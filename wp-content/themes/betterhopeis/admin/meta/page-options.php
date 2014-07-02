<?php 

$options = array(
	array(
		'label' => __('Layout Style', 'bunyad'),
		'name'  => 'layout_style', // will be _bunyad_layout_style
		'type'  => 'radio',
		'options' => array(
			'' => __('Default', 'bunyad'),
			'right' => __('Right Sidebar', 'bunyad'),
			'full' => __('Full Width', 'bunyad')),
		'value' => '' // default
	),
	
	array(
		'label' => __('Show Page Title?', 'bunyad'),
		'name'  => 'page_title', 
		'type'  => 'select',
		'options' => array('yes' => 'Yes', 'no' => 'No'),
		'value' => 'yes' // default
	),
	
	array(
		'label' => __('Show Featured Slider?', 'bunyad'),
		'name'  => 'featured_slider',
		'type'  => 'select',
		'options' => array(
			''	=> __('None', 'bunyad'),
			'default' => __('Default Slider - Use Posts Marked as "Featured Slider Post?"', 'bunyad'),
			'default-latest' => __('Default Slider - Use Latest Posts from Whole Site', 'bunyad'),
		),
		'value' => '' // default
	),
);

if (Bunyad::options()->layout_style == 'boxed') {
	
	$options[] = array(
		'label' => __('Custom Background Image', 'bunyad'),
		'name'  => 'bg_image',
		'type' => 'upload',
		'options' => array(
				'type'  => 'image',
				'title' => __('Upload This Picture', 'bunyad'), 
				'button_label' => __('Upload',  'bunyad'),
				'insert_label' => __('Use as Background',  'bunyad')
		),	
		'value' => '', // default
		'bg_type' => array('value' => 'cover'),
	);
}

$options = $this->options(apply_filters('bunyad_metabox_page_options', $options));

?>

<div class="bunyad-meta cf">

<?php foreach ($options as $element): ?>
	
	<div class="option">
		<span class="label"><?php echo esc_html($element['label']); ?></span>
		<span class="field"><?php echo $this->render($element); ?></span>
	</div>
	
<?php endforeach; ?>

</div>

<?php wp_enqueue_script('theme-options', get_template_directory_uri() . '/admin/js/options.js', array('jquery')); ?>