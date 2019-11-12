<?php
/*
Plugin Name: JBM Gallery
Plugin URI: http://wordpress.org/
Description: This is a responsive Gallery plugin for images and videos.
Author: Gurjit Singh
Version: 0.1.2
Author URI: http://gurjitsingh.com
*/
defined( 'ABSPATH' ) or die( 'Direct access not allowed!' );
define( 'JBM_GALLERY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

if(!class_exists('jbm_gallery')):
	class jbm_gallery{
		
		private static $instance = null;
		
		private function __construct(){
			$this->initializeHooks();
			$this->includeFiles();
		}
		
		public static function getInstance(){
			if(is_null(self::$instance))
				self::$instance = new self();
			return self::$instance;
		}
		
		private static function includeFiles(){
			include(JBM_GALLERY_PLUGIN_PATH. 'inc/gallery-post-type.php');
			include(JBM_GALLERY_PLUGIN_PATH . 'inc/cf-functions.php');
			include(JBM_GALLERY_PLUGIN_PATH . 'inc/gallery-shortcode.php');
		}
		
		private function initializeHooks(){
			
			add_action('wp_enqueue_scripts', array($this,'jbm_gallery_include_css_js')); //public scripts and styles
			//add_action('init', array($this,'register_jbm_gallery_columns'));
			
			add_filter("attachment_fields_to_edit", array($this, 'jmb_image_attachment_add_custom_fields'), null, 2);
			add_filter("attachment_fields_to_save", array($this, 'jbm_image_attachment_save_custom_fields'), null , 2);
			
			add_filter( 'manage_edit-jbm_gallery_columns', array($this, 'jbm_gallery_columns'), null, 1);
			add_action( 'manage_jbm_gallery_posts_custom_column', array($this, 'jbm_gallery_columns_manage'), null, 2);
			
		}
		
		public function jbm_gallery_include_css_js(){
		
			wp_enqueue_style( 'jbm-custom-style', plugins_url('/assets/css/custom.css', __FILE__), false, '1.0.0', 'all');
			wp_enqueue_style( 'jbm-lightgallery-min-style', plugins_url('/assets/css/lightgallery.min.css', __FILE__), false, '1.0.0', 'all');
			wp_enqueue_style( 'jbmjustifiedGallery-min-style', plugins_url('/assets/css/justifiedGallery.css', __FILE__), false, '1.0.0', 'all');
			
			wp_enqueue_script( 'jbm-justifiedGallery-min-script', plugins_url( '/assets/js/jquery.justifiedGallery.min.js' , __FILE__ ), array( 'jquery' ), '1.0.0', true  );
			
			wp_enqueue_script( 'jbm-picturefill-min-script', plugins_url( '/assets/js/lightgallery/picturefill.min.js' , __FILE__ ), array( 'jquery' ), '1.0.0', true  );
			wp_enqueue_script( 'jbm-mousewheel-min-script', plugins_url( '/assets/js/lightgallery/jquery.mousewheel.min.js' , __FILE__ ), array( 'jquery' ), '1.0.0', true  );
			wp_enqueue_script( 'jbm-lightgallery-all-min-script', plugins_url( '/assets/js/lightgallery/lightgallery-all.min.js' , __FILE__ ), array( 'jquery' ), '1.0.0', true  );
			wp_enqueue_script( 'jbm-lg-video-min-script', plugins_url( '/assets/js/lightgallery/lg-video.js' , __FILE__ ), array( 'jquery' ), '1.0.0', true  );
			
			wp_enqueue_script( 'jbm-gallery-custom-script', plugins_url( '/assets/js/custom.js' , __FILE__ ), array( 'jquery' ), '1.0.0', true  );
			
		}
		
		private function jmb_image_attachment_add_custom_fields($form_fields, $post) {
			$form_fields["jmb_video_id"] = array(
				"label" => __("Video Id"),
				"input" => "text",
				"value" => get_post_meta($post->ID, "jmb_video_id", true),
				"helps" => __(""),
			);
			return $form_fields;
		}
		
		private function jbm_image_attachment_save_custom_fields($post, $attachment) {
			if(isset($attachment['jmb_video_id'])) {
				update_post_meta($post['ID'], 'jmb_video_id', $attachment['jmb_video_id']);
			} else {
				delete_post_meta($post['ID'], 'jmb_video_id');
			}
			return $post;
		}
		
		private function jbm_gallery_columns( $columns ) {

			$columns = array(
				'cb' => '&lt;input type="checkbox" />',
				'title' => __( 'Title' ),
				'jbm_gallery_shortcode' => __( 'Shortcode' ),
				'author' => __( 'Author' ),
				'date' => __( 'Date' )
			);

			return $columns;
		}

		private function jbm_gallery_columns_manage( $column, $post_id ) {
			global $post;

			switch( $column ) {

				/* If displaying the 'duration' column. */
				case 'jbm_gallery_shortcode' :

					printf( __( '%s' ), '[jbm_gallery_shortcode id="'.$post_id.'"]' );

				break;

				/* Just break out of the switch statement for everything else. */
				default :
					break;
			}
		}
		
	}
endif;
jbm_gallery::getInstance();