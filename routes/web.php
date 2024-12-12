<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
//use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderInvoiceController;
use App\Http\Controllers\Admin\QuickBookController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\QuickBooksApiController;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\GoogleAuthController;
use Spatie\Permission\Models\Role;

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


Route::get('/', function () {
    return view('welcome');
});
Route::get('home', function () {
    return view('welcome');
})->name('home');

Route::get('testsms', [App\Http\Controllers\FrontendController::class, 'smsTest'])->name('testsms');

Route::get('email/resend', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');

Route::get('testordermail', [App\Http\Controllers\StripeController::class, 'testordermail'])->name('testordermail');

Auth::routes();

Route::get('/', [App\Http\Controllers\FrontendController::class, 'index'])->name('index');
Route::get('services', [App\Http\Controllers\FrontendController::class, 'services'])->name('services');
Route::get('privacy-policy', [App\Http\Controllers\FrontendController::class, 'privacypolicy'])->name('privacy-policy');
Route::get('terms-of-use', [App\Http\Controllers\FrontendController::class, 'termsofuse'])->name('terms-of-use');
Route::get('service/{slug}', [App\Http\Controllers\FrontendController::class, 'servicePackage'])->name('service.package');
Route::get('studiorentals', [App\Http\Controllers\FrontendController::class, 'studiorentals'])->name('studiorentals');
Route::get('workshops', [App\Http\Controllers\FrontendController::class, 'workshops'])->name('workshops');
Route::get('workshop/{slug}', [App\Http\Controllers\FrontendController::class, 'workshopDetail'])->name('workshop.detail');
Route::get('portfolio', [App\Http\Controllers\FrontendController::class, 'portfolio'])->name('portfolio');
Route::get('portfolio/{slug}', [App\Http\Controllers\FrontendController::class, 'portfolioDetail'])->name('portfolio.detail');
Route::get('videos', [App\Http\Controllers\FrontendController::class, 'videos'])->name('videos');
Route::get('video/{slug}', [App\Http\Controllers\FrontendController::class, 'videoDetail'])->name('video.detail');
Route::get('about', [App\Http\Controllers\FrontendController::class, 'about'])->name('about');
Route::get('contact', [App\Http\Controllers\FrontendController::class, 'contact'])->name('contact');
Route::any('store-contact', [App\Http\Controllers\FrontendController::class, 'submitContact'])->name('store-contact');
Route::get('verifyemail', [App\Http\Controllers\FrontendController::class, 'verifyemail'])->name('verifyemail');

Route::get('/check-date', [App\Http\Controllers\FrontendController::class, 'checkDate']);

Route::get('reviews', [App\Http\Controllers\FrontendController::class, 'listReviews'])->name('reviews');

// Route::get('googlereviews', [App\Http\Controllers\FrontendController::class, 'getAllReviews'])->name('googlereviews');
// Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle']);
// Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

Route::post('/cart/servicepackage/store/{id}', [CartController::class, 'AddToCartServicePackage']);
Route::post('/cart/studiorental/store/{id}', [CartController::class, 'AddToCartStudioRental']);
Route::post('/cart/workshop/store/{id}', [CartController::class, 'AddToCartWorkshop']);
Route::get('/cart-remove/{rowId}', [CartController::class, 'CartRemove']);
Route::get('/product/mini/cart', [CartController::class, 'GetCartDetails']);

Route::get('/cart-decrement/{rowId}' , [CartController::class, 'CartDecrement']);
Route::get('/cart-increment/{rowId}' , [CartController::class, 'CartIncrement']);

Route::post('/addon-qty-update', [CartController::class, 'addonQtyUpdate']);

Route::post('/coupon-apply', [CartController::class, 'CouponApply']);

Route::get('/coupon-calculation', [CartController::class, 'CouponCalculation']);

Route::get('/coupon-remove', [CartController::class, 'CouponRemove']);

Route::get('/quickbooks/qbauthorize', [App\Http\Controllers\Admin\OrderController::class, 'connectToQuickBooks'])->name('quickbooks.qbauthorize');
Route::get('/quickbooks/callback', [App\Http\Controllers\Admin\OrderController::class, 'handleQuickBooksCallback'])->name('quickbooks.callback');


Route::get('/get-booked-slots', [CartController::class, 'getBookedSlots'])->name('get-booked-slots');

Route::get('/events', [GoogleCalendarController::class, 'createEvent']);

Route::get('/google/apiclient', [GoogleCalendarController::class, 'googleApiClient']);





 // Stripe All Route 
Route::controller(StripeController::class)->group(function(){

    Route::post('/create-payment-intent' , 'createPaymentIntent')->name('stripe.createPaymentIntent');

    Route::post('/stripe/order' , 'StripeOrder')->name('stripe.order');

    Route::get('/orderconfirm' , 'orderconfirm')->name('orderconfirm');

    Route::get('/stripe/success' , 'orderconfirm')->name('stripe.success');

    Route::get('/payment/error' , 'paymentError')->name('payment.error');

}); 

//Route::get('/quickbooks', [QuickBooksApiController::class, 'index']);
//Route::get('/quickbooks/callback', [QuickBooksApiController::class, 'callback']);
//Route::get('/quickbooks/invoices', [QuickBooksApiController::class, 'invoices'])->name('invoices');

//Route::get('/quickbooks/qbauthorize', [App\Http\Controllers\QuickBooksController::class, 'qbauthorize'])->name('quickbooks.qbauthorize');
//Route::get('/quickbooks/callback', [App\Http\Controllers\QuickBooksController::class, 'callback'])->name('quickbooks.callback');



//Route::get('/quickbooks/qbauthorize',  'connectToQuickBooks')->name('quickbooks.qbauthorize');
//Route::get('/quickbooks/callback', 'handleQuickBooksCallback')->name('quickbooks.callback');

Route::group(['middleware' => ['auth']], function() {
   //Route::get('/logout', 'LoginController@logout');
   //Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
   Route::post('/add-to-wishlist/{product_id}', [WishlistController::class, 'AddToWishList']);
   Route::get('/wishlist-remove/{id}', [WishlistController::class, 'WishlistRemove']);
});

Route::get('account/verify/{token}', [LoginController::class, 'verifyAccount'])->name('user.verify');

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:user', 'is_verify_email'])->group(function () {
    Route::get('/school/profilecart', [HomeController::class, 'schoolProfileCart'])->name('school.profilecart');
    Route::get('/school/profile', [HomeController::class, 'schoolProfile'])->name('school.profile');
    Route::post('/school/profile/store', [HomeController::class, 'schoolProfileStore'])->name('school.profile.store');
    Route::get('/school/home', [HomeController::class, 'schoolHome'])->name('school.home');
    Route::post('/cart/school/store/{id}', [CartController::class, 'AddToCartSchool']);
    Route::get('/school/cart', [CartController::class, 'schoolCart'])->name('school.cart');
    Route::put('/school/update/password', [HomeController::class, 'customerUpdatePassword'])->name('school.update.password');
});
//Route::get('home', [HomeController::class, 'index'])->name('home')->middleware(['auth', 'is_verify_email']);

