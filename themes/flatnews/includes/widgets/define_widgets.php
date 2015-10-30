<?php

/*ARTICLE WIDGETS*/
/*###############*/
class News_Article_Box_Widget extends WP_Widget {

	/** Main */
	function __construct() {
		parent::__construct(
			'news_article_box_widget', // Base ID
			'&#10029;&#10029;&#10029;&#10029;&#10029; '. __('News Article Box', THEME_DOMAIN), // Name
			array( 'description' => __('Drag this widget into [&#10132; Break Section] or [&#10132; Flexible Home Layout] to build your home layout', THEME_DOMAIN), ) // Desc
		);
	}


	/** use this function to decide how the widget settings 
	will display in your admin dashboard */
	public function form( $instance ) {
		$title = '';
		if (isset($instance['title'])) {
			$title = esc_attr($instance[ 'title' ]);
		}
		
		$type = 1;
		if (isset($instance['type'])) {
			$type = (int)esc_attr($instance[ 'type' ]);
		}
		
		$from = 1;
		if (isset($instance['from'])) {
			$from = esc_attr($instance[ 'from' ]);
		}
		$from = (int) $from;
		
		$cat = '';
		if (isset($instance['cat'])) {
			$cat = esc_attr($instance['cat']);
		}
		
		$count = 5;
		if (isset($instance['count'])) {
			$count = esc_attr($instance['count']);
		}
		$count = (int) $count;
		
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title', THEME_DOMAIN ); ?> 
			
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('from'); ?>"><?php echo __('Get posts from', THEME_DOMAIN);?>
				<select name="<?php echo $this->get_field_name('from'); ?>" class="widefat">
					<option value="1" <?php if($from==1)  {echo 'selected="selected"';} ?>>A category</option>
					<option value="2" <?php if($from==2)  {echo 'selected="selected"';} ?>>Latest Posts</option>
				</select>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('type'); ?>"><?php echo __('Design type', THEME_DOMAIN);?>
				<select name="<?php echo $this->get_field_name('type'); ?>" class="widefat">
					<option value="1" <?php if($type==1)  {echo 'selected="selected"';} ?>>Hot (Sticky News)</option>
					<option value="2" <?php if($type==2)  {echo 'selected="selected"';} ?>>Break News</option>
					<option value="3" <?php if($type==3)  {echo 'selected="selected"';} ?>>Three Columns</option>
					<option value="4" <?php if($type==4)  {echo 'selected="selected"';} ?>>Dark Rows</option>
					<option value="5" <?php if($type==5)  {echo 'selected="selected"';} ?>>Two Columns</option>
					<option value="6" <?php if($type==6)  {echo 'selected="selected"';} ?>>One Left Columns</option>
					<option value="7" <?php if($type==7)  {echo 'selected="selected"';} ?>>One Right Columns</option>
					<option value="8" <?php if($type==8)  {echo 'selected="selected"';} ?>>Slider</option>
					<option value="9" <?php if($type==9)  {echo 'selected="selected"';} ?>>Combine Columns</option>
				</select>
			</label>
		</p>
		
		
		<p>
			<label for="<?php echo $this->get_field_id('cat'); ?>"><?php echo __( 'Category:' , THEME_DOMAIN );?>
			<?php
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 1,
				'hierarchical'             => 1,
				'taxonomy'                 => 'category');
				$args = get_categories( $args ); 
			?> 	
				<select name="<?php echo $this->get_field_name('cat'); ?>" class="widefat">
				<?php foreach($args as $ar) { ?>
					<option value="<?php echo $ar->cat_name; ?>" <?php if($ar->cat_name==$cat)  {echo 'selected="selected"';} ?>><?php echo $ar->cat_name; ?></option>
				<?php } ?>
				</select>
			
			</label>
		</p>
			
		<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php echo __( 'Post count:' , THEME_DOMAIN );?> <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" /></label></p>
		
