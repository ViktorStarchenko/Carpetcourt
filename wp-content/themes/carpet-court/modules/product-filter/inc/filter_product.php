<?php

/**
*  filter product classname
*/
class Filter_Product {

	private static $instance;

	public static function get_instance(){

		if (null == self::$instance ) {
			self::$instance = new Filter_Product();
		}
		return self::$instance;
	}

	private function __construct() {

		add_action('wp_ajax_nopriv_filter_popup_cpt', array( $this, 'ajax_generate_attributes_tags') );
		add_action('wp_ajax_filter_popup_cpt', array( $this, 'ajax_generate_attributes_tags') );

		add_action('cc_filter_navigation',array( $this, 'get_filter_navigation_popup') );

		add_action('cc_taxonomy_product_list',array( $this, 'fetch_taxonomy_product_list' ) );

		add_action('wp_ajax_nopriv_filter_product', array( $this, 'ajax_filter_products' ) );
		add_action('wp_ajax_filter_product', array( $this , 'ajax_filter_products' ) );
		add_action('wp_ajax_nopriv_filter_product_return_url', array( $this, 'ajax_filter_products_return_url' ) );
		add_action('wp_ajax_filter_product_return_url', array( $this , 'ajax_filter_products_return_url' ) );
		add_action('wp_ajax_nopriv_product_color_filter_popup_cpt', array( $this, 'ajax_product_color_filter_popup_cpts' ) );
		add_action('wp_ajax_product_color_filter_popup_cpt', array( $this , 'ajax_product_color_filter_popup_cpts' ) );

		add_action('wp_ajax_nopriv_generate_filter_queries', array( $this, 'ajax_filter_queries' ) );
		add_action('wp_ajax_generate_filter_queries', array( $this , 'ajax_filter_queries' ) );

	}

