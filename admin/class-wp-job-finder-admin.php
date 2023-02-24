<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.logicrays.com/
 * @since      1.0.0
 *
 * @package    Wp_Job_Finder
 * @subpackage Wp_Job_Finder/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Job_Finder
 * @subpackage Wp_Job_Finder/admin
 * @author     LogicRays <dipali@logicrays.com>
 */
class Wp_Job_Finder_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Job_Finder_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Job_Finder_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-job-finder-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Job_Finder_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Job_Finder_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-job-finder-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	public function job_finder_custom_postType()
	{
		register_post_type('job-finder', [
			'label'         => __('Job Finder', 'wp-job-finder'),
			'public'        => true,
			'menu_position' => 10,
			'menu_icon'     => 'dashicons-id-alt',
			'supports'      => ['title', 'editor', 'thumbnail', 'author', 'revisions', 'comments'],
			'show_in_rest'  => true,
			'rewrite'       => ['slug' => 'job-finder'],
			'taxonomies'    => ['job-finder-category', 'job-finder-type', 'job-finder-location'],
			'labels' => [
				'singular_name'      => __('job', 'wp-job-finder'),
				'add_new_item'       => __('Add new job', 'wp-job-finder'),
				'new_item'           => __('New job', 'wp-job-finder'),
				'view_item'          => __('View job', 'wp-job-finder'),
				'not_found'          => __('No Job Finder found', 'wp-job-finder'),
				'not_found_in_trash' => __('No Job Finder found in trash', 'wp-job-finder'),
				'all_items'          => __('All Job Finder', 'wp-job-finder'),
				'insert_into_item'   => __('Insert into job', 'Job Finder')
			],		
		]);
	 
		//Add job category
		$labels = array(
			'name'              => _x( 'Job Category', 'taxonomy general name', 'wp-job-finder' ),
			'singular_name'     => _x( 'Job Category', 'taxonomy singular name', 'wp-job-finder' ),
			'search_items'      => __( 'Search Job Category', 'wp-job-finder' ),
			'all_items'         => __( 'All Job Category', 'wp-job-finder' ),
			'parent_item'       => __( 'Parent Job Category', 'wp-job-finder' ),
			'parent_item_colon' => __( 'Parent Job Category:', 'wp-job-finder' ),
			'edit_item'         => __( 'Edit Job Category', 'wp-job-finder' ),
			'update_item'       => __( 'Update Job Category', 'wp-job-finder' ),
			'add_new_item'      => __( 'Add New Job Category', 'wp-job-finder' ),
			'new_item_name'     => __( 'New Job Category Name', 'wp-job-finder' ),
			'menu_name'         => __( 'Job Category', 'wp-job-finder' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'job-finder-category' ),
		);

		register_taxonomy( 'job-finder-category', array( 'job-finder' ), $args );

		unset( $args );
		unset( $labels );

		// Add job type
		$labels = array(
			'name'              => _x( 'Job Type', 'taxonomy general name', 'wp-job-finder' ),
			'singular_name'     => _x( 'Job Type', 'taxonomy singular name', 'wp-job-finder' ),
			'search_items'      => __( 'Search Job Type', 'wp-job-finder' ),
			'all_items'         => __( 'All Job Type', 'wp-job-finder' ),
			'parent_item'       => __( 'Parent Job Type', 'wp-job-finder' ),
			'parent_item_colon' => __( 'Parent Job Type:', 'wp-job-finder' ),
			'edit_item'         => __( 'Edit Job Type', 'wp-job-finder' ),
			'update_item'       => __( 'Update Job Type', 'wp-job-finder' ),
			'add_new_item'      => __( 'Add New Job Type', 'wp-job-finder' ),
			'new_item_name'     => __( 'New Job Type Name', 'wp-job-finder' ),
			'menu_name'         => __( 'Job Type', 'wp-job-finder' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'job-finder-type' ),
		);

		register_taxonomy( 'job-finder-type', array( 'job-finder' ), $args );
		//Job Location
		
		$labels = array(
			'name'              => _x( 'Job location', 'taxonomy general name', 'wp-job-finder' ),
			'singular_name'     => _x( 'Job location', 'taxonomy singular name', 'wp-job-finder' ),
			'search_items'      => __( 'Search Job location', 'wp-job-finder' ),
			'all_items'         => __( 'All Job location', 'wp-job-finder' ),
			'parent_item'       => __( 'Parent Job location', 'wp-job-finder' ),
			'parent_item_colon' => __( 'Parent Job location:', 'wp-job-finder' ),
			'edit_item'         => __( 'Edit Job location', 'wp-job-finder' ),
			'update_item'       => __( 'Update Job location', 'wp-job-finder' ),
			'add_new_item'      => __( 'Add New Job location', 'wp-job-finder' ),
			'new_item_name'     => __( 'New Job location Name', 'wp-job-finder' ),
			'menu_name'         => __( 'Job location', 'wp-job-finder' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'job-finder-location' ),
		);

		register_taxonomy( 'job-finder-location', array( 'job-finder' ), $args );

	}

	//ADD SUBMENU
	public function add_job_finder_submenu()
	{
		//CANDIDATE LIST:
		add_submenu_page(
			'edit.php?post_type=job-finder',
			__( 'Job Application', 'job-finder' ),
			__( 'Job Application', 'job-finder' ),
			'manage_options',
			'job-application-list',
			'job_application_list_function'
		);
		add_submenu_page(
			'edit.php?post_type=job-finder',
			__( 'Settings', 'job-finder' ),
			__( 'Settings', 'job-finder' ),
			'manage_options',
			'job-finder-setting',
			'job_finder_setting_function'
		);
		
	}
	//JOB TYPE METABOX
	function job_finder_metabox() {
		add_meta_box(
			'job_finder_metabox_id',       
			'Job and Company Details',                  
			array($this,'job_meta_box_render_page'),
			'job-finder',                 
			'normal',                  
			'high'                     
		);
	}
	function job_meta_box_render_page()
	{
		require_once plugin_dir_path(__FILE__) . 'partials/wp-job-finder-job-post-metabox.php';
	}
	public function display_save_notice()
	{
		if(isset( $_GET[ 'page' ] ) && 'job-application-list' == $_GET[ 'page' ] && isset( $_GET[ 'action' ] ) && 'bulk-delete' == $_GET[ 'action' ] ){
			echo '<div class="notice notice-success is-dismissible">
					 <p>
						 <strong>Delete Records.</strong>
					 </p>
				 </div>';
		} 

		if(isset( $_GET[ 'page' ] ) && 'job-application-list' == $_GET[ 'page' ] && isset( $_GET[ 'action' ] ) && 'delete' == $_GET[ 'action' ] ){
			echo '<div class="notice notice-success is-dismissible">
					 <p>
						 <strong>Delete Records.</strong>
					 </p>
				 </div>';
		}
	}	
	public function job_finder_metabox_save()
	{
		global $post;
		if(!empty(isset($_POST["company_name"])) ){
			$data =  array(
				'company_name' => $_POST["company_name"],
				'company_description' => $_POST["company_description"],
				'company_mail' => $_POST["company_mail"],
				'phone_no' => $_POST["phone_no"],
				'company_location' => $_POST["company_location"],
				'job_expiry_date' => $_POST['job_expiry_date'],
			);
			update_post_meta($post->ID, 'job_finder_metabox_data', $data);
		}
	}
	function my_columns($columns) {
		$columns['expiry_date'] = 'Expiry Date';
		return $columns;
	}
	function my_show_columns($name) {
		global $post;
		switch ($name) {
			case 'expiry_date':
				$views = get_post_meta($post->ID, 'job_finder_metabox_data', true);
				$date = (!empty($views['expiry_date'])) ? $views['expiry_date'] : '';
		}
	}	
	public function register_job_finder_email_settings()
	{
		register_setting( 'job_finder_email_setting', 'job_finder_email_setting_data' );
	}
	public function register_job_finder_page_settings()
	{
		register_setting( 'job_finder_page_setting', 'job_finder_page_setting_data' );
	}
	public function register_job_finder_list_settings()
	{
		register_setting( 'job_finder_list_setting', 'job_finder_list_setting_data' );
	}
	
}
function job_application_list_function()
{
	
	$jobApplication_ListTable = new Job_Application_Wp_List_Table();
	$jobApplication_ListTable->prepare_items();
	?>
		<div class="wrap">
			<div id="icon-users" class="icon32"></div>
			<h2>Job Application List</h2>
			<form id="job-application-list" method="get">
			<input type="hidden" name="post_type" value="<?php echo  $_REQUEST['post_type'] ?>" />
				<input type="hidden" name="page" value="<?php echo  $_REQUEST['page'] ?>" />
				<?php
					$jobApplication_ListTable->search_box('search', 'search_id');
					$jobApplication_ListTable->display();
				?>
			</form>
		</div>
	<?php
}
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class Job_Application_Wp_List_Table extends WP_List_Table  {

	function __construct() {
		global $status, $page;
		parent::__construct( array(
		'singular' => 'job_application_list', 
		'plural'   => 'job_application_list', 
		'ajax'     => false 
	   ) );
	}
	
    public function prepare_items()
    {	
		global $wpdb;         
        
        $columns = $this->get_columns();

        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $this->process_bulk_action();

        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ) );

        $perPage = 10;
        
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );

        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;

        $user_search_key = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';   
        $this->_column_headers = $this->get_column_info();
        
        $this->handle_table_actions();
    
        $table_data = $this->fetch_table_data();
    
        if( $user_search_key ) {
            $table_data = $this->filter_table_data( $table_data, $user_search_key );
        }	    
    }
    public function get_columns()
    {
		$columns = array(
				'cb'              => '<input type="checkbox" />',
				// 'id'  		  => 'ID',
				'name'            => 'Name',
				'email'           => 'Email',
				// 'applied_for'  => 'Job applied for' ,
				'phone_no'        => 'Phone No',
				'gender'          => 'Gender',
			);
 
		 return $columns;
    }
    
    public function get_hidden_columns()
    {
        return array();
    }

    public function get_sortable_columns()
    {
        $s_columns = array (
            'post_title'    => [ 'post_title', true], 
            'email'         => [ 'email', true],
            'phone_no'      => [ 'phone_no', true],
            //'applied_for' => [ 'applied_for', true],
        );
        return $s_columns;
    }

    //GET THE TABLE DATA
    private function table_data($search = "")
    {
        $data = array();
		global $wpdb;
        $search = ( isset( $_REQUEST['s'] ) ) ? $_REQUEST['s'] : false;
        if (!empty($search)) {
			echo $_REQUEST['s'];
            $serach_Args="SELECT * FROM `wp_postmeta` WHERE `meta_key`= 'job_apply_user_data' ORDER BY `meta_id` DESC
			";
            $search_codes = $wpdb->get_results($serach_Args);
			
            foreach ($search_codes as $mycode){
				$searchdata = unserialize($mycode->meta_value);
				if(in_array($_REQUEST['s'],$searchdata)){
					$data[] =array(
						'id'         => $mycode->post_id,
						'post_title' => $searchdata['username'],
						'email'      => $searchdata['email'],
						'phone_no'   => $searchdata['phone_no'],
						'gender'     => $searchdata['gender'],
					); 
				}
            }
        }else{
			$query = "SELECT * FROM `wp_postmeta` WHERE `meta_key`= 'job_apply_user_data' ORDER BY `meta_id` DESC ";
			$query_codes = $wpdb->get_results($query);
			// echo "<pre>";
			// print_r($query_codes);
			// exit;
            foreach ($query_codes as $value) {
				$userdata = unserialize($value->meta_value);
				$data[] = array(
					'id'          => $value->post_id,
					'post_title'  => $userdata['username'],
					'email'       => $userdata['email'],
					'applied_for' => $userdata['username'],
					'phone_no'    => $userdata['phone_no'],
					'gender'      => $userdata['gender'],
				);
            }
        }        
		return $data;
    }
    public function column_default( $item, $column_name )
    {
		switch( $column_name ) {
			  case 'id':
			  case 'post_title':
			  case 'email':
			  case 'phone_no':
			  case 'gender':
			  case 'date':
				  return $item[ $column_name ];
			  default:
				 return $item[ $column_name ];
		  }
    }

    public function sort_data( $a, $b )
    {
        $orderby = 'post_title';
        $order = 'asc';

        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }
        $result = strcmp( $a[$orderby], $b[$orderby] );

        if($order === 'asc')
        {
            return $result;
        }
        return -$result;
	}

    /**
     * Define our bulk actions
     */
    function column_cb($item){
        return sprintf(
            '<input id="ct-select-'.$item['id'].'" type="checkbox" name="%1$s[]" value="%2$s" >',
            /*$1%s*/ $this->_args['singular'],  
            /*$2%s*/ $item['id']                 
        );
    }
    
	function get_bulk_actions() {
        $actions = [
            'bulk-delete' => 'Delete',
		];
		return $actions;
    }
    function process_bulk_action() {
     
        if(isset($_GET['action']) && isset($_GET['action']) != '')
        {
            global $wpdb;
          	$id = $_GET['data'];
			$wpdb->delete( 'wp_postmeta', array( 'post_id' => $id ) );
        }
        if ( ( isset( $_GET['action'] ) && $_GET['action'] == 'bulk-delete' )
        || ( isset( $_GET['action2'] ) && $_GET['action2'] == 'bulk-delete' )
            ) {	
                $delete_ids = esc_sql( $_GET['job_application_list'] );
                foreach ( $delete_ids as $id ) {
                    global $wpdb;
                    $wpdb->delete( 'wp_postmeta', array( 'post_id' => $id ) );
                }
        }
    }
	  //ADD LINKS[EDIT/DELETE]
	function column_name($item)
	{
		$actions = array(
				'delete'    => sprintf('<a href="?post_type=%s&page=%s&action=%s&data=%s">Delete</a>',$_REQUEST['post_type'],$_REQUEST['page'],'delete',$item['id']),
		);
		return sprintf('%1$s %2$s', $item['post_title'], $this->row_actions($actions));
	}
    function search_box( $text, $input_id ) {
		
        if ( empty( $_REQUEST['s'] ) && ! $this->has_items() ) {
            return;
        }
        $input_id = $input_id . '-search-input';
        if ( ! empty( $_REQUEST['orderby'] ) ) {
            echo '<input type="hidden" name="orderby" value="' . esc_attr( $_REQUEST['orderby'] ) . '" />';
        }
        if ( ! empty( $_REQUEST['order'] ) ) {
            echo '<input type="hidden" name="order" value="' . esc_attr( $_REQUEST['order'] ) . '" />';
        }
        if ( ! empty( $_REQUEST['post_mime_type'] ) ) {
            echo '<input type="hidden" name="post_mime_type" value="' . esc_attr( $_REQUEST['post_mime_type'] ) . '" />';
        }
        if ( ! empty( $_REQUEST['detached'] ) ) {
            echo '<input type="hidden" name="detached" value="' . esc_attr( $_REQUEST['detached'] ) . '" />';
        }
        ?>
        <p class="search-box">
        <label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo $text; ?>:</label>
        <input type="search" id="<?php echo esc_attr( $input_id ); ?>" name="s" value="<?php _admin_search_query(); ?>" />
            <?php submit_button( $text, '', '', false, array( 'id' => 'search-submit' ) ); ?>
        </p>
        <?php
    }
}
function job_finder_setting_function()
{
	require_once plugin_dir_path(__FILE__) . 'partials/wp-job-finder-job-settings.php';
}