Route::get('/user/order_details/{order_id}' , [HomeController::class, 'UserOrderDetails']);
Route::get('/invoice_download/{order_id}', [HomeController::class, 'UserOrderInvoice'])->name('invoice.download');
Route::get('/school/order', [HomeController::class, 'schoolOrder'])->name('school.orders');

/*------------------------------------------
--------------------------------------------
All customer Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:customer', 'is_verify_email'])->group(function () {
    Route::get('/customer/profilecart', [HomeController::class, 'customerProfileCart'])->name('customer.profilecart');
    Route::get('/customer/profile', [HomeController::class, 'customerProfile'])->name('customer.profile');
    
    Route::post('/customer/profile/store', [HomeController::class, 'customerProfileStore'])->name('customer.profile.store');
    Route::put('/customer/update/password', [HomeController::class, 'customerUpdatePassword'])->name('customer.update.password');
    Route::get('/customer/wishlist', [WishlistController::class, 'customerWishlist'])->name('customer.wishlist');
    Route::get('/customer/wishlistcnt', [WishlistController::class, 'customerWishlistCount'])->name('customer.wishlistcnt');
    Route::get('/customer/cart', [CartController::class, 'customerCart'])->name('customer.cart');
    Route::get('/customer/order', [HomeController::class, 'customerOrder'])->name('customer.order');

});


/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
// Route::middleware(['auth', 'user-access:admin'])->group(function () {
  
//     Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
//     Route::get('/admin/news', [NewsController::class, 'index'])->name('admin.news');
// });

//Route::get('server-side-students', 'StudentsController@getDataForDataTable')->name('server-side-students');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth', 'user-access:admin']], function () {

        

        Route::post('remove-offerimage/{id}', 'BannersController@removeOfferImage')->name('remove.offerimage');
        Route::get('delete/banners/{id}' , 'BannersController@delete')->name('banners.delete');
        Route::resource('banners', 'BannersController');


        Route::post('studentsimport', 'SchoolsController@studentsimport')->name('studentsimport');
        Route::get('delete/schools/{id}' , 'SchoolsController@delete')->name('schools.delete');
        Route::get('deleteproduct/schools/{id}' , 'SchoolsController@deleteproduct')->name('schools.deleteproduct');
        Route::resource('schools', 'SchoolsController');

        //Route::post('addproducts', 'StudentsController@addproducts')->name('addproducts');
        Route::get('getstudents' , 'StudentsController@getstudents')->name('getstudents');
        Route::delete('delete/students' , 'StudentsController@massdelete')->name('students.massdelete');
        Route::get('delete/students/{id}' , 'StudentsController@delete')->name('students.delete');
        Route::get('deleteproduct/student/{id}' , 'StudentsController@deleteproduct')->name('students.deleteproduct');
        Route::post('students/sendVerificationEmail', 'StudentsController@sendVerificationEmail')->name('users.sendVerificationEmail');
        Route::post('students/sendBulkVerificationEmail', 'StudentsController@sendBulkVerificationEmail')->name('users.sendBulkVerificationEmail');
        Route::post('students/media', 'StudentsController@storeMedia')->name('students.storeMedia');
        Route::resource('students', 'StudentsController');

        Route::delete('delete/products' , 'ProductsController@massdelete')->name('products.massdelete');
        Route::get('delete/products/{id}' , 'ProductsController@delete')->name('products.delete');
        Route::post('products/media', 'ProductsController@storeMedia')->name('products.storeMedia');
        Route::resource('products', 'ProductsController');

        Route::get('bulkproductsstudents/{id}' , 'BulkProductsController@bulkproductsstudents')->name('bulkproducts.bulkproductsstudents');
        Route::get('bulkproducts/delete/{id}' , 'BulkProductsController@deleteproduct')->name('bulkproducts.bulkdelete');
        Route::get('bulkproducts/edit/{id}' , 'BulkProductsController@editproduct')->name('bulkproducts.bulkedit');
        Route::resource('bulkproducts', 'BulkProductsController');

        Route::get('delete/banners/{id}' , 'BannersController@delete')->name('banners.delete');
        Route::resource('banners', 'BannersController');

        Route::get('services/package/{id}', 'ServicesController@package')->name('services.package');
        Route::get('services/addonsoptions/{id}', 'ServicesController@addonsoptions')->name('services.addonsoptions');
        Route::put('services/packageupdate', 'ServicesController@packageupdate')->name('services.packageupdate');
        Route::put('services/optionsaddonupdate', 'ServicesController@optionsaddonupdate')->name('services.optionsaddonupdate');
        Route::delete('services/destroy', 'ServicesController@massDestroy')->name('services.massDestroy');
        Route::post('services/media', 'ServicesController@storeMedia')->name('services.storeMedia');
        Route::resource('services', 'ServicesController');

        Route::delete('workshops/destroy', 'WorkshopsController@massDestroy')->name('workshops.massDestroy');
        Route::post('workshops/media', 'WorkshopsController@storeMedia')->name('workshops.storeMedia');
        Route::resource('workshops', 'WorkshopsController');

        Route::delete('portfolios/destroy', 'PortfoliosController@massDestroy')->name('portfolios.massDestroy');
        Route::post('portfolios/media', 'PortfoliosController@storeMedia')->name('portfolios.storeMedia');
        Route::resource('portfolios', 'PortfoliosController');

        Route::delete('videos/{id}/delete', 'VideosController@ajaxDelete')->name('videos.ajaxDelete');
        Route::delete('videos/destroy', 'VideosController@massDestroy')->name('videos.massDestroy');
        Route::post('videos/media', 'VideosController@storeVideo')->name('videos.storeVideo');
        Route::post('videos/media', 'VideosController@storeMedia')->name('videos.storeMedia');
        Route::resource('videos', 'VideosController');

        Route::get('delete/testimonials/{id}' , 'TestimonialsController@delete')->name('testimonials.delete');
        Route::resource('testimonials', 'TestimonialsController');

        Route::get('delete/coupons/{id}' , 'CouponsController@delete')->name('coupons.delete');
        Route::put('coupons/change-status', 'CouponsController@changeStatus')->name('coupons.change-status');
        Route::resource('coupons', 'CouponsController');

        Route::post('studiorentals/mostliked', 'StudioRentalsController@mostliked')->name('studiorentals.mostliked');
        Route::get('delete/studiorentals/{id}' , 'StudioRentalsController@delete')->name('studiorentals.delete');
        Route::resource('studiorentals', 'StudioRentalsController');

        Route::get('delete/clients/{id}' , 'ClientsController@delete')->name('clients.delete');
        Route::resource('clients', 'ClientsController');

        Route::get('delete/offerbanners/{id}' , 'OfferBannersController@delete')->name('offerbanners.delete');
        Route::resource('offerbanners', 'OfferBannersController');

        Route::get('delete/teams/{id}' , 'TeamsController@delete')->name('teams.delete');
        Route::resource('teams', 'TeamsController');

        Route::delete('contactforms/destroy', 'ContactformsController@massDestroy')->name('contactforms.massDestroy');
        Route::post('contactforms/media', 'ContactformsController@storeMedia')->name('contactforms.storeMedia');
        Route::resource('contactforms', 'ContactformsController');

        Route::delete('settings/destroy', 'SettingsController@massDestroy')->name('settings.massDestroy');
        Route::post('settings/media', 'SettingsController@storeMedia')->name('settings.storeMedia');
        Route::resource('settings', 'SettingsController');




        Route::controller(OrderController::class)->group(function(){
            Route::get('/ordersprint' , 'OrdersPrint')->name('ordersprint');

            Route::get('/pending/order' , 'PendingOrder')->name('pending.order');

            Route::get('/confirmed/order' , 'AdminConfirmedOrder')->name('confirmed.order');

            Route::get('/processing/order' , 'AdminProcessingOrder')->name('processing.order');
         
            Route::get('/delivered/order' , 'AdminDeliveredOrder')->name('delivered.order');

            Route::get('/order/details/{order_id}' , 'AdminOrderDetails')->name('order.details');
            Route::get('/schoolorder/details/{order_id}' , 'AdminSchoolOrderDetails')->name('schoolorder.details');

            Route::get('/pending/confirm/{order_id}' , 'PendingToConfirm')->name('pending-confirm');
            Route::get('/confirm/processing/{order_id}' , 'ConfirmToProcess')->name('confirm-processing');

            Route::get('/processing/delivered/{order_id}' , 'ProcessToDelivered')->name('processing-delivered');

            Route::get('/order/cancel/{order_id}' , 'OrderCancel')->name('order-cancel');

            //Route::get('/quickbooks/qbauthorize',  'connectToQuickBooks')->name('quickbooks.qbauthorize');
            //Route::get('/quickbooks/callback', 'handleQuickBooksCallback')->name('quickbooks.callback');

        });

        Route::controller(OrderInvoiceController::class)->group(function(){
            Route::post('/invoice/download/{order_id}' , 'adminInvoiceDownload')->name('invoice.download');
            Route::post('/invoice/sync-products-to-quickbooks' , 'syncProductsToQuickBooks')->name('invoice.sync-products-to-quickbooks');
            Route::get('/invoice/print/{orderId?}', 'printInvoice')->name('invoice.print');

        });

        // Admin School Order All Route 
        Route::controller(SchoolOrderController::class)->group(function(){
            Route::get('/schoolordersprint' , 'OrdersPrint')->name('schoolordersprint');

            Route::get('/pending/schoolorder' , 'PendingOrder')->name('pending.schoolorder');

            Route::get('/confirmed/schoolorder' , 'AdminConfirmedOrder')->name('confirmed.schoolorder');

            Route::get('/processing/schoolorder' , 'AdminProcessingOrder')->name('processing.schoolorder');
         
            Route::get('/delivered/schoolorder' , 'AdminDeliveredOrder')->name('delivered.schoolorder');
            
            /*Route::get('/order/details/{order_id}' , 'AdminOrderDetails')->name('order.details');

            Route::get('/pending/confirm/{order_id}' , 'PendingToConfirm')->name('pending-confirm');
            Route::get('/confirm/processing/{order_id}' , 'ConfirmToProcess')->name('confirm-processing');

            Route::get('/processing/delivered/{order_id}' , 'ProcessToDelivered')->name('processing-delivered');

            Route::get('/invoice/download/{order_id}' , 'AdminInvoiceDownload')->name('invoice.download');*/

        });

        Route::controller(RoleController::class)->group(function(){

            Route::get('/all/permission', 'AllPermission')->name('all.permission');

            Route::get('/add/permission', 'AddPermission')->name('add.permission');

            Route::post('/store/permission', 'StorePermission')->name('store.permission');

            Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');

            Route::post('/update/permission', 'UpdatePermission')->name('update.permission');

            Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');

            Route::get('/all/roles', 'AllRoles')->name('all.roles');

            Route::get('/add/roles', 'AddRoles')->name('add.roles');

            Route::post('/store/roles', 'StoreRoles')->name('store.roles');

            Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles');

            Route::post('/update/roles', 'UpdateRoles')->name('update.roles');

            Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles');

            Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');

            Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');

            Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission');

            Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles');

            Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');

            Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles');


        });

        Route::controller(AdminController::class)->group(function(){

            Route::get('dashboard', 'adminDashboard')->name('dashboard');

            Route::get('calendar', 'calendar')->name('calendar');

            Route::get('profile', 'adminProfile')->name('profile');

            Route::post('profile/store', 'adminProfileStore')->name('profile.store');

            Route::post('update/password', 'adminUpdatePassword')->name('update.password');

            Route::get('/all/admin', 'AllAdmin')->name('all.admin'); 

            Route::get('/add/admin', 'AddAdmin')->name('add.admin');

            Route::post('/store/admin', 'StoreAdmin')->name('store.admin');

            Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin');

            Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');

            Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin');

        });

        Route::get('/quickbooks/login', [QuickBookController::class, 'login'])->name('quickbook.createtoken');

        Route::get('/quickbooks/callback', [QuickBookController::class, 'callback'])->name('quickbook.callback');        
});
  
 
Route::get('create-role', function () {
    $role = Role::create(['name' => 'writer']);
});


Route::get('routes', function () {
    $routeCollection = Route::getRoutes();

    echo "<table style='width:100%'>";
    echo "<tr>";
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='10%'><h4>Name</h4></td>";
    echo "<td width='70%'><h4>Corresponding Action</h4></td>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        echo "<tr>";
        echo "<td>" . $value->methods()[0] . "</td>";
        echo "<td>" . $value->uri() . "</td>";
        echo "<td>" . $value->getName() . "</td>";
        echo "<td>" . $value->getActionName() . "</td>";
        echo "</tr>";
    }
    echo "</table>";
});