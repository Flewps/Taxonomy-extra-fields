<?php

defined( 'ABSPATH' ) or die('Don\'t touch the eggs, please!');

function tef_getInstance(){
	
	return TaxonomyExtraFields::init();
	
}