<?php
/*
LINKS:
http://wp.tutsplus.com/tutorials/theme-development/digging-into-the-theme-customizer-overview/

https://codex.wordpress.org/Theme_Customization_API

*/
get_template_part(THEME_R_CUSTOMIZE.'class_customize');



global $social_name_array;	
$social_name_array = array(	
	'facebook', 	'pinterest', 	'twitter', 		'google-plus', 	'feed', 
	'vimeo', 		'evernote', 	'dribbble', 	'tumblr', 		'behance', 
	'stumbleupon', 	/*'dropbox',*/	'soundcloud', 	/*'picasa',*/	'lastfm', 
	/*'forrst',*/	'flickr', 		'deviantart', 	'linkedin', 	'blogger', 
	'instagram', 	/*'yahoo',*/	'youtube', 		'grooveshark', 	'digg',
	/*'skype',*/ 		/*'sharethis',*//*'wordpress',*/ 					
	
													'quora'
	);
	
function register_customizations_social_links( $wp_customize, $social_names ) {

		// social link list group
	$wp_customize->add_section( 'social_links' , array(
		'title'      	=> __( 'Social Links', THEME_DOMAIN ),
		'priority'		=> 40,
	) );
	
	// add settings and controls
	$priority = 1;
	foreach ($social_names as $social_name) {
		$wp_customize->add_setting( 'social_'.$social_name.'_link' , array(
			'default'     => '',
			/*'transport'   => 'postMessage',*/
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ctrl_social_'.$social_name.'_link', array(
			'label'        	=> ucfirst($social_name) . __( ' Link', THEME_DOMAIN ),
			'section'    	=> 'social_links',
			'settings'   	=> 'social_'.$social_name.'_link',
			'priority'		=> $priority
		) ) );
		$priority++;
	}
}

