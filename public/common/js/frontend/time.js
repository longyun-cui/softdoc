jQuery( function ($) {

    $("#calendar").on("click", ".sc-item:not(.sc-othermenth)", function() {
        $(".sc-item").removeClass("sc-active-day");
        $(this).addClass("sc-active-day");
        var $day = $(this).find('.day').html();
        $("#calendar").attr('data-day', $day);

        $calendar_id = $("#calendar").attr('data-calendar');
        console.log($calendar_id);

        $("#"+$calendar_id).find(".item-option").hide();
        $("#"+$calendar_id).find(".item-option[data-calendar-days*='calendar-day-"+$calendar_id+"-"+$day+"']").show();
    });

});


function getMonthSchedule($year,$month)
{
    // console.log($year+"-"+$month);
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


// 显示 日历 日程数
function show_calendar_num(schedule_ctn)
{
    var calendar_ctn = $(schedule_ctn).attr("data-ctn");
    var the_month = $(schedule_ctn).attr("data-id");
    var items = schedule_ctn + " .item-container";

    $(calendar_ctn).find(".agendaN").attr("data-num","0");
    $(calendar_ctn).find(".agendaN").html("");

    $(items).each( function() {
        var time_type = $(this).attr("data-time-type");
        if(time_type == 1) {
            var days = $(this).attr("data-days").split(" ");
            for(var j=0; j<days.length ;j++) {
                var the_day = days[j].split(".");
                if(the_day[0] == the_month) {
                    var xx = "._day[data-day=" + the_day[1] + "]";
                    var agendaN = $(calendar_ctn).find(xx).find(".agendaN");
                    agendaN.attr("data-num",parseInt(agendaN.attr("data-num")) + 1);
                    agendaN.html(agendaN.attr("data-num"));
                }
            }
        } else {
            var weeks = $(this).attr("data-weeks").split(" ");//alert(weeks[0]);
            for(var k=0; k<weeks.length ;k++) {
                var yy = "._day[data-day!=''][data-week=" + weeks[k] + "]";
                $(calendar_ctn).find(yy).each( function() {
                    var agendaNx = $(this).find(".agendaN");
                    agendaNx.attr("data-num",parseInt(agendaNx.attr("data-num")) + 1);
                    agendaNx.html(agendaNx.attr("data-num"));
                });
                //var agendaN = $(calendar_ctn).find(yy).parent().find(".agendaN");
                //agendaN.attr("data-num",parseInt(agendaN.attr("data-num")) + 1);
                //agendaN.html(agendaN.attr("data-num"));
            }
        }
        $(".calendar_month ._day").removeClass("time-selected");
        $(this).addClass("time-selected");
    });
}
