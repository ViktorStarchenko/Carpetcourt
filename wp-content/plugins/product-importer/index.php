<?php
/*
Plugin Name: CSV Product Import Table
Plugin URI:
Version: 0.1
Author: CodePixelzMedia
*/

class csv_import_table {

	function __construct() {

		add_action( 'admin_menu', array( $this , 'register_admin_menu_csv' ) );
		add_action( 'admin_enqueue_scripts', array( $this , 'csv_import_table_script' ) );
		add_action( 'wp_ajax_upload_product_csv' , array( $this , 'upload_csv' ) );
		add_action( 'wp_ajax_upload_color_csv' , array( $this , 'upload_color_csv' ) );
		add_action( 'init' , array( $this , 'export_color_csv'), 100  );
	}

	function printr( $value ){
		echo '<pre>'; print_r( $value ); echo '</pre>';

	}

	// Uploads CSV to the directory
	function upload_to_directory( $files ){

		$files_temp = file_get_contents( $files["file"]["tmp_name"][0]);
		$upload = wp_upload_bits( $files["file"]["name"][0], null, $files_temp);

		$link = $upload['url'];

		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents($link);
		$filename = basename($link);
		if (wp_mkdir_p($upload_dir['basedir']))
			$file = $upload_dir['path'] . '/' . $filename;
		else
			$file = $upload_dir['path'] . '/' . $filename;

		return $file;

	}


	//upload color to the table
	function upload_color_csv() {

		global $wpdb;
		$table_name = $wpdb->prefix . 'post_meta';
		$table_post = $wpdb->prefix . 'posts';

		$csv = $this->upload_to_directory( $_FILES );
		$file = fopen($csv, "r");

		$pacolor_terms = $this->cc_existing_tax_name('pa_color');
		// $pafilter_colour_terms = $this->cc_existing_tax_name('pa_filter-colour');
		// $parent_terms = $this->cc_existing_tax_name('pa_rent');
		// $pasell_terms = $this->cc_existing_tax_name('pa_sell');
		// $pafloor_terms = $this->cc_existing_tax_name('pa_floor');
		// $pastyle_terms = $this->cc_existing_tax_name('pa_style');
		// $productcolor_terms = $this->cc_existing_tax_name('product_color');
		// $productaccent_terms = $this->cc_existing_tax_name('product_accent');
		if ( $file !== false) {
			$i=0;
			while (($value = fgetcsv($file, 1000, ',')) !== false ) {
				// printr($value);
				// die("yeahi nai");
				if ($i > 0) {

					if ( !empty( $value[2] ) ) {
						//cpm_insert_terms($term, $taxonomy, $slug);
						if ( !in_array($value[3], $pacolor_terms)) {
							$color_array = $this->cpm_insert_terms( $value[2], 'pa_color', $value[3]);
						}
						if ( !empty( $color_array) && !empty( $value[5] ) ) {
							cc_update_term_meta_data( $color_array['term_id'], 'cpm_color_thumbnail', $value[5]);
						}
						if ( !empty( $value[4] ) ) {
							$this->cpm_relate_terms_colors( $value[4], 'pa_filter-colour', $color_array );
						}
						if ( !empty( $value[7] ) ) {
							$this->cpm_relate_terms_colors( $value[7], 'pa_rent', $color_array );
						}
						if ( !empty( $value[8] ) ) {
							$this->cpm_relate_terms_colors( $value[8], 'pa_sell', $color_array );
						}

						if ( !empty( $value[9] ) ) {
							$this->cpm_relate_terms_colors( $value[9], 'pa_floor', $color_array );
						}
						if ( !empty( $value[10] ) ) {
							$this->cpm_relate_terms_colors( $value[10], 'pa_style', $color_array );
						}
						if ( !empty( $value[11] ) ) {
							$this->cpm_relate_terms_colors( $value[11], 'product_color', $color_array );
						}
						if ( !empty( $value[12] ) ) {
							$this->cpm_relate_terms_colors( $value[12], 'product_accent', $color_array );
						}
					}
				}
				$i++;
				unset( $value );
			}
		}
		die();
	}

