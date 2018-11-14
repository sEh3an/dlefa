<?php

if( !defined( 'DATALIFEENGINE' ) ) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../../' );
	die( "Hacking attempt!" );
}

$config['version_id'] = "13.1";
$config['allow_admin_social'] = "0";

$tableSchema = array();

$tableSchema[] = "ALTER TABLE `" . PREFIX . "_category` CHANGE `descr` `descr` VARCHAR(300) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_plugins_files` ADD `searchcount` SMALLINT(6) NOT NULL DEFAULT '0'";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_plugins` ADD `filedelete` TINYINT(1) NOT NULL DEFAULT '0', ADD `filelist` TEXT NOT NULL, ADD `upgradeurl` VARCHAR(255) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_flood` CHANGE `ip` `ip` VARCHAR(46) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_logs` CHANGE `ip` `ip` VARCHAR(46) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_vote_result` CHANGE `ip` `ip` VARCHAR(46) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_banners_logs` CHANGE `ip` `ip` VARCHAR(46) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_banned` CHANGE `ip` `ip` VARCHAR(46) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_login_log` CHANGE `ip` `ip` VARCHAR(46) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_admin_logs` CHANGE `ip` `ip` VARCHAR(46) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_read_log` CHANGE `ip` `ip` VARCHAR(46) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_spam_log` CHANGE `ip` `ip` VARCHAR(46) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_comment_rating_log` CHANGE `ip` `ip` VARCHAR(46) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_users` ADD `cat_add` VARCHAR(500) NOT NULL DEFAULT '', ADD `cat_allow_addnews` VARCHAR(500) NOT NULL DEFAULT '', CHANGE `logged_ip` `logged_ip` VARCHAR(46) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_comments` CHANGE `ip` `ip` VARCHAR(46) NOT NULL DEFAULT ''";

$tableSchema[] = "INSERT INTO " . PREFIX . "_plugins (name, description, icon, version, dleversion, versioncompare, active, mysqlinstall, mysqlupgrade, mysqlenable, mysqldisable, mysqldelete, filedelete, filelist, upgradeurl) VALUES ('Add Persian Language and CSS', 'اضافه کردن فایل های css نسخه فارسی و راست چین سازی', '', '1.0', '13.0', '>=', 1, '', '', '', '', '', 1, '', 'https://dlefa.ir/updates/dlefa_css.xml')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_plugins_files (plugin_id, file, action, searchcode, replacecode, active, searchcount) SELECT p.id AS plugin_id, 'engine/inc/include/functions.inc.php' AS file, 'replace' AS `action`, '		\$default_array = array (\\n			\'engine/skins/javascripts/application.js\',\\n		);' AS searchcode, '		if (isset( \$_COOKIE[\'selected_language\'] )) {\\n			\\n			if (\$_COOKIE[\'selected_language\'] == \'Farsi\'){\\n				\$default_array = array (\\n					\'engine/skins/javascripts/application_fa.js\',\\n				);\\n			}else{	\\n				\$default_array = array (\\n					\'engine/skins/javascripts/application.js\',\\n				);\\n			}\\n			\\n			\\n		}else{\\n			\\n			if (\$config[\'langs\'] == \'Farsi\'){\\n				\$default_array = array (\\n					\'engine/skins/javascripts/application_fa.js\',\\n				);\\n			}else{	\\n				\$default_array = array (\\n					\'engine/skins/javascripts/application.js\',\\n				);\\n			}\\n			\\n		}' AS replacecode, 1 AS `active`, 0 AS searchcount FROM " . PREFIX . "_plugins p WHERE p.name = 'Add Persian Language and CSS' LIMIT 1";
$tableSchema[] = "INSERT INTO " . PREFIX . "_plugins_files (plugin_id, file, action, searchcode, replacecode, active, searchcount) SELECT p.id AS plugin_id, 'engine/inc/include/functions.inc.php' AS file, 'replace' AS `action`, 'function build_css(\$css) {\\n	global \$config;\\n\\n	\$default_array = array (\\n		\'engine/skins/fonts/fontawesome/styles.min.css\',\\n		\'engine/skins/stylesheets/application.css\'\\n	);' AS searchcode, 'function build_css(\$css) {\\n	global \$config, \$db;\\n\\n	if (isset( \$_COOKIE[\'selected_language\'] )) {\\n		\\n		if (\$_COOKIE[\'selected_language\'] == \'Farsi\'){\\n			\$default_array = array (\\n				\'engine/skins/fonts/fontawesome/styles.min.css\',\\n				\'engine/skins/stylesheets/application_fa.css\'\\n			);\\n          	\$row = \$db->super_query( \"SELECT id FROM \" . PREFIX . \"_plugins WHERE name=\'Persian DataLife Engine\'\" );\\n			\$db->query( \"UPDATE \" . PREFIX . \"_plugins SET active=\'1\' WHERE id=\'{\$row[\'id\']}\'\" );\\n          	\$db->query( \"UPDATE \" . PREFIX . \"_plugins_files SET active=\'1\' WHERE plugin_id=\'{\$row[\'id\']}\'\" );          	\\n        }else{	\\n			\$default_array = array (\\n				\'engine/skins/fonts/fontawesome/styles.min.css\',\\n				\'engine/skins/stylesheets/application.css\'\\n			);\\n          	\$row = \$db->super_query( \"SELECT id FROM \" . PREFIX . \"_plugins WHERE name=\'Persian DataLife Engine\'\" );\\n			\$db->query( \"UPDATE \" . PREFIX . \"_plugins SET active=\'0\' WHERE id=\'{\$row[\'id\']}\'\" );\\n          	\$db->query( \"UPDATE \" . PREFIX . \"_plugins_files SET active=\'0\' WHERE plugin_id=\'{\$row[\'id\']}\'\" );          	\\n        }		\\n	}else{	\\n		if (\$config[\'langs\'] == \'Farsi\'){\\n			\$default_array = array (\\n				\'engine/skins/fonts/fontawesome/styles.min.css\',\\n				\'engine/skins/stylesheets/application_fa.css\'\\n			);\\n          	\$row = \$db->super_query( \"SELECT id FROM \" . PREFIX . \"_plugins WHERE name=\'Persian DataLife Engine\'\" );\\n			\$db->query( \"UPDATE \" . PREFIX . \"_plugins SET active=\'1\' WHERE id=\'{\$row[\'id\']}\'\" );\\n          	\$db->query( \"UPDATE \" . PREFIX . \"_plugins_files SET active=\'1\' WHERE plugin_id=\'{\$row[\'id\']}\'\" );          	\\n		}else{	\\n			\$default_array = array (\\n				\'engine/skins/fonts/fontawesome/styles.min.css\',\\n				\'engine/skins/stylesheets/application.css\'\\n			);\\n          	\$row = \$db->super_query( \"SELECT id FROM \" . PREFIX . \"_plugins WHERE name=\'Persian DataLife Engine\'\" );\\n			\$db->query( \"UPDATE \" . PREFIX . \"_plugins SET active=\'0\' WHERE id=\'{\$row[\'id\']}\'\" );\\n          	\$db->query( \"UPDATE \" . PREFIX . \"_plugins_files SET active=\'0\' WHERE plugin_id=\'{\$row[\'id\']}\'\" );          	\\n        }		\\n	}' AS replacecode, 1 AS `active`, 0 AS searchcount FROM " . PREFIX . "_plugins p WHERE p.name = 'Add Persian Language and CSS' LIMIT 1";
$tableSchema[] = "INSERT INTO " . PREFIX . "_plugins_files (plugin_id, file, action, searchcode, replacecode, active, searchcount) SELECT p.id AS plugin_id, 'engine/classes/antivirus.class.php' AS file, 'after' AS `action`, 'var \$good_files       = array(' AS searchcode, '\"./engine/classes/jdate.class.php\",\\n\"./engine/ajax/calendar_fa.php\",\\n\"./engine/ajax/updates_fa.php\",\\n\"./engine/modules/calendar_fa.php\",' AS replacecode, 1 AS `active`, 0 AS searchcount FROM " . PREFIX . "_plugins p WHERE p.name = 'Add Persian Language and CSS' LIMIT 1";

foreach($tableSchema as $table) {
	$db->query ($table, false);
}

if( file_exists( ENGINE_DIR . "/inc/upgrade/persian-datalife-engine.xml") ) {
	
	include_once (DLEPlugins::Check(ENGINE_DIR . '/inc/upgrade/plugins.php'));
	$dlefapersian = ENGINE_DIR . "/inc/upgrade/persian-datalife-engine.xml";
	$plugin_file = trim( @file_get_contents($dlefapersian) );
	install_xml_plugin($plugin_file);
	clear_all_caches();
	@unlink(ENGINE_DIR . '/inc/upgrade/persian-datalife-engine.xml');	
	@unlink(ENGINE_DIR . '/inc/upgrade/plugins.php');

}

$handler = fopen(ENGINE_DIR.'/data/config.php', "w");
fwrite($handler, "<?PHP \n\n//System Configurations\n\n\$config = array (\n\n");
foreach($config as $name => $value) {
	fwrite($handler, "'{$name}' => \"{$value}\",\n\n");
}
fwrite($handler, ");\n\n?>");
fclose($handler);

?>