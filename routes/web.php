<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

// Rota de fallback para qualquer outra rota não encontrada
Route::fallback(function () {
    return redirect()->route('home');
});
