<?php
$post_id = get_the_ID();
$data    = get_post_meta($post_id, 'job_finder_metabox_data', true );
$company_name        = $data['company_name'];
$company_description = $data['company_description'];
$company_mail        = $data['company_mail'];
$phone_no            = $data['phone_no'];
$company_location    = $data['company_location']; 
$job_expiry_date     = $data['job_expiry_date']
?>
<table id="job_metabox"  class="form-table">
    <tbody>
        <tr class="user-user-login-wrap">
            <td><b><label for="email"><?php _e('Company Name'); ?></label></b> </td>
            <td>
                <input type="text" class="regular-text" name="company_name" id="company_name" value="<?php echo (!empty($company_name)) ? $company_name : '';?>">
            </td>   
        </tr>
        <tr class="user-user-login-wrap">
            <td><b><label for="email"><?php _e('Company Description'); ?></label></b> </td>
            <td>
                <textarea id="company_description" name="company_description" rows="6" cols="38"><?php echo (!empty($company_description)) ? $company_description : '';?></textarea>
            </td>
        </tr>
        <tr class="user-user-login-wrap">
            <td><b><label for="email"><?php _e('Company Email Id'); ?></label></b> </td>
            <td>
                <input type="text" class="regular-text" name="company_mail" id="company_mail" value="<?php echo (!empty($company_mail )) ? $company_mail  : '';?>">         
            </td>
        <tr class="user-user-login-wrap">
            <td><b><label for="email"><?php _e('Company Phone Number'); ?></label></b> </td>
            <td>
                <input type="text" class="regular-text" name="phone_no" id="phone_no" value="<?php echo (!empty($$phone_no)) ? $$phone_no : '';?>">
            </td>
        <tr class="user-user-login-wrap">
            <td><b><label for="email"><?php _e('Company Location'); ?></label></b> </td>
            <td>
                <input type="text" class="regular-text" name="company_location" id="company_location" value="<?php echo (!empty($company_location )) ? $company_location  : '';?>">
             </td>
         <tr class="user-user-login-wrap">
            <td><b><label for="email"><?php _e('Job Expiry Date'); ?></label></b> </td>
            <td>
                <input type="date" class="regular-text" name="job_expiry_date" id="job_expiry_date" value="<?php echo (!empty($job_expiry_date )) ? $job_expiry_date  : '';?>">
            </td>
        </tr>
    </tbody>       
</table>
    