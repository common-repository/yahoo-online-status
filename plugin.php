<?php
/*
Plugin Name: Yahoo Online Status
Plugin URI: http://mr.hokya.com/yahoo-online-status/
Description: Show YM Online status of all of your members on your widget to show whether they are currently online with Yahoo Messenger or not.
Version: 2.01
Author: Julian Widya Perdana
Author URI: http://mr.hokya.com/
*/

if (!get_option("yos_title")) update_option("yos_title","Yahoo Online Status");

function yos_widget ($args) {
	extract($args);
	global $wpdb;
	$title = get_option("yos_title");
	echo $before_widget.$before_title.$title.$after_title;
	echo "<ul>";
	$results = $wpdb->get_results("select * from $wpdb->users");
	foreach ($results as $results) {
		$email = strtolower($results->user_email);
		if(strpos($email,"yahoo")) {
			$ymid = substr($email,0,strpos($email,"@"));
			echo "<li><a href='ymsgr:sendIM?$ymid' alt='My Yahoo! Messenger'><img src='http://opi.yahoo.com/online?u=$ymid&m=g&t=1' border='0'></a></li>";
		}
	}
	echo "</ul>";
	echo $after_widget;
}

function yos_control() {
	if ($_POST["yos_submit"]) update_option("yos_title",$_POST["title"]);
	$title = get_option("yos_title");
	echo "Title : <input name='title' value='$title'/>";
	echo "<input name='yos_submit' value=1 type='hidden' />";
	echo "<p><a target='_blank' href='http://mr.hokya.com/yahoo-online-status/'>What's this?</a></p>";
}

function yos_register() {
	register_sidebar_widget("Yahoo Online Status","yos_widget");
	register_widget_control("Yahoo Online Status","yos_control");
}

add_action('plugins_loaded','yos_register');

?>