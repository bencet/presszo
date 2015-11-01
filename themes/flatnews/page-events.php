<?php
/*
Template Name: Page Events
*/
?>

<?php get_header(); ?>

<?php if ( is_active_sidebar( 'break-section' ) && (get_theme_mod('break_box') == true)) : ?>

	<section id="break-section">
		<?php dynamic_sidebar( 'break-section' ); ?>
	</section>

<?php endif; ?>

<div class="clear"></div>

<div id="primary">

	<div id="main">
		<?php
			$args = array(
				'post_type'			=> 'event',
				'posts_per_page' 	=> '10',
				'paged' 			=> get_query_var('paged'),
				'meta_key'			=> 'event_date',
				'orderby'			=> 'meta_value_num',
				'order'				=> 'DESC'
			);
			$events = new WP_Query( $args );
			$prev = null;
			$archic_event = 0;
			while ($events->have_posts()) : $events->the_post();
				
			$edate = get_field('event_date');
			$cdate = strtolower(date('Y/m/d.', strtotime('now')));
		?>
		<?php	if( $edate > $cdate ) { ?>
		
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="archive-inner future-event">
						<a href="<?php echo get_permalink(); ?>" title="<?php echo __('Click to read', THEME_DOMAIN); ?>" class="item-thumbnail archive-thumbnail"><?php echo get_post_image(get_the_ID(), 'medium', array('alt' =>'item-thumbnail', 'title' => esc_attr(get_the_title()))); ?></a>

						<h2 class="post-title archive-post-title"><a href="<?php echo get_permalink(); ?>" title="<?php echo __('Click to read', THEME_DOMAIN); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<div class="meta meta-post-archive">
							<?php
								if (comments_open()) {
							?>
								<a href="<?php echo get_comments_link(); ?>" class="comment"><i class="icon"></i><span><?php echo get_comments_number(); ?></span></a>
									
							<?php
								}
								if (get_the_category()) {
									echo '<div class="cate">';
									the_category(", ");
									echo '</div>';
								}			 
							?>
								
							<a href="<?php echo get_permalink(); ?>" class="date"><i class="icon"></i><span><?php echo $edate; ?></span></a>
						</div><!-- .post-meta -->

						<div class="post-body post-body-archive">
							<?php echo get_the_snippet(); ?>
						</div><!-- .post-body -->
						<div class="clear"></div>

					</div><!-- .archive-inner -->

				</article><!-- #post -->
				<?php } ?>
			<?php	
				if( $edate < $cdate ) { 
					if( $archiv_event == 0) {
						echo '<div class="archiv-event">Elmúlt Eseményeink:</div>';
						$archiv_event = 1;
					}
					$valaszto = date('Y. F', strtotime($edate));
					
					if ( $valaszto != $prev ) {
						echo '<div class="arch-event">'. $valaszto . '</div>';
						$prev = $valaszto;
					}
				}
			?>	
			<?php	if( $edate < $cdate ) { ?>
		
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="archive-inner past-event">
						<a href="<?php echo get_permalink(); ?>" title="<?php echo __('Click to read', THEME_DOMAIN); ?>" class="item-thumbnail archive-thumbnail"><?php echo get_post_image(get_the_ID(), 'medium', array('alt' =>'item-thumbnail', 'title' => esc_attr(get_the_title()))); ?></a>

						<h2 class="post-title archive-post-title"><a href="<?php echo get_permalink(); ?>" title="<?php echo __('Click to read', THEME_DOMAIN); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<div class="meta meta-post-archive">
							<?php
								if (comments_open()) {
							?>
								<a href="<?php echo get_comments_link(); ?>" class="comment"><i class="icon"></i><span><?php echo get_comments_number(); ?></span></a>
									
							<?php
								}
								if (get_the_category()) {
									echo '<div class="cate">';
									the_category(", ");
									echo '</div>';
								}			 
							?>
								
							<a href="<?php echo get_permalink(); ?>" class="date"><i class="icon"></i><span><?php echo $edate; ?></span></a>
						</div><!-- .post-meta -->

						<div class="post-body post-body-archive">
							<?php echo get_the_snippet(); ?>
						</div><!-- .post-body -->
						<div class="clear"></div>

					</div><!-- .archive-inner -->

				</article><!-- #post -->
				<?php } ?>
			<?php endwhile; ?>
		<?php wp_pagenavi(array( 'query' => $events )); ?>
	</div>
	<?php get_sidebar(); ?>
	
	<div class="clear"></div>
	
</div>
<?php get_footer(); ?>