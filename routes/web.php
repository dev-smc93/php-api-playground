<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Swagger API 문서 (Scramble)
Route::redirect('/docs', '/docs/api')->name('docs');
