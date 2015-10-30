<?php

// comment design
function wpinhands_theme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<?php 
	if ($comment->user_id == get_the_author_meta('ID')) {
		$author = 'comments-author';
	} else {
		$author='';
	} ?>
	
		<div class="comments-item <?php echo $author; ?>"  id="comment-<?php comment_ID(); ?>">
			<div class="avatar-image-container">
				<?php if (get_comment_author_url()) : ?>
					<a href="<?php echo comment_author_url(); ?>" target="_blank" rel="nofollow">
						<?php echo get_avatar( $comment, 45);?>
					</a>
				<?php else: ?>
					<span><?php echo get_avatar( $comment, 45);?></span>
				<?php endif; ?>
			</div>
			
			
			
			<div class="comment-block">
				
				<div class="comments-header">
				
					<span class="comment-author-name"><?php echo comment_author_link(); ?></span>
					
					<span class="datetime secondary-text">
						<a href="<?php echo get_comment_link(); ?>" rel="nofollow" title="<?php echo __('Permalink', THEME_DOMAIN); ?>"><?php printf(' %1$s, %2$s', get_comment_date(), get_comment_time());?></a>
					</span>
				</div>
				
				<div class="comment-content">
					<?php comment_text(); ?>
					<div class="clear"></div>
					
					<?php if ($comment->comment_approved == '0') : ?>
						<p><em><?php printf ( __( 'Your comment is awaiting moderation.' , THEME_DOMAIN ));?></em></p>
					<?php endif; ?>
					
				
					<span class="comment-actions secondary-text">
					<?php 
					comment_reply_link( wp_parse_args( $args, array( 'reply_text' => (__( 'Reply', THEME_DOMAIN ) . ' <span>&darr;</span>'), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</span>
					
					
				</div>
				
			</div>
		</div>
		<div class="clear"></div>
	
	
<?php
}

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

if ( have_comments()) {
?>
<div id="comments" class="comments">
	<ol>
<?php
	wp_list_comments( array( 'callback' => 'wpinhands_theme_comment' ) );
?>
	</ol>
</div>

	<?php
		// Are there comments to navigate through?
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h3 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', THEME_DOMAIN ); ?></h3>
		<div class="nav-previous"><?php previous_comments_link( '&larr; ' . __( 'Older Comments', THEME_DOMAIN ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', THEME_DOMAIN ) . ' &rarr;' ); ?></div>
	</nav><!-- .comment-navigation -->
	<?php endif; // Check for comment navigation ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
	<p class="no-comments"><?php _e( 'Comments are closed.' , THEME_DOMAIN ); ?></p>
	<?php endif; ?>


<?php
}

if ( comments_open() ) {
	// comment form
	$args = array(
		'comment_notes_after' => ''
	);
	comment_form($args);
}

?>