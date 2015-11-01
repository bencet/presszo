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
	
		<?php /*
			$args = array( 'post_type' => 'event' );
			$event = new WP_Query( $args );*/
		?>
		<?php while ( have_posts() ) : the_post(); ?>
		
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<header class="post-header">
						<h1 class="post-title entry-title"><?php the_title(); ?></h1>
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

								//A Co-Authors Plus PLUGIN MEGVALOSITASA A TEMABAN ES A BEEPITETT KIIKTATASA
								if ( function_exists( 'coauthors_posts_links' ) ) {
								echo '<span>';
									coauthors_posts_links();
								echo '</span>';
								} else {
									echo '<a href="'.get_permalink().'" <span>'.get_the_author().'</span></a>';
								}

								/*AZ EREDTEI TEMA KIIRO FUGGVENYE ITT VAN KIKAPCSOLVA
								echo '<a href="'.get_permalink().'" <span>'.get_the_author().'</span></a>';
								*/
								//A Co-Authors Plus PLUGIN MEGVALOSITASA A TEMABAN ES A BEEPITETT KIIKTATASA - END

							?>

							<div class="post-apps">

								<a href="#A+" class="zoom-text zoom-in-text">A<span>+</span></a>
								<a href="#A-" class="zoom-text zoom-out-text">A<span>-</span></a>

								<!-- AddThis Button BEGIN -->
								<div class="addthis_toolbox addthis_default_style addthis_16x16_style">

									<a class="addthis_button_email">Email</a>

									<a class="addthis_button_print">Print</a>

								</div><!-- AddThis Button END -->

							</div>
						</div><!-- .post-meta -->
					</header><!-- .post-header -->
					
					<div class="post-body">
						<div class="eventBox forDate">
							<p><?php the_field('event_date'); ?></p>
							<p><?php the_field('event_time'); ?></p>
						</div>
						<div class="eventBox forPlace">
							<?php 
								$location = get_field('event_place');
								$address = explode( "," , $location['address']);
							?>
							<p class="sm"><?php echo $address[3] ?></p> <?php //city name ?>
							<p class="sm1"><?php echo $address[0] ?></p> <?php //place name ?>
							<p class="sm2"><?php echo $address[2] ?></p> <?php //street adress ?>
						</div>
						
						<div class="mapToogle">
							<span>Térkép a helyszínhez</span>
						</div>
						<?php 
							$location = get_field('event_place');
							if( !empty($location) ):
					
								$address = urlencode( $location['address'] );	
								
								echo '<iframe class="eventMap" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q='. $address .'&key=AIzaSyA6XZINoefyLZeLt7qxENGFKsbE_LRt2js" allowfullscreen></iframe>';
							endif; 
						?>	
					
						<?php the_content(); ?>
						<?php wp_link_pages();?>

						<!--KOMMENT LIKE SHARE A FACEBOOK API-BOL-->
						<?php
						switch( get_locale() ){
							case 'hu_HU' : $lang= 'hu_HU'; 
							break;
							case 'sr_RS' : $lang= 'sr_RS'; 
							break;
							default : $lang= 'en_US';
						}
						?>
						<div id="fb-root"></div>
							<script>
							(function(d, s, id) {
								var js, fjs = d.getElementsByTagName(s)[0];
								if (d.getElementById(id)) return;
								js = d.createElement(s); js.id = id;
								js.src = "//connect.facebook.net/<?php echo $lang;?>/sdk.js#xfbml=1&version=v2.4";
								fjs.parentNode.insertBefore(js, fjs);
							}
							(document, 'script', 'facebook-jssdk'));
							</script>

						<div class="fb-like" data-href="<?php echo get_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div></br></br>

						<div class="fb-comments" data-href="<?php echo get_permalink(); ?>" data-numposts="5"></div>
						<!--KOMMENT LIKE SHARE A FACEBOOK API-BOL - END-->

						
						<div class="clear"></div>

						<?php the_tags('<div class="tags"><span class="label">'.__('Címkék',THEME_DOMAIN).'</span><ul><li>','</li><li>','</li></ul></div><div class="clear"></div>'); ?>

					</div><!-- .post-body -->
					
					<?php if (is_single()) : ?>

						<?php if ( is_active_sidebar( 'post-footer-section' )) : ?>

							<section id="post-footer-section">
								<?php dynamic_sidebar( 'post-footer-section' ); ?>
							</section>

						<?php endif; ?>

					<?php endif; // is_single() for post footer ?>

					<?php
						if (is_single()) :
						
							// this is for popular widgets
							$postID = get_the_ID();
							$count_key = 'post_views_count';
							$count = get_post_meta($postID, $count_key, true);

							if($count != ''){
								update_post_meta($postID, $count_key, ((int) $count) + 1);  
							} else {
								add_post_meta($postID, $count_key, '1', true);        
							}					
							// show next, previous post
							get_template_part( 'content-pagination' );
						endif;

						// comment

						comments_template();
					?>
				</article><!-- #post -->
		<?php endwhile;	?>
	
	</div><?php /*#main*/ ?>

	<?php get_sidebar(); ?>
	<div class="clear"></div>

</div><?php /*#primary*/ ?>

<?php get_footer(); ?>