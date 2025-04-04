<?php

use App\Http\Controllers\AboutusController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientSubscriptionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashbaordController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\VisitController;
use App\Livewire\CategoryComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services/{service}', [HomeController::class, 'service_show'])->name('service_show');
Route::post('/appointments/store', [HomeController::class, 'appointmentstore'])->name('appointment.store');
Route::post('/purchase-package', [HomeController::class, 'purchase'])->name('package.purchase');
Route::post('/enroll', [HomeController::class, 'enroll'])->name('course.enroll');
Route::get('/course/{course}', [HomeController::class, 'single_course'])->name('single_course');
Route::get('products', [HomeController::class, 'products'])->name('products');
Route::get('services', [HomeController::class, 'services'])->name('services');
Route::get('contact-us', [HomeController::class, 'contact_us'])->name('contact-us');

 
Route::get('product.details/{id}', [HomeController::class, 'single_products'])->name('product.details');
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::get('/order-success', function () {
    return view('frontend.order_success');
})->name('orders.success');
Route::post('/contact', [HomeController::class, 'store_contact'])->name('contact.store');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('cart_remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/login', [DashbaordController::class, 'login'])->name('login');
Route::post('/login', [DashbaordController::class, 'post_login'])->name('post_login');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {
    Route::get('/', [DashbaordController::class, 'dashboard'])->name('dashboard');
    Route::get('logout', [DashbaordController::class, 'logout'])->name('logout');
    Route::resource('users', UserController::class);

    Route::resource('packages', PackageController::class);
    Route::get('update_status_package', [PackageController::class, 'update_status_package'])->name('update_status_package');
    Route::resource('sliders', SliderController::class);
    Route::resource('galleries', GalleryController::class);
    Route::resource('partners', PartnerController::class);
    Route::resource('products', ProductController::class);
    Route::get('service_order', [HomeController::class, 'service_order'])->name('service_order');
    Route::get('packge_order',  [HomeController::class, 'packge_order'])->name('packge_order');

    Route::get('/cource_order/{order}', [HomeController::class, 'cource_order'])->name('cource_order');

    Route::get('pacgkeorders/{id}',  [HomeController::class, 'pacgkeorders'])->name('pacgkeorders.show');
    Route::get('show_notofication/{id}',[NotificationController::class, 'show'])->name('show_notofication');
    Route::delete('pacgkeorders_delete/{id}',  [HomeController::class, 'pacgkeorders_delete'])->name('pacgkeorders.delete');
    Route::delete('cource_order_delete/{id}',  [HomeController::class, 'cource_order_delete'])->name('cource_order.delete');

    Route::post('/clients/store-from-order', [ClientController::class, 'storeFromOrder'])->name('clients.storeFromOrder');
    Route::get('/orders/{order}/get-order-data', [ClientController::class, 'getOrderData'])->name('orders.get-data');
    Route::get('course_order',  [HomeController::class, 'course_order'])->name('courses_order');

    Route::get('/change_order_cource_status/{order}', [HomeController::class, 'updateStatus_course_order'])
     ->name('updateStatus_course_order');
    Route::get('contact_order',  [HomeController::class, 'contact_order'])->name('contact_order');
    Route::get('contact_show/{id}',  [HomeController::class, 'contact_order_edit'])->name('contact_order_edit');
    Route::delete('contact_delete/{id}',  [HomeController::class, 'contact_order_delete'])->name('contact_order_delete');
    Route::resource('services', ServiceController::class);
    Route::get('update_status_service', [ServiceController::class, 'update_status_service'])->name('update_status_service');
    Route::get('update_status_product', [ProductController::class, 'update_status_product'])->name('update_status_product');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index'); // عرض كل الطلبات
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('update_status_slider', [SliderController::class, 'update_status_slider'])->name('update_status_slider');
    Route::get('aboutus', [AboutusController::class, 'index'])->name('aboutus.index');
    Route::post('aboutus', [AboutusController::class, 'update'])->name('aboutus.update');
    Route::get('aboutus', [AboutusController::class, 'index'])->name('aboutus.index');
    Route::post('/check-phone', [ClientController::class, 'checkPhoneNumber'])->name('check.phone');
    Route::resource('clients', ClientController::class);
    Route::post('/clients/subscribe', [ClientSubscriptionController::class, 'store'])->name('clients.subscribe');
    Route::get('setting', [DashbaordController::class, 'setting'])->name('setting');
    Route::post('add_general', [DashbaordController::class, 'add_general'])->name('add_general');
    Route::get('edit_profile', [DashbaordController::class, 'edit_profile'])->name('edit_profile');
    Route::post('edit_profile', [DashbaordController::class, 'edit_profile_post'])->name('edit_profile_post');
    Route::resource('courses', CourseController::class);
    Route::get('/calender', [HomeController::class, 'calender'])->name('calender');
    Route::get('update_status_course', [CourseController::class, 'updateStatus'])->name('update_status_course');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/dashboard/events', [ReservationController::class, 'index'])->name('events.index');
    Route::post('/dashboard/events', [ReservationController::class, 'store'])->name('events.store');
    Route::get('/dashboard/events/{id}', [ReservationController::class, 'destroy'])->name('events.destroy');
    Route::resource('reservations', EventController::class);
    Route::get('/packages/{package}/calculate-end-date', [ClientController::class, 'calculateEndDate'])
     ->name('packages.calculate-end-date');
    Route::get('active_clients', [ClientController::class, 'getActiveClients'])->name('clients.active');
    Route::get('notactive_clients', [ClientController::class, 'getNotActiveSubscribers'])->name('clients.notactive');
    Route::get('/notifications', [NotificationController::class, 'getNotifications']);

     Route::post('/subscriptions', [ClientController::class, 'store_sub'])->name('subscriptions.store');
    Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');
    Route::get('update_status_reservation', [EventController::class, 'updateStatus'])->name('update_status_reservation');
    Route::get('social-media', [SocialMediaController::class, 'index'])->name('social_media');
    Route::post('social-media/save', [SocialMediaController::class, 'save'])->name('save_social_media');
});
