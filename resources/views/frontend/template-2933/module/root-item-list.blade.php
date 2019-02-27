{{--main--}}
<section class="module-container">
    <div class="container- row">

        <header class="module-row module-header-container text-center _none">
            <div class="wow slideInLeft module-title-row title-with-double-line color-1 border-light title-h2"><b>原创内容</b></div>
            {{--<div class="wow slideInRight module-subtitle-row color-5 title-h4"><b>description-1</b></div>--}}
        </header>

        <div class="module-row module-body-container bg-light-">
            @include('frontend.'.env('TEMPLATE').'.component.item-list', ['items'=>$items])
        </div>

        <footer class="module-row module-footer-container text-center">
            {{--<a href="{{ url('/item/list') }}" class="view-more style-dark">查看更多 <i class="fa fa-hand-o-right"></i></a>--}}
        </footer>

    </div>
</section>