<?php
namespace tef\Field;

defined( 'ABSPATH' ) or die('Don\'t touch the eggs, please!');

/**
 * Abstract class TEF_Field
 * @since 0.0.01
 * @author GuilleGarcia
 */
abstract class Field{
	
	protected $ID = NULL;
	
	protected $position = 1;
	
	protected $taxonomy = '';
	
	protected $name = '';

	protected $label = '';
	
	protected $description = '';
	
	protected $options = array(
		'pattern' => null, // Regular expresion to validate
		'length' => array(
			'min' => 0, // 0: none
			'max' => 0, // 0: none
		),
		'multiple' => false, // false: unique value | true: multiple values
	);
	
	protected $required = 0;
	
	protected $type;
	
	/**
	 * Constructor
	 * Create a istance
	 * @param integer $ID
	 */
	function __construct($ID = null){
		
		if(is_numeric($ID))
			$this->ID = intval( $ID );	
		
	}
	
	/**
	 * 
	 */
	function get_ID(){
		return $this->ID;
	}

	/**
	 *
	 */
	function get_position(){
		return $this->position;
	}

	/**
	 *
	 */
	function set_position($position){
		if(is_numeric($position))
			$this->position = intval( $position );
	}

	/**
	 *
	 */
	function get_taxonomy(){
		return $this->taxonomy;
	}

	/**
	 *
	 */
	function set_taxonomy($taxonomy){
		
		if(is_string($taxonomy)){
			$taxonomy = sanitize_title( $taxonomy );
			
			if(in_array($taxonomy, get_taxonomies() ))
				$this->taxonomy = $taxonomy;
		}
			
	}

	/**
	 *
	 */
	function get_name(){
		return $this->name;
	}

	/**
	 *
	 */
	function set_name($name){
		if(is_string($name))
			$this->name = sanitize_title( $name );
	}

	/**
	 *
	 */
	function get_label(){
		return $this->label;
	}

	/**
	 *
	 */
	function set_label($label){
		if(is_string($label))
			$this->label = sanitize_text_field( $label );
	}

	/**
	 *
	 */
	function get_description(){
		return $this->description;
	}

	/**
	 *
	 */
	function set_description( $description ){
		if(is_string($description))
			$this->description = sanitize_text_field( $description );
	}

	/**
	 *
	 */
	function get_options(){
		return $this->options;
	}

	/**
	 *
	 */
	function set_options($options){
		
		if(is_array($options)){
			$this->options = wp_parse_args($options, $this->options );
		}
		
	}

	/**
	 *
	 */
	function get_required(){
		return $this->required;
	}

	/**
	 *
	 */
	function si_required(){
		
		if($this->required)
			return true;
		
		return false;
		
	}

	/**
	 *
	 */
	function set_required($boolean){
		
		if($boolean)
			$this->required = 1;
		
		else
			$this->required = 0;
		
	}
	
	/**
	 *
	 */
	function get_type(){
		return $this->type;
	}

	/**
	 *
	 */
	function set_type($type){
		if(is_string($type) && in_array($type, array_keys( tef_fields_types() )))
			$this->type = $type;
	}
		
	/**
	 * Save the current field
	 * If ID is empty create a new field
	 * Else update the existing field
	 * @return boolean
	 */
	function save(){
		global $wpdb;
		
		// Create new
		if(is_null($this->ID))
			return $wpdb->insert(
				TEF_FIELD_TABLE_NAME,
				array(
					'taxonomy' => $this->taxomy,
					'label' => $this->label,
					'name' => $this->name,
					'type' => $this->type,
					'description' => $this->description,
					'required' => $this->required,
					'options' => json_encode( $this->options ),
				),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
					'%s',
				)
			);
		// Update existing
		else
			return $wpdb->update(
				TEF_FIELD_TABLE_NAME,
				array(
					'taxonomy' => $this->taxomy,
					'label' => $this->label,
					'name' => $this->name,
					'type' => $this->type,
					'description' => $this->description,
					'required' => $this->required,
					'options' => json_encode( $this->options ),
				),
				array(
					'ID' => $this->ID,
				),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
					'%s',
				),
				array(
					'$d',
				)
			);
		
	}
	
	/**
	 * Delete the field from DB
	 */
	function delete(){
		global $wpdb;
		
		return $wpdb->delete(
			TEF_FIELD_TABLE_NAME,
			array('ID' => $this->ID),
			array('%d')
		);
	}
	
	
	/**
	 * Validate de data of Field Object for create/update
	 */
	abstract function validate($value);
	
}