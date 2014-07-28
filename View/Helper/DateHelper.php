<?php

class DateHelper extends Helper {
	
	public function format($date){
		return date(Configure::read('date_format'), strtotime($date));
	}	
	
	public function nameFormat($date){
		return date('d M, Y', strtotime($date));
	}
	
	public function daysBetween($d1, $d2)
	{
		return ceil((strtotime($d2) - strtotime($d1)) / (60 * 60 * 24));
	}

    public function getBoundaries($dates){
        $ini = $fin = array();
        foreach($dates as $date){
            $ini[] = $date['from'];
            $fin[] = $date['to'];
        }
        rsort($fin);
        sort($ini);
        if(!empty($ini) && !empty($fin))
            return array($ini[0],$fin[0]);
        else
            return array(date('Y-m-d'),date('Y-m-d', strtotime('+1 year')));
    }
	
	public function getDates($start, $end){
		$dates[date('Y',strtotime($start))][date('n',strtotime($start))] = array(date('j',strtotime($start)));
		$last = $start;
		while(strtotime($last) < strtotime($end)){
			$next = date('Y-m-d ', strtotime('+1 day', strtotime($last)));
			$dates[date('Y',strtotime($next))][date('n',strtotime($next))][] = date('j',strtotime($next));
			$last = $next;
		}
		return $dates; 
	}
	
	public function getMonths(){
		return array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dic');
	}
	
	//Returns the next recurring date
	public function recurring($type, $from, $to = null)
	{
		if($to)
			if(strtotime( date('Y-m-d') ) < strtotime($from))
				return $this->nextDate($type, $from);
			else
				return false;
		else
			return $this->nextDate($type, $from);
	}
	
	//Returns the next recurring date
	public function nextDate($type, $from){
		$out = false;
		switch($type){
			case 1:
				$out = date('Y-m-d', strtotime ( '+1 week' , strtotime ( $from )));
				break;
			case 2:
				$out = date('Y-m-d', strtotime ( '+2 week' , strtotime ( $from )));
				break;
			case 3:
				$out = date('Y-m-d', strtotime ( '+1 month' , strtotime ( $from )));
				break;
			case 4:
				$out = date('Y-m-d', strtotime ( '+2 month' , strtotime ( $from )));
				break;	
			case 5:
				$out = date('Y-m-d', strtotime ( '+3 month' , strtotime ( $from )));
				break;
			case 6:
				$out = date('Y-m-d', strtotime ( '+6 month' , strtotime ( $from )));
				break;
			case 7:
				$out = date('Y-m-d', strtotime ( '+1 year' , strtotime ( $from )));
				break;
			case 8:
				$out = date('Y-m-d', strtotime ( '+2 year' , strtotime ( $from )));
				break;				
		}
		return $out;
	}

    //Date is type datetime
    public function prettyfy($date){
        $parts = explode('-', $date);
        $out = '<span class="date">';
        $out .= '<span class="day">'.$parts[2].' </span>';
        $out .= '<span class="month">'.date('M', strtotime($date)).' </span>';
        $out .= '<span class="year">'.$parts[0].' </span>';
        $out .= '</span>';
        return $out;
    }

    public function prettyViewInline($date){
        echo '<div class="update-date-inline">';
        echo '<span class="update-day">'.substr($this->nameFormat($date),0,2).'</span> ';
        echo '<span class="update-month">'.substr($this->nameFormat($date),2,4).'</span> ';
        echo '</div>';
    }

    public function prettyViewComplete($date){
        echo '<div class="update-date">';
        echo '<span class="update-day">'.substr($this->nameFormat($date),0,2).'</span>';
        echo substr($this->nameFormat($date),2,4);
        echo substr($this->nameFormat($date),7,10);
        echo '</div>';
    }

    public function calendarView($date){
        $out =  '<div class="dateEvent">';
        $out .= '<div class="dateEventMonth">'.substr($this->nameFormat($date),2,4).'</div>';
        $out .= '<div class="dateEventDay">'.substr($this->nameFormat($date),0,2).'</div>';
        $out .= '<div class="dateEventYear">'.substr($this->nameFormat($date),7,10).'</div>';
        $out .= '</div>';
        return $out;
    }

    public function timeago($timestamp){
        //type cast, current time, difference in timestamps
        $timestamp      = (int) $timestamp;
        $current_time   = time();
        $diff           = $current_time - $timestamp;

        //intervals in seconds
        $intervals      = array (
            'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
        );

        //now we just find the difference
        if ($diff == 0)
        {
            return 'just now';
        }

        if ($diff < 60)
        {
            return $diff == 1 ? $diff . ' second ago' : $diff . ' seconds ago';
        }

        if ($diff >= 60 && $diff < $intervals['hour'])
        {
            $diff = floor($diff/$intervals['minute']);
            return $diff == 1 ? $diff . ' minute ago' : $diff . ' minutes ago';
        }

        if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
        {
            $diff = floor($diff/$intervals['hour']);
            return $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago';
        }

        if ($diff >= $intervals['day'] && $diff < $intervals['week'])
        {
            $diff = floor($diff/$intervals['day']);
            return $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
        }

        if ($diff >= $intervals['week'] && $diff < $intervals['month'])
        {
            $diff = floor($diff/$intervals['week']);
            return $diff == 1 ? $diff . ' week ago' : $diff . ' weeks ago';
        }

        if ($diff >= $intervals['month'] && $diff < $intervals['year'])
        {
            $diff = floor($diff/$intervals['month']);
            return $diff == 1 ? $diff . ' month ago' : $diff . ' months ago';
        }

        if ($diff >= $intervals['year'])
        {
            $diff = floor($diff/$intervals['year']);
            return $diff == 1 ? $diff . ' year ago' : $diff . ' years ago';
        }
    }
}

