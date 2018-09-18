@extends('home.layout.auth')

@section('title','用户登陆')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="/"><b>{{ config('information.website_name') }}</b> </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">用户登录</p>

        <form action="/login" method="post" id="form-admin-login">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input type="email" class="form-control" name="email" placeholder="邮箱">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" placeholder="密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember"> 记住我
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="button" class="btn btn-primary btn-block btn-flat" id="admin-login-submit">登陆</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <!-- /.social-auth-links -->

        <a href="#">忘记密码</a><br>
        <a href="/register" class="text-center">注册新用户</a>

        <div class="social-auth-links text-center" >
            <p>- 第三方登录 -</p>
            <a href="https://open.weixin.qq.com/connect/qrconnect?appid=wxaf993c7aace04371&redirect_uri=http%3A%2F%2Fsoftdoc.cn%2Fweixin%2Flogin&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect" class="btn btn-block- btn-social- btn-success btn-flat">
                <i class="fa fa-weixin"></i> 微信登陆
            </a>
            {{--<a href="#" class="btn btn-block btn-social btn-primary btn-flat"><i class="fa fa-"></i> 支付宝登陆</a>--}}
        </div>

    </div>
    <!-- /.login-box-body -->

    <div class="login-box-body" style="display:none;">
        <a href="{{url('/register')}}"><button type="button" class="btn btn-primary btn-block btn-flat">注册新用户</button></a>
    </div>

    <div class="login-box-body">
        <a href="{{url('/')}}"><button type="button" class="btn btn-default btn-block btn-flat">返回平台主页</button></a>
    </div>

</div>
@endsection


@section('js')
<script>
    $(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        // 提交表单
        $("#admin-login-submit").on('click', function() {
            var options = {
                url: "/login",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "/home";
                    }
                }
            };
            $("#form-admin-login").ajaxSubmit(options);
        });
    });
</script>
@endsection
