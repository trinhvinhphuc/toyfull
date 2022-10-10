<?php

if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('Wc_Cancel_Request_Received')):

	class Wc_Cancel_Request_Received extends WC_Email {

		public function __construct() {
			$this->id             = 'wc_cancel_request_received';
			$this->title          = __('Cancellation Request Received','wc-cancel-order');
			$this->description    = __('Order cancellation request emails are sent to chosen recipient(s) when a new cancellation request is received.','wc-cancel-order');
			$this->template_base  = WC_CANCEL_DIR.'/templates/';
			$this->template_html  = 'emails/admin-request-received.php';
			$this->template_plain = 'emails/plain/admin-request-received.php';
			$this->placeholders   = array(
				'{order_date}'   => '',
				'{order_number}' => '',
			);

			// Call parent constructor.
			parent::__construct();

			// Other settings.
			$this->recipient = $this->get_option( 'recipient', get_option( 'admin_email' ) );
		}

		public function get_default_subject(){
			return __('[{site_title}]: Order (#{order_number}) cancellation request received.','wc-cancel-order');
		}

		public function get_default_heading(){
			return __('Order cancellation request received','wc-cancel-order');
		}

		public function trigger($order_id, $order = false){
			$this->setup_locale();

			if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
				$order = wc_get_order( $order_id );
			}

			if ( is_a( $order, 'WC_Order' ) ) {
				$this->object                         = $order;
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
					'sent_to_admin'      => true,
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

		public function init_form_fields() {
			/* translators: %s: list of placeholders */
			$placeholder_text  = sprintf(__('Available placeholders: %s','wc-cancel-order'), '<code>' . implode( '</code>, <code>', array_keys( $this->placeholders ) ) . '</code>' );
			$this->form_fields = array(
				'enabled'            => array(
					'title'   => __('Enable/Disable','wc-cancel-order'),
					'type'    => 'checkbox',
					'label'   => __('Enable this email notification','wc-cancel-order'),
					'default' => 'yes',
				),
				'recipient'          => array(
					'title'       => __('Recipient(s)','wc-cancel-order'),
					'type'        => 'text',
					'description' => sprintf(__('Enter recipients (comma separated) for this email. Defaults to %s.','wc-cancel-order'), '<code>' . esc_attr( get_option( 'admin_email' ) ) . '</code>' ),
					'placeholder' => '',
					'default'     => '',
					'desc_tip'    => true,
				),
				'subject'            => array(
					'title'       => __('Subject','wc-cancel-order'),
					'type'        => 'text',
					'desc_tip'    => true,
					'description' => $placeholder_text,
					'placeholder' => $this->get_default_subject(),
					'default'     => '',
				),
				'heading'            => array(
					'title'       => __('Email heading','wc-cancel-order'),
					'type'        => 'text',
					'desc_tip'    => true,
					'description' => $placeholder_text,
					'placeholder' => $this->get_default_heading(),
					'default'     => '',
				),
				'email_type'         => array(
					'title'       => __('Email type','wc-cancel-order'),
					'type'        => 'select',
					'description' => __('Choose which format of email to send.','wc-cancel-order'),
					'default'     => 'html',
					'class'       => 'email_type wc-enhanced-select',
					'options'     => $this->get_email_type_options(),
					'desc_tip'    => true,
				),
			);
		}
	}

endif;

return new Wc_Cancel_Request_Received();
