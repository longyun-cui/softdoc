<div class="main-side-block-padding main-side-container pull-left">

    <a href="javascript:void(0);" class="visible-xs visible-sm header-hide-side side-hidden" role="button"><i class="fa fa-remove"></i></a>

    <div class="col-md-12">

        <div>
            <h2><a href="{{ url('/item/'.$parent_item->id) }}" style="font-size:18px;"><b>{{ $parent_item->title or '' }}</b></a></h2>
        </div>

        <ul class="cbp_tmtimeline">
            @foreach($time_points as $num => $val)
                <li @if($val->id == $item->id) class="active" @endif>
                    <div class="cbp_tmicon"></div>
                    <time class="cbp_tmtime" datetime="">
                        <a href="{{ url('/item/'.$val->id) }}"><span role="button"><b>{{ $val->time_point or '' }}</b></span></a>
                    </time>
                    <div class="cbp_tmlabel">
                        <h2><a href="{{ url('/item/'.$val->id) }}"><b>{{ $val->title or '' }}</b></a></h2>
                        <div class="media _none">
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
                    </div>
                </li>
            @endforeach
        </ul>

    </div>

</div>