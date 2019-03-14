@foreach($items as $n => $v)
<div class="item-col col-lg-3 col-md-3 col-sm-6 col-xs-6 item-option" style=""
     data-item="{{ $v->id }}"
     data-calendar-days="{{ $v->calendar_days or '' }}"
>
    <div class="item-container bg-white">

        <figure class="image-container padding-top-2-3">
            <div class="image-box">
                <a class="clearfix zoom-" target="_blank"  href="{{ url('/item/'.$v->id) }}">
                    {{--<img class="grow" data-action="zoom-" src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="Property Image">--}}
                    @if(!empty($v->cover_pic))
                        <img class="grow" src="{{ url(env('DOMAIN_CDN').'/'.$v->cover_pic) }}">
                    @else
                        @if(!empty($v->img_tags[2][0]))
                            <img class="grow" src="{{ $v->img_tags[2][0] or '' }}">
                        @else
                            <img class="grow" src="{{ url('/common/images/notexist.png') }}">
                        @endif
                    @endif
                </a>
                <span class="btn btn-warning">热销中</span>
            </div>
        </figure>

        <figure class="text-container clearfix">
            <div class="text-box">
                <div class="text-title-row multi-ellipsis-1">
                    <a href="{{ url('/item/'.$v->id) }}"><c>{{ $v->title or '' }}</c></a> &nbsp;
                </div>
                <div class="text-title-row multi-ellipsis-1 with-border-top">
                    <a href="{{ url('/user/'.$v->user->id) }}" style="color:#ff7676;font-size:13px;">
                        <img src="{{ url(env('DOMAIN_CDN').'/'.$v->user->portrait_img) }}" class="title-portrait" alt="">
                        <c>{{ $v->user->name or '' }}</c>
                    </a>
                </div>
                <div class="text-description-row _none">
                    {{--<div>--}}
                        {{--<i class="fa fa-cny"></i> <span class="font-18px color-red"><b>{{ $v->custom->price or '' }}</b></span>--}}
                    {{--</div>--}}
                    @if($v->time_type == 1)
                        <div class="" style="font-size:16px;">
                            @if(!empty($v->start_time))
                                <x class="text-blue">{{ time_show($v->start_time) }}</x>
                            @endif
                        </div>
                        <div class="" style="font-size:16px;">
                            @if(!empty($v->end_time))
                                {{--&nbsp;<b class="font-14px">至</b>&nbsp;--}}
                                <x class="text-blue">{{ time_show($v->end_time) }} (结束)</x>
                            @endif
                        </div>
                    @else
                        &nbsp;
                    @endif
                </div>
            </div>
            <div class="text-box with-border-top text-center clearfix _none">
                <a target="_blank" href="{{ url('/item/'.$v->id) }}">
                    <button class="btn btn-default btn-flat btn-3d btn-clicker" data-hover="点击查看" style="border-radius:0;">
                        <strong>查看详情</strong>
                    </button>
                </a>
            </div>
        </figure>



        <span class="item-plus-box in-item-list-2" role="button">
            <i class="fa fa-plus-square-o item-plus-button" style="font-weight:900;"></i>
            <ul class="item-plus-list left-bottom">

                @if(Auth::check() && $v->pivot_item_relation->contains('type', 21))
                    <li class="remove-this-collection"><i class="fa fa-star-o text-red"></i> 移出收藏</li>
                @else
                    <li class="add-this-collection"><i class="fa fa-star-o"></i> 收藏</li>
                @endif


                @if(Auth::check() && $v->pivot_item_relation->contains('type', 31))
                    <li class="remove-this-todolist"><i class="fa fa-check-square-o text-red"></i> 移出待办事</li>
                @else
                    <li class="add-this-todolist"><i class="fa fa-check-square-o"></i> 添加到待办事</li>
                @endif


                @if($v->time_type == 1)
                    @if(Auth::check() && $v->pivot_item_relation->contains('type', 32))
                        <li class="remove-this-schedule"><i class="fa fa-calendar-plus-o text-red"></i> 移出日程</li>
                    @else
                        <li class="add-this-schedule"><i class="fa fa-calendar-plus-o"></i> 添加为日程</li>
                    @endif
                @endif

                @if(Auth::check() && $v->user_id == Auth::user()->id)
                    <li class="delete-this-item"><i class="fa fa-trash"></i> 删除</li>
                @endif

            </ul>
        </span>

    </div>
</div>
@endforeach