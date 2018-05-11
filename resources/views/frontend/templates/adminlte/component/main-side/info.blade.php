<div class="box-body main-side-block">

    <div class="col-md-12">
        <span class="recursion-icon" style="color:orange;">
            <i class="fa fa-bookmark"></i>
        </span>
        <span class="recursion-text recursion-course @if(empty($content)) active @endif">
            <a href="{{url('/course/'.encode($course->id))}}">
                {{ $course->title or '' }}
            </a>
        </span>
    </div>

    <div class="col-md-12">
        <span class="recursion-icon" style="color:orange;">
            <i class="fa fa-user"></i>
        </span>
        <span class="recursion-text recursion-user">
            <a href="{{url('/u/'.$course->user->encode_id)}}"><b class="text-blue">{{ $course->user->name }}</b></a>
        </span>
    </div>

    <div class="col-md-12">
        <span class="recursion-icon" style="color:orange;">
            <i class="fa fa-tv"></i>
        </span>
        <span class="recursion-text">
            <a href="javascript:void(0)">浏览 <span class="text-blue">{{ $course->visit_num or 0 }}</span> 次</a>
        </span>
    </div>

    <div class="col-md-12">
        <span class="recursion-icon" style="color:orange;">
            <i class="fa fa-commenting-o"></i>
        </span>
        <span class="recursion-text">
            <a href="javascript:void(0)">评论 <span class="text-blue">{{ $course->comments_total or 0 }}</span> 个</a>
        </span>
    </div>

</div>