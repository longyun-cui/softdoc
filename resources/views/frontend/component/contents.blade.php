@foreach($datas as $num => $item)
<div class="item-piece item-option course-option items"
     data-course="{{encode($item->id)}}"
     data-content="{{encode(0)}}">
    <!-- BEGIN PORTLET-->
    <div class="panel-default box-default item-entity-container">

        {{--header--}}
        <div class="box-body item-title-row">
            <a target="_blank" href="{{url('/course/'.encode($item->course->id).'?content='.encode($item->id))}}">{{$item->title or ''}}</a>
        </div>

        <div class="box-body item-info-row text-muted">
            <span><a href="{{url('/u/'.encode($item->user->id))}}">{{$item->user->name or ''}}</a></span>
            <span> • {{ $item->created_at->format('n月j日 H:i') }}</span>
            <span> • 阅读 <span class="text-blue">{{ $item->visit_num }}</span> 次</span>
        </div>

        <div class="box-body item-info-row text-muted" style="display:none;">
            <span><a target="_blank" href="{{url('/course/'.encode($item->course->id))}}">{{$item->course->title or ''}}</a></span>
        </div>


        {{--description--}}
        @if(!empty($item->description))
            <div class="box-body item-description-row">
                <div class="colo-md-12 text-muted"> {!! $item->description or '' !!} </div>
            </div>
        @endif

        {{--content--}}
        @if(!empty($item->content))
            <div class="box-body item-content-row">
                <div class="media">
                    <div class="media-left">
                        @if(!empty($item->cover_pic))
                            <img class="media-object" src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$item->cover_pic }}">
                        @else
                            <img class="media-object" src="{{ $item->img_tags[2][0] or '' }}">
                        @endif
                    </div>
                    <div class="media-body">
                        <div class="clearfix">
                            <article class="colo-md-12"> {!! $item->content_show or '' !!} </article>
                        </div>
                    </div>
                </div>
                {{--<article class="colo-md-12"> {!! $item->content or '' !!} </article>--}}
            </div>
        @endif




    </div>
    <!-- END PORTLET-->
</div>
@endforeach