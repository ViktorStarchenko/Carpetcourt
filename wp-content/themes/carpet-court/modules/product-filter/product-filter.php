<?php

define( 'PATH', get_stylesheet_directory().'/modules/product-filter/' );
define( 'PATH_URL', get_stylesheet_directory_uri().'/modules/product-filter/' );
define( 'PATH_TEMPLATE_DIR', get_stylesheet_directory_uri().'/modules/product-filter/templates/' );
define( 'PATH_TEMPLATE', get_stylesheet_directory().'/modules/product-filter/templates/' );

/**
 * helpers functions
 */
require __DIR__ . "/inc/functions-helper.php";
/**
 * Register CPT
 */
require __DIR__ . "/inc/cc-cpt.php";

/**
 * taxonomy registerations
 */
require __DIR__ . "/inc/cc-tags.php";

// scripts
require __DIR__ . "/inc/enqueue.php";

// custom page templates include
require __DIR__ . "/inc/class-template.php";


require __DIR__ . "/inc/filter_product.php";

// require __DIR__ . "/inc/woo-custom-heads.php";


// actions
add_action( 'init', array( 'CC_Cpt', 'get_instance' ),5 );

add_action( 'init', array( 'CC_tags', 'get_instance' ),10);

add_action( 'init', array( 'CC_Product_Filter_Enqueue', 'get_instance' ), 15 );

add_action( 'init', array( 'CC_Page_Template', 'get_instance' ),20 );

add_action('init', array('Filter_Product','get_instance'),25);


// add_action('init', array('Woo_Custom_Heads','get_instance'),25);



add_shortcode( 'cpm-cc-style-life', 'cpm_cc_style_life');
function cpm_cc_style_life( $atts ) {

	$values = shortcode_atts( array(
		'taxonomy'  =>  '',
		'term_id'	=> '',
		), $atts
	);
	ob_start();
	$taxonomy = '';
	if ( !empty( $values['taxonomy'] ) ) {
		$taxonomy = $values['taxonomy'];
	} else {
		$taxonomy = 'pa_style';
	}

	if ( !empty( $values['term_id'] ) ) { ?>
	<div class="container-fluid pad0lr">

		<ul class="cc_filter full-width-filter">
			<?php
			$term_related_id = get_term_meta($values['term_id'], 'related_post_id', true);

			$col_md_class = 'col-md-3 col-sm-3';
			$single = get_term_by( 'id', $values['term_id'], $taxonomy, OBJECT );

			$thumbnail_id = cc_get_term_meta( $values['term_id'], 'thumbnail_id', true );

			$image = cc_placeholder_img_src('340x260');
			if ( $thumbnail_id ) {
				$image = wp_get_attachment_image_src( $thumbnail_id, 'colour_palettes' );
				$image = $image[0];
			}

		    // Prevent esc_url from breaking spaces in urls for image embeds
		    // Ref: http://core.trac.wordpress.org/ticket/23605
			$image = str_replace( ' ', '%20', $image );

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

										<?php

										?>

										<a href="#" class="cpm_modal_popup cc_product_filter_image view-btn" data-href="<?php echo get_permalink( $term_related_id ) ;?>" data-taxonomy="<?php echo $taxonomy;?>" data-term="<?php echo $single->term_id ?>" data-post="<?php echo $term_related_id; ?>" data-page="<?php echo (is_page('keep') || is_page('keep') || is_page('keep') ) ? 1 : 0; ?>" >
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
			</ul>


			<div class="modal grow cpm-cc-style-modal" id="page-modal-popup-<?php echo $values['term_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
				<div class="modal-dialog modal-lg modal-xlg" role="document">

					<div class="modal-content">
						<div class="modalbox-header pull-right">
							<form>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
									aria-hidden="true">&times;</span></button>
								</form>
							</div>
							<div class="modal-body" id="post-popup-<?php echo $values['term_id']; ?>">
								<iframe id="my_iframe" name="my_iframe" src="" width="100%" height="1200px"></iframe>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
		} else {

			?>

			<div class="container-fluid pad0lr">

				<!-- multistep form -->
				<div id="msform">


					<!-- fieldsets -->
					<div class="col-sm-12 pad0lr-xs">

						<fieldset data-index="1" class="click-<?php echo $taxonomy; ?>">

								<!-- Style list an images -->
								<ul class="cc_filter full-width-filter">
									<?php cc_filter_template_looppp($taxonomy); ?>
								</ul>


						</fieldset>
					</div>
				</div>
			</div>

			<?php
		}

		$return = ob_get_clean();

		return $return;
	}