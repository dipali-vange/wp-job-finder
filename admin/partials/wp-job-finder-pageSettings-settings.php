<form method="post" action="options.php">
    <?php 
        $pages = get_pages(array('post_status'  => 'publish'));
        settings_fields( 'job_finder_page_setting' ); 
        do_settings_sections( 'job_finder_page_setting' ); 
        $settings = get_option('job_finder_page_setting_data');

    ?>
  <table class="form-table">  
     <tr>
        <th scope="row"> <?php _e('Job Listings Page');?>   </th>
        
        <td>
            <select name="job_finder_page_setting_data[job_page]" id="job_page" >
                <option value=""><?php _e('Job Listings Page');?></option>
                <?php foreach($pages as $page_data){ 
                ?>
                    <option value=<?php echo $page_data->post_title; ?>><?php echo $page_data->post_title;?></option>
                    <option value="load_more" <?php echo isset( $settings['pagination_type'] ) && $settings['pagination_type'] === 'load_more' ? 'selected' : '' ; ?>>Load More</option>
                <?php } ?>
            </select>
            <p class="description">     
                <?php _e("Select the page where you've used the [show-all-job] shortcode. This lets the plugin know the location of the form."); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row"> <?php _e('Post Job page');?> </th>
        <td>
            <select name="job_finder_page_setting_data[job_post_page]" id="job_post_page" >
                <option value=""><?php _e('Post Job page');?></option>
                <?php foreach($pages as $page_data){ ?>
                    <option value=<?php echo $page_data->post_title; ?>><?php echo $page_data->post_title;?></option>
                <?php } ?>
            </select>
            <p class="description"> 
                <?php _e("Select the page where you've used the [post-job-form] shortcode. This lets the plugin know the location of the form."); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row"> <?php _e('Apply Job page');?> </th>
        <td>
            <select name="job_finder_page_setting_data[apply_job]" id="apply_job" >
                <option value=""><?php _e('Apply Job page');?></optio>
                <?php foreach($pages as $page_data){ ?>
                    <option value=<?php echo $page_data->post_title; ?>><?php echo $page_data->post_title;?></option>
                <?php } ?>
            </select>
            <p class="description"> 
                <?php _e("Select the page where you've used the [apply-now] shortcode. This lets the plugin know the location of the form."); ?>
            </p>   
        </td>
    </tr>

</table>
<?php submit_button(); ?>
</form>