<?php


final class TaxonomyExtraFields{
	
	static public $instance = null;
	
	protected $fields_types = array();
	
	/**
	 * Constructor
	 */
	function __construct(){
		
		$this->init();
	}
	
	/**
	 * Plugin initialization
	 */
	function init(){
		
		add_action('init', array($this,'register_fields_types'), 10);
		
		add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'));
	}
	
	/**
	 * Register all admin scripts (CSS and JavaScript)
	 */
	function register_admin_scripts(){
		wp_register_style( 'tef_admin_style', TEF_DIR . '/assets/css/admin-style.min.css', false, '1.0.0' );
		wp_enqueue_style( 'tef_admin_style' );
	}
	
	/**
	 * Create custom plugin required database tables
	 */
	function create_db_tables(){
		global $wpdb;
		
		$this->fields_table_name = $wpdb->prefix."tef_fields";
		$charset_collate = $wpdb->get_charset_collate();
		
		$sql = "CREATE TABLE ".TEF_FIELD_TABLE_NAME." (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  taxonomy varchar(32) NOT NULL DEFAULT 'all',
		  label VARCHAR(50),
		  name VARCHAR(20),
		  type VARCHAR(20),
		  description LONGTEXT,
		  required TINYINT(1),
		  options LONGTEXT,
		  UNIQUE KEY id (id)
		) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	
	/**
	 * Register the fields types
	 */
	function register_fields_types(){
		
		// Predefined Types
		$types = array(
			'text' => 'TEF_TextField',
			'longtext' => 'TEF_LongtextField',
			'image' => 'TEF_ImageField',
			'file' => 'TEF_FileField',
			'select' => 'TEF_SelectField',
			'number' => 'TEF_NumberField',
		);
		
		// Add your own Field Type on array (key: field identificator, value: class of instance)
		$types = apply_filters( 'tef_fields_types', $types);
		
		// Set the field types;
		$this->types = (array) $types;
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