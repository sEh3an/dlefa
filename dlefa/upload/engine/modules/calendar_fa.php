<?php
/*
=====================================================
 DataLife Engine v13.1
-----------------------------------------------------
 Translate & Develope :
	Seyed Ehsan Setarehdan   - Eh3an@Setarehdan.ir
-----------------------------------------------------
 FileName :  engine/modules/calendar_fa.php
-----------------------------------------------------
 Copyright (c) 2018, All rights reserved.
=====================================================
*/

if( !defined('DATALIFEENGINE') ) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../' );
	die( "Hacking attempt!" );
}

$is_change = false;

if ( !$config['allow_cache'] ) { $config['allow_cache'] = 1; $is_change = true;}

if ( $config['allow_calendar'] ) {

	$tpl->result['calendar'] = dle_cache("calendar" . $year . $month . $day, $config['skin']);
	
	if( 1  ){
		
		$events = array();
		
		$thisdate = date("Y-m-d H:i:s", $_TIME);
		$jmonth = jdate("m", $_TIME);
		$jyear = jdate("Y" , $_TIME);	
		$this_startm = date("Y-m-d H:i:s", jmaketime(0, 0, 0, $jmonth, 1, $jyear));
		$this_endm = date("Y-m-d H:i:s", jmaketime(0, 0, 0, ($jmonth+1), 1, $jyear));
		$startm = date("Y-m-d H:i:s", jmaketime(0, 0, 0, $month, 1, $year));
		$endm = date("Y-m-d H:i:s", jmaketime(0, 0, 0, ($month+1), 1, $year));
		
		if ($year != '' and $month != ''){		
			if (($year == $jyear AND $month > $jmonth) OR ($year > $jyear)) {
				$sql = "";
			} else {
				$sql = "SELECT date FROM " . PREFIX . "_post WHERE date BETWEEN '$startm' AND '$endm' AND approve = '1'";
			}
			$jmonth = $month; 
			$jyear  = $year;
		} else{
			$sql = "SELECT date FROM " . PREFIX . "_post WHERE date BETWEEN '$this_startm' AND '$this_endm' AND approve = '1'";
		}

		if ($sql != "" ) {
			$db->query($sql);
			while($row = $db->get_row()){
				$datetime = strtotime($row['date']) + ($config['date_adjust'] * 60);
				$tday = jdate("d", $datetime);
				$tmonth = jdate("m", $datetime);
				$tyear = jdate("Y", $datetime);
				$events[$tday] = jmaketime(0,0,0,$tmonth,$tday,$tyear);
			}
			$db->free();
		}
		
		$jmonth = intval($jmonth);
		$jyear  = intval($jyear);
		$pre_month = $jmonth-1;
		$next_month = $jmonth+1;	
		$pre_year = $jyear-1;
		$next_year = $jyear+1;
		$prev_of_month = jmaketime(0, 0, 0, ($pre_month == 0 ? "12" : $pre_month), 1, ($pre_month == 0 ? $pre_year : $jyear));
		$next_of_month = jmaketime(0, 0, 0, ($next_month == 13 ? "1" : $next_month), 1, ($next_month == 13 ? $next_year : $jyear));
		$prev_of_year = jmaketime(0, 0, 0, $jmonth, 1, $pre_year);
		$next_of_year = jmaketime(0, 0, 0, $jmonth, 1, $next_year);
		$first_of_month = jmaketime(0, 0, 0, $jmonth, 1, $jyear);
		$maxdays = jdate('t', $first_of_month); //29-31
		$cal_day = 1;
		$weekday = date('w', ($first_of_month + 86400)); //0-6
		
		if ($config['allow_alt_url']) {
			$date_link['prev'] = '<a class="monthlink" onClick="doCalendar('.jdate("'m','Y'", $prev_of_month).'); return false;" href="'.$config['http_home_url'].($pre_month == 0 ? $jyear-1 : $jyear).'/'.($pre_month == 0 ? "12" : $pre_month).'/" title="'.$lang['prev_moth'].'">&laquo;</a>&nbsp;&nbsp;';
			$date_link['next'] = '&nbsp;&nbsp;<a class="monthlink" onClick="doCalendar('.jdate("'m','Y'", $next_of_month).'); return false;" href="'.$config['http_home_url'].($next_month == 13 ? $jyear+1 : $jyear).'/'.($next_month == 13 ? "1" : $next_month).'/" title="'.$lang['next_moth'].'">&raquo;</a>';
			$date_link['prev_y'] = '<a class="monthlink" onClick="doCalendar('.jdate("'m','Y'", $prev_of_year).'); return false;" href="'.$config['http_home_url'].$pre_year.'/'.$jmonth.'/" title="'.$lang['prev_year'].'">&lt;</a>&nbsp;&nbsp;&nbsp;&nbsp;';
			$date_link['next_y'] = '&nbsp;&nbsp;&nbsp;&nbsp;<a class="monthlink" onClick="doCalendar('.jdate("'m','Y'", $next_of_year).'); return false;" href="'.$config['http_home_url'].$next_year.'/'.$jmonth.'/" title="'.$lang['next_year'].'">&gt;</a>';
		} else {
			$date_link['prev'] = '<a class="monthlink" onClick="doCalendar('.jdate("'m','Y'", $prev_of_month).'); return false;" href="'.$PHP_SELF.'?year='.($pre_month == 0 ? $jyear-1 : $jyear).'&month='.($pre_month == 0 ? "12" : $pre_month).'" title="'.$lang['prev_moth'].'">&laquo;</a>&nbsp;&nbsp;';
			$date_link['next'] = '&nbsp;&nbsp;<a class="monthlink" onClick="doCalendar('.jdate("'m','Y'", $next_of_month).'); return false;" href="'.$PHP_SELF.'?year='.($next_month == 13 ? $jyear+1 : $jyear).'&month='.($next_month == 13 ? "1" : $next_month).'" title="'.$lang['next_moth'].'">&raquo;</a>';
			$date_link['prev_y'] = '<a class="monthlink" onClick="doCalendar('.jdate("'m','Y'", $prev_of_year).'); return false;" href="'.$PHP_SELF.'?year='.$pre_year.'&month='.$jmonth.'" title="'.$lang['prev_year'].'">&lt;</a>&nbsp;&nbsp;&nbsp;&nbsp;';
			$date_link['next_y'] = '&nbsp;&nbsp;&nbsp;&nbsp;<a class="monthlink" onClick="doCalendar('.jdate("'m','Y'", $next_of_year).'); return false;" href="'.$PHP_SELF.'?year='.$next_year.'&month='.$jmonth.'" title="'.$lang['next_year'].'">&gt;</a>';
		}
		
		$buffer  = '
		<div id="calendar-layer">
		<table id="calendar" cellpadding="3" class="calendar">
			<caption>
				<strong>' . $date_link['prev_y'] . $date_link['prev'] . langdate( 'F', $first_of_month ) . ' ' . $jyear . $date_link['next'] . $date_link['next_y'] . '</th>
			</caption>
			<thead>
		<tr>';
		
		$langdateshortweekdays = $lang['date']['shortweek'];

		for ($it=0; $it<=5; $it++)
			$buffer .= '<th class="workday">' . $langdateshortweekdays[$it] . '</th>';
		
		$buffer .= '<th class="weekday">' . $langdateshortweekdays[6] . '</th>';
		
		$buffer .= ($weekday > 0 && $weekday <= 6) ? '</thead><tr align="center"><td colspan="' . $weekday . '">&nbsp;</td>' : '<tr align="center">';
		
		list( $todayjyear, $todayjmonth, $todayjday ) = gregorian_to_jalali(date("Y"), date("m"), date("d"));
		$days = 1;

		while($maxdays >= $cal_day) {
			if ($weekday == 7) {
				$buffer .= '</tr><tr align="center">';
				$weekday = 0;
			}
			
			if ($days < 10) $days = "0" . $days;

			if (isset($events[$days])){

				$date['title'] = langdate('d F Y', $events[$days]);			

				if ($weekday == '6'){

					$class = $todayjday == $days && ($jmonth == $todayjmonth) && ($jyear == $todayjyear) ? 'day-current' : 'day-active';
				
					if ($config['allow_alt_url'])
						$buffer .= '<td class="' . $class . '"><a class="day-active" href="' . $config['http_home_url'] . ''.jdate("Y/m/d", $events[$days]) . '/" title="' . $lang['cal_post'] . ' ' . $date['title'] . '">' . $cal_day . '</a></td>';
					else
						$buffer .= '<td class="' . $class . '"><a class="day-active" href="' . $PHP_SELF . '?year='.jdate("Y", $events[$days]) . '&month='.jdate("m", $events[$days]) . '&day='.jdate("d", $events[$days]) . '" title="' . $lang['cal_post'] . ' ' . $date['title'] . '">' . $cal_day . '</a></td>';

				} else {
					$class = $todayjday == $days && ($jmonth == $todayjmonth) && ($jyear == $todayjyear) ? 'day-current' : 'day-active-v';
					
					if ($config['allow_alt_url'])
						$buffer .= '<td class="' . $class . '"><a class="day-active-v" href="' . $config['http_home_url'] . ''.jdate("Y/m/d", $events[$days]) . '/" title="' . $lang['cal_post'] . ' ' . $date[title] . '">' . $cal_day . '</a></td>';
					else
						$buffer .= '<td class="' . $class . '"><a class="day-active-v" href="' . $PHP_SELF . '?year='.jdate("Y", $events[$days]) . '&month='.jdate("m", $events[$days]) . '&day='.jdate("d", $events[$days]) . '" title="' . $lang['cal_post'] . ' ' . $date[title] . '">' . $cal_day . '</a></td>';

				}
			} else {
				if ($todayjday == $days && ($jmonth == $todayjmonth) && ($jyear == $todayjyear)) 
				$buffer .= '<td class="day-current">' . $cal_day . '</td>';
				elseif ($weekday == "6") $buffer .= '<td class="weekday">' . $cal_day . '</td>';
				else $buffer .= '<td class="day">' . $cal_day . '</td>';
			}

			$cal_day++;
			$weekday++;
			$days++;
		}

		if ($weekday != 7){$buffer .= '<td colspan="' . (7 - $weekday) . '">&nbsp;</td>';}

		$tpl->result['calendar'] = $buffer . '</tr></table></div>';
	}
	
	create_cache("calendar" . $year . $month . $day, $tpl->result['calendar'], $config['skin']);

}


