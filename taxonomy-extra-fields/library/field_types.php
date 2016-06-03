<?php
/**
 * Get fields types
 */
function tef_fields_types(){

	// Predefined Types
	$types = array(
		'text' => array(
			'name' => __('Text','tef'),
			'object' => '\tef\Field\TextField',
		),
		'longtext' => array(
			'name' => __('Longtext','tef'),
			'object' => '\tef\Field\LongtextField',
		),
		'number' => array(
			'name' => __('Number','tef'),
			'object' => '\tef\Field\NumberField',
		),
		'image' => array(
			'name' => __('Image','tef'),
			'object' => '\tef\Field\ImageField',
		),
		'file' => array(
			'name' => __('File','tef'),
			'object' => '\tef\Field\FileField',
		),
		'select' => array(
			'name' => __('Selection','tef'),
			'object' => '\tef\Field\SelectField',
		),
	);

	// Add your own Field Type on array (key: field identificator, value: class of instance)
	$types = apply_filters( 'tef_fields_types', $types);
	
	return $types;
}