		<?php 
	}

	/** use this function to decide the way widget data will
	be saved after admin update widget data */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['cat'] = strip_tags($new_instance['cat']);
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['type'] = strip_tags($new_instance['type']);
		$instance['from'] = strip_tags($new_instance['from']);
		return $instance;
	}
	
	
	/** use this function to decide how the widget
	will display in your theme */
	public function widget( $args, $instance ) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$cat = htmlspecialchars($instance['cat']);
		$count = $instance['count'];
		$type = $instance['type'];
		$from = $instance['from'];
		$category_id = get_cat_ID($cat);
		
		if (!$type) {
			$type = 1;
		}
		$type = (int) $type;
		
		// type map
		$style_map = array('default', 'hot', 'break', 'three', 'dark', 'two', 'left-col', 'right-col', 'slider', 'combine');

		if ($style_map[$type] == 'hot') {
			$count = 3;
		}
		
		/*load post from category*/
		$args=array(
			'ignore_sticky_posts' => true,
			'post_type' => 'post',
			'cat' => $category_id,
			'posts_per_page'=> $count
		);
		/*load post from latest posts*/
		if ($from == 2) {
			$args=array(
			   'posts_per_page'=> $count
			);
		}
		$the_query = new WP_Query($args);
		if ($the_query->have_posts()) : 
			
			echo '<div class="news-box '.$style_map[$type].'">';
			if ($from == 1) {
				echo '<h2 class="title"><a href="'.get_category_link($category_id).'" title="'.__('View all posts', THEME_DOMAIN).'">'.$title.'</a></h2>';
			} else {
				echo '<h2  class="title"><a href="/?s=+&index=post" title="'.__('View all posts', THEME_DOMAIN).'">'.$title.'</a></h2>';
			}
			
			
			echo '<div class="outer"><ul class="content">';
			$counter = 0;
			while ($the_query->have_posts()) : $the_query->the_post();
				// preparing for flexible home layout output
				$item_img_thumbnail = '<a href="'.get_permalink().'" title="'.__('Click to read', THEME_DOMAIN).'" class="item-thumbnail">'.get_post_image(get_the_ID(), 'thumbnail', array('alt' =>'item-thumbnail', 'title' => esc_attr(get_the_title()))).'</a>';
				
				$item_img_medium = '<a href="'.get_permalink().'" title="'.__('Click to read', THEME_DOMAIN).'" class="item-thumbnail">'.get_post_image(get_the_ID(), 'medium', array('alt' =>'item-thumbnail', 'title' => esc_attr(get_the_title()))).'</a>';
				
				$item_img_large = '<a href="'.get_permalink().'" title="'.__('Click to read', THEME_DOMAIN).'" class="item-thumbnail">'.get_post_image(get_the_ID(), 'large', array('alt' =>'item-thumbnail', 'title' => esc_attr(get_the_title()))).'</a>';
				
				$item_title = '<h3 class="title"><a href="'.get_permalink().'" title="'.__('Click to read', THEME_DOMAIN).'">'.get_the_title().'</a></h3>';
				
				$item_snip = get_the_snippet();
				
				$item_meta = '<div class="meta">';
				if (comments_open()) {
					$item_meta .= '<a href="'.get_comments_link().'" class="comment"><i class="icon"></i><span>'.get_comments_number().'</span></a>';
				}
				
				$item_meta .= '<a href="'.get_permalink().'" class="date"><i class="icon"></i><span>'.get_the_date().'</span></a>';
				
				$item_meta .= '</div>';
				
				
				echo '<li class="item item-'.$counter.' item-'.(($counter==0)? 'first':'other').'"><div class="inner">';
				switch ($style_map[$type]) :
					case 'hot':
						echo $item_img_medium.'<div class="body">'.$item_title.(($counter==0)? $item_snip : '').'</div>'.$item_meta;
						break;
					case 'break':
						echo $item_img_thumbnail . $item_title;	
						break;
					case 'three':
						echo $item_img_medium.$item_meta.$item_title.$item_snip;
						break;
					case 'dark':
						echo $item_img_thumbnail.$item_title.$item_meta;
						break;
					case 'two':
					case 'left-col':
					case 'right-col':
					case 'combine':
						echo (($counter==0)? $item_img_medium : $item_img_thumbnail) . $item_title . $item_meta . (($counter==0)? $item_snip : '');
						break;
					case 'slider':
						echo $item_img_large.$item_title;
						break;
				endswitch;
				
				$counter++;
				echo '<div class="clear"></div></div></li>';
			endwhile;
			echo '</ul></div><div class="clear"></div></div>';
		else :?>
			<p><?php echo __( 'No posts where found' , THEME_DOMAIN );?></p>
		<?php
		endif;
		wp_reset_postdata();
		
	}
}

