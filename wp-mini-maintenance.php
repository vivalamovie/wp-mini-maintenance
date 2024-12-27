<?php
/*
Plugin Name: WP mini maintenance
Plugin URI: https://github.com/vivalamovie/wp-mini-maintenance
Description: The smallest WordPress maintenance plugin
Author: Christian Pier
Version: 1.0
Author URI: http://vlmsrv.com
License: https://creativecommons.org/publicdomain/zero/1.0/
*/

if(!function_exists('maintenance_head')):
function maintenance_head($status_header, $header, $text, $protocol) {
	if ( !is_user_logged_in() ) {
		return "$protocol 503 Service Unavailable";
	}
}
endif;

if(!function_exists('maintenance_content')):
function maintenance_content() {
	if ( !is_user_logged_in() ) {
		$page = <<<EOT

			<!DOCTYPE html>
			<html lang="en-US">
			<head>
			<meta charset="UTF-8" />
			
			<title></title>
			<body></body>
			</html>

EOT;
		die($page);
	}
}
endif;

if(!function_exists('maintenance_feed')):
function maintenance_feed() {
	if ( !is_user_logged_in() ) {
		die('<?xml version="1.0" encoding="UTF-8"?>'.
			'<status>Service unavailable</status>');
	}
}
endif;

if(!function_exists('add_feed_actions')):
function add_feed_actions() {
	$feeds = array ('rdf', 'rss', 'rss2', 'atom');
	foreach ($feeds as $feed) {
		add_action('do_feed_'.$feed, 'maintenance_feed', 1, 1);
	}
}
endif;

if (function_exists('add_filter') ):
add_filter('status_header', 'maintenance_head', 10, 4);
add_action('get_header', 'maintenance_content');
add_feed_actions();
else:
die('');
endif;
?>
