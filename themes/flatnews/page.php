<?php get_header(); ?>



<?php

if ( is_active_sidebar( 'break-section' ) && (get_theme_mod('break_box') == true)) : ?>

	<section id="break-section">

		<?php dynamic_sidebar( 'break-section' ); ?>

	</section>

<?php endif; ?>



<div class="clear"></div>

<div id="primary">

	<div id="main">

		

		<?php if (have_posts()) : ?>

			<?php while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					

					<header class="post-header">

						<h1 class="post-title"><?php the_title(); ?></h1>

						<h3 class="sub-title"> <?php the_subtitle(); ?> </h3>

						<div class="meta post-meta">

							<?php

								if (comments_open()) {

									echo '<a href="'.get_comments_link().'" class="comment"><i class="icon"></i><span>'.get_comments_number().'</span></a>';

								}

								if (get_the_category()) {

									echo '<div class="cate">';

									the_category(", ");

									echo '</div>';

								}

								

								echo '<a href="'.get_permalink().'" class="date"><i class="icon"></i><span>'.get_the_date().'</span></a>';

							?>

							

							<div class="post-apps">

								<a href="#A+" class="zoom-text zoom-in-text">A<span>+</span></a>

								<a href="#A-" class="zoom-text zoom-out-text">A<span>-</span></a>

								<!-- AddThis Button BEGIN -->

								<div class="addthis_toolbox addthis_default_style addthis_16x16_style">

									<a class="addthis_button_email">Email</a>

									<a class="addthis_button_print">Print</a>

								</div>

								

								<!-- AddThis Button END -->

							</div>

							

							

						</div><!-- .post-meta -->

					</header><!-- .post-header -->



					<div class="post-body">

						<?php 

						if ( (has_post_thumbnail()) && (get_theme_mod( 'hide_feature_image' ) != true)) : ?>

							<div class="post-feature-image">

								<?php the_post_thumbnail('medium', array('alt' => esc_attr(get_the_title()), 'title' => esc_attr(get_the_title()) )); ?>

							</div>

						<?php endif; ?>

						<?php 

						global $post;

						

						if( ($post->post_excerpt) && (get_theme_mod( 'hide_excerpt' ) != true)) : ?>

							<div class="post-summary">

								<?php the_excerpt(); ?>

							</div><!-- .post-summary -->

						<?php endif; ?>

						

						

						<?php the_content(); ?>

						<?php wp_link_pages();?>

						<div class="clear"></div>

						

					</div><!-- .post-body -->



					



					<?php comments_template(); ?>





				</article><!-- #post -->

			<?php endwhile; /*end have_posts*/ ?>

			

			

		<?php else: ?>

			<?php get_template_part( 'content-none' ); ?>

			

		<?php endif; /*end have_posts()*/ ?>

		

	</div><?php /*#main*/ ?>



	<div class="clear"></div>

</div><?php /*#primary*/ ?>

			

<?php get_footer(); ?>