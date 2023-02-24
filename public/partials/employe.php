<div class="post_job_container">
  <div class="title">Registration</div>
  <form action="#">
    <div class="user__details">
      <div class="input__box">
        <span class="details">Full Name</span>
        <input type="text" placeholder="E.g: John Smith" required>
      </div>
      <div class="input__box">
        <span class="details">Username</span>
        <input type="text" placeholder="johnWC98" required>
      </div>
      <div class="input__box">
        <span class="details">Email</span>
        <input type="email" placeholder="johnsmith@hotmail.com" required>
      </div>
      <div class="input__box">
        <span class="details">Phone Number</span>
        <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="012-345-6789" required>
      </div>
      <div class="input__box">
        <span class="details">Password</span>
        <input type="password" placeholder="********" required>
      </div>
      <div class="input__box">
        <span class="details">Confirm Password</span>
        <input type="password" placeholder="********" required>
      </div>

    </div>
    <div class="gender__details">
      <input type="radio" name="gender" id="dot-1">
      <input type="radio" name="gender" id="dot-2">
      <input type="radio" name="gender" id="dot-3">
      <span class="gender__title">Gender</span>
      <div class="category">
        <label for="dot-1">
          <span class="dot one"></span>
          <span>Male</span>
        </label>
        <label for="dot-2">
          <span class="dot two"></span>
          <span>Female</span>
        </label>
        <label for="dot-3">
          <span class="dot three"></span>
          <span>Prefer not to say</span>
        </label>
      </div>
    </div>
    <div class="cls_button">
      <input type="submit" value="Register">
    </div>
  </form>
</div>
<?php

//KEYWORDS Search dATA CODE:
//KEYWORD START :
			echo $keywords = $_POST['keywords'];
			global $wpdb;
			// $response = '';
			$myposts = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = 'job-finder' AND post_title LIKE '%s'", '%'. $wpdb->esc_like( $keywords ) .'%' ) );
			// echo "<pre>";
			if(!empty($myposts)){
				foreach ($myposts as $keyword_data) {
					// echo "<pre>";
					// print_r($keyword_data);
					$categories = get_the_terms( $keyword_data->ID, 'job-finder-category' );
					$categories_type = get_the_terms( $keyword_data->ID, 'job-finder-type' );
					$categories_location = get_the_terms( $keyword_data->ID, 'job-finder-location' );
					
					$post_data = get_post_meta($keyword_data->ID,'job_finder_metabox_data',true);
					setup_postdata($post); ?>
					
					<a href="<?php echo get_permalink($keyword_data->ID )?>" style="text-decoration: none;">
						<div class="job-box d-md-flex align-items-center justify-content-between mb-30">
						<div class="job-left my-4 d-md-flex align-items-center flex-wrap">
						<div class="img-holder mr-md-4 mb-md-0 mb-4 mx-auto mx-md-0 d-md-none d-lg-flex">
						<i class="fa-solid fa-briefcase"></i>
						</div>
						<div class="job-content">
							<h5 class="text-center text-md-left"><?php echo $keyword_data->post_title; ?></h5>
							<p class="text-center text-md-left"><?php _e('Ut facilisis lorem ut interdum gravida. Aenean nec tempor lorem. Ut et nisi ligula.') ?></p>
							
							<ul class="d-md-flex flex-wrap text-capitalize ff-open-sans" style="padding-left: 1px;">
								<li class="mr-md-4">
									<i class="zmdi zmdi-pin mr-2"></i> 
									<?php foreach($categories_location as $name){?>
										<?php echo $name->name; ?>
									<?php } ?>
								</li>
								<li class="mr-md-4">
									<?php
										$startTimeStamp = strtotime(get_the_time('Y-m-d', $keyword_data->ID));
										$endTimeStamp = strtotime(date("Y-m-d"));
										$timeDiff = abs($endTimeStamp - $startTimeStamp);
										$numberDays = $timeDiff/86400;  // 86400 seconds in one day
										
										if($numberDays == 0){
											echo '<i class="zmdi zmdi-time mr-2"></i>Posted today';
										} else {
											echo '<i class="zmdi zmdi-time mr-2"></i> '.$numberDays = intval($numberDays).' days ago';
										}
									?>
								</li>
								<li class="mr-md-4">
									<i class="zmdi zmdi-account-o"></i>
									<?php foreach($categories_type as $name){ ?>
										<?php echo $name->name; ?>
									<?php } ?>
								</li>
							</div>
						</div>
					
					</div>
				</a> <?php
				}
			}else{
				echo '<p class="no_result_found">'."NO JOBS FOUND".'</p>';
			}
			exit;

			
			//KEYWORD END :