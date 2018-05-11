<div class="box-body main-side-block main-side-menu side-menu course-menu-md-container">

    <div class="main-side-menu-header">
        <div class="col-md-6 fold-button fold-down">
            <span class="">
                <i class="fa fa-plus-square"></i> 全部展开
            </span>
        </div>
        <div class="col-md-6 fold-button fold-up">
            <span class="">
                <i class="fa fa-minus-square"></i> 全部折叠
            </span>
        </div>
    </div>

    @foreach( $course->contents_recursion as $key => $recursion )
        <div class="col-md-12 recursion-row" data-level="{{$recursion->level or 0}}" data-id="{{$recursion->id or 0}}"
             style="display:@if($recursion->level != 0) none @endif">
            <div class="recursion-menu" style="margin-left:{{ $recursion->level*24 }}px">
                <span class="recursion-icon">
                    @if($recursion->type == 1)
                        @if($recursion->has_child == 1)
                            <i class="fa fa-plus-square recursion-fold"></i>
                        @else
                            <i class="fa fa-file-text"></i>
                        @endif
                    @else
                        <i class="fa fa-file-text"></i>
                    @endif
                </span>
                <span class="recursion-text @if(!empty($content)) @if($recursion->id == $content->id) active @endif @endif">
                    <a class="row-ellipsis" href="{{url('/course/'.encode($course->id).'?content='.encode($recursion->id))}}">
                        {{ $recursion->title or '' }}
                    </a>
                </span>
            </div>
        </div>
    @endforeach

</div>