<?php

class Bunyad_TabbedRecent_Widget extends WP_Widget
{
	public function __construct()
	{
		parent::__construct(
			'bunyad-tabbed-recent-widget',
			'Bunyad - Recent Tabs',
			array('description' => __('Tabs: Recent, category1, category2...', 'bunyad-widgets'), 'classname' => 'tabbed')
		);
		
		add_action('save_post', array($this, 'flush_widget_cache'));
		add_action('deleted_post', array($this, 'flush_widget_cache'));
		add_action('switch_theme', array($this, 'flush_widget_cache'));
		
		// init hook
		add_action('init', array($this, 'init'));
		
	}
	
	public function init() 
	{
		// only in admin cp for form
		if (is_admin()) {
			wp_enqueue_script('widget-tabs', get_template_directory_uri() . '/admin/js/widget-tabs.js');
		}
	}

	// @todo wrap existing widgets with in-memory cache
	public function widget($args, $instance) 
	{
		global $post; // setup_postdata not enough
		
		extract($args);
		extract($instance);
		
		$tabs  = array_combine(array_values($cats), array_values($titles));

		// latest posts
		$posts = $this->get_posts($tabs, $number);
		
		?>

		<?php echo $before_widget; ?>

		<ul class="tabs-list">
		
			<?php
				$count = 0; 
				foreach ($posts as $key => $val): $count++; $active = ($count == 1 ? 'active' : ''); ?>
			
			<li class="<?php echo $active;?>">
				<a href="#" data-tab="<?php echo $key; ?>"><?php echo $tabs[$key]; ?></a>
			</li>
			
			<?php endforeach; ?>
			
		</ul>
		
		<div class="tabs-data">
			<?php
				$i = 0; 
				foreach ($posts as $tab => $tab_posts): $i++; $active = ($i == 1 ? 'active' : ''); ?>
				
			<ul class="tab-posts <?php echo $active; ?> posts-list" id="recent-tab-<?php echo $tab; ?>">
			
				<?php foreach ($tab_posts as $post): setup_postdata($post); ?>

				<li>
				
					<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('thumbnail', array('title' => strip_tags(get_the_title()))); ?></a>
					
					<div class="content">
					
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
							<?php if (get_the_title()) the_title(); else the_ID(); ?></a>
						<time datetime="<?php echo get_the_date('Y-m-d\TH:i:sP'); ?>"><?php echo get_the_date(); ?> </time>
					
					<?php if (class_exists('Bunyad') && Bunyad::options()->review_show_widgets && Bunyad::posts()->meta('reviews')): ?>
					
						<div class="review rateit" data-rateit-readonly="true" 
							data-rateit-value="<?php echo Bunyad::posts()->meta('review_overall'); ?>" data-rateit-ispreset="true"></div>
							
					<?php endif; ?>
					
					</div>
				
				</li>
				
				<?php endforeach; ?>
				
			</ul>
			<?php endforeach; ?>
		
		</div>
		
		<?php echo $after_widget; ?>
		
		<?php
		
		wp_reset_postdata();

	}
	
	public function get_posts($tabs, $number)
	{
		// posts available in cache? - use instance id to suffix
		$cache = get_transient('bunyad_tabbed_recent_posts');
		
		if (is_array($cache) && isset($cache[$this->number])) {
			return $cache[$this->number];
		}

		// get posts
		$args = array('numberposts' => $number);
		foreach ($tabs as $key => $title) {	
			
			$opts = array();
			if ($key !== 0) {
				$opts['cat'] = intval($key); 	
			}
			
			//$query = new WP_Query(array_merge($args, $opts));
			$posts[$key] = get_posts(array_merge($args, $opts));
		}
		
		if (!is_array($cache)) {
			$cache = array();
		}
		
		$cache[ $this->number ] = $posts;
		
		set_transient('bunyad_tabbed_recent_posts', $cache, 60*60*24*30); // 30 days transient cache
		
		return $posts;
	}

	public function flush_widget_cache()
	{
		delete_transient('bunyad_tabbed_recent_posts');
	}
	
	public function update($new, $old)
	{		
		$new['number'] = intval($new['number']);
		
		// delete cache
		$this->flush_widget_cache();

		return $new;
	}
	
	public function form($instance)
	{
		if (!$instance) {
			$instance = array('number' => 4);
		}
		
		extract($instance);
		
	?>		
		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts in each tab:', 'bunyad-widgets'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>
		
		
	<?php
	}
	
}