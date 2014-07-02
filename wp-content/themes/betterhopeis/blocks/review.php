<?php

/**
 * Block for review shortcode
 * 
 * Collect criteria and create an average rating to display.
 * 
 * Note: supports microformat schema. Add hreview, reviewer, dtreviewed
 * relevant fields in content.php
 */

$meta = Bunyad::posts()->meta();
$ratings = array();
foreach ($meta as $key => $value)
{
	if (preg_match('/criteria_rating_([0-9]+)$/', $key, $match)) {
		
		$ratings[] = array(
			'number' => $match[1],
			'rating' => $value,
			'label'  => $meta['_bunyad_criteria_label_' . $match[1]]
		);
	}
}

$overall = Bunyad::posts()->meta('review_overall');
$heading = Bunyad::posts()->meta('review_heading');
$type    = Bunyad::posts()->meta('review_type');

// add verdict text 
$verdict = Bunyad::posts()->meta('review_verdict');
$verdict_text = Bunyad::posts()->meta('review_verdict_text');

// container classes
$classes[] = 'review-box';
if ($position == 'top-left') {
	array_push($classes, 'alignleft', 'column', 'half');
}

?>

<section class="<?php echo implode(' ', $classes); ?>">
	<?php if ($heading): ?>
	
	<h3 class="heading"><?php echo esc_html($heading); ?></h3>
	
	<?php endif; ?>
	
	
	<div class="verdict-box">
		<div class="overall">
			<span class="number rating"><span class="value"><?php 
				echo ($type == 'percent' ? round($overall / 10 * 100) . '<span class="percent">%</span>' : $overall); ?></span>
				<span class="best"><span class="value-title" title="10"></span></span>
			</span>
			<span class="verdict"><?php echo $verdict; ?></span>
		</div>
		
		<div class="text summary"><?php echo do_shortcode(wpautop($verdict_text)); ?></div>		
	</div>
	
	
	<ul>
	<?php foreach ((array) $ratings as $rating): 
	
			$percent = round(($rating['rating'] / 10) * 100);
	
			if ($type == 'percent') {
				$rating['rating'] = $percent . ' %';
			}
	?>
	
		<li>
		
			<div class="criterion">
				<span class="label"><?php echo esc_html($rating['label']); ?></span>
				<span class="rating"><?php echo esc_html($rating['rating']); ?></span>
			</div>
			
			<div class="rating-bar"><div class="bar" style="width: <?php echo $percent; ?>%;"></div></div>
		</li>
	
	<?php endforeach; ?>
	
	</ul>
</section>