// register News_Article_Box_Widget
add_action('widgets_init', create_function('', 'return register_widget("News_Article_Box_Widget");'));



/*SOCIAL ICONS WIDGETS*/
/*###############*/
class Social_Icons_Widget extends WP_Widget {

	/** Main */
	function __construct() {
		parent::__construct(
			'social_icons_widget', // Base ID
			'&#10029;&#10029;&#10029;&#10029;&#10029; '. __('Social Icons', THEME_DOMAIN), // Name
			array( 'description' => __('Drag this widget into [&#10132; Right Side] sections to display social icons', THEME_DOMAIN), ) // Desc
		);
	}


	/** use this function to decide how the widget settings 
	will display in your admin dashboard */
	public function form( $instance ) {
		$title = '';
		$title = esc_attr($instance[ 'title' ]);
			
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title', THEME_DOMAIN ); ?> 
			
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		
		<?php 
	}

	/** use this function to decide the way widget data will
	be saved after admin update widget data */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	
	
	/** use this function to decide how the widget
	will display in your theme */
	public function widget( $args, $instance ) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		
		echo $before_widget;
		if ($title) {
			echo $before_title . $title . $after_title;
		}
		display_social_list();
		echo $after_widget;
	}
}

// register News_Article_Box_Widget
add_action('widgets_init', create_function('', 'return register_widget("Social_Icons_Widget");'));




/*FEED DATA WIDGETS (POPULAR, RECENT POST, RANDOM POST, RECENT COMMENTS */
/*######################################################################*/
class Feed_Data_Widget extends WP_Widget {

	/** Main */
	function __construct() {
		parent::__construct(
			'feed_data_widget', // Base ID
			'&#10029;&#10029;&#10029;&#10029;&#10029; '. __('Feed Data', THEME_DOMAIN), // Name
			array( 'description' => __('Show popular posts, recent posts, random posts or recent comments', THEME_DOMAIN), ) // Desc
		);
	}


	/** use this function to decide how the widget settings 
	will display in your admin dashboard */
	public function form( $instance ) {
		$title = '';
		if (isset($instance[ 'title' ])) {
			$title = esc_attr($instance[ 'title' ]);
		}
		$from = 1;
		if (isset($instance[ 'from' ])) {
			$from = esc_attr($instance[ 'from' ]);
		}
		$from = (int) $from;
		
		$show_meta = ''; 
		if (isset($instance[ 'meta' ])) {
			$show_meta = esc_attr($instance[ 'meta' ]);
		}
		
		$show_thumbnail = '';
		if (isset($instance[ 'thumbnail' ])) {
			$show_thumbnail = esc_attr($instance[ 'thumbnail' ]);
		}
		
		$count = 5;
		if (isset($instance['count'])) {
			$count = esc_attr($instance['count']);
		}
		$count = (int) $count;
		
		$duration = 1;
		if (isset($instance[ 'duration' ])) {
			$duration = esc_attr($instance[ 'duration' ]);
		}
		$duration = (int) $duration;
		
		$cat = 0;
		if (isset($instance[ 'cat' ])) {
			$cat = $instance[ 'cat' ];
		}
		$cat = (int) $cat;
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title', THEME_DOMAIN ); ?> 
			
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('from'); ?>"><?php echo __('Load Feed From', THEME_DOMAIN);?>
				<select name="<?php echo $this->get_field_name('from'); ?>" class="widefat">
					<option value="1" <?php if($from==1)  {echo 'selected="selected"';} ?>>Popular Posts</option>
					<option value="2" <?php if($from==2)  {echo 'selected="selected"';} ?>>Recent posts</option>
					<option value="3" <?php if($from==3)  {echo 'selected="selected"';} ?>>Random posts</option>
					<option value="4" <?php if($from==4)  {echo 'selected="selected"';} ?>>Recent comments</option>
				</select>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('cat'); ?>"><?php echo __( 'Category');?>
			<?php
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 1,
				'hierarchical'             => 1,
				'taxonomy'                 => 'category');
				$categories = get_categories( $args ); 
			?> 	
				<select name="<?php echo $this->get_field_name('cat'); ?>" class="widefat">
					<option value="0" <?php if($cat==0)  {echo 'selected="selected"';} ?>><?php echo __('All categories'); ?></option>
				<?php foreach($categories as $category) { ?>
					<option value="<?php echo $category->term_id; ?>" <?php if($category->term_id==$cat)  {echo 'selected="selected"';} ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
				</select>
			
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('meta'); ?>">
				<input class="checkbox" type="checkbox" <?php if ( $show_meta ) { echo 'checked';} ?> id="<?php echo $this->get_field_id( 'meta' ); ?>" name="<?php echo $this->get_field_name( 'meta' ); ?>" />   
				<?php echo __('Show Meta', THEME_DOMAIN);?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('thumbnail'); ?>">
				<input class="checkbox" type="checkbox" <?php if ( $show_thumbnail ) { echo 'checked';} ?> id="<?php echo $this->get_field_id( 'thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail' ); ?>" />   
				<?php echo __('Show Thumbnail', THEME_DOMAIN);?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php echo __( 'Post count', THEME_DOMAIN ); ?> 
			
				<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('duration'); ?>"><?php echo __('Duration', THEME_DOMAIN);?>
				<select name="<?php echo $this->get_field_name('duration'); ?>" class="widefat">
					<option value="1" <?php if($duration==1)  {echo 'selected="selected"';} ?>>All Time</option>
					<option value="2" <?php if($duration==2)  {echo 'selected="selected"';} ?>>This Year</option>
					<option value="3" <?php if($duration==3)  {echo 'selected="selected"';} ?>>This Month</option>
					<option value="4" <?php if($duration==4)  {echo 'selected="selected"';} ?>>This Week</option>
				</select>
			</label>
		</p>
		
		<?php 
	}

