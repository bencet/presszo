<?php get_header(); ?>

<div class="clear"></div>
<div id="primary">
	<div id="main">
			
		<div class="desc-404">
			<?php _e('Ez az oldal nem elérhető', THEME_DOMAIN);?>
		</div>
		<div class="img-404">404</div>
		
		<div class="clear"></div>
			<?php get_search_form(); ?>
		<div class="clear"></div>
		<a class="home-from-none" href="<?php echo get_home_url(); ?>">Home</a>
		<div class="clear"></div>
		
	</div><!-- #main -->
	
	<div class="clear"></div>
</div><!-- #primary -->
			
<?php get_footer(); ?>