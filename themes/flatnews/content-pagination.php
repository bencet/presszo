<?php /*pagination*/
	if (!is_page() && !is_single()) :
	
		global $wp_query;
		$big = 999999999; // need an unlikely integer
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages
		) );
	
		
		
	else:
		
		if (get_adjacent_post(false, '', true) || get_adjacent_post(false, '', false)) :
		
		?>
			<div class="paginations item_pagination">
				<?php if (get_adjacent_post(false, '', false)) : ?>
				<div class="item"><span><?php echo __('Újabb cikk', THEME_DOMAIN); ?></span><?php next_post_link('%link'); ?></div>
				<?php endif;?>
				
				<?php if (get_adjacent_post(false, '', true)) : ?>
				<div class="item"><span><?php echo __('Régebbi cikk', THEME_DOMAIN); ?></span><?php previous_post_link('%link'); ?></div>
				<?php endif;?>
				<div class="clear"></div>
			</div>
		<?php
		
		endif;
	endif;
?>