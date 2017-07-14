<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
$input = @file_get_contents("php://input");

$event_json = json_decode($input, true);

	$sub_id = $event_json['data']['object']['id'];
	$price = $event_json['items']['data']['plan']['amount'];
	global $wpdb;
	$user_id = $wpdb->get_var("SELECT `user_id` FROM `wp_mixpro_meels` WHERE `sub_id`='".$sub_id."'");

	$order_id = $wpdb->get_var("SELECT `post_id` FROM `wp_postmeta` WHERE `meta_key`='_customer_user' AND `meta_value`='".$user_id."'");
	$user_email = $wpdb->get_var("SELECT `user_email` FROM `wp_users` WHERE `ID`='".$user_id."'");
	$date = date('Y-m-d H:i:s', time());
	$gmdate = gmdate('Y-m-d H:i:s', time());
	$wpdb->update('wp_posts', array('post_date'=>$date, 'post_status'=>'wc-processing'), array('ID'=>$order_id));	
	if($wpdb->insert('wp_comments', array('comment_post_ID'=>$order_id, 'comment_author'=>'WooCommerce', 'comment_date'=>$date, 'comment_date_gmt'=>$gmdate, 'comment_author_email'=>$user_email, 'comment_content'=>'subscription is renewed at'.$price, 'comment_approved'=>1, 'comment_agent'=>'WooCommerce', 'comment_type'=>'order_note'))){
		echo 'ok';
	}
	else {
		echo 'false';
	}
