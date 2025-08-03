<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Route;
use App\Middleware\AuthMiddleware;
use App\Core\BaseController;
 
//Front Route Yapısı 
Route::add('/', 'Front\HomeController@index');
Route::add('abouts', 'Front\AboutsController@index'); // Yeni abouts rotası
Route::add('category/([a-zA-Z0-9_-]+)', 'Front\CategoryController@show');
Route::add('contact', 'Front\ContactController@index');
Route::add('contact/submit-contact', 'Front\ContactController@sendContactForm'); // Yeni route
Route::add('blog', 'Front\BlogController@index'); // Blog listesi için yeni route
Route::add('blog/([a-zA-Z0-9_-]+)', 'Front\BlogController@detail'); // Blog detayı için yeni route
Route::add('product/([a-zA-Z0-9_-]+)', 'Front\ProductController@detail');
Route::add('search', 'Front\SearchController@index'); // Yeni arama rotası
Route::add('page/([a-zA-Z0-9_-]+)', 'Front\PageController@show'); // Yeni page rotası

//Front Auth Route Yapısı
Route::add('order', 'Front\OrderController@index')->middleware(AuthMiddleware::class);
Route::add('order/detail/([0-9]+)', 'Front\OrderController@detail')->middleware(AuthMiddleware::class);
Route::add('customer', 'Front\CustomerController@index')->middleware(AuthMiddleware::class);
Route::add('uth/updatePasswordFront', 'Front\AuthController@updatePasswordFront')->middleware(AuthMiddleware::class);

//Cart Route Yapısı
Route::add('cart', 'Front\CartController@index')->middleware(AuthMiddleware::class);
Route::add('cart/add', 'Front\CartController@addToCart')->middleware(AuthMiddleware::class);
Route::add('cart/remove', 'Front\CartController@removeFromCart')->middleware(AuthMiddleware::class);
Route::add('cart/increaseQuantity', 'Front\CartController@increaseQuantity')->middleware(AuthMiddleware::class);
Route::add('cart/decreaseQuantity', 'Front\CartController@decreaseQuantity')->middleware(AuthMiddleware::class);

//Buy Route Yapısı
Route::add('buy', 'Front\BuyController@index')->middleware(AuthMiddleware::class);
Route::add('buy/submit', 'Front\BuyController@submit')->middleware(AuthMiddleware::class);
Route::add('buy/callback', 'Front\BuyController@callback'); // Yeni callback rotası
Route::add('buy/testOrderSuccess', 'Front\BuyController@testOrderSuccess'); // Geçici test rotası

//Auth Route Yapısı
Route::add('login', 'Front\AuthController@login');
Route::add('login/submit', 'Front\AuthController@loginSubmit');
Route::add('register', 'Front\AuthController@register');
Route::add('register/submit', 'Front\AuthController@registerSubmit');
Route::add('logout', 'Front\AuthController@logout');
Route::add('admin', 'Admin\DashboardController@index');

//Settings Route Yapısı
Route::add('admin/settings', 'Admin\SettingsController@index');
Route::add('admin/settings/updateSetting', 'Admin\SettingsController@updateSetting');

//About Route Yapısı
Route::add('admin/about', 'Admin\AboutController@edit');
Route::add('admin/about/update', 'Admin\AboutController@update');

//Profile Route Yapısı
Route::add('admin/profile', 'Front\AuthController@profile');
Route::add('admin/profile/updatePassword', 'Front\AuthController@updatePassword');

//Slider Route Yapısı
Route::add('admin/slider', 'Admin\SliderController@index');
Route::add('admin/slider/create', 'Admin\SliderController@create');
Route::add('admin/slider/store', 'Admin\SliderController@store');
Route::add('admin/slider/edit', 'Admin\SliderController@edit');
Route::add('admin/slider/edit/([0-9]+)', 'Admin\SliderController@edit');
Route::add('admin/slider/update/([0-9]+)', 'Admin\SliderController@update');
Route::add('admin/slider/delete/([0-9]+)', 'Admin\SliderController@delete');

// Blog Route Yapısı 
Route::add('admin/blogs', 'Admin\BlogController@index');
Route::add('admin/blogs/create', 'Admin\BlogController@create');
Route::add('admin/blogs/store', 'Admin\BlogController@store');
Route::add('admin/blogs/edit/([0-9]+)', 'Admin\BlogController@edit');
Route::add('admin/blogs/update/([0-9]+)', 'Admin\BlogController@update');
Route::add('admin/blogs/delete/([0-9]+)', 'Admin\BlogController@delete');

// Kategori Route Yapısı
Route::add('admin/categories', 'Admin\CategoryController@index');
Route::add('admin/categories/create', 'Admin\CategoryController@create');
Route::add('admin/categories/store', 'Admin\CategoryController@store');
Route::add('admin/categories/edit/([0-9]+)', 'Admin\CategoryController@edit');
Route::add('admin/categories/update/([0-9]+)', 'Admin\CategoryController@update');
Route::add('admin/categories/delete/([0-9]+)', 'Admin\CategoryController@delete');

// Product Route Yapısı
Route::add('admin/products', 'Admin\ProductController@index');
Route::add('admin/products/create', 'Admin\ProductController@create');
Route::add('admin/products/store', 'Admin\ProductController@store');
Route::add('admin/products/edit/([0-9]+)', 'Admin\ProductController@edit');
Route::add('admin/products/update/([0-9]+)', 'Admin\ProductController@update');
Route::add('admin/products/delete/([0-9]+)', 'Admin\ProductController@delete');
Route::add('admin/products/gallery/([0-9]+)', 'Admin\ProductController@gallery');
Route::add('admin/products/gallery/add', 'Admin\ProductController@addGalleryImage');
Route::add('admin/products/gallery/delete', 'Admin\ProductController@deleteGalleryImage');

// Deal Route Yapısı
Route::add('admin/deal', 'Admin\DealController@index');
Route::add('admin/deal/create', 'Admin\DealController@create');
Route::add('admin/deal/store', 'Admin\DealController@store');
Route::add('admin/deal/edit/([0-9]+)', 'Admin\DealController@edit');
Route::add('admin/deal/update/([0-9]+)', 'Admin\DealController@update');
Route::add('admin/deal/delete/([0-9]+)', 'Admin\DealController@delete');

// Order Route Yapısı
Route::add('admin/orders', 'Admin\OrderController@index');
Route::add('admin/orders/detail/([0-9]+)', 'Admin\OrderController@detail');
Route::add('admin/orders/updateStatus/([0-9]+)', 'Admin\OrderController@updateStatus'); // Yeni route

// Page Route Yapısı
Route::add('admin/pages', 'Admin\PageController@index');
Route::add('admin/pages/create', 'Admin\PageController@create');
Route::add('admin/pages/store', 'Admin\PageController@store');
Route::add('admin/pages/edit/([0-9]+)', 'Admin\PageController@edit');
Route::add('admin/pages/update/([0-9]+)', 'Admin\PageController@update');
Route::add('admin/pages/delete/([0-9]+)', 'Admin\PageController@delete');

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
if ($uri === '') {
    $uri = '/';
}

try {
    Route::dispatch($uri);
} catch (Exception $e) {
    (new BaseController())->render('front/errors/404', [], 404);
}