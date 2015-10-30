<?php
	$author_id = get_the_author_meta( 'ID' );
	if ($author_id !== '') :
		$author = get_userdata($author_id);
		$author_name = $author->data->display_name;
		$author_nice_name = $author->data->user_nicename;
		$author_profile_url = home_url().'/author/'.$author_nice_name;
		$author_avatar = get_simple_local_avatar( $author_id, 120, 'http://assets.tumblr.com/images/default_avatar_128.png', 'author-avatar' );
		$author_avatar = get_simple_local_avatar( $author_id, 120, 'http://assets.tumblr.com/images/default_avatar_128.png', 'author-avatar' );
		$author_description = get_the_author_meta('description',$author_id);
		
		$author_website = $author->data->user_url;
		$author_twitter = get_user_meta($author_id, 'twitter', true);
		$author_facebook = get_user_meta($author_id, 'face', true);
		$author_gplus = get_user_meta($author_id, 'gplus', true);
		$author_youtube = get_user_meta($author_id, 'youtube', true);
		$author_pinterest = get_user_meta($author_id, 'pinterest', true);
		$author_instagram = get_user_meta($author_id, 'instagram', true);
		$author_rss = get_user_meta($author_id, 'rss', true);
		
		?>
		
		<div class="post-author">
			<div class="author-image">
				<a href="<?php echo $author_profile_url; ?>" title="<?php _e('A szerzőről:', THEME_DOMAIN); echo esc_attr($author_name); ?> " rel="author"><?php echo $author_avatar; ?></a>
			</div>
			<div class="author-info">
				<h4><?php _e('A szerzőről:', THEME_DOMAIN); ?> <a href="<?php echo $author_profile_url; ?>" title="<?php _e('A szerzőről:', THEME_DOMAIN); echo esc_attr($author_name); ?> " rel="author"><?php echo $author_name; ?></a></h4>
				<p><?php echo $author_description; ?></p>
				
				<?php 
				if ( 	$author_facebook ||
						$author_gplus ||
						$author_pinterest ||
						$author_twitter ||
						$author_website ||
						$author_youtube || 
						$author_instagram ||
						$author_rss) :
				?>
						
				<div class="author-connect">
					<?php if ($author_website) : ?>
					<a href="<?php echo $author_website; ?>" class="author-social website"></a>
					<?php endif; ?>
					
					<?php if ($author_facebook) : ?>
					<a href="<?php echo $author_facebook; ?>" class="author-social facebook"></a>
					<?php endif; ?>
					
					<?php if ($author_twitter) : ?>
					<a href="<?php echo $author_twitter; ?>" class="author-social twitter"></a>
					<?php endif; ?>
					
					<?php if ($author_gplus) : ?>
					<a href="<?php echo $author_gplus; ?>?rel=author" class="author-social gplus"></a>
					<?php endif; ?>
					
					<?php if ($author_instagram) : ?>
					<a href="<?php echo $author_instagram; ?>" class="author-social instagram"></a>
					<?php endif; ?>
					
					<?php if ($author_pinterest) : ?>
					<a href="<?php echo $author_pinterest; ?>" class="author-social pinterest"></a>
					<?php endif; ?>
					
					<?php if ($author_youtube) : ?>
					<a href="<?php echo $author_youtube; ?>" class="author-social youtube"></a>
					<?php endif; ?>
					
					<?php if ($author_rss) : ?>
					<a href="<?php echo $author_rss; ?>" class="author-social rss"></a>
					<?php endif; ?>
					
					
				</div>
				
				<?php endif; ?>
				
			</div>
			<div class="clear"></div>
		</div>
		
		<?php
		
	endif;

?>