	//Export color csv
	function export_color_csv() {

		if ( !isset( $_POST['submit_export']))
			return;
		// session_destroy()
		if ( ( isset( $_SESSION['csv_filename'] ) && !empty( $_SESSION['csv_filename']) ) && (isset( $_SESSION['csv_filepath'] )  && !empty( $_SESSION['csv_filepath'] ) ) ) {
			unset($_SESSION['csv_filename']);
			unset($_SESSION['csv_filepath']);
		}

		// $this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");

		$filename = 'Color_proposed_export_' . date("Y-m-d");

		$upload_dir = wp_upload_dir();

		$filepath = $upload_dir['path'] . '/' . $filename.'.csv';

		$file_url = $upload_dir['url'].'/'.$filename.'.csv';

		$output = fopen($filepath, 'w');

		fputcsv($output, array("Category", "Style", "Colour Name", "Style Number", "Filter Colours", "Swatch Image", "Purpose", "Rent life", "Sell life", "Floor life", "Style life", "Colour palettes", "Accent colours", "Range"));
		$pa_color_terms = get_terms( array(
			'taxonomy' => 'pa_color',
			'hide_empty' => false,
			) );
		if ( !empty( $pa_color_terms ) ) {

			foreach ( $pa_color_terms as $pa_key => $color_terms_value ) {
				$insert_array = array();
				$insert_array[0] = '';
				$insert_array[1] = '';
				$insert_array[2] = '';
				$insert_array[3] = '';
				$insert_array[4] = '';
				$insert_array[5] = '';
				$insert_array[6] = '';
				$insert_array[7] = '';
				$insert_array[8] = '';
				$insert_array[9] = '';
				$insert_array[10] = '';
				$insert_array[11] = '';
				$insert_array[12] = '';
				$insert_array[13] = '';

				$posts_array = get_posts(
				    array(
				        'posts_per_page' => -1,
				        'post_type' => 'product',
				        'post_status' => 'any',
				        'tax_query' => array(
				            array(
				                'taxonomy' => 'pa_color',
				                'field' => 'term_id',
				                'terms' => $color_terms_value->term_id,
				            )
				        )
				    )
				);

				if ( !empty( $posts_array ) ) {
					$array_to_implode = array();
					foreach ($posts_array as $key => $posts_value) {
						array_push($array_to_implode, $posts_value->post_title);
					}
					if ( !empty( $array_to_implode ) ) {

						$insert_array[13] = implode(',', $array_to_implode );
					}
				}

				$thumbnail_url = get_term_meta( $color_terms_value->term_id, 'cpm_color_thumbnail', true);
				$insert_array[5] = $thumbnail_url;
				$pa_color_rel_lifes = get_term_meta( $color_terms_value->term_id, 'pa_color_rel_lifes', true );

				if ( !empty( $pa_color_rel_lifes ) ) {

					foreach ($pa_color_rel_lifes as $taxonomy => $lifes_value) {
						// die();

						if ( !empty( $pa_color_rel_lifes[$taxonomy] ) && $taxonomy == 'pa_floor' ) {
							$insert_array[9] = $this->return_imploded_pa_attributes( $pa_color_rel_lifes[$taxonomy], $taxonomy );
						}

						if ( !empty( $pa_color_rel_lifes[$taxonomy] ) && $taxonomy == 'pa_style' ) {
							$insert_array[10] = $this->return_imploded_pa_attributes( $pa_color_rel_lifes[$taxonomy], $taxonomy );
						}
						if ( !empty( $pa_color_rel_lifes[$taxonomy] ) && $taxonomy == 'product_color' ) {
							$insert_array[11] = $this->return_imploded_pa_attributes( $pa_color_rel_lifes[$taxonomy], $taxonomy );
						}
						if ( !empty( $pa_color_rel_lifes[$taxonomy] ) && $taxonomy == 'product_accents' ) {
							$insert_array[12] = $this->return_imploded_pa_attributes( $pa_color_rel_lifes[$taxonomy], $taxonomy );
						}
						if ( !empty( $pa_color_rel_lifes[$taxonomy] ) && $taxonomy == 'pa_rent' ) {
							$insert_array[7] = $this->return_imploded_pa_attributes( $pa_color_rel_lifes[$taxonomy], $taxonomy );
						}
						if ( !empty( $pa_color_rel_lifes[$taxonomy] ) && $taxonomy == 'pa_sell' ) {
							$insert_array[8] = $this->return_imploded_pa_attributes( $pa_color_rel_lifes[$taxonomy], $taxonomy );
						}
						if ( !empty( $pa_color_rel_lifes[$taxonomy] ) && $taxonomy == 'pa_filter-colour' ) {
							$insert_array[4] = $this->return_imploded_pa_attributes( $pa_color_rel_lifes[$taxonomy], $taxonomy );
						}
					}
				}
				$insert_array[2] = $color_terms_value->name;
				$insert_array[3] = $color_terms_value->slug;

				fputcsv($output, $insert_array);
			}
		}

		fclose($output);

		header("Pragma: public");
		header("Expires: 0");
		header( 'Content-Type:application/octet-stream' );
		header( 'Content-Disposition:filename='.$filename.'.csv' );
		header( 'Content-Length:' . filesize( $filepath ) );
		if (file_exists($filepath)) {
			session_start();
			$_SESSION['csv_filename'] = $filename.'.csv';
			$_SESSION['csv_filepath'] = $file_url;
		}

	}

