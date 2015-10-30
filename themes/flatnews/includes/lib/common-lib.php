<?php

function get_image_attachment_id($image_url) {
	global $wpdb;
	$prefix = $wpdb->prefix;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts" . " WHERE guid='%s';", $image_url )); 
	if ( $attachment ) {
		foreach ( $attachment as $attachment_id ) 
		{
			return $attachment_id;
		}
	}
    return NULL;
}
function get_first_image_src_in_content($content = '') {
	$src = '';
	if ($content) {
		$start_image_tag = strpos($content, '<img ');
		if ($start_image_tag !== false) {
			$start_src_1 = strpos($content, 'src="', $start_image_tag);
			$start_src_2 = strpos($content, 'src=\'', $start_image_tag);
			if (!($start_src_1 === false && $start_src_2 === false)) {
				$start_src = -1;
				if ($start_src_1 === false) {
					$start_src = $start_src_2;
				} else if ($start_src_2 === false) {
					$start_src = $start_src_1;
				} else if ($start_src_1 < $start_src_2) {
					$start_src = $start_src_1;
				} else {
					$start_src = $start_src_2;
				}
				
				if ($start_src != -1) {
					$offset_key = 'src="';
					$end_src_1 = strpos($content, '"', $start_src + strlen($offset_key));
					$end_src_2 = strpos($content, '\'', $start_src + strlen($offset_key));
					$end_src = -1;
					if ($end_src_1 === false) {
						$end_src = $end_src_2;
					} else if ($end_src_2 === false) {
						$end_src = $end_src_1;
					} else if ($end_src_1 < $end_src_2) {
						$end_src = $end_src_1;
					} else {
						$end_src = $end_src_2;
					}
					
					if ($end_src != -1) {
						$len = $end_src - ($start_src + strlen($offset_key));
						$src = substr($content, $start_src + strlen($offset_key), $len);
					}
				}
			}
		}
	}
	
	return $src;
}

// http://stackoverflow.com/questions/1361149/get-img-thumbnails-from-vimeo
function get_vimeo_image_src_in_content($content = '', $size = 'small') {
	$src = '';
	
	if ($size == 'thumbnail') {
		$size = 'small';
	} else if ($size == 'full') {
		$size = 'large';
	}
	
	
	if ($size && $content) {
		// search and get vimeo ID
		$key = '//player.vimeo.com/video/';
		$start = strpos($content, $key);
		if ($start !== false) {
			$end_1 = strpos($content, '"', $start + strlen($key));
			$end_2 = strpos($content, '\'', $start + strlen($key));
			$end_3 = strpos($content, '?', $start + strlen($key));
			
			if (!($end_1 === false && $end_2 === false && $end_3 === false)) {
				$end = -1;
				if ($end_1 === false) {
					$end = $end_2;
				} else if ($end_2 === false) {
					$end = $end_1;
				} else if ($end_1 < $end_2) {
					$end = $end_1;
				} else {
					$end = $end_2;
				}
				
				if ($end_3 !== false && $end_3 < $end) {
					$end = $end_3;
				}
				
				$vimeo_id = substr($content, $start + strlen($key), $end - ($start + strlen($key)));
				
				// load vimeo thumbnail via API
				$vimeo_thumb_xml = wp_remote_get('http://vimeo.com/api/v2/video/'.$vimeo_id.'.php', array( 
					'sslverify' => false, 
					'compress'    => false,
					'decompress'  => false ));
				
				if ( !is_wp_error($vimeo_thumb_xml) ) {
					$hash = unserialize(wp_remote_retrieve_body($vimeo_thumb_xml));
					$src = $hash[0]['thumbnail_'.$size];
				}
				
			}
		}
	}
	
	return $src;
}


