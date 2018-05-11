<div class="box-body main-side-block">
    <div class="box-body" style="border-bottom: 2px solid #eee">
        <i class="fa fa-user text-orange"></i> <b>{{ $data->name or '' }}</b>
    </div>
    <div class="margin">课程数：<span class="text-blue">{{ $data->courses_count or 0 }}</span> 个</div>
    <div class="margin">访问量：<span class="text-blue">{{ $data->visit_num or 0 }}</span> 次</div>
</div>