<style type="text/css">
    .list-product-wrap{
        max-width: 100% !important;
        margin-bottom: 15px;
        overflow: hidden;
    }
    .cat_block{
        width: 33.33333%;
        padding: 30px;
        float: left;
        text-align: center;
    }
    .cat_block img{
        width: 100%;
    }
    .fa-heart-o{
        position: relative;
        top:8px;
    }
    .cat_title{
    margin-top: -91px;
    display: block;
    font-weight: bold;
    color: white;
    font-size: 25px;
    letter-spacing: 2px;
    padding: 0 10px;
        min-height: 75px;
    }
    
    .text_container{
        width: 90%;
        margin: 0 auto;
        margin-top: 30px;
    }
    #colophon{
        height: 0px;
    }
    .product-filter-banner img{
    width: 100%;
}
</style>
<?php
/**
 * Template Name: Fibers page
 */
get_header();

$field = $value='';

foreach($_POST as $key => $val) {
    if( isset( $_POST[$key] ) ) {
        $field = $key;
        $value = $val;
        break;
    }
}
if($field !='') {
    ?>
    <script>
        var post_key={<?php echo $field;?>:[<?php echo implode(",", $value );?>]};
    </script>
<?php }

       global $wpdb;
$table_name = $wpdb->prefix . 'slider_sliders';
$slider = get_field('slider_shortcode');
$mobile_slider = get_field('mobile_slider');
$show_random_slider = get_field('show_random_slider');

$add_slider_shortcode = '';
$cc_slider_ids = '';
?>

<div class="desktop-view">
    <?php
    $show_slider = false;
    if ( $show_random_slider == 'no' ) {
        $add_slider_shortcode = get_field('add_slider_shortcode');
        echo do_shortcode($add_slider_shortcode);
        if ( !empty( $add_slider_shortcode ) ) {

            $show_slider = true;
        }
    } elseif ( $show_random_slider == 'yes' ) {
        $cc_slider_ids = get_post_meta( $post->ID, 'selected_random_sliders', true );
        if ( !empty( $cc_slider_ids ) ) {

            $show_slider = true;
        }
        if( empty( $cc_slider_ids ) ) {
            $cc_slider_ids = array( '1' );
        }
        shuffle( $cc_slider_ids ) ;
        echo do_shortcode( '[cc_slider id="'.$cc_slider_ids[0].'"]' );
    } else {
        echo do_shortcode( $slider );
    } ?>
</div>
<?php

    if ( !empty( $mobile_slider ) ) { ?>

        <div class="mobile-view">
            <?php echo do_shortcode( $mobile_slider ); ?>
        </div>

        <?php
    }

    $margin_top_class = '';
    if ( !$show_slider ) {
        $margin_top_class = 'cpm-margin-no-slider';
    }
