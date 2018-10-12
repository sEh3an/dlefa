<?php
/*
=====================================================
 DataLife Engine v13.1
-----------------------------------------------------
 Translate & Develope :
	Seyed Ehsan Setarehdan   - Eh3an@Setarehdan.ir
-----------------------------------------------------
 FileName :  engine/classes/jdate.class.php
-----------------------------------------------------
 Copyright (c) 2018, All rights reserved.
=====================================================
*/



function jdate( $type, $maket = "now" ){
	global $lang;

	if ( $maket == "now" ) {
		list( $jyear, $jmonth, $jday ) = gregorian_to_jalali(date("Y"), date("m"), date("d"));
		$maket = jmaketime( date("h"), date("i") , date("s"), $jmonth, $jday, $jyear );
	}

	$year = date("Y", $maket);
	$month = date("m", $maket);
	$day = date("d", $maket);
	list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);

	$a = date("a", $maket);
	if($a == "pm"){
		$a = $lang['date']['pm'];
		$a2 = $lang['date']['pm_long'];
	} else {
		$a = $lang['date']['am'];
		$a2 = $lang['date']['am_long'];
	}
	
	if( $jday < 10 ) $d = "0" . $jday;
	else $d = $jday;
	
	$d2 = $lang['date'][date("D", $maket)];
	$j = $jday;
	$l = $lang['date'][date("l", $maket)];
	
	if( $jmonth < 10 ) $m = "0" . $jmonth;
	else $m = $jmonth;
	
	$f = $lang['date']["month"][$jmonth];
	$n = $jmonth;
	$s = $lang['date']['S'];
	
	$r = $lang['date'][date("r", $maket)];
	
	$t = jlastday( $day, $month, $year );
	
	$w = date("W", $maket + 172800);
	if( $w > 12 ) $w = $w - 12;
	else $w += 40;
	if( $w < 10 ) $w = "0" . $w;
	
	$y = substr( $jyear, 2, 4 );
	$y2 = $jyear;
	
	$find = array( "a", "A", "d", "D", "F", "j", "l", "m", "M", "n", "r", "S", "t", "W", "y", "Y" );
	$replace = array( $a, $a2, $d, $d2, $f, $j, $l, $m, $f, $n, $r, $s, $t, $w, $y, $y2 );
	
	$output = date( str_replace( $find, $replace, $type ), $maket );

	return $output;
}

function jmaketime( $hour, $minute, $second, $jmonth, $jday, $jyear ){
	list( $year, $month, $day ) = jalali_to_gregorian($jyear, $jmonth, $jday);
	$i = mktime($hour, $minute, $second, $month, $day, $year);
	return $i;
}

function mstart($month, $day, $year){
	list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);
	list( $year, $month, $day ) = jalali_to_gregorian($jyear, $jmonth, "1");
	$timestamp = mktime(0,0,0,$month,$day,$year);
	return date("w",$timestamp);
}

function jlastday( $day, $month, $year ){
	$lastday_gregorian = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
	list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);
	$lastdate_jalali = $jday;
	$jday2 = $jday;
	while($jday2 >= "1"){
		if( $day < $lastday_gregorian ) {
			$day++;
			list( $jyear, $jmonth, $jday2 ) = gregorian_to_jalali($year, $month, $day);
			if($jday2 == "1") break;
			if($jday2 != "1") $lastdate_jalali += 1;
		} else {
			$day = 0;
			$month += 1;
			if( $month == 13 ){
					$month = "1";
					$year++;
			}
		}
	}
	return $lastdate_jalali;
}

function Convertnumber2farsi( $string ) {
	$find = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9" );
	$replace = array( "۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹" );
	
	$string = str_replace( $find, $replace, $string );
	
	return $string;
}

function jdiv($a,$b) {
	return (int) ($a / $b);
}

