<?php

use Illuminate\Support\Facades\Route;


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
//Auth::routes();

define('PAGINATION_COUNT',6);
Route::group(['namespace'=>'Admin','middleware'=>'guest:admin'],function(){

    Route::get ('login' ,  'LoginController@getLogin')->name('admin.getLogin');
    Route::post('login' ,  'LoginController@Login'   )->name('admin.login');

});
    Route::post('logout',  'Auth\LoginController@logout')->name('logout');




Route::group(['namespace'=>'Admin','middleware'=>'auth:admin'],function(){

    Route::get('/dashboard',       'AdminController@index')     ->name('admin.dashboard');

   ######################### Begin category Route ########################
  Route::group(['prefix'=>'categories'],function(){

    Route::get('/',          'CategoriesController@index')  ->name('admin.categories.index');
    Route::post('/store',    'CategoriesController@store')  ->name('admin.categories.store');
    Route::get('show/{id}',  'CategoriesController@show')  ->name('admin.categories.edit');
    Route::post('/update',   'CategoriesController@update') ->name('admin.categories.update');
    Route::post('/delete',   'CategoriesController@destroy')->name('admin.categories.delete');

            });
   ######################### End category Route ########################

    ######################### Start Post Route ########################
   Route::group(['prefix'=>'posts'],function(){

    Route::get('/',              'PostsController@index')  ->name('admin.posts.index');
    Route::get('/create',        'PostsController@create') ->name('admin.posts.create');
    Route::post('/store',        'PostsController@store')  ->name('admin.posts.store');
    Route::get('edit/{id}',      'PostsController@edit')   ->name('admin.posts.edit');
    Route::post('/update',     'PostsController@update') ->name('admin.posts.update');
    Route::post('/delete',       'PostsController@delete') ->name('admin.posts.delete');

   });
    ############################### end Post Route ########################

     ######################### Begin static pages Route ########################
  Route::group(['prefix'=>'pages'],function(){

    Route::get('/',              'StaticPageController@index')  ->name('admin.pages.index');
    Route::post('/store',        'StaticPageController@store')  ->name('admin.pages.store');
    Route::get('edit/{id}',      'StaticPageController@edit')  ->name('admin.pages.edit');
    Route::post('/update',       'StaticPageController@update') ->name('admin.pages.update');
    Route::post('/delete',       'StaticPageController@destroy')->name('admin.pages.delete');

    });
   ######################### End staticpages Route ########################

   ######################### Start setting Route ########################
    Route::group(['prefix'=>'settings'],function() {
      Route::get('/',             'SettingController@index') ->name('admin.settings.index');
      Route::patch('/update/{id}','SettingController@update')->name('admin.settings.update');
    });
    ######################### End setting Route ########################



   ######################### Start Role Route ########################
    Route::group(['middleware' => ['auth']], function() {
        Route::resource('roles', 'RoleController');
     ######################### End roles Route ########################

     ######################### Start users Route ########################
//        Route::resource('users', 'UserController');
        Route::group(['prefix'=>'users'],function(){
            Route::get('/',                   'UserController@index')  ->name('admin.users.index');
            Route::post('/store',              'UserController@store')  ->name('admin.users.store');
            Route::post('/update',             'UserController@update') ->name('admin.users.update');
            Route::get('/get/{id}',            'UserController@get') ->name('admin.users.get');
            Route::get('/show/{id}',           'UserController@show') ->name('admin.users.show');
            Route::post('/delete',             'UserController@destroy')->name('admin.users.delete');

        });
        Route::get('/user/edit-profile/{id}'   ,'UserController@editProfile'  )->name('users.editProfile');
        Route::post('/user/update-profile'     ,'UserController@updateProfile')->name('users.updateProfile');
        ######################### End users Route ########################

    });
});

