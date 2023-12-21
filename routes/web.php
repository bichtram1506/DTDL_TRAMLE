<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Page\BotManController;

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

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

Route::get('errors-403', function() {
    return view('errors.403');
});
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {

    Route::group(['namespace' => 'Auth'], function() {
        Route::get('/login', 'LoginController@login')->name('admin.login');
        Route::post('/login', 'LoginController@postLogin');
        Route::get('/register', 'RegisterController@getRegister')->name('admin.register');
        Route::post('/register', 'RegisterController@postRegister');
        Route::get('/logout', 'LoginController@logout')->name('admin.logout');
        Route::get('/forgot/password', 'ForgotPasswordController@forgotPassword')->name('admin.forgot.password');
    });

    Route::group(['middleware' =>['auth']], function() {
        Route::get('/home', 'HomeController@index')->name('admin.home')->middleware('permission:truy-cap-he-thong|full-quyen-quan-ly');

        Route::group(['prefix' => 'group-permission'], function(){
            Route::get('/','GroupPermissionController@index')->name('group.permission.index');
            Route::get('/create','GroupPermissionController@create')->name('group.permission.create');
            Route::post('/create','GroupPermissionController@store');

            Route::get('/update/{id}','GroupPermissionController@edit')->name('group.permission.update');
            Route::post('/update/{id}','GroupPermissionController@update');

            Route::get('/delete/{id}','GroupPermissionController@destroy')->name('group.permission.delete');
        });

        Route::group(['prefix' => 'permission'], function(){
            Route::get('/','PermissionController@index')->name('permission.index');
            Route::get('/create','PermissionController@create')->name('permission.create');
            Route::post('/create','PermissionController@store');

            Route::get('/update/{id}','PermissionController@edit')->name('permission.update');
            Route::post('/update/{id}','PermissionController@update');

            Route::get('/delete/{id}','PermissionController@delete')->name('permission.delete');
        });
        Route::group(['prefix' => 'service'], function(){
            Route::get('/','ServiceController@index')->name('service.index')->middleware('permission:danh-sach-dich-vu|full-quyen-quan-ly');
            Route::get('/create','ServiceController@create')->name('service.create')->middleware('permission:them-dich-vu|full-quyen-quan-ly');
            Route::post('/create','ServiceController@store');

            Route::get('/update/{id}','ServiceController@edit')->name('service.update')->middleware('permission:chinh-sua-dich-vu|full-quyen-quan-ly');
            Route::post('/update/{id}','ServiceController@update');

            Route::get('/delete/{id}','ServiceController@delete')->name('service.delete')->middleware('permission:xoa-dich-vu|full-quyen-quan-ly');;
        });
        Route::group(['prefix' => 'role'], function(){
            Route::get('/','RoleController@index')->name('role.index')->middleware('permission:danh-sach-vai-tro|full-quyen-quan-ly');
            Route::get('/create','RoleController@create')->name('role.create')->middleware('permission:them-moi-vai-tro|full-quyen-quan-ly');
            Route::post('/create','RoleController@store');

            Route::get('/update/{id}','RoleController@edit')->name('role.update')->middleware('permission:chinh-sua-vai-tro|full-quyen-quan-ly');
            Route::post('/update/{id}','RoleController@update');

            Route::get('/delete/{id}','RoleController@delete')->name('role.delete')->middleware('permission:xoa-vai-tro|full-quyen-quan-ly');
        });

        Route::group(['prefix' => 'staff'], function(){
            Route::get('/','StaffController@index')->name('staff.index')->middleware('permission:danh-sach-nhan-vien|full-quyen-quan-ly');
            Route::get('/create','StaffController@create')->name('staff.create')->middleware('permission:them-moi-nhan-vien|full-quyen-quan-ly');
            Route::post('/create','StaffController@store');

            Route::get('/update/{id}','StaffController@edit')->name('staff.update')->middleware('permission:chinh-sua-nhan-vien|full-quyen-quan-ly');
            Route::post('/update/{id}','StaffController@update');

            Route::get('/delete/{id}','StaffController@delete')->name('staff.delete')->middleware('permission:xoa-nhan-vien|full-quyen-quan-ly');
        });

        Route::group(['prefix' => 'user'], function(){
            Route::get('/','UserController@index')->name('user.index')->middleware('permission:danh-sach-nguoi-dung|full-quyen-quan-ly');
            Route::get('/create','UserController@create')->name('user.create')->middleware('permission:them-moi-nguoi-dung|full-quyen-quan-ly');
            Route::post('/create','UserController@store');

            Route::get('/update/{id}','UserController@edit')->name('user.update')->middleware('permission:chinh-sua-nguoi-dung|full-quyen-quan-ly');
            Route::post('/update/{id}','UserController@update');

            Route::get('/delete/{id}','UserController@delete')->name('user.delete')->middleware('permission:xoa-nguoi-dung|full-quyen-quan-ly');
        });
        
        Route::group(['prefix' => 'category'], function(){
            Route::get('/','CategoryController@index')->name('category.index')->middleware('permission:danh-sach-danh-muc|full-quyen-quan-ly');
            Route::get('/create','CategoryController@create')->name('category.create')->middleware('permission:them-moi-danh-muc|full-quyen-quan-ly');
            Route::post('/create','CategoryController@store')->name('category.store');

            Route::get('/update/{id}','CategoryController@edit')->name('category.update')->middleware('permission:chinh-sua-danh-muc|full-quyen-quan-ly');
            Route::post('/update/{id}','CategoryController@update');

            Route::get('/delete/{id}','CategoryController@delete')->name('category.delete')->middleware('permission:xoa-danh-muc|full-quyen-quan-ly');
        });

        Route::group(['prefix' => 'article'], function(){
            Route::get('/','ArticleController@index')->name('article.index')->middleware('permission:danh-sach-bai-viet|full-quyen-quan-ly');
            Route::get('/create','ArticleController@create')->name('article.create')->middleware('permission:them-moi-bai-viet|full-quyen-quan-ly');
            Route::post('/create','ArticleController@store');

            Route::get('/update/{id}','ArticleController@edit')->name('article.update')->middleware('permission:chinh-sua-bai-viet|full-quyen-quan-ly');
            Route::post('/update/{id}','ArticleController@update');

            Route::get('/delete/{id}','ArticleController@delete')->name('article.delete')->middleware('permission:xoa-bai-viet|full-quyen-quan-ly');
        });

        Route::group(['prefix' => 'location'], function(){
            Route::get('/','LocationController@index')->name('location.index')->middleware('permission:danh-sach-dia-diem|full-quyen-quan-ly');
            Route::post('/create','LocationController@store')->name('location.store')->middleware('permission:them-moi-dia-diem|full-quyen-quan-ly');

            Route::get('/update/{id}','LocationController@edit')->name('location.update')->middleware('permission:chinh-sua-dia-diem|full-quyen-quan-ly');
            Route::post('/update/{id}','LocationController@update');

            Route::get('/attraction/{id}', 'LocationController@showAttraction')->name('region.location.attraction.index');
       

            Route::get('/delete/{id}','LocationController@delete')->name('location.delete')->middleware('permission:xoa-dia-diem|full-quyen-quan-ly');
        });
        Route::group(['prefix' => 'attraction'], function(){
            Route::get('/','AttractionController@index')->name('attraction.index')->middleware('permission:danh-sach-dia-diem|full-quyen-quan-ly');
            Route::post('/create','AttractionController@store')->name('attraction.store')->middleware('permission:them-moi-dia-diem|full-quyen-quan-ly');
            Route::get('/delete/{id}', 'AttractionController@delete')->name('attraction.delete')->middleware('permission:xoa-dia-diem|full-quyen-quan-ly');
            Route::get('/update/{id}','AttractionController@edit')->middleware('permission:chinh-sua-dia-diem|full-quyen-quan-ly');
            Route::post('/update/{id}', 'AttractionController@update')->name('attraction.update')->middleware('permission:chinh-sua-dia-diem|full-quyen-quan-ly');
        });
        Route::group(['prefix' => 'vehicle'], function(){
            Route::get('/','VehicleController@index')->name('vehicle.index')->middleware('permission:danh-sach-phuong-tien|full-quyen-quan-ly');
            Route::get('/update/{id}','VehicleController@edit')->middleware('permission:chinh-sua-phuong-tien|full-quyen-quan-ly');;
            Route::post('/update/{id}', 'VehicleController@update')->name('vehicle.update');
            Route::post('/create','VehicleController@store')->name('vehicle.store')->middleware('permission:them-moi-phuong-tien|full-quyen-quan-ly');
            Route::get('/vehicle/{id}', 'VehicleController@delete')->name('vehicle.delete')->middleware('permission:xoa-phuong-tien|full-quyen-quan-ly');;
        });
        Route::group(['prefix' => 'region'], function(){
            Route::get('/','RegionController@index')->name('region.index')->middleware('permission:danh-sach-dia-diem|full-quyen-quan-ly');
            Route::get('/create','RegionController@create')->name('region.create')->middleware('permission:them-moi-dia-diem|full-quyen-quan-ly');
            Route::post('/create','RegionController@store');

            Route::get('/update/{id}','RegionController@edit')->name('region.update')->middleware('permission:chinh-sua-dia-diem|full-quyen-quan-ly');
            Route::post('/update/{id}','RegionController@update');
            Route::get('/location/{id}', 'RegionController@showLocation')->name('region.location.index');
            Route::get('/delete/{id}','RegionController@delete')->name('region.delete')->middleware('permission:xoa-dia-diem|full-quyen-quan-ly');
        });

        Route::group(['prefix' => 'tour'], function(){
            Route::get('/','TourController@index')->name('tour.index')->middleware('permission:danh-sach-tour|full-quyen-quan-ly|them-lich-trinh');
            Route::get('/create','TourController@create')->name('tour.create')->middleware('permission:them-moi-tour|full-quyen-quan-ly');
            Route::post('/create','TourController@store');
            Route::get('/tour_request','TourController@index1')->name('tour.index1')->middleware('permission:danh-sach-tour|full-quyen-quan-ly|them-lich-trinh');
            Route::get('/tour_0','TourController@index0')->name('tour.index0')->middleware('permission:danh-sach-tour|full-quyen-quan-ly|them-lich-trinh');
            Route::get('/detail/{id}', 'TourController@showDetail')->name('tour.details');
            Route::get('/eventdate/{id}', 'TourController@showEventDate')->name('tour.eventdate.index')->middleware('permission:chinh-sua-tour|full-quyen-quan-ly');;

            Route::get('/update/{id}','TourController@edit')->name('tour.update')->middleware('permission:chinh-sua-tour|full-quyen-quan-ly|them-lich-trinh');
            Route::post('/update/{id}','TourController@update');
            Route::post('/tours/{tour}/save-vehicles', 'TourController@saveVehicles')->name('saveVehicles')->middleware('permission:chinh-sua-tour|full-quyen-quan-ly');

            Route::get('/delete/{id}','TourController@delete')->name('tour.delete')->middleware('permission:xoa-tour|full-quyen-quan-ly');
            // web.php
            Route::get('/bao-gia/{quote_id}', 'TourController@sendQuote')->name('bao-gia')->middleware('permission:chinh-sua-tour|full-quyen-quan-ly');
            Route::post('/create-quote', 'TourController@create_quote')->name('create-quote')->middleware('permission:chinh-sua-tour|full-quyen-quan-ly');
            Route::get('/quote-delete/{id}','TourController@quote_delete')->name('quote.delete')->middleware('permission:xoa-tour|full-quyen-quan-ly');

        });
        Route::group(['prefix' => 'bespoke_tour'], function(){
            Route::get('/','BespokeTourController@index')->name('bespoke.index')->middleware('permission:danh-sach-tour|full-quyen-quan-ly');
        });
        Route::group(['prefix' => 'tourtype'], function(){
            Route::get('/','TourTypeController@index')->name('tourtype.index')->middleware('permission:danh-sach-loai-tour|full-quyen-quan-ly');
            Route::get('/create','TourTypeController@create')->name('tourtype.create')->middleware('permission:them-loai-tour|full-quyen-quan-ly');
            Route::post('/create','TourTypeController@store');

            Route::get('/update/{id}','TourTypeController@edit')->name('tourtype.update')->middleware('permission:chinh-sua-loai-tour|full-quyen-quan-ly');
            Route::post('/update/{id}','TourTypeController@update');

            Route::get('/delete/{id}','TourTypeController@delete')->name('tourtype.delete')->middleware('permission:xoa-loai-tour|full-quyen-quan-ly');
        });
        Route::group(['prefix' => 'tourdate'], function(){
            Route::get('/','TourDateController@index')->name('tourdate.index');
        });

        Route::group(['prefix' => 'hotel'], function(){
            Route::get('/','HotelController@index')->name('hotel.index')->middleware('permission:danh-sach-khach-san|full-quyen-quan-ly');
            Route::get('/create','HotelController@create')->name('hotel.create')->middleware('permission:them-moi-khach-san|full-quyen-quan-ly');
            Route::post('/create','HotelController@store');

            Route::get('/update/{id}','HotelController@edit')->name('hotel.update')->middleware('permission:chinh-sua-khach-san|full-quyen-quan-ly');
            Route::post('/update/{id}','HotelController@update');

            Route::get('/delete/{id}','HotelController@delete')->name('hotel.delete')->middleware('permission:xoa-khach-san|full-quyen-quan-ly');
        });
        Route::group(['prefix' => 'room'], function(){
            Route::get('/','RoomController@index')->name('room.index')->middleware('permission:danh-sach-phong|full-quyen-quan-ly');
            Route::get('/create','RoomController@create')->name('room.create')->middleware('permission:them-moi-phong|full-quyen-quan-ly');
            Route::post('/create','RoomController@store');

            Route::get('/update/{id}','RoomController@edit')->name('room.update')->middleware('permission:chinh-sua-phong|full-quyen-quan-ly');
            Route::post('/update/{id}','RoomController@update');

            Route::get('/delete/{id}','RoomController@delete')->name('room.delete')->middleware('permission:xoa-phong|full-quyen-quan-ly');
        });


        Route::group(['prefix' => 'book-tour'], function(){
            Route::get('/', 'BookTourController@index')->name('book.tour.index')->middleware('permission:quan-ly-dat-tour|full-quyen-quan-ly');
            Route::get('/update/{status}/{id}', 'BookTourController@updateStatus')->name('book.tour.update.status')->middleware('permission:xoa-va-cap-nhat-trang-thai|full-quyen-quan-ly');
            Route::get('/delete/{id}', 'BookTourController@delete')->name('book.tour.delete')->middleware('permission:xoa-va-cap-nhat-trang-thai|full-quyen-quan-ly');
            Route::get('/booktour/detail/{id}', 'BookTourController@showDetail')->name('book.tour.detail')->middleware('permission:xoa-va-cap-nhat-trang-thai|full-quyen-quan-ly');
            Route::get('/update/{id}','BookTourController@edit')->name('book.tour.update')->middleware('permission:chinh-sua-dat-tour|full-quyen-quan-ly');
            Route::post('/update/{id}','BookTourController@update');
            Route::get('/invoices/{bookId}/download', 'BookTourController@downloadInvoiceAsPDF')->name('download_invoice');


        });
        Route::group(['prefix' => 'book-hotel'], function(){
            Route::get('/', 'BookHotelController@index')->name('book.hotel.index')->middleware('permission:danh-sach-dat-hotel|full-quyen-quan-ly');
            Route::get('/update/{status}/{id}', 'BookHotelController@updateStatus')->name('book.hotel.update.status')->middleware('permission:xoa-va-cap-nhat-trang-thai-book-hotel|full-quyen-quan-ly');
            Route::get('/delete/{id}', 'BookHotelController@delete')->name('book.hotel.delete')->middleware('permission:xoa-va-cap-nhat-trang-thai-book-hotel|full-quyen-quan-ly');
            Route::get('/update/{id}','BookHotelController@edit')->name('book.hotel.update')->middleware('permission:chinh-sua-book-hotel|full-quyen-quan-ly');
            Route::post('/update/{id}','BookHotelController@update');

        });
        Route::group(['prefix' => 'tour_guide'], function(){
            Route::get('/eventdate/{id}', 'EventDateController@show_tourguide')->name('eventdate.show')->middleware('permission:danh-sach-lich-trinh-user|full-quyen-quan-ly');
         
        });

        Route::group(['prefix' => 'comments'], function(){
            Route::get('/', 'CommentController@index')->name('comment.index')->middleware('permission:quan-ly-binh-luan|full-quyen-quan-ly');
            Route::get('/update/{status}/{id}', 'CommentController@updateStatus')->name('comment.update.status')->middleware('permission:xoa-va-cap-nhat-trang-thai-binh-luan|full-quyen-quan-ly');
            Route::get('/delete/{id}', 'CommentController@delete')->name('comment.delete')->middleware('permission:xoa-va-cap-nhat-trang-thai-binh-luan|full-quyen-quan-ly');
         
        });
        Route::group(['prefix' => 'eventdates'], function(){
            Route::get('/', 'EventDateController@index')->name('eventdate.index')->middleware('permission:danh-sach-lich-trinh|full-quyen-quan-ly|chinh-sua-tour');
            Route::get('/update/{status}/{id}', 'EventDateController@updateStatus')->name('eventdate.update.status')->middleware('permission:xoa-va-cap-nhat-trang-thai-lich-trinh|full-quyen-quan-ly');
            Route::post('/create','EventDateController@store')->name('eventdate.store')->middleware('permission:them-lich-trinh|full-quyen-quan-ly');
            Route::get('/update/{id}','EventDateController@edit')->name('eventdate.update')->middleware('permission:chinh-sua-lich-trinh|full-quyen-quan-ly');
            Route::post('/update/{id}','EventDateController@update')->middleware('permission:chinh-sua-lich-trinh|full-quyen-quan-ly|');
            Route::get('/delete/{id}', 'EventDateController@delete')->name('eventdate.delete')->middleware('permission:xoa-va-cap-nhat-trang-thai-lich-trinh|full-quyen-quan-ly');
        
// routes/web.php
            Route::get('/getUsersByEvent/{eventDateId}', 'EventDateController@getUsersByEvent')->name('book.user.detail')->middleware('permission:danh-sach-lich-trinh|full-quyen-quan-ly');

        });

        Route::group(['prefix' => 'touritineraries'], function(){
            Route::post('/create','TourItinerarieController@store')->name('touritinerarie.store')->middleware('permission:chinh-sua-tour|full-quyen-quan-ly');
            Route::get('/update/{id}','TourItinerarieController@edit')->middleware('permission:chinh-sua-tour|full-quyen-quan-ly');
            Route::post('/update/{id}', 'TourItinerarieController@update')->name('touritinerarie.update')->middleware('permission:chinh-sua-tour|full-quyen-quan-ly');
            Route::get('/delete/{id}', 'TourItinerarieController@delete')->name('touritinerarie.delete')->middleware('permission:chinh-sua-tour|full-quyen-quan-ly');
         
         
        });
        Route::group(['prefix' => 'tourimages'], function(){
            Route::post('/create','TourImageController@store')->name('tourimage.store')->middleware('permission:chinh-sua-tour|full-quyen-quan-ly');
            Route::get('/update/{id}','TourImageController@edit')->middleware('permission:chinh-sua-tour|full-quyen-quan-ly');
            Route::post('/update/{id}', 'TourImageController@update')->name('tourimage.update')->middleware('permission:chinh-sua-tour|full-quyen-quan-ly');
            Route::get('/delete/{id}', 'TourImageController@delete')->name('tourimage.delete')->middleware('permission:chinh-sua-tour|full-quyen-quan-ly');
         
         
        });
        Route::group(['prefix' => 'couponcodes'], function(){
            Route::get('/', 'CouponCodeController@index')->name('couponcode.index')->middleware('permission:danh-sach-ma-khuyen-mai|full-quyen-quan-ly');;
            Route::get('/create','CouponCodeController@create')->name('couponcode.create')->middleware('permission:them-ma-khuyen-mai|full-quyen-quan-ly');
            Route::post('/create','CouponCodeController@store')->middleware('permission:them-ma-khuyen-mai|full-quyen-quan-ly');
            Route::get('/update/{id}','CouponCodeController@edit')->name('couponcode.update')->middleware('permission:sua-ma-khuyen-mai|full-quyen-quan-ly');
            Route::post('/update/{id}', 'CouponCodeController@update')->middleware('permission:sua-ma-khuyen-mai|full-quyen-quan-ly');
            Route::get('/delete/{id}', 'CouponCodeController@delete')->name('couponcode.delete')->middleware('permission:xoa-ma-khuyen-mai|full-quyen-quan-ly');;
        });
        
        
        
        Route::group(['prefix' => 'revenue-report'], function(){
            Route::get('/', 'RevenueReportController@index')->name('admin.revenue_report.index')->middleware('permission:danh-sach-thong-ke|full-quyen-quan-ly');
            Route::get('/revenue-by-month', 'RevenueReportController@getRevenueByMonth')->middleware('permission:danh-sach-thong-ke|full-quyen-quan-ly');
            Route::get('/revenue-by-month/{year}/{month}', 'RevenueReportController@getDailyRevenueByMonth')->middleware('permission:danh-sach-thong-ke|full-quyen-quan-ly');
            Route::get('/monthly-revenue/{year}', 'RevenueReportController@getMonthlyRevenueByYear')->middleware('permission:danh-sach-thong-ke|full-quyen-quan-ly');
            Route::get('/searchChartData',  'RevenueReportController@searchChartData');
            Route::get('/search-revenue',  'RevenueReportController@searchByMonthAndYear');
        });
        
        Route::get('/schedule', function () {
            $schedule = app(Schedule::class);
        
            $schedule->call(function () {
              
              $this->updateBookingStatus();
            })->daily();
        
            $schedule->call(function () {
                // Đặt mã công việc khác ở đây
            })->everyMinute();
        
            $schedule->run();
        
            return 'Scheduled tasks executed.';
        });
    });
});