	/** use this function to decide the way widget data will
	be saved after admin update widget data */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['from'] = strip_tags($new_instance['from']);
		$instance['meta'] = strip_tags($new_instance['meta']);
		$instance['thumbnail'] = strip_tags($new_instance['thumbnail']);
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['duration'] = strip_tags($new_instance['duration']);
		$instance['cat'] = strip_tags($new_instance['cat']);
		return $instance;
	}
	
	
	/** use this function to decide how the widget
	will display in your theme */
	public function widget( $args, $instance ) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $from = $instance['from'];
		if (!$from) {
			$from = 1;
		}
		$from = (int) $from;
		
        $show_meta = $instance['meta'];
        $show_thumbnail = $instance['thumbnail'];
		
		$count = esc_attr($instance['count']);
		if (!$count) {
			$count = 5;
		}
		$count = (int) $count;
		
		$duration = esc_attr($instance[ 'duration' ]);
		if (!$duration) {
			$duration = 1;
		}
		$duration = (int) $duration;
		
		$cat = 0;
		if (isset($instance[ 'cat' ])) {
			$cat = $instance[ 'cat' ];
		}
		$cat = (int) $cat;
		
		
		echo $before_widget;
		if ($title) {
			echo $before_title . $title . $after_title;
		}
		
		

		if ($from != 4) {/*IF QUERY FROM POSTS*/
			/*QUERY*/
			// common query
			$args = array (
				'ignore_sticky_posts' => true,
				'post_type' => 'post',
				'posts_per_page' => $count,
				'order' => 'DESC'
			);
			
			// category select
			if ($cat) {
				$args = wp_parse_args($args, array('cat' => $cat));
			}

			// source query
			if ($from == 1) {//POPULAR POSTS
				$args = wp_parse_args($args, array(
					'meta_key' => 'post_views_count', 
					'orderby' => 'meta_value_num'
				));
			} else if ($from == 3) {// RANDOM POSTS
				$args = wp_parse_args($args, array(
					'orderby' => 'rand'
				));
			}
			
			// time query
			if ($duration == 2) {//1 year ago
				$args = wp_parse_args($args, array(
					'date_query' => array(
						array(
							'column' => 'post_date_gmt',
							'before' => '1 year ago',
						)
					),
				));
			} else if ($duration == 3) {//1 month ago
				$args = wp_parse_args($args, array(
					'date_query' => array(
						array(
							'column' => 'post_date_gmt',
							'before' => '1 month ago',
						)
					),
				));
			} else if ($duration == 4) {//1 week ago
				$args = wp_parse_args($args, array(
					'date_query' => array(
						array(
							'column' => 'post_date_gmt',
							'before' => '1 week ago',
						)
					),
				));
			}
			
			$feed_query = new WP_Query( $args );
			
			// Show HTML
			if ($feed_query->have_posts()) :
				while ( $feed_query->have_posts() ) : $feed_query->the_post();
					$item_thumbnail = '<a href="'.get_permalink().'" title="'.__('Click to read', THEME_DOMAIN).'" class="item-thumbnail">'.get_post_image(get_the_ID(), 'thumbnail', array('alt' =>'item-thumbnail', 'title' => esc_attr(get_the_title()))).'</a>';
					
					$item_title = '<h3 class="title"><a href="'.get_permalink().'" title="'.__('Click to read', THEME_DOMAIN).'">'.get_the_title().'</a></h3>';
				
					$item_meta = '<div class="meta">';
					if (comments_open()) {
						$item_meta .= '<a href="'.get_comments_link().'" class="comment"><i class="icon"></i><span>'.get_comments_number().'</span></a>';
					}
					
					$item_meta .= '<a href="'.get_permalink().'" class="date"><i class="icon"></i><span>'.get_the_date().'</span></a>';
					
					$item_meta .= '</div>';
					
					echo '<div class="item item-'.(($show_thumbnail)? 'thumb' : 'nothumb').'">' . (($show_thumbnail)? $item_thumbnail : '') . $item_title . (($show_meta)? $item_meta : '') . '<div class="clear"></div></div>';
				endwhile;
			else:
				echo '<p><em>Have no posts</em></p>';
			endif;
			wp_reset_postdata();
		} else {/*IF QUERY FROM COMMENTS*/
			$args = array('number' => $count);
			$comments = get_comments($args);
			if (count($comments)): 
				foreach ($comments as $comment) {
					$post_id = $comment->comment_post_ID;
					
					$item_thumbnail = '<a href="'.get_permalink($post_id).'#comment-'.$comment->comment_ID.'" class="comment-avatar">'.get_avatar($comment->comment_author_email,70).'</a>';
					
					$item_title = '<a href="'.get_permalink($post_id).'#comment-'.$comment->comment_ID.'" class="comment-name">'.$comment->comment_author.'</a>';
					
					$item_meta = ' <span>'. __('on', THEME_DOMAIN) . '</span> <a href="'.get_permalink($post_id).'#comment-'.$comment->comment_ID.'" class="comment-post-name">'.get_the_title($post_id).'</a>';
					
					$snip = strip_tags($comment->comment_content);
					if (strlen($snip) > 150) {
						mb_internal_encoding('UTF-8');
						mb_http_output('UTF-8');
						mb_http_input('UTF-8');
						mb_language('uni');
						mb_regex_encoding('UTF-8');
						$snip = mb_substr($snip, 0, 150) . '...';	
					}
					
					$item_snip = ' <span>'. __('said:', THEME_DOMAIN) . '</span><p class="comment-snip">'. $snip . '</p>';
					
					echo '<div class="item recent-comment-item item-'.(($show_thumbnail)? 'thumb' : 'nothumb').'">' . (($show_thumbnail)? $item_thumbnail : '') . '<div class="body">'.$item_title . (($show_meta)? $item_meta : $item_snip) . '</div><div class="clear"></div></div>';
				}
			else:
				echo '<p><em>Have no comments</em></p>';
			endif;
		}
		
		echo $after_widget;
	}
}

