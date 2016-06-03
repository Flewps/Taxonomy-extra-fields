<?php

defined( 'ABSPATH' ) or die('Don\'t touch the eggs, please!');

require_once 'field_types.php';

/**
 * 
 * @return \tef\TaxonomyExtraFields
 */
function tef_getInstance(){
	
	return \tef\TaxonomyExtraFields::init();
	
}

/**
 * 
 * @return \tef\TaxonomyExtraFields
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