	function return_imploded_pa_attributes( $pa_lifes_array, $taxonomy ) {

		$return_imploded = '';

		if ( $taxonomy == 'product_accents') {
			$name_array = array();

			if ( !empty( $pa_lifes_array[0] ) ) {
				foreach ( $pa_lifes_array as $term_ids ) {
					$terms_data = get_term($term_ids, 'product_color', ARRAY_A );
					if ( !is_wp_error( $terms_data ) ) {
						$name_array[] = $terms_data['name'];
					}
					// print_r($terms_data);
					// die();
				}
				if ( !empty( $name_array ) ) {
					$return_imploded = implode(',', $name_array );
				}
			}

		} else {
			$cname_array = array();
			if ( !empty( $pa_lifes_array[0] ) ) {

				foreach ( $pa_lifes_array as $term_ids ) {
					$terms_data = get_term($term_ids, $taxonomy, ARRAY_A );
					if ( !is_wp_error( $terms_data ) ) {
						$cname_array[] = $terms_data['name'];
					}
				}

				if ( !empty( $cname_array ) ) {
					$return_imploded = implode(',', $cname_array );
				}
			}

		}

		return $return_imploded;
	}

	// Upload and insert to the table
	function upload_csv(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'post_meta';
		$table_post = $wpdb->prefix . 'posts';

		$csv = $this->upload_to_directory( $_FILES );
		$file = fopen($csv, "r");
		$i = 0;
		$post_desc = array();
		$post_title = array();
		$part_num = array();
		$insert_data = array();

		if ( $file !== false) {
			$i=0;
			while (($value = fgetcsv($file, 1000, ',')) !== false ) {

				// echo "<pre>";
				// print_r($value);
				// echo "</pre>";
				// die();

				if ($i > 0) {
					if ( !empty( $value[3] ) ) {
						$post_title = $value[3];
						$description = $value[16];
						$comment_status = '';
						if ( $value[82] != 0 ) {
							$comment_status = 'closed';
						} else {
							$comment_status = 'open';
						}
						$post_back_end = get_page_by_title( $post_title, 'OBJECT','product' );
						if (!$post_back_end) {
							$my_post = array(
								'post_type'     => 'product',
								'post_title'    => $post_title,
								'post_content'  => $description,
								'post_status'   => 'publish',
								'post_author'   => 1,
								'post_excerpt'	=> $description
								// 'comment_status' => $comment_status

								);
							$post_ids = wp_insert_post( $my_post );

							$this->set_post_terms( $post_ids, $value[2], 'product_brand' );
							$this->set_post_terms( $post_ids, $value[5], 'product_cat' );
							$this->set_post_terms( $post_ids, $value[6], 'pa_materials' );
							$this->set_post_terms( $post_ids, $value[7], 'pa_fibres' );
							$this->set_post_terms( $post_ids, $value[47], 'pa_looks' );
							$this->set_post_color_terms( $post_ids, $value[4], 'pa_color' );

							update_post_meta( $post_ids, 'post_indent', $value[8] );
							update_field( 'field_56babeecb78b2', $value[9], $post_ids );
							update_field( 'field_56babef5b78b3', $value[10], $post_ids );
							update_field( 'field_56dea29d0d6d6', $value[11], $post_ids );
							update_field( 'field_56dea28a0d6d5', $value[12], $post_ids );
							update_field( 'field_56dea2ae0d6d7', $value[13], $post_ids );
							update_field( 'field_57a1abdda30eb', $value[14], $post_ids );
							$this->set_product_gallery_url( $post_ids, $value[15] );
							$this->set_product_delivery( $post_ids, $value[19] );
							$this->set_product_tags( $post_ids, $value[20], 'affordable' );//afordable
							$this->set_product_tags( $post_ids, $value[21], 'special' );//special
							$this->set_product_tags( $post_ids, $value[22], 'luxury' );//luxury
							$this->set_product_tags( $post_ids, $value[23], 'durable' );//durable
							$this->set_product_tags( $post_ids, $value[44], 'specials' );//specials
							$this->set_product_additional_options( $post_ids, $value[24], 'scratch-and-dent-resistant');
							$this->set_product_additional_options( $post_ids, $value[25], 'pet-friendly');
							$this->set_product_additional_options( $post_ids, $value[26], 'kid-friendly');
							$this->set_product_additional_options( $post_ids, $value[27], 'easy-maintenance');
							$this->set_product_additional_options( $post_ids, $value[28], 'allergy-friendly');
							$this->set_product_additional_options( $post_ids, $value[29], 'heavy-wear');
							$this->set_product_additional_options( $post_ids, $value[30], 'water-resistant');
							$this->set_product_additional_options( $post_ids, $value[31], 'stain-resistant');
							$this->set_product_additional_options( $post_ids, $value[32], 'fade-resistant');
							$this->set_product_additional_options( $post_ids, $value[33], 'exclusive');
							$this->set_product_additional_options( $post_ids, $value[34], 'quiet-choice');
							$this->set_product_additional_options( $post_ids, $value[35], 'eco-friendly');
							$this->set_product_additional_options( $post_ids, $value[36], 'luxury');
							$this->set_product_additional_options( $post_ids, $value[37], 'natural-material');
							$this->set_product_additional_options( $post_ids, $value[38], 'underfloor-heating-compatible');
							$this->set_product_room_terms( $post_ids, $value[39], 'kitchens' );
							$this->set_product_room_terms( $post_ids, $value[40], 'bathrooms' );
							$this->set_product_room_terms( $post_ids, $value[41], 'living' );
							$this->set_product_room_terms( $post_ids, $value[42], 'bedrooms' );
							$this->set_product_room_terms( $post_ids, $value[43], 'outdoor' );
							$this->set_product_review_status( $post_ids, $value[46] );


						} else {

							$my_post = array(
								'ID'           => $post_back_end->ID,
								'post_content'  => $description,
								'post_excerpt'	=> $description
								);

							// Update the post into the database
							wp_update_post( $my_post );

							$this->set_post_terms( $post_back_end->ID, $value[2], 'product_brand' );
							$this->set_post_terms( $post_back_end->ID, $value[5], 'product_cat' );
							$this->set_post_terms( $post_back_end->ID, $value[6], 'pa_materials' );
							$this->set_post_terms( $post_back_end->ID, $value[7], 'pa_fibres' );
							$this->set_post_terms( $post_back_end->ID, $value[47], 'pa_looks' );
							$this->set_post_color_terms( $post_back_end->ID, $value[4], 'pa_color' );

							update_post_meta( $post_back_end->ID, 'post_indent', $value[8] );
							update_field( 'field_56babeecb78b2', $value[9], $post_back_end->ID );
							update_field( 'field_56babef5b78b3', $value[10], $post_back_end->ID );
							update_field( 'field_56dea29d0d6d6', $value[11], $post_back_end->ID );
							update_field( 'field_56dea28a0d6d5', $value[12], $post_back_end->ID );
							update_field( 'field_56dea2ae0d6d7', $value[13], $post_back_end->ID );
							update_field( 'field_57a1abdda30eb', $value[14], $post_back_end->ID );

							$this->set_product_gallery_url( $post_back_end->ID, $value[15] );
							$this->set_product_delivery( $post_back_end->ID, $value[19] );
							$this->set_product_tags( $post_back_end->ID, $value[20], 'affordable' );//afordable
							$this->set_product_tags( $post_back_end->ID, $value[21], 'special' );//special
							$this->set_product_tags( $post_back_end->ID, $value[22], 'luxury' );//luxury
							$this->set_product_tags( $post_back_end->ID, $value[23], 'durable' );//durable
							$this->set_product_tags( $post_back_end->ID, $value[44], 'specials' );//specials
							$this->set_product_additional_options( $post_back_end->ID, $value[24], 'scratch-and-dent-resistant');
							$this->set_product_additional_options( $post_back_end->ID, $value[25], 'pet-friendly');
							$this->set_product_additional_options( $post_back_end->ID, $value[26], 'kid-friendly');
							$this->set_product_additional_options( $post_back_end->ID, $value[27], 'easy-maintenance');
							$this->set_product_additional_options( $post_back_end->ID, $value[28], 'allergy-friendly');
							$this->set_product_additional_options( $post_back_end->ID, $value[29], 'heavy-wear');
							$this->set_product_additional_options( $post_back_end->ID, $value[30], 'water-resistant');
							$this->set_product_additional_options( $post_back_end->ID, $value[31], 'stain-resistant');
							$this->set_product_additional_options( $post_back_end->ID, $value[32], 'fade-resistant');
							$this->set_product_additional_options( $post_back_end->ID, $value[33], 'exclusive');
							$this->set_product_additional_options( $post_back_end->ID, $value[34], 'quiet-choice');
							$this->set_product_additional_options( $post_back_end->ID, $value[35], 'eco-friendly');
							$this->set_product_additional_options( $post_back_end->ID, $value[36], 'luxury');
							$this->set_product_additional_options( $post_back_end->ID, $value[37], 'natural-material');
							$this->set_product_additional_options( $post_back_end->ID, $value[38], 'underfloor-heating-compatible');
							$this->set_product_room_terms( $post_back_end->ID, $value[39], 'kitchens' );
							$this->set_product_room_terms( $post_back_end->ID, $value[40], 'bathrooms' );
							$this->set_product_room_terms( $post_back_end->ID, $value[41], 'living' );
							$this->set_product_room_terms( $post_back_end->ID, $value[42], 'bedrooms' );
							$this->set_product_room_terms( $post_back_end->ID, $value[43], 'outdoor' );
							$this->set_product_review_status( $post_back_end->ID, $value[46] );
						}
					}
				}
				$i++;
				unset( $value );
			}
		}


		die();
	}


