<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * API Routes
 */


Route::group(['namespace' => 'Api', 'as' => 'api'], function () {

    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');

        Route::post('/companyInfo', 'CompaniesController@companyInfo')->name('companyInfo');
        // Route::post('/news/store', 'NewsController@store');
        // Route::patch('/news/update/{id}', 'NewsController@update');
        Route::apiResource('/news', 'NewsController');

        Route::apiResource('/transactions', 'TransactionsController');

        Route::get('/customers/{id}/file_services', 'FileServicesController@customerFileservice');
        Route::get('/file_services/{id}/tickets', 'TicketsController@customerFileserviceTickets');
        Route::get('/file_services/{id}/tickets/create', 'TicketsController@fileserviceTicketCreate');
        Route::post('/file_services/{id}/tickets/create', 'TicketsController@ticketCreate');
        Route::get('/file_services/{id}/createtickets', 'TicketsController@fileserviceCreateTicket');
        Route::get('/file_services', 'FileServicesController@index');
        Route::get('/file_services/create', 'FileServicesController@create');
        Route::post('/file_services', 'FileServicesController@store');

        // Route::get('/tickets', 'TicketsController@index');
        Route::get('/tickets/create', 'TicketsController@create');
        // Route::post('/tickets/store', 'TicketsController@store');
        // Route::apiResource('/file_services', 'FileServicesController');
        Route::get('/dashboard', 'CustomersController@dashboard');

        Route::post('comments', 'CommentController@store')->name('comments');
        Route::apiResource('/comments', 'CommentController');
        Route::apiResource('/tickets', 'TicketsController');
        Route::get('/category/{name}', 'TicketsController@category');
        Route::get('tuning_options/{tuning_type_id}', 'TuningOptionsController@show');
        Route::post('profile', 'AuthController@store');

        Route::resource('/tuning-credits', 'TuningCreditsController');
        Route::post('/pay-credits', 'TuningCreditsController@payCredits');

        Route::get('admin/dashboard', 'AdminDashboardController@adminDashboard')->name('admin/dashboard');
        Route::resource('/customers', 'CustomersController');
    });
    Route::get('/files_download/original_file/{id}', 'FilesDownloadController@originalFile');
    Route::get('/email_files_download/{id}', 'FilesDownloadController@emailFileServiceLink');
    Route::get('/comment_files_download/{id}', 'FilesDownloadController@emailCommentLink');
});
