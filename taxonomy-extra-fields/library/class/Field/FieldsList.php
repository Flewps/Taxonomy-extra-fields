<?php
namespace tef\Field;

defined( 'ABSPATH' ) or die('Don\'t touch the eggs, please!');

/**
 * Class FieldList
 * @since 0.0.01
 * @author GuilleGarcia
 */
class FieldList{
	
	protected $taxonomy;
	
	protected $fields = array();
	
	function __construct($taxonomy='all'){
		
		$this->taxonomy = $taxonomy;
		
	}
	
	function set_from_db($args=array()){
		global $wpdb;
		$types = tef_getInstance()->get_fields_types();
		$rows = $wpdb->get_results( $wpdb->prepare("SELECT * FROM ".TEF_FIELD_TABLE_NAME." WHERE taxonomy LIKE %s;", $this->taxonomy), ARRAY_A );
		
		if(0 < count( $rows )):
			foreach($rows as $row):
				if(in_array($row['type'], array_keys($types)) && class_exists( $types[$row['type']]['object'] ))
					$this->fields[] = new $types[$row['type']]['object']($row['ID']);
				else
					continue;
			endforeach;
		endif;
	}
	
	function get_fields(){
		return $this->fields;
	}
	
}