// register News_Article_Box_Widget
add_action('widgets_init', create_function('', 'return register_widget("Feed_Data_Widget");'));




/*FLICKR WIDGETS*/
/*###############*/
class Flickr_Widget extends WP_Widget {

	/** Main */
	function __construct() {
		parent::__construct(
			'flickr_widget', // Base ID
			'&#10029;&#10029;&#10029;&#10029;&#10029; '. __('Flickr Widget', THEME_DOMAIN), // Name
			array( 'description' => __('Show your flickr photos, just input flickr ID', THEME_DOMAIN), ) // Desc
		);
	}

	/** use this function to decide how the widget settings 
	will display in your admin dashboard */
	public function form( $instance ) {
		$title = '';
		$title = esc_attr($instance[ 'title' ]);
		$flickr_id = $instance[ 'flickr_id' ];
		$count = $instance[ 'count' ];
			
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title', THEME_DOMAIN ); ?> 
			
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'flickr_id' ); ?>"><?php echo __( 'Flickr ID (ex: 52617155@N08)', THEME_DOMAIN ); ?> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'flickr_id' ); ?>" name="<?php echo $this->get_field_name( 'flickr_id' ); ?>" type="text" value="<?php echo esc_attr( $flickr_id ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php echo __( 'Number images', THEME_DOMAIN ); ?> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
			</label>
		</p>
		
