<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.logicrays.com/
 * @since      1.0.0
 *
 * @package    Wp_Job_Finder
 * @subpackage Wp_Job_Finder/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Job_Finder
 * @subpackage Wp_Job_Finder/public
 * @author     LogicRays <dipali@logicrays.com>
 */
class Wp_Job_Finder_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		add_shortcode( 'post-job-form', array($this, 'post_job_form_function') );
		add_shortcode( 'show-all-job' , array($this, 'show_all_job_function') );
		add_shortcode( 'apply-now'    , array($this, 'apply_now_function') );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-job-finder-public.css', array(), $this->version, 'all' );
		wp_enqueue_style('bootstrap-min', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), 'all' );
		wp_enqueue_style('design-iconic', plugin_dir_url( __FILE__ ) . 'css/material-design-iconic-font.min.css',array(),'all');
		wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css' );
		wp_enqueue_script( 'job-finder', plugin_dir_url( __FILE__ ) . 'js/wp-job-finder-public.js', array('jquery'),$this->version, false );
		wp_localize_script( 'job-finder', 'job_finder_object',
			array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jquery.min.js', array( 'jquery' ),false );
		wp_enqueue_script( 'jquery-validate', plugin_dir_url( __FILE__ ) . 'js/jquery.validate.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'job-finder', plugin_dir_url( __FILE__ ) . 'js/wp-job-finder-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'sweetalert2', plugin_dir_url( __FILE__ ) . 'js/sweetalert2.js', array( 'jquery' ), $this->version, false );
	}
	//POST JOB SHORTCODE FUNCTION
	public function post_job_form_function()
	{
		if(!is_admin() && !wp_doing_ajax()){
			ob_start();
			require_once plugin_dir_path(__FILE__) . 'partials/wp-job-finder-job-post-form.php';
			return ob_get_clean();
		}
	}
	public function add_job_data_function()
	{
		if(!empty('job_title')){
			$content .= $_POST['formData']['job_description'].'<br>'.'[job-apply]';
			$post_id = wp_insert_post(array(
				'post_title'     => $_POST['formData']['job_title'], 
				'post_content'   => $content,
				'post_type'      =>'job-finder', 
				'post_status'    =>'publish'
			));
			
			$data = array(
				'company_name'        => $_POST['formData']['company_name'], 
				'company_description' => $_POST['formData']['company_description'],
				'company_mail'        => $_POST['formData']['company_mail'],
				'phone_no'            => $_POST['formData']['phone_no'],
				'company_location'    => $_POST['formData']['company_location'],
				'expiry_date'         => $_POST['formData']['expiry_date'],
			); 
		
			$category = $_POST['job_category'];
			$type     = $_POST['job_type'];
			$location = $_POST['job_location'];

			$cat_taxonomy       = 'job-finder-category';
			$type_taxonomy      = 'job-finder-type';
			$location_taxonomy  = 'job-finder-location';

			wp_set_object_terms( $post_id, intval( $category ), $cat_taxonomy );
			wp_set_object_terms( $post_id, intval( $type ), $type_taxonomy );
			wp_set_object_terms( $post_id, intval( $location ), $location_taxonomy );
			
			update_post_meta($post_id,'job_finder_metabox_data',$data);

			$result         = array();
			$result['data'] = 'success';
			$result['msg']  = "Job Post Successfully";
		}
		echo json_encode($result);	
		exit;
	}
	public function show_all_job_function()
	{
		if(!is_admin() && !wp_doing_ajax()){
			ob_start();
			require_once plugin_dir_path(__FILE__) . 'partials/wp-job-finder-show-all-job.php';
			return ob_get_clean();
		}
	}
	public function job_apply_function()
	{
		if(!is_admin() && !wp_doing_ajax()){
			ob_start();
			require_once plugin_dir_path(__FILE__) . 'partials/wp-job-finder-apply-form.php';
			return ob_get_clean();
		}
	}
	
	public function prefix_admin_add_foobar()
	{
		add_shortcode( 'job-apply', array( $this, 'job_apply_function' ) );
	}
	public function apply_job_user_data_function()
	{
		if(!empty($_POST['formData']['username'])){
			$id =  $_POST['formData']['id'];
			$user_data = array(
				'username'  => $_POST['formData']['username'],
				'email'     => $_POST['formData']['email'],
				'message'   => $_POST['formData']['message'],
				'phone_no'  => $_POST['formData']['phone_no'],
				'upload_cv' => $_POST['formData']['username'],
				'gender'    => $_POST['formData']['gender'],
			);
			add_post_meta($id,'job_apply_user_data',$user_data);
			//SEND MAIL START

			$shortcodes = array(		
				"[user-name]", 
				"[user-email]", 
			);
			$data = array(		
				'username' => $_POST['formData']['username'],
				'email'    => $_POST['formData']['email'],
			);
			$user_op = get_option('job_finder_page_setting_data');
			
			if($user_op['is_enable'] == "yes"){

				$subject = str_replace( $shortcodes, $data, $user_op['user_template_heading']);		
				$message = str_replace( $shortcodes, $data, $user_op['user_template_msg']);
				$to 	 = $_POST['formData']['email'];
				$headers = 'From: '. $_POST['formData']['email'] . "\r\n" .
						   'Reply-To: ' . $_POST['formData']['email'] . "\r\n";
				$sent    = wp_mail($to, $subject, strip_tags($message), $headers);
			}
			//SEND MAIL END
			$result         = array();
			$result['data'] = 'success';
			$result['msg']  = "Job applied Successfully";
			echo json_encode($result);	
			exit;
		}
	}
	function show_job_load_more_function()
	{
		$ajaxposts = new WP_Query([
			'post_type' 	 => 'job-finder',
			'posts_per_page' => 3,
			'orderby' 		 => 'date',
			'order' 		 => 'DESC',
			'paged'          => $_POST['paged'],
		]);
		$response = '';
		$i=0;
		if($ajaxposts->have_posts()): 
			while ($ajaxposts->have_posts()): $ajaxposts->the_post();
				get_data($post->ID);
		 	endwhile; 
		endif;
		wp_reset_postdata();
		echo $response;  
		exit;	
	}
	public function load_more_after_search_function()
	{
		$postId   = (!empty($_POST['job_post_id'])) ? $_POST['job_post_id'] : '';
		$kewords  = (!empty($_POST['keywords'])) 	? $_POST['keywords'] : '';
		$location = (!empty($_POST['location'])) 	? $_POST['location'] : '';
		$job_type = (!empty($_POST['job_type'])) 	? $_POST['job_type'] : '';

		if($kewords && $location && $job_type){
			$args = array(
				"post_type" 		=> "job-finder", 
				'post_status'       => 'publish',
				'posts_per_page'    => -1,
				"s" 				=> $kewords,
				'post__not_in'      => $postId,
				'tax_query' => array(
					'relation' => 'IN',
					array(
						'taxonomy' => 'job-finder-location',
						'field'    => 'slug',
						'terms'    => $location,
					),
					array(
						'taxonomy' => 'job-finder-type',
						'field'    => 'slug',
						'terms'    => $job_type,
					),
				)	
			);
		}
		elseif( $kewords || $location ){
			$args = array(
				"post_type" 		=> "job-finder", 
				'post_status'       => 'publish',
				'posts_per_page'    => -1,
				"s" 				=> $kewords,
				'post__not_in'      => $postId,
				'tax_query' => array(
					array(
						'taxonomy' => 'job-finder-location',
						'field'    => 'slug',
						'terms'    => $location,
					),
				)	
			);
		}
		elseif( $kewords || $job_type ){
			$args = array(
				"post_type" 		=> "job-finder", 
				'post_status'       => 'publish',
				'posts_per_page'    => -1,
				"s" 				=> $kewords,
				'post__not_in'      => $postId,
				array(
						'taxonomy' => 'job-finder-type',
						'field'    => 'slug',
						'terms'    => $job_type,
					),	
			);
		}
		elseif( $location && $job_type ){
			$args = array(
				'post_type' => 'job-finder',
				'post_status'       => 'publish',
				'posts_per_page'    => -1,
				's' 				=> $keywords,
				'post__not_in'      => $postId,
				'tax_query' => array(
					'relation' => 'IN',
					array(
						'taxonomy' => 'job-finder-location',
						'field'    => 'slug',
						'terms'    => $location,
					),
					array(
						'taxonomy' => 'job-finder-type',
						'field'    => 'slug',
						'terms'    => $job_type,
					),
				),
			);
		}
		elseif ($location || $job_type) {
			$args = array(
				'post_type' => 'job-finder',
				'post_status'       => 'publish',
				'posts_per_page'    => -1,
				'post__not_in'      => $postId,
				'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'job-finder-location',
						'field'    => 'slug',
						'terms'    => $location,
					),
					array(
						'taxonomy' => 'job-finder-type',
						'field'    => 'slug',
						'terms'    => $job_type,
					),
				),
			);
		}
		else{
			$args = array(
				'post_type' => 'job-finder',
				'post_status'       => 'publish',
				'posts_per_page'    => -1,
				'post__not_in'      => $postId
			);
		}
		$searchpost = new WP_Query( $args );
		$response = '';
		$i = 0;
		while ( $searchpost->have_posts() ) {
			$i++;
			$searchpost->the_post();
			get_data(get_the_ID());
		}
		wp_reset_postdata();
		echo $response;  
		exit;
			
	}
	public function show_job_search_data_function()
	{
		$expiry_date = get_option('job_finder_list_setting_data');
		$keywords    =  (!empty($_POST["keywords"]))  ? '1' : '0' ;
		$location    =  (!empty($_POST["location"]))  ? '1' : '0' ;
		$type        =  (!empty($_POST["job_type"]))  ? '1' : '0' ;	
		
		$location_name   = $_POST['location'];
		$keywords_name 	 = $_POST['keywords'];
		$job_type		 = $_POST['job_type'];

		if (($keywords == 1) && ($location == 1) && ($type == 1) ) {
			//ALL CONDITION SEARCH START
				//echo '<p class="mb-30 ff-montserrat">Search for : '.$keywords_name.' , ' .$location_name.' , '.$job_type.'</p>';
				$response = '';
				$all_condtion_args = array(
						"post_type" => "job-finder", 
						"s" => $keywords_name,
						'numberposts'    => 3,
						'tax_query' => array(
							'relation' => 'IN',
							array(
								'taxonomy' => 'job-finder-location',
								'field'    => 'slug',
								'terms'    => $location_name,
							),
							array(
								'taxonomy' => 'job-finder-type',
								'field'    => 'slug',
								'terms'    => $job_type,
							),
						)	
				);
				$all_condtion = get_posts( $all_condtion_args );
				$count = count($all_condtion); 
				if($count>0){
					echo '<p class="mb-30 ff-montserrat">Total Result Found : '.$count.'</p>';
				}
				if(!empty($all_condtion)){
					foreach ($all_condtion as $all_condtion_data) {
						get_data($all_condtion_data->ID);
					}
				}else{
					echo "<p class='no_result_found'>NO DATA FOUND</p>";
				}
			//ALL CONDITIONSEARCH END
		} 
		else if (($keywords == 1) && ($location == 0) && ($type == 0) ) {
			//KEYWORD SEARCH START
				echo '<p class="mb-30 ff-montserrat">Search for : '.$keywords_name.'</p>';
				$response = '';
				$keywords_args = array(
						"post_type" => "job-finder", 
						"s" => $keywords_name,
						'numberposts' => 3,
				);
				$kewords = get_posts( $keywords_args );
				$count = count($kewords); 
				if($count>0){
				//	echo '<p class="mb-30 ff-montserrat">Total Result Found : '.$count.'</p>';
				}
				if(!empty($kewords)){
					foreach ($kewords as $kewords_data) {
						get_data($kewords_data->ID);
					}
				}else{
					echo "<p class='no_result_found'>NO DATA FOUND</p>";
				}
			//KEYWORD SEARCH END
		}
		else if (($keywords == 0) && ($location == 1) && ($type == 0) ) {
			//LOCATION START :
				echo '<p class="mb-30 ff-montserrat">Search for : '.$location_name.'</p>';
				$response = '';
				$location_args = array(
					'post_type' => 'job-finder',
					'orderby' => 'title',
					'numberposts' => 3,
					'order' => 'ASC',
					'hierarchical' => false,
					'job-finder-location' => $location_name
				);
				$locations = get_posts($location_args);
				// echo "<pre>";
				// print_r($locations);
				// exit;
				$count = count($locations); 
				if($count>0){
					//echo '<p class="mb-30 ff-montserrat">Total Result Found : '.$count.'</p>';
				}
				if(!empty($locations)){
					foreach ($locations as $location_data) {
						get_data($location_data->ID);
					}
				}else{
					echo "<p class='no_result_found'>NO DATA FOUND</p>";
				}	
			//LOCATION END :
		}
		else if (($keywords == 0) && ($location == 0) && ($type == 1) ) {
			//JOB TYPE START
				echo '<p class="mb-30 ff-montserrat">Search for : '.$job_type.'</p>';
				$jobType_args = array(
					'post_type' => 'job-finder',
					'orderby' => 'title',
					'order' => 'ASC',
					'hierarchical' => false,
					'numberposts' => 3,
					'job-finder-type' => $job_type
				);
				$job_type = get_posts($jobType_args);
				
				$response = '';
				$count = count($job_type); 
				if($count>0){
				//	echo '<p class="mb-30 ff-montserrat">Total Result Found : '.$count.'</p>';
				}
				if(!empty($job_type)){
					foreach ($job_type as $jobType_data) {
						get_data($jobType_data->ID);
					}
				}else{
					echo "<p class='no_result_found'>NO DATA FOUND</p>";
				}
			//JOB TYPE END
		}
		else if (($keywords == 0) && ($location == 1) && ($type == 1) ) {
			//LOCATION AND TYPE SEARCH START
				echo '<p class="mb-30 ff-montserrat">Search for : '.$location_name.' , '.$job_type.'</p>';
				$type_location_args = array(
					'post_type' => 'job-finder',
					'post_status' => 'publish',
					'numberposts' => 3,
					'tax_query' => array(
						'relation' => 'IN',
						array(
							'taxonomy' => 'job-finder-location',
							'field'    => 'slug',
							'terms'    => $location_name,
						),
						array(
							'taxonomy' => 'job-finder-type',
							'field'    => 'slug',
							'terms'    => $job_type,
						),
					),
				);
				$response = '';
				$postslist = get_posts( $type_location_args );
				$count = count($postslist); 
				if($count>0){
				//	echo '<p class="mb-30 ff-montserrat">Total Result Found : '.$count.'</p>';
				}
				if(!empty($postslist)){
					foreach ($postslist as $postslist_data) {
						get_data($postslist_data->ID);
					}
				}else{
					echo "<p class='no_result_found'>NO DATA FOUND</p>";
				}	
			//LOCATION AND TYPE SEARCH START
		}
		else if (($keywords == 1) && ($location == 1) && ($type == 0) ) {
			//KEYWORD AND LOCATION SEARCH START
				echo '<p class="mb-30 ff-montserrat">Search for : '.$keywords_name.' , '.$location_name.'</p>';
				$response = '';
				$keywords_location_args = array(
						"post_type" => "job-finder", 
						"s" => $keywords_name,
						'numberposts' => 3,
						'tax_query' => array(
							array(
								'taxonomy' => 'job-finder-location',
								'field'    => 'slug',
								'terms'    => $location_name,
							),
						)	
				);
				$keywords_location = get_posts( $keywords_location_args );
				$count = count($keywords_location); 
				if($count>0){
					echo '<p class="mb-30 ff-montserrat">Total Result Found : '.$count.'</p>';
				}
				if(!empty($keywords_location)){
					foreach ($keywords_location as $keywords_location_data) {
						get_data($keywords_location_data->ID);
					}
				}else{
					echo "<p class='no_result_found'>NO DATA FOUND</p>";
				}
				
			//KEYWORD AND LOCATION SEARCH END
		}
		else if (($keywords == 1) && ($location == 0) && ($type == 1) ) {
			//KEYWORD AND TYPE SEARCH START
				echo '<p class="mb-30 ff-montserrat">Search for : '.$keywords.' , '.$job_type.'</p>';
				$response = '';
				$keywords_type_args = array(
						"post_type" => "job-finder", 
						"s" => $keywords_name,
						'numberposts' => 3,
						'tax_query' => array(
							array(
								'taxonomy' => 'job-finder-type',
								'field'    => 'slug',
								'terms'    => $job_type,
							),
						)	
				);
				$keywords_type = get_posts( $keywords_type_args );
				$count = count($keywords_type); 
				if($count>0){
					echo '<p class="mb-30 ff-montserrat">Total Result Found : '.$count.'</p>';
				}
				if(!empty($keywords_type)){
					foreach ($keywords_type as $keywords_type_data) {
						echo $keywords_type_data->ID;
						get_data($keywords_type_data->ID);
					}
				}else{
					echo "<p class='no_result_found'>NO DATA FOUND</p>";
				}
			//KEYWORD AND TYPE SEARCH START
		}
		else{
			$ajaxposts = new WP_Query([
				'post_type' => 'job-finder',
				'posts_per_page' => 3,
				'orderby' => 'date',
				'order' => 'DESC',
			]);
			$count_posts = wp_count_posts( 'job-finder' )->publish;
			echo '<p class="mb-30 ff-montserrat">Total Result Found : '.$count_posts.'</p>';
			// exit;
			$response = '';
			$i=0;
			if($ajaxposts->have_posts()): ?>
				<?php while ($ajaxposts->have_posts()): $ajaxposts->the_post();
					get_data($post->ID);
			 endwhile; 
			endif; 
		}
		wp_reset_postdata();
		echo $response;  
		exit;		
	}
	
}	
function get_data( $postid ){

		$categories_type     = get_the_terms( $postid, 'job-finder-type' );
		$categories_location = get_the_terms( $postid, 'job-finder-location' );
		$post_data           = get_post_meta( $postid,'job_finder_metabox_data',true);
		
		setup_postdata($post); ?>
		
		<a href="<?php echo get_permalink($postid )?>" style="text-decoration: none;">
			<div class="job-box d-md-flex align-items-center justify-content-between mb-30">
			<div class="job-left my-4 d-md-flex align-items-center flex-wrap">
			<div class="img-holder mr-md-4 mb-md-0 mb-4 mx-auto mx-md-0 d-md-none d-lg-flex">
			<i class="fa-solid fa-briefcase"></i>
			</div>
			<div class="job-content">
				<input type="hidden" value="<?php echo $postid; ?>" name="job_post_id" id="job_post_id" class="job_post_id">
				<h5 class="text-center text-md-left"><?php echo get_the_title($postid); ?></h5>
				<p class="text-center text-md-left"><?php echo trim(get_post_field('post_content', $postid), "[job-apply]");  ?></p>
				
				<ul class="d-md-flex flex-wrap text-capitalize ff-open-sans" style="padding-left: 1px;">
					<li class="mr-md-4">
						<i class="zmdi zmdi-pin mr-2"></i> 
						<?php foreach($categories_location as $name){
								echo $name->name;
						 } ?>
					</li>
					<li class="mr-md-4">
						<?php
							$startTimeStamp = strtotime(get_the_time('Y-m-d', $postid));
							$endTimeStamp   = strtotime(date("Y-m-d"));
							$timeDiff       = abs($endTimeStamp - $startTimeStamp);
							$numberDays     = $timeDiff/86400;  // 86400 seconds in one day
							
							if($numberDays == 0){
								echo '<i class="zmdi zmdi-time mr-2"></i>Posted today';
							} else {
								echo '<i class="zmdi zmdi-time mr-2"></i> '.$numberDays = intval($numberDays).' days ago';
							}
						?>
					</li>
					<li class="mr-md-4">
						<i class="zmdi zmdi-account-o"></i>
						<?php 
							foreach($categories_type as $name){ 
								echo $name->name; 
							} 
						?>
					</li>
				</div>
			</div>
		</div>
	</a> <?php
	return 	$postid;		
}
