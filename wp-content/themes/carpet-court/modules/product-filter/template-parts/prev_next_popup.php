<?php
/**
 *  Filter page part
 *  used for navigating taxonomy pages
 */
if ( $taxonomy != 'product_color') {
?>
<div class="content-slide-navigation mt-50 mb-50 clearfix">

    <ul class="mobile-view">

        <?php if( !is_null( $previous_link_array ) ) {
            $term_related_id = get_term_meta($previous_link_array['term_id'], 'related_post_id', true);
            ?>

            <li class="prev-left">
                <a href="#" class="filter_popup_navigation  prev" data-page="<?php echo $is_page; ?>" data-control="prev" data-taxonomy="<?php echo $taxonomy;?>" data-post="<?php echo $term_related_id; ?>" data-term="<?php echo $previous_link_array['term_id']?>"><i class="fa fa-angle-left"></i> <span><?php echo $previous_link_array['name']; ?></span></a>

            </li>

            <?php }

            if( !is_null( $next_link_array ) ) {

                $term_related_id = get_term_meta($next_link_array['term_id'], 'related_post_id', true);
                ?>
                <li class="next-right">
                    <a href="#" class="filter_popup_navigation next" data-page="<?php echo $is_page; ?>" data-control="next" data-taxonomy="<?php echo $taxonomy;?>" data-post="<?php echo $term_related_id; ?>" data-term="<?php echo $next_link_array['term_id'];?>"><span> <?php echo $next_link_array['name'];?> </span> <i class="fa fa-angle-right"></i> </a>

                </li>

                <?php } ?>
            </ul>
            <?php if ( $taxonomy != 'product_color') {?>
            <div class="content-navigation-slide content-prev col-md-3 desktop-view">
                <?php if( !is_null( $previous_link_array ) ) {
                    $term_related_id = get_term_meta($previous_link_array['term_id'], 'related_post_id', true);
                    ?>

                    <a href="#" class="filter_popup_navigation  prev" data-page="<?php echo $is_page; ?>" data-control="prev" data-taxonomy="<?php echo $taxonomy;?>" data-post="<?php echo $term_related_id; ?>" data-term="<?php echo $previous_link_array['term_id']?>"><i class="fa fa-5x fa-angle-left"></i> <span><?php echo $previous_link_array['name']; ?></span></a>

                    <?php } ?>
                </div>
                <?php } ?>


                <div class="modelbox-content-slide col-md-6">
                    <?php
                    if ( $taxonomy != 'product_color' ) {

                        ?>
                        <div class="modelbox-slide-content">
                            <?php echo  get_field('content');?>
                        </div>

                        <?php
                    }
                    $post_type =  get_post_type();

                    if ( $post_type == 'attribute' && $is_page == 1 ) { ?>

                    <div class="form-select-continue">
                        <a href="#" class="form-select-continue-link btn btn-cc btn-cc-orange" data-taxonomy="<?php echo $taxonomy;?>" data-term="<?php echo $term;?>" > <?php _e("Select & Continue","cc_product_filter")?></a>
                    </div>
                    <?php } ?>
                </div>

                <?php if ( $taxonomy != 'product_color') {?>
                <div class="content-navigation-slide content-next col-md-3 desktop-view">
                    <?php if( !is_null( $next_link_array ) ) {
                        $term_related_id = get_term_meta($next_link_array['term_id'], 'related_post_id', true);
                        ?>

                        <a href="#" class="filter_popup_navigation next" data-page="<?php echo $is_page; ?>" data-control="next" data-taxonomy="<?php echo $taxonomy;?>" data-post="<?php echo $term_related_id; ?>" data-term="<?php echo $next_link_array['term_id'];?>"><span> <?php echo $next_link_array['name'];?> </span> <i class="fa fa-5x fa-angle-right"></i> </a>

                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>