<?php
/**
 * filter page used in loop
 */
// get post id
$term_related_id = get_term_meta($single->term_id, 'related_post_id', true);

$col_md_class = '';
if ( $taxonomy == 'pa_filter-colour' ) {
  $col_md_class = 'col-md-3 col-sm-3';
} else {
  $col_md_class = 'col-md-4 col-sm-4';
}


?>


<li class="<?php echo $col_md_class; ?> col-xs-12 wow fadeInUp">
  <div class="grid-item-content">
    <div class="fig-wrap">

      <figure class="fig-hover">
        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' ); ?>" width="620" height="470" class="wp-post-image" >
        <div class="cpm-block-title">
          <div class="c-table">
            <span class="t-cell">
              <h3 class="title"><?php echo $single->name ?></h3>
            </span>
          </div>
        </div>
      </figure>

      <figcaption class="hover-title fig-hover-one">
        <div class="fig-title" >
          <div class="vert-middle">
            <div class="div">
              <h3 class="title"><?php echo $single->name ?></h3>
              <p><?php echo $single->description; ?></p>


              <a href="#" class="modal_popup cc_product_filter_image view-btn" data-href="<?php echo get_permalink( $term_related_id ) ;?>" data-taxonomy="<?php echo $taxonomy;?>" data-term="<?php echo $single->term_id ?>" data-page="<?php echo (is_page('keep') || is_page('keep') || is_page('keep') ) ? 1 : 0; ?>" data-post="<?php echo $term_related_id; ?>" >
                VIEW MORE
              </a>

              <?php

              if ( is_page( 'product-guide' ) || is_page( 'rent' ) || is_page( 'sell' ) || is_page( 'keep' ) ) {
                $filter_tax_btn = '' ;
                if ( $taxonomy != 'product_color' ) {
                  $filter_tax_btn = 'filter_tax ';
                }
                ?>
                <a href="#" class="<?php echo $filter_tax_btn.$taxonomy ?>" data-taxonomy="<?php echo $taxonomy ?>" id="term_<?php echo $single->term_id ?>" data-name="<?php echo $single->name ?>" data-term="<?php echo $single->term_id ?>">
                  <div class="select" id="attr_term_<?php echo $single->term_id ?>"><span class="glyphicon glyphicon-ok invisible"></span> CHOOSE THIS</div>
                </a>
                <?php } ?>

                <form id="form-submit_<?php echo $single->term_id ?>" action="<?php echo get_permalink( $term_related_id ) ;?>" method="post" target="my_iframe">
                 <input type="hidden" name="term" value="<?php echo $single->term_id ?>" />
                 <input type="hidden" name="taxonomy" value="<?php echo $taxonomy;?>" />
               </form>

             </div>
           </div>
         </div>
       </figcaption>
     </div>
   </div>
 </li>