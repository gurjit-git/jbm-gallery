<?php
defined( 'ABSPATH' ) or die( 'Direct access not allowed!' );
class jbm_gallery_shortcode_class{
	
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
		//add_action('init', array($this,'register_jbm_gallery_shortcodes')); //shortcodes
		add_shortcode('jbm_gallery_shortcode', array($this, 'jbm_gallery_shortcode'));
	}
	
	public function jbm_gallery_shortcode($atts){
	
		$atts = shortcode_atts( array(
			'id' => '',
		), $atts, 'jbm_gallery_shortcode' );
			
		$entries = get_post_meta( $atts['id'], 'jbm_group_gallery', true );
		
		$images = get_post_meta( $atts['id'], 'jbm_group_gallery_vimg_list', true );
		
		$gallery_html = '<div id="jmb_gallery">';
		foreach (  (array) $images as $attachment_id => $attachment_url  ) {
			
			$video_id = get_post_meta($attachment_id, 'jmb_video_id', true);
			
			if(empty($video_id)){
				$gallery_html .= '
					<a href="'.$attachment_url.'">
						<img alt="" src="'.$attachment_url.'">
					</a>';
			}
			else{
				if(strlen($video_id) == 11 && !is_numeric($video_id)){
					$gallery_html .= '<a class="video-icon" href="//www.youtube.com/watch?v='.$video_id.'" data-poster="//i.ytimg.com/vi/'.$video_id.'/mqdefault.jpg">
						<img class="video" src="//i.ytimg.com/vi/'.$video_id.'/mqdefault.jpg" >
					</a>';
				}else{
					$gallery_html .= '<a class="video-icon" href="//vimeo.com/'.$video_id.'" data-poster="//i.vimeocdn.com/video/'.$video_id.'_768.jpg">
						<img class="video" src="//i.vimeocdn.com/video/'.$video_id.'_768.jpg" >
					</a>';
				}
			}
			
		}
		$gallery_html .= '</div>';

		return $gallery_html;
	}
}
jbm_gallery_shortcode_class::getInstance();
?>