<?php

/**
 * Content Template is used for every post format and used on single posts
 */

// post has review? 
$review = Bunyad::posts()->meta('reviews');

?>

<article id="post-<?php the_ID(); ?>" class="<?php
	// hreview has to be first class because of rich snippet classes limit 
	echo ($review ? 'hreview ' : '') . join(' ', get_post_class()); ?>" itemscope itemtype="http://schema.org/Article">

	<?php if (!is_page() OR Bunyad::posts()->meta('page_title') == 'yes'): // page title can be disabled on pages ?>
	
	<header class="post-header cf">

	<?php if (!Bunyad::posts()->meta('featured_disable')): ?>
		<div class="featured">
			<?php if (get_post_format() == 'gallery'): // get gallery template ?>
			
				<?php get_template_part('partial-gallery'); ?>
				
			<?php elseif (Bunyad::posts()->meta('featured_video')): // featured video available? ?>
			
				<div class="featured-vid">
					<?php echo apply_filters('bunyad_featured_video', Bunyad::posts()->meta('featured_video')); ?>
				</div>
				
			<?php else: // normal featured image ?>
			
				<a href="<?php $url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); echo $url[0]; ?>" title="<?php the_title_attribute(); ?>" itemprop="image">
				
				<?php if (Bunyad::options()->blog_thumb != 'thumb-left'): // normal container width image ?>
				
					<?php if ((!in_the_loop() && Bunyad::posts()->meta('layout_style') == 'full') OR Bunyad::core()->get_sidebar() == 'none'): // largest images - no sidebar? ?>
				
						<?php the_post_thumbnail('main-full', array('title' => strip_tags(get_the_title()))); ?>
				
					<?php else: ?>
					
						<?php the_post_thumbnail('main-slider', array('title' => strip_tags(get_the_title()))); ?>
					
					<?php endif; ?>
					
				<?php else: ?>
					<?php the_post_thumbnail('thumbnail', array('title' => strip_tags(get_the_title()))); ?>
				<?php endif; ?>
				
					<?php
						$caption = get_post(get_post_thumbnail_id())->post_excerpt;
						if (!empty($caption)): // have caption ? ?>
						
						<p class="caption"><?php echo $caption; ?></p>
						
					<?php endif;?>
				
				</a>
				
			<?php endif; ?>
		</div>
	<?php endif; // featured check ?>

		<h1 class="post-title" itemprop="name">
		<?php if (is_singular()): the_title(); else: ?>
		
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
				<?php the_title(); ?></a>
				
		<?php endif;?>
		</h1>
		
		<a href="<?php comments_link(); ?>" class="comments"><i class="fa fa-comments-o"></i> <?php echo get_comments_number(); ?></a>
		
	</header><!-- .post-header -->
	
	<div class="post-meta">
		<span class="posted-by"><?php _ex('By', 'Post Meta', 'bunyad'); ?> 
			<span class="reviewer" itemprop="author"><?php the_author_posts_link(); ?></span>
		</span>
		 
		<span class="posted-on"><?php _ex('on', 'Post Meta', 'bunyad'); ?>
			<span class="dtreviewed">
				<time class="value-datetime" datetime="<?php echo esc_attr(get_the_time('c')); ?>" itemprop="datePublished"><?php echo esc_html(get_the_date()); ?></time>
			</span>
		</span>
		
		<span class="cats"><?php echo get_the_category_list(__(', ', 'bunyad')); ?></span>
			
	</div>
	
	<?php endif; ?>
	
<?php
	// page builder for posts enabled?
	$panels = get_post_meta(get_the_ID(), 'panels_data', true);
	if (!empty($panels) && !empty($panels['grids']) && is_singular()):
?>
	
	<?php Bunyad::posts()->the_content(); ?>

<?php 
	else: 
?>

	<div class="post-container cf">
	
		<div class="post-content-right">
			<div class="post-content description" itemprop="articleBody">
			
				<?php
				if (is_singular() OR !Bunyad::options()->blog_excerpts): 
					Bunyad::posts()->the_content();
				else:
					echo Bunyad::posts()->excerpt();
					
				?>
				
				<?php
				endif;
				?>
			
				<?php wp_link_pages(array(
						'before' => '<div class="main-pagination post-pagination">', 
						'after' => '</div>', 
						'link_before' => '<span>',
						'link_after' => '</span>')); ?>
						
				<?php if (Bunyad::options()->show_tags): ?>
					<div class="tagcloud"><?php the_tags('', ' '); ?></div>
				<?php endif; ?>
			</div><!-- .post-content -->
		</div>
		
	</div>
	
