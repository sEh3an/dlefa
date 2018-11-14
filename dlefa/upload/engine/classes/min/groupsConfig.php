<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 **/

return array(
    // custom source example
    'dlefa' => array(
     	$min_documentRoot . '/engine/skins/javascripts/application_fa.js', 
    ),

    'general' => array(
     	$min_documentRoot . '/engine/classes/js/jquery.js',
    ),

    'admin' => array(
     	$min_documentRoot . '/engine/skins/javascripts/application.js', 
    ),
);