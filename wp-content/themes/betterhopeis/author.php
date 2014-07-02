<?php

/**
 * Author Page
 */

get_header();

$authordata = get_userdata(get_query_var('author'));

?>


<div class="main wrap cf">

	<div class="row">
		<div class="col-8 main-content">
		
			<h1 class="main-heading author-title"><?php echo sprintf(__('Author %s', 'bunyad'), '<strong>' . get_the_author() . '</strong>'); ?></h1>

			<?php get_template_part('partial-author'); ?>
	
			<?php get_template_part(Bunyad::options()->author_loop_template); ?>

		</div>
		
		<?php Bunyad::core()->theme_sidebar(); ?>
		
	</div> <!-- .row -->
</div> <!-- .main -->

<?php get_footer(); ?>