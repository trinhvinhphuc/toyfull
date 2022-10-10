<?php

if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('Wc_Cancel_Request_Approved')):

	class Wc_Cancel_Request_Approved extends WC_Email {

		public function __construct() {
			$this->id             = 'wc_cancel_request_approved';
			$this->customer_email = true;
			$this->title          = __('Cancellation Request Approved','wc-cancel-order');
			$this->description    = __('Order cancellation request approved email is sent to customer when cancellation request is approved by store manager.','wc-cancel-order');
			$this->template_base  = WC_CANCEL_DIR.'/templates/';
			$this->template_html  = 'emails/customer-request-approved.php';
			$this->template_plain = 'emails/plain/customer-request-approved.php';
			$this->placeholders   = array(
				'{order_date}'   => '',
				'{order_number}' => '',
			);

			// Call parent constructor.
			parent::__construct();
		}

		public function get_default_subject() {
			return __('[{site_title}]: Order (#{order_number}) cancellation request approved.','wc-cancel-order');
		}

		public function get_default_heading() {
			return __('Order cancellation request approved','wc-cancel-order');
		}

		public function trigger($order_id, $order = false){
			$this->setup_locale();

			if($order_id && !is_a($order,'WC_Order')){
				$order = wc_get_order( $order_id );
			}

			if(is_a($order,'WC_Order')){
				$this->object                         = $order;
				$this->recipient                      = $this->object->get_billing_email();
				$this->placeholders['{order_date}']   = wc_format_datetime( $this->object->get_date_created() );
				$this->placeholders['{order_number}'] = $this->object->get_order_number();
			}

			if ( $this->is_enabled() && $this->get_recipient() ) {
				$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
			}

			$this->restore_locale();
		}

		public function get_content_html() {
			return wc_get_template_html(
				$this->template_html,
				array(
					'order'              => $this->object,
					'email_heading'      => $this->get_heading(),
					'additional_content' => $this->get_additional_content(),
					'sent_to_admin'      => false,
					'plain_text'         => false,
					'email'              => $this,
				),
				'',
				$this->template_base
			);
		}

		public function get_content_plain() {
			return wc_get_template_html(
				$this->template_plain,
				array(
					'order'              => $this->object,
					'email_heading'      => $this->get_heading(),
					'additional_content' => $this->get_additional_content(),
					'sent_to_admin'      => true,
					'plain_text'         => true,
					'email'              => $this,
				),
				'',
				$this->template_base
			);
		}

	}

endif;

return new Wc_Cancel_Request_Approved();
