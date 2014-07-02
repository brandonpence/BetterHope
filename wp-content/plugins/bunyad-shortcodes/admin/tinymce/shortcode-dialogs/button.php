<?php
$render  = Bunyad::factory('admin/option-renderer');

$button_colors = (array) Bunyad_ShortCodes::getInstance()->get_config('button_colors');
$button_colors = array_combine($button_colors, array_map('ucfirst', $button_colors));

// all the attributes
$options = array(
	array(
		'label' => __('Link To', 'bunyad-shortcodes'),
		'type'  => 'text',
		'name'  => 'link',
		'html_post_output' => '<span class="help">' . __('Example: http://google.com.', 'bunyad-shortcodes') . '</span>'
	),
	
	array(
		'label' => __('Button Text', 'bunyad-shortcodes'),
		'type'  => 'text',
		'name'  => 'enclose'
	),
	
	array(
		'label' => __('Preset Styles', 'bunyad-shortcodes'),
		'type'  => 'select',
		'name'  => 'preset',
		'options' => $button_colors,
		'html_post_output' => '<span class="help">'. __('Either choose a pre-defined style or customize below.') .'</span>'
	),
	
	array(
		'type' => 'html',
		'html' => '<div class="divider-or"><span>' .  __('Or Customize (Optional)', 'bunyad-shortcodes') . '</span></div>'
	),
	
	array(
		'label' => __('Text Color', 'bunyad-shortcodes'),
		'type'  => 'color',
		'name'  => 'text_color'
	),
	
	array(
		'label' => __('Background Color', 'bunyad-shortcodes'),
		'type'  => 'color',
		'name'  => 'color',
		''
	)
);

foreach ($options as $option) {
	echo $render->render($option);
}

?>

<script>
jQuery(function($) {

	// replace customized color - this will be hooked before main handler
	var button_handler = function() {

		var bg_color = $(this).find('input[name=color]'),
			preset = $(this).find('select[name=preset]');
		
		if (bg_color.val() == '') {
			bg_color.val(preset.val());
		}

		preset.remove();

		// don't return false or it will stop propagation
	};

	$('form.bunyad-sc-visual').unbind('submit');
	$('form.bunyad-sc-visual').submit(button_handler);
	$('form.bunyad-sc-visual').submit(Bunyad_Shortcodes_Helper.simple_shortcodes);
});
</script>
