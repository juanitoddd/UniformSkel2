<?php

class GanttHelper extends Helper {

    public $helpers = array('Wwr');

    private $_width = 6;

    public function setWidth($_width){
        $this->_width = $_width;
    }

    public function width($dates){
        $contWidth = 0;
        foreach($dates as $year){
            foreach($year as $month){
                $contWidth = $contWidth + ($this->_width * count($month));
            }
        }
        return $contWidth;
    }

    public function days($dates){
        $totalDays = 0;
        foreach($dates as $year){
            foreach($year as $month){
                $totalDays = $totalDays + count($month);
            }
        }
        return $totalDays;
    }

    public function daysBetween($d1, $d2)
    {
        return (strtotime($d2) - strtotime($d1)) / (60 * 60 * 24);
    }

    public function header_years($dates){
        $y = '';
        $contWidth = 0;
        foreach($dates as $year => $months){
            $days = 0;
            foreach($months as $month)
                $days += count($month);
            $width = $this->_width * $days;
            $y .= '<div class="ganttview-hzheader-year" style="width:'.($width - 1).'px">' . $year . '</div>';
            $contWidth = $contWidth + $width;
        }
        echo '<div class="ganttview-hzheader-years" style="width:'.$contWidth.'px">';
        echo $y;
        echo '</div>';
    }

    public function header_months($dates){
        $names = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dec');
        $months = '';
        $contWidth = 0;
        foreach($dates as $y => $year){
            foreach($year as $key => $month){
                $width = $this->_width * count($month);
                $months .= '<div class="ganttview-hzheader-month" style="width:'.($width - 1).'px" data-length="'.count($month).'">'.__($names[$key-1]) . ' ' .$y .'</div>';
                $contWidth = $contWidth + $width;
            }
        }
        echo '<div class="ganttview-hzheader-months" style="width:'.$contWidth.'px">';
        echo $months;
        echo '</div>';
    }

    public function header_weeks($dates){
        $names = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dec');
        $weeks = '';
        $contWidth = 0;
        $i = 1;
        $from = $to = '';
        foreach($dates as $years => $year){
            foreach($year as $months => $month){
                //debug($month);
                foreach($month as $day){
                    $date = date('N',mktime(0,0,0,$months,$day,$years));
                    if($date % 7 == 1)
                        $from = $day;
                    if($date % 7 == 0){
                        //$width = $this->_width * $i;
                        $width = 6 * $i;
                        $weeks .= '<div class="ganttview-hzheader-week" data-length="'.$i.'" style="width:'.($width - 1).'px">'.$from.'-'.$day.'</div>';
                        $contWidth = $contWidth + $width;
                        $i = 1;
                        $from = $to = '';
                    }else
                        $i++;
                }
            }
        }
        echo '<div class="ganttview-hzheader-weeks" style="width:'.$contWidth.'px">';
        echo $weeks;
        echo '</div>';
    }

    public function header_days($dates){
        $days = '';
        $contWidth = 0;
        foreach($dates as $years => $year){
            foreach($year as $months => $month){
                $width = $this->_width * count($month);
                foreach($month as $day){
                    $date = date('N',mktime(0,0,0,$months,$day,$years));
                    $class = ($date % 7 == 6 || $date % 7 == 0) ? 'ganttview-hzheader-day weekend-header' : 'ganttview-hzheader-day';
                    $days .= '<div class="'.$class.'" style="width:'.($this->_width - 1).'px">'.$day.'</div>';
                }
                $contWidth = $contWidth + $width;
            }
        }
        echo '<div class="ganttview-hzheader-days" style="width:'.$contWidth.'px">';
        echo $days;
        echo '</div>';
    }

