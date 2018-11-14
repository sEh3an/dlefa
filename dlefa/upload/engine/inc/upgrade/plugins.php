<?php
/*
=====================================================
 DataLife Engine - by SoftNews Media Group 
-----------------------------------------------------
 http://dle-news.ru/
-----------------------------------------------------
 Copyright (c) 2004-2018 SoftNews Media Group
=====================================================
 This code is protected by copyright
=====================================================
 File: plugins.php
-----------------------------------------------------
 Use: AJAX plugins manage
=====================================================
*/

if(!defined('DATALIFEENGINE')) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../' );
	die( "Hacking attempt!" );
}

if($member_id['user_group'] != 1) {
	echo_error ($lang['sess_error']);
}

function install_xml_plugin ($plugin) {
	global $config, $db, $member_id, $_TIME, $_IP, $lang;

	$id = intval($id);
	libxml_use_internal_errors(true);
	
	$xml = simplexml_load_string($plugin);
	
	if (!$xml) {
		
		$errors = libxml_get_errors();
		echo 'XML Error!';
		
	} else {
		
		if(is_array($file_list) AND count($file_list)){
			$file_list = $db->safesql(implode(",", $file_list));
		} else $file_list = "";
		
		if ( $xml->name ) $name = (string)$xml->name;
		if ( $xml->description ) $description = (string)$xml->description;
		if ( $xml->icon ) $icon = (string)$xml->icon;
		if ( $xml->version ) $version = (string)$xml->version;
		if ( $xml->dleversion ) $dleversion = (string)$xml->dleversion;
		if ( $xml->versioncompare ) $versioncompare = (string)$xml->versioncompare;
		if ( $xml->upgradeurl ) $upgradeurl = (string)$xml->upgradeurl;
		if ( $xml->filedelete ) $filedelete = trim((string)$xml->filedelete);
		
		if( $versioncompare == "greater" ) $versioncompare = '>=';
		elseif ( $versioncompare == "less") $versioncompare = '<=';
		
		if ( $xml->mysqlinstall ) $_POST['mysqlinstall'] = trim((string)$xml->mysqlinstall);
		if ( $xml->mysqlupgrade ) $_POST['mysqlupgrade'] = trim((string)$xml->mysqlupgrade);
		if ( $xml->mysqlenable )  $_POST['mysqlenable'] = trim((string)$xml->mysqlenable);
		if ( $xml->mysqldisable ) $_POST['mysqldisable'] = trim((string)$xml->mysqldisable);
		if ( $xml->mysqldelete )  $_POST['mysqldelete'] = trim((string)$xml->mysqldelete);
		
		$i=0;
		$t=0;
		
		if ( $xml->file ) {
			foreach ($xml->file as $file) {
				$i++;
				$_POST['file'][$i] = (string)$file->attributes()->name;
				
				if ( $file->operation ) {
					foreach ($file->operation as $operation) {
						$t++;
						$_POST['fileaction'][$i][$t] = (string)$operation->attributes()->action;
						
						if($operation->searchcode) $_POST['filesearch'][$i][$t] = (string)$operation->searchcode;
						if($operation->replacecode) $_POST['filereplace'][$i][$t] = (string)$operation->replacecode;
						if($operation->searchcount) $_POST['filefindcount'][$i][$t] = (string)$operation->searchcount;
						
					}
					
					
				}
				
			}
		}
		
		$name = $db->safesql(htmlspecialchars( trim($name), ENT_QUOTES, $config['charset'] ));
		$description = $db->safesql(htmlspecialchars( trim($description), ENT_QUOTES, $config['charset'] ));
		$icon = $db->safesql( clearfilepath( htmlspecialchars( trim($icon), ENT_QUOTES, $config['charset'] ), array ("gif", "jpg", "jpeg", "png" ) ) );
		$version = $db->safesql(htmlspecialchars( trim($version), ENT_QUOTES, $config['charset'] ));
		$dleversion = $db->safesql(htmlspecialchars( trim($dleversion), ENT_QUOTES, $config['charset'] ));
		$upgradeurl = $db->safesql( htmlspecialchars( trim($upgradeurl), ENT_QUOTES, $config['charset'] ) );
		$filedelete = intval($filedelete);
		if ( in_array( $versioncompare, array("==", ">=", "<=") ) ) $versioncompare = $db->safesql($versioncompare); else $versioncompare = '';
		
		$mysqlinstall = $db->safesql($_POST['mysqlinstall']);
		$mysqlupgrade = $db->safesql($_POST['mysqlupgrade']);
		$mysqlenable = $db->safesql($_POST['mysqlenable']);
		$mysqldisable = $db->safesql($_POST['mysqldisable']);
		$mysqldelete = $db->safesql($_POST['mysqldelete']);
		
		$files = array();
		$allowed_action =array("replace", "before", "after", "replaceall", "create");
		
		if(is_array($_POST['file']) AND count($_POST['file']) ) {
			
			foreach($_POST['file'] as $key => $value) {
				$file_name = clearfilepath( trim($value) , array ("php", "lng" ) );
				
				if(!$file_name) continue;

				if(is_array($_POST['fileaction'][$key]) AND count($_POST['fileaction'][$key]) ) {
					
					foreach($_POST['fileaction'][$key] as $key2 => $value2) {
						
						if( !in_array($value2, $allowed_action) ) continue;
						
						$file_action = $value2;
						$file_search = $_POST['filesearch'][$key][$key2];
						$file_replace = $_POST['filereplace'][$key][$key2];
						$searchcount = intval($_POST['filefindcount'][$key][$key2]);
						
						if( !trim($file_search) ) $file_search ='';
						if( !trim($file_replace) ) $file_replace ='';
	
						if( ($file_action == "replace" OR $file_action == "before" OR $file_action == "after") AND !$file_search ) continue;
						
						if( ($file_action == "before" OR $file_action == "after" OR $file_action == "replaceall" OR $file_action == "create") AND !$file_replace) continue;
						
						$files[$file_name][] = array('action' => $file_action, 'searchcode' => $file_search, 'replacecode' => $file_replace, 'searchcount' => $searchcount );
	
					}
				}
				
			}
		}
		
		if (!$id) {
			
			$row = $db->super_query( "SELECT id FROM " . PREFIX . "_plugins WHERE name='{$name}'" );
			
			if( $row['id'] ) {
				echo 'پلاگینی با این نام قبلا نصب شده است.';
			}
			
			$db->query( "INSERT INTO " . PREFIX . "_plugins (name, description, icon, version, dleversion, versioncompare, active, mysqlinstall, mysqlupgrade, mysqlenable, mysqldisable, mysqldelete, filedelete, filelist, upgradeurl) values ('{$name}', '{$description}','{$icon}','{$version}','{$dleversion}','{$versioncompare}', '1', '{$mysqlinstall}', '{$mysqlupgrade}','{$mysqlenable}','{$mysqldisable}','{$mysqldelete}','{$filedelete}','{$file_list}', '{$upgradeurl}')" );
			$id = $_SESSION['upload_plugins']['id'] = $db->insert_id();
			$db->query( "INSERT INTO " . USERPREFIX . "_admin_logs (name, date, ip, action, extras) values ('".$db->safesql($member_id['name'])."', '{$_TIME}', '{$_IP}', '116', '{$name}')" );
	
			execute_query($id, $_POST['mysqlinstall'] );
			execute_query($id, $_POST['mysqlenable'] );
			
		} else {
			
			$row = $db->super_query( "SELECT id FROM " . PREFIX . "_plugins WHERE id='{$id}'" );
			
			if (!$row['id']) echo "ID not valid", "ID not valid";
			
			$row = $db->super_query( "SELECT id FROM " . PREFIX . "_plugins WHERE name='{$name}'" );
		
			if( $row['id'] AND $row['id'] != $id ) {
				echo 'پلاگینی با این نام قبلا نصب شده است.';
			}
		
			$db->query( "DELETE FROM " . PREFIX . "_plugins_logs WHERE plugin_id = '{$id}'" );
			$db->query( "UPDATE " . PREFIX . "_plugins SET name='{$name}', description='{$description}', icon='{$icon}', version='{$version}', dleversion='{$dleversion}', versioncompare='{$versioncompare}', mysqlinstall='{$mysqlinstall}', mysqlupgrade='{$mysqlupgrade}', mysqlenable='{$mysqlenable}', mysqldisable='{$mysqldisable}', mysqldelete='{$mysqldelete}', filedelete='{$filedelete}', filelist='{$file_list}', upgradeurl='{$upgradeurl}' WHERE id='{$id}'" );
			$db->query( "INSERT INTO " . USERPREFIX . "_admin_logs (name, date, ip, action, extras) values ('".$db->safesql($member_id['name'])."', '{$_TIME}', '{$_IP}', '117', '{$name}')" );
	
			execute_query($id, $_POST['mysqlupgrade'] );
			
		}
		
		$db->query( "DELETE FROM " . PREFIX . "_plugins_files WHERE plugin_id='{$id}'" );
		
		if(count($files)) {
			
			$row = $db->super_query( "SELECT active FROM " . PREFIX . "_plugins WHERE id='{$id}'" );
			
			foreach( $files as $key => $value ) {
				foreach ($value as $value2) {
					$key = $db->safesql($key);
					$value2['action'] = $db->safesql($value2['action']);
					$value2['searchcode'] = $db->safesql($value2['searchcode']);
					$value2['replacecode'] = $db->safesql($value2['replacecode']);
					$value2['searchcount'] = intval($value2['searchcount']);
					
					$db->query( "INSERT INTO " . PREFIX . "_plugins_files (plugin_id, file, action, searchcode, replacecode, searchcount, active) values ('{$id}', '{$key}', '{$value2['action']}', '{$value2['searchcode']}', '{$value2['replacecode']}', '{$value2['searchcount']}', '{$row['active']}')" );
				}
	
			}
	
		}
		
	}

}

?>