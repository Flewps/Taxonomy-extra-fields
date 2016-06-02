<?php
namespace tef\UI;

use \tef\UI\FieldController;

/**
 * Create and manage User Interface
 * 
 * @author Guillermo
 *
 */
class UI{
	
	public static $istance;
	
	protected $twig_loader;
	protected $twig;
	
	protected $admin_pages = array();
	protected $hidden_admin_pages = array();
	
	function __construct(){
		$this->init();
	}
	
	function init(){
		
		// Register menus
		add_action('admin_menu', array($this, 'register_menus'), 10);
	}
	
	function register_menus(){
		
		$this->admin_pages = array(
			// Principal Plugin Menu
			array(
				'page_title' => __('Taxonomy Extra Fields','tef'),
				'menu_title' => __('Taxonomy Extra Fields','tef'),
				'capability' => 'manage_options',
				'menu_slug' => 'taxonomy-extra-fields',
				'function' => array(new TaxonomyController, 'listAction'),
				'icon_url' => 'dashicons-smiley',
				'position' => '50',
				// Subpages
				'subpages' => array(
					array(
						'page_title' => __('Credits','tef'),
						'menu_title' => __('Credits','tef'),
						'capability' => 'manage_options',
						'menu_slug' => 'taxonomy-extra-fields-credits',
						'function' => array($this, 'credits_view'),
					),
				),
			),
			
			/*
			 * TEMPLATE:
			array(
				'page_title' => __('','tef'),
				'menu_title' => __('','tef'),
				'capability' => '',
				'menu-slug' => '',
				'function' => array(),
				'icon_url' => '',
				'position' => '',
				'subpages' => array(
					array(
						'page_title' => __('','tef'),
						'menu_title' => __('','tef'),
						'capability' => '',
						'menu-slug' => '',
						'function' => array(),
					),
				),
			),
			*/
		);
		
		// Create pages
		if(0 < count( $this->admin_pages )){
			foreach($this->admin_pages as $page){
					
				add_menu_page($page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['function'], $page['icon_url'], $page['position']);
		
				if(isset($page['subpages']) && 0 < count($page['subpages'])){
					foreach($page['subpages'] as $subpage){
						add_submenu_page($page['menu_slug'],$subpage['page_title'],$subpage['menu_title'],$subpage['capability'],$subpage['menu_slug'],$subpage['function']);
					}
				}
		
			}
		}
		
		
		// HIDDEN PAGES
		$this->hidden_admin_pages = array(
			array(
				'page_title' => __('Manage Taxonomies','tef'),
				'menu_title' => __('Manage Taxonomies','tef'),
				'capability' => 'manage_options',
				'menu_slug' => 'tef-manage-taxonomy',
				'function' => array(new TaxonomyController, 'controller'),
			),
			array(
				'page_title' => __('Edit Field','tef'),
				'menu_title' => __('Edit Field','tef'),
				'capability' => 'manage_options',
				'menu_slug' => 'tef-edit-field',
				'function' => array(new FieldController, 'editAction'),
			),
			array(
				'page_title' => __('Delete Field','tef'),
				'menu_title' => __('Delete Field','tef'),
				'capability' => 'manage_options',
				'menu_slug' => 'tef-delete-field',
				'function' => array(new FieldController, 'deleteAction'),
			),
		);
		
		if(0 < count($this->hidden_admin_pages)){
			foreach($this->hidden_admin_pages as $page){
				add_submenu_page('options-writing.php',$page['page_title'],$page['menu_title'],$page['capability'],$page['menu_slug'],$page['function']);
			}
		}
		
	}
	
	// VIEWS
	function welcome_view(){
	
	}
	
	function credits_view(){
		
	}
	
	/**
	 * Render the view (if exists)
	 * @param string $path: Ex: admin/manage-field
	 * @param array $data
	 * @return string
	 */
	function render( $path, $data=array() ){
		
		require_once TEF_DIR . 'vendor/Twig/Autoloader.php';
		
		\Twig_Autoloader::register();
		
		$templates_dir = TEF_DIR .'assets/templates';
		$file_name = $path . '.html.twig';
		$file_dir = $templates_dir . '/' . $file_name;
		
		if(file_exists( $file_dir )){
			
			$this->twig_loader = new \Twig_Loader_Filesystem($templates_dir);
			$this->twig = new \Twig_Environment($this->twig_loader, array(
				//'cache' => TEF_DIR . '/cache',
			));
			
			return $this->twig->render($file_name,$data);
			
		}
		
		
		
	}
	
	public static function get_istance(){
		if(is_null( self::$istance ))
			self::$istance = new self();
		
		return self::$istance;
	}
	
}