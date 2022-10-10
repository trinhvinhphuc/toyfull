<?php

if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('WC_Cancel_Guest',false)){
	class WC_Cancel_Guest{

		public $slug ='';
		public $args = array();

		function __construct($args){
			$this->args = $args;
			$this->slug = $args['slug'];
		}

		public function guest_page($posts){
			global $wp,$wp_query;
			$page_slug = $this->slug;
			if(strtolower($wp->request) == $page_slug || $wp->query_vars['page_id'] == $page_slug){

				$post = new stdClass;
				$post->post_author = 1;
				$post->post_name = $page_slug;
				$post->guid = get_home_url(get_current_blog_id(),'/'.$page_slug);
				$post->post_title = isset($this->args['post_title']) ? $this->args['post_title']  : __('Order Details','wc-cancel-order');
				$post->post_content = isset($this->args['post content']) ? $this->args['post content']  : '[wc_cancel_order_details]';
				$post->ID = isset($posts[0]->ID) ? $posts[0]->ID :  -1;
				$post->post_type = 'wc-cancel-order-page';
				$post->post_status = 'static';
				$post->comment_status = 'closed';
				$post->ping_status = 'closed';
				$post->comment_count = 0;
				$post->post_date = current_time('mysql');
				$post->post_date_gmt = current_time('mysql',1);

				$post = (object) array_merge((array)$post,(array)$this->args);
				$posts = NULL;
				$posts[] = $post;

				$wp->query = array();
				$wp_query->found_posts = 1;
				$wp_query->post_count = 1;
				$wp_query->comment_count = 0;

				$wp_query->is_page = true;
				$wp_query->is_singular = false;
				$wp_query->is_home = false;
				$wp_query->is_archive = false;
				$wp_query->is_category = false;

				$wp_query->post = $post;
				$wp_query->posts = array($post);
				$wp_query->queried_object = $post;
				$wp_query->queried_object_id = $post->ID;
				$wp_query->post_count = 1;
				//$wp_query->current_post = $post->ID;

				$wp_query->query_vars["error"]="";
				$wp_query->is_404 = false;

			}
			return $posts;
		}
	}
}

