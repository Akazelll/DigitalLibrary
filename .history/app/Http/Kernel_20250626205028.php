// app/Http/Kernel.php

protected $middlewareAliases = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    // ... middleware lain
    'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,

    // TAMBAHKAN BARIS INI
    'is.admin' => \App\Http\Middleware\IsAdmin::class,
];