<?php 
	endif; // end page builder blocks test
?>
	
	<?php if (Bunyad::options()->social_share): ?>
	
	<div class="post-share">
		<span class="text"><?php _e('Share.', 'bunyad'); ?></span>
		
		<span class="share-links">

			<a href="http://twitter.com/home?status=<?php echo urlencode(get_permalink()); ?>" class="fa fa-twitter" title="<?php _e('Tweet It', 'bunyad'); ?>">
				<span class="visuallyhidden"><?php _e('Twitter', 'bunyad'); ?></span></a>
				
			<a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" class="fa fa-facebook" title="<?php _e('Share on Facebook', 'bunyad'); ?>">
				<span class="visuallyhidden"><?php _e('Facebook', 'bunyad'); ?></span></a>
				
			<a href="http://plus.google.com/share?url=<?php echo urlencode(get_permalink()); ?>" class="fa fa-google-plus" title="<?php _e('Share on Google+', 'bunyad'); ?>">
				<span class="visuallyhidden"><?php _e('Google+', 'bunyad'); ?></span></a>
				
			<a href="http://pinterest.com/pin/create/button/?url=<?php 
				echo urlencode(get_permalink()); ?>&amp;media=<?php echo urlencode(wp_get_attachment_url(get_post_thumbnail_id($post->ID))); ?>" class="fa fa-pinterest"
				title="<?php _e('Share on Pinterest', 'bunyad'); ?>">
				<span class="visuallyhidden"><?php _e('Pinterest', 'bunyad'); ?></span></a>
				
			<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink()); ?>" class="fa fa-linkedin" title="<?php _e('Share on LinkedIn', 'bunyad'); ?>">
				<span class="visuallyhidden"><?php _e('LinkedIn', 'bunyad'); ?></span></a>
				
			<a href="http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink()) ?>&amp;name=<?php echo urlencode(get_the_title()) ?>" class="fa fa-tumblr"
				title="<?php _e('Share on Tumblr', 'bunyad'); ?>">
				<span class="visuallyhidden"><?php _e('Tumblr', 'bunyad'); ?></span></a>
				
			<a href="mailto:?subject=<?php echo rawurlencode(get_the_title()); ?>&amp;body=<?php echo rawurlencode(get_permalink()); ?>" class="fa fa-envelope-o"
				title="<?php _e('Share via Email', 'bunyad'); ?>">
				<span class="visuallyhidden"><?php _e('Email', 'bunyad'); ?></span></a>
			
		</span>
	</div>
	
	<?php endif; ?>
		
</article>


<?php if (is_single() && Bunyad::options()->author_box) : // author box? ?>

	<h3 class="section-head"><?php _e('About Author', 'bunyad'); ?></h3>

	<?php get_template_part('partial-author'); ?>

<?php endif; ?>

<?php if (is_single() && Bunyad::options()->related_posts && ($posts = Bunyad::posts()->get_related(Bunyad::core()->get_sidebar() == 'none' ? 3 : 3))): // && Bunyad::options()->related_posts != false): ?>

<section class="related-posts">
	<h3 class="section-head"><?php _e('Related Posts', 'bunyad'); ?></h3> 
	<ul class="highlights-box three-col related-posts">
	
	<?php foreach ($posts as $post): setup_postdata($post); ?>
	
		<li class="highlights column one-third">
			
			<article>
					
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="image-link">
					<?php the_post_thumbnail(
						(Bunyad::core()->get_sidebar() == 'none' ? 'main-block' : 'gallery-block'),
						array('class' => 'image', 'title' => strip_tags(get_the_title()))); ?>

					<?php if (get_post_format()): ?>
						<span class="post-format-icon <?php echo esc_attr(get_post_format()); ?>"><?php
							echo apply_filters('bunyad_post_formats_icon', ''); ?></span>
					<?php endif; ?>
				</a>
				
				<div class="meta">
					<time datetime="<?php echo get_the_date(__('Y-m-d\TH:i:sP', 'bunyad')); ?>"><?php echo get_the_date(); ?> </time>
					
					<?php echo apply_filters('bunyad_review_main_snippet', ''); ?>
										
					<span class="comments"><i class="fa fa-comments-o"></i>
						<?php echo get_comments_number(); ?></span>	
					
				</div>
				
				<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				
			</article>
		</li>
		
	<?php endforeach; wp_reset_postdata(); ?>
	</ul>
</section>

<?php endif; ?>
