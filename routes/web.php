<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FernsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Checkout;
use App\Http\Controllers\PaulowniaController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\OrderPaymentController;
use App\Http\Controllers\Backend\BackendPageController;
use App\Http\Controllers\Backend\BackendUserController;
use App\Http\Controllers\Backend\PageGalleryController;
use App\Http\Controllers\Backend\BackendBlockController;
use App\Http\Controllers\Backend\BackendOrderController;
use App\Http\Controllers\Backend\BackendPlantController;
use App\Http\Controllers\Backend\MediaLibraryController;
use App\Http\Controllers\Backend\BackendProductController;
use App\Http\Controllers\Backend\ProductGalleryController;
use App\Http\Controllers\Backend\BackendVariationController;

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

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


// Route::get('/', 'HomeController@index')->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/get-in-touch', [ContactController::class, 'index'])->name('contact');
Route::post('/get-in-touch', [ContactController::class, 'store'])->name('contact.store');
// Route::middleware('throttle:1,1')->post('/contact', [ContactController::class, 'store'])->name('contact.store');
// Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/ferns', [FernsController::class, 'index'])->name('ferns');
Route::get('/paulownia', [PaulowniaController::class, 'index'])->name('paulownia');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');


// Route::prefix('admin')->group(function () {
//     Route::get('pages', 'Admin\PageController@index')->name('admin.pages');
// });


Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
});


Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [Checkout\ContactController::class, 'show'])->name('index');
    Route::post('/', [Checkout\ContactController::class, 'store'])->name('contact');
    Route::get('/delivery', [Checkout\DeliveryController::class, 'show'])->name('delivery');
    Route::post('/delivery', [Checkout\DeliveryController::class, 'store'])->name('deliverypost');
    Route::get('/card', [Checkout\CardPaymentController::class, 'show'])->name('card');
    Route::post('/card', [Checkout\CardPaymentController::class, 'store'])->name('processcard');
    Route::get('/directdeposit', Checkout\DirectDepositController::class)->name('directdeposit');
    Route::get('/thankyou', Checkout\ThankYouController::class)->name('thankyou');
});


// Backend dashboard
// Fortify handles login (/login), logout and password reset. Keep the old
// admin login address working for bookmarks.
Route::redirect('/backend/login', '/login')->name('backend.login');

Route::prefix('backend')->middleware('App\Http\Middleware\AdminAccessMiddleware')->group(function () {
    Route::get('/', [BackendController::class, 'index'])->name('backend.index');

    Route::resource('/blocks', BackendBlockController::class, ['as' => 'backend', 'only' => ['create','destroy','edit','show','store','update']]);

    Route::resource('/orders', BackendOrderController::class, ['as' => 'backend', 'only' => ['index', 'edit','update', 'destroy']]);

    Route::get('/orders/{order}/sendshippedemail', [BackendOrderController::class, 'showOrderShippedEmail'])->name('backend.orders.sendshippedemail');
    Route::post('/orders/{order}/sendshippedemail', [BackendOrderController::class, 'sendOrderShippedEmail']);
    Route::get('/orders/{order}/delete', [BackendOrderController::class, 'destroy'])->name('backend.orders.delete');
    Route::post('/orders/{order}/payment/paid', [OrderPaymentController::class, 'markPaid'])->name('backend.orders.payment.paid');
    Route::post('/orders/{order}/payment/release', [OrderPaymentController::class, 'release'])->name('backend.orders.payment.release');
    Route::get('/medialibary/{mediaId}/delete', [ MediaLibraryController::class, 'delete']);

    Route::resource('/pages', BackendPageController::class, ['as' => 'backend']);
    Route::get('/pages/{id}/gallery',[ PageGalleryController::class, 'create'])->name('backend.pagegallery.create');
    Route::post('/pages/{id}/gallery',[ PageGalleryController::class, 'store']);
    Route::get('/pages/{page}/gallery/{id}',[ PageGalleryController::class, 'destroy']);

    Route::resource('/plants', BackendPlantController::class, ['as' => 'backend']);

    Route::resource('/products', BackendProductController::class, ['as' => 'backend']);

    Route::get('/products/{id}/gallery',[ ProductGalleryController::class, 'create'])->name('backend.productgallery.create');
    Route::post('/products/{id}/gallery',[ ProductGalleryController::class, 'store']);
    Route::get('/products/{product}/gallery/{id}',[ ProductGalleryController::class, 'destroy']);

    Route::get('/shop/toggle', function () {
        $option = (option('shop')) ? 0 : 1 ;
        option(['shop' => $option ]);
        return back();
    })->name('backend.shop.toggle');

    Route::get('/variations/create/{product}', [BackendVariationController::class, 'create'])->name('backend.variations.create');
    Route::post('/variations', [BackendVariationController::class, 'store'])->name('backend.variations.store');
    Route::get('/variations/{variation}/edit', [BackendVariationController::class, 'edit'])->name('backend.variations.edit');
    Route::put('/variations/{variation}/update', [BackendVariationController::class, 'update'])->name('backend.variations.update');
    Route::delete('/variations/{variation}', [BackendVariationController::class, 'destroy'])->name('backend.variations.destroy');


    Route::get('/users', [BackendUserController::class, 'index'])->name('backend.users');
});



Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});



Route::middleware('App\Http\Middleware\AdminAccessMiddleware')->group(function () {

   //Clear configurations:
    Route::get('/config-clear', function () {
        $status = Artisan::call('config:clear');
        return '<h1>Configurations cleared</h1>';
    });

    //Clear cache:
    Route::get('/cache-clear', function () {
        $status = Artisan::call('cache:clear');
        return '<h1>Cache cleared</h1>';
    });

    //Clear configuration cache:
    Route::get('/config-cache', function () {
        $status = Artisan::call('config:cache');
        return '<h1>Configurations cache cleared</h1>';
    });

    //Clear routes:
    Route::get('/route-clear', function () {
        $status = Artisan::call('route:clear');
        return '<h1>Routes cleared</h1>';
    });


    Route::get('/media-regenerate', function () {
        $status = Artisan::call('media-library:regenerate --only-missing');
        return '<h1>Missing Media Regenerated</h1>';
    });

    Route::get('/media-regenerate-all', function () {
        $status = Artisan::call('media-library:regenerate');
        return '<h1>All Media Regenerated</h1>';
    });

    Route::get('/link', function () {
        $status = Artisan::call('storage:link');
        return '<h1>Symlinks created</h1>';
    });

    // Route::get('/vendor/publish', function () {
    //     $status = Artisan::call('vendor:publish --provider="Appstract\Options\OptionsServiceProvider"');
    //     return '<h1>Vendor published </h1>';
    // });


});
