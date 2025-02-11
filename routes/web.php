<?php
use App\Http\Controllers\ProductController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () { 
    return view('welcome');
});

// ✅ Product Routes using Slug
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{slug}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{slug}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{slug}', [ProductController::class, 'destroy'])->name('products.destroy');