if( $config['allow_archives']) {
	
	$tpl->result['archive'] = dle_cache( "archives", $config['skin'] );
	
	if( ! $tpl->result['archive'] ) {
  
		$added_time = time() + ($config['date_adjust'] * 60);
		$db->query("SELECT MIN(date), date FROM " . PREFIX . "_post GROUP BY date");
		$row = $db->get_row();
		$post_year = jdate("Y", strtotime($row['date']) + $added_time);
		$post_month = jdate("m", strtotime($row['date']) + $added_time);
		
		$month_jalali = jdate("m", $_TIME)+1;
		$year_jalali = jdate("Y", $_TIME);
		if ($month_jalali > 12) {
			$month_jalali = 1;
			$year_jalali++;
		}  
		
		while( jmaketime( 0, 0, 0, $month_jalali, 1, $year_jalali ) >= -abs( jmaketime( 0, 0, 0, $post_month, 1, $post_year ) ) ){
			$nextmonth_jalali = $month_jalali - 1;
			$nextyear_jalali = $year_jalali;
			if ($nextmonth_jalali < 1) {
				$nextmonth_jalali = 12;
				$nextyear_jalali--;
			}
					
			$thistime = jmaketime(0,0,0,$nextmonth_jalali,1,$nextyear_jalali);
			$thisdate = date("Y-m-d H:i:s", $thistime);
			$nextdate = date("Y-m-d H:i:s", jmaketime(0,0,0,$month_jalali,1,$year_jalali));
		   
			$db->query("SELECT id FROM " . PREFIX . "_post WHERE approve = '1' AND date >= '$thisdate' AND date < '$nextdate'");
			$count = $db->num_rows();
			
			if ($count > 0) {
				$arch_title['fa'] = jdate("F", $thistime);
				$arch_url[0] = jdate("m", $thistime);
				$arch_url[1] = jdate("Y", $thistime);
                if( $config['allow_alt_url']) $news_archive[] = '<a class="archives" href="' . $config['http_home_url'] . "$arch_url[1]/$arch_url[0]" . '"><b>' . $arch_title['fa'] . " " . $arch_url[1] . ' (' . $count . ')</b></a>';
                else $news_archive[] = "<a class=\"archives\" href=\"$PHP_SELF?year=$arch_url[1]&amp;month=$arch_url[0]\"><b>" . $arch_title['fa'] . " (" . $count . ")</b></a>";
			}
			
			$month_jalali = $nextmonth_jalali;
			$year_jalali = $nextyear_jalali;	
			
		}
		
		$db->free();
		
		$i = count( $news_archive );
		
		if( $i > 6 ) {
			$news_archive[6] = "<div id=\"dle_news_archive\" style=\"display:none;\">" . $news_archive[6];
			$news_archive[] = "</div><div id=\"dle_news_archive_link\" ><br /><a class=\"archives\" onclick=\"$('#dle_news_archive').toggle('blind',{},700); return false;\" href=\"#\">" . $lang['show_archive'] . "</a></div>";
		}
		
		if( $i ) $tpl->result['archive'] = implode( "<br />", $news_archive );
		else $tpl->result['archive'] = "";
		create_cache( "archives", $tpl->result['archive'], $config['skin'] );
	}

}

if ( $mod == "calendar" )
	echo $tpl->result['calendar'];
else if ( $mod == "archives" )
	echo $tpl->result['archive'];


if ($is_change) $config['allow_cache'] = false;

?>