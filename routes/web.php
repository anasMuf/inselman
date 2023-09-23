<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Supplier\SupplierController;
use App\Http\Controllers\ProductCategory\ProductCategoryController;

Route::get('/', [HomeController::class, 'main'])->name('home');
Route::prefix('/product')->group(function(){
    Route::get('/', [ProductController::class, 'main'])->name('product');
    Route::get('/getData', [ProductController::class, 'getData'])->name('getDataProduct');
    Route::get('/formContent', [ProductController::class, 'formContent'])->name('formContentProduct');
    Route::post('/save', [ProductController::class, 'save'])->name('saveProduct');
    Route::delete('/delete', [ProductController::class, 'delete'])->name('deleteProduct');
});

Route::prefix('/category')->group(function(){
    Route::get('/', [ProductCategoryController::class, 'main'])->name('product_category');
    Route::get('/getData', [ProductCategoryController::class, 'getData'])->name('getDataProductCategory');
    Route::get('/formContent', [ProductCategoryController::class, 'formContent'])->name('formContentProductCategory');
    Route::post('/save', [ProductCategoryController::class, 'save'])->name('saveProductCategory');
    Route::delete('/delete', [ProductCategoryController::class, 'delete'])->name('deleteProductCategory');
});

Route::prefix('/supplier')->group(function(){
    Route::get('/', [SupplierController::class, 'main'])->name('supplier');
    Route::get('/getData', [SupplierController::class, 'getData'])->name('getDataSupplier');
    Route::get('/formContent', [SupplierController::class, 'formContent'])->name('formContentSupplier');
    Route::post('/save', [SupplierController::class, 'save'])->name('saveSupplier');
    Route::delete('/delete', [SupplierController::class, 'delete'])->name('deleteSupplier');
});

Route::prefix('/customer')->group(function(){
    Route::get('/', [CustomerController::class, 'main'])->name('customer');
    Route::get('/getData', [CustomerController::class, 'getData'])->name('getDataCustomer');
    Route::get('/formContent', [CustomerController::class, 'formContent'])->name('formContentCustomer');
    Route::post('/save', [CustomerController::class, 'save'])->name('saveCustomer');
    Route::delete('/delete', [CustomerController::class, 'delete'])->name('deleteCustomer');
});

Route::prefix('/purchase')->group(function(){
    Route::get('/', [PurchaseController::class, 'main'])->name('purchase');
    Route::get('/getData', [PurchaseController::class, 'getData'])->name('getDataPurchase');
    Route::get('/formContent', [PurchaseController::class, 'formContent'])->name('formContentPurchase');
    Route::post('/hitungSubTotal', [PurchaseController::class, 'hitungSubTotal'])->name('hitungSubTotal');
    Route::post('/hitungTotal', [PurchaseController::class, 'hitungTotal'])->name('hitungTotal');
    Route::post('/save', [PurchaseController::class, 'save'])->name('savePurchase');
    Route::delete('/delete', [PurchaseController::class, 'delete'])->name('deletePurchase');
});
