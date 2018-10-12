<?php
/*
=====================================================
 DataLife Engine v13.1
-----------------------------------------------------
 Translate :
	Seyed Ehsan Setarehdan   - Eh3an@Setarehdan.ir
-----------------------------------------------------
 FileName :  install.php
-----------------------------------------------------
 Copyright (c) 2018, All rights reserved.
=====================================================
*/
session_start();

@error_reporting ( E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE );

define('DATALIFEENGINE', true);
define('ROOT_DIR', dirname (__FILE__));
define('ENGINE_DIR', ROOT_DIR.'/engine');

header("Content-type: text/html; charset=utf-8");

require_once(ROOT_DIR.'/language/Farsi/adminpanel.lng');
require_once(ENGINE_DIR.'/inc/include/functions.inc.php');

$url = explode( basename($_SERVER['PHP_SELF']), strtolower ( $_SERVER['PHP_SELF'] ) );
$url = reset($url);

if( isSSL() ) $url  = "https://".$_SERVER['HTTP_HOST'].$url;
else $url  = "http://".$_SERVER['HTTP_HOST'].$url;

$skin_header = <<<HTML
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>نصب سیستم DataLife Engine فارسی</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="HandheldFriendly" content="true">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width"> 
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link href="engine/skins/fonts/fontawesome/styles.min.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="engine/skins/stylesheets/application_fa.css" media="screen" rel="stylesheet" type="text/css" />
    <script src="engine/skins/javascripts/application_fa.js"></script>
</head>
<body class="no-theme">
<script>
<!--
var dle_act_lang   = [];
var cal_language   = {en:{months:[],dayOfWeek:[]}};
var filedefaulttext= '';
var filebtntext    = '';
//-->
</script>
<div class="navbar navbar-inverse bg-primary-700">
	<div class="navbar-header">
		<a class="navbar-brand" href="#">نصب دیتالایف انجین فارسی</a>
	</div>
</div>
<div class="page-container">
	<div class="page-content">
		<div class="col-md-8 col-md-offset-2 mt-20">
<!--MAIN area-->
HTML;


$skin_footer = <<<HTML
	 <!--MAIN area-->
    </div>
  </div>
</div>
</body>
</html>
HTML;

function msgbox($type, $title, $text, $back=false){
global $lang, $skin_header, $skin_footer;

  if ($back) $back = "onclick=\"history.go(-1); return false;\""; else $back = "";

  echo $skin_header;

echo <<<HTML
<form action="install.php" method="get">
<div class="panel panel-default">
  <div class="panel-heading">
	{$title}
  </div>
  <div class="panel-body">
		{$text}
  </div>
  <div class="panel-footer">
	<button type="submit" {$back} class="btn bg-teal btn-sm btn-raised position-left"><i class="fa fa-arrow-circle-o-left position-left"></i>بعدی</button>
  </div>
</div>
</form>
HTML;

  echo $skin_footer;

  exit();
}

function GetRandInt($max){

	if(function_exists('openssl_random_pseudo_bytes')) {
	     do{
	         $result = floor($max*(hexdec(bin2hex(openssl_random_pseudo_bytes(4)))/0xffffffff));
	     }while($result == $max);
	} else {

		$result = mt_rand( 0, $max );
	}

    return $result;
}

function generate_auth_key() {

    $arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 'A','B','C','D','E','F',
                 'G','H','I','J','K','L',
                 'M','N','O','P','R','S',
                 'T','U','V','X','Y','Z',
                 '1','2','3','4','5','6',
                 '7','8','9','0','.',',',
                 '(',')','[',']','!','?',
                 '&','^','%','@','*',' ',
                 '<','>','/','|','+','-',
                 '{','}','`','~','#',';',
                 '/','|','=',':','`');

    $key = "";
    for($i = 0; $i < 64; $i++)
    {
      $index = GetRandInt(count($arr))-1;
      $key .= $arr[$index];
    }
    return $key;
}

