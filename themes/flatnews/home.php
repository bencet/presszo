<?php get_header(); ?>


<?php
if ( is_active_sidebar( 'break-section' )) : ?>
	<section id="break-section">
		<?php dynamic_sidebar( 'break-section' ); ?>
	</section>
<?php endif; ?>
 
<div class="clear"></div>
<div id="primary">
	<div id="main">
		<?php
		if ( is_active_sidebar( 'flexible-home-layout' )) : ?>
			<section id="flexible-home-layout-section">
				<?php dynamic_sidebar( 'flexible-home-layout' ); ?>
			</section>
		<?php else: ?>
			
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="archive-inner">
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
								
								<a href="<?php echo get_permalink(); ?>" class="date"><i class="icon"></i><span><?php echo get_the_date(); ?></span></a>		
							</div><!-- .post-meta -->

							<div class="post-body post-body-archive">
								<?php echo get_the_snippet(); ?>
							</div><!-- .post-body -->
							<div class="clear"></div>

						</div><!-- .archive-inner -->

					</article><!-- #post -->
					
				<?php endwhile; /*end have_posts*/ ?>
				
				<?php get_template_part( 'content-pagination' ); ?>
				
			<?php else: ?>
				<?php get_template_part( 'content-none' ); ?>
			<?php endif; /*end have_posts()*/ ?>
		
		<?php endif; /*end check active home section*/ ?>
		
	</div><?php /*#main*/ ?>
		
	<?php get_sidebar(); ?>
		
	<div class="clear"></div>
</div><?php /*#primary*/ ?>
			

<?php get_footer(); ?>