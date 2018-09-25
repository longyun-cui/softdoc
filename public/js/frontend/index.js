jQuery( function ($) {


    $(".user-logout").on("click",function() {
        location.href = "/logout";
    });

    $(".admin-logout").on("click",function() {
        location.href = "/admin/logout";
    });


    // 默认隐藏事件
    $(document).on('click', function(){
        $('.tool-menu-list').hide();
    });



    $('.section-header').on('click', '.header-show-side', function (o) {
        o.preventDefault();
        $("body").hasClass("menu") ? ($("body").removeClass("menu")) : ($("body").addClass("menu"));
    });

    $('.main-side-container').on('click', '.header-hide-side', function () {
        $("body").removeClass("menu");
    });


    // user.page 用户页面 添加关注
    $('.section-header').on('click', '.follow-add-it', function () {
        var $that = $(this);
        var $user_id = $that.attr('data-user-id');

        $.post(
            "/user/relation/add",
            {
                _token: $('meta[name="_token"]').attr('content'),
                user_id: $user_id,
                type: 1
            },
            function(data){
                if(!data.success) layer.msg(data.msg);
                else
                {
                    var html = '<i class="fa fa-minus"></i> 取消关注';
                    $that.removeClass('follow-add-it').addClass('follow-remove-it');
                    $that.find('a').html(html);
                }
            },
            'json'
        );
    });

    // user.page 用户页面 取消关注
    $('.section-header').on('click', '.follow-remove-it', function () {
        var $that = $(this);
        var $user_id = $that.attr('data-user-id');

        layer.msg('确认"取消"？', {
            time: 0
            ,btn: ['确定', '取消']
            ,yes: function(index){
                $.post(
                    "/user/relation/remove",
                    {
                        _token: $('meta[name="_token"]').attr('content'),
                        user_id: $user_id,
                        type: 1
                    },
                    function(data){
                        if(!data.success) layer.msg(data.msg);
                        else
                        {
                            var html = '<i class="fa fa-plus"></i> 添加关注';
                            $that.removeClass('follow-remove-it').addClass('follow-add-it');
                            $that.find('a').html(html);
                        }
                    },
                    'json'
                );
            }
        });
    });

    // 显示用户操作
    $('.user-option').on('click', '.tool-set', function (e) {
        e.stopPropagation();
        $('.tool-menu-list').hide();
        var $that = $(this);
        var $user_option = $that.parents('.user-option');
        $user_option.find('.tool-menu-list').show();
    });

    // user.option 添加关注
    $('.user-option').on('click', '.follow-add-it', function (e) {

        e.stopPropagation();

        var $that = $(this);
        var $user_option = $that.parents('.user-option');
        var $user_id = $user_option.attr('data-user');
        var $relation_type = $user_option.data('type');

        $.post(
            "/user/relation/add",
            {
                _token: $('meta[name="_token"]').attr('content'),
                user_id: $user_id,
                type: 1
            },
            function(data){
                if(!data.success) layer.msg(data.msg);
                else
                {
                    var html = '';
                    console.log(data.data.relation_type);
                    if(data.data.relation_type == 21) html = '<i class="fa fa-exchange"></i> 相互关注';
                    else if(data.data.relation_type == 41) html = '<i class="fa fa-check"></i> 已关注';
                    else html = '';
                    $user_option.find('.tool-inn.tool-info').removeClass('follow-add-it').html(html);

                    var li_html = '<li class="follow-remove-it">取消关注</li>';
                    $user_option.find('.tool-menu-list ul').prepend(li_html);
                }
            },
            'json'
        );
    });

    // user.option 取消关注
    $('.user-option').on('click', '.follow-remove-it', function (e) {

        e.stopPropagation();

        var $that = $(this);
        var $user_option = $that.parents('.user-option');
        var $user_id = $user_option.attr('data-user');
        var $relation_type = $user_option.data('type');

        layer.msg('确认"取消"？', {
            time: 0
            ,btn: ['确定', '取消']
            ,yes: function(index){
                $.post(
                    "/user/relation/remove",
                    {
                        _token: $('meta[name="_token"]').attr('content'),
                        user_id: $user_id,
                        type: 1
                    },
                    function(data){
                        if(!data.success) layer.msg(data.msg);
                        else
                        {
                            layer.closeAll();
                            var html = '<i class="fa fa-plus text-yellow"></i> 关注';
                            $user_option.find('.tool-inn.tool-info').addClass('follow-add-it').html(html);
                            $that.remove();
                        }
                    },
                    'json'
                );
            }
        });
    });




    $('.item-option').on('click', '.show-menu', function () {
        var item_option = $(this).parents('.item-option');
        item_option.find('.menu-container').show();
        $(this).removeClass('show-menu').addClass('hide-menu');
        $(this).html('隐藏目录');
    });

    $('.item-option').on('click', '.hide-menu', function () {
        var item_option = $(this).parents('.item-option');
        item_option.find('.menu-container').hide();
        $(this).removeClass('hide-menu').addClass('show-menu');
        $(this).html('查看目录');
    });




    // 收藏自己
    $(".item-option").off("click",".collect-mine").on('click', ".collect-mine", function() {
        layer.msg('不能收藏自己的', function(){});
    });
    // 收藏
    $(".item-option").off("click",".add-this-collection").on('click', ".add-this-collection", function() {
        var that = $(this);
        var item_option = $(this).parents('.item-option');

        layer.msg('确认"收藏"？', {
            time: 0
            ,btn: ['确定', '取消']
            ,yes: function(index){
                $.post(
                    "/item/add/collection",
                    {
                        _token: $('meta[name="_token"]').attr('content'),
                        item_id: item_option.attr('data-item'),
                        type: 1
                    },
                    function(data){
                        if(!data.success) layer.msg(data.msg);
                        else
                        {
                            layer.msg("收藏成功");

                            // var btn = that.parents('.collect-btn');
                            // var num = parseInt(btn.attr('data-num'));
                            // num = num + 1;
                            // btn.attr('data-num',num);
                            // var html = '<span class="collect-this-cancel"><i class="fa fa-heart text-red"></i> '+num+'</span>';
                            // btn.html(html);
                            //
                            // // item_option.html(data.data.html);
                        }
                    },
                    'json'
                );
            }
        });

    });
    // 取消收藏
    $(".item-option").off("click",".remove-this-collection").on('click', ".remove-this-collection", function() {
        var that = $(this);
        var item_option = $(this).parents('.item-option');

        layer.msg('取消"收藏"？', {
            time: 0
            ,btn: ['确定', '取消']
            ,yes: function(index){
                $.post(
                    "/item/remove/collection",
                    {
                        _token: $('meta[name="_token"]').attr('content'),
                        item_id: item_option.attr('data-item'),
                        type: 1
                    },
                    function(data){
                        if(!data.success) layer.msg(data.msg);
                        else
                        {
                            layer.closeAll();

                            // var index = parent.layer.getFrameIndex(window.name);
                            // parent.layer.close(index);
                            //
                            // var btn = that.parents('.collect-btn');
                            // var num = parseInt(btn.attr('data-num'));
                            // num = num - 1;
                            // btn.attr('data-num',num);
                            // if(num == 0) num = '';
                            // var html = '<span class="collect-this"><i class="fa fa-heart-o"> '+num+'</span>';
                            // btn.html(html);
                            //
                            // // item_option.html(data.data.html);
                        }
                    },
                    'json'
                );
            }
        });

    });


    // 点赞
    $(".item-option").off("click",".add-this-favor").on('click', ".add-this-favor", function() {
        var that = $(this);
        var item_option = $(this).parents('.item-option');

        $.post(
            "/item/add/favor",
            {
                _token: $('meta[name="_token"]').attr('content'),
                item_id: item_option.attr('data-item'),
                type: 9
            },
            function(data){
                if(!data.success) layer.msg(data.msg);
                else
                {
                    layer.msg("点赞成功");
                    that.addClass('remove-this-favor').removeClass('add-this-favor');
                    that.find('i').addClass('fa-thumbs-up text-red').removeClass('fa-thumbs-o-up');

                    var btn = that.parents('.operate-btn');
                    var num = parseInt(btn.attr('data-num'));
                    num = num + 1;
                    btn.attr('data-num',num);
                    btn.find('num').html(num);

                    // var btn = that.parents('.favor-btn');
                    // var num = parseInt(btn.attr('data-num'));
                    // num = num + 1;
                    // btn.attr('data-num',num);
                    // var html = '<span class="favor-this-cancel"><i class="fa fa-thumbs-up text-red"></i> '+num+'</span>';
                    // btn.html(html);
                    //
                    // // item_option.html(data.data.html);
                }
            },
            'json'
        );

    });
    // 取消点赞
    $(".item-option").off("click",".remove-this-favor").on('click', ".remove-this-favor", function() {
        var that = $(this);
        var item_option = $(this).parents('.item-option');

        $.post(
            "/item/remove/favor",
            {
                _token: $('meta[name="_token"]').attr('content'),
                item_id: item_option.attr('data-item'),
                type: 9
            },
            function(data){
                if(!data.success) layer.msg(data.msg);
                else
                {
                    layer.closeAll();
                    // var index = parent.layer.getFrameIndex(window.name);
                    // parent.layer.close(index);

                    that.addClass('add-this-favor').removeClass('remove-this-favor');
                    that.find('i').addClass('fa-thumbs-o-up').removeClass('fa-thumbs-up text-red');

                    var btn = that.parents('.operate-btn');
                    var num = parseInt(btn.attr('data-num'));
                    num = num - 1;
                    btn.attr('data-num',num);
                    btn.find('num').html(num);
                    // if(num == 0) num = '';
                    // var html = '<span class="favor-this"><i class="fa fa-thumbs-o-up"></i> '+num+'</span>';

                    //
                    // // item_option.html(data.data.html);
                }
            },
            'json'
        );

    });


    // 添加待办事
    $(".item-option").off("click",".add-this-todolist").on('click', ".add-this-todolist", function() {
        var that = $(this);
        var item_option = $(this).parents('.item-option');

        layer.msg('添加待办事？', {
            time: 0
            ,btn: ['确定', '取消']
            ,yes: function(index){
                $.post(
                    "/item/add/todolist",
                    {
                        _token: $('meta[name="_token"]').attr('content'),
                        item_id: item_option.attr('data-item'),
                        type: 11
                    },
                    function(data){
                        if(!data.success) layer.msg(data.msg);
                        else
                        {
                            layer.msg("添加成功");
                        }
                    },
                    'json'
                );
            }
        });

    });
    // 移除待办事
    $(".item-option").off("click",".remove-this-todolist").on('click', ".remove-this-todolist", function() {
        var that = $(this);
        var item_option = $(this).parents('.item-option');

        layer.msg('移除待办事？', {
            time: 0
            ,btn: ['确定', '取消']
            ,yes: function(index){
                $.post(
                    "/item/remove/todolist",
                    {
                        _token: $('meta[name="_token"]').attr('content'),
                        item_id: item_option.attr('data-item'),
                        type: 1
                    },
                    function(data){
                        if(!data.success) layer.msg(data.msg);
                        else
                        {
                            layer.closeAll();
                            layer.msg("");
                        }
                    },
                    'json'
                );
            }
        });

    });


    // 添加日程
    $(".item-option").off("click",".add-this-schedule").on('click', ".add-this-schedule", function() {
        var that = $(this);
        var item_option = $(this).parents('.item-option');

        layer.msg('添加日程？', {
            time: 0
            ,btn: ['确定', '取消']
            ,yes: function(index){
                $.post(
                    "/item/add/schedule",
                    {
                        _token: $('meta[name="_token"]').attr('content'),
                        item_id: item_option.attr('data-item'),
                        type: 11
                    },
                    function(data){
                        if(!data.success) layer.msg(data.msg);
                        else
                        {
                            layer.msg("添加成功");
                        }
                    },
                    'json'
                );
            }
        });

    });
    // 移除日程
    $(".item-option").off("click",".remove-this-schedule").on('click', ".remove-this-schedule", function() {
        var that = $(this);
        var item_option = $(this).parents('.item-option');

        layer.msg('移除日程？', {
            time: 0
            ,btn: ['确定', '取消']
            ,yes: function(index){
                $.post(
                    "/item/remove/schedule",
                    {
                        _token: $('meta[name="_token"]').attr('content'),
                        item_id: item_option.attr('data-item'),
                        type: 1
                    },
                    function(data){
                        if(!data.success) layer.msg(data.msg);
                        else
                        {
                            layer.closeAll();
                            layer.msg("");
                        }
                    },
                    'json'
                );
            }
        });

    });




    // 显示评论
    $(".item-option").off("click",".comment-toggle").on('click', ".comment-toggle", function() {
        var item_option = $(this).parents('.item-option');
        item_option.find(".comment-container").toggle();

        if(!item_option.find(".comment-container").is(":hidden"))
        {
            $.post(
                "/item/comment/get",
                {
                    _token: $('meta[name="_token"]').attr('content'),
                    item_id: item_option.attr('data-item'),
                    type: 1
                },
                function(data){
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        item_option.find('.comment-list-container').html(data.data.html);
                        if(data.data.more == 'more')
                        {
                            item_option.find('.item-more').html("查看更多");
                        }
                        else if(data.data.more == 'none')
                        {
                            item_option.find('.item-more').html("没有更多评论了");
                        }

                    }
                },
                'json'
            );
        }
    });
    // 发布评论
    $(".item-option").off("click",".comment-submit").on('click', ".comment-submit", function() {
        var item_option = $(this).parents('.item-option');
        var form = $(this).parents('.item-comment-form');
        var options = {
            url: "/item/comment/save",
            type: "post",
            dataType: "json",
            // target: "#div2",
            success: function (data) {
                if(!data.success) layer.msg(data.msg);
                else
                {
                    form.find('textarea').val('');
                    item_option.find('.comment-list-container').prepend(data.data.html);
                }
            }
        };
        form.ajaxSubmit(options);
    });


    // 查看评论
    $(".item-option").off("click",".comments-get").on('click', ".comments-get", function() {
        var that = $(this);
        var item_option = $(this).parents('.item-option');
        var getSort = that.attr('data-getSort');
        var getSupport = item_option.find('input[name=get-support]:checked').val();

        $.post(
            "/item/comment/get",
            {
                _token: $('meta[name="_token"]').attr('content'),
                item_id: item_option.attr('data-item'),
                support: getSupport,
                type: 1
            },
            function(data){
                if(!data.success) layer.msg(data.msg);
                else
                {
                    item_option.find('.comment-list-container').html(data.data.html);

                    item_option.find('.comments-more').attr("data-getSort",getSort);
                    item_option.find('.comments-more').attr("data-maxId",data.data.max_id);
                    item_option.find('.comments-more').attr("data-minId",data.data.min_id);
                    item_option.find('.comments-more').attr("data-more",data.data.more);
                    if(data.data.more == 'more')
                    {
                        item_option.find('.comments-more').html("更多");
                    }
                    else if(data.data.more == 'none')
                    {
                        item_option.find('.comments-more').html("评论也是有底的！");
                    }
                }
            },
            'json'
        );
    });
    // 更多评论
    $(".item-option").off("click",".comments-more").on('click', ".comments-more", function() {

        var that = $(this);
        var more = that.attr('data-more');
        var getSort = that.attr('data-getSort');
        var min_id = that.attr('data-minId');

        var item_option = $(this).parents('.item-option');

        if(more == 'more')
        {
            $.post(
                "/item/comment/get",
                {
                    _token: $('meta[name="_token"]').attr('content'),
                    item_id: item_option.attr('data-item'),
                    min_id: min_id,
                    type: 1
                },
                function(data){
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        item_option.find('.comment-list-container').append(data.data.html);

                        item_option.find('.comments-more').attr("data-getSort",getSort);
                        item_option.find('.comments-more').attr("data-maxId",data.data.max_id);
                        item_option.find('.comments-more').attr("data-minId",data.data.min_id);
                        item_option.find('.comments-more').attr("data-more",data.data.more);
                        if(data.data.more == 'more')
                        {
                            item_option.find('.comments-more').html("更多");
                        }
                        else if(data.data.more == 'none')
                        {
                            item_option.find('.comments-more').html("我是有底的！");
                        }
                    }
                },
                'json'
            );
        }
        else if(more == 'none')
        {
            layer.msg('没有更多评论了', function(){});
        }
    });


    // 选择支持方
    $(".item-option").off("click","input[name=get-support]").on('click', "input[name=get-support]", function() {
        var that = $(this);
        var item_option = $(this).parents('.item-option');
        item_option.find('.comments-get').click();
    });


    // 显示对评论的回复
    $(".item-option").off("click",".comment-reply-toggle").on('click', ".comment-reply-toggle", function() {
        var comment_option = $(this).parents('.comment-option');
        comment_option.find(".comment-reply-input-container").toggle();
    });
    // 发布对评论的回复
    $(".item-option").off("click",".comment-reply-submit").on('click', ".comment-reply-submit", function() {
        var that = $(this);
        var item_option = $(this).parents('.item-option');
        var comment_option = $(this).parents('.comment-option');

        var item_id = item_option.attr('data-item');
        var comment_id = comment_option.attr('data-id');

        var content_input = comment_option.find('.comment-reply-content');
        var content = content_input.val();

        if(content == "")
        {
            layer.msg('请输入回复',function(){});
            return false;
        }

        $.post(
            "/item/reply/save",
            {
                _token: $('meta[name="_token"]').attr('content'),
                type: 1,
                item_id: item_id,
                comment_id: comment_id,
                content: content
            },
            function(data){
                if(!data.success) layer.msg(data.msg);
                else
                {
                    content_input.val('');
                    comment_option.find('.reply-list-container').prepend(data.data.html);
                }
            },
            'json'
        );
    });


    // 显示对回复的回复
    $(".item-option").off("click",".reply-toggle").on('click', ".reply-toggle", function() {
        var reply_option = $(this).parents('.reply-option');
        reply_option.find(".reply-input-container").toggle();
    });
    // 发布对回复的回复
    $(".item-option").off("click",".reply-submit").on('click', ".reply-submit", function() {
        var that = $(this);
        var item_option = $(this).parents('.item-option');
        var comment_option = $(this).parents('.comment-option');
        var reply_option = $(this).parents('.reply-option');

        var item_id = item_option.attr('data-item');
        var reply_id = reply_option.attr('data-id');

        var content_input = reply_option.find('.reply-content');
        var content = content_input.val();

        if(content == "")
        {
            layer.msg('请输入回复',function(){});
            return false;
        }

        $.post(
            "/item/reply/save",
            {
                _token: $('meta[name="_token"]').attr('content'),
                type: 1,
                item_id: item_id,
                comment_id: reply_id,
                content: content
            },
            function(data){
                if(!data.success) layer.msg(data.msg);
                else
                {
                    content_input.val('');
                    comment_option.find('.reply-list-container').prepend(data.data.html);
                }
            },
            'json'
        );
    });


    // 更多回复
    $(".item-option").off("click",".replies-more").on('click', ".replies-more", function() {

        var that = $(this);
        var more = that.attr('data-more');
        var getSort = that.attr('data-getSort');
        var min_id = that.attr('data-minId');

        var item_option = $(this).parents('.item-option');
        var comment_option = $(this).parents('.comment-option');

        if(more == 'more')
        {
            $.post(
                "/item/reply/get",
                {
                    _token: $('meta[name="_token"]').attr('content'),
                    item_id: item_option.attr('data-item'),
                    comment_id: comment_option.attr('data-id'),
                    min_id: min_id,
                    type: 1
                },
                function(data){
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        comment_option.find('.reply-list-container').append(data.data.html);

                        comment_option.find('.replies-more').attr("data-getSort",getSort);
                        comment_option.find('.replies-more').attr("data-maxId",data.data.max_id);
                        comment_option.find('.replies-more').attr("data-minId",data.data.min_id);
                        comment_option.find('.replies-more').attr("data-more",data.data.more);
                        if(data.data.more == 'more')
                        {
                            comment_option.find('.replies-more').html("更多");
                        }
                        else if(data.data.more == 'none')
                        {
                            comment_option.find('.replies-more').html("没有更多回复了");
                        }
                    }
                },
                'json'
            );
        }
        else if(more == 'none')
        {
            layer.msg('没有更多回复了', function(){});
        }
    });


    // 发布对回复的点赞
    $(".item-option").off("click",".comment-favor-this").on('click', ".comment-favor-this", function() {
        var that = $(this);
        var that_parent = that.attr('data-parent');
        var reply_option = $(this).parents(that_parent);
        var item_option = $(this).parents('.item-option');

        var item_id = item_option.attr('data-item');
        var comment_id = reply_option.attr('data-id');

        $.post(
            "/item/comment/favor/save",
            {
                _token: $('meta[name="_token"]').attr('content'),
                type: 5,
                item_id: item_id,
                comment_id: comment_id
            },
            function(data){
                if(!data.success) layer.msg(data.msg);
                else
                {
                    layer.msg("点赞成功");

                    that.addClass('comment-favor-this-cancel');
                    that.removeClass('comment-favor-this');
                    var btn = that.parents('.comment-favor-btn');
                    var num = parseInt(btn.attr('data-num'));
                    num = num + 1;
                    btn.attr('data-num',num);
                    var html = '<i class="fa fa-thumbs-up text-red"></i>('+num+')';
                    that.html(html);
                }
            },
            'json'
        );
    });
    // 取消点赞
    $(".item-option").off("click",".comment-favor-this-cancel").on('click', ".comment-favor-this-cancel", function() {
        var that = $(this);
        var that_parent = that.attr('data-parent');
        var reply_option = $(this).parents(that_parent);
        var item_option = $(this).parents('.item-option');

        var item_id = item_option.attr('data-item');
        var comment_id = reply_option.attr('data-id');

        $.post(
            "/item/comment/favor/cancel",
            {
                _token: $('meta[name="_token"]').attr('content'),
                type: 5,
                item_id: item_id,
                comment_id: comment_id
            },
            function(data){
                if(!data.success) layer.msg(data.msg);
                else
                {
                    layer.msg("取消点赞");

                    that.addClass('comment-favor-this');
                    that.removeClass('comment-favor-this-cancel');
                    var btn = that.parents('.comment-favor-btn');
                    var num = parseInt(btn.attr('data-num'));
                    num = num - 1;
                    btn.attr('data-num',num);
                    // if(num == 0) num = '';
                    var html = '<i class="fa fa-thumbs-o-up"></i>('+num+')';
                    that.html(html);
                }
            },
            'json'
        );
    });





    // 全部展开
    $(".side-menu").on('click', '.fold-down', function () {
        $('.recursion-row').each( function () {
            $(this).show();
            $(this).find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');
        });
    });
    // 全部收起
    $(".side-menu").on('click', '.fold-up', function () {
        $('.recursion-row').each( function () {
            if($(this).attr('data-level') != 0) $(this).hide();
            $(this).find('.recursion-fold').removeClass('fa-minus-square').addClass('fa-plus-square');
        });
    });
    // 收起
    $(".side-menu").on('click', '.recursion-row .fa-minus-square', function () {
        var this_row = $(this).parents('.recursion-row');
        var this_level = this_row.attr('data-level');
        this_row.nextUntil('.recursion-row[data-level='+this_level+']').each( function () {
            if($(this).attr('data-level') <= this_level ) return false;
            $(this).hide();
        });
        $(this).removeClass('fa-minus-square').addClass('fa-plus-square');
    });
    // 展开
    $(".side-menu").on('click', '.recursion-row .fa-plus-square', function () {
        var this_row = $(this).parents('.recursion-row');
        var this_level = this_row.attr('data-level');
        this_row.nextUntil('.recursion-row[data-level='+this_level+']').each( function () {
            if($(this).attr('data-level') <= this_level ) return false;
            $(this).find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');
            $(this).show();
        });
        $(this).removeClass('fa-plus-square').addClass('fa-minus-square');
    });





});