?>
<?php //echo do_shortcode('[websitetour id="7871"]'); ?>
<div class="container-fluid pad0lr <?php echo $margin_top_class; ?>" id="home-content-wrap">
    <?php
        $product_banner = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
        if ( !empty( $product_banner ) ) {
            ?>
        <div class="product-filter-banner">
            <img src="<?php echo $product_banner; ?>">
        </div>

            <?php
        }

    ?>

    <main id="main" role="main">
        <div id="hidden_breadcrumb" style="display:none;">
            <?php if(function_exists('woocommerce_breadcrumb')):woocommerce_breadcrumb();endif;?>
        </div>
        <div class="col-md-12 pad0lr-xs">
        <div class="text_container">
            <?php the_content(); ?>
        </div>
        <div class="cc-filter-dark">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <!-- <div class="fig-content">
                            <span class="line-top"></span>
                            <h2 class="alt-text"><?php //_e("PRODUCTS FOR YOU", "cc_filter_product") ?> </h2>
                            <span class="line-bottom"></span>
                        </div> -->
                        <ul class="thumbs-step">
                            <li class="media">
                              <a href="<?php echo esc_url(home_url('/')); ?>measure-and-quote/">
                              <div class="media-left">
                                <img class="media-object" src="<?php echo get_template_directory_uri(); ?>/assets/images/tape.png" alt="Generic placeholder image">
                                </div>
                              <div class="media-body">
                                <h4 class="media-heading">BOOK A MEASURE AND QUOTE</h4>
                              </div>
                              </a>
                            </li> <!-- media ends-->
                            <li class="media">
                              <a href="<?php echo esc_url(home_url('/')); ?>advice/q-card/">
                              <div class="media-left">
                                <img class="media-object" src="<?php echo get_template_directory_uri(); ?>/assets/images/dollar.png" alt="Generic placeholder image">
                                </div>
                              <div class="media-body">
                                <h4 class="media-heading">FINANCE YOUR FLOOR</h4>
                              </div>
                              </a>
                            </li> <!-- media ends-->
                            <li class="media">
                              <a href="javascript:void(0)" onclick="document.getElementById('cc-cat-form-specials').submit(); return false;" >
                              <div class="media-left">
                                    <img class="media-object" src="<?php echo get_template_directory_uri(); ?>/assets/images/tag.png" alt="Generic placeholder image">
                                    </div>
                                <form style="display: none;" id="cc-cat-form-specials" action="<?php echo esc_url( home_url() ); ?>/product-filter/" method="POST" >
                                      <?php $term = get_term_by( 'name', 'Specials', 'product_tag', OBJECT );  ?>
                                      <input name="product_tag[]" value="<?php echo $term->term_id; ?>" type="hidden">
                                  </form>
                              <div class="media-body">
                                <h4 class="media-heading">see our specials</h4>
                              </div>
                                      </a>
                            </li> <!-- media ends-->
                        </ul>
                    </div>


                </div>
            </div>
        </div>
                <div style="margin: 0 30px;">
                  

                        </div>
                    <!-- </div> -->
                </div>
        </div>
        <?php 
		$cat = get_term_by( 'slug', get_query_var("cat_slug"), 'product_cat' );
        $cat_id = $cat -> term_id;
		$cat_slug = $cat -> slug;
       
         global $wpdb;
                $table_name = $wpdb->prefix . "terms";
                $cat_name = $wpdb->get_results("SELECT slug from $table_name WHERE term_id = $cat_id");
                foreach ($cat_name as $row2) {
                   $cat_slag =$row2->slug;
                    
                 }
         
             
               echo '<div class="list-product-wrap">';
               $args = array(
            'post_type' => 'product',
            'product_cat' => $cat_slag,
            'posts_per_page' => 300
            
            );
        $loop = new WP_Query( $args );
        if ( $loop->have_posts() ){
            $pa_fibres = array();
                $pa_material = array();
            while ( $loop->have_posts() ) : $loop->the_post();
                global $product;
                
                $taxonomies_slug = array(
                    'pa_fibres',
                    'pa_materials',
                );

                //$arr_fibre = array_unique( $taxonomies_slug);

                
                foreach ($taxonomies_slug as $slug){

                    //$tax_detail = get_taxonomy($slug);
                    $attributes = $product->get_attribute($slug);
                    if ($attributes != ''){
                            //echo $tax_detail->labels->name;
                            // echo $attributes; 
                        if($slug == 'pa_fibres'){
                            $pa_fibres[] = $attributes;
                        }else if($slug == 'pa_materials'){
                            $pa_material[] = $attributes;
                        }
                    }
                }
            endwhile;
            $pa_fibres = array_unique($pa_fibres);
            $pa_material = array_unique($pa_material);


        foreach($pa_fibres as $fibre ) :

        $fibre_data = get_term_by( 'name', $fibre, 'pa_fibres');
        $fibre_id = $fibre_data->term_id;
		$fibre_slug = $fibre_data -> slug;
        $thumbnail_id = absint( get_term_meta( $fibre_id,'thumbnail_id', true ) );


        if ( $thumbnail_id ) {
            $image = wp_get_attachment_thumb_url( $thumbnail_id );
        } else {
            $image = wc_placeholder_img_src();
        }

    ?>
        <div class="cat_block">
        <div class="cat_img">
        <a href="https://carpetcourt.nz/category/<?php echo $cat_slug; ?>/<?php echo $fibre_slug; ?>/">
        <div class="overlay"></div>
         <img src="<?php echo $image; ?>"  />
        </a>
        <a class="cat_title" href="https://carpetcourt.nz/category/<?php echo $cat_slug; ?>/<?php echo $fibre_slug; ?>/"><?php echo $fibre; ?></a>
        </div>
        
        </div>


    <?php endforeach; wp_reset_query();

        }


      /*
        $loop = new WP_Query( $args );
        if ( $loop->have_posts() ) { 
            
     ?>
  

       <?php while ( $loop->have_posts() ) : $loop->the_post();
            global $product;
            $get_permalink = get_permalink(); ?>

           
            <div class="list-attributes">
                <?php
                    // Get product attributes for fibre and material



                $taxonomies_slug = array(
                    'pa_fibres'
                    );

                $arr_fibre = array_unique( $taxonomies_slug);


                foreach ($taxonomies_slug as $slug):
                    $tax_detail = get_taxonomy($slug);
                    $attributes = $product->get_attribute($slug);
                    if ($attributes != ''):
                        ?>
                    <div class="list-attribute">
                        <span><?php echo $tax_detail->labels->name; ?>:</span>
                        <?php echo $attributes; ?>
                    </div>
                    <?php
                    endif;
                endforeach;

                $taxonomies_slug2 = array(
                    'pa_material'
                    
                    );


                foreach ($taxonomies_slug2 as $slug):
                    $tax_detail = get_taxonomy($slug);

                
                    $attributes = $product->get_attribute($slug);
                    if ($attributes != ''):
                        ?>
                    <div class="list-attribute">
                        <span><?php echo $tax_detail->labels->name; ?>:</span>
                        <?php echo $attributes; ?>
                    </div>
                    <?php
                    endif;
                endforeach;
                ?>
            </div>
           


<!-- </div> -->
</a>
</div><?php
            endwhile; ?>
           
      <?php  } else {
           // echo __( 'No products found' );
        }
        echo '</div>'; */
        wp_reset_postdata();
             
        
         

        ?>
      
    </main>
</div>
<?php get_footer();