<?php
/**
 * filter page used in loop
 */
// get post id
$term_related_id = get_term_meta($single->term_id, 'related_post_id', true);

if ( $taxonomy == 'pa_sell' ) {
  $class_atrr = 'col-md-3 col-sm-3';
} else {
  $class_atrr = 'col-md-4 col-sm-4';
}
?>

<li class="<?php echo $class_atrr; ?> col-xs-12 wow fadeInUp">
  <div class="grid-item-content">
    <div class="fig-wrap">

      <figure class="fig-hover">
       <img src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' )?>" width="340" height="260" class="wp-post-image" >
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

            <a href="#" class="cpm_filter_tax <?php echo $taxonomy ?>" id="term_<?php echo $single->term_id ?>" data-name="<?php echo $single->name ?>" data-term="<?php echo $single->term_id ?>" data-taxonomy="<?php echo $taxonomy ?>">
             <div class="select" id="attr_term_<?php echo $single->term_id ?>"><span class="glyphicon glyphicon-ok invisible"></span> CHOOSE THIS</div>
           </a>

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
