<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

// Shop / e-commerce controllers
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Admin controllers
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\OtpController;
/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

// You can keep this as welcome page or change later.
// If you want shop as home page, change this to ProductController@index.
Route::get('/', [ProductController::class, 'index'])->name('shop.index');


// Shop routes (catalog)
Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('shop.show');

// Cart routes
Route::get('/cart', [CartController::class,'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])
    ->name('cart.add');
Route::post('/cart/update', [CartController::class,'update'])->name('cart.update');
Route::post('/cart/clear', [CartController::class,'clear'])->name('cart.clear');


/*
|--------------------------------------------------------------------------
| Authenticated user routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::middleware(['auth', 'otp'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'form'])->name('checkout.form');
    Route::post('/checkout/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel/{order}', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

    Route::get('/my-orders', [OrderHistoryController::class, 'index'])
        ->name('orders.mine');
    



});



/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function() {
    Route::resource('products', AdminProduct::class);
    Route::resource('categories', AdminCategory::class);
    Route::get('orders', [AdminOrder::class,'index'])->name('orders.index');
    Route::patch('orders/{order}', [AdminOrder::class,'update'])->name('orders.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/otp', [OtpController::class, 'show'])->name('otp.show');
    Route::post('/otp', [OtpController::class, 'verify'])->name('otp.verify');
    Route::post('/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');
});

/*
|--------------------------------------------------------------------------
| Auth routes (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
