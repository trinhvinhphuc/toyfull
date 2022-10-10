<?php
if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('WC_Cancel_Order_Details',false)){
	class WC_Cancel_Order_Details{

		public $slug ='';
		public $settings ='';

		function __construct($key,$settings){
			$this->key = $key;
			$this->settings = $settings;
			add_action('woocommerce_after_order_details',array($this,'guest_cancel_link'));
		}

		function guest_cancel_link($order){
			$actions = WC_Cancel_Order_Init()->get_cancel_action($order);
			if(is_array($actions) && !empty($actions)){
				echo '<p><h4>'.__('Want to cancel this order?','wc-cancel-order').'</h4></p>';
				echo '<p>';
				WC_Cancel_Order_Init()->add_cancel_btn($actions);
				echo '</p>';
			}
		}

		function get_order_id($key){
			global $wpdb;
			$id = $wpdb->get_var("SELECT m.post_id as order_id FROM ".$wpdb->postmeta." as m,".$wpdb->posts." as p WHERE p.ID=m.post_id AND m.meta_key='_wc_cancel_key' AND m.meta_value='".$key."' AND p.post_type='shop_order'");
			return $id;
		}

		public function order_details(){
			$order_id = $this->get_order_id($this->key);
			if($order_id && isset($this->settings['guest-cancel']) && $this->settings['guest-cancel']){
				$order = wc_get_order($order_id);
				if(is_a($order,'WC_Order')){
					$status       = new stdClass();
					$status->name = wc_get_order_status_name( $order->get_status() );
					wc_get_template(
						'myaccount/view-order.php',
						array(
							'status'   => $status,
							'order'    => $order,
							'order_id' => $order->get_id(),
						)
					);
				}
				else
				{
					echo '<div class="woocommerce-error">'.esc_html__('Invalid order.','woocommerce').'<a href="'.esc_url(wc_get_page_permalink('myaccount')).'" class="wc-forward">'.esc_html__('My account','wc-cancel-order').'</a></div>';
				}

			}
			else
			{
				wc_print_notice( __( 'Sorry, this order is invalid and no details found.','wc-cancel-order'),'error');
			}
		}
	}
}