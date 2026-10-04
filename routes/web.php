<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Route::redirect('/', '/products');

Route::get('/products', [
    ProductController::class,
    'index'
])->name('products.index');

Route::post('/products', [
    ProductController::class,
    'store'
])->name('products.store');


Route::get("getData", [ProductController::class, "dbGet"]);
Route::get("postData", [ProductController::class, "dbPostData"]);
Route::get("updateData", [ProductController::class, "updateDate"]);
Route::get("deleteData/{id}", [ProductController::class, "deleteData"]);


Route::get("sellerData", [ProductController::class, "getData"]);
