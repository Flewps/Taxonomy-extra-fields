<?php
namespace tef\UI;

defined( 'ABSPATH' ) or die('Don\'t touch the eggs, please!');

use \tef\UI\TaxonomyListTable;

/**
 *
 * @author GuilleGarcia
 *
 */
class TaxonomyController{
	
	protected $actions = array(
		'list',
	);
	
	function controller(){
		
		$action = $_GET['action'];
		
		if(method_exists($this, $action.'Action'))
			$this->{$action.'Action'}();
		
	}
	
	/**
	 * 
	 */
	function listAction(){
	
		$table = new TaxonomiesListTable();
		
		$table->prepare_items();
		
		/*
		echo "<pre>";
		print_r(get_taxonomies(null, 'objects'));
		echo "</pre>";
		*/
		
		$data = array(
			'title' => 'Taxonomy Extra Fields',
			'table' => $table,
		);
		
		echo UI::get_istance()->render('admin/select-taxonomy', $data);
	}
	
	function manageAction(){
		
		
		$taxonomy = $_GET['taxonomy'];
		if('all' != $taxonomy)
			$taxonomy = get_taxonomy( $taxonomy );
		else
			$taxonomy = (object) array(
				'name' => 'all',
				'label' => __('All Taxonomies','tef'),
			);
			
		$data = array(
			'title' => sprintf( __('Taxonomy: %s','tef'), $taxonomy->label),
			'taxonomy' => $taxonomy,
		);
		
		echo UI::get_istance()->render('admin/manage-taxonomy', $data);
	}
	

}