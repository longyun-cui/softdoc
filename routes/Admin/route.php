<?php


/*
 * 超级后台
 */
Route::group([], function () {


    // 注册登录
    Route::group([], function () {

        $controller = "AuthController";

        Route::match(['get','post'], 'login', $controller.'@login');
        Route::match(['get','post'], 'logout', $controller.'@logout');

    });


    // 后台管理，需要登录
    Route::group(['middleware' => 'admin'], function () {

        $controller = "IndexController";

        Route::get('/sql-init', $controller.'@sql_init');

        Route::get('/', $controller.'@index');
        Route::get('index', $controller.'@index');


        Route::fallback(function(){
            return response()->view(env('TEMPLATE_ADMIN').'admin.errors.404');
        });


        /*
         * info
         */
        Route::match(['get','post'], '/info/', $controller.'@view_info_index');
        Route::match(['get','post'], '/info/index', $controller.'@view_info_index');
        Route::match(['get','post'], '/info/edit', $controller.'@operate_info_edit');
        Route::match(['get','post'], '/info/password-reset', $controller.'@operate_info_password_reset');




        /*
         * user
         */
        Route::match(['get','post'], '/user/select2_user', $controller.'@operate_user_select2_user');

        Route::match(['get','post'], '/user/user-create', $controller.'@operate_user_user_create');
        Route::match(['get','post'], '/user/user-edit', $controller.'@operate_user_user_edit');

        Route::match(['get','post'], '/user/user-all-list', $controller.'@view_user_all_list');
        Route::match(['get','post'], '/user/user-org-list', $controller.'@view_user_org_list');
        Route::match(['get','post'], '/user/user-sponsor-list', $controller.'@view_user_sponsor_list');
        Route::match(['get','post'], '/user/user-individual-list', $controller.'@view_user_individual_list');

        Route::match(['get','post'], '/user/user-login', $controller.'@operate_user_user_login');
        Route::match(['get','post'], '/user/org-login', $controller.'@operate_user_org_login');
        Route::match(['get','post'], '/user/sponsor-login', $controller.'@operate_user_sponsor_login');

        Route::match(['get','post'], '/user/org-delete', $controller.'@operate_user_org_delete');

        Route::match(['get','post'], '/user/user-admin-disable', $controller.'@operate_user_admin_disable');
        Route::match(['get','post'], '/user/user-admin-enable', $controller.'@operate_user_admin_enable');


        Route::match(['get','post'], '/user/change-password', $controller.'@operate_user_change_password');




        /*
         * business
         */
        // item
        Route::match(['get','post'], '/item/item-list', $controller.'@view_item_item_list');
        Route::match(['get','post'], '/item/item-all-list', $controller.'@view_item_all_list');
        Route::match(['get','post'], '/item/item-article-list', $controller.'@view_item_article_list');
        Route::match(['get','post'], '/item/item-activity-list', $controller.'@view_item_activity_list');
        Route::match(['get','post'], '/item/item-advertising-list', $controller.'@view_item_advertising_list');

        Route::match(['get','post'], '/item/item-my-list', $controller.'@view_item_my_list');


        Route::match(['get','post'], '/item/item-create', $controller.'@operate_item_item_create');
        Route::match(['get','post'], '/item/item-edit', $controller.'@operate_item_item_edit');


        Route::match(['get','post'], '/item/item-get', $controller.'@operate_item_item_get');
        Route::match(['get','post'], '/item/item-delete', $controller.'@operate_item_item_delete');
        Route::match(['get','post'], '/item/item-publish', $controller.'@operate_item_item_publish');

        Route::match(['get','post'], '/item/item-admin-disable', $controller.'@operate_item_admin_disable');
        Route::match(['get','post'], '/item/item-admin-enable', $controller.'@operate_item_admin_enable');





        Route::match(['get','post'], '/user/agent-list', $controller.'@view_user_agent_list');
        Route::match(['get','post'], '/user/client-list', $controller.'@view_user_client_list');

        Route::match(['get','post'], '/user/client-login', $controller.'@operate_user_client_login');

        Route::match(['get','post'], '/user/agent', $controller.'@view_user_agent');
        Route::match(['get','post'], '/user/client', $controller.'@view_user_client');

        Route::match(['get','post'], '/user/agent/client-list', $controller.'@view_user_agent_client_list');
        Route::match(['get','post'], '/user/client/keyword-list', $controller.'@view_user_client_keyword_list');

        Route::match(['get','post'], '/user/agent-recharge', $controller.'@operate_user_agent_recharge');
        Route::match(['get','post'], '/user/agent-recharge-limit-close', $controller.'@operate_user_agent_recharge_limit_close');
        Route::match(['get','post'], '/user/agent-recharge-limit-open', $controller.'@operate_user_agent_recharge_limit_open');
        Route::match(['get','post'], '/user/agent-sub-agent-close', $controller.'@operate_user_agent_sub_agent_close');
        Route::match(['get','post'], '/user/agent-sub-agent-open', $controller.'@operate_user_agent_sub_agent_open');

        Route::match(['get','post'], '/user/client-delete', $controller.'@operate_user_client_delete');




        /*
         * business
         */


        // site
        Route::match(['get','post'], '/business/site-list', $controller.'@view_business_site_list');
        Route::match(['get','post'], '/business/site-todo', $controller.'@view_business_site_todo_list');

        Route::match(['get','post'], '/business/site-review', $controller.'@operate_business_site_review');
        Route::match(['get','post'], '/business/site-review-bulk', $controller.'@operate_business_site_review_bulk');

        Route::match(['get','post'], '/business/site-todo-delete', $controller.'@operate_business_site_todo_delete');
        Route::match(['get','post'], '/business/site-todo-delete-bulk', $controller.'@operate_business_site_todo_delete_bulk');

        Route::match(['get','post'], '/business/site-get', $controller.'@operate_business_site_get');
        Route::match(['get','post'], '/business/site-delete', $controller.'@operate_business_site_delete');
        Route::match(['get','post'], '/business/site-stop', $controller.'@operate_business_site_stop');
        Route::match(['get','post'], '/business/site-start', $controller.'@operate_business_site_start');
        Route::match(['get','post'], '/business/site-edit', $controller.'@operate_business_site_edit');




        // work-order
        Route::match(['get','post'], '/business/site/work-order-create', $controller.'@operate_business_site_work_order_create');
        Route::match(['get','post'], '/business/site/work-order-edit', $controller.'@operate_business_site_work_order_edit');
        Route::match(['get','post'], '/business/site/work-order-list', $controller.'@view_business_site_work_order_list');

        Route::match(['get','post'], '/business/work-order-list', $controller.'@view_business_work_order_list');
        Route::match(['get','post'], '/business/work-order-get', $controller.'@operate_business_work_order_get');
        Route::match(['get','post'], '/business/work-order-push', $controller.'@operate_business_work_order_push');
        Route::match(['get','post'], '/business/work-order-delete', $controller.'@operate_business_work_order_delete');




        // keyword
        Route::match(['get','post'], '/business/keyword-search', $controller.'@operate_keyword_search');
        Route::match(['get','post'], '/business/keyword-recommend', $controller.'@operate_keyword_recommend');
        Route::match(['get','post'], '/business/keyword-search-export', $controller.'@operate_keyword_search_export');

        Route::match(['get','post'], '/business/keyword-list', $controller.'@view_business_keyword_list');
        Route::match(['get','post'], '/business/keyword-today', $controller.'@view_business_keyword_today_list');
        Route::match(['get','post'], '/business/keyword-today-newly', $controller.'@view_business_keyword_today_newly_list');
        Route::match(['get','post'], '/business/keyword-anomaly', $controller.'@view_business_keyword_anomaly_list');
        Route::match(['get','post'], '/business/keyword-todo', $controller.'@view_business_keyword_todo_list');
        Route::match(['get','post'], '/business/keyword-detect-record', $controller.'@view_business_keyword_detect_record');


        Route::match(['get','post'], '/business/keyword-review', $controller.'@operate_business_keyword_review');
        Route::match(['get','post'], '/business/keyword-review-bulk', $controller.'@operate_business_keyword_review_bulk');

        Route::match(['get','post'], '/business/keyword-todo-delete', $controller.'@operate_business_keyword_todo_delete');
        Route::match(['get','post'], '/business/keyword-todo-delete-bulk', $controller.'@operate_business_keyword_todo_delete_bulk');

        Route::match(['get','post'], '/business/keyword-get', $controller.'@operate_business_keyword_get');
        Route::match(['get','post'], '/business/keyword-delete', $controller.'@operate_business_keyword_delete');
        Route::match(['get','post'], '/business/keyword-delete-bulk', $controller.'@operate_business_keyword_delete_bulk');
        Route::match(['get','post'], '/business/keyword-stop', $controller.'@operate_business_keyword_stop');
        Route::match(['get','post'], '/business/keyword-start', $controller.'@operate_business_keyword_start');

        Route::match(['get','post'], '/business/keyword-detect-create-rank', $controller.'@operate_business_keyword_detect_create_rank');
        Route::match(['get','post'], '/business/keyword-detect-set-rank', $controller.'@operate_business_keyword_detect_set_rank');
        Route::match(['get','post'], '/business/keyword-detect-set-rank-bulk', $controller.'@operate_business_keyword_detect_set_rank_bulk');


        Route::match(['get','post'], '/business/download/', $controller.'@operate_download');
        Route::match(['get','post'], '/business/download/keyword-today', $controller.'@operate_download_keyword_today');
        Route::match(['get','post'], '/business/download/keyword-detect', $controller.'@operate_download_keyword_detect');




        /*
         * finance
         */
        Route::match(['get','post'], '/finance/overview', $controller.'@view_finance_overview');
        Route::match(['get','post'], '/finance/overview-month', $controller.'@view_finance_overview_month');
        Route::match(['get','post'], '/finance/recharge-record', $controller.'@view_finance_recharge_record');
        Route::match(['get','post'], '/finance/expense-record', $controller.'@view_finance_expense_record');
        Route::match(['get','post'], '/finance/expense-record-daily', $controller.'@view_finance_expense_record_daily');
        Route::match(['get','post'], '/finance/freeze-record', $controller.'@view_finance_freeze_record');




        /*
         * notice
         */
        Route::match(['get','post'], '/notice/notice-create', $controller.'@operate_notice_notice_create');
        Route::match(['get','post'], '/notice/notice-edit', $controller.'@operate_notice_notice_edit');

        Route::match(['get','post'], '/notice/notice-list', $controller.'@view_notice_notice_list');
        Route::match(['get','post'], '/notice/my-notice-list', $controller.'@view_notice_my_notice_list');
        Route::match(['get','post'], '/notice/notice-get', $controller.'@operate_notice_notice_get');
        Route::match(['get','post'], '/notice/notice-push', $controller.'@operate_notice_notice_push');
        Route::match(['get','post'], '/notice/notice-delete', $controller.'@operate_notice_notice_delete');



    });


});
