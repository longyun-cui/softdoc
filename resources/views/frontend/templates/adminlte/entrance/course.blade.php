@extends('frontend.templates.adminlte.layout.layout')

@section('wx_share_title') {{$item->title or ''}} @endsection
@section('wx_share_desc') {{$item->description or '@'.$course->title}} @endsection

@if(!empty($item->user->portrait_img))
    @section('wx_share_imgUrl'){{config('common.host.'.env('APP_ENV').'.cdn').'/'.$item->user->portrait_img}}@endsection
@else
    @section('wx_share_imgUrl'){{config('common.host.'.env('APP_ENV').'.root').'/favicon.png'}}@endsection
@endif


@section('title') {{$course->title}} @endsection
@section('header','')
@section('description','')

@section('header_title') {{$course->title}} @endsection



@section('header-sidebar-toggle-menu')
    @include('frontend.templates.adminlte.component.header.sidebar-toggle-menu')
@endsection

@section('sidebar')
    @include('frontend.templates.adminlte.component.sidebar.menu')
@endsection


@section('content')

<div class="_none">
    <input type="hidden" id="" value="{{$_encode or ''}}" readonly>
</div>


<div class="container">

    <div class="col-xs-12 col-sm-12 col-md-8 container-main pull-right">

        @include('frontend.course.component.item')

    </div>

    <div class="col-xs-12 col-sm-12 col-md-4 hidden-xs hidden-sm container-side pull-left">

        @include('frontend.templates.adminlte.component.main-side.info')
        @include('frontend.templates.adminlte.component.main-side.menu')

    </div>

</div>

@endsection


@section('js')
    <script>
        $(function() {

            console.log('1');
            fold();
            $(".comments-get-default").click();

        });
    </script>
@endsection
