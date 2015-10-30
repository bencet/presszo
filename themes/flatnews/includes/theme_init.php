<?php 

/**
 * Sets up the content width value based on the theme's design.
 */
if ( ! isset( $content_width ) )
	$content_width = 720;
	
	
function theme_setup() {
	load_theme_textdomain( THEME_DOMAIN, get_template_directory() . '/languages' );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'top-page-list', __( 'Top Page List', THEME_DOMAIN ) );
	register_nav_menu( 'drop-down-menu', __( 'Drop Down Menu', THEME_DOMAIN ) );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 420, 420 );
	set_post_thumbnail_size( 720, 720 );
}
add_action( 'after_setup_theme', 'theme_setup' );


function new_excerpt_more( $more ) {
	return '';
}
add_filter('excerpt_more', 'new_excerpt_more');

function custom_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . __( 'Page', THEME_DOMAIN ) . ' ' . max( $paged, $page );
	}
	return $title;
}
add_filter( 'wp_title', 'custom_wp_title', 10, 2 );



/* custom author fields*/
/*#######################*/
add_action( 'show_user_profile', 'flatnews_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'flatnews_show_extra_profile_fields' );

function flatnews_show_extra_profile_fields( $user ) { ?>

	<h3><?php _e('Social Links for Author box', THEME_DOMAIN); ?></h3>

	<table class="form-table">		
		<tr>			
			<th><label for="twitter"><?php _e('Twitter URL', THEME_DOMAIN); ?> </label></th>
			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		
		<tr>			
			<th><label for="face"><?php _e('Facebook URL', THEME_DOMAIN); ?></label></th>
			<td>
				<input type="text" name="face" id="face" value="<?php echo esc_attr( get_the_author_meta( 'face', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		
		<tr>			
			<th><label for="gplus"><?php _e('Google+ URL', THEME_DOMAIN); ?></label></th>
			<td>
				<input type="text" name="gplus" id="gplus" value="<?php echo esc_attr( get_the_author_meta( 'gplus', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		
		<tr>			
			<th><label for="youtube"><?php _e('Youtube URL', THEME_DOMAIN); ?></label></th>
			<td>
				<input type="text" name="youtube" id="youtube" value="<?php echo esc_attr( get_the_author_meta( 'youtube', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		
		<tr>			
			<th><label for="pinterest"><?php _e('Pinterest URL', THEME_DOMAIN); ?></label></th>
			<td>
				<input type="text" name="pinterest" id="pinterest" value="<?php echo esc_attr( get_the_author_meta( 'pinterest', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		
		<tr>			
			<th><label for="instagram"><?php _e('Instagram URL', THEME_DOMAIN); ?></label></th>
			<td>
				<input type="text" name="instagram" id="instagram" value="<?php echo esc_attr( get_the_author_meta( 'instagram', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		
		<tr>			
			<th><label for="rss"><?php _e('RSS Feed', THEME_DOMAIN); ?></label></th>
			<td>
				<input type="text" name="rss" id="rss" value="<?php echo esc_attr( get_the_author_meta( 'rss', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		
	</table>
<?php }

add_action( 'personal_options_update', 'flatnews_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'flatnews_save_extra_profile_fields' );

function flatnews_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}
	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
	update_user_meta( $user_id, 'face', $_POST['face'] );
	update_user_meta( $user_id, 'gplus', $_POST['gplus'] );
	update_user_meta( $user_id, 'youtube', $_POST['youtube'] );
	update_user_meta( $user_id, 'pinterest', $_POST['pinterest'] );	
	update_user_meta( $user_id, 'instagram', $_POST['instagram'] );	
	update_user_meta( $user_id, 'rss', $_POST['rss'] );	
}


// add file type support
// http://en.wikipedia.org/wiki/List_of_file_formats
global $font_ext;
$font_ext = array('abf','afm','bdf','bmf','fnt','fon','mgf','otf','pcf','pfa','pfb','pfm','afm','fond','sfd','snf','tdf','tfm','ttf','ttc','woff');

add_filter('upload_mimes', 'custom_upload_mimes');
function custom_upload_mimes ( $existing_mimes=array() ) {
	global $font_ext;
	foreach ($font_ext as $value) {
		$existing_mimes[$value] = 'font/opentype';
	}
	return $existing_mimes;
}
 