	public function ajax_generate_attributes_tags(){
		$param = array(
			'term'=>$_POST['term'],
			'taxonomy'=>$_POST['taxonomy']
			);
		$post_id = $_POST['post_id'];
		$url = get_permalink( $_POST['post_id'] );

		$post_wquery = new WP_Query( array( 'p' => $post_id, 'post_type' => 'attribute' ) );
		if ( $post_wquery->have_posts() ) {
			while ( $post_wquery->have_posts() ) {
				$post_wquery->the_post(); ?>

				<div class="site-content">
					<div id="primary" class="content-area container">
						<main id="main" class="site-main" role="main">
						<?php $style="";
						if( has_post_thumbnail( get_the_ID() ) ) {
							// the_post_thumbnail_url('full');
							$feat_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
							$style = 'style="background: url('.$feat_image.') repeat; padding: 20px 0px;"';
							}?>
							<div class="popup-banner thumbnl-url" <?php echo $style; ?>>
								<div class="popup-banner-image" style="display: none;">
									<?php if( has_post_thumbnail( get_the_ID() ) ) {
										the_post_thumbnail('thumbnail');
									}
									?>
								</div>
								<div class="popup-banner-content">
									<div class="popup-center">
										<h1>
											<span class="text-white"><?php the_title(); ?></span>
										</h1>
									</div>
								</div>
							</div>
							<?php
							do_action('cc_filter_navigation');

							if ( $_POST['taxonomy'] == 'product_color' ) {
								?>
								<div class="model-wrapper">
									<h2 class="inner-section-title alt-text">
										<span>
											<?php _e("Wall colours to create the look ","cc_filter_product")?>
										</span>
									</h2>
								</div>
								<?php
								?>
								<div class="model-wrapper">
									<?php echo  get_field('content'); ?>
								</div>
								<?php
							}


							WPBMap::addAllMappedShortcodes();
							the_content();

							$term = $_POST['term'];
							$taxonomy = $_POST['taxonomy'];
							$is_page = $_POST['is_page'];
							?>

								<div class="model-wrapper">
									<h2 class="inner-section-title alt-text">
										<span>
											<?php
												if ( $_POST['taxonomy'] == 'product_color') {

												_e("Floors that match","cc_filter_product");

												} else {
												_e("shop the look","cc_filter_product");

												}
												?>
										</span>
									</h2>
									<?php if ( $_POST['taxonomy'] == 'product_color') { ?>
									<h3 class="cc-ds">
										<?php _e("We’ve hand selected each floor colour that match this paint palette.","cc_filter_product")?>
									</h3>
									<?php } ?>
								</div>
								<div class="vertical-slider">
									<?php
					        // do_action('cc_taxonomy_product_list');
									$related_terms_meta = cc_get_term_meta( $term, 'related_'.$taxonomy, true );
									$query_args = array();
									$query_args['post_type'] = 'product';
									$query_args['post_status'] = 'publish';
									$query_args['orderby'] = 'rand';
									$query_args['posts_per_page'] = 25;

									$tax_query = array();
									$tax_query[]  = array(
										'taxonomy' => 'pa_color',
										'field'    => 'term_id',
										'terms'    =>  $related_terms_meta
										);
									$query_args['tax_query'] = $tax_query;
									$product_query = new WP_Query( $query_args );

									$template_path = PATH.'template-parts/filter_right_results.php';

									include( $template_path );
									?>

								</div>


							<?php
							if ( $_POST['taxonomy'] == 'product_color') {

								$accent_class = 'cpm_product_color_filter_tax';
								if ( $is_page == 1 ) {

									$accent_class = 'product_color_filter_tax';
								}

								$parent_term = get_term( $term, $taxonomy, OBJECT);
								$termchildren = get_term_children( $term, $taxonomy );
								//if ( !empty( $termchildren[0] ) ) { ?>

								<div class="model-wrapper">
									<h2 class="inner-section-title alt-text">
										<span>
											<?php _e("Complimentary pops of colour","cc_filter_product")?>
										</span>
									</h2>
								</div>
								<div class="model-wrapper">
									<?php
									if ( $_POST['taxonomy'] == 'product_color') {
										echo "Our accents are perfectly hand matched to this flexible paint and floor scheme. Pick one or two accents either in the same colour or opposites to add richness to your room – in designer matched colours all worked out for you.";
									}
									?>
								</div>
								<!-- <ul class="cpm-col-two" > -->
									<?php
									/*foreach ($termchildren as $term_child_value ) {
										$child_terms_object = get_term( $term_child_value, $taxonomy );

										$child_thumbnail_id = cc_get_term_meta( $child_terms_object->term_id, 'thumbnail_id', true );

										if( $taxonomy == "product_cat"){
											$child_thumbnail_id = get_woocommerce_term_meta( $child_terms_object->term_id, 'thumbnail_id', true );
										}

										$child_image = '';
										if ( $child_thumbnail_id ) {
											$child_image = wp_get_attachment_image_src( $child_thumbnail_id, ($taxonomy == "product_color")?'thumbnail':'filtertype_image' );
											$child_image = $child_image[0];
										}

										?>
										<li>
											<?php if ( !empty( $child_image ) ) { ?>
											<!-- <figure class="fig-hover"> -->

											<a href="javascript:void(0);" class="<?php echo $accent_class; ?>" id="term_<?php echo $child_terms_object->term_id; ?>" data-parent="<?php echo $term; ?>" data-name="<?php echo $child_terms_object->name; ?>" data-term="<?php echo $child_terms_object->term_id; ?>">

												<img src="<?php echo esc_url($child_image) ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' );?>"  class="wp-post-image"/>
												<span class="cpm-term-name">
													<span class="vert-wrap">
														<span class="vert-middle">
															<?php echo $child_terms_object->name; ?>
														</span>
													</span>
												</span>
											</a>

											<!-- </figure> -->
											<?php } ?>
										</li>
										<?php }*/ ?>
									<!-- </ul> -->
									<?php //}
									?>
									<!-- <div class="model-wrapper">
										<h2 class="inner-section-title alt-text">
											<span>
												<?php //_e("Other Accents","cc_filter_product")?>
											</span>
										</h2>
									</div> -->
									<ul class="cpm-col-two" >
										<?php
										$color_terms = get_terms( array(
											'taxonomy' => 'product_color',
											'hide_empty' => false,
											'include'	=> array(261,265,269,263,267,271,4725,4724)
											) );
										foreach ($color_terms as $color_cvalue) {

											$color_thumbnail_id = cc_get_term_meta( $color_cvalue->term_id, 'thumbnail_id', true );
											$color_image = '';
											if ( $color_thumbnail_id ) {
												$color_image = wp_get_attachment_image_src( $color_thumbnail_id, ($taxonomy == "product_color")?'thumbnail':'filtertype_image' );
												$color_image = $color_image[0];
											}
											?>
											<li>
												<?php if ( !empty( $color_image ) ) { ?>
												<a href="javascript:void(0);" class="cpm_product_color_filter_tax">

													<img src="<?php echo esc_url($color_image) ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' );?>"  class="wp-post-image"/>
													<span class="cpm-term-name">
														<span class="vert-wrap">
															<span class="vert-middle">
																<?php echo $color_cvalue->name; ?>
															</span>
														</span>
													</span>
												</a>
												<?php } ?>
											</li>
											<?php

										}
										?>
									</ul>
									<?php
								} ?>
							</main><!-- #main -->
						</div><!-- #primary -->
					</div>

					<?php
				} wp_reset_postdata();
			}
			?>



			<?php

		// $url = str_replace('www.', '', $url);

		// $headers = array();
		// if( $_SERVER['HTTP_HOST'] != "localhost" ) {
		// 	$headers[ 'Authorization'] = 'Basic ' . base64_encode( 'staging' . ':' . 'O9p9a$W%WSI*F2HG' );
		// }

		// $response = wp_remote_post( $url, array(
		// 										'method' => 'POST',
		// 										'timeout' => 120,
		// 										'redirection' => 5,
		// 										'httpversion' => '1.0',
		// 										'blocking' => true,
		// 										'headers' => $headers,
		// 										'body' => $param,
		// 										'cookies' => array()
		// 									    )
		// 									);

		// if ( is_wp_error( $response ) ) {
		//    $error_message = $response->get_error_message();
		//    echo "Something went wrong: $error_message";
		// } else {
		//    echo $response['body'];
		// }
			die;
		}

