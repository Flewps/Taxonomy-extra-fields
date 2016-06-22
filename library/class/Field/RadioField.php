<?php
namespace tef\Field;

defined( 'ABSPATH' ) or die('Don\'t touch the eggs, please!');

/**
 * Class SelectField
 * @since 0.0.01
 * @author GuilleGarcia
 */
class RadioField extends Field{
	
	protected $type = "select";
	
	protected $options = array(
		'multiple' => false,
		'options' => array(),
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
		return true;
	}
	
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \tef\Field\Field::validate_value()
	 */
	function validate_value($value){
		return true;
	}
}