// http://stackoverflow.com/questions/2068344/how-to-get-thumbnail-of-youtube-video-link-using-youtube-api/2068371#2068371
function get_youtube_image_src_in_content($content = '', $size = 'thumbnail') {
	$src = '';
	if ($size && $content) {
		// search and get vimeo ID
		$key = '//www.youtube.com/embed/';
		$start = strpos($content, $key);
		
		if ($start !== false) {
			$end_1 = strpos($content, '"', $start + strlen($key));
			$end_2 = strpos($content, '\'', $start + strlen($key));
			
			if (!($end_1 === false && $end_2 === false)) {
				$end = -1;
				if ($end_1 === false) {
					$end = $end_2;
				} else if ($end_2 === false) {
					$end = $end_1;
				} else if ($end_1 < $end_2) {
					$end = $end_1;
				} else {
					$end = $end_2;
				}
				$youtube_id = substr($content, $start + strlen($key), $end - ($start + strlen($key)));
				if ($size == 'thumbnail') {
					$src = 'http://img.youtube.com/vi/'.$youtube_id.'/default.jpg';
				} else if ($size == 'medium') {
					$src = 'http://img.youtube.com/vi/'.$youtube_id.'/hqdefault.jpg';
				} else if ($size == 'large') {
					$src = 'http://img.youtube.com/vi/'.$youtube_id.'/maxresdefault.jpg';
				} else {
					$src = 'http://img.youtube.com/vi/'.$youtube_id.'/mqdefault.jpg';
				}
				
			}
		} else {
			$key = '//www.youtube.com/v/';
			$start = strpos($content, $key);
			if ($start !== false) {
				$end = strpos($content, '?', $start + strlen($key));
				if ($end !== false) {
					$youtube_id = substr($content, $start + strlen($key), $end - ($start + strlen($key)));
					if ($size == 'thumbnail') {
						$src = 'http://img.youtube.com/vi/'.$youtube_id.'/default.jpg';
					} else if ($size == 'medium') {
						$src = 'http://img.youtube.com/vi/'.$youtube_id.'/hqdefault.jpg';
					} else if ($size == 'large') {
						$src = 'http://img.youtube.com/vi/'.$youtube_id.'/maxresdefault.jpg';
					} else {
						$src = 'http://img.youtube.com/vi/'.$youtube_id.'/mqdefault.jpg';
					}
				}
			}
		}
	}
	return $src;
}



/*sizes: thumbnail, large, medium, full*/
function get_post_image($post_id = 0, $size = 'thumbnail', $attr = NULL) {
	$html = '';
	
	if (!$post_id) {
		$post_id = get_the_ID();
	}
	
	if ($post_id) {
	
		if (has_post_thumbnail($post_id)) {
			$html = get_the_post_thumbnail($post_id, $size, $attr);
		} else {
			$content_post = get_post($post_id);
			$content = $content_post->post_content;
			
			// search image in post
			$src = get_first_image_src_in_content($content);
			if ($src == '') {
				$src = get_vimeo_image_src_in_content($content, $size);
				if ($src == '') {
					$src = get_youtube_image_src_in_content($content, $size);
				}
			}
			
			if ($src) {
				if (get_image_attachment_id($src)) {
					$html .= wp_get_attachment_image( get_image_attachment_id($src), $size, false, $attr );
				} else {
					// maybe external image or not in library
					$html = '<img src="'.$src.'"';
					foreach ($attr as $key => $value) {
						$html .= ' '.$key.'="'.$value.'"';
					}
					$html .= '/>';
				}
			} else {
				$src = get_theme_mod('default_thumbnail');
				if ($src == '') {
					$src =  THEME_URL_IMAGES.'default-thumbnail.jpg';
				}
				
				// for post without images
				$html = '<img src="'.$src.'"';
				foreach ($attr as $key => $value) {
					$html .= ' '.$key.'="'.$value.'"';
				}
				$html .= '/>';
			}
			
		}
	}
	return $html;
}


/*  ----------------------------------------------------------------------------
    mbstring support
 */

if (!function_exists('mb_strlen')) {
    function mb_strlen ($string) {
        return strlen($string);
    }
}

if (!function_exists('mb_strpos')) {
    function mb_strpos($haystack,$needle,$offset=0) {
        return strpos($haystack,$needle,$offset);
    }
}
if (!function_exists('mb_strrpos')) {
    function mb_strrpos ($haystack,$needle,$offset=0) {
        return strrpos($haystack,$needle,$offset);
    }
}
if (!function_exists('mb_strtolower')) {
    function mb_strtolower($string) {
        return strtolower($string);
    }
}
if (!function_exists('mb_strtoupper')) {
    function mb_strtoupper($string){
        return strtoupper($string);
    }
}
if (!function_exists('mb_substr')) {
    function mb_substr($string,$start,$length) {
        return substr($string,$start,$length);
    }
}


/*Use this function inside loop*/
function get_the_snippet($length = 150) {
	$html = '';
	
	if (get_the_excerpt()) {
		$html = get_the_excerpt();
	} else {
		$html = get_the_content('', false);
	}
	
	if ($html) {
		$html = strip_tags($html);
		if (strlen($html) > $length) {
			if (	function_exists('mb_internal_encoding') &&
					function_exists('mb_http_output') &&
					function_exists('mb_http_input') &&
					function_exists('mb_language') &&
					function_exists('mb_regex_encoding')) {
				mb_internal_encoding('UTF-8');
				mb_http_output('UTF-8');
				mb_http_input('UTF-8');
				mb_language('uni');
				mb_regex_encoding('UTF-8');
			}
			$html = mb_substr($html, 0, $length) . '...';	
		}
		$html = '<p class="snippet">'.$html.'</p>';
	}
	return $html;
}

function remove_html_slashes($content) {
	return filter_var(stripslashes($content), FILTER_SANITIZE_SPECIAL_CHARS);
}

?>