		public function ajax_generate_attributes_tags_1() {
		// todo call page content
			$param = array(
				'term'=>$_POST['term'],
				'taxonomy'=>$_POST['taxonomy']
				);
			$url = get_permalink( $_POST['post_id'] );

			$ch = curl_init();
			if( $_SERVER['HTTP_HOST'] != "localhost" ) {
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, "staging:O9p9a$W%WSI*F2HG"); //Your credentials goes here
		}

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch,CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');

		// curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param );
		// receive server response ...
		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
		echo $result;
		die;
	}

/**
 * [get_filter_navigation_popup do action hook]
 */
public function get_filter_navigation_popup(){
	$taxonomy = $_REQUEST['taxonomy'];
	$term = $_REQUEST['term'];
	$is_page = $_REQUEST['is_page'];
	$previous_link_array = $this->cc_filter_generate_navigation($term, $taxonomy,'prev');


	$next_link_array = $this->cc_filter_generate_navigation($term, $taxonomy,'next');
	$template_path = PATH.'template-parts/prev_next_popup.php';
	include( $template_path );
}

public function fetch_taxonomy_product_list() {
	$taxonomy = $_REQUEST['taxonomy'];
	$term = $_REQUEST['term'];

    	// fetch products
	$related_terms_meta = cc_get_term_meta( $term, 'related_'.$taxonomy, true );
	$query_args = array();
	$query_args['post_type'] = 'product';
	$query_args['post_status'] = 'publish';

		//Order & Orderby Parameters
	// $query_args['order'] = 'DESC';
	$query_args['orderby'] = 'rand';
	$query_args['posts_per_page'] = 15;

	$tax_query = array();
	$tax_query[]  = array(
		'taxonomy' => 'pa_color',
		'field'    => 'term_id',
		'terms'    =>  $related_terms_meta
		);
	$query_args['tax_query'] = $tax_query;
	$this->query_fetch($query_args);
}


