<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.logicrays.com/
 * @since      1.0.0
 *
 * @package    Wp_Job_Finder
 * @subpackage Wp_Job_Finder/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Job_Finder
 * @subpackage Wp_Job_Finder/includes
 * @author     LogicRays <dipali@logicrays.com>
 */
class Wp_Job_Finder {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Job_Finder_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WP_JOB_FINDER_VERSION' ) ) {
			$this->version = WP_JOB_FINDER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wp-job-finder';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Job_Finder_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Job_Finder_i18n. Defines internationalization functionality.
	 * - Wp_Job_Finder_Admin. Defines all hooks for the admin area.
	 * - Wp_Job_Finder_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-job-finder-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-job-finder-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-job-finder-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-job-finder-public.php';

		$this->loader = new Wp_Job_Finder_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Job_Finder_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_Job_Finder_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wp_Job_Finder_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'job_finder_custom_postType' );
		$this->loader->add_action( 'admin_menu',$plugin_admin, 'add_job_finder_submenu' );
		//CUSTOM META BOX:
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'job_finder_metabox');
		//SAVE CUSTOM META BOX
		$this->loader->add_action( 'save_post', $plugin_admin, 'job_finder_metabox_save');
		//FILTER DEFULT VALUEFOR CUSTOM POST TYPE
		// $this->loader->add_filter( 'default_content', $plugin_admin,  'my_editor_content',10,2 );
		//SAVE NOTIFICATION
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'display_save_notice' );
		//REGISTER SUBMENU /options SETTINGS:
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_job_finder_email_settings' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_job_finder_page_settings' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_job_finder_list_settings' );
		//DATA-TABLE LIST ADD EXTRA FIELD
		// $this->loader->add_filter('manage_edit-job-finder_columns', $plugin_admin, 'my_columns');
		// $this->loader->add_action('manage_posts_custom_column', $plugin_admin,  'my_show_columns');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Job_Finder_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		//SAVE JOB POST FORM DATA :
		$this->loader->add_action("wp_ajax_add_job_data", $plugin_public, "add_job_data_function");
		$this->loader->add_action("wp_ajax_nopriv_add_job_data",$plugin_public,  "add_job_data_function");
		//CHECK LINK WITH POST TYPE :
		$this->loader->add_action( 'wp_head',$plugin_public, 'prefix_admin_add_foobar' );
		//SAVE APPLY JOB USER DATA :
		$this->loader->add_action("wp_ajax_apply_job_user_data", $plugin_public, "apply_job_user_data_function");
		$this->loader->add_action("wp_ajax_nopriv_apply_job_user_data",$plugin_public,  "apply_job_user_data_function");
		//LOAD MORE BUTTON :
		$this->loader->add_action("wp_ajax_show_job_load_more", $plugin_public, "show_job_load_more_function");
		$this->loader->add_action("wp_ajax_nopriv_show_job_load_more",$plugin_public,  "show_job_load_more_function");
		//LOAD MORE BUTTON AFTER FILTER :
		$this->loader->add_action("wp_ajax_load_more_after_search", $plugin_public, "load_more_after_search_function");
		$this->loader->add_action("wp_ajax_nopriv_load_more_after_search",$plugin_public,  "load_more_after_search_function");
		//SHOW SEARCH DATA :
		$this->loader->add_action("wp_ajax_show_job_search_data", $plugin_public, "show_job_search_data_function");
		$this->loader->add_action("wp_ajax_nopriv_show_job_search_data",$plugin_public,  "show_job_search_data_function");

	
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wp_Job_Finder_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
