@extends('home.layout.auth')

@section('title','注册')

@section('content')
<div class="register-box">
    <div class="register-logo">
        <a href="/"><b>{{ config('information.website_name') }}</b></a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">用户注册</p>

        <form action="" method="post" id="form-register">

            {{ csrf_field() }}

            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="name" placeholder="用户名">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="email" class="form-control" name="email" placeholder="邮箱">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" placeholder="密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password_confirm" placeholder="确认密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="captcha" placeholder="验证码" AUTOCOMPLETE="off">
                <span class="_pointer change_captcha" style="cursor: pointer;">{!! captcha_img() !!}</span>
            </div>
            <div class="row" style="display:none;">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="agree"> 阅读并接受 <a href="#">《用户协议》</a>及<a href="#">《隐私权保护声明》</a>
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="button" class="btn btn-primary btn-block btn-flat">注册</button>
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="agree"> 阅读并接受 <a href="#">《用户协议》</a>及<a href="#">《隐私权保护声明》</a>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="button" class="btn btn-primary btn-block btn-flat" id="register-submit">注册</button>
                </div>
            </div>
        </form>

        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="https://open.weixin.qq.com/connect/qrconnect?appid=wxaf993c7aace04371&redirect_uri=http%3A%2F%2Fsoftdoc.cn%2Fweixin%2Flogin&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect" class="btn btn-block btn-social btn-success btn-flat"><i class="fa fa-wechat"></i> 微信登陆</a>
            {{--<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-wechat"></i> 微信登陆</a>--}}
            {{--<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> 支付宝登陆</a>--}}
        </div>

        <div class="social-auth-links text-center">
            <a href="/login" class="text-center">邮箱登陆</a>
        </div>
    </div>
    <!-- /.form-box -->

    <div class="register-box-body" style="display:none;">
        <a href="{{url('/login')}}"><button type="button" class="btn btn-primary btn-block btn-flat">邮箱登陆</button></a>
    </div>

    <div class="register-box-body">
        <a href="{{url('/')}}"><button type="button" class="btn btn-default btn-block btn-flat">返回首页</button></a>
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
        $("#register-submit").on('click', function() {
            var form = $("#form-register");
            var options = {
                url: "/register",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        form.find('input').val('');

                    }
                    $('input[name=captcha]').val('');
                    form.find(".change_captcha").click();
                }
            };
            form.ajaxSubmit(options);
        });

        // 更换验证码
        $(".change_captcha").on('click', function() {
            var that = $(this);
            $.post("/common/change_captcha", {'_token': $('meta[name="_token"]').attr('content')}, function(result) {
                that.find('img').attr('src', result.data.src);
//                that.html(result.data.img);
            }, 'json');
        });
    });
</script>
@endsection
