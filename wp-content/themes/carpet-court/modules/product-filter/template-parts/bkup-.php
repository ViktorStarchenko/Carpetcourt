<?php
/**
 * filter page used in loop
 */
// get post id
$term_related_id = get_term_meta($single->term_id, 'related_post_id', true);
?>

<li class="col-md-4 col-sm-4 col-xs-12 wow rent-sell-wrap fadeInUp">
	<div class="grid-item-content">
    <div class="fig-wrap">
      <figure class="fig-hover">
          
              <img src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' )?>" width="340" height="260" class="wp-post-image" >
               <div class="hover-overlay"> </div>
               <figcaption class="hover-title fig-hover-one">
                  <div class="fig-title" data-href="<?php echo get_permalink( $term_related_id ) ;?>" data-taxonomy="<?php echo $taxonomy;?>" data-term="<?php echo $single->term_id ?>" data-post="<?php echo $term_related_id; ?>" >
                      <span class="active-first"><i class="line top"></i><?php echo $single->name ?><i class="line bottom"></i></span>
                      <span class="visible-only-hover"><?php _e( sprintf('%s',$single->name ),'carpet-court');?></span>
                  </div>
              </figcaption>
          
      </figure>
      <?php 
        //if ( is_page( 'product-guide' ) ) { ?>
          
      <a href="#" class="cpm_filter_tax <?php echo $taxonomy ?>" id="term_<?php echo $single->term_id ?>" data-name="<?php echo $single->name ?>" data-term="<?php echo $single->term_id ?>" data-taxonomy="<?php echo $taxonomy ?>">
           <div class="select" id="attr_term_<?php echo $single->term_id ?>"><span class="glyphicon glyphicon-ok invisible"></span> SELECT & CONTINUE</div>
      </a>
          <?php
        //}
      ?>
      <form id="form-submit_<?php echo $single->term_id ?>" action="<?php echo get_permalink( $term_related_id ) ;?>" method="post" target="my_iframe">
         <input type="hidden" name="term" value="<?php echo $single->term_id ?>" />
         <input type="hidden" name="taxonomy" value="<?php echo $taxonomy;?>" />
      </form>  
    </div>

    <div class="fig-overlay">
      <div class="col-md-6 col-sm-6 details">
        <h4><?php echo $single->name ?></h4>
        <p><?php echo $single->description; ?></p>          
      
       <!--  <a href="#" class="modal_popup cc_product_filter_image view-btn" data-href="<?php //echo get_permalink( $term_related_id ) ;?>" data-taxonomy="<?php //echo $taxonomy;?>" data-term="<?php //echo $single->term_id ?>" data-post="<?php //echo $term_related_id; ?>" >
        View more details
        </a> -->

        <?php 
        if ( is_page( 'product-guide' ) ) { ?>
        <a href="#" class="cpm_filter_tax <?php echo $taxonomy ?>" id="term_<?php echo $single->term_id ?>" data-name="<?php echo $single->name ?>" data-term="<?php echo $single->term_id ?>" data-taxonomy="<?php echo $taxonomy ?>">
          <div class="select" id="attr_term_<?php echo $single->term_id ?>"><span class="glyphicon glyphicon-ok invisible"></span> SELECT & CONTINUE</div>
        </a>
        <?php } ?>
        <form id="form-submit_<?php echo $single->term_id ?>" action="<?php echo get_permalink( $term_related_id ) ;?>" method="post" target="my_iframe">
         <input type="hidden" name="term" value="<?php echo $single->term_id ?>" />
         <input type="hidden" name="taxonomy" value="<?php echo $taxonomy;?>" />
      </form> 
      </div>
      <div class="col-md-6 col-sm-6 img">
        <img src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' )?>" width="340" height="260" class="wp-post-image" >
      </div>    
    </div>
  </div>
</li>


<li class="col-md-4 col-sm-4 col-xs-12 wow fadeInUp">
    <div class="grid-item-content">
        <div class="fig-wrap">
            <a href="<?php echo get_permalink( get_page_by_path( 'product-guide/'.$step ) ); ?>" class="diagnostic_filter_tax" id="term_<?php echo $step; ?>">

                <figure class="fig-hover">            
                    <img src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' )?>" width="340" height="260" class="wp-post-image" >
                    <div class="cpm-block-title">
                        <div class="c-table">
                          <span class="t-cell">
                            <h3 class="title"><?php echo ucfirst($step); ?></h3>
                          </span>
                        </div>
                    </div>
                </figure>    

                <figcaption class="hover-title fig-hover-one">
                    <div class="fig-title" >
                        <div class="vert-middle">
                            <div class="div">
                                <h3 class="title"><?php echo ucfirst($step); ?></h3>
                                <p><?php echo ( !empty( $step_description ) ) ? $step_description : ''; ?></p>
                            </div>
                        </div>
                    </div>
                </figcaption>                  
            </a>
        </div>
    </div>
</li>