	//set product comment status
	function set_product_review_status( $post_id, $value ) {
		global $wpdb;

		if ( !empty( $value ) ) {
			$reviews_allowed = ( 1 == $value ) ? 'open' : 'closed';

			$wpdb->update( $wpdb->posts, array( 'comment_status' => $reviews_allowed ), array( 'ID' => $post_id ) );
		}
	}

	function cc_existing_tax_name($taxname){
	  $pa_terms = get_terms( $taxname, array(
	      'hide_empty' => false,
	      'fields' => 'id=>slug',
	      )
	  );
	  $values = array_values($pa_terms);
	  return $values;
	}

	//set product room terms
	function set_product_room_terms( $post_id, $value, $term_slug ) {

		if ( !empty( $value ) && $value == 1 ) {
			$pa_rooms = get_term_by( 'slug', $term_slug, 'pa_rooms', ARRAY_A );
			if ( !empty( $pa_rooms ) ) {

				wp_set_object_terms( $post_id, array($pa_rooms['term_id']), 'pa_rooms', true );

				$product_attributes = get_post_meta( $post_id, '_product_attributes', true );
				$attributes = wc_get_attribute_taxonomy_names();

				$prod_attributes = array();



				if ( in_array( 'pa_rooms', $attributes ) ) {

					$position = array_search( 'pa_rooms', $attributes);
					if ( !empty( $product_attributes ) ) {

						$prod_attributes = $product_attributes;

						if ( !array_key_exists( 'pa_rooms', $prod_attributes ) ) {

							$prod_attributes['pa_rooms'] = array(
								'name' => 'pa_rooms',
								'value' => '',
								'position' => $position,
								'is_visible' => 1,
								'is_variation' => 0,
								'is_taxonomy' => 1,
								);

							update_post_meta( $post_id, '_product_attributes', $prod_attributes );
						} else {
							$prod_attributes['pa_rooms']['name'] = 'pa_rooms';
							$prod_attributes['pa_rooms']['value'] = '';
							$prod_attributes['pa_rooms']['position'] = $position;
							$prod_attributes['pa_rooms']['is_visible'] = 1;
							$prod_attributes['pa_rooms']['is_variation'] = 0;
							$prod_attributes['pa_rooms']['is_taxonomy'] = 1;

							update_post_meta( $post_id, '_product_attributes', $prod_attributes );
						}

					} else {
						$prod_attributes['pa_rooms'] = array(
							'name' => 'pa_rooms',
							'value' => '',
							'position' => $position,
							'is_visible' => 1,
							'is_variation' => 0,
							'is_taxonomy' => 1,
							);
						update_post_meta( $post_id, '_product_attributes', $prod_attributes );
					}

				}
			}
		}

	}