    public function gridDays($dates, $size){
        $cells = '';
        $contWidth = 0;
        foreach($dates as $years => $year){
            foreach($year as $months => $month){
                $width = $this->_width * count($month);
                foreach($month as $day){
                    $date = date('N',mktime(0,0,0,$months,$day,$years));
                    $class = ($date % 7 == 6 || $date % 7 == 0) ? 'ganttview-grid-row-cell ganttview-weekend-day' : 'ganttview-grid-row-cell';
                    $cells .= '<div class="'.$class.'" style="width:'.($this->_width - 1).'px"></div>';
                }
                $contWidth = $contWidth + $width;
            }
        }
        $i = 0;
        for($j = 0; $j < $size; $j++){
            $class = ++$i == $size ? 'ganttview-grid-row ganttview-grid-row-last'	: 'ganttview-grid-row';
            echo '<div class="'.$class.'" style="width:'.$contWidth.'px;">';
            echo $cells;
            echo '</div>';
        }
    }

    public function gridMonths($dates, $size){
        $cells = '';
        $contWidth = 0;
        foreach($dates as $years => $year){
            foreach($year as $months => $month){
                //debug(count($month));
                $width = $this->_width * count($month);
                $class = 'ganttview-grid-row-cell';
                $cells .= '<div class="'.$class.'" style="width:'.($width - 1).'px"></div>';
                $contWidth = $contWidth + $width;
            }
        }
        $i = 0;
        for($j = 0; $j < $size; $j++){
            $class = ++$i == $size ? 'ganttview-grid-row ganttview-grid-row-last'	: 'ganttview-grid-row';
            echo '<div class="'.$class.'" style="width:'.$contWidth.'px;">';
            echo $cells;
            echo '</div>';
        }
    }

    public function blocks($apartments, $start, $end = null){
        foreach($apartments as $apartment){
            echo '<div id="apt-'. $apartment['Apartment']['id'].'" class="ganttview-block-container">';
            foreach($apartment['Booking'] as $booking){
                if($end){
                    if(strtotime($end) < strtotime($booking['to']))
                        $booking['to'] = $end;
                    if(strtotime($end) < strtotime($booking['from']))
                        continue;
                }
                $width = (($this->daysBetween($booking['from'], $booking['to']) + 1) * $this->_width); //+ 15;
                $margin = ($this->daysBetween($start, $booking['from']) * $this->_width);// + 3;
                //$block = '<div id="bkn-'.$booking['id'].'" data-width="'.($this->daysBetween($booking['from'], $booking['to'])+1).'" data-margin="'.$this->daysBetween($start, $booking['from']).'" class="ganttview-block '.$booking['status'].'" style="width:'.(($this->daysBetween($booking['from'], $booking['to']) + 1) * $this->_width).'px; margin-left:'.($this->daysBetween($start, $booking['from']) * $this->_width).'px;">'.$this->Wwr->bookingStatusLabel($label).'</div>';
                $block = '<div id="bkn-'.$booking['id'].'" data-width="'.($this->daysBetween($booking['from'], $booking['to'])+1).'" data-margin="'.$this->daysBetween($start, $booking['from']).'" class="ganttview-block '.$booking['status'].(isset($booking['class'])?$booking['class']:'').' '.$booking['author'].'" style="width:'.(($this->daysBetween($booking['from'], $booking['to']) + 1) * $this->_width).'px; margin-left:'.($this->daysBetween($start, $booking['from']) * $this->_width).'px;">'.$this->guestDisplay($booking).'</div>';
                echo $block;
            }
            echo '</div>';
        }
    }

    private function guestDisplay($booking){
        $delay24 = strpos($booking['status'], '24') ? '(<i class="icon-exclamation"></i>24) ':'';
        $delay48 = strpos($booking['status'], '48') ? '(<i class="icon-exclamation"></i>48) ':'';
        if($booking['id'] != 0){
            if($booking['author'] != 'partner')
                return '<span class="label label-'.$booking['status'].'">'.$delay24.$delay48.(empty($booking['User'])?$booking['name']:$booking['User']['firstname'].' '.$booking['User']['lastname']).'</span>';
            else
                return '<span class="label-partner">'.$booking['status'].'</span>';
        }else
            return '<span class="label label-new new-booking-user"></span>';
    }
}

