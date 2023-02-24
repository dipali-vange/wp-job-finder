<div class="wrap">
<h1>
    <?php _e('User Email Template Settings'); ?>
</h1>

<form method="post" action="options.php">
    <?php 
        settings_fields( 'job_finder_page_setting' ); 
        do_settings_sections( 'job_finder_page_setting' ); 
        $tempalte_Udata =  get_option('job_finder_page_setting_data'); 
        $enabled        =  $tempalte_Udata['is_enable'];
        $heading        =  $tempalte_Udata['user_template_heading'];
        $subject        =  $tempalte_Udata['user_template_subject'];
        $message        =  $tempalte_Udata['user_template_msg'];
    ?>
	
	<p><?php _e('Use Below shortcode:');?></p>
	<ol style="list-style-type:square">
		<li><?php _e('Username : [user-name]');?></li>
		<li><?php _e('User Email : [user-email]');?></li>
    </ol>

    <!-- USER EMAIL TEMPLATE SETTINGS -->
	<hr>
	<h5><?php _e('User mail Template Settings');?></h5>
    <table class="form-table">

		<tr valign="top">
			<th scope="row"><?php _e('Enable User mail');?></th>
            <?php $isChecked = !empty($enabled) && $enabled == "yes" ? "checked" : " "; ?>
			<td>
                <input type="checkbox"  name="job_finder_page_setting_data[is_enable]" value="yes" <?php echo $isChecked ? $isChecked: "checked"?> >
            </td>
        </tr>

		<tr valign="top">
			<th scope="row"><?php _e('User mail template Heading');?></th>
			<td>
                <input type="text" placeholder="User mail template Heading" name="job_finder_page_setting_data[user_template_heading]" value="<?php echo isset( $heading ) ? $heading : '';?>" />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e('User mail template Subject');?></th>
            <td>
                <input type="text"  placeholder="User mail template Subject" name="job_finder_page_setting_data[user_template_subject]" value="<?php echo  isset( $subject ) ? $subject : '';?>" />
            </td>
        </tr>

		<tr valign="top">
            <th scope="row"><?php _e('User mail template Message');?></th>
            <td>
                <?php $args = array (
                    'media_buttons' => false,
                    'textarea_rows' => '10',
                    'textarea_name' => 'job_finder_page_setting_data[user_template_msg]'
                );
                wp_editor(isset( $message ) ? $message : '', 'user_template_msg', $args ); ?>
            </td>
        </tr>
        
    </table>
        
    <?php submit_button(); ?>

</form>
</div>