	//set product additional options
	function set_product_additional_options( $post_id, $value, $term_slug ) {

		if ( !empty( $value ) && $value == 1 ) {
			$additional_option = get_term_by( 'slug', $term_slug, 'additional_option', ARRAY_A );
			if ( !empty( $additional_option ) ) {

				wp_set_object_terms( $post_id, array($additional_option['term_id']), 'additional_option', true );
			}
			$product_feature = get_term_by( 'slug', $term_slug, 'product_feature', ARRAY_A );
			if ( !empty( $product_feature ) ) {

				wp_set_object_terms( $post_id, array($product_feature['term_id']), 'product_feature', true );
			}
		}

	}

	//set product tags affordable, luxury, durable, special
	function set_product_tags( $post_id, $value, $term_slug ) {

		// $term_slug = 'affordable';
		if ( !empty( $value ) && $value == 1 ) {
			$fetch_term = get_term_by( 'slug', $term_slug, 'product_tag', ARRAY_A );
			if ( !empty( $fetch_term ) ) {

				wp_set_object_terms( $post_id, array($fetch_term['term_id']), 'product_tag', true );
			}
		}

	}


	//Set product deliver terms
	function set_product_delivery( $post_id, $value ) {

		$term_slug = '';
		if ( !empty( $value ) ) {

			if ( $value == 1 ) {
				$term_slug = 'as-soon-as-possible';
			} elseif ( $value == 2 ) {
				$term_slug = 'im-not-in-a-hurry';
			}
			if ( !empty( $term_slug ) ) {
				$fetch_term = get_term_by( 'slug', $term_slug, 'product_delivery', ARRAY_A );
				wp_set_post_terms( $post_id, array($fetch_term['term_id']), 'product_delivery', true );
			}
		}

	}


