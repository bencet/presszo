<div id="side">
<?php if ( is_active_sidebar( 'right-side-top' )) : ?>
	<section id="right-side-top" class="section">
		<?php dynamic_sidebar( 'right-side-top' ); ?>
	</section>
<?php endif; ?>

<?php if ( is_active_sidebar( 'right-side-tab' )) : ?>
	<section id="right-side-tab" class="section">
		<?php dynamic_sidebar( 'right-side-tab' ); ?>
	</section>
<?php endif; ?>


<?php if ( is_active_sidebar( 'right-side-bottom' )) : ?>
	<section id="right-side-bottom" class="section">
		<?php dynamic_sidebar( 'right-side-bottom' ); ?>
	</section>
<?php endif; ?>
</div><?php /*#side*/ ?>