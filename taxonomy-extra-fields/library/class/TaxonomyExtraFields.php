<?php
namespace tef;

defined( 'ABSPATH' ) or die('Don\'t touch the eggs, please!');

use \tef\UI\UI;
use \tef\LoadClasses;

/**
 * Class TaxonomyExtraFields
 * @since 0.0.01
 * @author GuilleGarcia
 */
final class TaxonomyExtraFields{
	
	static public $instance = NULL;
	
	private $ui;
	
	protected $fields_types = array();
	
	/**
	 * Constructor
	 */
	function __construct(){
		
		LoadClasses::load_classes();
		
		$this->initialize();
				
		$this->ui = UI::get_istance();
	}
	
	/**
	 * Plugin initialization
	 */
	function initialize(){
		// Register fields types
		add_action('init', array($this,'register_fields_types'), 10);
		
		// Create database tables
		add_action('init', array($this,'create_db_tables'), 10);
		
		// Register scripts (CSS and JS)
		add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'));
	}
	
	/**
	 * Register all admin scripts (CSS and JavaScript)
	 */
	function register_admin_scripts(){
		/*wp_enqueue_style( 'jquery-ui-core' );
		wp_enqueue_style( 'jquery-ui-sortable' );*/
		
		wp_register_script( 'tef_admin_functions', TEF_URL.'/assets/javascript/admin-functions.js', array('jquery','jquery-ui-core','jquery-ui-sortable'), '1.0.0', true );
		wp_enqueue_script( 'tef_admin_functions' );
		
		wp_register_style( 'tef_admin_style', TEF_URL.'/assets/css/admin-style.min.css', false, '1.0.0' );
		wp_enqueue_style( 'tef_admin_style' );
	}
	
	/**
	 * Create custom plugin required database tables
	 */
	function create_db_tables(){
		global $wpdb;
		
		$this->fields_table_name = $wpdb->prefix."tef_fields";
		$charset_collate = $wpdb->get_charset_collate();
		
		$sql = "CREATE TABLE IF NOT EXISTS ".TEF_FIELD_TABLE_NAME." (
		  ID mediumint(9) NOT NULL AUTO_INCREMENT,
		  position smallint(4) NOT NULL DEFAULT 1,
		  taxonomy varchar(32) NOT NULL DEFAULT 'all',
		  label VARCHAR(50),
		  name VARCHAR(20),
		  type VARCHAR(20),
		  description LONGTEXT,
		  required TINYINT(1),
		  options LONGTEXT,
		  PRIMARY KEY ID (ID),
		  UNIQUE KEY ID_position (ID, position)
		) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	
	function get_fields_types(){
		return $this->fields_types;
	}
	
	/**
	 * Register the fields types
	 */
	function register_fields_types(){
		
		// Predefined Types
		$types = array(
			'text' => array(
				'name' => __('Text','tef'),
				'object' => '\tef\Field\TextField',
			),
			'longtext' => array(
				'name' => __('Longtext','tef'),
				'object' => '\tef\Field\LongtextField',
			),
			'number' => array(
				'name' => __('Number','tef'),
				'object' => '\tef\Field\NumberField',
			),
			'image' => array(
				'name' => __('Image','tef'),
				'object' => '\tef\Field\ImageField',
			),
			'file' => array(
				'name' => __('File','tef'),
				'object' => '\tef\Field\FileField',
			),
			'select' => array(
				'name' => __('Selection','tef'),
				'object' => '\tef\Field\SelectField',
			),
		);
		
		// Add your own Field Type on array (key: field identificator, value: class of instance)
		$types = apply_filters( 'tef_fields_types', $types);
		
		
		// Set the field types;
		$this->fields_types = (array) $types;
	}
	
	
	/**
	 * Function that create and return an instance of TaxonomyExtraFields
	 * @return TaxonomyExtraFields
	 */
	static function init(){
		
		if(is_null(self::$instance))
			self::$instance = new self();
		
		return self::$instance;
	}
}