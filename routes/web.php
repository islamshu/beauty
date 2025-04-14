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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\SubscriptionPaymentController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;

// Routes accessible without authentication
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [DashbaordController::class, 'login'])->name('login');
Route::post('/login', [DashbaordController::class, 'post_login'])->name('post_login');

// Frontend routes
Route::prefix('frontend')->group(function () {
    Route::get('/services/{service}', [HomeController::class, 'service_show'])->name('service_show');
    Route::post('/appointments/store', [HomeController::class, 'appointmentstore'])->name('appointment.store');
    Route::post('/purchase-package', [HomeController::class, 'purchase'])->name('package.purchase');
    Route::post('/enroll', [HomeController::class, 'enroll'])->name('course.enroll');
    Route::get('/course/{course}', [HomeController::class, 'single_course'])->name('single_course');
    Route::get('/products', [HomeController::class, 'products'])->name('products');
    Route::get('/services', [HomeController::class, 'services'])->name('services');
    Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('contact-us');
    Route::get('/product.details/{id}', [HomeController::class, 'single_products'])->name('product.details');
    Route::post('/contact', [HomeController::class, 'store_contact'])->name('contact.store');
    Route::get('add_perm', [HomeController::class, 'add_perm']);

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart_remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/order-success', function () {
        return view('frontend.order_success');
    })->name('orders.success');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashbaordController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/logout', [DashbaordController::class, 'logout'])->name('logout');
    Route::get('/dashboard/edit_profile', [DashbaordController::class, 'edit_profile'])->name('edit_profile');
    Route::post('/dashboard/edit_profile', [DashbaordController::class, 'edit_profile_post'])->name('edit_profile_post');
    
    // Settings routes
    Route::middleware(['can:الإعدادات'])->group(function () {
        Route::get('/dashboard/setting', [DashbaordController::class, 'setting'])->name('setting');
        Route::post('/dashboard/add_general', [DashbaordController::class, 'add_general'])->name('add_general');
        Route::get('/dashboard/social-media', [SocialMediaController::class, 'index'])->name('social_media');
        Route::post('/dashboard/social-media/save', [SocialMediaController::class, 'save'])->name('save_social_media');
        Route::get('/dashboard/aboutus', [AboutusController::class, 'index'])->name('aboutus.index');
        Route::post('/dashboard/aboutus', [AboutusController::class, 'update'])->name('aboutus.update');
        
        // Resources with settings permission
        Route::resource('/dashboard/sliders', SliderController::class)->middleware('can:الإعدادات');
        Route::resource('/dashboard/galleries', GalleryController::class)->middleware('can:الإعدادات');
        Route::resource('/dashboard/partners', PartnerController::class)->middleware('can:الإعدادات');
        
        // Status updates
        Route::get('/dashboard/update_status_slider', [SliderController::class, 'update_status_slider'])->name('update_status_slider');
    });
    
    // Roles and permissions routes
    Route::middleware(['can:الادوار والاذونات'])->group(function () {
        Route::resource('/dashboard/roles', RoleController::class);
    });
    
    // Users routes
    Route::middleware(['can:الموظفين'])->group(function () {
        Route::resource('/dashboard/users', UserController::class);
    });
    
    // Packages routes
    Route::middleware(['can:الباقات'])->group(function () {
        Route::resource('/dashboard/packages', PackageController::class);
        Route::get('/dashboard/update_status_package', [PackageController::class, 'update_status_package'])->name('update_status_package');
    });
    
    // Categories and services routes
    Route::middleware(['can:التصنيفات والخدمات'])->group(function () {
        Route::get('/dashboard/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/dashboard/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/dashboard/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/dashboard/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        
        Route::resource('/dashboard/services', ServiceController::class);
        Route::get('/dashboard/update_status_service', [ServiceController::class, 'update_status_service'])->name('update_status_service');
    });
    
    // Courses routes
    Route::middleware(['can:الدورات'])->group(function () {
        Route::resource('/dashboard/courses', CourseController::class);
        Route::get('/dashboard/update_status_course', [CourseController::class, 'updateStatus'])->name('update_status_course');
    });
    
    // Clients routes
    Route::middleware(['can:العملاء'])->group(function () {
        Route::resource('/dashboard/clients', ClientController::class);
        Route::post('/dashboard/clients/subscribe', [ClientSubscriptionController::class, 'store'])->name('clients.subscribe');
        Route::post('/dashboard/clients/store-from-order', [ClientController::class, 'storeFromOrder'])->name('clients.storeFromOrder');
        Route::get('/dashboard/active_clients', [ClientController::class, 'getActiveClients'])->name('clients.active');
        Route::get('/dashboard/notactive_clients', [ClientController::class, 'getNotActiveSubscribers'])->name('clients.notactive');
        Route::post('/dashboard/check-phone', [ClientController::class, 'checkPhoneNumber'])->name('check.phone');
        Route::get('/dashboard/search-client', [ClientController::class, 'searchById'])->name('client.search');
        
        // Subscription management
        Route::post('/dashboard/subscriptions/{subscription}/activate', [ClientController::class, 'activate'])
            ->name('subscriptions.activate');
        Route::post('/dashboard/subscriptions/{subscription}/suspend', [ClientController::class, 'suspend'])
            ->name('subscriptions.suspend');
        Route::post('/dashboard/subscriptions/{subscription}/cancel', [ClientController::class, 'cancel'])
            ->name('subscriptions.cancel');
        Route::post('/dashboard/subscriptions', [ClientController::class, 'store_sub'])->name('subscriptions.store');
    });
    
    // Reservations routes
    Route::middleware(['can:الحجوزات'])->group(function () {
        Route::resource('/dashboard/reservations', EventController::class);
        Route::get('/dashboard/calender', [HomeController::class, 'calender'])->name('calender');
        Route::get('/dashboard/events', [ReservationController::class, 'index'])->name('events.index');
        Route::post('/dashboard/events', [ReservationController::class, 'store'])->name('events.store');
        Route::get('/dashboard/events/{id}', [ReservationController::class, 'destroy'])->name('events.destroy');
        Route::get('/dashboard/update_status_reservation', [EventController::class, 'updateStatus'])->name('update_status_reservation');
    });
    
    // Orders routes
    Route::middleware(['can:الطلبات'])->group(function () {
        Route::get('/dashboard/service_order', [HomeController::class, 'service_order'])->name('service_order');
        Route::get('/dashboard/packge_order', [HomeController::class, 'packge_order'])->name('packge_order');
        Route::get('/dashboard/cource_order/{order}', [HomeController::class, 'cource_order'])->name('cource_order');
        Route::get('/dashboard/course_order', [HomeController::class, 'course_order'])->name('courses_order');
        Route::get('/dashboard/contact_order', [HomeController::class, 'contact_order'])->name('contact_order');
        Route::get('/dashboard/contact_show/{id}', [HomeController::class, 'contact_order_edit'])->name('contact_order_edit');
        Route::delete('/dashboard/contact_delete/{id}', [HomeController::class, 'contact_order_delete'])->name('contact_order_delete');
        Route::get('/dashboard/change_order_cource_status/{order}', [HomeController::class, 'updateStatus_course_order'])
            ->name('updateStatus_course_order');
        Route::get('/dashboard/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/dashboard/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/dashboard/pacgkeorders/{id}', [HomeController::class, 'pacgkeorders'])->name('pacgkeorders.show');
        Route::delete('/dashboard/pacgkeorders_delete/{id}', [HomeController::class, 'pacgkeorders_delete'])->name('pacgkeorders.delete');
        Route::delete('/dashboard/cource_order_delete/{id}', [HomeController::class, 'cource_order_delete'])->name('cource_order.delete');
        Route::get('/dashboard/orders/{order}/get-order-data', [ClientController::class, 'getOrderData'])->name('orders.get-data');
    });
    
    // Reports routes
    Route::middleware(['can:التقارير'])->group(function () {
        Route::get('/dashboard/payments/reports', [ReportController::class, 'payments'])
            ->name('reports.payments');
        Route::get('/dashboard/subsciption/reports', [ReportController::class, 'subscription'])
            ->name('reports.subsciption');
        Route::get('/dashboard/visits/reports', [ReportController::class, 'visits'])
            ->name('reports.visits');
        Route::get('/dashboard/subsciption/show/{subscription}', [ReportController::class, 'showSubscription'])
            ->name('subscription.show');
    });
    
    // Products routes
    Route::middleware(['can:المتجر'])->group(function () {
        Route::resource('/dashboard/products', ProductController::class);
        Route::get('/dashboard/update_status_product', [ProductController::class, 'update_status_product'])->name('update_status_product');
    });
    
    // Visits routes
    Route::post('/dashboard/visits', [VisitController::class, 'store'])->name('visits.store');
    
    // Subscription payments
    Route::post('/dashboard/subscription-payments', [SubscriptionPaymentController::class, 'store'])->name('subscription-payments.store');
    Route::delete('/dashboard/subscription-payments/{payment}', [SubscriptionPaymentController::class, 'destroy'])->name('subscription-payments.destroy');
    
    // Notifications
    Route::get('/dashboard/notifications', [NotificationController::class, 'getNotifications']);
    Route::get('/dashboard/show_notofication/{id}', [NotificationController::class, 'show'])->name('show_notofication');
    
    // Package calculations
    Route::get('/dashboard/packages/{package}/calculate-end-date', [ClientController::class, 'calculateEndDate'])
        ->name('packages.calculate-end-date');
        

        
});