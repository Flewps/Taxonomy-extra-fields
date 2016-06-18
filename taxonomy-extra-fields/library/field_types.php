<?php
/**
 * Get fields types
 */
function tef_fields_types($field=null){

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
	
	
	if( !is_null( $field ) ){
		$tmp_array = array();
		
		if($field == "names"){

			foreach($types as $type => $obj){
				$tmp_array[$type] = $obj['name'];
			}
			
			return $tmp_array;
		}
		
	}
		
	return $types;
}


function tef_field_template($type){

	switch ($type){
		case 'text':
			return "text.html.twig";
		case 'longtext':
			return "longtext.html.twig";
		case 'number':
			return "number.html.twig";
		case 'image':
			return "image.html.twig";
		case 'file':
			return "file.html.twig";
		case 'select':
			return "select.html.twig";
		default:
			return "text.html.twig";
	}
	
	
}