Route::group(['namespace' => 'Page'], function() {

    Route::group(['namespace' => 'Auth'], function() {
        Route::get('/dang-nhap.html', 'LoginController@login')->name('page.user.account');
        Route::post('/account/login', 'LoginController@postLogin')->name('account.login');
        Route::get('/dang-ky-tai-khoan.html', 'RegisterController@register')->name('user.register');
        Route::post('/account/register', 'RegisterController@postRegister')->name('post.account.register');
        Route::get('/dang-xuat.html', 'LoginController@logout')->name('page.user.logout');
        Route::get('/quen-mat-khau.html', 'ForgotPasswordController@showLinkRequestForm')->name('password.email');
        Route::post('/quen-mat-khau.html', 'ForgotPasswordController@sendResetLinkEmail')->name('password.reset');
        Route::get('/dat-lai-mat-khau/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/dat-lai-mat-khau', 'ResetPasswordController@reset')->name('password.update');
        Route::get('/verify-account/{token}', 'RegisterController@verifyAccount')->name('verify-account');
        // Hiển thị form yêu cầu khôi phục mật khẩu
        

    });

    Route::group(['middleware' =>['users']], function() {
        Route::get('account.html', 'AccountController@infoAccount')->name('info.account');
        Route::get('list-tour.html', 'AccountController@myTour')->name('my.tour');
        Route::get('list-hotel.html', 'AccountController@myHotel')->name('my.hotel');
        Route::post('/update/info/account/{id}', 'AccountController@updateInfoAccount')->name('update.info.account');
        Route::get('change-password.html', 'AccountController@changePassword')->name('change.password');
        Route::post('change/password', 'AccountController@postChangePassword')->name('post.change.password');
        Route::post('cancel/order/tour/{status}/{id}', 'AccountController@updateStatus')->name('post.cancel.order.tour');
        Route::post('cancel/order/hotel/{status}/{id}', 'AccountController@updateStatusHotel')->name('post.cancel.order.hotel');
        Route::get('/deletecm/{id}', 'CommentController@delete')->name('commentuser.delete');
        Route::get('/tour-comments.html', 'AccountController@getTourComments')->name('tour.comments');
        Route::get('/tour-favorites.html', 'AccountController@getTourFavorites')->name('tour.favorites');
        Route::get('/tour-requires.html', 'AccountController@getTourRequires')->name('tour.requires');
        Route::post('/apply-discount', 'CheckoutController@applyDiscount')->name('apply.discount');
        Route::post('/tour/{id}/favorite', 'TourController@addToFavorites')->name('tour.addToFavorites');
        Route::get('/messages', 'MessageController@index')->name('message.index');
        Route::post('/messages/send', 'MessageController@store')->name('message.store');
        Route::get('/get-notifications', 'AccountController@getNotifications')->name('get.notifications');
     
        Route::post('/submit-review', 'CommentController@submitReview')->name('submit.review');
        Route::get('/quote/request/{tourId}', 'AccountController@requestQuote')->name('quote.request');
        Route::post('/filter-rooms', 'HotelController@filterRooms')->name('filter-rooms');
        Route::get('/danh-gia-don/{id}', 'CommentController@showReviewForm')->name('danh.gia.don');
        Route::get('/booktour/detail/{id}', 'TourController@showDetail')->name('book1.tour.detail');
        Route::get('/tour-comments', 'AccountController@getTourComments')->name('tour-comments');
    });    
     Route::post('/update-tour', 'TourController@update')->name('update.tour');
    Route::post('/quote/action/{id}', 'AccountController@processAction')->name('quote.processAction');
    Route::get('/', 'HomeController@index')->name('page.home');
    Route::get('/loi', 'TourController@loi')->name('loi.loi');
    Route::get('/tin-tuc.html', 'ArticleController@index')->name('articles.index');
    Route::get('/tin-tuc/{id}/{slug}.html', 'ArticleController@detail')->name('articles.detail');
    Route::get('/ve-chung-toi.html', 'HomeController@about')->name('about.us');
    Route::get('/lien-he.html', 'HomeController@contact')->name('contact.index');
    Route::get('/khuyen-mai.html', 'TourController@index_promotion')->name('promotion.index');
    Route::get('/tour.html', 'TourController@index')->name('tour');
    Route::get('book-tour/{id}/{slug}.html', 'TourController@bookTour')->name('book.tour');
    Route::get('book-tour-user/{id}/{slug}.html', 'TourController@bookTouruser')->name('book.tour.user');
    Route::post('book/tour/{id}', 'TourController@postBookTour')->name('post.book.tour');
    Route::get('/ve-may-bay.html', 'FlightController@index')->name('flight.index');
    Route::get('/tour-theo-yeu-cau.html', 'DespokeTourController@bookTour')->name('despoke.book.index');    
    Route::post('/tour-theo-yeu-cau/book/tour/', 'DespokeTourController@postbookTour')->name('despoke.postbook.tour');    
   //Cổng thanh toán 
   Route::post('/vnpay_payment', 'PaymentController@vnpay_payment')->name('vnpay_payment'); 
   Route::match(['get', 'post'], '/momo_payment', 'PaymentController@momo_payment')->name('momo_payment');
   Route::match(['get', 'post'], '/vnpay_return', 'PaymentController@vnpay_return')->name('vnpay_return');
   /// Book Hotel
   Route::get('book-room/{id}/{slug}.html', 'HotelController@bookRoom')->name('book.room');
   Route::post('/post-book-room/{id}', 'HotelController@postBookRoom')->name('post.book.room');

   // routes/web.php
   
    Route::get('/tour/{id}/{slug}.html', 'TourController@detail')->name('tour.detail');
    Route::get('/khach-san.html', 'HotelController@index')->name('hotel');
    Route::get('/khach-san/{id}/{slug}.html', 'HotelController@detail')->name('hotel.detail');
    Route::post('/comment', 'CommentController@comment')->name('comment');
    Route::get('/category/{id}', 'ArticleController@showByCategory')->name('articles.showByCategory');
    ////Phòng khách sạn
    Route::get('/room-detail/{id}', 'HotelController@Roomdetail')->name('room.detail');
 //   Route::get('/locations/{t_location_id}/tours', 'TourController@indexByLocation')->name('tours.by_location');
    Route::get('/tour/{date}', 'TourController@show')->name('tour.show');
    Route::get('/tours/location/{location_id}', 'TourController@showToursByLocation')->name('tours.by.location');
    Route::get('/tours/region/{region_id}', 'TourController@showToursByRegion')->name('tours.by.region');
    Route::get('/show-tours-by-tour-type/{tourtype_id}', 'TourController@showToursByTourType')->name('showToursByTourType');
    Route::post('/favorite/{tour}', 'TourController@toggleFavorite')->name('favorite.toggle');
    Route::get('/tour/delete-favorite/{id}', 'AccountController@deleteFavorite')->name('tour.deleteFavorite');

    Route::get('/tour/{tourId}/download-itinerary', 'TourController@downloadItinerariesAsPDF')->name('download.itineraries');
    Route::match(['get', 'post'], '/botman', [BotManController::class,"handle"]);

    Route::match(['get', 'post'], '/thanh-toan', 'PaymentController@processPayment')->name('process_payment');
    Route::match(['get', 'post'], '/thanh-toan-momo', 'PaymentController@processPaymentMOMO')->name('process_payment_momo');
    Route::get('/payment/success','PaymentController@success')->name('payment.success');
    Route::post('/payment/ipn', 'PaymentController@ipn')->name('payment.ipn');

    
});