	//Set product gallery image
	function set_product_gallery_url( $post_id, $image_urls ) {

		if ( !empty( $image_urls ) ) {
			$image_url = explode( ',', trim( $image_urls, " \n\t\r\0\x0B," ) );
			$url_arrays = array_filter(array_map('trim', $image_url ) );
			$image_values = array();
			$image_value = array();
			$i = 1;
			foreach ($url_arrays as $url_value) {
				$image_values[] = array( 'gallery_images_url' => $url_value ) ;
				$i++;
			}
			// field_57a1af46ae616
			// field_57a1af46ae616
			update_field( 'field_57a1af46ae616', $image_values, $post_id );
		}

	}


//set post color attributes
	function set_post_color_terms( $post_ids, $term_slugs, $pa_color ) {

		if ( !empty( $term_slugs ) ) {

			$tags = explode( ',', trim( $term_slugs, " \n\t\r\0\x0B," ) );
			$trim_terms = array_filter(array_map('trim', $tags ) );

			foreach ($trim_terms as $trim_value) {

				$sanitized_slug = sanitize_title( $trim_value );
				$fetch_term = get_term_by( 'slug', $sanitized_slug, $pa_color, ARRAY_A );
				if ( !empty( $fetch_term ) ) {

					$color_rel_terms_meta = get_term_meta( $fetch_term['term_id'], 'pa_color_rel_lifes', true );

					$this->set_life_posts_relations( $post_ids, $color_rel_terms_meta );

					wp_set_post_terms( $post_ids, array($fetch_term['term_id']), $pa_color, true );
					$product_attributes = get_post_meta( $post_ids, '_product_attributes', true );
					$prod_attributes = array();
					if ( !empty( $product_attributes ) ) {

						$key_position = count( $product_attributes );
						$position = 0;

						$prod_attributes = $product_attributes;

						if ( !array_key_exists( $pa_color, $prod_attributes ) ) {

							$prod_attributes[$pa_color] = array(
								'name' => $pa_color,
								'value' => '',
								'position' => $position,
								'is_visible' => 1,
								'is_variation' => 0,
								'is_taxonomy' => 1,
								);

							update_post_meta( $post_ids, '_product_attributes', $prod_attributes );
						}

					} else {
						$prod_attributes[$pa_color] = array(
							'name' => $pa_color,
							'value' => '',
							'position' => 0,
							'is_visible' => 1,
							'is_variation' => 0,
							'is_taxonomy' => 1,
							);
						update_post_meta( $post_ids, '_product_attributes', $prod_attributes );
					}
				}

			}
		}

	}

	//set post life relations according to color
	function set_life_posts_relations( $post_ids, $color_rel_terms_meta ) {

		if ( !empty( $color_rel_terms_meta ) ) {
			foreach ( $color_rel_terms_meta as $keyss => $color_rel ) {
				$product_attributes = get_post_meta( $post_ids, '_product_attributes', true );
				$attributes = wc_get_attribute_taxonomy_names();

				$prod_attributes = array();

				if ( $keyss == 'product_accents' ) {
					wp_set_post_terms( $post_ids, $color_rel_terms_meta[$keyss], 'product_color', true );
				} else {
					wp_set_post_terms( $post_ids, $color_rel_terms_meta[$keyss], $keyss, true );
				}




				if ( in_array( $keyss, $attributes ) && !empty( $color_rel ) ) {

					if ( !empty( $product_attributes ) ) {

						$key_position = count( $product_attributes );
						$position = 0;

						$prod_attributes = $product_attributes;

						if ( !array_key_exists( $keyss, $prod_attributes ) ) {

							$prod_attributes[$keyss] = array(
								'name' => $keyss,
								'value' => '',
								'position' => $position,
								'is_visible' => 1,
								'is_variation' => 0,
								'is_taxonomy' => 1,
								);

							update_post_meta( $post_ids, '_product_attributes', $prod_attributes );
						} else {
							$prod_attributes[$keyss]['name'] = $keyss;
							$prod_attributes[$keyss]['value'] = '';
							$prod_attributes[$keyss]['position'] = $position;
							$prod_attributes[$keyss]['is_visible'] = 1;
							$prod_attributes[$keyss]['is_variation'] = 0;
							$prod_attributes[$keyss]['is_taxonomy'] = 1;

							update_post_meta( $post_ids, '_product_attributes', $prod_attributes );
						}

					} else {
						$prod_attributes[$keyss] = array(
							'name' => $keyss,
							'value' => '',
							'position' => 0,
							'is_visible' => 1,
							'is_variation' => 0,
							'is_taxonomy' => 1,
							);
						update_post_meta( $post_ids, '_product_attributes', $prod_attributes );
					}

				}
			}
		}
	}

	//color csv insert term
	function cpm_insert_terms( $term, $taxonomy, $slug ) {

		$term_exists = term_exists( $term, $taxonomy ); // array is returned if taxonomy is given
		// $parent_term_id = $parent_term['term_id']; // get numeric term id
		if ($term_exists !== 0 && $term_exists !== null) {
			return $term_exists;
		} else {

			$insert_terms = wp_insert_term(
			  $term, // the term
			  $taxonomy, // the taxonomy
			  array(
			  	'description'=> '',
			  	'slug' => sanitize_title( $slug ),
			  	'parent'=> ''
			  	)
			  );

			return $insert_terms;
		}

	}

