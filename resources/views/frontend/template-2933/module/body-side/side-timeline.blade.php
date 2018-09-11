<ul class="cbp_tmtimeline">
@foreach($time_points as $num => $val)
    <li>
        <div class="cbp_tmicon"></div>
        <time class="cbp_tmtime" datetime="2013-04-10 18:30">
            <span><b>{{ $val->time_point or '' }}</b></span>
        </time>
        <div class="cbp_tmlabel">
            <h2><a href="{{ url('/item/'.$val->id) }}"><b>{{ $val->title or '' }}</b></a></h2>
            <div class="media">
                <div class="media-left">
                    @if(!empty($val->cover_pic))
                        <a href="{{ url('/item/'.$val->id) }}">
                            <img class="media-object" src="{{ url(env('DOMAIN_CDN').'/'.$item->cover_pic )}}">
                        </a>
                    @else
                        <a href="{{ url('/item/'.$val->id) }}">
                            <img class="media-object" src="{{ $val->img_tags[2][0] or '' }}">
                        </a>
                    @endif
                </div>
                <div class="media-body">
                    <div class="clearfix">
                        @if(!empty($item->description))
                            <article class="colo-md-12">{{{ $val->description or '' }}}</article>
                        @else
                            <article class="colo-md-12">{!! $val->content_show or '' !!}</article>
                        @endif

                    </div>
                </div>
            </div>
    </li>
@endforeach
</ul>