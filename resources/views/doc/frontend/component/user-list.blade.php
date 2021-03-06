@foreach($user_list as $u)
<div class="a-piece a-option user-piece user-option user margin-bottom-8px radius-2px"
     data-user="{{ $u->id or 0 }}"
     data-type="{{ $u->relation_type or 0 }}"
>
    <div class="panel-default box-default item-entity-container">

        <div class="item-table-box">

            <div class="item-left-box">
                <a href="{{ url('/user/'.$u->id) }}">
                    <img class="media-object" src="{{ url(env('DOMAIN_CDN').'/'.$u->portrait_img) }}">
                </a>
            </div>

            <div class="item-right-box">

                <div class="item-row item-title-row">

                    <a href="{{ url('/user/'.$u->id) }}">
                        <b>{{ $u->username or '' }}</b>
                    </a>

                    @if(Auth::check())

                        <span class="tool-inn tool-set _none"><i class="fa fa-cog"></i></span>

                        @if($u->id != Auth::user()->id)
                            @if(count($u->fans_list->whereIn('relation_type', [21,41])) > 0)
                                <span class="tool-inn tool-info follow-remove follow-remove-it" role="button"><i class="fa fa-check"></i> 已关注</span>
                                {{--<span class="tool-inn tool-info follow-remove follow-remove-it"><i class="fa fa-minus"></i> 取消关注</span>--}}
                            @else
                                <span class="tool-inn tool-info follow-add follow-add-it" role="button"><i class="fa fa-plus"></i> 关注</span>
                            @endif
                        @endif


                        {{--@if($u->relation_with_me == 21)--}}
                            {{--<span class="tool-inn tool-info"><i class="fa fa-exchange"></i> 相互关注</span>--}}
                        {{--@elseif($u->relation_with_me == 41)--}}
                            {{--<span class="tool-inn tool-info"><i class="fa fa-check"></i> 已关注</span>--}}
                        {{--@elseif($u->relation_with_me == 71)--}}
                            {{--<span class="tool-inn tool-info follow-add-it"><i class="fa fa-plus text-yellow"></i> 关注</span>--}}
                        {{--@else--}}
                            {{--<span class="tool-inn tool-info follow-add-it"><i class="fa fa-plus text-yellow"></i> 关注</span>--}}
                        {{--@endif--}}

                        <div class="tool-menu-list _none" style="z-index:999;">
                            <ul>
                                @if($u->relation_with_me == 21)
                                    <li class="follow-remove-it">取消关注</li>
                                    <li class="fans-remove-it">移除粉丝</li>
                                @elseif($u->relation_with_me == 41)
                                    <li class="follow-remove-it">取消关注</li>
                                @elseif($u->relation_with_me == 71)
                                    <li class="fans-remove-it">移除粉丝</li>
                                @endif
                            </ul>
                        </div>

                    @else

                        <span class="tool-inn tool-info follow-add follow-add-it" role="button"><i class="fa fa-plus"></i> 关注</span>

                    @endif

                </div>

                <div class="item-row item-info-row">
                    <span>粉丝 {{ $u->fans_num }}</span>
                    <span> • 文章 {{ $u->article_count }}</span>
                    <span> • 活动 {{ $u->activity_count }}</span>
                    <span> • 访问 {{ $u->visit_num }}</span>
                </div>

                @if(!empty($u->linkman))
                <div class="item-row item-info-row">
                    <i class="fa fa-user text-orange" style="width:16px;"></i>
                    <span class="text-muted">{{ $u->linkman or '暂无' }}</span>
                </div>
                @endif

                @if(!empty($u->contact_phone))
                <div class="item-row item-info-row">
                    <i class="fa fa-phone text-success" style="width:16px;"></i>
                    <span class="text-muted">{{ $u->contact_phone or '暂无' }}</span>
                </div>
                @endif

                @if(!empty($u->contact_address))
                <div class="item-row item-info-row">
                    <i class="fa fa-map-marker text-primary" style="width:16px;"></i>
                    <span class="text-muted">{{ $u->contact_address or '暂无' }}</span>
                </div>
                @endif

                <div class="item-row item-info-row">
                    {{ $u->description or '暂无简介' }}
                </div>

            </div>

        </div>

    </div>
</div>
@endforeach