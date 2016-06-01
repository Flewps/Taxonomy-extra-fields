<?php
namespace tef;

/**
 *
 * @author GuilleGarcia
 *
 */
class LoadClasses{
	
	static function load_classes(){
		// User Interface
		require_once 'UI/UI.php';
		require_once 'UI/FieldController.php';
		require_once 'UI/TaxonomyController.php';
		require_once 'UI/TaxonomiesListTable.php';
		
		// Fields
		require_once 'Field/Field.php';
		require_once 'Field/FileField.php';
		require_once 'Field/ImageField.php';
		require_once 'Field/LongTextField.php';
		require_once 'Field/NumberField.php';
		require_once 'Field/SelectField.php';
		require_once 'Field/TextField.php';
		
	}
	
}