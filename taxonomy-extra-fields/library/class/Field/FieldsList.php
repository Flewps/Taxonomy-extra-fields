<?php
namespace tef\Field;

defined( 'ABSPATH' ) or die('Don\'t touch the eggs, please!');

/**
 * Class FieldList
 * @since 0.0.01
 * @author GuilleGarcia
 */
class FieldList{
	
	protected $taxonomy = "all";
	
	protected $fields = array();
	
	/**
	 * 
	 * @param string $taxonomy
	 */
	function __construct($taxonomy = 'all'){
		
		if(is_string($taxonomy))
			$this->taxonomy = sanitize_title( $taxonomy );
		
	}
	
	/**
	 * Set fields from database
	 * @param array $args
	 */
	function set_from_db( $args = array() ){
		global $wpdb;
		$types = tef_fields_types();
		
		$args_default = array(
			'orderby' => 'position',
			'order' => 'ASC',
		);
		
		$args = wp_parse_args($args, $args_default);
		
		$rows = $wpdb->get_results( $wpdb->prepare("SELECT * FROM ".TEF_FIELD_TABLE_NAME." AS tef WHERE tef.taxonomy LIKE %s ORDER BY ".$args['orderby']." ".$args['order']." ;", $this->taxonomy), ARRAY_A );

		if(0 < count( $rows )):
			foreach($rows as $row):
				if(in_array($row['type'], array_keys($types)) && class_exists( $types[$row['type']]['object'] )){
			
					$field = new $types[$row['type']]['object']($row['ID']);
					$field->set_name( $row['name'] );
					$field->set_label( $row['label'] );
					$field->set_required( $row['required'] );
					$field->set_type( $row['type'] );
					$field->set_options( json_decode( $row['options'] ) );
					$field->set_description( $row['description'] );
					$field->set_taxonomy( $row['taxonomy'] );
					$field->set_position( $row['position'] );					
					
					$this->fields[] = $field;
					
				}
					
				else
					continue;
				
			endforeach;
		endif;
	}
	
	/**
	 * Return table fields
	 */
	function get_fields(){
		return $this->fields;
	}
	
}