<?php
// single title
function cc_woocommerce_template_single_title() { ?>
<!--<h1 itemprop="name" class="product_title entry-title mobile-view"><?php the_title(); ?></h1>-->
<?php
}

// single description
function cc_woocommerce_template_single_description() {

	global $post;

	if ( ! $post->post_excerpt ) {
		return;
	}

	?>
	<!--<div itemprop="description" class="mobile-view">
		<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?>
	</div>-->
	<?php
}

//booking button
function cc_woocommerce_template_book_button() {
	global $product, $post;


	$best_for = get_post_meta($product->id, 'best_for', true);
	$avoid_if = get_post_meta($product->id, 'avoid_if', true);
	$post_indent = get_post_meta($product->id, 'post_indent', true);
	$maintenance = get_post_meta($product->id, 'maintenance', true);
$features = get_the_terms( $product->ID, 'product_feature' );
	if ( $features && ! is_wp_error( $features ) ) :
		?>

	<div class="cc-works-well clearfix mobile-view">
		<h2 class="inner-section-title inner-section-title-1 alt-text"><span><?php _e('Key Features','carpet-court');?></span></h2>
		<ul class="cc-product-features hi-icon-effect-9 hi-icon-big hi-icon-effect-9b text-center">
			<?php
			$key_features = array();
			foreach ( $features as $term ) {
				$key_features[] = $term->name;
				$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
				if ( $thumbnail_id ) {
					$image = wp_get_attachment_thumb_url( $thumbnail_id );
				} else {
					$image = wc_placeholder_img_src();
				}
				$image = str_replace( ' ', '%20', $image );
				?>
				<li>
					<span class="hi-icon hi-icon-images" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( $term->name );?>">
						<img src="<?php echo esc_url( $image );?>" alt="<?php echo esc_attr( $term->name );?>"  />
					</span>
				</li>
				<?php
			}
			?>

		</ul>
	</div>
<?php endif;
?>
<div class="cc-product-color mobile-view">

		<?php

		$colors = wp_get_object_terms( $product->id, 'pa_color' );


		$pa_floor = $pa_style = $product_color = '';

		$taxonomy_array = array( 'pa_floor', 'pa_style', 'product_color', 'pa_rent', 'pa_sell' );

		$related_swatches_array = array();
		foreach ($taxonomy_array as $taxonomy ) {
			if ( isset( $_GET[$taxonomy] ) && !empty( $_GET[$taxonomy] ) ) {

				if ( is_array( $_GET[$taxonomy] ) ) {

					foreach ($_GET[$taxonomy] as $get_value) {

						$related_color_swatches = cc_get_term_meta( $get_value, 'related_'.$taxonomy, true );
						if ( !empty( $related_color_swatches ) ) {

							foreach ($related_color_swatches as $swatches_value) {
								if ( !in_array($swatches_value, $related_swatches_array ) ) {
									array_push( $related_swatches_array, $swatches_value );
								}
							}
						}
					}
				} else {
					$related_color_swatches = cc_get_term_meta( $_GET[$taxonomy], 'related_'.$taxonomy, true );
					if ( !empty( $related_color_swatches ) ) {

						foreach ($related_color_swatches as $swatches_value) {
							if ( !in_array($swatches_value, $related_swatches_array ) ) {
								array_push( $related_swatches_array, $swatches_value );
							}
						}
					}
				}

			}
		}

		if ( !empty( $related_swatches_array ) ) {
			foreach ($colors as $keys => $color_value) {
				if ( !in_array( $color_value->term_id, $related_swatches_array ) ) {
					unset( $colors[$keys] );
				}
			}
		}

		if (!empty($colors)) {
			$first = true;
			foreach ($colors as $color) {
				if ($first === true) {
					echo '<h2 class="product-detail-label inner-section-title inner-section-title-1 alt-text">';
					printf(__('%s Colours %s%s', 'carpet-court'), '<span>', '</span>','');
					echo '</h2><h4 class="single-selected-color ">Selected Colour:&nbsp; '.$color->name.'</h4>';
					echo '<ul id="color-tabs" class="nav nav-tabs" role="tablist">';
				}
				$thumbnail_id = get_term_meta($color->term_id, 'thumbnail_id', true);
				$term_image = get_term_meta( $color->term_id, 'cpm_color_thumbnail', true );
                if ( !empty( $term_image ) ) {

                    $active = (true == $first) ? 'active' : '';

                    // $image = wp_get_attachment_image_src($thumbnail_id);
                    echo '<li role="presentation" class="' . $active . '" data-color="' . $color->name . '">';
                    echo '<a href=#' . $color->term_id . ' aria-controls="' . $color->term_id . '" role="tab" data-toggle="tab" class="clearfix"><img src="' . $term_image . '" width="30" height="30" class="cloud-zoom" data-zoom-image="' . $term_image . '"></a>';
                    echo '</li>';

                } elseif ($thumbnail_id) {
                    $active = (true == $first) ? 'active' : '';

                    $image = wp_get_attachment_image_src($thumbnail_id);
                    echo '<li role="presentation" class="' . $active . '" data-color="' . $color->name . '">';
                    echo '<a href=#' . $color->term_id . ' aria-controls="' . $color->term_id . '" role="tab" data-toggle="tab" class="clearfix"><img src="' . $image[0] . '" width="30" height="30" class="cloud-zoom" data-zoom-image="' . $image[0] . '"></a>';
                    echo '</li>';
                }
					$first = false;
			}
			echo '</ul>';
		}
		?>
</div>

<div class="cc-product-specs mobile-view">
	<span class="cc-sub-title alt-text"><?php _e('Product Information', 'carpet-court'); ?></span>
	<a class="collapse-icon" data-toggle="collapse" href="#collapse-specss" aria-expanded="true"
	aria-controls="collapse-specss">
	<span class="cc-icon-collapse"></span>
</a>
<hr/>
<div class="collapse" id="collapse-specss">
	<div class="collapse-container">
	<div itemprop="description" class="mobile-view">
		<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?>
	</div>
		<?php

			$product_info = new WC_Product($product);

		/*Category*/
		$prod_category = get_the_terms($post->ID, 'product_cat');

		$cat_array = array();
		foreach ($prod_category as $prod_value) {
			array_push( $cat_array, $prod_value->name);
		}
		$cat_count = sizeof($prod_category);

		?>
		<div class="product-detail-label">
			<span>category:</span>
			<?php echo implode( ', ', $cat_array ); ?>
		</div>
		<?php
	if (!empty($best_for)) {
		echo '<div class="product-detail-label mobile-view">';
		printf(esc_html__('%sBest For:%s%s', 'carpet-court'), '<span>', '</span>', $best_for);
		echo '</div>';
	}

	if (!empty($avoid_if)) {
		echo '<div class="product-detail-label mobile-view">';
		printf(esc_html__('%sAvoid If:%s%s', 'carpet-court'), '<span>', '</span>', $avoid_if);
		echo '</div>';
	}

	if (!empty($maintenance)) {
		echo '<div class="product-detail-label mobile-view">';
		printf(esc_html__('%sMaintenance:%s%s', 'carpet-court'), '<span>', '</span>', $maintenance);
		echo '</div>';
	}
	if (!empty($post_indent) && $post_indent == 1 ) {
		echo '<div class="product-detail-label mobile-view">';
		printf('Please be aware this product will take approximately 8 - 12 weeks to arrive. If you need something sooner - check <a href="'.home_url().'/our-products/product-filter/">here</a>');
		echo '</div>';
	}









		/* Suits Styles */
		$suit_styles = get_field('suits_styles');
    if ( !empty($suit_styles) ) {
            echo '<div class="product-detail-label">';
                // printf(esc_html__('%s suits styles: %s%s', 'carpet-court'), '<span>', '</span>', $suit_styles);
            ?>
            <span> Specifications: </span> <a class="blue-anchor" href="<?php  echo $suit_styles; ?>" target="_blank">View spec sheet</a>
            <?php
            echo '</div>';
            }


		/* Suits LifeStyle */
		$suit_lifestyle = get_field('suits_lifestyle');
		/* if (!empty($suit_lifestyle)) {
			echo '<div class="product-detail-label">';
			printf(esc_html__('%s suits lifestyle: %s%s', 'carpet-court'), '<span>', '</span>', $suit_lifestyle);
			echo '</div>';
		} */

		/*Price*/
		$price = $product->get_price_html();
		if (!empty($price)) {
			echo '<div class="product-detail-label">';
			printf(esc_html__('%s price: %s%s', 'carpet-court'), '<span>', '</span>', $price);
			echo '</div>';
		}

		/*Weight*/
		if ( $product_info->has_weight() ) {
			$weight = $product_info->get_weight() . ' ' . esc_attr(get_option('woocommerce_weight_unit'));
			if (!empty($weight)) {
				echo '<div class="product-detail-label">';
				printf(esc_html__('%s weight: %s%s', 'carpet-court'), '<span>', '</span>', $weight);
				echo '</div>';
			}
		}

		/*Fibre/ Materials*/
		$materials = get_the_terms($product->id, 'pa_materials');
		if (!empty($materials)) {
			echo '<div class="product-detail-label">';
			printf(esc_html__('%s material: %s', 'carpet-court'), '<span>', '</span>');
			foreach ($materials as $material) {
				echo $material->name;
			}
			echo '</div>';
		}
		$fibers = get_the_terms($product->id, 'pa_fibres');
		if (!empty($fibers)) {
			echo '<div class="product-detail-label">';
			printf(esc_html__('%s fibre: %s', 'carpet-court'), '<span>', '</span>');
			foreach ($fibers as $fiber) {
				echo $fiber->name;
			}
			echo '</div>';
		}


		/*Lifespan*/
		$lifespan = get_field('lifespan');
		if (!empty($lifespan)) {
			echo '<div class="product-detail-label">';
			printf(esc_html__('%s lifespan: %s%s', 'carpet-court'), '<span>', '</span>', $lifespan);
			echo '</div>';
		}

			echo '<div class="cc-btn-wrap clearfix mobile-view"><a href="#book-modal" data-toggle="modal" data-target="#book-modal" class="btn-cc btn-block btn-cc-red ">';
	_e('<span class="fa fa-angle-right"></span>  BOOK MEASURE AND QUOTE', 'carpet-court');
	echo '</a></div>';

		/*Stock*/
	           // echo '<div class="product-detail-label">';
	            //echo '<span>availability:</span>';
	            //if ($product_info->is_in_stock()):
	              //  _e('In Stock', 'carpet-court');
	           // else:
	               // _e('Out of Stock', 'carpet-court');
	           // endif;
	            //echo '</div>';
		?>
		<div class="cc-finance-cpm">

    <span class="cc-sub-title alt-text">Finance</span>
   <!-- <a class="collapse-icon" data-toggle="collapse" href="#cpm-finance" aria-expanded="true" aria-controls="cpm-finance">
        <span class="cc-icon-collapse"></span>
    </a>
    <hr>-->
    <div id="cpm-finance">

            <div class="tab-content">
                <?php //wc_get_template( 'single-product/rating.php' );
                    global $cc_options;
                 ?>
                 <a href="<?php echo esc_url( $cc_options['product_finance_link']); ?>" target="_blank">
                    <img src="<?php echo esc_url($cc_options['product_finance_media']['url']); ?>">
                 </a>
            </div>
        </div>

</div>
	</div>
</div>
</div>

<?php
}

// key features
function woocommerce_template_single_key_feaures() {
	wc_get_template('single-product/features.php');
}

// works well
function woocommerce_template_single_works_well() {
	// wc_get_template('single-product/works-well.php');
}

// other products
function woocommerce_template_single_other_products() {
	// wc_get_template('single-product/other_products.php');
}