function gregorian_to_jalali ($g_y, $g_m, $g_d) {
	$g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	$j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);	
	

	$gy = $g_y - 1600;
	$gm = $g_m - 1;
	$gd = $g_d - 1;

	$g_day_no = 365*$gy+ jdiv($gy+3,4)- jdiv($gy+99,100)+ jdiv($gy+399,400);

	for ($i=0; $i < $gm; ++$i)
		$g_day_no += $g_days_in_month[$i];
	if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0))) 
		$g_day_no++;
	$g_day_no += $gd;

	$j_day_no = $g_day_no-79;

	$j_np = jdiv($j_day_no, 12053); 
	$j_day_no = $j_day_no % 12053;

	$jy = 979+33*$j_np+4* jdiv($j_day_no,1461); 

	$j_day_no %= 1461;

	if ($j_day_no >= 366) {
		$jy += jdiv($j_day_no-1, 365);
		$j_day_no = ($j_day_no-1)%365;
	}

	for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i)
	 $j_day_no -= $j_days_in_month[$i];
	$jm = $i+1;
	$jd = $j_day_no+1;

	return array($jy, $jm, $jd);
}

function jalali_to_gregorian($j_y, $j_m, $j_d) {
	$g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	$j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

	$jy = $j_y-979;
	$jm = $j_m-1;
	$jd = $j_d-1;

	$j_day_no = 365*$jy + jdiv($jy, 33)*8 + jdiv($jy%33+3, 4);
	for ($i=0; $i < $jm; ++$i)
		$j_day_no += $j_days_in_month[$i];

	$j_day_no += $jd;

	$g_day_no = $j_day_no+79;

	$gy = 1600 + 400* jdiv($g_day_no, 146097); 
	$g_day_no = $g_day_no % 146097;

	$leap = true;
	if ($g_day_no >= 36525){ 
		$g_day_no--;
		$gy += 100* jdiv($g_day_no, 36524); 
		$g_day_no = $g_day_no % 36524;

		if ($g_day_no >= 365)
			$g_day_no++;
		else
			$leap = false;
	}

	$gy += 4 * jdiv($g_day_no, 1461); 
	$g_day_no %= 1461;

	if ($g_day_no >= 366) {
		$leap = false;

		$g_day_no--;
		$gy += jdiv($g_day_no, 365);
		$g_day_no = $g_day_no % 365;
	}

	for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++)
		$g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap);
	$gm = $i+1;
	$gd = $g_day_no+1;

	return array($gy, $gm, $gd);
}

function jstrtotime( $date ){
	$date = trim($date);
	$date_time = explode( " ", $date );

	$date = reset( $date_time );
	$date = preg_split ( '/-/', $date );
	if ( ! intval( $date[0] ) ) $date[0] = jdate("Y");
	if ( ! intval( $date[1] ) ) $date[1] = "01";
	if ( ! intval( $date[2] ) ) $date[2] = "01";
	
	if ( $date_time[1] ) {
		$time = end( $date_time );
		$time = explode( ":", $time );
	} else
		$time = array( );
	
	if ( ! intval( $time[0] ) ) $time[0] = "00";
	if ( ! intval( $time[1] ) ) $time[1] = "00";
	if ( ! intval( $time[2] ) ) $time[2] = "00";
	
	$time = jmaketime( $time[0], $time[1], $time[2], $date[1], $date[2], $date[0] );
	
	if ( ! intval($time) ) return - 1;
	return $time;
}

function fatotranslit($var, $lower, $punkt) {
	if ( is_array($var) ) return "";
	$var = trim( strip_tags( $var ) );
	$var = str_replace( array( " ", ".", "\"", "'", ">", "<", ":" ), "-", $var );
	$var = str_ireplace( ".php", "", $var );
	$var = str_ireplace( ".php", ".ppp", $var );
	$var = ArabicToPersian( $var );
	if( strlen( $var ) > 200 ) {
		$var = substr( $var, 0, 200 );
		if( ($temp_max = strrpos( $var, '-' )) ) $var = substr( $var, 0, $temp_max );
	}
	return $var;
}


function ArabicToPersian( $str ){
		if( is_array( $str ) ) return "";
		$str = str_replace("ي", "ی", $str);
		$str = str_replace("ك", "ک", $str);
		return $str;
}

?>