public function cc_filter_generate_navigation( $term_id, $taxonomy, $navigation = "prev" ) {

	$new_tax = array();
	$args = array(
		'hide_empty' => false,
		'orderby'    => 'name',
		'order'       => 'ASC',
		'parent' => 0
		);
	$loop_life = get_terms( $taxonomy, $args );

	$current_index = 0;
	$i=0;
	foreach($loop_life as $single) {
		$new_tax[] = array(
			'term_id'  => $single->term_id,
			'name'     => $single->name,
			'slug'     => $single->slug,
			'taxonomy' => $single->taxonomy,
			);
		if($single->term_id == $term_id){
			$current_index = $i;
		}

		$i++;
	    } // loop ends


	    if ($navigation == "prev"){
	    	$index = $current_index - 1;
	    } else {
	    	$index = $current_index + 1;
	    }

	    $index = $this->cc_array_recursive($new_tax,$index,$navigation );

	    if( !is_null($index) ){
	    	return $new_tax[$index];
	    } else {
	    	return NULL;
	    }
	}

	public function cc_array_recursive($tax_array,$index,$navigation) {

		if (  array_key_exists( $index, $tax_array ) ) {
			return $index;
		} else {

			if($navigation == "prev"){
				$index--;
				if( $index < 0 ){
					return NULL;
				}
			} else {
				$index++;
				if( count($tax_array) < $index ){
					return NULL;
				}
			}

			return $this->cc_array_recursive($tax_array,$index,$navigation);
		}
	}

	public function ajax_filter_queries(){
		// ob_start();
		if ( isset( $_POST['pa_filter-colour-term'] ) && ($_POST['pa_filter-colour-term'] != '' ) ) {
			$_POST['pa_filter-colour'] = get_term_by( 'slug', $_POST['pa_filter-colour-term'], 'pa_filter-colour' ) -> term_id;
		};
		
		include( PATH.'template-parts/filter_left_results.php' );
		// $content = ob_get_clean();
		// ob_flush();
		// echo $content;
		die;
	}

	public function ajax_filter_products(){


		// session_start();
		// $_SESSION['diagnostic_tour_product_filter'] = $_POST;
    	// fetch products
		$query_args = array();
		$query_args['post_type'] = 'product';
		$query_args['post_status'] = 'publish';

		$product_order = get_theme_mod('cpm_cc_product_order');
		$product_orderby = get_theme_mod('cpm_cc_product_orderby');
		$cpm_cc_product_count = get_theme_mod('cpm_cc_product_count');

		//Order & Orderby Parameters
    	// $query_args['order'] = ( !empty( $product_order ) ) ? $product_order : 'DESC';
    	// $query_args['orderby'] = ( !empty( $product_orderby ) ) ? $product_orderby : 'date';
		$query_args['posts_per_page'] = ( !empty( $cpm_cc_product_count ) ) ? $cpm_cc_product_count : 5;

		if( isset($_POST['paged']) && $_POST['paged'] != '' ) {
			$query_args['paged'] = $_POST['paged'];
		} else {
			$query_args['paged'] = 1;
		}
		$query_args['offset'] = (  $query_args['paged'] - 1 ) * $query_args['posts_per_page'];

		//Taxonomy Parameters
		$tax_query = array();

		// for rhino product view
		// echo '<pre>';
		// 	print_r($_POST);
		// echo '</pre>';
		// die("Heree");
		if( isset( $_POST['referrerPage'] ) && ($_POST['referrerPage'] != '') && ($_POST['referrerPage'] != 'undefined') ){
			$referer = $_POST['referrerPage'];
			$explode_ref = explode("/",$referer);
			if( ($explode_ref[count($explode_ref)-2] == 'exclusive-rhino-carpet') || $explode_ref[count($explode_ref)-2] == 'advice'){
				$tax_query[]  = array(
					'taxonomy' => 'pa_fibre',
					'field'    => 'term_id',
					'terms'    =>  array(55, 393),
					'operator' => 'IN'
				);
				// $tax_query[]  = array(
				// 	'taxonomy' => 'pa_material',
				// 	'field'    => 'slug',
				// 	'terms'    =>  'carpet',
				// );
			}
		}

		if( isset( $_POST['product_cat'] ) && $_POST['product_cat'] !='' && $_POST['product_cat'] != 'undefined' ){
			// $cat_query = arr
			$product_cat_value =  $_POST['product_cat'];

    		// remove empty key
			$cat_value = array_values( array_filter( $product_cat_value ) );
			$tax_query[]  = array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    =>  $cat_value,
				'operator' => 'AND'
				);
			//related brand with category
			// if ( !empty( $product_cat_value[0] ) ) {

			// 	$related_brand_meta = cc_get_term_meta( $product_cat_value[0], 'related_product_cat_brand', true );

			// 	if ( !empty( $related_brand_meta ) ) {
			// 		$tax_query[]  = array(
			// 			'taxonomy' => 'product_brand',
			// 			'field'    => 'term_id',
			// 			'terms'    =>  $related_brand_meta ,
			// 			'operator' => 'AND'
			// 			);

			// 	}
			// }
		}

		$taxonomies =  get_taxonomies();
		$taxonomy_name = array();
		$this->getTaxonomiesList($taxonomy_name);

		foreach($taxonomy_name as $taxonomy):

			$field1 = $taxonomy['field1'];
		$field2 = $taxonomy['field2'];

		if( ( isset( $_POST[$field1] ) && $_POST[$field1] != '' ) || ( isset( $_POST[$field2] ) && $_POST[$field2] != '' ) ) {
			$value = ( isset( $_POST[$field1] ) )?$_POST[$field1]:$_POST[$field2];
	    		// remove empty key
			$value = array_values( array_filter( $value ) );
			if( !empty( $value ) ) {
				$tax_query[] = array(
					'taxonomy' => $taxonomy['slug_name'],
					'field'    => 'term_id',
					'terms'    => $value ,
					'operator' => 'AND'
					);
			}
		}

		endforeach;

		if ( isset( $_POST['pa_rent'] ) && $_POST['pa_rent'] != '' && $_POST['pa_rent'] != 'undefined' ) {
			$r_value = array_values( array_filter( $_POST['pa_rent'] ) );
			if( !empty( $r_value ) ) {
				$tax_query[]  = array(
					'taxonomy' => 'pa_rent',
					'field'    => 'term_id',
					'terms'    => $r_value,
					'operator' => 'IN'
					);
			}
		}
		if ( isset( $_POST['product_feature'] ) && $_POST['product_feature'] != '' && $_POST['product_feature'] != 'undefined' ) {
			$r_value = array_values( array_filter( $_POST['product_feature'] ) );
			if( !empty( $r_value ) ) {
				$tax_query[]  = array(
					'taxonomy' => 'product_feature',
					'field'    => 'term_id',
					'terms'    => $r_value,
					'operator' => 'AND'
					);
			}
		}
		
		if ( isset( $_POST['pa_filter-colour-term'] ) && ($_POST['pa_filter-colour-term'] != '' ) ) {
			$_POST['pa_filter-colour'] = get_term_by( 'slug', $_POST['pa_filter-colour-term'], 'pa_filter-colour' ) -> term_id;
		};
		
		if ( isset( $_POST['pa_filter_color'] ) && ($_POST['pa_filter_color'] != '' ) ) {
			$f_value = array_values( array_filter( $_POST['pa_filter_color'] ) );
			// echo '<pre>';
			//     print_r($f_value);
			// echo '</pre>';

			if( !empty( $f_value ) ) {
				$tax_query[]  = array(
					'taxonomy' => 'pa_filter-colour',
					'field'    => 'term_id',
					'terms'    => $f_value,
					'operator' => 'AND'
					);
				// foreach($r_value as $rrr){
				// 	$tax_query[]  = array(
				// 	'taxonomy' => 'pa_filter-colour',
				// 	'field'    => 'term_taxonomy_id',
				// 	'terms'    => $rrr,
				// 	''
				// 	);
				// }
			}
		}
		if ( isset( $_POST['pa_sell'] ) && $_POST['pa_sell'] != '' && $_POST['pa_sell'] != 'undefined' ) {
			$s_value = array_values( array_filter( $_POST['pa_sell'] ) );
			if( !empty( $s_value ) ) {
				$tax_query[]  = array(
					'taxonomy' => 'pa_sell',
					'field'    => 'term_id',
					'terms'    => $s_value,
					'operator' => 'IN'
					);
			}
		}


		if( isset( $_POST['child_product_color'] ) && $_POST['child_product_color'] !='' && !empty( $_POST['child_product_color'] ) && $_POST['child_product_color'] != 'undefined' ) {
			$child_product_colorvalue = $_POST['child_product_color'];

			$tax_query[]  = array(
				'taxonomy' => 'product_color',
				'field'    => 'term_id',
				'terms'    => $child_product_colorvalue,
				'operator' => 'AND'
				);
		} elseif ( isset( $_POST['product_color'] ) && !empty( $_POST['product_color'] ) && $_POST['product_color'] != 'undefined' && $_POST['child_product_color'] !='' ) {
			// remove empty key
			$product_colorvalue = $_POST['product_color'];

			$tax_query[]  = array(
				'taxonomy' => 'product_color',
				'field'    => 'term_id',
				'terms'    => $product_colorvalue,
				'operator' => 'AND'
				);
		}


		if( isset( $_POST['delivery'] ) && $_POST['delivery'] != '' && $_POST['delivery'] != 'undefined' ) {
			// remove empty key
			// $value = array_values( array_filter( $value ) );
			$tax_query[]  = array(
				'taxonomy' => 'product_delivery',
				'field'    => 'term_id',
				'terms'    =>  $_POST['delivery']
				);
		}

		if( isset( $_POST['product_brand'] ) && $_POST['product_brand'] !='' && $_POST['product_brand'] != 'undefined' ) {
			// remove empty key
			$product_brandvalue = array_values( array_filter( $_POST['product_brand'] ) );

			$tax_query[]  = array(
				'taxonomy' => 'product_brand',
				'field'    => 'term_id',
				'terms'    => $product_brandvalue,
				'operator' => 'AND'
				);
		}

		if( isset( $_POST['product_tag'] ) && $_POST['product_tag'] != '' && $_POST['product_tag'] != 'undefined' && $_POST['product_tag'] != "all" && $_POST['product_tag'] != 'undefined' ) {
			// remove empty key
			// $value = array_values( array_filter( $_POST['product_tag'] ) );

			$tax_query[]  = array(
				'taxonomy' => 'product_tag',
				'field'    => 'term_id',
				'terms'    =>  $_POST['product_tag']
				);
		}

		if( isset( $_POST['additional_option'] ) && $_POST['additional_option'] !='' && $_POST['additional_option'] != 'undefined' ) {
					// remove empty key
			$additional_optionvalue = $_POST['additional_option'];

			$tax_query[]  = array(
				'taxonomy' => 'additional_option',
				'field'    => 'term_id',
				'terms'    => $additional_optionvalue,
		    								// 'operator' => 'IN'
				);
		}
		if( isset( $_POST['pa_looks'] ) && $_POST['pa_looks'] !='' && $_POST['pa_looks'] != 'undefined' ) {
					// remove empty key
			$pa_looksvalue = $_POST['pa_looks'];
			$looks_value = array_values( array_filter( $pa_looksvalue ) );

			$tax_query[]  = array(
				'taxonomy' => 'pa_looks',
				'field'    => 'term_id',
				'terms'    => $looks_value,
		    								// 'operator' => 'IN'
				);
		}


		if( !empty( $tax_query ) ) {


			if ( count( $tax_query ) > 1 ) {

				if( isset( $_POST['delivery'] ) && $_POST['delivery'] != '' ) {
					$term = get_term( $_POST['delivery'], 'product_delivery' );
					if ( $term->slug == 'i-dont-mind-show-me-all' ) {

						$tax_query['relation'] = 'OR';
					} else {
						$tax_query['relation'] = 'AND';
					}
				} else {
					$tax_query['relation'] = 'AND';
				}
			}
			$query_args['tax_query'] = $tax_query;
		}

		// $this->query_fetch($query_args);

		$product_query = new WP_Query( $query_args );
				// echo $product_query->request; die;
		$template_path = PATH.'template-parts/filter_right_results.php';
		// ob_start();
		if( $product_query->found_posts > 0 ) {
					// include(PATH . 'template-parts/filter_tabs.php');
		}
		include( $template_path );
		// $content = ob_get_clean();
		// echo $content;
		die;


	}
	
	public function ajax_filter_products_return_url(){
		
		$url = site_url() . "/products/";
		
		$type = get_term( $_POST['product_cat'][0], 'product_cat' );
		if (isset($_POST['product_cat'])) {
			if (is_wp_error($type)) {
				$type_slug = 'type';
			}
			else {
				$type_slug = $type -> slug;
			}
			$url .= $type_slug . '/';
			
			if (!is_wp_error($type)) {
				if ($type -> term_id == '7') {
					$fibres = get_term($_POST['pa_fibres'][0], 'pa_fibres');
					if (isset($_POST['pa_fibres'])) {
						if (is_wp_error($fibres)) { 
							$fibres_slug = 'fibres';
						}
						else {
							$fibres_slug = $fibres -> slug;
						}
						$url .= $fibres_slug . '/';
					}
				}
			}
		}

		$lifestyle = get_term($_POST['pa_floor'][0], 'pa_floor');
		if (isset($_POST['pa_floor'])) {
			if (is_wp_error($lifestyle)) { 
				$lifestyle_slug = 'lifestyle';
			}
			else {
				$lifestyle_slug = $lifestyle -> slug;
			}
			$url .= $lifestyle_slug . '/';
		}
	
		if (isset($_POST['product_feature'])) {
			$feature = get_term(  $_POST['product_feature'][0], 'product_feature' );
			$feature_slug = $feature -> slug;
			$url .= $feature_slug . '/';
		}
		
		if ( isset( $_POST['pa_filter-colour-term'] ) && ($_POST['pa_filter-colour-term'] != '' ) ) {
			$url .= '#' . $_POST['pa_filter-colour-term'];
		};
		
		wp_send_json(array("url" => $url ));
	}

	function ajax_product_color_filter_popup_cpts() {

		$taxonomy = $_POST['taxonomy'];
		$taxonomy_term = $_POST['term'];
		$parent_term = get_term( $taxonomy_term, $taxonomy, OBJECT);
		$termchildren = get_term_children( $taxonomy_term, $taxonomy );
		if ( !empty( $termchildren[0] ) ) { ?>

		<ul class="cpm-col-two" >
			<h4>Select any <?php echo ucfirst( $parent_term->name ); ?> Palettes</h4>
			<?php
			foreach ($termchildren as $term_child_value ) {
				$child_terms_object = get_term( $term_child_value, $taxonomy );

				$child_thumbnail_id = cc_get_term_meta( $child_terms_object->term_id, 'thumbnail_id', true );

				if( $taxonomy == "product_cat"){
					$child_thumbnail_id = get_woocommerce_term_meta( $child_terms_object->term_id, 'thumbnail_id', true );
				}

				$child_image = '';
				if ( $child_thumbnail_id ) {
					$child_image = wp_get_attachment_image_src( $child_thumbnail_id, ($taxonomy == "product_color")?'thumbnail':'filtertype_image' );
					$child_image = $child_image[0];
				}

				?>
				<li>
					<?php if ( !empty( $child_image ) ) { ?>
					<!-- <figure class="fig-hover"> -->

					<a href="#" class="product_color_filter_tax product_color" id="term_<?php echo $child_terms_object->term_id; ?>" data-parent="<?php echo $taxonomy_term; ?>" data-name="<?php echo $child_terms_object->name; ?>" data-term="<?php echo $child_terms_object->term_id; ?>">

						<img src="<?php echo esc_url($child_image) ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' );?>"  class="wp-post-image"/>
					</a>

					<!-- </figure> -->
					<?php } ?>
				</li>
				<?php } ?>
			</ul>
			<?php }
			die();
		}

		function query_fetch( $query_args ) {
		// echo "<pre>";print_r($query_args);die;

			$product_query = new WP_Query( $query_args );
		// echo $product_query->request; die;
			$template_path = PATH.'template-parts/filter_right_results.php';
			ob_start();
			if( $product_query->found_posts > 0 ) {
				include(PATH . 'template-parts/filter_tabs.php');
			}
			include( $template_path );
			$content = ob_get_clean();
			echo $content;
			die;
		}

		function getTaxonomiesList(&$taxonomy_name){

			$taxonomies =  get_taxonomies();

			foreach($taxonomies as $tax){

				if( $tax != "pa_color" && $tax != 'pa_material' && preg_match('/pa_[a-zA-z+]/', $tax)){
					$taxonomy_name[] = array(
						'field1' => $tax,
						'field2' => str_replace("pa_", "cc_", $tax),
						'slug_name'    => $tax
						);
				}
			}
		}

} // class ends