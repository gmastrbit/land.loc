<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// завдяки групі ми визначимо посередників, які будуть використовуватися певних маршрутів
Route::group([], function (){

    // маршрут головної сторінки
    Route::match(['get', 'post'], '/', ['uses' => 'IndexController@execute', 'as' => 'home']);
    Route::get('/page/{alias}', ['uses' => 'PageController@execute', 'as' => 'page']);

    // для аутентифікації користувачів
    Route::auth();
});

// адмін-частина

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){

    // головна сторінка адмінки
    Route::get('/', function(){
        if (view()->exists('admin.index')) {
            $data = ['title' => 'Панель адміністратора'];
            return view('admin.index', $data);
        }
    });

    // admin/pages
    Route::group(['prefix' => 'pages'], function(){

        // маршрут головної сторінки по керування сторінками
        Route::get('/', ['uses' => 'PagesController@execute', 'as' => 'pages']);

        // admin/pages/add
        Route::match(['get', 'post'], '/add', ['uses' => 'PageAddController@execute', 'as' => 'pagesAdd']);

        // admin/edit/2
        // uses => PagesEditController@execute - який метод обробить поточний маршрут
        Route::match(['get', 'post', 'delete'], '/edit/{page}', ['uses' => 'PagesEditController@execute', 'as' => 'pagesEdit']);
    });

    // admin/portfolio
    Route::group(['prefix' => 'portfolios'], function(){

        // маршрут головної сторінки портфоліо
        Route::get('/', ['uses' => 'PortfolioController@execute', 'as' => 'portfolio']);

        Route::match(['get', 'post'], '/add', ['uses' => 'PortfolioAddController@execute', 'as' => 'portfolioAdd']);

        Route::match(['get', 'post', 'delete'], '/edit/{portfolio}', ['uses' => 'PortfolioEditController@execute', 'as' => 'portfolioEdit']);
    });

    // admin/services
    Route::group(['prefix' => 'services'], function(){

        // маршрут головної сторінки портфоліо
        Route::get('/', ['uses' => 'ServiceController@execute', 'as' => 'services']);

        Route::match(['get', 'post'], '/add', ['uses' => 'ServiceAddController@execute', 'as' => 'serviceAdd']);

        Route::match(['get', 'post', 'delete'], '/edit/{service}', ['uses' => 'ServiceEditController@execute', 'as' => 'serviceEdit']);
    });

});