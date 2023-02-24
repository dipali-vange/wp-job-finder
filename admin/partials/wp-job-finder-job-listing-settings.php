<form method="post" action="options.php">
    <?php
        settings_fields( 'job_finder_list_setting' );
        do_settings_sections( 'job_finder_list_setting' ); 
        $settings              = get_option('job_finder_list_setting_data');
        $pagination_type       = $settings['pagination_type'];
        $multi_select_category = $settings['multi_select_category'];
        $expiry_date           = $settings['expiry_date'];
    ?>
  <table class="form-table">  
    <tr>
        <th scope="row"> <?php _e('Listings Per Page');?> </th>
        <td> 
            <input type="number" name="job_finder_list_setting_data[listing_per_page]" id="listing_per_page"  min="1" max="9" value= "<?php echo isset($settings['listing_per_page']) ? $settings['listing_per_page'] : '';?>">
        </td>
    </tr>
    
    <tr>
        <th scope="row"> <?php _e('Pagination Type');?> </th>
        <td> 
            <select name="job_finder_list_setting_data[pagination_type]" id="pagination_type">
                <option value="0">Select Type</option>
                <option value="load_more" <?php echo isset( $pagination_type ) && $pagination_type === 'load_more' ? 'selected' : '' ; ?>>Load More</option>
                <option value="pagination"  <?php echo isset( $pagination_type ) && $pagination_type === 'pagination' ? 'selected' : '' ; ?>>Pagination</option>
            </select>
        </td>
    </tr>
     
    <tr>
        <th scope="row"> <?php _e('Multi-select Categories');?> </th>
        <td>
            <select name="job_finder_list_setting_data[multi_select_category]" id="multi_select_category">
                <option value="0">Select option</option>
                <option value="yes" <?php echo isset( $multi_select_category ) && $multi_select_category === 'yes' ? 'selected' : '' ; ?>>Yes</option>
                <option value="no"  <?php echo isset( $multi_select_category ) && $multi_select_category === 'no' ? 'selected' : '' ; ?>>No</option>
            </select>
        </td>
    </tr>

    <tr>
        <th scope="row"> <?php _e('Hide Expired Listings');?> </th>
        <td>
            <select name="job_finder_list_setting_data[expiry_date]" id="expiry_date">
                <option value="0">Select option</option>
                <option value="yes" <?php echo isset( $expiry_date ) && $expiry_date === 'yes' ? 'selected' : '' ; ?>>Yes</option>
                <option value="no"  <?php echo isset( $expiry_date ) && $expiry_date === 'no' ? 'selected' : '' ; ?>>No</option>
            </select>
        </td>
    </tr>

</table>
<?php submit_button(); ?>
</form>