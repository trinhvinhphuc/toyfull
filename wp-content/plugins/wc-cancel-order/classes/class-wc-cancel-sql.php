<?php
if(!defined('ABSPATH')){
    exit;
}
if(!class_exists('Wc_Cancel_Sql')){

    class Wc_Cancel_Sql{

	    function __construct(){

	    }

        function create(){
	        global $wpdb;
	        include_once ABSPATH . 'wp-admin/includes/upgrade.php';
	        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "wc_cancel_orders(
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `order_id` bigint(20) NOT NULL,
		  `user_id` bigint(20) NOT NULL,
		  `is_approved` TINYINT( 2 ) NOT NULL DEFAULT  '0',
		  `cancel_request_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `cancel_date` TIMESTAMP NOT NULL,
		   PRIMARY KEY (`id`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	        dbDelta($sql);
        }
    }
}