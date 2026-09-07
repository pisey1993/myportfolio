<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();

// Vercel's serverless filesystem is read-only outside of /tmp. Redirect
// Laravel's writable storage paths there and seed a writable copy of the
// SQLite database on cold start so the app doesn't crash on boot. Writes
// (admin edits, uploads, sessions) still won't persist across invocations.
if (getenv('VERCEL')) {
    $tmpStorage = '/tmp/storage';

    foreach (['app/public', 'framework/cache/data', 'framework/sessions', 'framework/testing', 'framework/views', 'logs'] as $dir) {
        if (! is_dir("{$tmpStorage}/{$dir}")) {
            mkdir("{$tmpStorage}/{$dir}", 0775, true);
        }
    }

    $app->useStoragePath($tmpStorage);

    $sqliteSource = dirname(__DIR__).'/database/database.sqlite';
    $sqliteCopy = '/tmp/database.sqlite';
    if (! file_exists($sqliteCopy) && file_exists($sqliteSource)) {
        copy($sqliteSource, $sqliteCopy);
    }
}

return $app;
