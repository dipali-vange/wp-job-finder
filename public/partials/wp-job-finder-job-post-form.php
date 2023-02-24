<div class="container mt-3">
  <form name="post-job-form">
    <div class="row jumbotron box8">
      <div class="col-sm-12 mx-t3 mb-4">
        <h2 class="text-center text-info"><?php _e('Post Job');?></h2>
      </div>

      <div class="col-sm-6 form-group">
        <label for="name-f"><?php _e('Job Title');?></label>
        <input type="text" class="form-control" name="job_title" id="job_title" placeholder="Enter your Job Title." >
      </div>

      <div class="col-sm-6 form-group">
        <label for="name-l"><?php _e('Company Name');?></label>
        <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Enter your company name." >
      </div>

      <div class="col-sm-6 form-group">
        <label for="name-l"><?php _e('Job Description');?> </label>
        <textarea class="form-control" id="job_description" name="job_description" cols="20" rows="5" placeholder="Enter Job description."></textarea>
        <?php
            // $content = "hello";
            // $settings = array( 'textarea_name' => 'post_text' );
            // wp_editor( $content, 'job_description', $settings );
        ?>
      
      </div>

      <div class="col-sm-6 form-group">
        <label for="address-1"><?php _e('Company Description');?></label>
        <textarea class="form-control" id="company_description" name="company_description" cols="20" rows="5" placeholder="Enter Job description."></textarea>
        </textarea>
      </div>
      
      <!-- JOB CATEGORY START -->
      <div class="col-sm-6 form-group">
          <label for="Country"><?php _e('Job Category');?></label>
          <?php 
            $args = array(
              'taxonomy'   => 'job-finder-category',
              'orderby'    => 'name',
              'order'      => 'ASC',
              'hide_empty' => false,
          ); 
          $job_category = get_categories($args);   
          if(!empty($job_category)){ ?>
          <select class="form-control custom-select browser-default" name="job_category" id="job_category">
              <option value="0"><?php _e('Select Job Category  ');?></option>
          <?php foreach($job_category as $cat) { ?>
                  <option value="<?php  echo $cat->term_id;?>"><?php  echo $cat->name; ?></option>
          <?php }?>
          </select> 
          <?php } else {?>
                  <p class="cstm_cat" style="font-size: 16px;margin-top: -25px;"><a href="<?php echo $finder ?>">
                  <?php _e('Job Finder Category is empty, Create category first');?></a></p>
          <?php }?>  
        </div>
      <!-- JOB CATEGORY END -->
       
      <div class="col-sm-6 form-group">
        <label for="pass2"><?php _e('Company Mail ID'); ?></label>
        <input type="email" name="company_mail" class="form-control" id="company_mail" placeholder="Enter Company Mail Id." >
      </div>
     
      <!-- JOB TYPE START -->
      <div class="col-sm-6 form-group">
        <label for="Country"><?php _e('Job Type');?> </label>
        <?php 
          $args = array(
              'taxonomy'    => 'job-finder-type',
              'orderby'     => 'name',
              'order'       => 'ASC',
              'hide_empty'  => false,
          ); 
          $type_category = get_categories($args);    
          $finder = get_site_url().'/wp-admin/edit-tags.php?taxonomy=job-finder-type&post_type=job-finder'; 
              
        if(!empty($type_category)){ ?>
          <select class="form-control custom-select browser-default" name="job_type" id="job_type">
                <option value="0"><?php _e('Select Job Type  ');?></option>
                <?php foreach($type_category as $cat) { ?>
                        <option value="<?php  echo $cat->term_id;?>"><?php  echo $cat->name; ?></option>
                <?php }?>
          </select> 
        <?php } else {?>
                <p class="cstm_cat" style="font-size: 16px;margin-top: -25px;"><a href="<?php echo $finder ?>">
                 <?php _e('Job Finder Category is empty, Create category first');?></a></p>
        <?php }?>  
      </div>
       <!-- JOB TYPE END -->

      <div class="col-sm-6 form-group">
        <label for="tel"><?php _e('Company Phone Number'); ?></label>
        <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="Enter Your Contact Number." >
      </div>

      <!-- JOB LOCATION START -->
      <div class="col-sm-6 form-group">
        <label for="Country"><?php _e('Job Location'); ?></label>
        <?php 
        $args = array(
            'taxonomy'     => 'job-finder-location',
            'orderby'      => 'name',
            'order'        => 'ASC',
            'hide_empty'   => false,
        ); 
        $location_category = get_categories($args);    
        $finder = get_site_url().'/wp-admin/edit-tags.php?taxonomy=job-finder-location&post_type=job-finder'; 
             
        if(!empty($location_category)){ ?>
         <select class="form-control custom-select browser-default" name="job_location" id="job_location">
              <option value="0"><?php _e('Select Job Location  ');?></option>
              <?php foreach($location_category as $cat) { ?>
                      <option value="<?php  echo $cat->term_id;?>"><?php  echo $cat->name; ?></option>
              <?php }?>
        </select> 
        <?php } else {?>
                <p class="cstm_cat" style="font-size: 16px;margin-top: -25px;"><a href="<?php echo $finder ?>">
                 <?php _e('Job Finder Category is empty, Create category first');?></a></p>
         <?php }?>  
      </div>
       <!-- JOB LOCATION END -->
      <div class="col-sm-6 form-group">
        <label for="State"> <?php _e('Company Location'); ?></label>
        <input type="address" class="form-control" name="company_location" id="company_location" placeholder="Enter Company Location." >
      </div>

      <div class="col-sm-6 form-group">
          <label for="Date"> <?php _e('Job Expiry Date'); ?></label>
          <input type="date" name="expiry_date" class="form-control" id="expiry_date" placeholder="" >
      </div>
        
      <div class="col-sm-12">
          <input type="checkbox" name="conditon_accept" class="form-check d-inline" id="conditon_accept" ><label for="chb" class="form-check-label"><p><?php _e('I accept all terms and conditions.'); ?></p> 
          </label>
      </div>

      <div class="col-sm-12 form-group mb-0">
        <button class="btn btn-primary float-right"> <?php _e('Submit');?> </button>
      </div>

    </div>
  </form>
