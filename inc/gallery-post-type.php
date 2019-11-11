<?php
defined( 'ABSPATH' ) or die( 'Direct access not allowed!' );
if(!class_exists('jmb_gallery_custom_post_type_class')):
class jmb_gallery_custom_post_type_class{

	private static $instance = null;
	
	private function __construct(){
	 
		$this->initializeHooks();
		
	}
	
	public static function getInstance(){
		if(is_null(self::$instance))
			self::$instance = new self();
		return self::$instance;
	}
	
	private function initializeHooks(){
		
		/* Hook into the 'init' action so that the function
		* Containing our post type registration is not 
		* unnecessarily executed. 
		*/
		add_action( 'init', array($this, 'jmb_gallery_custom_post_type') );
		
		register_activation_hook(__FILE__, array($this,'plugin_activate')); //activate hook
		register_deactivation_hook(__FILE__, array($this,'plugin_deactivate')); //deactivate hook
	}
	
	public function jmb_gallery_custom_post_type() {
 
	// Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'Gallery', 'Post Type General Name', 'twentythirteen' ),
			'singular_name'       => _x( 'Gallery', 'Post Type Singular Name', 'twentythirteen' ),
			'menu_name'           => __( 'Galleries', 'twentythirteen' ),
			//'parent_item_colon'   => __( 'Parent Movie', 'twentythirteen' ),
			'all_items'           => __( 'All Galleries', 'twentythirteen' ),
			//'view_item'           => __( 'View Carousels', 'twentythirteen' ),
			'add_new_item'        => __( 'Add New Gallery', 'twentythirteen' ),
			'add_new'             => __( 'Add New', 'twentythirteen' ),
			'edit_item'           => __( 'Edit Gallery', 'twentythirteen' ),
			'update_item'         => __( 'Update Gallery', 'twentythirteen' ),
			'search_items'        => __( 'Search Gallery', 'twentythirteen' ),
			'not_found'           => __( 'Not Found', 'twentythirteen' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
		);
		 
	// Set other options for Custom Post Type
		 
		$args = array(
			'label'               => __( 'jbm-gallery', 'twentythirteen' ),
			'description'         => __( 'Galleries', 'twentythirteen' ),
			'labels'              => $labels,
			// Features this CPT supports in Post Editor
			'supports'            => array( 'title', 'author','revisions'),
			// You can associate this CPT with a taxonomy or custom taxonomy. 
		   // 'taxonomies'          => array( 'genres' ),
			/* A hierarchical CPT is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/ 
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_icon'           => 'dashicons-images-alt2',
			'name_admin_bar'      => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		);
		 
		// Registering your Custom Post Type
		register_post_type( 'jbm_gallery', $args );
	 
	}
	
	private function plugin_activate(){  
		//call our custom content type function
		$this->jmb_gallery_custom_post_type();
		//flush permalinks
		flush_rewrite_rules();
	}
	
	private function plugin_deactivate(){
		//flush permalinks
		flush_rewrite_rules();
	}
	
	
}
endif;
jmb_gallery_custom_post_type_class::getInstance();
?>