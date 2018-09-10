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

Route::get('/', function () {
    return view('welcome');
});


/*
 * Common 通用功能
 */
Route::group(['prefix' => 'common'], function () {

    $controller = "CommonController";

    // 验证码
    Route::match(['get','post'], 'change_captcha', $controller.'@change_captcha');

    //
    Route::get('dataTableI18n', function () {
        return trans('pagination.i18n');
    });
});





/*
 * Root Frontend
 */
Route::group(['namespace' => 'Front'], function () {


    /*
     * weixin
     */
    Route::group(['prefix' => 'weixin'], function () {

        $controller = "WeixinController";

        Route::match(['get', 'post'],'auth/MP_verify_0m3bPByLDcHKLvIv.txt', function () {
            return "0m3bPByLDcHKLvIv";
        });

        Route::match(['get', 'post'],'auth/MP_verify_eTPw6Fu85pGY5kiV.txt', function () {
            return "eTPw6Fu85pGY5kiV";
        });

        Route::match(['get', 'post'],'auth', $controller."@weixin_auth");
        Route::match(['get', 'post'],'login', $controller."@weixin_login");


        Route::match(['get', 'post'],'gongzhonghao', $controller."@gongzhonghao");
        Route::match(['get', 'post'],'root', $controller."@root");
        Route::match(['get', 'post'],'test', $controller."@test");

    });



    Route::group(['middleware' => 'wechat.share'], function () {

//        Route::get('/', function () {
//            return redirect('/courses');
//        });
        Route::get('/', 'RootController@view_root');

        Route::group(['middleware' => 'login.turn'], function () {

            Route::get('/home/todolist', 'RootController@view_home_todolist');
            Route::get('/home/schedule', 'RootController@view_home_schedule');

            Route::get('/home/collection', 'RootController@view_home_collection');
            Route::get('/home/favor', 'RootController@view_home_favor');

        });

        Route::get('/home/discovery', 'RootController@view_home_discovery');
        Route::get('/home/circle', 'RootController@view_home_circle');

        Route::get('item/{id?}', 'RootController@view_item');

        Route::get('user/{id?}', 'RootController@view_user');




    });


    Route::group(['middleware' => 'login'], function () {

        // 收藏
        Route::post('item/add/collection', 'RootController@item_add_collection');
        Route::post('item/remove/collection', 'RootController@item_remove_collection');

        // 点赞
        Route::post('item/add/favor', 'RootController@item_add_favor');
        Route::post('item/remove/favor', 'RootController@item_remove_favor');

        // 待办事
        Route::post('item/add/todolist', 'RootController@item_add_todolist');
        Route::post('item/remove/todolist', 'RootController@item_remove_todolist');

        // 日程
        Route::post('item/add/schedule', 'RootController@item_add_schedule');
        Route::post('item/remove/schedule', 'RootController@item_remove_schedule');


        Route::post('item/comment/save', 'RootController@item_comment_save');
        Route::post('item/reply/save', 'RootController@item_reply_save');

        Route::post('item/comment/favor/save', 'RootController@item_comment_favor_save');
        Route::post('item/comment/favor/cancel', 'RootController@item_comment_favor_cancel');

    });

    Route::post('item/comment/get', 'RootController@item_comment_get');
    Route::post('item/comment/get_html', 'RootController@item_comment_get_html');
    Route::post('item/reply/get', 'RootController@item_reply_get');

});


/*
 * auth
 */
Route::match(['get','post'], 'login', 'Home\AuthController@user_login');
Route::match(['get','post'], 'logout', 'Home\AuthController@user_logout');
Route::match(['get','post'], 'register', 'Home\AuthController@user_register');
Route::match(['get','post'], 'activation', 'Home\AuthController@activation');



/*
 * Home Backend
 */
Route::group(['prefix' => 'home', 'namespace' => 'Home'], function () {

    /*
     * 需要登录
     */
    Route::group(['middleware' => ['home','notification']], function () {

        $controller = 'HomeController';

        Route::get('/', $controller.'@index');


        // 【info】
        Route::group(['prefix' => 'info'], function () {

            $controller = 'HomeController';

            Route::get('index', $controller.'@info_index');
            Route::match(['get','post'], 'edit', $controller.'@infoEditAction');

            Route::match(['get','post'], 'password/reset', $controller.'@passwordResetAction');

        });


        // 作者
        Route::group(['prefix' => 'item'], function () {

            $controller = 'ItemController';

            Route::get('/', $controller.'@index');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('enable', $controller.'@enableAction');
            Route::post('disable', $controller.'@disableAction');

            // 书目类型
            Route::group(['prefix' => 'content'], function () {

                $controller = 'ContentController';

                Route::match(['get','post'], '/', $controller.'@content_viewIndex');
                Route::match(['get','post'], 'edit', $controller.'@content_editAction');
                Route::post('get', $controller.'@content_getAction');
                Route::post('delete', $controller.'@content_deleteAction');

            });

            // 时间线类型
            Route::group(['prefix' => 'point'], function () {

                $controller = 'PointController';

                Route::match(['get','post'], '/', $controller.'@viewList');
                Route::get('create', $controller.'@createAction');
                Route::match(['get','post'], 'edit', $controller.'@editAction');
                Route::match(['get','post'], 'list', $controller.'@viewList');
                Route::post('delete', $controller.'@deleteAction');
                Route::post('enable', $controller.'@enableAction');
                Route::post('disable', $controller.'@disableAction');

            });

            Route::get('select2_menus', $controller.'@select2_menus');

        });


        // 作者
        Route::group(['prefix' => 'course'], function () {

            $controller = 'CourseController';

            Route::get('/', $controller.'@index');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('enable', $controller.'@enableAction');
            Route::post('disable', $controller.'@disableAction');

            // 作者
            Route::group(['prefix' => 'content'], function () {

                $controller = 'CourseController';

                Route::match(['get','post'], '/', $controller.'@course_content_view_index');
                Route::match(['get','post'], 'edit', $controller.'@course_content_editAction');
                Route::post('get', $controller.'@course_content_getAction');
                Route::post('delete', $controller.'@course_content_deleteAction');
            });

            Route::get('select2_menus', $controller.'@select2_menus');

        });



        // 收藏
        Route::group(['prefix' => 'collect'], function () {

            $controller = 'OtherController';

            Route::match(['get','post'], 'course/list', $controller.'@collect_course_viewList');
            Route::match(['get','post'], 'chapter/list', $controller.'@collect_chapter_viewList');
            Route::post('course/delete', $controller.'@collect_course_deleteAction');
            Route::post('chapter/delete', $controller.'@collect_chapter_deleteAction');

        });

        // 点赞
        Route::group(['prefix' => 'favor'], function () {

            $controller = 'OtherController';

            Route::match(['get','post'], 'course/list', $controller.'@favor_course_viewList');
            Route::match(['get','post'], 'chapter/list', $controller.'@favor_chapter_viewList');
            Route::post('course/delete', $controller.'@favor_course_deleteAction');
            Route::post('chapter/delete', $controller.'@favor_chapter_deleteAction');

        });

        // 消息
        Route::group(['prefix' => 'notification'], function () {

            $controller = 'NotificationController';

            Route::get('comment', $controller.'@comment');
            Route::get('favor', $controller.'@favor');

        });


    });

});

