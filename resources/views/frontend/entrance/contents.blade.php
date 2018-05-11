<!DOCTYPE html>
<html>

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <!-- IE testing -->
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8">-->
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=9">-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{--<meta name="robots" content="noindex">--}}
        <title>课栈</title>
        <link rel="stylesheet" type="text/css" href="{{asset('templates/themes/match-height/zzsc.css')}}">
        <script type="text/javascript" src="{{asset('templates/themes/match-height/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('templates/themes/match-height/jquery.matchHeight.js')}}"></script>
        <script type="text/javascript">
            (function() {

                /* matchHeight example */

                $(function() {
                    // apply your matchHeight on DOM ready (they will be automatically re-applied on load or resize)

                    // get test settings
                    var byRow = $('body').hasClass('test-rows');

                    // apply matchHeight to each item container's items
                    $('.items-container').each(function() {
                        $(this).children('.item').matchHeight(byRow);
                    });

                    // example of removing matchHeight
                    $('.test-remove').click(function() {
                        $('.items-container').each(function() {
                            $(this).children('.item').matchHeight('remove');
                        });
                    });
                });

            })();
        </script>
    </head>

    <body class="test-match-height test-rows test-responsive test-border-box test-margin test-padding">

        <div class="container">



            <div class="items-container ">

                @foreach($contents as $num => $item)
                    <div class="item item-{{$loop->index%12}}">
                        <a target="_blank" href="{{url('/course/'.encode($item->course->id).'?content='.encode($item->id))}}">
                        <h4>{{$item->title}}</h4>
                        @if(!empty($item->cover_pic))
                            <img class="media-object" src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$item->cover_pic }}">
                        @else
                            <img class="media-object" src="{{ $item->img_tags[2][0] or '' }}">
                        @endif
                        <div>{!! $item->content !!}</div>
                        </a>
                    </div>
                @endforeach


            </div>

            <div class="items-container big-items">
                <div class="item item-1" style="height: 606px;">
                    <div class="items-container">
                        <div class="item item-2" style="height: 58px;">
                            <p>Aenean</p>
                        </div>
                        <div class="item item-3" style="height: 58px;">
                            <p>Lorem</p>
                        </div>
                        <div class="item item-4" style="height: 58px;">
                            <p>Phasellus</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="data-test-items">
                <div class="item item-0" data-match-height="items-a" style="height: 172px;">
                    <h3>data-match-height="items-a"</h3>
                    <p>Phasellus ut nibh fermentum, vulputate urna vel, semper diam. Nunc sollicitudin felis ut pellentesque fermentum. In erat mi, pulvinar sit amet tincidunt vitae, gravida id felis. Phasellus hendrerit erat sed porta imperdiet. Vivamus viverra ipsum tortor, et congue mauris porttitor ut.</p>
                </div>

            <div class="items-container fixed-items">
                <div class="item item-0" style="height: 150px;">
                    <p>Fixed height</p>
                </div>
                <div class="item item-1" style="height: 190px;">
                    <p>Fixed height</p>
                </div>
                <div class="item item-2" style="height: 230px;">
                    <p>Fixed height</p>
                </div>
                <div class="item item-3" style="height: 250px;">
                    <p>Fixed height</p>
                </div>
            </div>



        </div>

    </body>

</html>