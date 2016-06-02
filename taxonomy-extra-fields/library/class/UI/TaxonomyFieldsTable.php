<?php

namespace tef\UI;

defined( 'ABSPATH' ) or die('Don\'t touch the eggs, please!');

use tef\Field\FieldList;

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class TaxonomyFieldsTable extends \WP_List_table{
	
	protected $columns = array();
	protected $columns_hidden = array();
	protected $columns_sortables = array();
	
	function get_columns(){
		
		$this->columns = array(
			'ID' => __('ID','tef'),
			'taxonomy' => __('Taxonomy','tef'),
			'position' => '#',
			'label' => __('Label','tef'),
			'name' => __('Name','tef'),
			'type' => __('Type','tef'),
			'description' => __('Description','tef'),
			'required' => __('Is Required','tef'),
		);
		
		return $this->columns;
	}
	
	function get_columns_hidden(){
		
		$this->columns_hidden = array(
			'ID',
			'required',
			'taxonomy'
		);
		
		return $this->columns_hidden;
		
	}
	
	function get_columns_sortables(){
		$this->columns_sortables = array(
			
		);
		
		return $this->columns_sortables;
	}
	
	function prepare_items() {

		$this->_column_headers = array($this->get_columns(), $this->get_columns_hidden(), $this->get_columns_sortables());

		$fieldList = new FieldList('all');
		$fieldList->set_from_db();
		
		if(0 < count($fields = $fieldList->get_fields())):
			foreach($fields as $field):
				$this->items[] = array(
					'ID' => $field->get_ID(),
					'taxonomy' => $field->get_taxonomy(),
					'position' => $field->get_position(),
					'name' => $field->get_name(),
					'label' => $field->get_label(),
					'type' => $field->get_type(),
					'description' => $field->get_description(),
					'required' => $field->get_required(),
				);
			endforeach;
		endif;

	}
	
	function column_label($item) {
		
		$page = "tef-edit-field";
		$link = '?page='.$page.'&ID='.$item['ID'];

		$actions = array(
			'edit' => '<a href="'.$link.'">'.__('Edit','tef').'</a>',
			//'add-new' => sprintf('<a href="?page=%1$s&taxonomy=%2$s&taxonomy=%3$s">%4$s</a>', 'tef-add-field', $item['taxonomy'], __('Add New','tef')),
			'delete' => sprintf('<a href="?page=%1$s&ID=%2$s">Delete</a>', 'tef-delete-field', $item['ID']),
			
		);
	
		if($item['required'])
			$required = '<span class="required">*</span>';
		else 
			$required = '';
		
		return sprintf('<strong><a class="row-title" href="'.$link.'">%1$s %3$s</a></strong> %2$s', $item['label'], $this->row_actions($actions), $required );
	}
	
	
	function column_default( $item, $column_name ) {
		switch( $column_name ) {
			case 'position':
				return '<span class="sortable-icon dashicons dashicons-menu"></span><input type="hidden" name="field['.$item['ID'].']" value="'.$item[ $column_name ].'" />';
				break;
			case 'type':
				$types = tef_getInstance()->get_fields_types();
				if( in_array($item['type'], array_keys($types) ))
					return $types[$item['type']]['name'];
				else
					return __('Unknow','tef');
				break;
			case 'taxonomy':
			case 'name':
			case 'description':
			case 'required':
				return $item[ $column_name ];
				break;
			default:
				return $item; //Show the whole array for troubleshooting purposes
		}
	}
	
	function no_items() {
		echo '<h2>'.__( 'No fields found.', 'tef' ).' <a class="button button-primary button-large" href="#">'.__('Add new','tef').'</a></h2>';
	}
	
	
}