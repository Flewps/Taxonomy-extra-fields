<?php

defined( 'ABSPATH' ) or die('Don\'t touch the eggs, please!');

require_once 'field_types.php';
require_once 'ajax.php';

/**
 * 
 * @return \tef\Core
 */
function tef_getInstance(){
	
	return \tef\Core::init();
	
}

/**
 * 
 * @return \tef\Core
 */
function get_TEF(){
	return tef_getInstance();
}

/**
 * 
 * @return \tef\UI\UI
 */
function get_TEFUI(){
	return tef_getInstance()->get_UI();
}


function tef_js_translations(){
	echo "<script> var tef = JSON.parse('";
		echo json_encode(array(
			'translations' => array(
				'msg' => array(
					'confirm' => __('Do you want to continue?','tef'),
					'confirm_delete' => __('Do you want remove this field?', 'tef'),
					'save' => __('Save','tef'),
					'accept' => __('Accept','tef'),
					'saved' => __('Saved','tef'),
					'cancel' => __('Cancel','tef'),
				),
				'types' =>  tef_fields_types('names'),
			)
		));
	echo "');</script>";
}
add_action( 'admin_head', 'tef_js_translations' );