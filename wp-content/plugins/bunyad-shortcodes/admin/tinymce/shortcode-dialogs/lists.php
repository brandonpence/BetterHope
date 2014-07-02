<?php

$render  = Bunyad::factory('admin/option-renderer');

?>

<?php 
echo $render->render(array(
	'name'  => 'style',
	'label' => __('List Style', 'bunyad-shortcodes'),
	'type'  => 'select',
	'options' => apply_filters('bunyad_shortcodes_list_styles', array(
		'arrow'   => __('Arrow', 'bunyad-shortcodes'),	
		'check'   => __('Check', 'bunyad-shortcodes'),
		'edit'   => __('Edit', 'bunyad-shortcodes'),	
		'folder' => __('Folder', 'bunyad-shortcodes'),
		'file'   => __('File', 'bunyad-shortcodes'),
		'heart'  => __('Heart', 'bunyad-shortcodes'),
	)),
));

?>
	
</p>

<p><a href="#" id="add-more-groups"><?php _e('Add More Items', 'bunyad-shortcodes'); ?></a></p>

<script type="text/html" class="template-group-options">

	<?php echo $render->render(array('name' => 'content[%number%]', 'type' => 'text', 'label' => __('Item <span>%number%</span>:', 'bunyad-shortcodes'))); ?>
	
</script>

<script>
jQuery(function($) {
	$('#add-more-groups').click();
	Bunyad_Shortcodes_Helper.set_handler('advanced');
});
</script>