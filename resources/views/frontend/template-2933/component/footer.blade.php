{{--<!-- START: footer -->--}}
<footer role="contentinfo" class="section-footer probootstrap-footer background-blue">
    <div class="site-footer _none">
        <div class="container">

            <div class="row mb60">
                <div class="col-lg-12 col-md-12 section-heading probootstrap-animate-">
                    <h2 class="module-title title-white">Footer</h2>
                    {{--<p class="module-subtitle lead"><b>{{ trans('custom.text.contact_subtitle') }}</b></p>--}}
                </div>
            </div>

            <div class="row">

                <div class="col-md-4 _none">
                    <div class="probootstrap-footer-widget">
                        <h3><b>第三方合作</b></h3>
                        <p></p>
                        <p><a href="javascript:void(0);" class="link-with-icon _none-">Learn More <i class=" icon-chevron-right"></i></a></p>
                    </div>
                    <div class="probootstrap-footer-widget _none-">
                        <h3>联系我们</h3>
                        <ul class="probootstrap-footer-social">
                            <li><a href=""><i class="icon-twitter"></i></a></li>
                            <li><a href=""><i class="icon-facebook"></i></a></li>
                            <li><a href=""><i class="icon-instagram2"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 _none">
                    <div class="probootstrap-footer-widget">
                        <h3><b>{{ trans('custom.text.footer_partner_title') }}</b></h3>
                        {{--@foreach($partners as $v)--}}
                        {{--<div class="col-xs-3 col-sm-2 col-md-3 partner-option">--}}
                            {{--<a target="_blank" href="{{ $v->link_url or 'javascript:void(0);' }}">--}}
                                {{--<figure>--}}
                                    {{--<div class="image-box">--}}
                                        {{--<img src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="Image">--}}
                                    {{--</div>--}}
                                {{--</figure>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        {{--@endforeach--}}
                    </div>
                </div>

                <div class="col-md-4 _none">
                    <div class="probootstrap-footer-widget">
                        <h3><b>{{ trans('custom.text.footer_wechat_title') }}</b></h3>

                        <ul class="probootstrap-product-list">
                            <li class="mb10">
                                <div class="text">
                                    <b><i class="fa fa-qrcode"></i></b> &nbsp;&nbsp;
                                    <span><img src="{{{ url('/') }}}" alt="Wechat_Qrcode" style="height:120px;"></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="probootstrap-footer-widget _none">
                        <h3><b>{{ trans('custom.text.footer_focus_title') }}</b></h3>

                        <ul class="probootstrap-footer-social _none">
                            <li><a href=""><i class="icon-twitter"></i></a></li>
                            <li><a href=""><i class="icon-facebook"></i></a></li>
                            <li><a href=""><i class="icon-instagram2"></i></a></li>
                            <li><a href=""><i class="icon-twitter"></i></a></li>
                            <li><a href=""><i class="icon-facebook"></i></a></li>
                            <li><a href=""><i class="icon-instagram2"></i></a></li>
                        </ul>

                        <div class="footer-social">

                            <a target="_blank" href="http://www.wechat.com">
                                <img src="{{ asset('/common/images/logo-icon/icon-logo-wechat.png') }}" alt="WeChat Logo">
                            </a>
                            <a target="_blank" href="http://www.linkedin.com/company/keron-international-relocation-movers/">
                                <img src="{{ asset('/common/images/logo-icon/icon-logo-linkedin.png') }}" alt="Linkedin Logo">
                            </a>
                            <a target="_blank" href="https://moveaide.com/movers/keron-international-relocation-shanghai-china-mover-reviews">
                                <img src="{{ asset('/common/images/logo-icon/icon-logo-moveaide.png') }}" alt="MoveAide Logo">
                            </a>
                            <a target="_blank" href="http://www.smartshanghai.com/venue/15561/keron_international_relocation_and_movers_zhongshan_bei_lu">
                                <img src="{{ asset('/common/images/logo-icon/icon-logo-smart.png') }}" alt="Instagram Logo">
                            </a>
                            <a target="_blank" href="http://www.thatsmags.com/shanghai">
                                <img src="{{ asset('/common/images/logo-icon/icon-logo-thats.png') }}" alt="Instagram Logo">
                            </a>
                            <a target="_blank" href="{{ trans('custom.text.video_url') }}">
                                <img src="{{ asset('/common/images/logo-icon/icon-logo-youku.png') }}" alt="Instagram Logo">
                            </a>
                            <a target="_blank" href="https://www.baidu.com/">
                                <img src="{{ asset('/common/images/logo-icon/icon-logo-baidu.png') }}" alt="Instagram Logo">
                            </a>
                            <a target="_blank" href="https://plus.google.com/">
                                <img src="{{ asset('/common/images/logo-icon/icon-logo-google.png') }}" alt="Google Plus Logo">
                            </a>
                            <a target="_blank" href="https://www.facebook.com/" style="display: none;">
                                <img src="{{ asset('/common/images/logo-icon/icon-logo-facebook.png') }}" alt="Facebook Logo">
                            </a>
                            <a target="_blank" href="https://twitter.com/" style="display: none;">
                                <img src="{{ asset('/common/images/logo-icon/icon-logo-twitter.png') }}" alt="Twitter Logo">
                            </a>
                            <a target="_blank" href="https://instagram.com/" style="display: none;">
                                <img src="{{ asset('/common/images/logo-icon/icon-logo-instagram.png') }}" alt="Instagram Logo">
                            </a>

                        </div>
                    </div>
                </div>

                <div class="col-md-4 _none">
                    <div class="probootstrap-footer-widget">
                        <h3><b>{{ trans('custom.text.footer_contact_title') }}</b></h3>

                        <ul class="probootstrap-product-list">
                            <li class="mb10">
                                <div class="text">
                                    <b><i class="fa fa-location-arrow"></i></b> &nbsp;&nbsp;
                                    <span>{{ trans('custom.info.address') }}</span>
                                </div>
                            </li>
                            <li class="mb10">
                                <div class="text">
                                    <b><i class="fa fa-phone"></i></b> &nbsp;&nbsp;
                                    {{--<span><a href="tel:{{ config('company.info.telephone') }}" style="display:inline-block;">{{ config('company.info.telephone') }}</a></span>--}}
                                    <span>{{ config('company.info.telephone') }}</span>
                                </div>
                            </li>
                            <li class="mb10">
                                <div class="text">
                                    <b><i class="fa fa-envelope"></i></b> &nbsp;&nbsp;
                                    {{--<span><a href="mailto:{{ config('company.info.email') }}" style="display:inline-block;">{{ config('company.info.email') }}</a></span>--}}
                                    <span>{{ config('company.info.email') }}</span>
                                </div>
                            </li>
                            <li class="mb10">
                                <div class="text">
                                    <b><i class="fa fa-weixin"></i></b> &nbsp;&nbsp;
                                    <span>{{ config('company.info.wechat_id') }}</span>
                                </div>
                            </li>
                            <li class="mb10">
                                <div class="text">
                                    <b><i class="fa fa-globe"></i></b> &nbsp;&nbsp;
                                    <span>{{ config('company.info.website') }}</span>
                                </div>
                            </li>
                            <li class="mb10 _none">
                                <div class="text">
                                    <b><i class="fa fa-weixin"></i></b> &nbsp;&nbsp;
                                    <span><img src="{{ url('/') }}" alt="Wechat_Qrcode" style="height:120px;"></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="site-footer-bottom">
        <div class="container">
            <div class="row mt20 mb20">
                <div class="col-md-12 text-center">
                    <div>
                        <small> Copyright&copy;上海如哉网络科技有限公司 2017-2019</small><br>
                        <small><a target="_blank" href="http://www.miitbeian.gov.cn" style="color:#a8a8a8">沪ICP备17052782号-2</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

{{--<a href="javascript:void(0);" class="js-backtotop" style="position:fixed; right:32px; bottom:32px;"><i class="fa fa-chevron-up"></i></a>--}}
{{--<!-- END: footer -->--}}