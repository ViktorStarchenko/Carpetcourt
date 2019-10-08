<?php
$taxonomyName = "product_color";
	//This gets top layer terms only.  This is done by setting parent to 0.
$parent_terms = get_terms( $taxonomyName, array( 'parent' => 0, 'orderby' => 'slug', 'hide_empty' => false ) ); ?>
<div class="cpm-product-color-accents hidden">

  <div class="container full-width">
    <div class="text-centre">
      <div class="colored-cpm-bold">
        NOW, CHOOSE AN ACCENT COLOUR
      </div>
    </div>
    <div class="cpm-light-text">
      For a pop of colour in cushions, curtains and accessories:
    </div>
  </div>
  <ul class="cc_filter full-width-filter filter_product_color">
   <?php
   foreach ( $parent_terms as $pterm ) {
	    //Get the Child terms
     $terms = get_terms( $taxonomyName, array( 'parent' => $pterm->term_id, 'orderby' => 'slug', 'hide_empty' => false ) );
     foreach ( $terms as $term ) {

       $term_related_id = get_term_meta($term->term_id, 'related_post_id', true);

       $thumbnail_id = cc_get_term_meta( $term->term_id, 'thumbnail_id', true );

       $image = cc_placeholder_img_src('340x260');
       if ( $thumbnail_id ) {
         $image = wp_get_attachment_image_src( $thumbnail_id, 'category_image' );
         $image = $image[0];
       }

	        // Prevent esc_url from breaking spaces in urls for image embeds
	        // Ref: http://core.trac.wordpress.org/ticket/23605
       $image = str_replace( ' ', '%20', $image );
       ?>

       <li class="col-md-2 col-sm-2 col-xs-12 wow fadeInUp <?php echo $pterm->term_id; ?>">
        <div class="grid-item-content">
          <div class="fig-wrap">

            <figure class="fig-hover">
              <img src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' )?>" width="340" height="260" class="wp-post-image" >
              <div class="cpm-block-title">
                <div class="c-table">
                  <span class="t-cell">
                    <h3 class="title"><?php echo $term->name ?></h3>
                  </span>
                </div>
              </div>
            </figure>

            <figcaption class="hover-title fig-hover-one">
              <div class="fig-title" >
                <div class="vert-middle">
                  <div class="div">
                    <h3 class="title"><?php echo $term->name ?></h3>
                    <p><?php echo $term->description; ?></p>

                    <?php

                    if ( is_page( 'product-guide' ) || is_page( 'rent' ) || is_page( 'sell' ) || is_page( 'keep' ) ) { ?>
                    <a href="#" class="filter_tax" data-taxonomy="<?php echo $taxonomyName; ?>" id="term_<?php echo $term->term_id ?>" data-name="<?php echo $term->name ?>" data-term="<?php echo $term->term_id ?>">
                      <div class="select" id="attr_term_<?php echo $term->term_id ?>"><span class="glyphicon glyphicon-ok invisible"></span> CHOOSE THIS</div>
                    </a>
                    <?php } ?>
                    <form id="form-submit_<?php echo $term->term_id ?>" action="<?php echo get_permalink( $term_related_id ) ;?>" method="post" target="my_iframe">
                     <input type="hidden" name="term" value="<?php echo $term->term_id ?>" />
                     <input type="hidden" name="taxonomy" value="<?php echo $taxonomyName;?>" />
                   </form>
                 </div>
               </div>
             </div>
           </figcaption>
         </div>
       </div>
     </li>
     <?php
   }
 }
 ?>
</ul>
</div>
