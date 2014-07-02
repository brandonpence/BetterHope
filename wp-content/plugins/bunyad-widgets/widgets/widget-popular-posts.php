<?php

class Bunyad_PopularPosts_Widget extends WP_Widget
{
	public function __construct()
	{
		parent::__construct(
			'bunyad-popular-posts-widget',
			'Bunyad - Popular Posts',
			array('description' => 'Displays posts with most comments.', 'classname' => 'popular-posts')
		);
	}

	public function widget($args, $instance) 
	{
		extract($args);
		extract($instance);

		$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

		$r = new WP_Query(apply_filters('bunyad_widget_popular_posts_query_args', array('posts_per_page' => $number, 'offset' => 0, 'orderby' => 'comment_count')));
		
		if ($r->have_posts()) :
		?>
			<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			
			<ul class="posts-list">
			<?php  while ($r->have_posts()) : $r->the_post(); global $post; ?>
				<li>
				
					<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('post-thumbnail', array('title' => strip_tags(get_the_title()))); ?>
					
					<?php if (class_exists('Bunyad') && Bunyad::options()->review_show_widgets): ?>
						<?php echo apply_filters('bunyad_review_main_snippet', ''); ?>
					<?php endif; ?>
					
					</a>
					
					<div class="content">
					
						<time datetime="<?php echo get_the_date('Y-m-d\TH:i:sP'); ?>"><?php echo get_the_date(); ?> </time>
					
						<span class="comments"><a href="<?php echo esc_attr(get_comments_link()); ?>"><i class="fa fa-comments-o"></i>
							<?php echo get_comments_number(); ?></a></span>
					
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
							<?php if (get_the_title()) the_title(); else the_ID(); ?></a>
																	
					</div>
				
				</li>
			<?php endwhile; ?>
			</ul>
			
			<?php echo $after_widget; ?>
		
		<?php
			// reset global data
			wp_reset_postdata();

		endif;
	}

	public function update($new, $old) 
	{
		$new['title'] = strip_tags($new['title']);
		$new['number'] = intval($new['number']);

		return $new;
	}

	public function form($instance) 
	{
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bunyad-widgets'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'bunyad-widgets'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
	
}