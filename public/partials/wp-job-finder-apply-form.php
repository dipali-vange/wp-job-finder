<?php  
    $id = get_the_ID(); ?>
    <button name="apply_now" id="apply_now"><?php _e('Apply Now'); ?></button>

<div class="post_job_container" class="user_apply_form_class" id="user_apply_form_class" style="display:none;">
  <div class="title"><?php _e('Job Apply Form'); ?></div>
  <form method="post" name="user_apply_form" id="user_apply_form">
    <div class="user__details">
      
        <div class="input__box">
          <input type="hidden" value="<?php echo $id ?>" name="userId" id="userId">
          <span class="details"><?php _e('Username'); ?></span>
          <input type="text" name="username" id="username" name="username" placeholder="E.g: John Smith" required>
        </div>

        <div class="input__box">
          <span class="details"><?php _e('Email'); ?></span>
          <input type="email" id="email" name="email" placeholder="johnWC98" required>
        </div>

        <div class="input__box">
          <span class="details"><?php _e('Message'); ?></span>
          <input type="text"  id="message" name="message" placeholder="johnsmith@hotmail.com" required>
        </div>

        <div class="input__box">
          <span class="details"><?php _e('Phone Number'); ?> </span>
          <input type="tel" id="phone_no" name="phone_no" placeholder="012-345-6789" required>
        </div>

        <!-- <div>
          <span class="details"><?php _e('Upload CV'); ?> </span>
          <input ype="file" name="upload" id="upload" />
        </div> -->
    </div>
    <input type="hidden" value="<?php the_title();  ?>" name="applied_job_name" id="applied_job_name">

    <div class="gender__details">
        <input type="radio" name="gender" id="dot-1" value="male">
        <input type="radio" name="gender" id="dot-2" value="female">
        <input type="radio" name="gender" id="dot-3" value="other">
        <span class="gender__title"><?php _e('Gender'); ?></span>

        <div class="category">
          <label for="dot-1">
            <span class="dot one"></span>
            <span><?php _e('Male')?></span>
          </label>

          <label for="dot-2">
            <span class="dot two"></span>
            <span><?php _e('Female')?></span>
          </label>

          <label for="dot-3">
            <span class="dot three"></span>
            <span><?php _e('Prefer not to say')?> </span>
          </label>
        </div>
    </div>

    <div class="cls_button">
      <input type="submit" value="Register">
    </div>

  </form>
</div>

<script>
  
    jQuery( document ).ready(function() {
      jQuery('form').on('submit', function (e) {
        
        jQuery("#user_apply_form").valid();  
          e.preventDefault();
              var formData = {
                  id       : jQuery("#userId").val(),
                  username : jQuery("#username").val(),
                  email    : jQuery("#email").val(),
                  message  : jQuery("#message").val(),
                  phone_no : jQuery("#phone_no").val(),
                  // upload_cv: jQuery("#upload_cv").val(),
                  gender   : jQuery('input[name=gender]:checked').val(),
                  job_name : jQuery("#applied_job_name").val(),
              };
          
          // console.log(formData);
          // return false;
          jQuery.ajax({
              type     : "POST",
              dataType : "json",
              encode   : true,
              url      : job_finder_object.ajaxurl,
              data     : {
                  action   : "apply_job_user_data",
                  formData : formData
              },
              success  : function(response){
                Swal.fire({
                    icon             : 'success',
                    title            : 'Job applied Successfully',
                    showConfirmButton: false,
                    timer            : 2000
                  });
                  setTimeout(function() {
                  location.reload();
                }, 1000);  
              }  
          });			
        });
        jQuery("#apply_now").click(function(){
            if (jQuery('#user_apply_form_class').is(":hidden")) {  
                jQuery("#user_apply_form_class").slideDown();
            }else {
                jQuery('#user_apply_form_class').slideUp('slow');
            }    
        });
  });
</script>