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
use App\Models\Order;

// Home route
Route::get('/', [ProductController::class, 'home'])->name('home');

// Shop route
Route::get('/shop', [ProductController::class, 'userindex'])->name('shop');

// Static pages
Route::get('/story', function () {
    return view('userpage.story');
})->name('story');

Route::get('/contact', function () {
    return view('userpage.contact');
})->name('contact');

// Product routes
Route::get('/product/{id}', [ProductController::class, 'showDetails'])->name('product.show');
Route::post('/products/{product}/comment', [CommentController::class, 'store'])->middleware('auth');

// Cart routes
Route::post('/cart/add/{id}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [ProductController::class, 'viewCart'])->name('cart.index');
Route::delete('/cart/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');

// Auth routes
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

// Authenticated user routes (e.g., profile)
Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', function () {
        return "hi";
    });
});

// Checkout & Order Routes (Managed by OrderManager)
Route::get('/checkout', [OrderManager::class, 'showCheckout'])->name('checkout.show');
Route::post('/checkout', [OrderManager::class, 'checkoutPost'])->name('checkout.post');

// Khalti Payment Routes (Handled by OrderManager)
Route::post('/payment/verify', [OrderManager::class, 'verifyPayment'])->name('payment.verify');
Route::get('payment/success', [OrderManager::class, 'paymentSuccess'])->name('payment.success');

Route::get('/orders', [OrderManager::class, 'index'])->name('orders.index');
//for receipt
Route::get('/orders/receipt/{order}', [OrderManager::class, 'viewReceipt'])->name('orders.receipt');




// Admin routes - These are protected by both 'auth' and 'admin' middleware
// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin dashboard
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.index');

    // Orders route for Admin
    Route::get('/admin/orders/history', [AdminController::class, 'showOrders'])->name('admin.orders.history');

    // Product management (CRUD)
    Route::resource('admin/products', ProductController::class, ['as' => 'admin']);
});
    


// Vendor routes - These are protected by both 'auth' and 'vendor' middleware
Route::middleware(['auth', 'vendor'])->group(function () {
    // Vendor Dashboard
    Route::get('/vendor/dashboard', [VendorController::class, 'dashboard'])->name('vendor.dashboard');

    // Vendor's Product CRUD (Using Resource Controller)
    Route::resource('/vendor/products', VendorProductController::class)->names('vendor.products');

    // Order history
    Route::get('/vendor/orders/list', [VendorController::class, 'vendorOrders'])->name('vendor.orders.list'); // Updated to vendorOrders
    Route::get('/vendor/orders/{order}', [VendorController::class, 'showOrder'])->name('vendor.orders.show'); // Added to view individual order details

});
 //user dashboard

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/orders', [UserDashboardController::class, 'orders'])->name('user.orders');
});


