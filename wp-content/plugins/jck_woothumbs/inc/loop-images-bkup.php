<?php global $jck_wt; ?>

<?php

$imported_images = get_field('gallery_images');

if ( !empty( $imported_images[0]['gallery_images_url'] ) ) { ?>

    <div class="<?php echo $this->slug; ?>-images-wrap">

       <div class="<?php echo $this->slug; ?>-images <?php if( $jck_wt['clickAnywhere'] ) echo $this->slug."-images--click_anywhere"; ?>">

           <?php $i = 0; foreach($imported_images as $import_image):

           ?>

           <div class="<?php echo $this->slug; ?>-images__slide <?php if($i == 0) echo $this->slug."-images__slide--active"; ?>" data-index="<?php echo $i; ?>">

             <img class="<?php echo $this->slug; ?>-images__image" src="<?php echo $import_image['gallery_images_url']; ?>" data-large-image="<?php echo $import_image['gallery_images_url']; ?>" >
             <a data-pin-do="buttonPin" data-share-url="<?php echo esc_url(get_permalink()); ?>" data-share-description="<?php echo get_the_title(); ?>" data-share-media="<?php echo $import_image['gallery_images_url']; ?>" class="cpm-pin-it" href="https://www.pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&media=<?php echo $import_image['gallery_images_url']; ?>&description=<?php echo get_the_title(); ?>" data-pin-custom="true"><i class="fa fa-pinterest fa-3" aria-hidden="true"></i></a>
             <?php /*if ( is_user_logged_in() && is_numeric( $default_image_ids[$i] ) && !empty( $default_image_ids[$i] ) ) {

                global $wpdb;
                $table_name = $wpdb->prefix . "wishlists_image";


                $current_user_id = get_current_user_id();
                $result_arr = $wpdb->get_row('SELECT * from '.$table_name.' where user_id = '.$current_user_id.' and media_id = '.$default_image_ids[$i], ARRAY_N );
                if ( empty( $result_arr ) || $result_arr == null ) { ?>

                <a href="#" class="cpm-like-btn loading" data-smallurl="<?php echo $image['thumb'][0]; ?>" data-largeurl="<?php echo $import_image['gallery_images_url']; ?>" data-imgid="<?php //echo $default_image_ids[$i]; ?>" data-userid="<?php echo $current_user_id; ?>" >
                    <span class="fa fa-heart-o"></span>
                </a>
                <?php
            }
        }*/ ?>

    </div>

    <?php $i++; endforeach; ?>

</div>

<div class="<?php echo $this->slug; ?>-loading-overlay"><i class="<?php echo $this->slug; ?>-icon-loading"></i></div>

</div>

<?php

} else{

    if(!empty($images)) { ?>

    <div class="<?php echo $this->slug; ?>-images-wrap">

       <div class="<?php echo $this->slug; ?>-images <?php if( $jck_wt['clickAnywhere'] ) echo $this->slug."-images--click_anywhere"; ?>">

           <?php $i = 0; foreach($images as $image):

           ?>

           <div class="<?php echo $this->slug; ?>-images__slide <?php if($i == 0) echo $this->slug."-images__slide--active"; ?>" data-index="<?php echo $i; ?>">

             <img class="<?php echo $this->slug; ?>-images__image" src="<?php echo $image['large'][0]; ?>" data-large-image="<?php echo $image['large'][0]; ?>" data-large-image-width="<?php echo $image['large'][1]; ?>" >
             <a data-pin-do="buttonPin" data-share-url="<?php echo esc_url(get_permalink()); ?>" data-share-description="<?php echo $image['alt'] ?>" data-share-media="<?php echo $image['large'][1]; ?>" class="cpm-pin-it" href="https://www.pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&media=<?php echo $image['large'][1]; ?>&description=<?php echo $image['alt']; ?>" data-pin-custom="true"><i class="fa fa-pinterest fa-3" aria-hidden="true"></i></a>
             <?php if ( is_user_logged_in() && is_numeric( $default_image_ids[$i] ) && !empty( $default_image_ids[$i] ) ) {

                global $wpdb;
                $table_name = $wpdb->prefix . "wishlists_image";


                $current_user_id = get_current_user_id();
                $result_arr = $wpdb->get_row('SELECT * from '.$table_name.' where user_id = '.$current_user_id.' and media_id = '.$default_image_ids[$i], ARRAY_N );
                if ( empty( $result_arr ) || $result_arr == null ) { ?>

                <a href="#" class="cpm-like-btn loading" data-smallurl="<?php echo $image['thumb'][0]; ?>" data-largeurl="<?php echo $image['large'][0]; ?>" data-imgid="<?php echo $default_image_ids[$i]; ?>" data-userid="<?php echo $current_user_id; ?>" >
                    <span class="fa fa-heart-o"></span>
                </a>
                <?php
            }
        } ?>

    </div>

    <?php $i++; endforeach; ?>

</div>

<div class="<?php echo $this->slug; ?>-loading-overlay"><i class="<?php echo $this->slug; ?>-icon-loading"></i></div>

</div>

<?php

}

}
?>