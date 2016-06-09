<?php


use tef\Field\Field;
use tef\Field\NoTypeField;
use tef\Auxiliary\TaxonomyFieldsTable;

function tef_save_field(){
	$form = array();
	
	if(isset($_POST['form'])){
	
		parse_str( $_POST['form'], $form );

		if(!isset($form['unique']) || !isset($form['nonce'])){
			die(0);
		}

		if(!wp_verify_nonce($form['nonce'], 'save_field_'.intval($form['unique']) )){
			die(0);
		}

		/* -- SANITIZE AND CONTROLE REQUIRED FIELDS -- */
		// ID
		if(isset($form['ID'])){
			$ID = intval( $form['ID'] );
		}else{
			$ID = NULL;
		}

		// POSITION
		if(isset($form['position'])){
			$position = intval( $form['position'] );
		}else{
			die(0);
		}

		// TAXONOMY
		if(isset($form['taxonomy'])){
			$taxonomy = sanitize_title( $form['taxonomy'] );
		}else{
			die(0);
		}

		// NAME
		if(isset($form['name'])){
			$name = sanitize_title( $form['name'] );
		}else{
			die(0);
		}

		// LABEL
		if(isset($form['label'])){
			$label = sanitize_text_field( $form['label'] );
		}else{
			die(0);
		}
		
		// DESCRIPTION
		if(isset($form['description'])){
			$description = sanitize_text_field( $form['description'] );
		}else{
			$description = "";
		}
		
		// ID
		$options = array();
		
		// REQUIRED
		if(isset($form['required'])){
			$required = true;
		}else{
			$required = false;
		}

		// TYPE
		if(isset($form['type'])){
			$type = sanitize_title( $form['type'] );
		}else{
			die(0);
		}
		
		// EJECUTE ACTION
		echo Field::save_field($ID, $position, $taxonomy, $name, $label, $description, $options, $required, $type);
		
		die();
		
	}

	die(0);
}
add_action( 'wp_ajax_tef_save_field', 'tef_save_field' );


function tef_get_row_template(){
	
	if(isset($_POST['data'])){
		$data_defaults = array(
			'position' => 0,
			'taxonomy' => 'all',
		);
		
		$data = array();

		parse_str($_POST['data'], $data);
		
		$data = wp_parse_args($data, $data_defaults );
		
		$table = new TaxonomyFieldsTable( $data['taxonomy'] );
		$table->prepare_columns();
		
		$field = new NoTypeField( 0 );
		$field->set_taxonomy( $data['taxonomy'] );
		$field->set_position( $data['position'] );

		$item = array(
			'ID' => 0,
			'taxonomy' => $data['taxonomy'],
			'position' => $data['position'],
			'name' => "",
			'label' => "",
			'type' => "",
			'description' => "",
			'required' => 0,
			'json' => $field->to_JSON(),
		);

		die( $table->single_row( $item ) );
		
	}
	
	die(0);
}
add_action( 'wp_ajax_tef_get_row_template', 'tef_get_row_template' );