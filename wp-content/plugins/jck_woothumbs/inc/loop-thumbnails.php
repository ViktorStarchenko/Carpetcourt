<?php global $jck_wt;

$imported_images = get_field('gallery_images');
 $imported_tags =get_field('gallery_tag');
if ( !empty( $imported_images[0]['gallery_images_url'] ) ) { ?>
<div class="<?php echo $this->slug; ?>-thumbnails-wrap <?php echo $this->slug; ?>-thumbnails-wrap--<?php echo $jck_wt['navigationType']; ?>">

    <div class="<?php echo $this->slug; ?>-thumbnails">

        <?php $import_image_count = count($imported_images); ?>

        <?php //if( $import_image_count > 1 ) { ?>

        <?php $i = 0; foreach($imported_images as $import_image): ?>

        <div class="<?php echo $this->slug; ?>-thumbnails__slide <?php if($i == 0) { ?><?php echo $this->slug; ?>-thumbnails__slide--active<?php } ?>" data-index="<?php echo $i; ?>">

            <img class="<?php echo $this->slug; ?>-thumbnails__image" src="<?php echo $import_image['gallery_images_url']; ?>" alt="<?php echo $imported_tags[$i]['gallery_images_tag'];?>">
            <a data-pin-do="buttonPin" data-share-url="<?php echo esc_url(get_permalink()); ?>" data-share-description="<?php echo get_the_title(); ?>" data-share-media="<?php echo $import_image['gallery_images_url']; ?>" class="cpm-pin-it" href="https://www.pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&media=<?php echo $import_image['gallery_images_url']; ?>&description=<?php echo get_the_title(); ?>" data-pin-custom="true"><i class="fa fa-pinterest fa-3" aria-hidden="true"></i></a>

        </div>

        <?php $i++; endforeach; ?>

        <?php //} ?>

    </div>
</div>

<?php
} else {

    if(!empty($images)) {
        ?>

        <div class="<?php echo $this->slug; ?>-thumbnails-wrap <?php echo $this->slug; ?>-thumbnails-wrap--<?php echo $jck_wt['navigationType']; ?>">

           <div class="<?php echo $this->slug; ?>-thumbnails">

               <?php $image_count = count($images); ?>

               <?php if( $image_count > 1 ) { ?>

               <?php $i = 0; foreach($images as $image): ?>

               <div class="<?php echo $this->slug; ?>-thumbnails__slide <?php if($i == 0) { ?><?php echo $this->slug; ?>-thumbnails__slide--active<?php } ?>" data-index="<?php echo $i; ?>">

                 <img class="<?php echo $this->slug; ?>-thumbnails__image" src="<?php echo $image['thumb'][0]; ?>" >
                 <a data-pin-do="buttonPin" data-share-url="<?php echo esc_url(get_permalink()); ?>" data-share-description="<?php echo $image['alt'] ?>" data-share-media="<?php echo $image['large'][1]; ?>" class="cpm-pin-it" href="https://www.pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&media=<?php echo $image['large'][1]; ?>&description=<?php echo $image['alt']; ?>" data-pin-custom="true"><i class="fa fa-pinterest fa-3" aria-hidden="true"></i></a>

             </div>

             <?php $i++; endforeach; ?>

             <?php

                // pad out thumbnails if there are less than the number
                // which are meant to be shown.

             if( $image_count < $jck_wt['thumbnailCount'] ) {

               $empty_count = $jck_wt['thumbnailCount'] - $image_count;
               $i = 0;

               while( $i < $empty_count ) {

                   echo "<div></div>";
                   $i++;

               }

           }

           ?>

           <?php } ?>

       </div>

   </div>

   <?php
}

}
?>