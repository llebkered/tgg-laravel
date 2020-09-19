<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FernsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaulowniaController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\BackendPageController;
use App\Http\Controllers\Backend\BackendUserController;
use App\Http\Controllers\Backend\BackendOrderController;
use App\Http\Controllers\Backend\BackendPlantController;
use App\Http\Controllers\Backend\BackendProductController;



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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


// Route::get('/', 'HomeController@index')->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/ferns', [FernsController::class, 'index'])->name('ferns');
Route::get('/paulownia', [PaulowniaController::class, 'index'])->name('paulownia');
Route::get('/products', [ProductController::class, 'index'])->name('products');



// Route::prefix('admin')->group(function () {
//     Route::get('pages', 'Admin\PageController@index')->name('admin.pages');
// });


Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
});


Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/', [CheckoutController::class, 'contact'])->name('checkout.contact');
    Route::get('/delivery', [CheckoutController::class, 'delivery'])->name('checkout.delivery');
    Route::post('/delivery', [CheckoutController::class, 'deliverypost'])->name('checkout.deliverypost');
    Route::get('/card', [CheckoutController::class, 'card'])->name('checkout.card');
    Route::post('/card', [CheckoutController::class, 'processcard'])->name('checkout.processcard');
    Route::get('/directdeposit', [CheckoutController::class, 'directdeposit'])->name('checkout.directdeposit');
    Route::get('/thankyou', [CheckoutController::class, 'thankyou'])->name('checkout.thankyou');
    Route::get('/test', [CheckoutController::class, 'test'])->name('checkout.test');
});




// Backend dashboard
// middleware('App\Http\Middleware\AdminAccessMiddleware') ['auth:sanctum', 'verified']
Route::prefix('backend')->middleware('App\Http\Middleware\AdminAccessMiddleware')->group(function () {
    Route::get('/', [BackendController::class, 'index'])->name('backend.index');
    Route::get('/orders', [BackendOrderController::class, 'index'])->name('backend.orders');
    Route::get('/pages', [BackendPageController::class, 'index'])->name('backend.pages');
    Route::get('/plants', [BackendPlantController::class, 'index'])->name('backend.plants');
    Route::get('/products', [BackendProductController::class, 'index'])->name('backend.products');
    Route::get('/users', [BackendUserController::class, 'index'])->name('backend.users');
});




// Route::get('/clear', function() {
//     Artisan::call('cache:clear');s
//     // Artisan::call('route:clear');
//     // Artisan::call('config:clear');
//     // Artisan::call('view:clear');
//     return "All is cleared";
// });



//Clear configurations:
Route::get('/config-clear', function() {
    $status = Artisan::call('config:clear');
    return '<h1>Configurations cleared</h1>';
});

//Clear cache:
Route::get('/cache-clear', function() {
    $status = Artisan::call('cache:clear');
    return '<h1>Cache cleared</h1>';
});

//Clear configuration cache:
Route::get('/config-cache', function() {
    $status = Artisan::call('config:Cache');
    return '<h1>Configurations cache cleared</h1>';
});

Route::get('/link', function() {
    $status = Artisan::call('storage:link');
    return '<h1>Symlinks created</h1>';
});
