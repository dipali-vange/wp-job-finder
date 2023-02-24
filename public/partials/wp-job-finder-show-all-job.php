<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />
<div class="container">
    <div class="row">
        <div class="col-lg-10 mx-auto mb-4">
            <div class="section-title text-center ">
                <h3 class="top-c-sep"><?php _e('Find Your job'); ?></h3>
                <p>
                    <?php _e('Lorem ipsum dolor sit detudzdae amet, rcquisc adipiscing elit. Aenean socada commodo
                    ligaui egets dolor. Nullam quis ante tiam sit ame orci eget erovtiu faucid.');?>
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="career-search mb-60">
                <form action="#" class="career-form mb-60" id="jobForm">
                <div class="row">
                    <div class="col-md-12 col-lg-3 my-3">
                        <div class="input-group position-relative">
                        <input type="text" class="form-control" placeholder="Enter Your Keywords" id="keywords" name="keywords">
                    </div>
                </div>
                        <div class="col-md-12 col-lg-3 my-3">
                            <div class="select-container">
                            <?php
                                $args = array(
                                    'taxonomy' => 'job-finder-location',
                                    'orderby' => 'name',
                                    'order'   => 'ASC',
                                    'hide_empty'      => false,
                                ); 
                                $location_cats = get_categories($args);
                                ?>
                                <select class="custom-select" name="custom-select-location" id="custom-select-location">
                                    <option selected=""  value="0">Location</option>
                                    <?php foreach($location_cats as $val) {?> 
                                        <option value="<?php echo $val->cat_name;?>"><?php echo $val->cat_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-3 my-3">
                            <div class="select-container">
                                <?php
                                $args = array(
                                    'taxonomy' => 'job-finder-type',
                                    'orderby' => 'name',
                                    'order'   => 'ASC',
                                    'hide_empty'      => false,
                                ); 
                                $cats = get_categories($args);?>
                                <select class="custom-select" name="custom-select-jobType" id="custom-select-jobType">
                                    <option selected="" value="0">Select Job Type</option>
                                <?php foreach($cats as $cat_val){ ?>
                                        <option value="<?php echo $cat_val->cat_name;?>"><?php echo $cat_val->cat_name; ?></option>
                                
                                <?php } ?>  
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-3 my-3">
                            <button type="button" class="btn btn-lg btn-block btn-light btn-reset" id="cstm-reset-btn">
                                <?php _e('Reset'); ?>
                            </button>
                        </div>

                        <div class="col-md-12 col-lg-12 my-3">
                            <button type="button" class="btn btn-lg btn-block btn-light btn-custom" id="contact-submit">
                            <?php _e('Search'); ?>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="filter-result" id="filter-result-search"></div>
                <p class="search_datap"></p>
                <div class="filter-result" id="filter-result">
                    <p class="mb-30 ff-montserrat" style="margin-top:10px;">
                        Total Job Openings : <?php echo $count_posts = wp_count_posts( 'job-finder' )->publish ; ?>
                    </p>
                    <?php 
                    $post_per_page = get_option('job_finder_list_setting_data');
                    $list          = $post_per_page['listing_per_page'];
                    $paged         = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    if(!empty($list)){
                        $posts =  new WP_Query( array( 'post_type' => 'job-finder','posts_per_page'=> $list, 'paged' => $paged) );
                    }else{
                        $posts =  new WP_Query( array( 'post_type' => 'job-finder','posts_per_page'=> 6, 'paged' => $paged ) );
                    }

                    if ( $posts->have_posts() ) : 
                        while ( $posts->have_posts() ) : $posts->the_post();
                            $postID = get_the_ID();
                            $categories          = get_the_terms( $postID, 'job-finder-category' );
                            $categories_type     = get_the_terms( $postID, 'job-finder-type' );
                            $categories_location = get_the_terms( $postID, 'job-finder-location' );
                            
                            $post_data = get_post_meta($postID,'job_finder_metabox_data',true);
                            ?>
                            <a href="<?php echo get_permalink($postID )?>" style="text-decoration: none;">
                            <div class="job-box d-md-flex align-items-center justify-content-between mb-30">
                                <div class="job-left my-4 d-md-flex align-items-center flex-wrap">
                                    <div class="img-holder mr-md-4 mb-md-0 mb-4 mx-auto mx-md-0 d-md-none d-lg-flex">
                                        <i class="fa-solid fa-briefcase"></i>
                                    </div>
                                    <div class="job-content">
                                        <h5 class="text-center text-md-left"><?php the_title(); ?></h5>
                                        <p class="text-center text-md-left">
                                        <?php  echo str_replace("[job-apply]"," ",get_the_content());  ?></p>
                                        
                                        <ul class="d-md-flex flex-wrap text-capitalize ff-open-sans" style="padding-left: 1px;">
                                            <li class="mr-md-4">
                                                <i class="zmdi zmdi-pin mr-2"></i> 
                                                <?php foreach($categories_location as $name){?>
                                                    <?php echo $name->name; ?>
                                                <?php } ?>
                                            </li>
                                            <li class="mr-md-4">
                                                <?php
                                                    $startTimeStamp  = strtotime(get_the_time('Y-m-d', $postID));
                                                    $endTimeStamp    = strtotime(date("Y-m-d"));
                                                    $timeDiff        = abs($endTimeStamp - $startTimeStamp);
                                                    $numberDays      = $timeDiff/86400;  // 86400 seconds in one day
                                                    
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
                                        </ul>
                                        </div>
                                    </div>
                                </div>
                            </a>   
                        <?php
                            endwhile; 
                            endif;
                        ?> 
                    </div>
                </div>
                        <?php 
                        $settings        = get_option('job_finder_list_setting_data');
                        $pagination_type = $settings['pagination_type'];

                        if($pagination_type == 'load_more') { ?>
                                <div class="btn__wrapper load_more_class">
                                <a id="load-more" style="text-decoration:none;">Load more</a>
                                </div>

                                <div class="btn__wrapper load_more_search_class" style="display:none;">
                                <a id="load-more2" style="text-decoration:none;">Load more</a>
                                </div>
                        <?php } 

                        if($pagination_type == 'pagination') { 
                            $total_pages = $posts->max_num_pages;
                            if ($total_pages > 1){
                                $current_page = max(1, get_query_var('paged'));
                                echo paginate_links(array(
                                    'base'          => get_pagenum_link(1) . '%_%',
                                    'format'        => '/page/%#%',
                                    'current'       => $current_page,
                                    'total'         => $total_pages,
                                    'prev_text'     => __('« prev'),
                                    'next_text'     => __('next »'),
                                ));
                            }
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
<script>
    //AJAX LOAD
    jQuery( document ).ready(function() {
        var currentPage = 1;
        jQuery('#load-more2').on('click', function() {
            var keywords  = jQuery('#keywords').val();
            var location  = jQuery('#custom-select-location').val();
            var job_type  = jQuery('#custom-select-jobType').val();
            
            var job_post_id = [];
            jQuery(".job_post_id").each(function(){
            job_post_id.push(jQuery(this).val());
            });
            // alert(job_post_id);
            currentPage++; 
            jQuery.ajax({
                type: "POST",
                dataType: 'html',
                encode: true,
                url : job_finder_object.ajaxurl,
                data: {
                    action      : 'load_more_after_search',
                    paged       : currentPage,
                    job_post_id : job_post_id,
                    keywords    :keywords,
                    location    : location,
                    job_type    : job_type
                },
                success: function (res) {
                    jQuery('.filter-result').append(res);
                }
            });
        });

        jQuery('#load-more').on('click', function() {
            currentPage++; 
            jQuery.ajax({
                type    : "POST",
                dataType: 'html',
                encode  : true,
                url     : job_finder_object.ajaxurl,
                data    : {
                    action: 'show_job_load_more',
                    paged: currentPage,
                },
                success: function (res) {
                    jQuery('#filter-result').append(res);
                }
            });
        });
        
        jQuery('#contact-submit').on('click', function() {
            jQuery('#filter-result-search').empty('');
            var keywords  = jQuery('#keywords').val();
            var location  = jQuery('#custom-select-location').find(":selected").val();
            var job_type  = jQuery('#custom-select-jobType').find(":selected").val();
           
            if(keywords !== '' ||  location !== 0 || job_type !== 0){
                jQuery.ajax({
                    type: "POST",
                    dataType: 'html',
                    encode: true,
                    url : job_finder_object.ajaxurl,
                    data: {
                        action  : 'show_job_search_data',
                        keywords: keywords,
                        location: location,
                        job_type: job_type
                    },
                    success: function (res) {
                        console.log(res);
                        // jQuery('.load_more_class').css("display"," ");
                        // if( res !== ''){
                            var result = jQuery('#filter-result-search').append(res);
                            jQuery("#filter-result").replaceWith(result);
                            jQuery('.load_more_class').css("display","none");
                            jQuery('.load_more_search_class').css("display","");
                        // }
                    }
                });
            }
            
        });

        //RESER BUTTON
        jQuery('#cstm-reset-btn').on('click', function() {
            alert('hello');
            jQuery("#filter-result").load(".filter-result");
            return false;
            jQuery('.load_more_class').show("slow");
        });
    });
    
</script>
