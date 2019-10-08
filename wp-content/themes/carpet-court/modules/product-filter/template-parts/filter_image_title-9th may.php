<?php
/**
 * filter page used in loop
 */
// get post id
$term_related_id = get_term_meta($single->term_id, 'related_post_id', true);
?>

<div class="col-md-4 col-sm-4 col-xs-6 mb-20 grid-item wow fadeInUp">
	<div class="grid-item-content">
		<div class="fig-wrap">
			<figure class="fig-hover">
					
							<img src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' )?>" width="340" height="260" class="wp-post-image" >
							 <div class="hover-overlay"> </div>
							 <figcaption class="hover-title fig-hover-one">
									<div class="fig-title" data-href="<?php echo get_permalink( $term_related_id ) ;?>" data-taxonomy="<?php echo $taxonomy;?>" data-term="<?php echo $single->term_id ?>" data-post="<?php echo $term_related_id; ?>" >
											<span class="active-first"><?php echo $single->name ?></span>
											<span class="visible-only-hover"><?php _e( sprintf('Click here to view<br/>%s',$single->name ),'carpet-court');?> <i class="fa fa-angle-right"></i></span>
									</div>
							</figcaption>
					
			</figure>
			<a href="#" class="filter_tax <?php echo $taxonomy ?>" data-taxonomy="<?php echo $taxonomy ?>" id="term_<?php echo $single->term_id ?>" data-name="<?php echo $single->name ?>" data-term="<?php echo $single->term_id ?>">
					 <div class="select" id="attr_term_<?php echo $single->term_id ?>"><span class="glyphicon glyphicon-ok invisible"></span> SELECT & CONTINUE</div>
			</a>
			<form id="form-submit_<?php echo $single->term_id ?>" action="<?php echo get_permalink( $term_related_id ) ;?>" method="post" target="my_iframe">
				 <input type="hidden" name="term" value="<?php echo $single->term_id ?>" />
				 <input type="hidden" name="taxonomy" value="<?php echo $taxonomy;?>" />
			</form>  
		</div>

		<div class="fig-overlay">
			<div class="col-md-6 details">
				<h4><?php echo $single->name ?></h4>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est fuga eaque nesciunt dicta aut minus</p>					
			
				<a href="#" class="modal_popup cc_product_filter_image view-btn" data-href="<?php echo get_permalink( $term_related_id ) ;?>" data-taxonomy="<?php echo $taxonomy;?>" data-term="<?php echo $single->term_id ?>" data-post="<?php echo $term_related_id; ?>" >
				View more details
				</a>

				<a href="#" class="filter_tax <?php echo $taxonomy ?>" data-taxonomy="<?php echo $taxonomy ?>" id="term_<?php echo $single->term_id ?>" data-name="<?php echo $single->name ?>" data-term="<?php echo $single->term_id ?>">
					<div class="select" id="attr_term_<?php echo $single->term_id ?>"><span class="glyphicon glyphicon-ok invisible"></span> SELECT & CONTINUE</div>
				</a>
			</div>
			<div class="col-md-6 img">
				<img src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' )?>" width="340" height="260" class="wp-post-image" >
			</div>		
		</div>
	</div>
</div>

