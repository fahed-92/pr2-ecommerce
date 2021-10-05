<?php

use Illuminate\Support\Facades\Auth;
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


route::get('sendSms//','HomeController@sendSms');

Route::get('/', 'HomeController@home');

Auth::routes();
Route::group(['namespace' => 'Site'], function () {
    Route::get('productByCategory/{id}', 'HomeSiteController@productByCategory');
});

//Route::get('/home', 'HomeCo
//Route::get('/send-mails', 'HomeController@sendMails');



######################tasks#############


Route::get('offers','Homecontroller@createOffer');
Route::post('offers','Homecontroller@saveOffer')->name('save.users');
Route::group(['namespace' => 'Site'/*, 'middleware' => 'guest'*/], function () {
    //guest  user
//    Route::get('fat', 'PaymentController@fatoorah');
//    route::get('/', 'HomeController@home')->name('home')->middleware('VerifiedUser');
    route::get('category/{slug}', 'CategoryController@productsBySlug')->name('category');
    route::get('product/{slug}', 'ProductController@productsBySlug')->name('product.details');

});

Route::get('video','Homecontroller@getVideo');
Route::post('video','Homecontroller@upload')->name('upload.video');




