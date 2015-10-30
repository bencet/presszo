<?php

/*CUSTOMIZE OUTPUT TO THEME*/

function display_social_list() {
	
	global $social_name_array;
	echo '<ul class="social-link-list">';
	
	foreach ($social_name_array as $social_name) {
		if (get_theme_mod( 'social_'.$social_name.'_link' )) {
			echo '
			<li>
				<a href="'.get_theme_mod( 'social_'.$social_name.'_link' ).'" class="item-'.$social_name.' ti" target="_blank">'.$social_name.'</a>
			</li>';
		}
	}
	
	echo '</ul>';
}

function dynamic_inline_style() {
	$custom_css = '';
	$main_color = get_theme_mod('main_color');
	if ($main_color == '' || $main_color == NULL) {
		$main_color = '#D12F2F';
	}
	
	$bg_color = get_theme_mod('background-color');
	if ($bg_color == '' || $bg_color == NULL) {
		$bg_color = '#E5E5E5';
	}
	
	$bg_img = get_theme_mod('background-image');
	$em_font = get_theme_mod('emphasis-font');
	if ($em_font == '' || $em_font == NULL) {
		$em_font = 'font-62';
	}
	
	$body_font = get_theme_mod('body-font');
	if ($body_font == '' || $body_font == NULL) {
		$body_font = 'font-0';
	}
	
	$em_font_index = (int) substr($em_font, strpos($em_font, '-')+1);
	$body_font_index = (int) substr($body_font, strpos($body_font, '-')+1);
	
	// dynamic inline css
	if ($main_color) {
		$custom_css .= 'a,
#top-page-list ul li a,
.news-box.break li h3.title a:hover,
#flexible-home-layout-section .news-box .meta a:hover,
.post-wrapper .meta > div:hover,
.related-post .meta a:hover,
.related-news .meta a:hover,
#flexible-home-layout-section .news-box.slider h3.title a:hover,
.post-header .meta a:hover,
#copyright a:hover,
#selectnav2 {
	color: '.$main_color.';
}
::-webkit-scrollbar-thumb {
	background-color: '.$main_color.';
}

.header-line-2,
#drop-down-menu > div > ul > li:hover > a,
#drop-down-menu ul.sub-menu li a:hover,
#flexible-home-layout-section .news-box h2.title a,
#flexible-home-layout-section .news-box.hot .item-first,
#flexible-home-layout-section .news-box.slider .dots li.active,
.tagcloud a,
#respond form #submit,

#contact-form .show-all a {
	background-color: '.$main_color.';
}
.post-body blockquote {
	border-top-color: '.$main_color.';
}';
	}
	
	if ($bg_color || $bg_img) {
		$custom_css .='body {
'.(($bg_img)? 'background-image: url('.$bg_img.');':'')
.(($bg_color)? 'background-color: '.$bg_color.';':'').'
}';
	}
	
	$em_font_text = 'Oswald';
	$body_font_text = 'Arial';
	// google font
	if ($em_font && $body_font) {
		global $Google_Font_List;
	
		
		
	
		// loading google fonts
		if (strpos($em_font, 'cufont') === false) {
			$em_font_text = $Google_Font_List[$em_font_index];
			if ($em_font_index > 6) {
				echo '<link href="http://fonts.googleapis.com/css?family='.str_replace(' ', '+', $em_font_text).'" rel="stylesheet" type="text/css">';
				/*
				$custom_css .='
				@import url(http://fonts.googleapis.com/css?family='.str_replace(' ', '+', $em_font_text).');';
				*/
			}
		} else {
			$fid = get_the_ID($em_font_index);
			$fname = get_the_title($em_font_index);
			$fguid = get_the_guid($em_font_index);
			$custom_css .= '@font-face {
  font-family: \''.$fname.'\';
  src: url('.$fguid.') format(\'woff\');
}';
			$em_font_text = $fname;
		}
		if (strpos($body_font, 'cufont') === false) {
			$body_font_text = $Google_Font_List[$body_font_index];
			if ($body_font_index > 6) {
				echo '<link href="http://fonts.googleapis.com/css?family='.str_replace(' ', '+', $body_font_text).'" rel="stylesheet" type="text/css">';
				/*
				$custom_css .='
				@import url(http://fonts.googleapis.com/css?family='.str_replace(' ', '+', $body_font_text).');';
				*/
			}
		} else {
			$fid = get_the_ID($body_font_index);
			$fname = get_the_title($body_font_index);
			$fguid = get_the_guid($body_font_index);
			$custom_css .= '@font-face {
  font-family: \''.$fname.'\';
  src: url('.$fguid.') format(\'woff\');
}';
			$body_font_text = $fname;
		}
		$custom_css .='
body,
#drop-down-menu ul.sub-menu li a{
	font-family: '.$body_font_text.';
}
.blog-title,
#drop-down-menu,
#flexible-home-layout-section .news-box h2.title,
#flexible-home-layout-section .news-box h3.title,
h1.post-title,
.post-body blockquote,
.post-apps a,
.zoom-text span,
h2.archive-post-title,
#side h2.widget-title,
.widget_feed_data_widget .item .title,
#footer-section .widget-title,
.tagcloud a,
#post-footer-section .widget .widget-title ,
.share-post .title,
.related-news h3.title,
.post-author .author-info h4,
.page-numbers,
.paginations .item a,
#reply-title,
.img-404,
a.home-from-none,
#contact-form .label,
#contact-form .show-all a,
#selectnav2 {
	font-family: \''.$em_font_text.'\', sans-serif;
}';

	}
	
	
    wp_add_inline_style( 'theme-style', $custom_css );
	
	// dynamic inline javascript
	if (is_home() || (get_theme_mod('break_box') == true)) {
		echo '<script type="text/javascript">
var TICKER_DELAY = '.((get_theme_mod('ticker_delay'))?get_theme_mod('ticker_delay'):'7').';
var SLIDER_DELAY = '.((get_theme_mod('slider_delay'))?get_theme_mod('slider_delay'):'3000').';
var SLIDER_SPEED = '.((get_theme_mod('slider_speed'))?get_theme_mod('slider_speed'):'500').';
</script>';
	}
	
}
add_action( 'wp_enqueue_scripts', 'dynamic_inline_style' );


function custom_favicon() {
	$fav_src = get_theme_mod('favicon_image');
	$fav_html = '<link rel="shortcut icon" ';
	if (!$fav_src) {
		$fav_src = THEME_URL_IMAGES.'favicon.png';
	}
	if (strpos($fav_src, '.ico') !== false) {
		$fav_html .= 'type="image/x-icon"';
	} else if (strpos($fav_src, '.png') !== false) {
		$fav_html .= 'type="image/png"';
	} else if (strpos($fav_src, '.gif') !== false) {
		$fav_html .= 'type="image/gif"';
	}
		
	
	$fav_html .= ' href="'.$fav_src.'"/>';
	
	echo $fav_html;
}
add_action('wp_head', 'custom_favicon');

?>