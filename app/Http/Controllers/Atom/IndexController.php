<?php
namespace App\Http\Controllers\Atom;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\Doc\Doc_Item;

use App\Repositories\Atom\IndexRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode;

class IndexController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
        $this->repo = new IndexRepository;
    }


    // 返回【主页】视图
    public function index()
    {
        return $this->repo->view_atom_index();
    }





    /*
     * 用户基本信息
     */

    // 【基本信息】返回-视图
    public function view_info_index()
    {
        return $this->repo->view_info_index();
    }

    // 【基本信息】编辑
    public function operate_info_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_info_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_info_save(request()->all());
    }
    // 【基本信息】修改-密码
    public function operate_info_password_reset()
    {
        if(request()->isMethod('get')) return $this->repo->view_info_password_reset();
        else if (request()->isMethod('post')) return $this->repo->operate_info_password_reset_save(request()->all());
    }




    /*
     * 用户系统
     */

    // 【代理商&客户】修改-密码
    public function operate_user_change_password()
    {
        return $this->repo->operate_user_change_password(request()->all());
    }

    // 【代理商】SELECT2
    public function operate_business_select2_agent()
    {
        return $this->repo->operate_business_select2_agent(request()->all());
    }


    // 【用户】[组织]返回-列表-视图
    public function view_user_all_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_user_all_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_user_all_list_datatable(request()->all());
    }




    /*
     * 业务系统
     */
    // 【K】【内容】返回-列表-视图
    public function view_item_item_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_item_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_item_datatable(request()->all());
    }
    // 【K】【内容】返回-全部内容-列表-视图
    public function view_item_all_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_all_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_all_datatable(request()->all());
    }
    // 【K】【内容】返回-列表-视图
    public function view_item_people_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_people_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_people_datatable(request()->all());
    }
    // 【K】【内容】返回-列表-视图
    public function view_item_object_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_object_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_object_datatable(request()->all());
    }
    // 【K】【内容】返回-列表-视图
    public function view_item_product_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_product_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_product_datatable(request()->all());
    }

    // 【K】【内容】返回-全部内容-列表-视图
    public function view_item_event_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_event_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_event_datatable(request()->all());
    }

    // 【K】【内容】返回-全部内容-列表-视图
    public function view_item_conception_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_conception_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_conception_datatable(request()->all());
    }


    // 【K】【ITEM】添加
    public function operate_item_item_create()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_item_create(request()->all());
        else if (request()->isMethod('post')) return $this->repo->operate_item_item_save(request()->all());
    }
    // 【K】【ITEM】编辑
    public function operate_item_item_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_item_edit(request()->all());
        else if (request()->isMethod('post')) return $this->repo->operate_item_item_save(request()->all());
    }




    // 【内容】获取-详情
    public function operate_item_item_get()
    {
        return $this->repo->operate_item_item_get(request()->all());
    }
    // 【内容】删除
    public function operate_item_item_delete()
    {
        return $this->repo->operate_item_item_delete(request()->all());
    }
    // 【内容】发布
    public function operate_item_item_publish()
    {
        return $this->repo->operate_item_item_publish(request()->all());
    }




    // 【内容】禁用
    public function operate_item_admin_disable()
    {
        return $this->repo->operate_item_admin_disable(request()->all());
    }
    // 【内容】解禁
    public function operate_item_admin_enable()
    {
        return $this->repo->operate_item_admin_enable(request()->all());
    }








    // 【代理商】返回-详情页
    public function view_user_agent()
    {
        if(request()->isMethod('get')) return $this->repo->view_user_agent(request()->all());
        else if (request()->isMethod('post')) return $this->repo->get_user_client_list_datatable(request()->all());
    }

    // 【代理商】返回-详情页-客户列表
    public function view_user_agent_client_list()
    {
        if(request()->isMethod('get'))
        {
//            return view('mt.admin.entrance.user.agent-list')->with(['sidebar_agent_list_active'=>'active menu-open']);
        }
        else if(request()->isMethod('post')) return $this->repo->get_user_agent_client_list_datatable(request()->all());
    }






    // 【代理商】充值-1级代理商
    public function operate_user_agent_recharge()
    {
        return $this->repo->operate_user_agent_recharge(request()->all());
    }


    // 【代理商】关闭-充值限制
    public function operate_user_agent_recharge_limit_close()
    {
        return $this->repo->operate_user_agent_recharge_limit_close(request()->all());
    }
    // 【代理商】开启-充值限制
    public function operate_user_agent_recharge_limit_open()
    {
        return $this->repo->operate_user_agent_recharge_limit_open(request()->all());
    }

    // 【代理商】关闭-二级代理商
    public function operate_user_agent_sub_agent_close()
    {
        return $this->repo->operate_user_agent_sub_agent_close(request()->all());
    }
    // 【代理商】开启-二级代理商
    public function operate_user_agent_sub_agent_open()
    {
        return $this->repo->operate_user_agent_sub_agent_open(request()->all());
    }






    // 【客户】返回-列表-视图
    public function view_user_client_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_user_client_list();
        else if(request()->isMethod('post')) return $this->repo->get_user_client_list_datatable(request()->all());
    }

    // 【客户】返回-详情页
    public function view_user_client()
    {
        if(request()->isMethod('get')) return $this->repo->view_user_client(request()->all());
        else if (request()->isMethod('post')) return $this->repo->get_user_client_list_datatable(request()->all());
    }
    // 【客户】返回-详情页-关键词列表
    public function view_user_client_keyword_list()
    {
        if(request()->isMethod('get'))
        {
//            return view('mt.admin.entrance.user.client-list')->with(['sidebar_client_list_active'=>'active menu-open']);
        }
        else if(request()->isMethod('post')) return $this->repo->get_user_client_keyword_list_datatable(request()->all());
    }

    // 【客户】登录
    public function operate_user_client_login()
    {
        $client_id = request()->get('id');
        $client = User::where('id',$client_id)->first();
        Auth::guard('client')->login($client,true);
        return response_success();
    }
    // 【客户】删除
    public function operate_user_client_delete()
    {
        return $this->repo->operate_user_client_delete(request()->all());
    }













    /*
     * 业务系统
     */
    // 【站点】返回-列表-视图
    public function view_business_site_list()
    {
        if(request()->isMethod('get'))
        {
            return view('mt.admin.entrance.business.site-list')
                ->with([
                    'sidebar_business_site_active'=>'active',
                    'sidebar_business_site_list_active'=>'active'
                ]);
        }
        else if(request()->isMethod('post')) return $this->repo->get_business_site_list_datatable(request()->all());
    }
    // 【站点】返回-待审核列表-视图
    public function view_business_site_todo_list()
    {
        if(request()->isMethod('get'))
        {
            return view('mt.admin.entrance.business.site-todo-list')
                ->with([
                    'sidebar_business_keyword_active'=>'active',
                    'sidebar_business_site_todo_active'=>'active'
                ]);
        }
        else if(request()->isMethod('post')) return $this->repo->get_business_site_todo_list_datatable(request()->all());
    }




    // 【关键词】返回-查询-视图
    public function operate_keyword_search()
    {
        if(request()->isMethod('get')) return $this->repo->view_business_keyword_search();
        else if (request()->isMethod('post')) return $this->repo->operate_business_keyword_search(request()->all());
    }
    // 【关键词】返回-推荐-视图
    public function operate_keyword_recommend()
    {
        return $this->repo->operate_business_keyword_recommend(request()->all());
    }
    // 【关键词】导出-查询-结果
    public function operate_keyword_search_export()
    {
        return $this->repo->operate_business_keyword_search_export(request()->all());
    }


    // 【关键词】返回-列表-视图
    public function view_business_keyword_list()
    {
        if(request()->isMethod('get')) return $this->repo->show_business_keyword_list();
        else if(request()->isMethod('post')) return $this->repo->get_business_keyword_list_datatable(request()->all());
    }

    // 【今日关键词】返回-列表-视图
    public function view_business_keyword_today_list()
    {
        if(request()->isMethod('get')) return $this->repo->show_business_keyword_today_list();
        else if(request()->isMethod('post')) return $this->repo->get_business_keyword_today_list_datatable(request()->all());
    }

    // 【今日关键词】返回-列表-视图
    public function view_business_keyword_today_newly_list()
    {
        if(request()->isMethod('get')) return $this->repo->show_business_keyword_today_newly_list();
        else if(request()->isMethod('post')) return $this->repo->get_business_keyword_today_newly_list_datatable(request()->all());
    }

    // 【异常关键词】返回-列表-视图
    public function view_business_keyword_anomaly_list()
    {
        if(request()->isMethod('get')) return $this->repo->show_business_keyword_anomaly_list();
        else if(request()->isMethod('post')) return $this->repo->get_business_keyword_anomaly_list_datatable(request()->all());
    }

    // 【待审核关键词】返回-列表-视图
    public function view_business_keyword_todo_list()
    {
        if(request()->isMethod('get'))
        {
            return view('mt.admin.entrance.business.keyword-todo-list')
                ->with([
                    'sidebar_business_keyword_active'=>'active',
                    'sidebar_business_keyword_todo_active'=>'active'
                ]);
        }
        else if(request()->isMethod('post')) return $this->repo->get_business_keyword_todo_list_datatable(request()->all());
    }




    // 【关键词检测记录】返回-列表-视图
    public function view_business_keyword_detect_record()
    {
        if(request()->isMethod('get')) return $this->repo->show_business_keyword_detect_record(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_business_keyword_detect_record_datatable(request()->all());
    }

    // 【关键词检测记录】添加
    public function operate_business_keyword_detect_create_rank()
    {
        return $this->repo->operate_business_keyword_detect_create_rank(request()->all());
    }

    // 【关键词检测记录】修改
    public function operate_business_keyword_detect_set_rank()
    {
        return $this->repo->operate_business_keyword_detect_set_rank(request()->all());
    }

    // 【关键词检测记录】批量修改
    public function operate_business_keyword_detect_set_rank_bulk()
    {
        return $this->repo->operate_business_keyword_detect_set_rank_bulk(request()->all());
    }





    // 【站点】审核
    public function operate_business_site_review()
    {
        return $this->repo->operate_business_site_review(request()->all());
    }
    // 【站点】批量审核
    public function operate_business_site_review_bulk()
    {
        return $this->repo->operate_business_site_review_bulk(request()->all());
    }

    // 【待选站点】删除
    public function operate_business_site_todo_delete()
    {
        return $this->repo->operate_business_site_todo_delete(request()->all());
    }
    // 【待选站点】批量删除
    public function operate_business_site_todo_delete_bulk()
    {
        return $this->repo->operate_business_site_todo_delete_bulk(request()->all());
    }


    // 【站点】获取-详情
    public function operate_business_site_get()
    {
        return $this->repo->operate_business_site_get(request()->all());
    }
    // 【站点】删除
    public function operate_business_site_delete()
    {
        return $this->repo->operate_business_site_delete(request()->all());
    }
    // 【站点】合作停
    public function operate_business_site_stop()
    {
        return $this->repo->operate_business_site_stop(request()->all());
    }
    // 【站点】再合作
    public function operate_business_site_start()
    {
        return $this->repo->operate_business_site_start(request()->all());
    }
    // 【站点】编辑
    public function operate_business_site_edit()
    {
        return $this->repo->operate_business_site_save(request()->all());
    }




    // 【关键词】审核
    public function operate_business_keyword_review()
    {
        return $this->repo->operate_business_keyword_review(request()->all());
    }
    // 【关键词】批量审核
    public function operate_business_keyword_review_bulk()
    {
        return $this->repo->operate_business_keyword_review_bulk(request()->all());
    }

    // 【待选关键词】删除
    public function operate_business_keyword_todo_delete()
    {
        return $this->repo->operate_business_keyword_todo_delete(request()->all());
    }
    // 【待选关坚持】批量删除
    public function operate_business_keyword_todo_delete_bulk()
    {
        return $this->repo->operate_business_keyword_todo_delete_bulk(request()->all());
    }


    // 【关键词】获取-详情
    public function operate_business_keyword_get()
    {
        return $this->repo->operate_business_keyword_get(request()->all());
    }
    // 【关键词】删除
    public function operate_business_keyword_delete()
    {
        return $this->repo->operate_business_keyword_delete(request()->all());
    }
    // 【关键词】批量删除
    public function operate_business_keyword_delete_bulk()
    {
        return $this->repo->operate_business_keyword_delete_bulk(request()->all());
    }
    // 【关键词】合作停
    public function operate_business_keyword_stop()
    {
        return $this->repo->operate_business_keyword_stop(request()->all());
    }
    // 【关键词】再合作
    public function operate_business_keyword_start()
    {
        return $this->repo->operate_business_keyword_start(request()->all());
    }




    /*
     * 工单管理
     */
    // 【站点工单】添加
    public function operate_business_site_work_order_create()
    {
        if(request()->isMethod('get')) return $this->repo->view_business_site_work_order_create(request()->all());
        else if (request()->isMethod('post')) return $this->repo->operate_business_site_work_order_save(request()->all());
    }
    // 【站点工单】编辑
    public function operate_business_site_work_order_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_business_site_work_order_edit(request()->all());
        else if (request()->isMethod('post')) return $this->repo->operate_business_site_work_order_save(request()->all());
    }


    // 【站点工单】返回-列表-视图
    public function view_business_site_work_order_list()
    {
        if(request()->isMethod('get')) return $this->repo->show_business_site_work_order_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_business_site_work_order_datatable(request()->all());
    }


    // 【工单】返回-列表-视图
    public function view_business_work_order_list()
    {
        if(request()->isMethod('get')) return $this->repo->show_business_work_order_list();
        else if(request()->isMethod('post')) return $this->repo->get_business_work_order_list_datatable(request()->all());
    }
    // 【工单】获取详情
    public function operate_business_work_order_get()
    {
        return $this->repo->operate_business_work_order_get(request()->all());
    }
    // 【工单】推送
    public function operate_business_work_order_push()
    {
        return $this->repo->operate_business_work_order_push(request()->all());
    }
    // 【工单】删除
    public function operate_business_work_order_delete()
    {
        return $this->repo->operate_business_work_order_delete(request()->all());
    }




    /*
     * 财务系统
     */
    // 【财务概览】返回-列表-视图
    public function view_finance_overview()
    {
        if(request()->isMethod('get')) return $this->repo->show_finance_overview();
        else if(request()->isMethod('post')) return $this->repo->get_finance_overview_datatable(request()->all());
    }
    // 【财务概览】返回-列表-视图
    public function view_finance_overview_month()
    {
        if(request()->isMethod('get')) return $this->repo->show_finance_overview_month(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_finance_overview_month_datatable(request()->all());
    }

    // 【充值记录】返回-列表-视图
    public function view_finance_recharge_record()
    {
        if(request()->isMethod('get'))
        {
            return view('mt.admin.entrance.finance.recharge-record')
                ->with(['sidebar_finance_active'=>'active','sidebar_finance_recharge_active'=>'active']);
        }
        else if(request()->isMethod('post')) return $this->repo->get_finance_recharge_record_datatable(request()->all());
    }

    // 【消费记录】返回-列表-视图
    public function view_finance_expense_record()
    {

        if(request()->isMethod('get'))
        {
            return view('mt.admin.entrance.finance.expense-record')
                ->with(['sidebar_finance_active'=>'active','sidebar_finance_expense_active'=>'active']);
        }
        else if(request()->isMethod('post')) return $this->repo->get_finance_expense_record_datatable(request()->all());
    }

    // 【消费记录】返回-列表-视图
    public function view_finance_expense_record_daily()
    {

        if(request()->isMethod('get'))
        {
            return view('mt.admin.entrance.finance.expense-record-daily')
                ->with(['sidebar_finance_active'=>'active','sidebar_finance_expense_daily_active'=>'active']);
        }
        else if(request()->isMethod('post')) return $this->repo->get_finance_expense_record_daily_datatable(request()->all());
    }

    // 【冻结资金】返回-列表-视图
    public function view_finance_freeze_record()
    {
        if(request()->isMethod('get')) return $this->repo->show_finance_freeze_record();
        else if(request()->isMethod('post')) return $this->repo->get_finance_freeze_record_datatable(request()->all());

        if(request()->isMethod('get'))
        {
            return view('mt.admin.entrance.finance.freeze-record')
                ->with(['sidebar_finance_active'=>'active','sidebar_finance_expense_active'=>'active']);
        }
        else if(request()->isMethod('post')) return $this->repo->get_finance_freeze_record_datatable(request()->all());
    }




    public function operate_download_keyword_today()
    {
        $this->repo->operate_download_keyword_today();
    }

    public function operate_download_keyword_detect()
    {
        $this->repo->operate_download_keyword_detect(request()->all());
    }




    /*
     * 公告
     */
    // 【公告】添加
    public function operate_notice_notice_create()
    {
        if(request()->isMethod('get')) return $this->repo->view_notice_notice_create();
        else if (request()->isMethod('post')) return $this->repo->operate_notice_notice_save(request()->all());
    }
    // 【公告】编辑
    public function operate_notice_notice_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_notice_notice_edit(request()->all());
        else if (request()->isMethod('post')) return $this->repo->operate_notice_notice_save(request()->all());
    }


    // 【公告】返回-列表-视图
    public function view_notice_notice_list()
    {
        if(request()->isMethod('get')) return $this->repo->show_notice_notice_list();
        else if(request()->isMethod('post')) return $this->repo->get_notice_notice_list_datatable(request()->all());
    }

    // 【公告】返回-我发布的公告-视图
    public function view_notice_my_notice_list()
    {
        if(request()->isMethod('get')) return $this->repo->show_notice_my_notice_list();
        else if(request()->isMethod('post')) return $this->repo->get_notice_my_notice_list_datatable(request()->all());
    }


    // 【公告】返回-详情
    public function operate_notice_notice_get()
    {
        return $this->repo->operate_notice_notice_get(request()->all());
    }
    // 【公告】发布
    public function operate_notice_notice_push()
    {
        return $this->repo->operate_notice_notice_push(request()->all());
    }
    // 【公告】删除
    public function operate_notice_notice_delete()
    {
        return $this->repo->operate_notice_notice_delete(request()->all());
    }


}
