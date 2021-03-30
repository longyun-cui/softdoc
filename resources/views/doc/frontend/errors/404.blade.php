@extends(env('TEMPLATE_DEFAULT').'frontend.layout.layout')

@section('head_title','朝鲜族组织活动网')
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('header','')
@section('description','')
@section('content')
<div class="container">

    <div class="col-sm-12 col-md-9 container-body-left">

        <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>

            <div class="error-content">
                <h3 style="display:none;"><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
                <h3>&nbsp;</h3>
                <h3><i class="fa fa-warning text-yellow"></i> {{ $error or '哦，很抱歉' }} </h3>

                <p>
                    页面不存在或者参数有误，你可以 <a href="/">返回首页</a> 或者 <a href="javascript:location.reload();">刷新</a> 重试！
                </p>

                <p style="display:none;">
                    We could not find the page you were looking for.
                    Meanwhile, you may <a href="/">return to admin</a> or try using the search form.
                </p>
            </div>
        </div>

    </div>

    <div class="col-sm-12 col-md-3 hidden-xs hidden-sm container-body-right">

        @include(env('TEMPLATE_DEFAULT').'frontend.component.right-root')
        @include(env('TEMPLATE_DEFAULT').'frontend.component.right-me')

    </div>


</div>
@endsection


@section('js')
<script>
    $(function() {
    });
</script>
@endsection