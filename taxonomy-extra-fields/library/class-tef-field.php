<?php

abstract class TEF_Field{
	
	protected $ID = NULL;
	
	protected $taxomy = '';
	
	protected $name = '';

	protected $label = '';
	
	protected $description = '';
	
	protected $options = array();
	
	protected $required = 0;
	
	abstract protected $type;
	
	function __construct($ID=NULL){
		
		if(!is_null($ID)){
			
			global $wpdb;
			
			$ID = intval( $ID );
			
			$row = $wpdb->get_row( "SELECT * FROM ".TEF_FIELD_TABLE_NAME." WHERE ID = " . $ID, OBJECT );
			
			if($row){
				$this->ID = $row->ID;
				$this->taxomy = $row->taxonomy;
				$this->label = $row->label;
				$this->name = $row->name;
				$this->description = $row->description;
				$this->required = intval( $row->required );
				$this->options = json_decode( $row->options );
			}
			
		}
			
	}
	
	/**
	 * Save the current field
	 * If ID is empty create a new field
	 * Else update the existing field
	 * @return boolean
	 */
	function save(){
		global $wpdb;
		
		if( !$this->validate() )
			return false;
		
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
		
	}
	
	/**
	 * Validate de data of Field Object for create/update
	 */
	abstract function validate();
	
}