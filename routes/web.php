<?php

use FontLib\Table\Type\name;

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

// Route::resource('/makes', 'makeControllers');
Route::get('makes', 'makeControllers@index');
// Route::get('logos', 'makeControllers@Logo');
Route::get('logos/{make_id}', 'makeControllers@logo');
Route::get('makes/model/{make_id}', 'makeControllers@model');
Route::get('model/generation/{model_id}', 'makeControllers@generation');
Route::get('generation/engine/{model_id}', 'makeControllers@engine');
// Route::get('generation/engine/{generation_id}/{engine_id}/{code}/{name}/{fuel_type}/{power}/{torgue}/{flag}', 'makeControllers@generationEngine');

Route::group(['domain' => '127.0.0.11'], function () {
    Route::get('/', 'CompaniesController@create')->name('/companies/create')->middleware(['checkrole']);
    Route::get('/admin/login', 'SuperLoginController@login')->middleware(['checkrole']);
    Route::post('admin-login', 'SuperLoginController@adminLogin');
    Route::post('admin-logout', 'SuperLoginController@adminLogout');
    Route::resource('/profile', 'UserProfileController')->middleware(['auth']);

    Route::get('/tenants', 'TernantLoginController@tenants')->middleware(['auth']);

    Route::resource('/company-credits', 'CompanyCreditsController')->middleware(['auth']);
    Route::resource('admin-payments', 'AdminPaymentGetawayController')->middleware(['auth']);
    Route::get('super-admin/dashboard', 'CustomersController@adminDashboard')->middleware(['auth']);

    Route::get('/companies/success/{token}', 'CompaniesController@success')->name('success');
    Route::get('/companies/payment/{token}', 'CompaniesController@packagePayment')->name('packagePayment');
    Route::get('/order/{token}', 'CompaniesController@OrderCompleted')->name('OrderCompleted');

    Route::resource('/companies', 'CompaniesController')->only(['index', 'edit', 'update', 'destroy'])->middleware(['auth']);

    Route::resource('/companies', 'CompaniesController')->only(['create', 'store']);
    Route::get('/companies/block/{id}', 'CompaniesController@blocked')->middleware(['auth']);
    Route::get('/video', 'CompaniesController@videoPlayer')->name('videoPlayer')->middleware(['auth']);
    Route::get('/help', 'CompaniesController@help')->name('help')->middleware(['auth']);
});

