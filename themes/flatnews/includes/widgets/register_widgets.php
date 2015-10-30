<?php 
/*WIDGET AREAS*/
function register_widget_areas() {

	
	register_sidebar( array(
		'name'          => __( '&#10132; Header Ads', THEME_DOMAIN ),
		'id'            => 'header-ads2',
		'description'   => __( 'Add your ads for Header section here, maximum width is 728px', THEME_DOMAIN ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '<div class="clear"></div></aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );
	
	register_sidebar( array(
		'name'          => __( '&#10132; Break Section', THEME_DOMAIN ),
		'id'            => 'break-section',
		'description'   => __( 'You can add news box here for break news or add ads (max width: 728px)', THEME_DOMAIN ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '<div class="clear"></div></aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );
	
	register_sidebar( array(
		'name'          => __( '&#10132; Flexible Home Layout', THEME_DOMAIN ),
		'id'            => 'flexible-home-layout',
		'description'   => __( 'Add news widgets to this area to build your own home layout', THEME_DOMAIN ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s news-box">',
		'after_widget'  => '<div class="clear"></div></aside>',
		'before_title'  => '<h2 class="widget-title title">',
		'after_title'   => '</h2>'
	) );
	
	register_sidebar( array(
		'name'          => __( '&#10132; Post Footer Section', THEME_DOMAIN ),
		'id'            => 'post-footer-section',
		'description'   => __( 'Add widgets to show them under each post content', THEME_DOMAIN ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '<div class="clear"></div></aside>',
		'before_title'  => '<h2 class="widget-title"><span class="active">',
		'after_title'   => '</span></h2>'
	) );
	
	register_sidebar( array(
		'name'          => __( '&#10132; Right Side Top', THEME_DOMAIN ),
		'id'            => 'right-side-top',
		'description'   => __( 'Add widgets to this area to display on top of right side bar', THEME_DOMAIN ) ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '<div class="clear"></div></aside>',
		'before_title'  => '<h2 class="widget-title"><span class="active">',
		'after_title'   => '</span></h2>'
	) );
	
	register_sidebar( array(
		'name'          => __( '&#10132; Right Side TAB', THEME_DOMAIN ),
		'id'            => 'right-side-tab',
		'description'   => __( 'Add widgets to this area to display as TABs on right side bar', THEME_DOMAIN ) ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '<div class="clear"></div></aside>',
		'before_title'  => '<h2 class="widget-title"><span class="active">',
		'after_title'   => '</span></h2>'
	) );
	
	register_sidebar( array(
		'name'          => __( '&#10132; Right Side Bottom', THEME_DOMAIN ),
		'id'            => 'right-side-bottom',
		'description'   => __( 'Add widgets to this area to display on top of right side bar', THEME_DOMAIN ) ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '<div class="clear"></div></aside>',
		'before_title'  => '<h2 class="widget-title"><span class="active">',
		'after_title'   => '</span></h2>'
	) );
	
	register_sidebar( array(
		'name'          => __( '&#10132; Bottom Ads', THEME_DOMAIN ),
		'id'            => 'bottom-ads',
		'description'   => __( 'Add your ads to this area to display under the flexible home layout, maximum width is 728px', THEME_DOMAIN ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '<div class="clear"></div></aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );
	
	register_sidebar( array(
		'name'          => __( '&#10132; Footer Section', THEME_DOMAIN ),
		'id'            => 'footer-section',
		'description'   => __( 'Add widgets to this area to display on footer of website', THEME_DOMAIN ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '<div class="clear"></div></aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );
	
	
}
add_action( 'widgets_init', 'register_widget_areas' );

get_template_part(THEME_R_WIDGETS.'define_widgets');

?>