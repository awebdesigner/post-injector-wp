<?php
/*
* Plugin name: Inject post
* Plugin URL: https://wordpress.org
* Description: Insert custom content in a post. Suitable for adding Ads to posts. The extra
* content can be put at more one position in the particular post. Plugin initiated at WordCamp * Kampala 2017
* version: 0.0.3
* Author: David M. Wampamba
*/
defined( 'ABSPATH' ) or wp_die( 'Cheatin\' Uh?' );

class wpip_inject_post {

	private $wpip_attach_content ='';
	private $wpip_positions = [];

	public function __construct( $attach_content, $paragraph_positions = [] ) {
		$this->wpip_attach_content = $attach_content;
		$this->wpip_positions = $paragraph_positions;
		$this->wpip_init();
	}

	private function wpip_init() {
		add_filter( 'the_content', function( $wp_content ) {
			return ( is_single() && !is_admin() ) ? $this->wpip_inject_content( $wp_content ) : '';
		});
	}

	private function wpip_inject_content( $content ) {
		$paragraphs = explode( '</p>', $content );
		foreach( $this->wpip_positions as $position )
			( count( $paragraphs ) > $position - 1 ) ? $paragraphs[ $position - 1 ] .= $this->wpip_attach_content : null;

		return implode( '', $paragraphs );
	}

}

if( class_exists( 'wpip_inject_post' ) )
	new wpip_inject_post( '<p>A foreign paragraph</p>', [2,5,8] );