</div>
<script>
    jQuery( document ).ready(function() {
       jQuery("form[name='post-job-form']").validate({
        rules: {
          job_title         : "required",
          company_name      : "required",
          phone_no          : "required",
          company_location  : "required",
          conditon_accept   : "required", 
          chkbox            : "required", 
          job_description: {
              required: true
          },
          company_mail: {
            required: true,
            email: true
          },
          company_description: {
            required: true,
          },
          job_category: {
	   				 select_cat_check: true
	   			 },
	   			 job_location: {
	   				 select_loaction_check: true
	   			 },
	   			 job_type: {
	   				 select_type_check: true
	   			 }
        },
        messages: {
          job_title          : "Please enter your jobti title",
          company_name       : "Please enter your company name",
          phone_no           : "Please enter your phone number",
          company_location   : "Please enter your comapny location",
          conditon_accept    : "* You must accept at terms and condition.",
          company_mail       : "Please enter a valid email address",
          job_description    : "Please enter your job description",
          company_description: "Please enter your company description"
        },
        submitHandler: function(form) {
          var job_category  = jQuery('#job_category').find(":selected").val();
          var job_type      = jQuery('#job_type').find(":selected").val();
          var job_location  = jQuery('#job_location').find(":selected").val();
         
          var formData = {
                job_title          : jQuery("#job_title").val(),
                job_description    : jQuery("#job_description").val(),
                company_name       : jQuery("#company_name").val(),
                company_description: jQuery("#company_description").val(),
                company_mail       : jQuery("#company_mail").val(),
                company_location   : jQuery("#company_location").val(),
                expiry_date        : jQuery("#expiry_date").val(),
                phone_no           : jQuery("#phone_no").val(),
          };
          jQuery.ajax({
                type     : "POST",
                dataType : "json",
                encode   : true,
                url      : job_finder_object.ajaxurl,
                data     : {
                  action        : "add_job_data",
                  formData      : formData,
                  job_category  : job_category,
                  job_type      : job_type,
                  job_location  : job_location
                },
                success:function(response){
                    Swal.fire({
                        icon             : 'success',
                        title            : 'Job Posted Successfully',
                        showConfirmButton: false,
                        timer            : 2000
                      });
                      setTimeout(function() {
                      location.reload();
                    }, 1000);  
              }  
          });			
        }
    });
    jQuery.validator.addMethod('select_cat_check', function (value) {
        return (value != '0');
    }, "Select job Category ");

    jQuery.validator.addMethod('select_loaction_check', function (value) {
      return (value != '0');
    }, "Select job Location ");

    jQuery.validator.addMethod('select_type_check', function (value) {
      return (value != '0');
    }, "Select job Type ");
        
    // jQuery(function() {
    //    jQuery( "#expiry_date" ).datepicker({
    //        minDate: 0,
    //        dateFormat: 'yy/mm/dd'
    //    });
    // });
  });
</script>