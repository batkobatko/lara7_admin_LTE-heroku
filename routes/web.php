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

/*Route::get('/', function () {
    return view('welcome');
});*/

use App\Category;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->namespace('Admin')->group(function(){

	//All the admins routs here
	Route::match(['get','post'], '/', 'AdminController@login');
  
	Route::group(['middleware'=>['admin']], function(){

	    Route::get('dashboard','AdminController@dashboard');
	    Route::get('settings','AdminController@settings');
	    Route::get('logout','AdminController@logout');
	    Route::post('check-current-pwd','AdminController@chkCurrentPassword');
	 	Route::post('update-current-pwd','AdminController@updateCurrentPassword');
	 	Route::match(['get', 'post'], 'update-admin-details', 'AdminController@updateAdminDetails');

	 	//Sections
	 	Route::get('sections', 'SectionController@sections');
	 	Route::post('update-section-status', 'SectionController@updateSectionStatus');

	 	//Brands
	 	Route::get('brands','BrandController@brands');
	 	Route::post('update-brand-status', 'BrandController@updateBrandStatus');
	 	Route::match(['get', 'post'],'add-edit-brand/{id?}','BrandController@addEditBrand');
	 	Route::get('delete-brand/{id}','BrandController@deleteBrand');

	 	//categories
	 	Route::get('categories','CategoryController@categories');
	 	Route::post('update-category-status','CategoryController@updateCategoryStatus');
	 	Route::match(['get', 'post'],'add-edit-category/{id?}','CategoryController@addEditCategory');
	 	Route::post('append-categories-level', 'CategoryController@appendCategoryLevel');
	 	Route::get('delete-category-image/{id}', 'CategoryController@deleteCategoryImage');
	 	Route::get('delete-category/{id}','CategoryController@deleteCategory');

	 	//products route
	 	Route::get('products','ProductsController@products');
	 	Route::post('update-product-status','ProductsController@updateProductStatus');
	 	Route::get('delete-product/{id}','ProductsController@deleteProduct');
	 	Route::match(['get','post'],'add-edit-product/{id?}','ProductsController@addEditProduct');
	 	Route::get('delete-product-image/{id}', 'ProductsController@deleteProductImage');
	 	Route::get('delete-product-video/{id}', 'ProductsController@deleteProductVideo');

	 	// Attributes
	 	Route::match(['get','post'],'add-attributes/{id}', 'ProductsController@addAttributes');
	 	Route::post('edit-attributes/{id}','ProductsController@editAttributes');
	 	Route::post('update-attribute-status','ProductsController@updateAttributeStatus');
	 	Route::get('delete-attribute/{id}','ProductsController@deleteAttribute');

	 	// Images
	 	Route::match(['get','post'],'add-images/{id}', 'ProductsController@addImages');
		Route::post('update-image-status','ProductsController@updateImageStatus');
	 	Route::get('delete-image/{id}','ProductsController@deleteImage');

	 	//Banners
	 	Route::get('banners', 'BannersController@banners');
	 	Route::match(['get','post'], 'add-edit-banner/{id?}','BannersController@addEditBanner');
	 	Route::post('update-banner-status', 'BannersController@updateBannerStatus');
	 	Route::get('delete-banner/{id}','BannersController@deleteBanner');

 	});
});

Route::namespace('Front')->group(function(){
	// Home Page Route
	Route::get('/','IndexController@index');
	// Listing/Categories Ruote
	//Route::get('/{url}','ProductsController@listing');
	
	//Get Category url
    $catUrls = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    //echo "<pre>"; print_r($catUrls); die;
    foreach ($catUrls as $url){
    	Route::get('/'. $url,'ProductsController@listing');
    }

	Route::get('/contact-us',function(){
		echo "test"; die;
	});
});