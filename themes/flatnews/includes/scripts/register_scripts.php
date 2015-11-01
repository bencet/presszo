<?php
/*
REGISTERED SCRIPTS: 
http://codex.wordpress.org/Function_Reference/wp_enqueue_script
http://codex.wordpress.org/Function_Reference/wp_register_script
*/

function register_scripts_styles() {
	global $wp_styles;
	
	// JAVASCRIPT LOAD
	//################
	// load jquery library
	wp_enqueue_script('jquery');
	
	// Adds JavaScript to pages with the comment form to support sites with
	// threaded comments (when in use).
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// load ticker, slider plugin for break news section
	if ((get_theme_mod('break_box') == true) || is_home()) {
		wp_enqueue_script( 'ticker-js', THEME_URL_SCRIPTS . 'ticker/ticker.js', array('jquery'), THEME_VERSION );
	}
	if (is_home()) {	
		wp_enqueue_script( 'slider-js', THEME_URL_SCRIPTS . 'slider/slider.js', array('jquery'), THEME_VERSION );
	}
	
	wp_enqueue_script( 'global-js', THEME_URL_SCRIPTS_COMMONS . 'global.js', array('jquery'), THEME_VERSION );
	wp_enqueue_script( 'presszo_scripts-js', THEME_URL_SCRIPTS_COMMONS . 'presszo_scripts.js', array('jquery'), THEME_VERSION );
	wp_enqueue_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array(), '3', true );
	wp_enqueue_script( 'google-map-init',  THEME_URL_SCRIPTS . '/googlemap/maps.js', array('google-map', 'jquery'), '0.1', true );
	
	// addthis tool
	if (is_singular()) {
		wp_enqueue_script('addthis-js', '//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-51be7bd11b8b90a4');
	}
	
	// CSS LOAD
	//#########
	// Loads our main stylesheet.
	wp_enqueue_style( 'theme-style', get_stylesheet_uri(), NULL, THEME_VERSION);
	
	if (get_theme_mod('rtl') == true) {
		wp_enqueue_style( 'rtl-style', THEME_URL_SCRIPTS_COMMONS.'rtl.css', array( 'theme-style' ), THEME_VERSION );
	}

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'ie-style', THEME_URL_SCRIPTS_COMMONS.'ie.css', array( 'theme-style' ), THEME_VERSION );
	$wp_styles->add_data( 'ie-style', 'conditional', 'lt IE 9' );
	
	wp_enqueue_style( 'ie8-style', THEME_URL_SCRIPTS_COMMONS.'ie8.css', array( 'theme-style' ), THEME_VERSION );
	$wp_styles->add_data( 'ie8-style', 'conditional', 'IE 8' );
}
add_action('wp_enqueue_scripts', 'register_scripts_styles');

?>