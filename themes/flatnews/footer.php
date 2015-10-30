<?php if ( is_active_sidebar( 'bottom-ads' ) && (!is_page()) && (!is_404())) : ?>

	<section id="bottom-hm">

		<?php dynamic_sidebar( 'bottom-ads' ); ?>

	</section>

<?php endif; ?>



<div class="clear"></div>



	<footer id="footer">

		

		<?php if ( is_active_sidebar( 'footer-section' )) : ?>

			<section id="footer-section">

				<?php dynamic_sidebar( 'footer-section' ); ?>

				<div class="clear"></div>

			</section>

		<?php endif; ?>



		<div id="copyright">

			Copyright 2015 <a href="<?php echo get_home_url(); ?>"><?php bloginfo( 'name' ); ?> </a>. By <a href="<?php echo COPYRIGHT_URL; ?>" target="_blank">Wpinhands</a>

		</div>

	</footer>



</div><?php /* Wide #wrapper*/ ?>



<a class='scrollup' href='#'>Scroll</a>

<?php wp_footer(); ?>

<div id="fb-root"></div>

<script>(function(d, s, id) {

  var js, fjs = d.getElementsByTagName(s)[0];

  if (d.getElementById(id)) return;

  js = d.createElement(s); js.id = id;

  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";

  fjs.parentNode.insertBefore(js, fjs);

}(document, 'script', 'facebook-jssdk'));</script>

<?php
//RESPONSIVE MENU MULTILANG IMPLEMENTACIO
switch( get_locale() ){
	case 'hu_HU' : $rm = 'Main Menu'; 
	break;
	case 'sr_RS' : $rm = 'Main Menu-SR'; 
	break;
	default : $rm = 'Main Menu';
}

echo do_shortcode( '[responsive-menu menu="'.$rm.'"]' );
//RESPONSIVE MENU MULTILANG IMPLEMENTACIO - END
?>

<!--KI LETT VEVE A HEDERBOL ES AT LETT IDE RAKVA KLIENSI KERESRE-->
<link rel="profile" href="http://gmpg.org/xfn/11"/>

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>

	<!--[if lt IE 9]>

	<script src="<?php echo THEME_URL_SCRIPTS_COMMONS; ?>html5.js"></script>

	<![endif]-->	

<!--KI LETT VEVE A HEDERBOL ES AT LETT IDE RAKVA KLIENSI KERESRE - END-->
</body>

</html> 
