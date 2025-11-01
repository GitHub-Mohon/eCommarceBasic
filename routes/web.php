<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\FrontEnd\HomeController;
use App\Http\Controllers\FrontEnd\SlugProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });




Route::group(['prefix'=>'admin'],function(){

    //Guest
    Route::get('',[AuthController::class,'login'])->name('login.admin');
    Route::post('/auth',[AuthController::class,'adminAuth'])->name('auth.admin');
    Route::get('/register',[AuthController::class,'adminRegister'])->name('register.admin');


    // Authenticate

    Route::group(['middleware' => 'admin'],function(){

        Route::get('/logout',[AuthController::class,'logout'])->name('logout.admin');
        Route::get('/dashboard',[AuthController::class,'dashboard'])->name('admin.dashboard');
        Route::get('/read',[AuthController::class,'read'])->name('admin.read');
        Route::get('/create',[AuthController::class,'index'])->name('admin.create');
        Route::post('/store',[AuthController::class,'store'])->name('admin.store');
        Route::get('/delete/{id}',[AuthController::class,'delete'])->name('admin.delete');
        Route::get('/edit/{id}',[AuthController::class,'edit'])->name('admin.edit');
        Route::post('/update/{id}',[AuthController::class,'update'])->name('admin.update');

        // Category

        Route::get('category/create',[CategoryController::class,'index'])->name('category.create');
        Route::post('category/store',[CategoryController::class,'store'])->name('category.store');
        Route::get('category/read',[CategoryController::class,'read'])->name('category.read');
        Route::get('category/delete/{id}',[CategoryController::class,'delete'])->name('category.delete');
        Route::get('category/edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
        Route::post('category/update/{id}',[CategoryController::class,'update'])->name('category.update');

        // Sub Category

        Route::get('sub-category/create',[SubCategoryController::class,'index'])->name('sub-category.create');
        Route::post('sub-category/store',[SubCategoryController::class,'store'])->name('sub-category.store');
        Route::get('sub-category/read',[SubCategoryController::class,'read'])->name('sub-category.read');
        Route::get('sub-category/delete/{id}',[SubCategoryController::class,'delete'])->name('sub-category.delete');
        Route::get('sub-category/edit/{id}',[SubCategoryController::class,'edit'])->name('sub-category.edit');
        Route::post('sub-category/update/{id}',[SubCategoryController::class,'update'])->name('sub-category.update');


        // Brand

        Route::get('brand/create',[BrandController::class,'index'])->name('brand.create');
        Route::post('brand/store',[BrandController::class,'store'])->name('brand.store');
        Route::get('brand/read',[BrandController::class,'read'])->name('brand.read');
        Route::get('brand/delete/{id}',[BrandController::class,'delete'])->name('brand.delete');
        Route::get('brand/edit/{id}',[BrandController::class,'edit'])->name('brand.edit');
        Route::post('brand/update/{id}',[BrandController::class,'update'])->name('brand.update');


        // Color

        Route::get('color/create',[ColorController::class,'index'])->name('color.create');
        Route::post('color/store',[ColorController::class,'store'])->name('color.store');
        Route::get('color/read',[ColorController::class,'read'])->name('color.read');
        Route::get('color/delete/{id}',[ColorController::class,'delete'])->name('color.delete');
        Route::get('color/edit/{id}',[ColorController::class,'edit'])->name('color.edit');
        Route::post('color/update/{id}',[ColorController::class,'update'])->name('color.update');


        // Product

        Route::get('product/create',[ProductController::class,'index'])->name('product.create');
        Route::post('product/store',[ProductController::class,'store'])->name('product.store');
        Route::get('product/read',[ProductController::class,'read'])->name('product.read');
        Route::get('product/delete/{id}',[ProductController::class,'delete'])->name('product.delete');
        Route::get('product/edit/{id}',[ProductController::class,'edit'])->name('product.edit');
        Route::post('product/update/{id}',[ProductController::class,'update'])->name('product.update');
        Route::get('product/findSubCategory',[ProductController::class,'findSubCategory'])->name('findSubCategory');
        Route::get('product/gallery/delete/{id}',[ProductController::class,'deleteImage'])->name('deleteImage');
        Route::post('product/gallery/imageSortable',[ProductController::class,'imageSortable'])->name('imageSortable');
    });
});


//FrontEnd


Route::get('/',[HomeController::class,'home'])->name('homePage');
Route::post('get_filter_product_ajax',[SlugProductController::class,'getFilterProductAjax'])->name('getFilterProductAjax');
Route::get('/category/{category}/{subcategory?}/ajax', [SlugProductController::class, 'getCategoryAjax'])->name('category.ajax');

Route::get('/{category?}/{subcategory?}',[SlugProductController::class,'getCategory'])->name('getCategory');





