{{--<!-- START: modal -->--}}
<div class="modal fade" id="modal-forward" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><b>分享到我的主页</b></h4>
            </div>
            <div class="modal-body" style="padding-bottom:4px;">
                <div class="forward-item-container">
                    <div class="portrait-box"><img class="forward-user-portrait" src="" alt=""></div>
                    <div class="text-box">
                        <div class="text-row forward-item-title"></div>
                        <div class="text-row forward-user-name"></div>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="padding-top:4px;">
                <form action="" id="forward-form">

                    {{ csrf_field() }}
                    <input type="hidden" name="item_id" class="forward-item-id" value="0">
                    <div class="textarea-row">
                        <textarea class="forward-content" name="content" rows="2" placeholder="此刻的想法……" autofocus="autofocus"></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="forward-confirm">转发</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>

</div>
{{--<!-- END: modal -->--}}