// 初始化展开
function fold()
{

    var item_active = $('.side-menu .recursion-item.active');
    if(item_active.length > 0)
    {
        console.log(1);
        var item_a = item_active.find('a').clone();
        $('.prev-content').find('.a-box').html('已经是封页了');

        var content_first = $('.side-menu .recursion-row').first();
        $('.next-content').find('.a-box').html(content_first.find('a').clone());
    }

    $(".recursion-row .active").each(function() {

        console.log(12);
        var this_row = $(this).parents('.recursion-row');
        var this_level = this_row.attr('data-level');
        this_row.find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');

        var prev_row = this_row.prev(".recursion-row");
        var next_row = this_row.next(".recursion-row");

        if(prev_row.length == 0)
        {
            var item_a = $('.side-menu .recursion-item').find('a').clone();
            $('.prev-content').find('.a-box').html(item_a);
        }
        else
        {
            $('.prev-content').find('.a-box').html(prev_row.find('a').clone());
        }

        if(next_row.length == 0)
        {
            $('.next-content').find('.a-box').html('已经是最后了');
        }
        else
        {
            $('.next-content').find('.a-box').html(next_row.find('a').clone());
        }


        // console.log(prev_row);

        if(this_level == 0)
        {
            this_row.nextUntil('.recursion-row[data-level='+this_level+']').each( function () {
                if($(this).attr('data-level') <= this_level ) return false;
                $(this).show();
                $(this).find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');
            });
        }
        else if(this_level > 0)
        {
            this_row.prevUntil().each( function ()
            {
                if( $(this).attr('data-level') == 0 )
                {
                    $(this).find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');

                    $(this).nextUntil('.recursion-row[data-level=0]').show();
                    $(this).nextUntil('.recursion-row[data-level=0]').find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');
                    return false;
                }
            });
        }

    });

}

