<?php
/*
=====================================================
 DataLife Engine v13.1
-----------------------------------------------------
 Persian support site: https://dlefa.ir
-----------------------------------------------------
 Translate & Develope :
	Seyed Ehsan Setarehdan   - Eh3an@Setarehdan.ir
-----------------------------------------------------
 FileName :  engine/ajax/updates_fa.php
-----------------------------------------------------
 Copyright (c) 2018, All rights reserved.
=====================================================
*/

if(!defined('DATALIFEENGINE')) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../' );
	die( "Hacking attempt!" );
}

if(($member_id['user_group'] != 1)) {die ("error");}

if( $_REQUEST['user_hash'] == "" OR $_REQUEST['user_hash'] != $dle_login_hash ) {

	echo $lang['sess_error'];
	die();

}

$_REQUEST['versionid'] = htmlspecialchars( strip_tags($_REQUEST['versionid']), ENT_QUOTES, $config['charset']);

$data = @file_get_contents("https://dlefa.ir/extras/update.php?version_id=".$_REQUEST['versionid']);

if (!strlen($data)) echo $lang['no_update']; else echo $data;
	
?>