	//relate colors with other terms
	function cpm_relate_terms_colors( $term, $taxonomy, $color_array ) {

		$tags = explode( ',', trim( $term, " \n\t\r\0\x0B," ) );
		$trim_terms = array_filter(array_map('trim', $tags ) );

		foreach ($trim_terms as $trim_value) {

			if ( $taxonomy == 'product_accent' ) {
				$taxonomy = 'product_color';
				$term_exists = term_exists( $trim_value, $taxonomy ); // array is returned if taxonomy is given
				// get numeric term id
				if ($term_exists !== 0 && $term_exists !== null) {

					$this->set_term_color_relation( $term_exists, $color_array, 'product_accent' );

				} else {

					$insert_terms = wp_insert_term(
					  $trim_value, // the term
					  $taxonomy, // the taxonomy
					  array(
					  	'description'=> '',
					  	'slug' => '',
					  	'parent'=> ''
					  	)
					  );
					$this->set_term_color_relation( $insert_terms, $color_array, 'product_accent' );

				}
			} else {
				$term_exists = term_exists( $trim_value, $taxonomy ); // array is returned if taxonomy is given
			// get numeric term id
				if ($term_exists !== 0 && $term_exists !== null) {

					$this->set_term_color_relation( $term_exists, $color_array, $taxonomy );

				} else {

					$insert_terms = wp_insert_term(
				  $trim_value, // the term
				  $taxonomy, // the taxonomy
				  array(
				  	'description'=> '',
				  	'slug' => '',
				  	'parent'=> ''
				  	)
				  );
					$this->set_term_color_relation( $insert_terms, $color_array, $taxonomy );

				}
			}

		}


	}

	//set term and color relation
	function set_term_color_relation( $term_array, $color_array, $taxonomy ) {

		if ( $taxonomy == 'product_accent' ) {
			$taxonomy = 'product_color';
			$color_rel_terms_meta = cc_get_term_meta( $color_array['term_id'], 'pa_color_rel_lifes', true );
			if ( !empty( $color_rel_terms_meta ) ) {
				$color_rel_array = $color_rel_terms_meta;
				if ( !in_array( $term_array['term_id'], $color_rel_array['product_accents'] ) ) {
					$color_rel_array['product_accents'][] = $term_array['term_id'];
					// array_push($color_rel_array['product_accents'], $term_array['term_id']);
				}
			} else {
				$color_rel_array = array();
				$color_rel_array['product_accents'] = array($term_array['term_id']);
			}
			cc_update_term_meta_data( $color_array['term_id'], 'pa_color_rel_lifes', $color_rel_array );

			$related_terms = cc_get_term_meta( $term_array['term_id'], 'related_'.$taxonomy, true );
			if ( empty( $related_terms ) ) {
				$related_terms = array();
			}

			if ( !in_array( $color_array['term_id'], $related_terms ) ) {
				array_push( $related_terms, $color_array['term_id'] );
			}
			if ( !empty( $related_terms ) ) {
				cc_update_term_meta_data( $term_array['term_id'], 'related_'.$taxonomy, $related_terms);
			}
		} else {

			$color_rel_terms_meta = cc_get_term_meta( $color_array['term_id'], 'pa_color_rel_lifes', true );
			if ( !empty( $color_rel_terms_meta ) ) {
				$color_rel_array = $color_rel_terms_meta;
				if ( !in_array( $term_array['term_id'], $color_rel_array[$taxonomy] ) ) {
					$color_rel_array[$taxonomy][] = $term_array['term_id'];
					// array_push($color_rel_array[$taxonomy], $term_array['term_id']);
				}
			} else {
				$color_rel_array = array();
				$color_rel_array[$taxonomy] = array($term_array['term_id']);
			}
			cc_update_term_meta_data( $color_array['term_id'], 'pa_color_rel_lifes', $color_rel_array );

			$related_terms = cc_get_term_meta( $term_array['term_id'], 'related_'.$taxonomy, true );
			if ( empty( $related_terms ) ) {
				$related_terms = array();
			}

			if ( !in_array( $color_array['term_id'], $related_terms ) ) {
				array_push( $related_terms, $color_array['term_id'] );
			}
			if ( !empty( $related_terms ) ) {
				cc_update_term_meta_data( $term_array['term_id'], 'related_'.$taxonomy, $related_terms);
			}
		}


	}

	function set_post_terms( $post_id, $term, $taxonomy ) {


		if ( !empty( $term ) ) {

			$tags = explode( ',', trim( $term, " \n\t\r\0\x0B," ) );
			$trim_terms = array_filter(array_map('trim', $tags ) );
			if ( $taxonomy == 'product_tag') {
				wp_set_object_terms( $post_id, $trim_terms, $taxonomy, true );
			} else {


				foreach ($trim_terms as $tags_value) {
					$term_exists = term_exists( $tags_value, $taxonomy );

					if ( $term_exists === null) {
						$insert_terms = wp_insert_term($tags_value, $taxonomy );

						$term_gets = get_term_by( 'id', $insert_terms['term_id'] );

						wp_set_object_terms( $post_id, array( $insert_terms['term_id'] ), $taxonomy, true );
					} else {

						$term_getsd = get_term_by( 'id', $term_exists['term_id'] );

						wp_set_post_terms( $post_id, array($term_exists['term_id']), $taxonomy, true );
					}
				}

			}

			$product_attributes = get_post_meta( $post_id, '_product_attributes', true );
			$attributes = wc_get_attribute_taxonomy_names();

			$prod_attributes = array();



			if ( in_array( $taxonomy, $attributes ) ) {

				if ( !empty( $product_attributes ) ) {

					$key_position = count( $product_attributes );
					$position = 0;

					$prod_attributes = $product_attributes;

					if ( !array_key_exists( $taxonomy, $prod_attributes ) ) {

						$prod_attributes[$taxonomy] = array(
							'name' => $taxonomy,
							'value' => '',
							'position' => $position,
							'is_visible' => 1,
							'is_variation' => 0,
							'is_taxonomy' => 1,
							);

						update_post_meta( $post_id, '_product_attributes', $prod_attributes );
					} else {
						$prod_attributes[$taxonomy]['name'] = $taxonomy;
						$prod_attributes[$taxonomy]['value'] = '';
						$prod_attributes[$taxonomy]['position'] = $position;
						$prod_attributes[$taxonomy]['is_visible'] = 1;
						$prod_attributes[$taxonomy]['is_variation'] = 0;
						$prod_attributes[$taxonomy]['is_taxonomy'] = 1;

						update_post_meta( $post_id, '_product_attributes', $prod_attributes );
					}

				} else {
					$prod_attributes[$taxonomy] = array(
						'name' => $taxonomy,
						'value' => '',
						'position' => 0,
						'is_visible' => 1,
						'is_variation' => 0,
						'is_taxonomy' => 1,
						);
					update_post_meta( $post_id, '_product_attributes', $prod_attributes );
				}

			}
		}

	}

