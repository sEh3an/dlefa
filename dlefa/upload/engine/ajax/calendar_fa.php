<?php
/*
=====================================================
 DataLife Engine v13.1
-----------------------------------------------------
 Translate & Develope :
	Seyed Ehsan Setarehdan   - Eh3an@Setarehdan.ir
-----------------------------------------------------
 FileName :  engine/ajax/calendar_fa.php
-----------------------------------------------------
 Copyright (c) 2018, All rights reserved.
=====================================================
*/


if(!defined('DATALIFEENGINE')) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../' );
	die( "Hacking attempt!" );
}

@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

define( 'ROOT_DIR', substr( dirname(  __FILE__ ), 0, -12 ) );
define( 'ENGINE_DIR', ROOT_DIR . '/engine' );

include ENGINE_DIR . '/data/config.php';

date_default_timezone_set ( $config['date_adjust'] );

if( $config['http_home_url'] == "" ) {
	
	$config['http_home_url'] = explode( "engine/ajax/calendar_fa.php", $_SERVER['PHP_SELF'] );
	$config['http_home_url'] = reset( $config['http_home_url'] );
	$config['http_home_url'] = "https://" . $_SERVER['HTTP_HOST'] . $config['http_home_url'];

}

require_once ENGINE_DIR . '/classes/mysql.php';
require_once ENGINE_DIR . '/data/dbconfig.php';

$PHP_SELF = $config['http_home_url'] . "index.php";

require_once ENGINE_DIR . '/modules/functions.php';

dle_session();

$_COOKIE['dle_skin'] = trim(totranslit( $_COOKIE['dle_skin'], false, false ));

if( $_COOKIE['dle_skin'] ) {

	if( @is_dir( ROOT_DIR . '/templates/' . $_COOKIE['dle_skin'] ) ) {
		$config['skin'] = $_COOKIE['dle_skin'];
	}
}

if( $config["lang_" . $config['skin']] ) {

	if ( file_exists( ROOT_DIR . '/language/' . $config["lang_" . $config['skin']] . '/website.lng' ) ) {	
		@include_once ROOT_DIR . '/language/' . $config["lang_" . $config['skin']] . '/website.lng';
	} else die("فايل زبان سيستم يافت نشد!");

} else {
	
	@include_once ROOT_DIR . '/language/' . $config['langs'] . '/website.lng';

}

$config['charset'] = ($lang['charset'] != '') ? $lang['charset'] : $config['charset'];

require_once ENGINE_DIR . '/modules/functions.php';

function generate_calendar($jmonth, $jyear, $events){
	global $config, $month, $year, $lang, $PHP_SELF;

	$jmonth = intval ($jmonth);
	$jyear = intval ($jyear);
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

	$buffer = '<table id="calendar" cellpadding="3" class="calendar" width="100%"><caption><strong>' . $date_link['prev_y'] . $date_link['prev'] . $lang['date']['month'][$jmonth] . ' ' . $jyear . $date_link['next'] . $date_link['next_y'].'</strong></caption><thead><tr align="center">';
	
	for ($it=0; $it<=5; $it++)
		$buffer .= '<th>'.$lang['date']['shortweek'][$it].'</th>';
	$buffer .= '<th class="weekday">'.$lang['date']['shortweek'][6].'</th></tr></thead>';
			
	$buffer .= ($weekday > 0 && $weekday <= 6) ? '<tr align="center"><td colspan="'.$weekday.'">&nbsp;</td>' : '<tr align="center">';
	
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
					$buffer .= '<td class="' . $class . '"><a class="day-active" href="' . $config['http_home_url'].''.jdate("Y/m/d", $events[$days]).'/" title="'.$lang['cal_post'].' '.$date['title'].'">'.$cal_day.'</a></td>';
				else
					$buffer .= '<td class="' . $class . '"><a class="day-active" href="' . $PHP_SELF . '?year='.jdate("Y", $events[$days]).'&month='.jdate("m", $events[$days]).'&day='.jdate("d", $events[$days]).'" title="'.$lang['cal_post'].' '.$date['title'].'">'.$cal_day.'</a></td>';


			} else {


				$class = $todayjday == $days && ($jmonth == $todayjmonth) && ($jyear == $todayjyear) ? 'day-current' : 'day-active-v';
				
				if ($config['allow_alt_url'])
					$buffer .= '<td class="'.$class.'"><a class="day-active-v" href="'.$config['http_home_url'].''.jdate("Y/m/d", $events[$days]).'/" title="'.$lang['cal_post'].' '.$date[title].'">'.$cal_day.'</a></td>';
				else
					$buffer .= '<td class="'.$class.'"><a class="day-active-v" href="'.$PHP_SELF.'?year='.jdate("Y", $events[$days]).'&month='.jdate("m", $events[$days]).'&day='.jdate("d", $events[$days]).'" title="'.$lang['cal_post'].' '.$date[title].'">'.$cal_day.'</a></td>';

			}
		} else {
			if ($todayjday == $days && ($jmonth == $todayjmonth) && ($jyear == $todayjyear)) 
				$buffer .= '<td class="day-current">'.$cal_day.'</td>';
			elseif ($weekday == "6") $buffer .= '<td class="weekday">'.$cal_day.'</td>';
			else $buffer .= '<td class="day">'.$cal_day.'</td>';
		}

		$cal_day++;
		$weekday++;
		$days++;
	}

	if ($weekday != 7){$buffer .= '<td colspan="' . (7 - $weekday) . '">&nbsp;</td>';}

	return $buffer . '</tr></table>';
}
$buffer = false;
$time = time()+ ($config['date_adjust']*60);
$thisdate = date ("Y-m-d H:i:s", $time);
$this_month = jdate("m", $time);
$this_year = jdate("Y" , $time);
$month = $db->safesql(intval(htmlspecialchars($_GET['month'])));
$year = $db->safesql(intval(htmlspecialchars($_GET['year'])));
$this_startm = date("Y-m-d H:i:s", jmaketime(0, 0, 0, $this_month, 1, $this_year));
$this_endm = date("Y-m-d H:i:s", jmaketime(0, 0, 0, ($this_month+1), 1, $this_year));
$startm = date("Y-m-d H:i:s", jmaketime(0, 0, 0, $month, 1, $year));
$endm = date("Y-m-d H:i:s", jmaketime(0, 0, 0, ($month+1), 1, $year));
	
if ($year != '' and $month != ''){
		
	if (($year == $this_year AND $month > $this_month) OR ($year > $this_year)) {

		$sql = "";

	} else {

		$sql = "SELECT date FROM " . PREFIX . "_post WHERE date BETWEEN '$startm' AND '$endm' AND approve = '1'";

	}

	$this_month = $month; 
	$this_year = $year;

} else {
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
$db->close();

$buffer = generate_calendar($this_month, $this_year, $events);

header( "Content-type: text/html; charset=" . $config['charset'] );
echo $buffer;

?>