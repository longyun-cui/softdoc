@foreach($users as $u)
<div class="item-piece user-option user" data-user="{{ $u->relation_user->id or 0 }}" data-type="{{ $u->relation_type or 0 }}">
    <div class="panel-default box-default item-entity-container">

        <div class="item-table-box">

            <div class="item-left-box">
                <a href="{{ url('/user/'.$u->relation_user->id) }}" target="_blank">
                    <img class="media-object" src="{{ url(env('DOMAIN_CDN').'/'.$u->relation_user->portrait_img) }}">
                </a>
            </div>

            <div class="item-right-box">

                <div class="item-row item-title-row">

                    <a href="{{ url('/user/'.$u->relation_user->id) }}" target="_blank">
                        <b>{{ $u->relation_user->name or '' }}</b>
                    </a>

                    @if(Auth::check() && $u->relation_user_id != Auth::user()->id)

                        <span class="tool-inn tool-set"><i class="fa fa-cog"></i></span>

                        @if($u->relation_with_me == 21)
                            <span class="tool-inn tool-info"><i class="fa fa-exchange"></i> 相互关注</span>
                        @elseif($u->relation_with_me == 41)
                            <span class="tool-inn tool-info"><i class="fa fa-check"></i> 已关注</span>
                        @elseif($u->relation_with_me == 71)
                            <span class="tool-inn tool-info follow-add-it"><i class="fa fa-plus text-yellow"></i> 关注</span>
                        @else
                            <span class="tool-inn tool-info follow-add-it"><i class="fa fa-plus text-yellow"></i> 关注</span>
                        @endif

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

                    @endif

                </div>

                <div class="item-row item-info-row">
                    <span>关注 {{ $u->relation_user->follow_num }}</span>
                    <span> • 粉丝 {{ $u->relation_user->fans_num }}</span>
                </div>

                <div class="item-row">
                    {{ $u->relation_user->description or '暂无简介' }}
                </div>

            </div>

        </div>

    </div>
</div>
@endforeach