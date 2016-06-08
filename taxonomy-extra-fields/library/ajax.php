<?php


use tef\Field\Field;
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