Route::group(['middleware' => 'CheckCompany'], function () {
    Route::group(['namespace' => 'Auth\Controllers'], function () {
        // Authentication Routes...
        Route::get('/', 'LoginController@showLoginForm')->name('login')->middleware(['checkrole']);
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('logout');
    });
    Route::resource('/tuning-database', 'TuningDatabaseController')->only(['index']);

    Route::get('download/comment/{id}', 'FileController@comment');
    Route::get('download/file_service/{id}', 'FileController@modified');


    Route::group(['middleware' => ['blockCompany', 'blockUser']], function () {
        Route::group(['middleware' => ['subscription']], function () {
            Route::get('admin/dashboard', 'AdminDashboardController@adminDashboard')->name('admin/dashboard')->middleware(['auth']);
            Route::post('/export', 'AdminDashboardController@export')->name('export')->middleware(['auth']);
            Route::resource('/tickets', 'TicketsController')->middleware(['auth']);
            Route::delete('/users/impersonate', 'ImpersonateController@destroy')->name('users.impersonate.destroy');
            Route::post('/users/impersonate', 'ImpersonateController@store')->name('users.impersonate.store');
            Route::get('/dashboard', 'CustomersController@dashboard')->name('dashboard')->middleware(['auth']);

            Route::group(['prefix' => '/account', 'middleware' => ['auth'], 'namespace' => 'Account\Controllers', 'as' => 'account.'], function () {
                Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
            });
            Route::resource('/tuning-credits', 'TuningCreditsController')->middleware(['auth']);
            Route::get('/add-group', 'TuningCreditsController@addGroup')->middleware(['auth']);
            Route::post('/add-group', 'TuningCreditsController@addGroupCredits')->middleware(['auth']);
            Route::get('/add-tier', 'TuningCreditsController@addTier')->middleware(['auth']);
            Route::post('/add-tier', 'TuningCreditsController@addTierCredits')->middleware(['auth']);
            Route::get('/edit-group/{id}', 'TuningCreditsController@editGroup')->middleware(['auth']);
            Route::put('/edit-group/{id}', 'TuningCreditsController@editGroupCredits')->middleware(['auth']);
            Route::delete('/deletet-tier/{id}', 'TuningCreditsController@deleteTier')->middleware(['auth']);
            Route::delete('/delete-group/{id}', 'TuningCreditsController@deleteGroup')->middleware(['auth']);
            Route::get('/edit-group-default/{id}', 'TuningCreditsController@editGroupDefault')->middleware(['auth']);
            Route::get('/edit-user/{id}', 'CustomersController@updateUser')->middleware(['auth']);
            Route::put('/edit-user/{id}', 'CustomersController@updateUserData')->middleware(['auth']);

            Route::group(['prefix' => '/account', 'middleware' => ['auth'], 'namespace' => 'Ticket\Controllers', 'as' => 'ticket.'], function () {

                Route::post('comment', 'CommentsController@postComment')->name('comment');
                Route::get('comment/{id}', 'CommentsController@commentFile');
            });

            Route::get('/credits', 'CompanyCreditsController@Credits')->name('credits')->middleware(['auth']);
            Route::get('/company-credits/cancel/{token}', 'CompanyCreditsController@cancel')->middleware(['auth']);

            Route::get('/company-credits/success/{token}', 'CompanyCreditsController@success')->middleware(['auth']);
            Route::post('/companyCredits', 'CompanyCreditsController@companyCredits')->name('companyCredits')->middleware(['auth']);


            Route::get('/customers/{id}/file_services', 'FileServicesController@customerFileservice')->middleware(['auth']);
            Route::get('/refund/{id}', 'FileServicesController@refund')->middleware(['auth']);
            Route::get('/file_services/{id}/tickets', 'TicketsController@customerFileserviceTickets')->middleware(['auth']);
            Route::get('/file_services/{id}/tickets/create', 'TicketsController@fileserviceTicketCreate')->middleware(['auth']);
            Route::post('/file_services/{id}/tickets/create', 'TicketsController@ticketCreate')->middleware(['auth']);
            Route::get('/file_services/{id}/createtickets', 'TicketsController@fileserviceCreateTicket')->middleware(['auth']);
            Route::resource('/file_services', 'FileServicesController')->middleware(['auth']);
            Route::resource('/transactions', 'TransactionsController')->middleware(['auth']);
            Route::resource('/customers', 'CustomersController')->middleware(['auth']);
        });


        Route::get('/', 'TernantLoginController@index')->middleware(['checkrole']);
        Route::get('/register', 'TernantLoginController@register')->name('register')->middleware(['checkrole']);
        Route::post('/register', 'TernantLoginController@store')->name('register');

        Route::resource('/chats', 'ChatsController');
        Route::resource('/gearboxes', 'GearboxesController')->middleware(['auth']);
        Route::resource('/readmethods', 'ReadMethodsController')->middleware(['auth']);
        Route::get('/companyInfo', 'CompaniesController@companyInfo')->name('companyInfo')->middleware(['auth']);
        Route::get('/video', 'CompaniesController@videoPlayer')->name('videoPlayer')->middleware(['auth']);
        Route::get('/delivery-times', 'CompaniesController@deliveryTime')->name('deliveryTime')->middleware(['auth']);
        Route::put('/updateDeliveryTime', 'CompaniesController@updateDeliveryTime')->name('updateDeliveryTime')->middleware(['auth']);

        Route::get('/mail-templates', 'CompaniesController@mail')->name('mail')->middleware(['auth']);
        Route::get('/mail-templates/{id}', 'CompaniesController@mailEdit')->name('mailEdit')->middleware(['auth']);
        Route::put('/mails/{id}', 'CompaniesController@updateMail')->name('updateMail')->middleware(['auth']);
        Route::get('/resend/{id}', 'MailsController@resend')->name('resend')->middleware(['auth']);

        Route::post('/platformsettings', 'CompaniesController@platformsettings')->name('platformsettings')->middleware(['auth']);
        Route::post('/availability', 'CompaniesController@availability')->name('availability')->middleware(['auth']);
        Route::post('/legaldocuments', 'CompaniesController@legaldocuments')->name('legaldocuments')->middleware(['auth']);
        // Route::get('/companies', 'CompaniesController@create')->name('company');
        Route::resource('/companies', 'CompaniesController');
        Route::resource('/packages', 'PackagesController')->middleware(['auth']);
        Route::resource('/sent-mails', 'MailsController')->middleware(['auth']);


        Route::get('/readmethods/{id}/{name}', 'ReadMethodsController@show')->middleware(['auth']);


        Route::resource('/tuning_types', 'TuningTypesController')->middleware(['auth']);
        Route::get('/get-tuning-types', 'TuningTypesController@getTuningTypes')->middleware(['auth']);
        Route::resource('tuning_types.tuning_options', 'TuningOptionsController')->middleware(['auth']);
        Route::get('/tickitFileService', 'FileServicesController@tickitFileService')->name('tickitFileService')->middleware(['auth']);
        Route::resource('/payments', 'PaymentGetawaysController')->middleware(['auth']);
        Route::resource('/orders', 'OrdersController')->middleware(['auth']);
        Route::resource('/invoices', 'InvoicesController')->middleware(['auth']);

        Route::get('/download/invoices/{id}', 'InvoicesController@download')->name('invoices.download')->middleware(['auth']);

        Route::get('/tuning-credits/cancel/{token}', 'TuningCreditsController@cancel');

        Route::get('/buy-credits', 'TuningCreditsController@buyCredits')->name('buy-credits')->middleware(['auth']);
        Route::get('/success/{token}', 'TuningCreditsController@success');
        Route::post('/pay-credits', 'TuningCreditsController@payCredits')->name('pay-credits')->middleware(['auth']);



        Route::get('/files/{id}', 'FileController@show')->middleware(['auth']);
        Route::get('/download_modified/{id}', 'DownloadModifiedController@show')->middleware(['auth']);
        Route::get('/download_dynograph/{id}', 'DownloadDynographController@show')->middleware(['auth']);

        Route::resource('/profile', 'UserProfileController')->middleware(['auth']);
        Route::get('/blockOrUnblock/{id}', 'UserProfileController@blockOrUnblock')->middleware(['auth']);
        Route::resource('/news', 'NewsController')->middleware(['auth']);
        Route::resource('/datatables', 'DatatablesController')->middleware(['auth']);
        Route::resource('/subscriptions', 'SubscriptionsController')->middleware(['auth']);
        Route::resource('/file-sharing', 'FilesSharingCreditsController')->middleware(['auth']);
        Route::resource('vehicles', 'VehicleControllers');



        Route::get('/file-sharing/success/{token}', 'FilesSharingCreditsController@success')->name('success')->middleware(['auth']);
        Route::get('/file-sharing/cancel/{token}', 'FilesSharingCreditsController@cancel')->name('cancel')->middleware(['auth']);

        Route::get('/subscriptions/cancel/{token}', 'SubscriptionsController@cancel')->name('subscriptions.cancel')->middleware(['auth']);
    });
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm');
    Route::post('password/request', 'ResetPasswordController@reset')->name('password.request');
    Route::get('disclaimer', 'LegalController@disclaimer');
    Route::get('privacy-policy', 'LegalController@privacy_policy');
    Route::get('terms-and-conditions', 'LegalController@terms_and_conditions');
    Route::get('refund-policy', 'LegalController@refund_policy');
    Route::get('refund-policy', 'LegalController@refund_policy');

    // Route::post('make', 'VehicleControllers@make')->name('make');
});
