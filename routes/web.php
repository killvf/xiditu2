<?php

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


Route::group(['namespace'=>'Index'], function () {
    Route::get('/', 'IndexController@index');

    Route::any('/upload', 'UploadController@index')->name('upload');

    Route::any('/delpic', 'UploadController@delpic')->name('delpic');

    Route::get('nongye', 'IndexController@ny');

    Route::get('jijin', 'IndexController@jj');

    Route::get('jiaoyu', 'IndexController@jy');

    Route::get('dichan', 'IndexController@dc');

    Route::get('yiliao', 'IndexController@yl');

    Route::get('about', 'IndexController@about');
    
    Route::get('news', 'IndexController@news');

    Route::get('news/{id}', 'IndexController@newsDetail');
});

Route::group(['namespace'=>'Api', 'prefix'=>'api'], function () {
    Route::get('config', 'ConfigController@index');
});


Route::group(['namespace' => 'Admin', 'prefix'=>'admin'], function () {

    Route::any('login', 'LoginController@login')->name('staff.login');
    Route::get('hmac', 'LoginController@hmac')->name('staff.hmac');
    Route::get('logout', 'LoginController@logout')->name('staff.logout');

    //管理员
    Route::group(['middleware'=>'staffAuth'], function () {
        //主页面
        Route::get('/index', 'IndexController@index')->name('staff.index');


         //商品管理
         Route::get('language/modify/{id}', 'LanguageController@modify')->name('staff.language.modify');
         Route::post('language/modify/{id}', 'LanguageController@doModify')->name('staff.language.modify.do');
         Route::get('language', 'LanguageController@lists')->name('staff.language.lists');
         Route::get('language/add', 'LanguageController@add')->name('staff.language.add');
         Route::post('language/add', 'LanguageController@doAdd')->name('staff.language.add.do');
         Route::post('language/delete', 'LanguageController@delete')->name('staff.language.delete');

         //导航管理
        Route::get('nav/modify/{id}', 'NavController@modify')->name('staff.nav.modify');
        Route::post('nav/modify/{id}', 'NavController@doModify')->name('staff.nav.modify.do');
        Route::get('nav', 'NavController@lists')->name('staff.nav.lists');
        Route::get('nav/add', 'NavController@add')->name('staff.nav.add');
        Route::post('nav/add', 'NavController@doAdd')->name('staff.nav.add.do');
        Route::post('nav/delete', 'NavController@delete')->name('staff.nav.delete');

      //招聘管理
        Route::get('invite/modify/{id}', 'InviteController@modify')->name('staff.invite.modify');
        Route::post('invite/modify/{id}', 'InviteController@doModify')->name('staff.invite.modify.do');
        Route::get('invite', 'InviteController@lists')->name('staff.invite.lists');
        Route::get('invite/add', 'InviteController@add')->name('staff.invite.add');
        Route::post('invite/add', 'InviteController@doAdd')->name('staff.invite.add.do');
        Route::post('invite/delete', 'InviteController@delete')->name('staff.invite.delete');


        //文章管理
        Route::get('article/modify/{id}', 'ArticleController@modify')->name('staff.article.modify');
        Route::post('article/modify/{id}', 'ArticleController@doModify')->name('staff.artic`le.modify.do');
        Route::get('article', 'ArticleController@lists')->name('staff.article.lists');
        Route::get('article/add', 'ArticleController@add')->name('staff.article.add');
        Route::post('article/add', 'ArticleController@doAdd')->name('staff.article.add.do');
        Route::post('article/delete', 'ArticleController@delete')->name('staff.article.delete');

        //幻灯片管理
        Route::get('slider/modify/{id}', 'SliderController@modify')->name('staff.slider.modify');
        Route::post('slider/modify/{id}', 'SliderController@doModify')->name('staff.artic`le.modify.do');
        Route::get('slider', 'SliderController@lists')->name('staff.slider.lists');
        Route::get('slider/add', 'SliderController@add')->name('staff.slider.add');
        Route::post('slider/add', 'SliderController@doAdd')->name('staff.slider.add.do');
        Route::post('slider/delete', 'SliderController@delete')->name('staff.slider.delete');

    });
});