		<?php 
	}

	/** use this function to decide the way widget data will
	be saved after admin update widget data */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['flickr_id'] = strip_tags($new_instance['flickr_id']);
		$instance['count'] = strip_tags($new_instance['count']);
		return $instance;
	}
	
	
	/** use this function to decide how the widget
	will display in your theme */
	public function widget( $args, $instance ) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $count = $instance['count'];
        $flickr_id = $instance['flickr_id'];
		if ($flickr_id) {
			if (!$count) {
				$count = 9;
			}
			$count = (int) $count;
			echo $before_widget;
			if ($title) {
				echo $before_title . $title . $after_title;
			}
			echo '<div class="flickr-photos"><script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count='.$count.'&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user='.$flickr_id.'"></script></div>';
			echo $after_widget;
		}
	}
}

// register News_Article_Box_Widget
add_action('widgets_init', create_function('', 'return register_widget("Flickr_Widget");'));





/*REALTED WIDGETS */
/*###############################################*/
class Related_Post_Widget extends WP_Widget {

	/** Main */
	function __construct() {
		parent::__construct(
			'related_post_widget', // Base ID
			'&#10029;&#10029;&#10029;&#10029;&#10029; '. __('Related Post Widget', THEME_DOMAIN), // Name
			array( 'description' => __('This widget is affect in single post (article page) only. Using this widget to show releated posts of current post', THEME_DOMAIN), ) // Desc
		);
	}


	/** use this function to decide how the widget settings 
	will display in your admin dashboard */
	public function form( $instance ) {
		$title = '';
		$title = esc_attr($instance[ 'title' ]);
				
		$show_meta = esc_attr($instance[ 'meta' ]);
		$show_thumbnail = esc_attr($instance[ 'thumbnail' ]);
		
		$count = esc_attr($instance['count']);
		if (!$count) {
			$count = 3;
		}
		$count = (int) $count;
		
		$duration = esc_attr($instance[ 'duration' ]);
		if (!$duration) {
			$duration = 1;
		}
		$duration = (int) $duration;
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title', THEME_DOMAIN ); ?> 
			
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('meta'); ?>">
				<input class="checkbox" type="checkbox" <?php if ( $show_meta ) { echo 'checked';} ?> id="<?php echo $this->get_field_id( 'meta' ); ?>" name="<?php echo $this->get_field_name( 'meta' ); ?>" />   
				<?php echo __('Show Meta', THEME_DOMAIN);?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('thumbnail'); ?>">
				<input class="checkbox" type="checkbox" <?php if ( $show_thumbnail ) { echo 'checked';} ?> id="<?php echo $this->get_field_id( 'thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail' ); ?>" />   
				<?php echo __('Show Thumbnail', THEME_DOMAIN);?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php echo __( 'Post count', THEME_DOMAIN ); ?> 
			
				<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('duration'); ?>"><?php echo __('Duration', THEME_DOMAIN);?>
				<select name="<?php echo $this->get_field_name('duration'); ?>" class="widefat">
					<option value="1" <?php if($duration==1)  {echo 'selected="selected"';} ?>>All Time</option>
					<option value="2" <?php if($duration==2)  {echo 'selected="selected"';} ?>>This Year</option>
					<option value="3" <?php if($duration==3)  {echo 'selected="selected"';} ?>>This Month</option>
					<option value="4" <?php if($duration==4)  {echo 'selected="selected"';} ?>>This Week</option>
				</select>
			</label>
		</p>
		
		<?php 
	}

