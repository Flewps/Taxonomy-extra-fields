<?php
namespace tef\Field;

defined( 'ABSPATH' ) or die('Don\'t touch the eggs, please!');

/**
 * Class ImageField
 * @since 0.0.01
 * @author GuilleGarcia
 */
class ImageField extends FileField{

	protected $type = "image";

	protected $options = array(
		'multiple' => false,
		'formats' => array('image/*'), // Empty for all
	);

	/**
	 * Constructor
	 */
	function __construct($ID=NULL){

		parent::__construct($ID);

	}

	/**
	 * Checks whether the value corresponds to the specifications
	 * {@inheritDoc}
	 * @see TEF_Field::validate()
	 */
	function validate($value){


	}
}