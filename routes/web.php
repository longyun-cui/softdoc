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

    echo("【url()->full()】  --:--  ".url()->full().'<br>');
    echo("【url()->current()】  --:--  ".url()->current().'<br>');
    echo("【url()->previous()】  --:--  ".url()->previous().'<br>');
    echo("【request()->url()】  --:--  ".request()->url().'<br>');
    echo("【request()->path()】  --:--  ".request()->path().'<br>');
    echo("【request()->getUri()】  --:--  ".request()->getUri().'<br>');
    echo("【request()->getRequestUri()】  --:--  ".request()->getRequestUri().'<br>');
    dd();

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

    $controller = "IndexController";

    /*
     * weixin
     */
    Route::group(['prefix' => 'weixin'], function () {

        $wxController = "WeixinController";

        Route::match(['get', 'post'],'auth/MP_verify_0m3bPByLDcHKLvIv.txt', function () {
            return "0m3bPByLDcHKLvIv";
        });

        Route::match(['get', 'post'],'auth/MP_verify_eTPw6Fu85pGY5kiV.txt', function () {
            return "eTPw6Fu85pGY5kiV";
        });

        Route::match(['get', 'post'],'auth', $wxController."@weixin_auth");
        Route::match(['get', 'post'],'login', $wxController."@weixin_login");


        Route::match(['get', 'post'],'gongzhonghao', $wxController."@gongzhonghao");
        Route::match(['get', 'post'],'root', $wxController."@root");
        Route::match(['get', 'post'],'test', $wxController."@test");

    });



    Route::group(['middleware' => 'wechat.share'], function () {

        $controller = "IndexController";

        Route::get('/', $controller.'@view_root');

        Route::group(['middleware' => 'login.turn'], function () {

            $controller = "IndexController";

            Route::get('/home/todolist', $controller.'@view_home_todolist');
            Route::get('/home/schedule', $controller.'@view_home_schedule');

            Route::get('/home/collection', $controller.'@view_home_collection');
            Route::get('/home/favor', $controller.'@view_home_favor');

            Route::get('/home/discovery', $controller.'@view_home_discovery');
            Route::get('/home/follow', $controller.'@view_home_follow');
            Route::get('/home/circle', $controller.'@view_home_circle');


            Route::get('/home/relation/follow', $controller.'@view_relation_follow');
            Route::get('/home/relation/fans', $controller.'@view_relation_fans');

        });

        Route::get('item/{id?}', $controller.'@view_item');

        Route::get('user/{id?}', $controller.'@view_user');
        Route::get('user/{id?}/follow', $controller.'@view_user_follow');
        Route::get('user/{id?}/fans', $controller.'@view_user_fans');

    });


    Route::group(['middleware' => 'login'], function () {

        $controller = "IndexController";

        // 获取日程
        Route::post('ajax/get/schedule', $controller.'@ajax_get_schedule');

        // 收藏
        Route::post('item/add/collection', $controller.'@item_add_collection');
        Route::post('item/remove/collection', $controller.'@item_remove_collection');

        // 点赞
        Route::post('item/add/favor', $controller.'@item_add_favor');
        Route::post('item/remove/favor', $controller.'@item_remove_favor');

        // 待办事
        Route::post('item/add/todolist', $controller.'@item_add_todolist');
        Route::post('item/remove/todolist', $controller.'@item_remove_todolist');

        // 日程
        Route::post('item/add/schedule', $controller.'@item_add_schedule');
        Route::post('item/remove/schedule', $controller.'@item_remove_schedule');


        Route::post('item/comment/save', $controller.'@item_comment_save');
        Route::post('item/reply/save', $controller.'@item_reply_save');

        Route::post('item/comment/favor/save', $controller.'@item_comment_favor_save');
        Route::post('item/comment/favor/cancel', $controller.'@item_comment_favor_cancel');

        Route::post('user/relation/add', $controller.'@user_relation_add');
        Route::post('user/relation/remove', $controller.'@user_relation_remove');

        Route::post('item/forward', $controller.'@item_forward');

    });

    Route::post('item/comment/get', $controller.'@item_comment_get');
    Route::post('item/comment/get_html', $controller.'@item_comment_get_html');
    Route::post('item/reply/get', $controller.'@item_reply_get');

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

        Route::get('/404', $controller.'@view_404');

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

