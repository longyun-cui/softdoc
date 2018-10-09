<?php 
namespace App\Widgets;


class ItemWidget
{
	public function __construct()
	{
	}

	/**
	 * @param $tag
	 * @return array
	 */
	public function handleTag($tag)
	{
		$tags = explode(" ",$tag);
		return $tags;
	}

	/**
	 * @param $attaching
	 * @return array
	 */
	public function handleAttaching($attaching)
	{
		$attachings = explode("<|>",$attaching);
		foreach($attachings as $key => $value)
		{
			if(count($attachings) == 1) $tem["click"] = "One";
			$values = explode("-/",$value);
			$type = $values[0];
			$url = isset($values[1]) ? $values[1] : '';
			$tem["type"] = $type;
			$tem["origin"] = $url;
			if($type == "qingbo")
			{
				$tem["url"] = "/images/img160/".$url;
			} else if($type == "sinaimg")
			{
				$tem["url"] = "http://wx1.sinaimg.cn/thumb150/".$url;
			} else
			{
				$tem["url"] = $url;
			}
			$attachings[$key] = $tem;
		}
		return $attachings;
	}


    public function handleScheduleDays($start_time,$end_time)
    {
        $data_days = "";
        if($end_time == 0) $data_days .= date("Y-m.j", $start_time)." ";
        if($start_time == 0) $data_days .= date("Y-m.j", $end_time)." ";

        $day_start = strtotime(date("Y-n-j",$start_time));
        for($i=$day_start;$i<=$end_time;$i=$i+(3600*24))
        {
            $data_days .= date("Y-m.j",$i)." ";
        }
        return $data_days;
    }
    public function handleScheduleWeeks($start_time,$end_time)
    {
        $data_year_weeks = "";
        $day_start = strtotime(date("Y-n-j",$start_time));
        $year_week_start = $day_start - ((date("N",$start_time)-1)*3600*24);
        for($i=$year_week_start;$i<=$end_time;$i=$i+(3600*24*7))
        {
            $data_year_weeks .= date("Y.W",$i)." ";
        }
        return $data_year_weeks;
    }


}