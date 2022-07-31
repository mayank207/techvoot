<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user-logout', 'HomeController@logout')->name('user.logout');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// products routes
Route::get('products',[App\Http\Controllers\ProductController::class,'index'])->name('products.index');
Route::get('brands',[App\Http\Controllers\BrandController::class,'index'])->name('brands.index');
Route::post('product/update', [App\Http\Controllers\ProductController::class,'update'])->name('products.update');
Route::post('products/store', [App\Http\Controllers\ProductController::class,'store'])->name('products.store');
Route::get('product/edit/{id?}', [App\Http\Controllers\ProductController::class,'edit'])->name('products.edit');
Route::post('product/delete', [App\Http\Controllers\ProductController::class,'destroy'])->name('products.delete');

//product media routes
Route::get('product/media',[App\Http\Controllers\ProductController::class,'productMedia'])->name('product.media');
Route::get('product/media/delete',[App\Http\Controllers\ProductController::class,'productMediaDelete'])->name('products.delete_media');
Route::post('product/upload-media', [App\Http\Controllers\ProductController::class,'uploadProductMedia'])->name('product.upload_media');

//Admin Route's
Route::group(['middleware' => ['is_admin']], function () {
// brand routes
Route::get('brand/edit/{id?}', [App\Http\Controllers\BrandController::class,'edit'])->name('brands.edit');
Route::post('brand/delete', [App\Http\Controllers\BrandController::class,'destroy'])->name('brands.delete');
Route::post('brands/store', [App\Http\Controllers\BrandController::class,'store'])->name('brands.store');
Route::post('brand/update', [App\Http\Controllers\BrandController::class,'update'])->name('brands.update');

// users routes
Route::get('users', [App\Http\Controllers\UserController::class,'index'])->name('users.index');
Route::post('users/email_exists',[App\Http\Controllers\UserController::class,'isEmailExists'])->name('user.email_exists');
Route::get('userslists', [App\Http\Controllers\UserController::class,'lists'])->name('users.lists');
Route::get('users/create', [App\Http\Controllers\UserController::class,'create'])->name('users.create');
Route::post('users/store', [App\Http\Controllers\UserController::class,'store'])->name('users.store');
Route::get('users/edit/{id?}', [App\Http\Controllers\UserController::class,'edit'])->name('users.edit');
Route::post('users/update', [App\Http\Controllers\UserController::class,'update'])->name('users.update');
Route::get('users/delete/{id?}', [App\Http\Controllers\UserController::class,'destroy'])->name('users.delete');

});
// End admins routes