	function set_post_attr_features_terms( $post_id, $value, $term_name ) {

		$product_feature_term_exists = term_exists($term_name, 'product_feature');
		$additional_option_term_exists = term_exists($term_name, 'additional_option');

		if ( is_numeric( $value ) && !empty( $value ) && $value == 1 ) {

			if ( $product_feature_term_exists === null) {
				$product_feature_insert_terms = wp_insert_term($term_name, 'product_feature' );

				wp_set_object_terms( $post_id, array( $product_feature_insert_terms['term_id'] ), 'product_feature', true );
			} else {

				wp_set_post_terms( $post_id, array($product_feature_term_exists['term_id']), 'product_feature', true );
			}

			if ( $additional_option_term_exists === null) {
				$additional_option_insert_terms = wp_insert_term($term_name, 'additional_option' );

				wp_set_object_terms( $post_id, array( $additional_option_insert_terms['term_id'] ), 'additional_option', true );
			} else {

				wp_set_post_terms( $post_id, array($additional_option_term_exists['term_id']), 'additional_option', true );
			}
		}


	}

	// Localize script for the javascript
	function csv_import_table_script(){
		wp_register_script( 'script_csv1', plugin_dir_url( __FILE__ ) . 'js/script.js' );
		$this->localize_scripts();
	}

	// add admin menu
	function register_admin_menu_csv(){
		add_menu_page( 'CSV Import  Table', 'CSV Product Import', 'manage_options', 'import_csv_table', array( $this , 'csv_settings' ), '' , 80 );
		add_submenu_page( 'import_csv_table', 'Color Import', 'Color Import', 'manage_options', 'color_import', array( $this, 'color_csv_import' ) );
	}

	// Localize script for the javascript
	function localize_scripts(){

		$translation_array = array(
			'admin_ajax' => admin_url( 'admin-ajax.php' ),
			);
		wp_localize_script( 'script_csv1', 'translate', $translation_array );
		wp_enqueue_script( 'script_csv1' );

	}

	// Form for export and import
	function csv_settings(){
		?>
		<div class="wrap">
			<h2>CSV Product Import Table</h2>

			<form method="post" action="">
				<table class="form-table">
					<tr valign="top">
						<td>
							<input type="file" name="import_file" id="import_product_csv" />
							<button class="button" id="import_csvv" name="submit" type="button">Import</button>
							<img src="<?php echo includes_url( '/images/spinner.gif' ); ?>" class="spinner_loader" style="display:none;">
						</td>
					</tr>

				</table>

			</form>
		</div>

		<?php

	}

	function color_csv_import() {

		?>
		<div class="wrap">
			<h2>CSV Color Import Table</h2>

			<form method="post" action="">
				<table class="form-table">
					<tr valign="top">
						<td>
							<input type="file" name="import_color" id="import_color_csv" />
							<button class="button" id="color_import" name="submit" type="button">Import</button>
							<button class="button" id="color_export" name="submit_export" type="submit">Export</button>
							<img src="<?php echo includes_url( '/images/spinner.gif' ); ?>" class="spinner_loader" style="display:none;">
						</td>
					</tr>

				</table>

			</form>

			<?php
				if ( ( isset( $_SESSION['csv_filename'] ) && !empty( $_SESSION['csv_filename']) ) && (isset( $_SESSION['csv_filepath'] )  && !empty( $_SESSION['csv_filepath'] ) ) ) {
					// echo $_SESSION['csv_filepath'];
					?>
						File Created <a target="_blank" href="<?php echo $_SESSION['csv_filepath']; ?>"><?php echo $_SESSION['csv_filename']; ?></a>
					<?php
				}
			?>
		</div>

		<?php

	}
}

$csv = new csv_import_table();