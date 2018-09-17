jQuery( function ($) {

    console.log("time.js");

    $("#calendar").on("click", ".sc-item:not(.sc-othermenth)", function() {
        $(".sc-item").removeClass("sc-active-day");
        $(this).addClass("sc-active-day");
        var $day = $(this).find('.day').html();
        $("#calendar").attr('data-day', $day);
    });

});


function getMonthSchedule($year,$month)
{
    console.log($year+"-"+$month);
    var result;
    jQuery.ajax
    ({
        url:"/ajax/get/schedule",
        async:false,
        cache:false,
        type:"post",
        dataType:'json',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            year:$year,
            month:$month//,
            //_token:$('meta[name="_token"]').attr('content')
        },
        success:function(data) {
            //result = $.trim(data);
            result = data;//layer.msg(result);
        },
        error: function(xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
    return result;
}
