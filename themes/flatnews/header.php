<?php

$dir = '';

if (get_theme_mod('rtl') == true) {

	$dir = ' dir="rtl"';

}

?>



<!DOCTYPE html>

<!--[if IE 7]>

<html class="ie ie7" <?php language_attributes(); echo $dir; ?>>

<![endif]-->

<!--[if IE 8]>

<html class="ie ie8" <?php language_attributes(); echo $dir; ?>>

<![endif]-->

<!--[if !(IE 7) | !(IE 8)  ]><!-->

<html <?php language_attributes(); echo $dir; ?>>

<!--<![endif]-->

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>"/>

	<!--REGI VEWPORT<meta name="viewport" content="width=device-width"/>-->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<?php wp_head(); ?>

</head>

	

<body <?php body_class(); ?>>



<div class='wide' id="wrapper">

	<header id="header">

		<div class="header-line-1">

			<?php

				if ( has_nav_menu( 'top-page-list' ) ) {

					echo '<nav id="top-page-list">';

					wp_nav_menu( array( 'theme_location' => 'top-page-list', 'menu_class' => 'page-list' ) );

					echo '</nav>';

				}

			?>

			<?php get_search_form(); ?>

			<div class="social-list" id="social-list-top">

				<?php display_social_list(); ?>

			</div>

			

			<div class="clear"></div>

			

			

		</div>

		<div class="clear"></div>

		<div class="header-line-2 table">

			<div class="tr">

				<div class="td">

					<?php

						$blog_title = '<a href="'.get_home_url().'" title="'.esc_attr(get_bloginfo( 'description')).'">';

						

						if (get_theme_mod('blog_logo')) {

							$blog_title .= '<img alt="blog-logo" src="'.get_theme_mod('blog_logo').'"/>';

						}

						else {

							

							$blog_title .= get_bloginfo('name');

						}

						$blog_title .= '</a>';

					?>

					<?php if (!is_single() && !is_page()) : ?>

						<h1 class="blog-title"><?php echo $blog_title; ?></h1>

					<?php else : ?>

						<h2 class="blog-title"><?php echo $blog_title; ?></h2>

					<?php endif; ?>

				</div>

				<div class="td">

					<?php if ( is_active_sidebar( 'header-ads2' ) ) : ?>

						<section id="header-hm">

							<?php dynamic_sidebar( 'header-ads2' ); ?>

						</section> 

					<?php endif; ?>

				</div>

			</div>

			<div class="clear"></div>

		</div>

		<div class="clear"></div>

		<div class="header-line-3">

			<?php

				if ( has_nav_menu( 'drop-down-menu' ) ) {

					echo '<nav id="drop-down-menu">';

					wp_nav_menu( array( 'theme_location' => 'drop-down-menu', 'menu_class' => 'page-list' ) );

					echo '</nav>';

				}

			?>

			<div class="clear"></div>

		</div>

	</header>

	<div class="clear"></div>
