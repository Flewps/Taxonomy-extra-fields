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
	
	protected $position = '';
	
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
	function __construct($ID=NULL){
		
		if(!is_null($ID) && is_numeric($ID)){
			
			global $wpdb;
			
			$ID = intval( $ID );
			
			$row = $wpdb->get_row( "SELECT * FROM ".TEF_FIELD_TABLE_NAME." WHERE ID = " . $ID, OBJECT );
			
			if($row){
				$this->ID = $row->ID;
				$this->taxonomy = $row->taxonomy;
				$this->label = $row->label;
				$this->name = $row->name;
				$this->description = $row->description;
				$this->required = intval( $row->required );
				$this->options = json_decode( $row->options );
			}
			
		}
			
	}
	
	function get_ID(){
		return $this->ID;
	}
	
	function get_position(){
		return $this->position;
	}
	
	function get_taxonomy(){
		return $this->taxonomy;
	}
		
	function get_name(){
		return $this->name;
	}
		
	function get_label(){
		return $this->label;
	}
		
	function get_description(){
		return $this->description;
	}
		
	function get_options(){
		return $this->options;
	}
		
	function get_required(){
		return $this->required;
	}
		
	function get_type(){
		return $this->type;
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