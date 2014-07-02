<!DOCTYPE html>

<!--[if IE 8]> <html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]> <html class="ie ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<head>

<?php 
/*
 * Match wp_head() indent level
 */
?>

<meta charset="<?php bloginfo('charset'); ?>" />
<title><?php wp_title(''); // stay compatible with SEO plugins ?></title>

<?php if (!Bunyad::options()->no_responsive): // don't add if responsiveness disabled ?> 
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php endif; ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
<?php if (Bunyad::options()->favicon): ?>
<link rel="shortcut icon" href="<?php echo esc_attr(Bunyad::options()->favicon); ?>" />	
<?php endif; ?>

<?php if (Bunyad::options()->apple_icon): ?>
<link rel="apple-touch-icon-precomposed" href="<?php echo esc_attr(Bunyad::options()->apple_icon); ?>" />
<?php endif; ?>
	
<?php wp_head(); ?>
	
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

</head>

<body <?php body_class(); ?>>

<div class="main-wrap">

<?php if (!Bunyad::options()->disable_topbar): ?>
	<div class="top-bar">

		<div class="wrap">
			<section class="top-bar-content">
			
				<?php if (!Bunyad::options()->disable_topbar_ticker): ?>
				<div class="trending-ticker">
					<span class="heading"><?php echo Bunyad::options()->topbar_ticker_text; // filtered html allowed for admins ?></span>

					<ul>
						<?php $query = new WP_Query('orderby=date&order=desc'); ?>
						
						<?php while($query->have_posts()): $query->the_post(); ?>
						
							<li><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
						
						<?php endwhile; ?>
						
						<?php wp_reset_postdata(); ?>
					</ul>
				</div>
				<?php endif; ?>

				<div class="search">
					<form action="<?php echo esc_url(home_url('/')); ?>" method="get">
						<input type="text" name="s" class="query" value="<?php the_search_query(); ?>" placeholder="<?php _e('Search...', 'bunyad'); ?>" />
						<button class="search-button" type="submit"><i class="fa fa-search"></i></button>
					</form>
				</div> <!-- .search -->

				<?php dynamic_sidebar('top-bar'); ?>
				
			</section>
		</div>
		
	</div>
<?php endif; ?>

	<div id="main-head" class="main-head">
		
		<div class="wrap">
		
			<header>
				<div class="title">
				
				<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
				<?php if (Bunyad::options()->image_logo): // custom logo ?>
					
					<img src="<?php echo esc_attr(Bunyad::options()->image_logo); ?>" class="logo-image" alt="<?php 
						 echo esc_attr(get_bloginfo('name', 'display')); ?>" <?php 
						 echo (Bunyad::options()->image_logo_retina ? 'data-at2x="'. Bunyad::options()->image_logo_retina .'"' : ''); 
					?> />
						 
				<?php else: ?>
					<?php echo do_shortcode(Bunyad::options()->text_logo); ?>
				<?php endif; ?>
				</a>
				
				</div>
				
				<div class="right">
					<?php 
						dynamic_sidebar('header-right');
					?>
				</div>
			</header>
			
			<nav class="navigation cf" data-sticky-nav="<?php echo Bunyad::options()->sticky_nav; ?>">
				<div class="mobile"><a href="#" class="selected"><span class="text"><?php _e('Navigate', 'bunyad'); ?></span><span class="current"></span> <i class="fa fa-bars"></i></a></div>
				
				<?php wp_nav_menu(array('theme_location' => 'main', 'fallback_cb' => '', 'walker' =>  'Bunyad_Menu_Walker')); ?>
			</nav>
			
		</div>
		
	</div>
	
<?php if (!Bunyad::options()->disable_breadcrumbs): ?>
	<div class="wrap">
		<?php Bunyad::core()->breadcrumbs(); ?>
	</div>
<?php endif; ?>