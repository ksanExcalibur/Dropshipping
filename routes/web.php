<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderManager;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorProductController;
use App\Http\Controllers\UserDashboardController;

use Illuminate\Support\Facades\Password;

Auth::routes();

// Home route
Route::get('/', [ProductController::class, 'home'])->name('home');

// Shop route
Route::get('/shop', [ProductController::class, 'userindex'])->name('shop');
Route::get('/shop/search', [ProductController::class, 'userindex'])->name('shop.search');

// Static pages
Route::get('/story', fn() => view('userpage.story'))->name('story');
Route::get('/contact', fn() => view('userpage.contact'))->name('contact');

// Product routes
Route::get('/product/{id}', [ProductController::class, 'showDetails'])->name('product.show');
Route::post('/products/{product}/comment', [CommentController::class, 'store'])->middleware('auth');
Route::delete('/comments/{comment}/delete', [CommentController::class, 'destroy'])->middleware('auth');


// Cart routes
Route::post('/cart/add/{id}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [ProductController::class, 'viewCart'])->name('cart.index');
Route::get('/cart/view', [ProductController::class, 'viewCart'])->name('cart.view');
Route::delete('/cart/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');

// Auth routes
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::post('/logout', [AuthManager::class, 'logout'])->name('logout');



Route::get('/forgot-password', [AuthManager::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthManager::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [AuthManager::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthManager::class, 'resetPassword'])->name('password.update');

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

   
    
    // Cart & Checkout
    Route::get('/checkout', [OrderManager::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout', [OrderManager::class, 'checkoutPost'])->name('checkout.post');

    // Order Routes
    Route::get('/orders', [OrderManager::class, 'index'])->name('orders.index');
    Route::get('/orders/receipt/{order}', [OrderManager::class, 'viewReceipt'])->name('orders.receipt');

    // Payment
    Route::post('/payment/verify', [OrderManager::class, 'verifyPayment'])->name('payment.verify');
    Route::get('/payment/success', [OrderManager::class, 'paymentSuccess'])->name('payment.success');

    Route::post('order/{order}/cancel', [OrderManager::class, 'cancelOrderByUser'])->name('order.cancel');


// Chat Routes




    // Profile edit (alternate route)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit.alt');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/orders/history', [AdminController::class, 'showOrders'])->name('admin.orders.history');

// Vendor Management Routes
Route::get('/admin/vendors/{vendor}/edit', [AdminController::class, 'editVendor'])->name('admin.vendors.edit');
Route::put('/admin/vendors/{vendor}', [AdminController::class, 'updateVendor'])->name('admin.vendors.update');
Route::delete('/admin/vendors/{vendor}', [AdminController::class, 'destroyVendor'])->name('admin.vendors.destroy');

// User Management Routes
Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::resource('admin/products', ProductController::class, ['as' => 'admin']);
});

Route::middleware(['auth', 'vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'dashboard'])->name('vendor.dashboard');
    Route::resource('/vendor/products', VendorProductController::class)->names('vendor.products');
    Route::get('/vendor/orders/list', [VendorController::class, 'vendorOrders'])->name('vendor.orders.list');
    Route::get('/vendor/orders/{order}', [VendorController::class, 'showOrder'])->name('vendor.orders.show');
    Route::post('/vendor/orders/confirm/{orderId}', [OrderManager::class, 'confirmOrderByVendor'])->name('vendor.orders.confirm');
    Route::post('/vendor/orders/{orderId}/cancel', [OrderManager::class, 'cancelOrderByVendor'])->name('vendor.orders.cancel');
});


Route::post('/orders/{orderId}/cancel', [OrderManager::class, 'cancelOrderByUser'])->name('order.cancel');

// User dashboard
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/orders', [UserDashboardController::class, 'orders'])->name('user.orders');
});




