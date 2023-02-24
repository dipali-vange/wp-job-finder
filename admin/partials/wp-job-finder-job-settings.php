<?php
$pageSettings      = ( isset( $_GET['tab'] ) && 'page-setting' == $_GET['tab'] ) ? true : false;
$email_template    = ( isset( $_GET['tab'] ) && 'email-template-settings' == $_GET['tab'] ) ? true : false;

?>
<div style="padding-bottom: 12px;">
	<h2 class="nav-tab-wrapper">
		<a href="<?php echo admin_url( 'edit.php?post_type=job-finder&page=job-finder-setting' ); ?>" class="nav-tab<?php if ( ! isset( $_GET['tab'] ) || isset( $_GET['tab'] )  && 'page-setting' != $_GET['tab']   &&  'email-template-settings' != $_GET['tab'] ) echo ' nav-tab-active'; ?>"><?php esc_html_e( 'Job Listing Settings' ); ?></a>


		<a href="<?php echo esc_url( add_query_arg( array( 'tab' => 'email-template-settings' ), admin_url( 'admin.php?page=job-finder-setting' ) ) ); ?>" class="nav-tab<?php if ( $email_template ) echo ' nav-tab-active'; ?>"><?php esc_html_e( 'Email Template' ); ?></a> 
	</h2>
</div> 

<?php 
if($pageSettings){
	require_once plugin_dir_path(__FILE__) . 'wp-job-finder-pageSettings-settings.php';
}elseif($email_template) {
	require_once plugin_dir_path(__FILE__) . 'wp-job-finder-email-template.php';
}else{	
	require_once plugin_dir_path(__FILE__) . 'wp-job-finder-job-listing-settings.php';
}
?>