	/** use this function to decide the way widget data will
	be saved after admin update widget data */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['meta'] = strip_tags($new_instance['meta']);
		$instance['thumbnail'] = strip_tags($new_instance['thumbnail']);
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['duration'] = strip_tags($new_instance['duration']);
		return $instance;
	}
	
	/** use this function to decide how the widget
	will display in your theme */
	public function widget( $args, $instance ) {
		if (is_single()) :
			extract( $args );
			$title = apply_filters('widget_title', $instance['title']);
			$show_meta = $instance['meta'];
			$show_thumbnail = $instance['thumbnail'];
			
			$count = esc_attr($instance['count']);
			if (!$count) {
				$count = 3;
			}
			$count = (int) $count;
			
			$duration = esc_attr($instance[ 'duration' ]);
			if (!$duration) {
				$duration = 1;
			}
			$duration = (int) $duration;
			
			echo $before_widget;
			if ($title) {
				echo $before_title . $title . $after_title;
			}
			
			// save post for backup later
			global $post;
			$origin_post = $post;

			/*QUERY*/
			// common query
			$args = array (
				'posts_per_page' => $count,
				'order' => 'DESC',
				'orderby' => 'rand',
				'post__not_in' => array($post->ID),
			);
			
			// time query
			if ($duration == 2) {//1 year ago
				$args = wp_parse_args($args, array(
					'date_query' => array(
						array(
							'column' => 'post_date_gmt',
							'before' => '1 year ago',
						)
					),
				));
			} else if ($duration == 3) {//1 month ago
				$args = wp_parse_args($args, array(
					'date_query' => array(
						array(
							'column' => 'post_date_gmt',
							'before' => '1 month ago',
						)
					),
				));
			} else if ($duration == 4) {//1 week ago
				$args = wp_parse_args($args, array(
					'date_query' => array(
						array(
							'column' => 'post_date_gmt',
							'before' => '1 week ago',
						)
					),
				));
			}
			
			$tags = wp_get_post_tags($post->ID);  
			if ($tags) {  /*Get post from tags if post had at least 1 tag*/
				$tag_ids = array();  
				foreach($tags as $tag) {
					$tag_ids[] = $tag->term_id;  
				}
				$args = wp_parse_args($args, array('tag__in' => $tag_ids));
			} else {
				$cat_ids = wp_get_post_categories($post->ID);
				if ($cat_ids) { /*in case empty tags, get from cate*/
					$args = wp_parse_args($args, array('category__in ' => $cat_ids));
				}
				/* else: just random posts */
			}
			$my_query = new WP_Query( $args );
			
			// Show HTML
			if ($my_query->have_posts()) :
				echo '<div class="news-box three related-news"><div class="outer"><ul class="content">';
				$counter = 0;
				while ( $my_query->have_posts() ) : $my_query->the_post();
					// preparing for flexible home layout output
					
					$item_img_medium = '<a href="'.get_permalink().'" title="'.__('Click to read', THEME_DOMAIN).'" class="item-thumbnail">'.get_post_image(get_the_ID(), 'medium', array('alt' =>'item-thumbnail', 'title' => esc_attr(get_the_title()))).'</a>';
					
						
					$item_title = '<h3 class="title"><a href="'.get_permalink().'" title="'.__('Click to read', THEME_DOMAIN).'">'.get_the_title().'</a></h3>';
					
					$item_snip = get_the_snippet();
					
					$item_meta = '<div class="meta">';
					if (comments_open()) {
						$item_meta .= '<a href="'.get_comments_link().'" class="comment"><i class="icon"></i><span>'.get_comments_number().'</span></a>';
					}
					
					$item_meta .= '<a href="'.get_permalink().'" class="date"><i class="icon"></i><span>'.get_the_date().'</span></a>';
					
					$item_meta .= '</div>';
				
				
					echo '<li class="item item-'.$counter.' item-'.(($counter==0)? 'first':'other').'"><div class="inner">';
			
					echo (($show_thumbnail)? $item_img_medium : '').(($show_meta)? $item_meta : '') .$item_title;
						
					echo '<div class="clear"></div></div></li>';
					
					$counter++;
				endwhile;
				echo '</ul></div><div class="clear"></div></div>';
			endif;
			wp_reset_postdata();
			echo $after_widget;
			
			$post = $origin_post;
		endif;// is_single
	}
}

// register News_Article_Box_Widget
add_action('widgets_init', create_function('', 'return register_widget("Related_Post_Widget");'));

?>