function register_customizations( $wp_customize ) {

	// DEFAULT GROUPS
	// blog logo
	$wp_customize->add_setting( 'blog_logo' , array(
		'default'     => '',
	) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ctrl_blog_logo', array(
			'label'        => __( 'Blog logo', THEME_DOMAIN ),
			'section'    => 'title_tagline',
			'settings'   => 'blog_logo',
		) ) );
		
	//favicon image
	$wp_customize->add_setting( 'favicon_image' , array(
		'default'     => '',
	) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ctrl_favicon_image', array(
			'label'        => __( 'Favicon Image', THEME_DOMAIN ),
			'section'    => 'title_tagline',
			'settings'   => 'favicon_image',
		) ) );
		
	
	
		
	// GROUP > SETTING > CONTROLS
	$wp_customize->add_section( 'color_font_background' , array(
		'title'      	=> __( 'Color, Fonts, Background', THEME_DOMAIN ),
		'priority'		=>	30,
	) );
		
		
		// main color
		$wp_customize->add_setting( 'main_color' , array(
			'default'     => '#D12F2F',
		) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ctrl_main_color', array(
				'label'        => __( 'Main Color', THEME_DOMAIN ),
				'section'    => 'color_font_background',
				'settings'   => 'main_color',
			) ) );
		
		// background color
		$wp_customize->add_setting( 'background-color' , array(
			'default'     => '#E5E5E5',
		) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ctrl-background-color', array(
				'label'        => __( 'Background Color', THEME_DOMAIN ),
				'section'    => 'color_font_background',
				'settings'   => 'background-color',
			) ) );
			
		
		// background image
		$wp_customize->add_setting( 'background-image' , array(
			'default'     => '',
		) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ctrl-background-image', array(
				'label'        => __( 'Background Image', THEME_DOMAIN ),
				'section'    => 'color_font_background',
				'settings'   => 'background-image',
			) ) );
		
		
		if (class_exists( 'GoogleFontPicker' ) ) :
		// emphasis font
		$wp_customize->add_setting( 'emphasis-font' , array(
			'default'     => 'font-62',
		) );
			$wp_customize->add_control( new GoogleFontPicker( $wp_customize, 'ctrl-emphasis-font', array(
				'label'        => __( 'EMPHASIS Font (for titles)', THEME_DOMAIN ),
				'section'    => 'color_font_background',
				'settings'   => 'emphasis-font',
			) ) );
		
		// body font
		$wp_customize->add_setting( 'body-font' , array(
			'default'     => 'font-0',
		) );
			$wp_customize->add_control( new GoogleFontPicker( $wp_customize, 'ctrl-body-font', array(
				'label'        => __( 'BODY Font (for content)', THEME_DOMAIN ),
				'section'    => 'color_font_background',
				'settings'   => 'body-font',
			) ) );
		endif;//check google font class
			
	
	
	// content settings
	$wp_customize->add_section( 'content_settings' , array(
		'title'      	=> __( 'Content Settings', THEME_DOMAIN ),
		'priority'		=>	50,
	) );
		$wp_customize->add_setting( 'default_thumbnail' , array(
			'default'     => '',
		) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ctrl_default_thumbnail', array(
				'label'        => __( 'Default thumbnail', THEME_DOMAIN ),
				'section'    => 'content_settings',
				'settings'   => 'default_thumbnail',
			) ) );
			
		$wp_customize->add_setting( 'ticker_delay' , array(
			'default'     => '8',
		) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ctrl_ticker_delay', array(
				'label'        => __( 'Ticker Delay (s), larger is slower', THEME_DOMAIN ),
				'section'    => 'content_settings',
				'settings'   => 'ticker_delay',
			) ) );
			
		$wp_customize->add_setting( 'slider_delay' , array(
			'default'     => '3000',
		) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ctrl_slider_delay', array(
				'label'        => __( 'Delay between slide animations (ms)', THEME_DOMAIN ),
				'section'    => 'content_settings',
				'settings'   => 'slider_delay',
			) ) );
		$wp_customize->add_setting( 'slider_speed' , array(
			'default'     => '500',
		) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ctrl_slider_speed', array(
				'label'        => __( 'Speed to animate each slide (ms)', THEME_DOMAIN ),
				'section'    => 'content_settings',
				'settings'   => 'slider_speed',
			) ) );	
		// right to left language
		$wp_customize->add_setting( 'rtl' , array(
			'default'     => '',
		) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ctrl_rtl', array(
				'label'        => __( 'Right To Left Language (RTL)', THEME_DOMAIN ),
				'section'    => 'content_settings',
				'settings'   => 'rtl',
				'type'		=> 'checkbox'
			) ) );
		// show break news
		$wp_customize->add_setting( 'break_box' , array(
			'default'     => '',
		) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ctrl_break_box', array(
				'label'        => __( 'Show Breaknews for all pages', THEME_DOMAIN ),
				'section'    => 'content_settings',
				'settings'   => 'break_box',
				'type'		=> 'checkbox'
			) ) );
		// Hide feature image
		$wp_customize->add_setting( 'hide_feature_image' , array(
			'default'     => '',
		) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ctrl_hide_feature_image', array(
				'label'        => __( 'Hide feature image in post detail', THEME_DOMAIN ),
				'section'    => 'content_settings',
				'settings'   => 'hide_feature_image',
				'type'		=> 'checkbox'
			) ) );
			
		// Hide excerpt
		$wp_customize->add_setting( 'hide_excerpt' , array(
			'default'     => '',
		) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ctrl_hide_excerpt', array(
				'label'        => __( 'Hide excerpt in post detail', THEME_DOMAIN ),
				'section'    => 'content_settings',
				'settings'   => 'hide_excerpt',
				'type'		=> 'checkbox'
			) ) );
	
	
	global $social_name_array;
	register_customizations_social_links($wp_customize, $social_name_array);
}
add_action( 'customize_register', 'register_customizations' );

/*Some built-in functions for display settings on theme */
get_template_part(THEME_R_CUSTOMIZE.'display_customize');


?>