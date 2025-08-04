<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookScannerController extends Controller
{
    public function scan(Request $request)
    {
        // 1. Validasi gambar
        $request->validate([
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            // 2. Kirim gambar ke OCR.space API untuk membaca teks
            $ocrResponse = Http::withHeaders(['apikey' => config('services.ocr.api_key')])
                ->attach('file', file_get_contents($request->file('cover_image')), 'cover.jpg')
                ->post('https://api.ocr.space/parse/image', ['OCREngine' => 2]);

            if ($ocrResponse->failed() || $ocrResponse->json()['IsErroredOnProcessing']) {
                return response()->json(['message' => 'Gagal memindai gambar.'], 500);
            }

            $detectedText = $ocrResponse->json()['ParsedResults'][0]['ParsedText'] ?? '';
            if (empty($detectedText)) {
                return response()->json(['message' => 'Tidak ada teks yang terdeteksi pada gambar.'], 422);
            }

            // 3. Coba cari ISBN dari teks yang terdeteksi
            preg_match('/(?:ISBN[-:]?\s*)?(?:\d[- ]*){9}[\dXx]|\d{13}/', $detectedText, $matches);
            $isbn = $matches[0] ?? null;

            $bookInfo = null;

            // 4. PRIORITAS 1: Cari di Open Library menggunakan ISBN (jika ditemukan)
            if ($isbn) {
                $cleanIsbn = str_replace(['-', ' '], '', $isbn);
                $isbnResponse = Http::get('https://openlibrary.org/api/books', [
                    'bibkeys' => 'ISBN:' . $cleanIsbn,
                    'format' => 'json',
                    'jscmd' => 'data'
                ]);

                if ($isbnResponse->successful() && !empty($isbnResponse->json())) {
                    $bookData = $isbnResponse->json()['ISBN:' . $cleanIsbn] ?? null;
                    if ($bookData) {
                        $bookInfo = $bookData;
                    }
                }
            }

            // 5. PRIORITAS 2 (FALLBACK): Jika pencarian ISBN gagal, cari menggunakan semua teks
            if (!$bookInfo) {
                $searchResponse = Http::get('https://openlibrary.org/search.json', [
                    'q' => $detectedText,
                    'limit' => 1
                ]);
                if ($searchResponse->successful() && !empty($searchResponse->json()['docs'])) {
                    $bookInfo = $searchResponse->json()['docs'][0];
                }
            }

            if (!$bookInfo) {
                return response()->json(['message' => 'Buku tidak ditemukan di database Open Library.'], 404);
            }

            // 6. Format data yang ditemukan dan kirim kembali
            $formattedData = [
                'judul_buku' => $bookInfo['title'] ?? '',
                'penerbit' => $bookInfo['publishers'][0]['name'] ?? ($bookInfo['publisher'][0] ?? ''),
                'tahun_terbit' => $bookInfo['publish_date'] ?? ($bookInfo['first_publish_year'] ?? ''),
                'jml_halaman' => $bookInfo['number_of_pages'] ?? ($bookInfo['number_of_pages_median'] ?? 0),
            ];

            return response()->json($formattedData);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan server: ' . $e->getMessage()], 500);
        }
    }
}