if($_REQUEST['action'] == "eula") {

if ( !$_SESSION['dle_install'] ) msgbox( "", "خطا!", "به صفحه اصلی نصب سیستم بازگردید و مراحل نصب را از اول طی کنید. <br /><br /><a href=\"http://{$_SERVER['HTTP_HOST']}/install.php\">http://{$_SERVER['HTTP_HOST']}/install.php</a>" );

  echo $skin_header;

echo <<<HTML
<form id="check-eula" method="get" action="">
<input type=hidden name=action value="function_check">
<script language='javascript'>
function check_eula(){

	if( document.getElementById( 'eula' ).checked == true )
	{
		return true;
	}
	else
	{
		DLEalert( 'کاربر گرامی! می بایست قبل از نصب هشدارنامه را مطالعه بفرمایید.', 'اخطار' );
		return false;
	}
};
document.getElementById( 'check-eula' ).onsubmit = check_eula;
</script>
<div class="panel panel-default">
  <div class="panel-heading">
    هشدارها!
  </div>
	<div class="panel-body">
		لطفا قبل از نصب هشدارهای زیر را مطالعه نمایید.<br /><br />
		<div style="height: 300px; border: 1px solid #76774C; background-color: #FDFDD3; padding: 5px; overflow: auto;">
		<b>کاربر گرامی!<br><br>
		سلام و عرض احترام<br><br>
		بعد از نصب سیستم حتما فایل <span style="color:red">install.php</span> را از روی سیستم خود حذف نمایید.<br><br>
		این نسخه ورژن 13.1 سیستم مدیریت محتوای دیتالایف انجین می باشد.<br><br>
		برای دریافت اطلاعات بیشتر به سایت دیتالایف انجین به آدرس <a href="https://dle-news.com" target="_blank">dle-news.com</a> مراجعه نمایید.<br><br>
		در همه حال آماده ی دریافت پیشنهادات و انتقادات شما کاربران گرامی هستیم.<br><br>
		با تقدیم احترام<br><br>
		تیم مدیریتی دیتالایف انجین<br><br>
		</div>
		<div class="checkbox"><label><input type="checkbox" name="eula" id="eula" class="icheck">موارد بالا را مطالعه کرده و می پذیرم!</label></div>
	</div>
	<div class="panel-footer">
	<button type="submit" class="btn bg-teal btn-sm btn-raised position-left"><i class="fa fa-arrow-circle-o-left position-left"></i>مرحله بعد</button>
	</div>
</div>
</form>
HTML;

} elseif($_REQUEST['action'] == "function_check") {

    if ( !$_SESSION['dle_install'] ) msgbox( "", "خطا!", "به صفحه اصلی نصب سیستم بازگردید و مراحل نصب را از اول طی کنید.<br /><br /><a href=\"http://{$_SERVER['HTTP_HOST']}/install.php\">http://{$_SERVER['HTTP_HOST']}/install.php</a>" );

  echo $skin_header;

echo <<<HTML
<form method="get" action="">
<input type=hidden name="action" value="chmod_check">
<div class="panel panel-default">
  <div class="panel-heading">
    بررسی تنظیمات سرور
  </div>
  <div class="table-responsive">
<table class="table table-striped table-xs">
<thead>
<tr>
<th width="300">نوع نیازمندی</th>
<th colspan="2">مقدار</th>
</tr>
</thead>
HTML;

	$errors=false;

	if( version_compare(phpversion(), '5.4', '<') ) {
		$status = '<span class="text-danger"><b>خیر</b></span>';
		$errors=true;
	} else {
		$status = '<span class="text-success"><b>بلی</b></span>';
  }
   echo "<tr>
         <td>نسخه PHP از 5.4 به بالا</td>
         <td colspan=2>$status</td>
         </tr>";

	if( function_exists('mysqli_connect') ) {
	  $status = '<span class="text-success"><b>بلی</b></span>';
	} else {
	  $status = '<span class="text-danger"><b>خیر</b></span>';
	  $errors=true;
	}

   echo "<tr>
         <td>پشتیبانی از MySQLi</td>
         <td colspan=2>$status</td>
         </tr>";


	if( function_exists('gzopen') ) {
	  $status = '<span class="text-success"><b>بلی</b></span>';
	} else {
	  $status = '<span class="text-danger"><b>خیر</b></span>';
	  $errors=true;
	}

   echo "<tr>
         <td>پشتیبانی از فشرده ساز ZLib</td>
         <td colspan=2>$status</td>
         </tr>";

	if( function_exists('mb_convert_encoding') ) {
	  $status = '<span class="text-success"><b>بلی</b></span>';
	} else {
	  $status = '<span class="text-danger"><b>خیر</b></span>';
	  $errors=true;
	}

   echo "<tr>
         <td>پشتیبانی از رشته های چند بایتی</td>
         <td colspan=2>$status</td>
         </tr>";

	if($errors) {
	 $button= "<button onclick=\"location.reload(true); return false;\" class=\"btn bg-danger btn-sm btn-raised position-left\"><i class=\"fa fa-refresh position-left\"></i>بررسی مجدد</button>";
	} else {
	 $button = "<button type=\"submit\" class=\"btn bg-teal btn-sm btn-raised position-left\"><i class=\"fa fa-arrow-circle-o-right position-left\"></i>مرحله بعد</button>";
	}
	
echo <<<HTML
</table>
  <div class="panel-body">
	اگر مقدار هر یک از آیتم های بالا خیر بود، قبل از ادامه مراحل نصب، نسبت به تصحیح آیتم مورد نظر اقدام کنید (با مدیریت سرور تماس بگیرید).
  </div>
  <div class="panel-footer">
	{$button}
  </div>

  </div>
</div></form>
HTML;

}
// ********************************************************************************
// Checking write permissions
// ********************************************************************************
elseif($_REQUEST['action'] == "chmod_check") {

if ( !$_SESSION['dle_install'] ) msgbox( "", "خطا!", "نصب اسکریپت از ابتدا انجام نشده است! لطفا به صفحه ی نصب مراجعه فرمایید : <br /><br /><a href=\"http://{$_SERVER['HTTP_HOST']}/install.php\">http://{$_SERVER['HTTP_HOST']}/install.php</a>" );

  echo $skin_header;

echo <<<HTML
<form method="get" action="">
<input type=hidden name="action" value="doconfig">
<div class="panel panel-default">
  <div class="panel-heading">
    سطح دسترسی فولدرها
  </div>
  <div class="table-responsive">
<table class="table table-striped table-xs">
HTML;

echo"<thead><tr>
<th>Directory/File</th>
<th width=\"100\">CHMOD</th>
<th width=\"100\">وضعیت</th></tr></thead><tbody>";

$important_files = array(
'./backup/',
'./engine/data/',
'./engine/cache/',
'./engine/cache/system/',
'./uploads/',
'./uploads/files/',
'./uploads/fotos/',
'./uploads/posts/',
'./uploads/posts/thumbs/',
'./uploads/posts/medium/',
'./uploads/thumbs/',
'./templates/',
'./templates/Default/',
);


$chmod_errors = 0;
$not_found_errors = 0;
    foreach($important_files as $file){

        if(!file_exists($file)){
            $file_status = "<span class=\"text-danger\">یافت نشد!</span>";
            $not_found_errors ++;
        }
        elseif(is_writable($file)){
            $file_status = "<span class=\"text-success\">درست</span>";
        }
        else{
            @chmod($file, 0777);
            if(is_writable($file)){
                $file_status = "<span class=\"text-success\">درست</span>";
            }else{
                @chmod("$file", 0755);
                if(is_writable($file)){
                    $file_status = "<span class=\"text-success\">درست</span>";
                }else{
                    $file_status = "<span class=\"text-danger\">نادرست</span>";
                    $chmod_errors ++;
                }
            }
        }
        $chmod_value = @decoct(@fileperms($file)) % 1000;

    echo"<tr>
         <td>$file</td>
         <td>$chmod_value</td>
         <td>$file_status</td>
         </tr>";
    }
    
if($chmod_errors == 0 and $not_found_errors == 0){

    $status_report = 'سطح دسترسی فولدرها بدون مشکل بوده و شما می توانید به ادامه روند نصب سیستم بپردازید.';

} else {
    
    if($chmod_errors > 0){
        $status_report = "<span class=\"text-danger\">خطا!</span><br /><br />در چک کردن فولدرها، مشاهده شد که <b>$chmod_errors</b> امکان نوشتن در آن وجود ندارد. !<br />لطفاً سطح دسترسی به فولدرهای مشخص شده با رنگ قرمز را بر روی 777 قرار دهید.<br /><br />تصحیح این مورد قبل از ادامه روند کار <font color=red><b>به شدت</b></font> توصیه می شود.<br />";
    }

    if($not_found_errors > 0){
        $status_report .= "<span class=\"text-danger\">خطا!</span><br />در چک کردن فولدرها، <b>$not_found_errors</b> فایل پیدا نشد!<br /><br />تصحیح این مورد قبل از ادامه روند کار <font color=red><b>به شدت</b></font> توصیه می شود.<br />";
    }
}


echo <<<HTML
</tbody></table>
  </div>
  <div class="panel-body">
	{$status_report}
  </div>
  <div class="panel-footer">
	<button type="submit" class="btn bg-teal btn-sm btn-raised position-left"><i class="fa fa-arrow-circle-o-left position-left"></i>مرحله بعد</button>
  </div>
</div></form>
HTML;

} elseif($_REQUEST['action'] == "doconfig") {

    if ( !$_SESSION['dle_install'] ) msgbox( "", "خطا!", "به صفحه اصلی نصب سیستم بازگردید و مراحل نصب را از اول طی کنید.<br /><br /><a href=\"http://{$_SERVER['HTTP_HOST']}/install.php\">http://{$_SERVER['HTTP_HOST']}/install.php</a>" );

  echo $skin_header;

  echo <<<HTML
<form method="post" action="">
<input type=hidden name="action" value="doinstall">
<div class="panel panel-default">
  <div class="panel-heading">
    پیکربندی سیستم
  </div>
  <div class="panel-body">
<table width="100%">
HTML;

echo '<tr>
<tr><td style="padding: 5px;" width="175">آدرس جایگاه سیستم:</td><td style="padding: 5px;"><input type="text" class="form-control ltr width-400" name="url" value="'.$url.'"></tr>
<tr><td colspan="2" style="padding: 5px;"><b>اطلاعات مربوط به پایگاه داده ها (دیتابیس)</b><td></tr>
<tr><td style="padding: 5px;" width="175">سرور MYSQL:</td><td style="padding: 5px;"><input type="text" class="form-control ltr width-400" name="dbhost" value="localhost"></tr>
<tr><td style="padding: 5px;">نام دیتابیس:</td><td style="padding: 5px;"><input type="text" class="form-control ltr width-400" name="dbname"></tr>
<tr><td style="padding: 5px;">نام کاربری دیتابیس:</td><td style="padding: 5px;"><input type="text" class="form-control ltr width-400" name="dbuser"></tr>
<tr><td style="padding: 5px;">کلمه عبور دیتابیس:</td><td style="padding: 5px;"><input type="text" class="form-control ltr width-400" name="dbpasswd"></tr>
<tr><td style="padding: 5px;">پیشوند جداول:</td><td style="padding: 5px;"><input type="text" class="form-control ltr width-400" name="dbprefix" value="dle"> <span class="text-size-small text-muted">[Prefix]</span></tr>
<tr><td colspan="2" style="padding: 5px;"><b>اطلاعات مربوط به مدیریت سایت</b><td></tr>
<tr><td style="padding: 5px;">نام کاربری مدیر سایت:</td><td style="padding: 5px;"><input type="text" class="form-control ltr width-400" name="reg_username" ></tr>
<tr><td style="padding: 5px;">کلمه عبور:</td><td style="padding: 5px;"><input type="password" class="form-control ltr width-400" name="reg_password1"></tr>
<tr><td style="padding: 5px;">تکرار کلمه عبور:</td><td style="padding: 5px;"><input type="password" class="form-control ltr width-400" name="reg_password2"></tr>
<tr><td style="padding: 5px;">ایمیل:</td><td style="padding: 5px;"><input type="text" class="form-control ltr width-400" name="reg_email"></tr>
<tr><td colspan="2" style="padding: 5px;"><b>تنظیمات سیستم</b><td></tr>
<tr><td style="padding: 5px;">عنوان سایت:<td style="padding: 5px;"><input type="text" class="form-control width-400" name="site_title" value="دیتالایف انجین فارسی" ></tr>';

echo <<<HTML
</table>
  </div>
  <div class="panel-footer">
	<button type="submit" class="btn bg-teal btn-sm btn-raised position-left"><i class="fa fa-arrow-circle-o-left position-left"></i>نصب سیستم</button>
  </div>
</div></form>
HTML;

}
// ********************************************************************************
// Do Install
// ********************************************************************************
elseif($_REQUEST['action'] == "doinstall")
{

	if ( !$_SESSION['dle_install'] ) msgbox( "", "خطا!", "به صفحه اصلی نصب سیستم بازگردید و مراحل نصب را از اول طی کنید.<br /><br /><a href=\"http://{$_SERVER['HTTP_HOST']}/install.php\">http://{$_SERVER['HTTP_HOST']}/install.php</a>" );

    if( !$_POST['reg_username'] OR !$_POST['reg_email'] OR !$_POST['reg_password1'] OR $_POST['reg_password1'] != $_POST['reg_password2'] ){
		msgbox("خطا", "خطا!!!" ,"موارد خواسته شده را پر نمایید!", "history.go(-1)");
	}

	if (preg_match("/[\||\'|\<|\>|\[|\]|\"|\!|\?|\$|\@|\#|\/|\\\|\&\~\*\{\+]/", $_POST['reg_username'])){
		msgbox("error", "خطا!!!" ,"نام کاربری مدیریت معتبر نیست!", "history.go(-1)");
	}

	$reg_password = password_hash($_POST['reg_password1'], PASSWORD_DEFAULT);
	
	if( !$reg_password ) {
		msgbox("error", "لطفا افزونه ی PHP extension Crypt را برای هش کردن پسورد نصب نمایید! این عملیات توسط مدیر سرور انجام می شود!", "history.go(-1)");
	}

	$reg_username = $_POST['reg_username'];
	$alt_url = intval( $_POST['alt_url'] );
	$url = htmlspecialchars(strip_tags(stripslashes($_POST['url'])), ENT_QUOTES, $distr_charset );
	$url = str_replace( "$", "&#036;", $url );

	$not_allow_symbol = array ("\x22", "\x60", "\t", '\n', '\r', "\n", "\r", '\\', ",", "/", "¬", "#", ";", ":", "~", "[", "]", "{", "}", ")", "(", "*", "^", "%", "$", "<", ">", "?", "!", '"', "'", " ", "&" );
	$reg_email = trim( str_replace( $not_allow_symbol, '', strip_tags( stripslashes( $_POST['reg_email'] ) ) ) );

	$timezone = date_default_timezone_get();
	
	$timezones = array('Pacific/Midway','US/Samoa','US/Hawaii','US/Alaska','US/Pacific','America/Tijuana','US/Arizona','US/Mountain','America/Chihuahua','America/Mazatlan','America/Mexico_City','America/Monterrey','US/Central','US/Eastern','US/East-Indiana','America/Lima','America/Caracas','Canada/Atlantic','America/La_Paz','America/Santiago','Canada/Newfoundland','America/Buenos_Aires','America/Godthab','Atlantic/Stanley','Atlantic/Azores','Africa/Casablanca','Europe/Dublin','Europe/Lisbon','Europe/London','Europe/Amsterdam','Europe/Belgrade','Europe/Berlin','Europe/Bratislava','Europe/Brussels','Europe/Budapest','Europe/Copenhagen','Europe/Madrid','Europe/Paris','Europe/Prague','Europe/Rome','Europe/Sarajevo','Europe/Stockholm','Europe/Vienna','Europe/Warsaw','Europe/Zagreb','Europe/Athens','Europe/Bucharest','Europe/Helsinki','Europe/Istanbul','Asia/Jerusalem','Europe/Kiev','Europe/Minsk','Europe/Riga','Europe/Sofia','Europe/Tallinn','Europe/Vilnius','Asia/Baghdad','Asia/Kuwait','Africa/Nairobi','Asia/Tehran','Europe/Kaliningrad','Europe/Moscow','Europe/Volgograd','Europe/Samara','Asia/Baku','Asia/Muscat','Asia/Tbilisi','Asia/Yerevan','Asia/Kabul','Asia/Yekaterinburg','Asia/Tashkent','Asia/Kolkata','Asia/Kathmandu','Asia/Almaty','Asia/Novosibirsk','Asia/Jakarta','Asia/Krasnoyarsk','Asia/Hong_Kong','Asia/Kuala_Lumpur','Asia/Singapore','Asia/Taipei','Asia/Ulaanbaatar','Asia/Urumqi','Asia/Irkutsk','Asia/Seoul','Asia/Tokyo','Australia/Adelaide','Australia/Darwin','Asia/Yakutsk','Australia/Brisbane','Pacific/Port_Moresby','Australia/Sydney','Asia/Vladivostok','Asia/Sakhalin','Asia/Magadan','Pacific/Auckland','Pacific/Fiji');

	if ( !in_array($timezone, $timezones) ) {
		$timezone = "Asia/Tehran";
		date_default_timezone_set ( $timezone );
	}
	
	$dbhost = str_replace ('"', '\"', str_replace ("$", "\\$", $_POST['dbhost']) );
	$dbname = str_replace ('"', '\"', str_replace ("$", "\\$", $_POST['dbname']) );
	$dbuser = str_replace ('"', '\"', str_replace ("$", "\\$", $_POST['dbuser']) );
	$dbpasswd = str_replace ('"', '\"', str_replace ("$", "\\$", $_POST['dbpasswd']) );
	$dbprefix = str_replace ('"', '\"', str_replace ("$", "\\$", $_POST['dbprefix']) );
	$auth_key = generate_auth_key();
	
	define ("PREFIX", $dbprefix);
	define ("COLLATE", "utf8mb4");

	include ENGINE_DIR.'/classes/mysql.php';
	
	$check_db = new db;
	
	if ( !$check_db->connect($dbuser, $dbpasswd, $dbname, $dbhost, false) ) {
		msgbox("error", "خطا!!!" ,"توانایی اتصال به سرور MySQL وجود ندارد. لطفا اطلاعات مربوط به پایگاه داده را بررسی نمایید!", "history.go(-1)");
	}
	
	if( version_compare($check_db->mysql_version, '5.5.3', '<') ) {
		msgbox("error", "خطا!!!" ,"بر روی سرور شما نسخه ی <b>{version}</b> از MySQL نصب شده است. برای نصب دیتالایف انجین نیاز به نسخه 5.5.3 یا بالاتر هست!", "history.go(-1)");
	}
	
	if( version_compare($check_db->mysql_version, '5.6.4', '<') ) {
		$storage_engine = "MyISAM";
	} else $storage_engine = "InnoDB";


	unset($check_db);
	$site_title = $_POST['site_title'];
$config = <<<HTML
<?PHP

//System Configurations

\$config = array (

'version_id' => "13.1",

'home_title' => "{$site_title}",

'http_home_url' => "{$url}",

'charset' => "utf-8",

'admin_mail' => "{$reg_email}",

'description' => "DataLife Engine Farsi v13.1",

'keywords' => "DataLife, Engine, Data, Life, Content, Management, System, CMS, PHP script, دیتالایف, انجین",

'date_adjust' => "{$timezone}",

'site_offline' => "0",

'allow_alt_url' => "1",

'langs' => "Farsi",

'skin' => "Default-fa",

'allow_gzip' => "0",

'allow_admin_wysiwyg' => "1",

'allow_static_wysiwyg' => "1",

'news_number' => "10",

'smilies' => "bowtie,smile,laughing,blush,smiley,relaxed,smirk,heart_eyes,kissing_heart,kissing_closed_eyes,flushed,relieved,satisfied,grin,wink,stuck_out_tongue_winking_eye,stuck_out_tongue_closed_eyes,grinning,kissing,stuck_out_tongue,sleeping,worried,frowning,anguished,open_mouth,grimacing,confused,hushed,expressionless,unamused,sweat_smile,sweat,disappointed_relieved,weary,pensive,disappointed,confounded,fearful,cold_sweat,persevere,cry,sob,joy,astonished,scream,tired_face,angry,rage,triumph,sleepy,yum,mask,sunglasses,dizzy_face,imp,smiling_imp,neutral_face,no_mouth,innocent",

'timestamp_active' => "j F Y, H:i",

'news_sort' => "date",

'news_msort' => "DESC",

'hide_full_link' => "0",

'allow_site_wysiwyg' => "1",

'allow_comments' => "1",

'comm_nummers' => "30",

'comm_msort' => "ASC",

'flood_time' => "30",

'auto_wrap' => "80",

'timestamp_comment' => "j M Y H:i",

'allow_comments_wysiwyg' => "1",

'allow_registration' => "1",

'allow_cache' => "0",

'allow_votes' => "1",

'allow_topnews' => "1",

'allow_read_count' => "1",

'allow_calendar' => "1",

'allow_archives' => "1",

'files_allow' => "1",

'files_count' => "1",

'reg_group' => "4",

'registration_type' => "0",

'allow_sec_code' => "1",

'allow_skin_change' => "1",

'max_users' => "0",

'max_users_day' => "0",

'max_up_size' => "200",

'max_image_days' => "2",

'allow_watermark' => "1",

'max_watermark' => "150",

'max_image' => "200",

'jpeg_quality' => "85",

'files_antileech' => "1",

'allow_banner' => "1",

'log_hash' => "0",

'show_sub_cats' => "1",

'tag_img_width' => "0",

'mail_metod' => "php",

'smtp_host' => "localhost",

'smtp_port' => "25",

'smtp_user' => "",

'smtp_pass' => "",

'mail_bcc' => "0",

'speedbar' => "1",

'extra_login' => "0",

'image_align' => "center",

'ip_control' => "1",

'cache_count' => "0",

'related_news' => "1",

'no_date' => "1",

'mail_news' => "1",

'mail_comments' => "1",

'admin_path' => "admin.php",

'rss_informer' => "1",

'allow_cmod' => "0",

'max_up_side' => "0",

'files_force' => "1",

'short_rating' => "1",

'full_search' => "0",

'allow_multi_category' => "1",

'short_title' => "{$site_title}",

'allow_rss' => "1",

'rss_mtype' => "0",

'rss_number' => "10",

'rss_format' => "1",

'comments_maxlen' => "3000",

'offline_reason' => "درحال حاضر دسترسی به این وب‌سایت امکان پذیر نمی‌باشد<br /><br />لطفاً ساعاتی بعد از این وب‌سایت بازدید نمائید.",

'catalog_sort' => "date",

'catalog_msort' => "DESC",

'related_number' => "5",

'seo_type' => "2",

'max_moderation' => "0",

'allow_quick_wysiwyg' => "1",

'sec_addnews' => "2",

'mail_pm' => "1",

'allow_change_sort' => "1",

'registration_rules' => "1",

'allow_tags' => "1",

'allow_add_tags' => "1",

'allow_fixed' => "1",

'max_file_count' => "0",

'allow_smartphone' => "0",

'allow_smart_images' => "0",

'allow_smart_video' => "0",

'allow_search_print' => "1",

'allow_search_link' => "1",

'allow_smart_format' => "1",

'thumb_dimming' => "0",

'thumb_gallery' => "1",

'max_comments_days' => "0",

'allow_combine' => "1",

'allow_subscribe' => "1",

'parse_links' => "0",

't_seite' => "0",

'comments_minlen' => "10",

'js_min' => "0",

'outlinetype' => "0",

'fast_search' => "1",

'login_log' => "5",

'allow_recaptcha' => "0",

'recaptcha_public_key' => "",

'recaptcha_private_key' => "",

'search_number' => "10",

'news_navigation' => "1",

'smtp_mail' => "",

'seo_control' => "0",

'news_restricted' => "0",

'comments_restricted' => "0",

'auth_metod' => "0",

'comments_ajax' => "0",

'create_catalog' => "0",

'mobile_news' => "10",

'reg_question' => "0",

'news_future' => "0",

'cache_type' => "0",

'memcache_server' => "localhost:11211",

'allow_comments_cache' => "1",

'reg_multi_ip' => "1",

'top_number' => "10",

'tags_number' => "40",

'mail_title' => "",

'o_seite' => "0",

'online_status' => "1",

'avatar_size' => "100",

'allow_share' => "1",

'auth_domain' => "0",

'start_site' => "1",

'clear_cache' => "0",

'allow_complaint_mail' => "0",

'spam_api_key' => "",

'create_metatags' => '1',

'admin_allowed_ip' => '',

'related_only_cats' => '0',

'allow_links' => '1',

'comments_lazyload' => '0',

'category_separator' => '/',

'speedbar_separator' => '&raquo;',

'adminlog_maxdays' => '30',

'allow_social' => '0',

'medium_image' => '450',

'login_ban_timeout' => '20',

'watermark_seite' => '4',

'auth_only_social' => '0',

'rating_type' => '0',

'allow_comments_rating' => '1',

'comments_rating_type' => '1',

'tree_comments' => '0',

'tree_comments_level' => '5',

'simple_reply' => '0',

'recaptcha_theme' => "light",

'smtp_secure' => '',

'search_pages' => '5',

'profile_news' => '1',

'fullcache_days' => '30',

'twofactor_auth' => '1',

'category_newscount' => '1',

'max_cache_pages' => '10',

'only_ssl' => '0',

'bbimages_in_wysiwyg' => '0',

'allow_redirects' => '1',

'allow_own_meta' => '1',

'own_404' => '0',

'own_ip' => '',

'disable_frame' => '0',

'allow_plugins' => '1',

'allow_admin_social' => '0',

'key' => '',

);

?>
HTML;

$dbconfig = <<<HTML
<?PHP

define ("DBHOST", "{$dbhost}");

define ("DBNAME", "{$dbname}");

define ("DBUSER", "{$dbuser}");

define ("DBPASS", "{$dbpasswd}");

define ("PREFIX", "{$dbprefix}");

define ("USERPREFIX", "{$dbprefix}");

define ("COLLATE", "utf8mb4");

define('SECURE_AUTH_KEY', '{$auth_key}');

\$db = new db;

?>
HTML;


$video_config = <<<HTML
<?PHP

//Videoplayers Configurations

\$video_config = array (

'width' => "560",

'audio_width' => "560",

'preload' => '1',

'theme' => 'default',

);

?>
HTML;


$social_config = <<<HTML
<?PHP

//Social Configurations

\$social_config = array (

'vk' => '0',

'vkid' => '',

'vksecret' => '',

'od' => '0',

'odid' => '',

'odpublic' => '',

'odsecret' => '',

'fc' => '0',

'fcid' => '',

'fcsecret' => '',

'google' => '0',

'googleid' => '',

'googlesecret' => '',

'mailru' => '0',

'mailruid' => '',

'mailrusecret' => '',

'yandex' => '0',

'yandexid' => '',

'yandexsecret' => '',

);

?>
HTML;

$con_file = fopen("engine/data/config.php", "w+") or die("شما باید سطح دسترسی فایل <b>.engine/data/config.php</b>. را 666 بگذارید.");
fwrite($con_file, $config);
fclose($con_file);
@chmod("engine/data/config.php", 0666);

$con_file = fopen("engine/data/dbconfig.php", "w+") or die("شما باید سطح دسترسی فایل <b>.engine/data/dbconfig.php</b>. را 666 بگذارید.");
fwrite($con_file, $dbconfig);
fclose($con_file);
@chmod("engine/data/dbconfig.php", 0666);

$con_file = fopen("engine/data/videoconfig.php", "w+") or die("شما باید سطح دسترسی فایل <b>.engine/data/videoconfig.php</b>. را 666 بگذارید.");
fwrite($con_file, $video_config);
fclose($con_file);
@chmod("engine/data/videoconfig.php", 0666);

$con_file = fopen("engine/data/socialconfig.php", "w+") or die("شما باید سطح دسترسی فایل <b>.engine/data/socialconfig.php</b>. را 666 بگذارید.");
fwrite($con_file, $social_config);
fclose($con_file);
@chmod("engine/data/socialconfig.php", 0666);

$con_file = fopen("engine/data/wordfilter.db.php", "w+") or die("شما باید سطح دسترسی فایل <b>.engine/data/wordfilter.db.php</b>. را 666 بگذارید.");
fwrite($con_file, '');
fclose($con_file);
@chmod("engine/data/wordfilter.db.php", 0666);

$con_file = fopen("engine/data/xfields.txt", "w+") or die("شما باید سطح دسترسی فایل <b>.engine/data/xfields.txt</b>. را 666 بگذارید.");
fwrite($con_file, '');
fclose($con_file);
@chmod("engine/data/xfields.txt", 0666);

$con_file = fopen("engine/data/xprofile.txt", "w+") or die("شما باید سطح دسترسی فایل <b>.engine/data/xprofile.txt</b>. را 666 بگذارید.");
fwrite($con_file, '');
fclose($con_file);
@chmod("engine/data/xprofile.txt", 0666);

@unlink(ENGINE_DIR.'/cache/system/usergroup.php');
@unlink(ENGINE_DIR.'/cache/system/vote.php');
@unlink(ENGINE_DIR.'/cache/system/banners.php');
@unlink(ENGINE_DIR.'/cache/system/category.php');
@unlink(ENGINE_DIR.'/cache/system/banned.php');
@unlink(ENGINE_DIR.'/cache/system/cron.php');
@unlink(ENGINE_DIR.'/cache/system/informers.php');
@unlink(ENGINE_DIR.'/cache/system/plugins.php');
@unlink(ENGINE_DIR.'/data/snap.db');

listdir( ENGINE_DIR . '/cache/system/CSS' );
listdir( ENGINE_DIR . '/cache/system/HTML' );
listdir( ENGINE_DIR . '/cache/system/URI' );
listdir( ENGINE_DIR . '/cache/system/plugins' );

$fdir = opendir( ENGINE_DIR . '/cache' );
		
while ( $file = readdir( $fdir ) ) {
	if( $file != '.htaccess' AND !is_dir($file) ) {
		@unlink( ENGINE_DIR . '/cache/' . $file );
	}
}

include ENGINE_DIR.'/data/dbconfig.php';

$reg_username = $db->safesql( $reg_username );
$reg_password = $db->safesql( $reg_password );

$tableSchema = array();

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_category";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_category (
  `id` mediumint(8) NOT NULL auto_increment,
  `parentid` mediumint(8) NOT NULL default '0',
  `posi` mediumint(8) NOT NULL default '1',
  `name` varchar(50) NOT NULL default '',
  `alt_name` varchar(50) NOT NULL default '',
  `icon` varchar(200) NOT NULL default '',
  `skin` varchar(50) NOT NULL default '',
  `descr` varchar(300) NOT NULL default '',
  `keywords` text NOT NULL,
  `news_sort` varchar(10) NOT NULL default '',
  `news_msort` varchar(4) NOT NULL default '',
  `news_number` smallint(5) NOT NULL default '0',
  `short_tpl` varchar(40) NOT NULL default '',
  `full_tpl` varchar(40) NOT NULL default '',
  `metatitle` varchar(255) NOT NULL default '',
  `show_sub` tinyint(1) NOT NULL default '0',
  `allow_rss` tinyint(1) NOT NULL default '1',
  `fulldescr` text NOT NULL,
  `disable_search` tinyint(1) NOT NULL default '0',
  `disable_main` tinyint(1) NOT NULL default '0',
  `disable_rating` tinyint(1) NOT NULL default '0',
  `disable_comments` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_comments";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_comments (
  `id` int(10) unsigned NOT NULL auto_increment,
  `post_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '2000-01-01 00:00:00',
  `autor` varchar(40) NOT NULL default '',
  `email` varchar(40) NOT NULL default '',
  `text` text NOT NULL,
  `ip` varchar(46) NOT NULL default '',
  `is_register` tinyint(1) NOT NULL default '0',
  `approve` tinyint(1) NOT NULL default '1',
  `rating` int(11) NOT NULL default '0',
  `vote_num` int(11) NOT NULL default '0',
  `parent` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  KEY `approve` (`approve`),
  KEY `parent` (`parent`),
  KEY `rating` (`rating`),
  FULLTEXT KEY `text` (`text`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_email";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_email (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(10) NOT NULL default '',
  `template` text NOT NULL,
  `use_html` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";


$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_flood";

$tableSchema[] = "CREATE TABLE  " . PREFIX . "_flood (
  `f_id` int(11) unsigned NOT NULL auto_increment,
  `ip` varchar(46) NOT NULL default '',
  `id` varchar(20) NOT NULL default '',
  `flag` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`f_id`),
  KEY `ip` (`ip`),
  KEY `id` (`id`),
  KEY `flag` (`flag`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_images";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_images (
  `id` int(10) unsigned NOT NULL auto_increment,
  `images` text NOT NULL,
  `news_id` int(10) NOT NULL default '0',
  `author` varchar(40) NOT NULL default '',
  `date` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `author` (`author`),
  KEY `news_id` (`news_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_logs";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_logs (
  `id` int(10) unsigned NOT NULL auto_increment,
  `news_id` int(10) NOT NULL default '0',
  `member` varchar(40) NOT NULL default '',
  `ip` varchar(46) NOT NULL default '',
  `rating` TINYINT(4) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `member` (`member`),
  KEY `ip` (`ip`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_vote";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_vote (
  `id` mediumint(8) NOT NULL auto_increment,
  `category` text NOT NULL,
  `vote_num` mediumint(8) NOT NULL default '0',
  `date` varchar(25) NOT NULL default '0',
  `title` varchar(200) NOT NULL default '',
  `body` text NOT NULL,
  `approve` tinyint(1) NOT NULL default '1',
  `start` varchar(15) NOT NULL default '',
  `end` varchar(15) NOT NULL default '',
  `grouplevel` varchar(250) NOT NULL default 'all',
  PRIMARY KEY  (`id`),
  KEY `approve` (`approve`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_vote_result";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_vote_result (
  `id` int(10) NOT NULL auto_increment,
  `ip` varchar(46) NOT NULL default '',
  `name` varchar(40) NOT NULL default '',
  `vote_id` mediumint(8) NOT NULL default '0',
  `answer` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `answer` (`answer`),
  KEY `vote_id` (`vote_id`),
  KEY `ip` (`ip`),
  KEY `name` (`name`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_lostdb";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_lostdb (
  `id` mediumint(8) NOT NULL auto_increment,
  `lostname` mediumint(8) NOT NULL default '0',
  `lostid` varchar( 40 ) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `lostid` (`lostid`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_pm";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_pm (
  `id` int(11) unsigned NOT NULL auto_increment,
  `subj` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `user` MEDIUMINT(8) NOT NULL default '0',
  `user_from` varchar(40) NOT NULL default '',
  `date` int(11) unsigned NOT NULL default '0',
  `pm_read` TINYINT(1) NOT NULL default '0',
  `folder` varchar(10) NOT NULL default '',
  `reply` tinyint(1) NOT NULL default '0',
  `sendid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`),
  KEY `pm_read` (`pm_read`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_post";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_post (
  `id` int(11) NOT NULL auto_increment,
  `autor` varchar(40) NOT NULL default '',
  `date` datetime NOT NULL default '2000-01-01 00:00:00',
  `short_story` MEDIUMTEXT NOT NULL,
  `full_story` MEDIUMTEXT NOT NULL,
  `xfields` MEDIUMTEXT NOT NULL,
  `title` varchar(255) NOT NULL default '',
  `descr` varchar(300) NOT NULL default '',
  `keywords` text NOT NULL,
  `category` varchar(190) NOT NULL default '0',
  `alt_name` varchar(190) NOT NULL default '',
  `comm_num` mediumint(8) unsigned NOT NULL default '0',
  `allow_comm` tinyint(1) NOT NULL default '1',
  `allow_main` tinyint(1) unsigned NOT NULL default '1',
  `approve` tinyint(1) NOT NULL default '0',
  `fixed` tinyint(1) NOT NULL default '0',
  `allow_br` tinyint(1) NOT NULL default '1',
  `symbol` varchar(3) NOT NULL default '',
  `tags` VARCHAR(255) NOT NULL default '',
  `metatitle` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `autor` (`autor`),
  KEY `alt_name` (`alt_name`),
  KEY `category` (`category`),
  KEY `approve` (`approve`),
  KEY `allow_main` (`allow_main`),
  KEY `date` (`date`),
  KEY `symbol` (`symbol`),
  KEY `comm_num` (`comm_num`),
  KEY `tags` (`tags`),
  KEY `fixed` (`fixed`),
  FULLTEXT KEY `short_story` (`short_story`,`full_story`,`xfields`,`title`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_post_extras";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_post_extras (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL DEFAULT '0',
  `news_read` int(11) NOT NULL DEFAULT '0',
  `allow_rate` tinyint(1) NOT NULL DEFAULT '1',
  `rating` int(11) NOT NULL DEFAULT '0',
  `vote_num` int(11) NOT NULL DEFAULT '0',
  `votes` tinyint(1) NOT NULL DEFAULT '0',
  `view_edit` tinyint(1) NOT NULL DEFAULT '0',
  `disable_index` tinyint(1) NOT NULL DEFAULT '0',
  `related_ids` varchar(255) NOT NULL DEFAULT '',
  `access` varchar(150) NOT NULL DEFAULT '',
  `editdate` int(11) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(40) NOT NULL DEFAULT '',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `disable_search` tinyint(1) NOT NULL DEFAULT '0',
  `need_pass` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`eid`),
  KEY `news_id` (`news_id`),
  KEY `user_id` (`user_id`),
  KEY `rating` (`rating`),
  KEY `disable_search` (`disable_search`),
  KEY `news_read` (`news_read`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_static";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_static (
  `id` MEDIUMINT(8) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `descr` varchar(255) NOT NULL default '',
  `template` MEDIUMTEXT NOT NULL,
  `allow_br` tinyint(1) NOT NULL default '0',
  `allow_template` tinyint(1) NOT NULL default '0',
  `grouplevel` varchar(100) NOT NULL default 'all',
  `tpl` varchar(40) NOT NULL default '',
  `metadescr` varchar(200) NOT NULL default '',
  `metakeys` text NOT NULL,
  `views` mediumint(8) NOT NULL default '0',
  `template_folder` varchar(50) NOT NULL default '',
  `date` int(11) unsigned NOT NULL default '0',
  `metatitle` varchar(255) NOT NULL default '',
  `allow_count` tinyint(1) NOT NULL default '1',
  `sitemap` tinyint(1) NOT NULL default '1',
  `disable_index` tinyint(1) NOT NULL default '0',
  `disable_search` tinyint(1) NOT NULL default '0',
  `password` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `disable_search` (`disable_search`),
  FULLTEXT KEY `template` (`template`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_users";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_users (
  `email` varchar(50) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `name` varchar(40) NOT NULL default '',
  `user_id` int(11) NOT NULL auto_increment,
  `news_num` mediumint(8) NOT NULL default '0',
  `comm_num` mediumint(8) NOT NULL default '0',
  `user_group` smallint(5) NOT NULL default '4',
  `lastdate` varchar(20) NOT NULL default '',
  `reg_date` varchar(20) NOT NULL default '',
  `banned` varchar(5) NOT NULL default '',
  `allow_mail` tinyint(1) NOT NULL default '1',
  `info` text NOT NULL,
  `signature` text NOT NULL,
  `foto` varchar(255) NOT NULL default '',
  `fullname` varchar(100) NOT NULL default '',
  `land` varchar(100) NOT NULL default '',
  `favorites` text NOT NULL,
  `pm_all` smallint(5) NOT NULL default '0',
  `pm_unread` smallint(5) NOT NULL default '0',
  `time_limit` varchar(20) NOT NULL default '',
  `xfields` text NOT NULL,
  `allowed_ip` varchar(255) NOT NULL default '',
  `hash` varchar(32) NOT NULL default '',
  `logged_ip` varchar(46) NOT NULL default '',
  `restricted` tinyint(1) NOT NULL default '0',
  `restricted_days` smallint(4) NOT NULL default '0',
  `restricted_date` varchar(15) NOT NULL default '',
  `timezone` varchar(100) NOT NULL default '',
  `news_subscribe` tinyint(1) NOT NULL default '0',
  `comments_reply_subscribe` tinyint(1) NOT NULL default '0',
  `twofactor_auth` tinyint(1) NOT NULL default '0',
  `cat_add` varchar(500) NOT NULL DEFAULT '',
  `cat_allow_addnews` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_banned";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_banned (
  `id` smallint(5) NOT NULL auto_increment,
  `users_id` int(11) NOT NULL default '0',
  `descr` text NOT NULL,
  `date` varchar(15) NOT NULL default '',
  `days` smallint(4) NOT NULL default '0',
  `ip` varchar(46) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`users_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_files";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_files (
  `id` int(11) NOT NULL auto_increment,
  `news_id` int(11) NOT NULL default '0',
  `name` varchar(250) NOT NULL default '',
  `onserver` varchar(250) NOT NULL default '',
  `author` varchar(40) NOT NULL default '',
  `date` varchar(15) NOT NULL default '',
  `dcount` int(11) NOT NULL default '0',
  `size` bigint(20) NOT NULL default '0',
  `checksum` char(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_usergroups";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_usergroups (
  `id` smallint(5) NOT NULL auto_increment,
  `group_name` varchar(50) NOT NULL default '',
  `allow_cats` text NOT NULL,
  `allow_adds` tinyint(1) NOT NULL default '1',
  `cat_add` text NOT NULL,
  `allow_admin` tinyint(1) NOT NULL default '0',
  `allow_addc` tinyint(1) NOT NULL default '0',
  `allow_editc` tinyint(1) NOT NULL default '0',
  `allow_delc` tinyint(1) NOT NULL default '0',
  `edit_allc` tinyint(1) NOT NULL default '0',
  `del_allc` tinyint(1) NOT NULL default '0',
  `moderation` tinyint(1) NOT NULL default '0',
  `allow_all_edit` tinyint(1) NOT NULL default '0',
  `allow_edit` tinyint(1) NOT NULL default '0',
  `allow_pm` tinyint(1) NOT NULL default '0',
  `max_pm` smallint(5) NOT NULL default '0',
  `max_foto` VARCHAR(10) NOT NULL default '',
  `allow_files` tinyint(1) NOT NULL default '0',
  `allow_hide` tinyint(1) NOT NULL default '1',
  `allow_short` tinyint(1) NOT NULL default '0',
  `time_limit` tinyint(1) NOT NULL default '0',
  `rid` smallint(5) NOT NULL default '0',
  `allow_fixed` tinyint(1) NOT NULL default '0',
  `allow_feed`  tinyint(1) NOT NULL default '1',
  `allow_search`  tinyint(1) NOT NULL default '1',
  `allow_poll`  tinyint(1) NOT NULL default '1',
  `allow_main`  tinyint(1) NOT NULL default '1',
  `captcha`  tinyint(1) NOT NULL default '0',
  `icon` varchar(200) NOT NULL default '',
  `allow_modc`  tinyint(1) NOT NULL default '0',
  `allow_rating` tinyint(1) NOT NULL default '1',
  `allow_offline` tinyint(1) NOT NULL default '0',
  `allow_image_upload` tinyint(1) NOT NULL default '0',
  `allow_file_upload` tinyint(1) NOT NULL default '0',
  `allow_signature` tinyint(1) NOT NULL default '0',
  `allow_url` tinyint(1) NOT NULL default '1',
  `news_sec_code` tinyint(1) NOT NULL default '1',
  `allow_image` tinyint(1) NOT NULL default '0',
  `max_signature` SMALLINT(6) NOT NULL default '0',
  `max_info` SMALLINT(6) NOT NULL default '0',
  `admin_addnews` tinyint(1) NOT NULL default '0',
  `admin_editnews` tinyint(1) NOT NULL default '0',
  `admin_comments` tinyint(1) NOT NULL default '0',
  `admin_categories` tinyint(1) NOT NULL default '0',
  `admin_editusers` tinyint(1) NOT NULL default '0',
  `admin_wordfilter` tinyint(1) NOT NULL default '0',
  `admin_xfields` tinyint(1) NOT NULL default '0',
  `admin_userfields` tinyint(1) NOT NULL default '0',
  `admin_static` tinyint(1) NOT NULL default '0',
  `admin_editvote` tinyint(1) NOT NULL default '0',
  `admin_newsletter` tinyint(1) NOT NULL default '0',
  `admin_blockip` tinyint(1) NOT NULL default '0',
  `admin_banners` tinyint(1) NOT NULL default '0',
  `admin_rss` tinyint(1) NOT NULL default '0',
  `admin_iptools` tinyint(1) NOT NULL default '0',
  `admin_rssinform` tinyint(1) NOT NULL default '0',
  `admin_googlemap` tinyint(1) NOT NULL default '0',
  `allow_html` tinyint(1) NOT NULL default '1',
  `group_prefix` text NOT NULL,
  `group_suffix` text NOT NULL,
  `allow_subscribe` tinyint(1) NOT NULL default '0',
  `allow_image_size` tinyint(1) NOT NULL default '0',
  `cat_allow_addnews` text NOT NULL,
  `flood_news` smallint(6) NOT NULL default '0',
  `max_day_news` smallint(6) NOT NULL default '0',
  `force_leech` tinyint(1) NOT NULL default '0',
  `edit_limit` smallint(6) NOT NULL default '0',
  `captcha_pm` tinyint(1) NOT NULL default '0',
  `max_pm_day` smallint(6) NOT NULL default '0',
  `max_mail_day` smallint(6) NOT NULL default '0',
  `admin_tagscloud` tinyint(1) NOT NULL default '0',
  `allow_vote` tinyint(1) NOT NULL default '0',
  `admin_complaint` tinyint(1) NOT NULL default '0',
  `news_question` tinyint(1) NOT NULL default '0',
  `comments_question` tinyint(1) NOT NULL default '0',
  `max_comment_day` smallint(6) NOT NULL default '0',
  `max_images` smallint(6) NOT NULL default '0',
  `max_files` smallint(6) NOT NULL default '0',
  `disable_news_captcha` smallint(6) NOT NULL default '0',
  `disable_comments_captcha` smallint(6) NOT NULL default '0',
  `pm_question` tinyint(1) NOT NULL default '0',
  `captcha_feedback` tinyint(1) NOT NULL default '1',
  `feedback_question` tinyint(1) NOT NULL default '0',
  `files_type` varchar(255) NOT NULL default '',
  `max_file_size` mediumint(9) NOT NULL default '0',
  `files_max_speed` smallint(6) NOT NULL default '0',
  `spamfilter` tinyint(1) NOT NULL default '2',
  `allow_comments_rating` tinyint(1) NOT NULL default '1',
  `max_edit_days` tinyint(1) NOT NULL default '0',
  `spampmfilter` tinyint(1) NOT NULL default '0',
  `force_reg` TINYINT(1) NOT NULL default '0',
  `force_reg_days` MEDIUMINT(9) NOT NULL default '0',
  `force_reg_group` SMALLINT(6) NOT NULL default '4',
  `force_news` TINYINT(1) NOT NULL default '0',
  `force_news_count` MEDIUMINT(9) NOT NULL default '0',
  `force_news_group` SMALLINT(6) NOT NULL default '4',
  `force_comments` TINYINT(1) NOT NULL default '0',
  `force_comments_count` MEDIUMINT(9) NOT NULL default '0',
  `force_comments_group` SMALLINT(6) NOT NULL default '4',
  `force_rating` TINYINT(1) NOT NULL default '0',
  `force_rating_count` MEDIUMINT(9) NOT NULL default '0',
  `force_rating_group` SMALLINT(6) NOT NULL default '4',
  `not_allow_cats` text NOT NULL,
  `allow_up_image` TINYINT(1) NOT NULL default '0',
  `allow_up_watermark` TINYINT(1) NOT NULL default '0',
  `allow_up_thumb` TINYINT(1) NOT NULL default '0',
  `up_count_image` SMALLINT(6) NOT NULL default '0',
  `up_image_side` varchar(20) NOT NULL default '',
  `up_image_size` MEDIUMINT(9) NOT NULL default '0',
  `up_thumb_size` varchar(20) NOT NULL default '',
  `allow_mail_files` TINYINT(1) NOT NULL DEFAULT '0',
  `max_mail_files` SMALLINT(6) NOT NULL DEFAULT '0',
  `max_mail_allfiles` MEDIUMINT(9) NOT NULL DEFAULT '0',
  `mail_files_type` VARCHAR(100) NOT NULL DEFAULT '',
  `video_comments` TINYINT(1) NOT NULL DEFAULT '0',
  `media_comments` TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_poll";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_poll (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `news_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(200) NOT NULL default '',
  `frage` varchar(200) NOT NULL default '',
  `body` text NOT NULL,
  `votes` mediumint(8) NOT NULL default '0',
  `multiple` tinyint(1) NOT NULL default '0',
  `answer` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_poll_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_poll_log (
  `id` int(10) unsigned NOT NULL auto_increment,
  `news_id` int(10) unsigned NOT NULL default '0',
  `member` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `member` (`member`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_banners";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_banners (
  `id` smallint(5) NOT NULL auto_increment,
  `banner_tag` varchar(40) NOT NULL default '',
  `descr` varchar(200) NOT NULL default '',
  `code` text NOT NULL,
  `approve` tinyint(1) NOT NULL default '0',
  `short_place` tinyint(1) NOT NULL default '0',
  `bstick` tinyint(1) NOT NULL default '0',
  `main` tinyint(1) NOT NULL default '0',
  `category` VARCHAR(255) NOT NULL default '',
  `grouplevel` varchar(100) NOT NULL default 'all',
  `start` varchar(15) NOT NULL default '',
  `end` varchar(15) NOT NULL default '',
  `fpage` tinyint(1) NOT NULL default '0',
  `innews` tinyint(1) NOT NULL default '0',
  `devicelevel` varchar(10) NOT NULL default '',
  `allow_views` tinyint(1) NOT NULL default '0',
  `max_views` int(11) NOT NULL default '0',
  `allow_counts` tinyint(1) NOT NULL default '0',
  `max_counts` int(11) NOT NULL default '0',
  `views` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `rubric` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_rss";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_rss (
  `id` smallint(5) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `allow_main` tinyint(1) NOT NULL default '0',
  `allow_rating` tinyint(1) NOT NULL default '0',
  `allow_comm` tinyint(1) NOT NULL default '0',
  `text_type` tinyint(1) NOT NULL default '0',
  `date` tinyint(1) NOT NULL default '0',
  `search` text NOT NULL,
  `max_news` tinyint(3) NOT NULL default '0',
  `cookie` text NOT NULL,
  `category` smallint(5) NOT NULL default '0',
  `lastdate` INT(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_views";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_views (
  `id` int(11) NOT NULL auto_increment,
  `news_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";


$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_rssinform";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_rssinform (
  `id` smallint(5) NOT NULL auto_increment,
  `tag` varchar(40) NOT NULL default '',
  `descr` varchar(255) NOT NULL default '',
  `category` varchar(200) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `template` varchar(40) NOT NULL default '',
  `news_max` smallint(5) NOT NULL default '0',
  `tmax` smallint(5) NOT NULL default '0',
  `dmax` smallint(5) NOT NULL default '0',
  `approve` tinyint(1) NOT NULL default '1',
  `rss_date_format` VARCHAR(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_notice";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_notice (
  `id` mediumint(8) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `notice` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_static_files";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_static_files (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `static_id` int(11) NOT NULL default '0',
  `author` varchar(40) NOT NULL default '',
  `date` varchar(15) NOT NULL default '',
  `name` varchar(200) NOT NULL default '',
  `onserver` varchar(190) NOT NULL default '',
  `dcount` int(11) NOT NULL default '0',
  `size` bigint(20) NOT NULL default '0',
  `checksum` char(32) NOT NULL default '',
  PRIMARY KEY (`id`),
  KEY `static_id` (`static_id`),
  KEY `onserver` (`onserver`),
  KEY `author` (`author`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_tags";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_tags (
  `id` INT(11) NOT NULL auto_increment,
  `news_id` INT(11) NOT NULL default '0',
  `tag` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `tag` (`tag`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_post_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_post_log (
  `id` INT(11) NOT NULL auto_increment,
  `news_id` INT(11) NOT NULL default '0',
  `expires` varchar(15) NOT NULL default '',
  `action` tinyint(1) NOT NULL default '0',
  `move_cat` VARCHAR(190) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `expires` (`expires`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_admin_sections";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_admin_sections (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `descr` varchar(255) NOT NULL default '',
  `icon` varchar(255) NOT NULL default '',
  `allow_groups` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_subscribe";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_subscribe (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `name` varchar(40) NOT NULL default '',
  `email`  varchar(50) NOT NULL default '',
  `news_id` int(11) NOT NULL default '0',
  `hash` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `user_id` (`user_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_sendlog";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_sendlog (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(40) NOT NULL DEFAULT '',
  `date` INT(11) unsigned NOT NULL DEFAULT '0',
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `date` (`date`),
  KEY `flag` (`flag`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_login_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_login_log (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(46) NOT NULL DEFAULT '',
  `count` smallint(6) NOT NULL DEFAULT '0',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`),
  KEY `date` (`date`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_mail_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_mail_log (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `mail` varchar(50) NOT NULL DEFAULT '',
  `hash` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `hash` (`hash`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_complaint";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_complaint (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL DEFAULT '0',
  `c_id` int(11) NOT NULL DEFAULT '0',
  `n_id` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `from` varchar(40) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `c_id` (`c_id`),
  KEY `p_id` (`p_id`),
  KEY `n_id` (`n_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_ignore_list";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_ignore_list (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL default '0',
  `user_from` VARCHAR(40) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_admin_logs";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_admin_logs (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(46) NOT NULL DEFAULT '',
  `action` int(11) NOT NULL DEFAULT '0',
  `extras` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `date` (`date`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_question";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_question (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL DEFAULT '',
  `answer` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_read_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_read_log (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `ip` (`ip`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_spam_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_spam_log (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(46) NOT NULL DEFAULT '',
  `is_spammer` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`),
  KEY `is_spammer` (`is_spammer`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_links";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_links (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `only_one` tinyint(1) NOT NULL DEFAULT '0',
  `replacearea` tinyint(1) NOT NULL DEFAULT '1',
  `rcount` tinyint(3) NOT NULL DEFAULT '0',
  `targetblank` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_social_login";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_social_login (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` varchar(40) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '0',
  `password` varchar(32) NOT NULL DEFAULT '',
  `provider` varchar(15) NOT NULL DEFAULT '',
  `wait` tinyint(1) NOT NULL DEFAULT '0',
  `waitlogin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_comment_rating_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_comment_rating_log (
  `id` int unsigned NOT NULL auto_increment,
  `c_id` int NOT NULL default '0',
  `member` varchar(40) NOT NULL default '',
  `ip` varchar(46) NOT NULL default '',
  `rating` TINYINT(4) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`),
  KEY `c_id` (`c_id`),
  KEY `member` (`member`),
  KEY `ip` (`ip`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_xfsearch";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_xfsearch (
  `id` INT(11) NOT NULL auto_increment,
  `news_id` INT(11) NOT NULL default '0',
  `tagname` varchar(50) NOT NULL default '',
  `tagvalue` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `tagname` (`tagname`),
  KEY `tagvalue` (`tagvalue`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_comments_files";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_comments_files (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `c_id` int(10) NOT NULL default '0',
  `author` varchar(40) NOT NULL default '',
  `date` varchar(15) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY (`id`),
  KEY `c_id` (`c_id`),
  KEY `author` (`author`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_twofactor";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_twofactor (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL default '0',
  `pin` varchar(10) NOT NULL default '',
  `attempt` tinyint(1) NOT NULL DEFAULT '0',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pin` (`pin`),
  KEY `date` (`date`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_redirects";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_redirects (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(250) NOT NULL default '',
  `to` varchar(250) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_post_pass";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_post_pass (
  `id` INT(11) NOT NULL auto_increment,
  `news_id` INT(11) NOT NULL default '0',
  `password` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_metatags";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_metatags (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(250) NOT NULL default '',
  `title` varchar(200) NOT NULL default '',
  `description` varchar(300) NOT NULL default '',
  `keywords` text NOT NULL,
  `page_title` varchar(255) NOT NULL default '',
  `page_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_banners_logs";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_banners_logs (
  `id` int(11) unsigned NOT NULL auto_increment,
  `bid` int(11) NOT NULL default '0',
  `click` tinyint(1) NOT NULL default '0',
  `ip` varchar(46) NOT NULL  default '',
  PRIMARY KEY  (`id`),
  KEY `bid` (`bid`),
  KEY `ip` (`ip`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_banners_rubrics";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_banners_rubrics (
  `id` mediumint(8) NOT NULL auto_increment,
  `parentid` mediumint(8) NOT NULL default '0',
  `title` varchar(70) NOT NULL default '',
  `description` varchar(255) NOT NULL  default '',
  PRIMARY KEY  (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_plugins";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_plugins (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL DEFAULT '',
  `version` varchar(10) NOT NULL DEFAULT '',
  `dleversion` varchar(10) NOT NULL DEFAULT '',
  `versioncompare` char(2) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `mysqlinstall` text NOT NULL,
  `mysqlupgrade` text NOT NULL,
  `mysqlenable` text NOT NULL,
  `mysqldisable` text NOT NULL,
  `mysqldelete` text NOT NULL,
  `filedelete` tinyint(1) NOT NULL DEFAULT '0',
  `filelist` text NOT NULL,
  `upgradeurl` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_plugins_files";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_plugins_files (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_id` int(11) NOT NULL DEFAULT '0',
  `file` varchar(255) NOT NULL DEFAULT '',
  `action` varchar(10) NOT NULL DEFAULT '',
  `searchcode` text NOT NULL,
  `replacecode` mediumtext NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `searchcount` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `plugin_id` (`plugin_id`),
  KEY `active` (`active`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_plugins_logs";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_plugins_logs (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_id` int(11) NOT NULL DEFAULT '0',
  `area` text NOT NULL,
  `error` text NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `plugin_id` (`plugin_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "INSERT INTO " . PREFIX . "_rssinform VALUES (1, 'dle', 'آخرین مطالب سایت دیتالایف انجین', '0', 'https://dle-news.com/rss.xml', 'informer', 3, 0, 200, 1, 'j F Y H:i')";

$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (1, 'مدیر کل', 'all', 1, 'all', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 50, 101, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0, '{THEME}/images/icon_1.gif', 0, 1, 1, 1, 1, 1, 1, 0, 1,500,1000,1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,1,'<b><span style=\"color:red\">','</span></b>',1,1,'all', 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 2, 1, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, '', 1, 1, 1, 3, '800x600', 300, '200x150', 1, 3, 1000, 'jpg,png,zip,pdf',1,1)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (2, 'مدیر', 'all', 1, 'all', 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 50, 101, 1, 1, 1, 0, 2, 1, 1, 1, 1, 1, 0, '{THEME}/images/icon_2.gif', 0, 1, 0, 1, 1, 1, 1, 0, 1,500,1000,1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,1,'','',1,1,'all', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 2, 1, 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, 2, 0, 0, 2, '', 1, 1, 1, 3, '800x600', 300, '200x150', 1, 3, 1000, 'jpg,png,zip,pdf',1,1)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (3, 'ویرایشگر', 'all', 1, 'all', 1, 1, 1, 1, 0, 0, 1, 0, 1, 1, 50, 101, 1, 1, 1, 0, 3, 0, 1, 1, 1, 1, 0, '{THEME}/images/icon_3.gif', 0, 1, 0, 1, 1, 1, 1, 0, 1,500,1000,1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,1,'','',1,1,'all', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 2, 1, 0, 0, 0, 0, 3, 0, 0, 3, 0, 0, 3, 0, 0, 3, '', 1, 1, 1, 3, '800x600', 300, '200x150', 0, 3, 1000, 'jpg,png,zip,pdf',1,1)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (4, 'عضو سایت', 'all', 1, 'all', 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 20, 101, 1, 1, 1, 0, 4, 0, 1, 1, 1, 1, 0, '{THEME}/images/icon_4.gif', 0, 1, 0, 1, 0, 1, 1, 1, 0,500,1000,0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,1,'','',1,0,'all', 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 2, 1, 0, 2, 0, 0, 4, 0, 0, 4, 0, 0, 4, 0, 0, 4, '', 0, 0, 0, 1, '800x600', 300, '200x150', 0, 3, 1000, 'jpg,png,zip,pdf',0,0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (5, 'مهمان', 'all', 0, 'all', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 5, 0, 1, 1, 1, 0, 1, '{THEME}/images/icon_5.gif', 0, 1, 0, 0, 0, 0, 1, 1, 0,1,1,0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,0,'','',0,0,'all', 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '', 0, 0, 2, 1, 0, 2, 0, 0, 5, 0, 0, 5, 0, 0, 5, 0, 0, 5, '', 0, 0, 0, 1, '', 0, '', 0, 3, 1000, 'jpg,png,zip,pdf',0,0)";


$tableSchema[] = "INSERT INTO " . PREFIX . "_rss VALUES (1, 'https://dle-news.com/rss.xml', 'DataLife Engine Official Website', 1, 1, 1, 1, 1, '<div class=\"full-post-content row\">{get}</div><div class=\"full-post-footer ignore-select\">', 5, '', 1, 0)";

$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (1, 'reg_mail', 'با سلام خدمت شما کاربر گرامی {%username%},\r\n\r\nاز اینکه در وب سایت $url ثبت نام کرده اید، متشکریم؛ \r\n\r\n مشخصات شما در این وب سایت به شرح زیر می‌باشد:\r\n\r\nنام کاربری: {%username%}\r\nرمز عبور: {%password%}\r\n\r\n\r\nاکنون جهت تکمیل و اتمام مراحل ثبت نام در سایت، بر روی لینک زیر کلیک نمائید:\r\n\r\n{%validationlink%}', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (2, 'feed_mail', 'با سلام خدمت شما کاربر گرامی {%username_to%},\r\n\r\nایمیلی از طرف نام کاربری {%username_from%} در سایت $url  برای شما ارسال شده است.\r\n\r\nمتن پیام به شرح زیر می‌باشد:\r\n\r\n{%text%}\r\n\r\nIP ارسال کننده: {%ip%}', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (3, 'lost_mail', 'با سلام خدمت شما کاربر گرامی {%username%},\r\n\r\nبرای اکانت کاربری شما در وب سایت $url  درخواست تغییر رمزعبور داده شده است.\r\n در صورتی که این درخواست از جانب شما بوده است بر روی لینک زیر کلیک نمایید تا فرایند تغییر کلمه عبور شما تکمیل گردد؛ در غیر این صورت این ایمیل را نادیده بگیرید: \r\n\r\n{%lostlink%}\r\n\r\nIP ارسال کننده: {%ip%}', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (4, 'new_news', 'با سلام خدمت شما مدیریت محترم سایت $url \r\n\r\nمطلب جدیدی در سایت با مشخصات زیر ارسال گردید:\r\n\r\nفرستنده: {%username%}\r\nعنوان مطلب: {%title%}\r\nموضوع: {%category%}\r\nتاریخ ارسال: {%date%}', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (5, 'comments', 'با سلام خدمت شما کاربر گرامی {%username_to%},\r\n\r\nنظر جدیدی در وب سایت  $url  توسط شخصی با نام کاربری {%username%} ارسال شده است.\r\nتاریخ ارسال: {%date%}\r\nلینک خبر:  {%link%}\r\n\r\nمتن نظر به شرح زیر است:\r\n{%text%}\r\n\r\n\r\n اگر شما می‌خواهید اشتراک خود را از آگاهی نظر جدید این خبر حذف کنید، بر روی لینک زیر کلیک نمائید: \r\n{%unsubscribe%}', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (6, 'pm', 'با سلام خدمت شما کاربر گرامی {%username%},\r\n\r\nشما در وب سایت $url پیغام خصوصی جدیدی دریافت کرده اید. \r\n\r\n مشخصات این پیغام خصوصی به شرح زیر می‌باشد:\r\n\r\n فرستنده: {%fromusername%}\r\nتاریخ ارسال: {%date%}\r\nعنوان پیام: {%title%}\r\n\r\nمتن پیام به شرح زیر می‌باشد:\r\n{%text%}', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (7, 'wait_mail', '{%username%} عزیز,\r\n\r\nشما در سایت $url با استفاده از شبکه اجتماعی {%network%} ثبت نام کرده اید. بخاطر مسائل امنیتی، بر روی لینک زیر کلیک کنید تا مراحل ثبت نام تکمیل شود: \r\n\r\n------------------------------------------------\r\n{%link%}\r\n------------------------------------------------\r\n\r\nتوجه، در صورتی که قبلاً در این سایت حساب کاربری ایجاد کرده باشید (بدون شبکه اجتماعی)، رمز عبور شما تغییر خواهد یافت و به صورت قبل امکان ورود ندارید و فقط با استفاده از شبکه اجتماعی قادر خواهید بود وارد سایت شوید.\r\n\r\nاگر شما این درخواست را ارسال نکرده اید، بر روی لینک بالا کلیک نکنید و این ایمیل را نادیده بگیرید.\r\n\r\nآی پی شخص درخواست کننده: {%ip%}\r\n\r\nبا تشکر،\r\n\r\nمدیریت سایت $url', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (8, 'newsletter', '<html>\r\n<head>\r\n<title>{%title%}</title>\r\n<meta content=\"text/html; charset={%charset%}\" http-equiv=Content-Type>\r\n<style type=\"text/css\">\r\nhtml,body{\r\n    font-family: Tahoma;\r\n    word-spacing: 0.1em;\r\n    letter-spacing: 0;\r\n    direction: rtl;\r\n    text-align: right;\r\n    line-height: 1.5em;\r\n    font-size: 11px;\r\n}\r\n\r\np {\r\n margin:0px;\r\n padding: 0px;\r\n}\r\n\r\na:active,\r\na:visited,\r\na:link {\r\n color: #4b719e;\r\n text-decoration:none;\r\n}\r\n\r\na:hover {\r\n color: #4b719e;\r\n text-decoration: underline;\r\n}\r\n</style>\r\n</head>\r\n<body>\r\n{%content%}\r\n</body>\r\n</html>', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (9, 'twofactor', 'با سلام خدمت شما کاربر گرامی {%username%},\r\n\r\nاین ایمیل از طرف سایت $url ارسال شده است.\r\n\r\nاین ایمیل بنابر درخواست شما مبنی بر فعال سازی احراز هویت 2 مرحله ای ارسال شده است. برای ورود به سایت لازم است پین مشخص شده را وارد نمایید.\r\n\r\n------------------------------------------------\r\nPin:\r\n------------------------------------------------\r\n\r\n{%pin%}\r\n\r\n------------------------------------------------\r\n\r\nIP شما: {%ip%}\r\n\r\nموفق باشید،\r\n\r\nاز طرف مدیریت سایت $url', 0)";


$tableSchema[] = "INSERT INTO " . PREFIX . "_category (name, alt_name, keywords) values ('خبرها', 'news', '')";

$tableSchema[] = "INSERT INTO " . PREFIX . "_banners (banner_tag, descr, code, approve, short_place, bstick, main, category) values ('header', 'Top banner', '<div align=\"center\"><a href=\"https://dle-news.com/\" target=\"_blank\"><img src=\"{$url}templates/Default/images/_banner_.gif\" style=\"border: none;\" alt=\"\" /></a></div>', 1, 0, 0, 0, 0)";

$add_time = time();
$thistime = date ("Y-m-d H:i:s", $add_time);

$tableSchema[] = "INSERT INTO " . PREFIX . "_static (`name`, `descr`, `template`, `allow_br`, `allow_template`, `grouplevel`, `tpl`, `metadescr`, `metakeys`, `views`, `template_folder`, `date`) VALUES ('dle-rules-page', 'قوانین عمومی سایت', '<b>قوانین عمومی طرز رفتار در سایت</b><br /><br />برای شروع سایت، با ارتباط برقرار کردن صدها نفر از مردم از ادیان و اعتقادات مختلف، و بسیاری از میهمانان سایت، شما موظف هستید که به یک سری از قوانین سایت عمل کنید. شما را توصیه به خواندن این قوانین می کنیم که در کل بیشتر از پنج دقیقه طول نمی کشد.<br /><br />1. این وب سایت تابع قوانین جمهوری اسلامی ایران می باشد.<br />2. کپی مطلب از این وب سایت با ذکر منبع بلامانع است.<br />3. نمایش مطالب هر عضو در سایت به معنای تایید آن نیست و مسئولیت آن بر عهده خود نویسنده مطلب می باشد.<br />4. توهین به هر شخص ،  نژاد ، قوم و زبانی در این سایت ممنوع می باشد.<br />5. در حد امکان از بحث ها تفرقه انگیز بین اقوام ایرانی و طرح مطالبی که موجب ایجاد تنش بین اعضای سایت می گردد خودداری شود.<br /><br /><b>در صورتی که شخصی از قوانین سایت خارج گردد نام کاربری ایشان مسدود خواهد شد.</b><br /><div align=\"center\">{ACCEPT-DECLINE}</div>', 1, 1, 'all', '', 'قوانین عمومی', 'قوانین عمومی', 0, '', '{$add_time}')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_users (name, password, email, reg_date, lastdate, user_group, news_num, info, signature, favorites, xfields) values ('$reg_username', '$reg_password', '$reg_email', '$add_time', '$add_time', '1', '1', '', '', '', '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_vote (category, vote_num, date, title, body) VALUES ('all', '0', '$thistime', 'نظرشما در مورد سیستم؟', 'عالی<br />خوب<br />متوسط<br />بد')";

$title = "دیتالایف انجین فارسی نسخه 13.1";


$short_story = "به نام خدا<br><br>آخرین نسخه ی سیستم مدیریت محتوای دیتالایف انجین فارسی بدون دستکاری و اضافه نمودن ماژولی خاص پیشکش حضورتان.<br><br>با آغوش باز پذیرای انتقادات و پیشنهادات شما در ارتباط با هرگونه ایراد و یا اشکال سیستمی و یا بهتر سازی مدیریت محتوا هستیم. <br><br>برای دانلود قالب و امکانات اضافی دیگر به سایت <a href=\"https://dle-news.com\" rel=\"noopener noreferrer external\" target=\"_blank\">دیتالایف انجین</a> مراجعه فرمایید.<br><br><div align=\"center\"><img src=\"{$url}uploads/boxsmall.jpg\" width=\"350\" height=\"225\" class=\"fr-fic fr-dii\" alt=\"\"></div>با تقدیم احترام<br>تیم دیتالایف انجین";
$full_story = "";

$tableSchema[] = "INSERT INTO " . PREFIX . "_post (id, date, autor, short_story, full_story, xfields, title, keywords, category, alt_name, allow_comm, approve, allow_main, tags) values ('1', '$thistime', '$reg_username', '$short_story', '$full_story', '', '$title', '', '1', 'دیتالایف-انجین-فارسی-نسخه-13-1', '1', '1', '1', 'Datalife, Engine, CMS, نسخه دیتالایف انجین فارسی')";

$tableSchema[] = "INSERT INTO " . PREFIX . "_post_extras (news_id, user_id) values ('1', '1')";

$tableSchema[] = "INSERT INTO " . PREFIX . "_tags (news_id, tag) values ('1', 'DLE'), ('1', 'Datalife'), ('1', 'Engine'), ('1', 'CMS'), ('1', 'Farsi')";

      foreach($tableSchema as $table) {

        $db->query($table);

      }

  echo $skin_header;


echo <<<HTML
<div class="panel panel-default">
  <div class="panel-heading">
    {$title}
  </div>
  <div class="panel-body">
	سیستم مدیریت محتوای دیتالایف انجین با موفقیت بر روی سایت شما نصب گردید.<br/><br/>
	اکنون وارد <B><a href="admin.php"><font color="#1176CC" size="2">پنل مدیریت</font></a></B> خود شده و پلاگین های شمسی ساز دیتالایف انجین فارسی را آپلود نمایید. این پلاگین ها را می توانید از آدرس <B><a href="admin.php"><font color="#1176CC" size="2">اینجا</font></a></B> دانلود نمایید.<br><br>
	<font color="red"><strong>توجه:</strong> به یاد داشته باشید که فایل <b>install.php</b> را برای امنیت بیشتر سایت حذف کنید.</font>
	<br><br>
	موفق باشید.<br>
  </div>
  <div class="panel-footer">
	<a href="{$url}" class="btn bg-teal btn-sm btn-raised position-left"><i class="fa fa-arrow-circle-o-left position-left"></i>ورود به سایت</a>
  </div>
</div>
HTML;

}
else {

	if (@file_exists(ENGINE_DIR.'/data/config.php')) {

		msgbox( "", "خطا در نصب سیستم", "به دلیل وجود فایل <b>engine/data/config.php/</b> شما نمی توانید دوباره این سیستم را نصب کنید. [مگر آنکه فایل مذکور را حذف کنید]" );

		die ();
	}

$_SESSION['dle_install'] = 1;

// ********************************************************************************
// Greeting
// ********************************************************************************

  echo $skin_header;

echo <<<HTML
<form method="get" action="">
<input type="hidden" name="action" value="eula">
<div class="panel panel-default">
  <div class="panel-heading">
    نصب و راه اندازی سیستم دیتالایف انجین فارسی
  </div>
	<div class="panel-body">
	سلام و عرض احترام خدمت شما کاربر گرامی!<br><br>
	به صفحه نصب نسخه 13.1 سیستم مدیریت محتوای دیتالایف انجین خوش آمدید.<br><br>
	به خاطر داشته باشید در صورتیکه حالت سئوی سیستم را غیرفعال می کنید، فایل <b>htaccess.</b> را از روی سرور حذف نموده و در مرحله پیکربندی سیستم قابلیت سئو را غیر فعال نمایید.<br><br>
	<span class="text-danger">توجه: برای امنیت بیشتر سایت، ضروریست که بعد از نصب، فایل <B>install.php</b> را از سرور خود پاک کنید.</span><br><br>
	امیدواریم از امکانات این نسخه از سیستم نهایت لذت رو ببرید.<br><br>
	تیم مدیریتی دیتالایف انجین</a>
	</div>
	<div class="panel-footer">
	<button type="submit" class="btn bg-teal btn-sm btn-raised position-left"><i class="fa fa-arrow-circle-o-left position-left"></i>شروع نصب</button>
	</div>
</div>
</form>
HTML;
}


echo $skin_footer;
?>