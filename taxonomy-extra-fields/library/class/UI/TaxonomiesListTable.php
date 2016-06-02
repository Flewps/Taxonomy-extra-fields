<?php

namespace tef\UI;

defined( 'ABSPATH' ) or die('Don\'t touch the eggs, please!');

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class TaxonomiesListTable extends \WP_List_table{
	
	protected $columns = array();
	protected $columns_hidden = array();
	protected $columns_sortables = array();
	
	function get_columns(){
		
		$this->columns = array(
			'taxonomy' => __('Taxonomy','tef'),
			'slug' => __('Slug','tef'),
			'fields'    => __('Custom Fields','tef'),
		);
		
		return $this->columns;
	}
	
	function get_columns_hidden(){
		
		$this->columns_hidden = array(
			'slug',
		);
		
		return $this->columns_hidden;
		
	}
	
	function get_columns_sortables(){
		$this->columns_sortables = array(
			'ID',
		);
		
		return $this->columns_sortables;
	}
	
	function prepare_items($taxonomy) {

		$this->_column_headers = array($this->get_columns(), $this->get_columns_hidden(), $this->get_columns_sortables());

		$this->items[] = array(
			'taxonomy' => __('All Taxonomies','tef'),
			'slug' =>'all',
			'fields'  => rand(0,10),
		);
		
		foreach(get_taxonomies(null, 'objects') as $taxonomy){
			if($taxonomy->show_ui){
				$this->items[] = array(
					'taxonomy' => $taxonomy->label,
					'slug' => $taxonomy->name,
					'fields'  => rand(0,10),
				);
			}
		}

	}
	
	function column_taxonomy($item) {
		
		$page = "tef-manage-taxonomy";
		$manage_link = '?page='.$page.'&taxonomy='.$item['slug'].'&action=manage';

		$actions = array(
			'manage' => '<a href="'.$manage_link.'">'.__('Manage','tef').'</a>',
			'add-new' => sprintf('<a href="?page=%1$s&taxonomy=%2$s&action=%3$s">%4$s</a>',$page,$item['ID'],'add-new', __('Add New','tef')),
		);
	
		return sprintf('<strong><a class="row-title" href="'.$manage_link.'">%1$s</a></strong> %2$s', $item['taxonomy'], $this->row_actions($actions) );
	}
	
	
	function column_default( $item, $column_name ) {
		switch( $column_name ) {
			case 'taxonomy':
			case 'fields':
				return $item[ $column_name ];
			default:
				return $item; //Show the whole array for troubleshooting purposes
		}
	}
	
	
}