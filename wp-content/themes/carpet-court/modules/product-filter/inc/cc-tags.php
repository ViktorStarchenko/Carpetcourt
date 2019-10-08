<?php
/**
 * CC_tags
 */
class CC_tags {

	private static $instance;
	public $current_taxonomy;

	public static function get_instance() {

		if( null == self::$instance ) {
			self::$instance = new CC_tags();
		}
		return self::$instance;
	}


	private function __construct() {

		$taxonomies =  get_taxonomies();
		$taxonomy_name = array();
		foreach($taxonomies as $tax){

			if( $tax != 'pa_color' && $tax != 'pa_material' && $tax != 'pa_fibre' && preg_match('/pa_[a-zA-z+]/', $tax)){
				$taxonomy_name[] = $tax;
			}
		}

		foreach($taxonomy_name as $taxonomy){
			$this->current_taxonomy = $taxonomy;
			// Add form for Floor
			add_action( $taxonomy.'_add_form_fields', array( $this, 'add_taxonomy_fields' ) );
			add_action( $taxonomy.'_edit_form_fields', array( $this, 'edit_taxonomy_fields' ), 10 );

			// Add columns
			add_filter( 'manage_edit-' . $taxonomy . '_columns', array( $this, 'product_taxonomy_columns' ) );
			add_filter( 'manage_' . $taxonomy . '_custom_column', array( $this, 'product_taxonomy_column' ), 10, 3 );

			add_action( 'created_'. $taxonomy, array( $this, 'cc_save_taxonomy_fields' ), 10, 2 );
			add_action( 'edit_'. $taxonomy, array( $this, 'cc_save_taxonomy_fields' ), 10, 2 );

		}
		add_action('pre_delete_term', array( $this, 'delete_taxonomy_fields'), 10, 2 );


		// Add columns pa_color
		add_filter( 'pa_color_add_form_fields', array( $this, 'pa_attr_taxonomy_columns' ) );
		add_filter( 'pa_color_edit_form_fields', array( $this, 'edit_pa_attr_taxonomy_column' ), 10 );
		add_action( 'created_pa_color', array( $this, 'pa_attr_save_taxonomy_fields' ), 10, 2 );
		add_action( 'edit_pa_color', array( $this, 'pa_attr_save_taxonomy_fields' ), 10, 2 );

		// Add relation for Type and Brand
		add_filter( 'product_cat_add_form_fields', array( $this, 'product_cat_taxonomy_columns' ) );
		add_filter( 'product_cat_edit_form_fields', array( $this, 'edit_product_cat_taxonomy_column' ), 10 );
		add_action( 'created_product_cat', array( $this, 'product_cat_save_taxonomy_fields' ), 10, 2 );
		add_action( 'edit_product_cat', array( $this, 'product_cat_save_taxonomy_fields' ), 10, 2 );

		// Add relation for Type and Product Features
		add_filter( 'product_feature_add_form_fields', array( $this, 'product_feature_taxonomy_columns' ) );
		add_filter( 'product_feature_edit_form_fields', array( $this, 'edit_product_feature_taxonomy_column' ), 10 );
		add_action( 'created_product_feature', array( $this, 'product_feature_save_taxonomy_fields' ), 10, 2 );
		add_action( 'edit_product_feature', array( $this, 'product_feature_save_taxonomy_fields' ), 10, 2 );


	}

	/**
	* Attributes Related Fields
	*
	*/
	public function pa_attr_taxonomy_columns() {

		$screen = get_current_screen();

		$taxonomy_array = array( 'pa_floor', 'pa_style', 'product_color', 'pa_rent', 'pa_sell' );

		if ( $screen->id == 'edit-pa_filter-colour' ) {
			$taxonomy_array = array( 'pa_floor', 'pa_style', 'product_color', 'pa_rent', 'pa_sell' );
		} else {
			$taxonomy_array = array( 'pa_floor', 'pa_style', 'product_color', 'pa_rent', 'pa_sell', 'pa_filter-colour' );
		} ?>
		<!-- Image url field -->
		<div class="form-field term-image-wrap">
			<label for="tag-image">Image Url</label>
			<div style="line-height: 60px;">
				<input name="tag-image" id="tag-image" value="" type="text">
				<button type="button" class="tag_upload_image_button button"><?php _e( 'Upload/Add image', 'carpet-court' ); ?></button>
				<button type="button" class="tag_remove_image_button button"><?php _e( 'Remove image', 'carpet-court' ); ?></button>
			</div>
			<script type="text/javascript">

				// Only show the "remove image" button when needed
				if ( ! jQuery( '#tag-image' ).val() ) {
					jQuery( '.tag_remove_image_button' ).hide();
				}

				// Uploading files
				var file_frame;

				jQuery( document ).on( 'click', '.tag_upload_image_button', function( event ) {

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php _e( "Choose an image", "carpet-court" ); ?>',
						button: {
							text: '<?php _e( "Use image", "carpet-court" ); ?>'
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						var attachment = file_frame.state().get( 'selection' ).first().toJSON();

						jQuery( '#tag-image' ).val( attachment.url );
						jQuery( '.tag_remove_image_button' ).show();
					});

					// Finally, open the modal.
					file_frame.open();
				});

				jQuery( document ).on( 'click', '.tag_remove_image_button', function() {
					jQuery( '#tag-image' ).val('');
					jQuery( '.tag_remove_image_button' ).hide();
					return false;
				});

			</script>
			<div class="clear"></div>
			<p>The image url for colors from importer. If not set, it uses thumbnail above.</p>
		</div>
		<?php

		$accent_color = array();
		$all_accent_array = array();

		foreach ($taxonomy_array as $taxonomy ) {


			$terms = get_terms( $taxonomy, array(
				'hide_empty' => false,
				'parent' => 0
				) );

			$taxonomy_name_label = get_taxonomy( $taxonomy );


			if ( !empty( $terms ) ) {

				?>

				<div class="form-field term-related-<?php echo $taxonomy; ?>-wrap">
					<label for="related_<?php echo $taxonomy; ?>">Related <?php echo $taxonomy_name_label->labels->name; ?></label>
					<select name="related_<?php echo $taxonomy; ?>[]" id="related_<?php echo $taxonomy; ?>" multiple="multiple" class="postform">
						<option value="">None</option>
						<?php

						foreach ($terms as $term_value) {

							if ( $taxonomy == 'product_color' ) {
								$child_acents = get_terms( $taxonomy, array( 'parent' => $term_value->term_id, 'hide_empty' => false ) );
								if ( !empty( $child_acents ) ) {
									foreach ($child_acents as $child_value) {
										$accent_color['term_id'] = $child_value->term_id;
										$accent_color['name'] = $child_value->name;
										array_push( $all_accent_array, $accent_color );
									}
								}
							}

							?>

							<option value="<?php echo $term_value->term_id; ?>"><?php echo $term_value->name; ?></option>
							<?php
						}

						?>
					</select>
				</div>
				<?php
			}
			if ( $taxonomy == 'product_color' ) { ?>

			<div class="form-field term-related-<?php echo $taxonomy; ?>-wrap">
				<label for="related_<?php echo $taxonomy; ?>">Related Accent Colours</label>
				<select name="related_product_accents[]" id="related_<?php echo $taxonomy; ?>" multiple="multiple" class="postform">
					<option value="">None</option>
					<?php

					if ( !empty( $all_accent_array ) ) {
						foreach ($all_accent_array as $accent_value) {
							?>

							<option value="<?php echo $accent_value['term_id']; ?>"><?php echo $accent_value['name']; ?></option>
							<?php
						}
					}

					?>
				</select>
			</div>
			<?php
		}
	}
}

/**
* Type and Features relation
*/
public function product_feature_taxonomy_columns() {
	?>
	<div class="form-field">
		<label><?php _e('Related Types','cc_product_filter'); ?></label>
		<div>
			<?php
			$features_terms = get_terms( array(
				'taxonomy' => 'product_cat',
				'hide_empty' => false,
				) );
				?>
				<select name="related_cat_features_type[]" multiple="multiple">
					<option value=""><?php _e("Selct Types",'cc_product_filter')?></option>
					<?php
					if ( !empty( $features_terms ) ) {

						foreach($features_terms as $feature_value): ?>
						<option value="<?php echo $feature_value->term_id;?>"><?php echo $feature_value->name; ?></option>
						<?php
						endforeach;

					}
					?>
				</select>
				<p><?php _e("Select related types to product type that alters filter in product-filter and diagnostics.","cc_product_filter");?></p>
			</div>
		</div>
		<?php
	}

	public function edit_product_feature_taxonomy_column( $term ) {
		$rel_term_id =  get_term_meta( $term->term_id, 'related_cat_features_type', true );
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Related Types', 'cc_product_filter' ); ?></label></th>
			<td>
				<?php
				$features_terms = get_terms( array(
					'taxonomy' => 'product_cat',
					'hide_empty' => false,
					) );
					?>
					<select name="related_cat_features_type[]" multiple="multiple">
						<option value=""><?php _e("Select Types",'cc_product_filter')?></option>
						<?php
						if ( !empty( $features_terms ) ) {

							foreach($features_terms as $key => $feature_value): ?>
							<option value="<?php echo $feature_value->term_id;?>" <?php
								if ( in_array( $feature_value->term_id, $rel_term_id ) ) {
									echo 'selected="selected"';
								}
								?>><?php echo $feature_value->name; ?></option>
								<?php
								endforeach;

							}
							?>
						</select>
						<p class="description"><?php _e("Select related types to product type that alters filter in product-filter and diagnostics.","cc_product_filter");?></p>
					</td>
				</tr>
				<?php


			}

			public function product_feature_save_taxonomy_fields( $term_id, $tt_id = '' ) {
				if (isset( $_POST['related_cat_features_type'] ) && !empty( $_POST['related_cat_features_type'] ) ) {
					cc_update_term_meta_data( $term_id, 'related_cat_features_type', $_POST['related_cat_features_type']);
				}

			}

/**
* Type and brand relation
*/
public function product_cat_taxonomy_columns() {
	$taxonomy = 'product_brand';
	$terms = get_terms( $taxonomy, array(
		'hide_empty' => false,
		'parent' => 0
		) );

	$taxonomy_name_label = get_taxonomy( $taxonomy );

	?>

	<div class="form-field term-related-<?php echo $taxonomy; ?>-wrap">
		<label for="related_<?php echo $taxonomy; ?>">Related <?php echo $taxonomy_name_label->labels->name; ?></label>
		<select name="related_<?php echo $taxonomy; ?>[]" id="related_<?php echo $taxonomy; ?>" multiple="multiple" class="postform">
			<option value="">None</option>
			<?php
			if ( !empty( $terms ) ) {

				foreach ($terms as $term_value) { ?>

				<option value="<?php echo $term_value->term_id; ?>"><?php echo $term_value->name; ?></option>
				<?php
			}

		}
		?>
	</select>
</div>
<?php

}

public function edit_product_cat_taxonomy_column( $term ) {


	$taxonomy = 'product_brand';

	$terms = get_terms( $taxonomy, array(
		'hide_empty' => false,
		'parent' => 0
		) );

	$taxonomy_name_label = get_taxonomy( $taxonomy );


	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label>Related <?php echo $taxonomy_name_label->labels->name; ?></label></th>
		<td>
			<select name="related_<?php echo $taxonomy; ?>[]" multiple="multiple">
				<option value="">None</option>
				<?php
				if ( !empty( $terms ) ) {
					foreach ($terms as $term_value) {

						$related_brands = cc_get_term_meta( $term_value->term_id, 'related_product_cat', true );
						if ( empty( $related_brands ) ) {
							$related_brands = array();
						}
						?>
						<option value="<?php echo $term_value->term_id; ?>" <?php if ( in_array( $term->term_id, $related_brands ) ) {
							echo 'selected="selected"';
						} ?> >
						<?php echo $term_value->name; ?>
					</option>
					<?php
				}
			}
			?>
		</select>
	</td>
</tr>
<?php
}

public function product_cat_save_taxonomy_fields( $term_id, $tt_id = '' ) {


	$taxonomy = 'product_brand';

	$brands_ids = $_POST['related_'.$taxonomy];

	$brand_terms = get_terms( $taxonomy, array(
		'hide_empty' => false,
		'parent' => 0
		) );

	cc_update_term_meta_data( $term_id, 'related_product_cat_brand', $brands_ids );

	if ( !empty( $brand_terms ) ) {

		foreach ($brand_terms as $brands_value) {

			if ( !in_array( $brands_value->term_id, $brands_ids ) ) {
				$related_terms_meta = cc_get_term_meta( $brands_value->term_id, 'related_product_cat', true );

				if ( !empty( $related_terms_meta ) ) {

					if( ( $key = array_search($term_id, $related_terms_meta ) ) !== false ) {
						unset( $related_terms_meta[$key] );

						cc_update_term_meta_data( $brands_value->term_id, 'related_product_cat', $related_terms_meta );
					}
				}
			} else {

				foreach ( $brands_ids as $post_value) {


					$related_termsss = cc_get_term_meta( $post_value, 'related_product_cat', true );
					if ( empty( $related_termsss ) ) {
						$related_termsss = array();
					}

					if ( !in_array( $term_id, $related_termsss ) ) {
						array_push( $related_termsss, $term_id );
					}
					if ( !empty( $related_termsss ) ) {
						cc_update_term_meta_data( $post_value, 'related_product_cat', $related_termsss);
					}

				}

			}
		}
	}

}

public function edit_pa_attr_taxonomy_column( $term ) {

	$screen = get_current_screen();

	$taxonomy_array = array( 'pa_floor', 'pa_style', 'product_color', 'pa_rent', 'pa_sell' );

	if ( $screen->id == 'edit-pa_filter-colour' ) {
		$taxonomy_array = array( 'pa_floor', 'pa_style', 'product_color', 'pa_rent', 'pa_sell' );
	} else {
		$taxonomy_array = array( 'pa_floor', 'pa_style', 'product_color', 'pa_rent', 'pa_sell', 'pa_filter-colour' );
	}

	$accent_color = array();
	$all_accent_array = array();

	$term_image = get_term_meta( $term->term_id, 'cpm_color_thumbnail', true );
	$image_term = ( !empty( $term_image ) ) ? $term_image : '';
	?>

	<tr class="form-field term-image-wrap">
		<th scope="row"><label for="tag-image">Name</label></th>
		<td>
			<input name="tag-image" id="tag-image" value="<?php echo $image_term; ?>" type="text">
			<button type="button" class="tag_upload_image_button button"><?php _e( 'Upload/Add image', 'carpet-court' ); ?></button>
			<button type="button" class="tag_remove_image_button button"><?php _e( 'Remove image', 'carpet-court' ); ?></button>
			<script type="text/javascript">

				// Only show the "remove image" button when needed
				if ( ! jQuery( '#tag-image' ).val() ) {
					jQuery( '.tag_remove_image_button' ).hide();
				}

				// Uploading files
				var file_frame;

				jQuery( document ).on( 'click', '.tag_upload_image_button', function( event ) {

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php _e( "Choose an image", "carpet-court" ); ?>',
						button: {
							text: '<?php _e( "Use image", "carpet-court" ); ?>'
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						var attachment = file_frame.state().get( 'selection' ).first().toJSON();

						jQuery( '#tag-image' ).val( attachment.url );
						jQuery( '.tag_remove_image_button' ).show();
					});

					// Finally, open the modal.
					file_frame.open();
				});

				jQuery( document ).on( 'click', '.tag_remove_image_button', function() {
					jQuery( '#tag-image' ).val('');
					jQuery( '.tag_remove_image_button' ).hide();
					return false;
				});

			</script>
			<p>The image url for colors from importer. If not set, it uses thumbnail above.</p>
		</td>
	</tr>

	<?php

	foreach ($taxonomy_array as $taxonomy ) {


		$terms = get_terms( $taxonomy, array(
			'hide_empty' => false,
			'parent' => 0
			) );

		$taxonomy_name_label = get_taxonomy( $taxonomy );


		if ( !empty( $terms ) ) {
			?>
			<tr class="form-field">
				<th scope="row" valign="top"><label>Related <?php echo $taxonomy_name_label->labels->name; ?></label></th>
				<td>
					<select name="related_<?php echo $taxonomy; ?>[]" multiple="multiple">
						<option value="">None</option>
						<?php
						foreach ($terms as $term_value) {

							$related_color_swatches = cc_get_term_meta( $term_value->term_id, 'related_'.$taxonomy, true );
							if ( empty( $related_color_swatches ) ) {
								$related_color_swatches = array();
							}

							if ( $taxonomy == 'product_color' ) {
								$child_acents = get_terms( $taxonomy, array( 'parent' => $term_value->term_id, 'hide_empty' => false ) );
								if ( !empty( $child_acents ) ) {
									foreach ($child_acents as $child_value) {
										$accent_color['term_id'] = $child_value->term_id;
										$accent_color['name'] = $child_value->name;
										array_push( $all_accent_array, $accent_color );
									}
								}
							}

							?>
							<option value="<?php echo $term_value->term_id; ?>" <?php if ( in_array( $term->term_id, $related_color_swatches ) ) {
								echo 'selected="selected"';
							} ?> >
							<?php echo $term_value->name; ?>
						</option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
		<?php
	}

	if ( $taxonomy == 'product_color' ) { ?>

	<tr class="form-field">
		<th scope="row" valign="top"><label>Related Accent Colours</label></th>
		<td>
			<select name="related_product_accents[]" multiple="multiple">
				<option value="">None</option>
				<?php
				if ( !empty( $all_accent_array ) ) {
					foreach ($all_accent_array as $accent_value) {

						$related_color_swatches = cc_get_term_meta( $accent_value['term_id'], 'related_product_color', true );

						if ( empty( $related_color_swatches ) ) {
							$related_color_swatches = array();
						}
						?>
						<option value="<?php echo $accent_value['term_id']; ?>" <?php if ( in_array( $term->term_id, $related_color_swatches ) ) {
							echo 'selected="selected"';
						} ?> >
						<?php echo $accent_value['name']; ?>
					</option>
					<?php
				}
			}
			?>
		</select>
	</td>
</tr>
<?php

}
}


}


public function pa_attr_save_taxonomy_fields( $term_id, $tt_id = '' ) {

	$screen = get_current_screen();

	$taxonomy_array = array( 'pa_floor', 'pa_style', 'product_color', 'pa_rent', 'pa_sell' );

	if ( $screen->id == 'edit-pa_filter-colour' ) {
		$taxonomy_array = array( 'pa_floor', 'pa_style', 'product_color', 'pa_rent', 'pa_sell' );
	} else {
		$taxonomy_array = array( 'pa_floor', 'pa_style', 'product_color', 'product_accents', 'pa_rent', 'pa_sell', 'pa_filter-colour' );
	}

	//Set term image url
	update_term_meta( $term_id, 'cpm_color_thumbnail', $_POST['tag-image'] );


	$set_post_taxonomy = array( 'pa_floor', 'pa_style', 'product_color', 'pa_rent', 'pa_sell', 'pa_filter-colour' );

	$accent_color = array();
	$all_accent_array = array();

	$term_rel_product = array();
	$product_args = array(
		'post_type' => 'product',
		'posts_per_page' => -1,
		'tax_query' => array(
			array(
				'taxonomy' => 'pa_color',
				'field'	=> 'term_id',
				'terms'	=> $term_id
				)
			)
		);

	$product_query = new WP_Query( $product_args );
	if ( $product_query->have_posts() ) {
		while ( $product_query->have_posts() ) {
			$product_query->the_post();

			if ( !in_array( get_the_ID(), $term_rel_product ) ) {
				array_push( $term_rel_product, get_the_ID() );
			}
		}
		wp_reset_postdata();
	}

	$color_rel_array = array();

	foreach ($taxonomy_array as $taxonomy ) {

		$related_terms_meta = cc_get_term_meta( $term_id, 'pa_color_rel_lifes', true );


		if ( $taxonomy == 'product_accents') {

			$color_rel_array[$taxonomy] = $_POST['related_product_accents'];

			cc_update_term_meta_data( $term_id, 'pa_color_rel_lifes', $color_rel_array );

			$palettes_terms = get_terms( 'product_color', array(
				'hide_empty' => false,
				'parent' => 0
				) );

			foreach ( $palettes_terms as $palettes_value ) {
				$child_acents = get_terms( 'product_color', array( 'parent' => $palettes_value->term_id, 'hide_empty' => false ) );
				if ( !empty( $child_acents ) ) {
					foreach ($child_acents as $child_value) {
						$accent_color['term_id'] = $child_value->term_id;
						$accent_color['name'] = $child_value->name;
						array_push( $all_accent_array, $accent_color );
					}
				}
			}

			if ( !empty( $all_accent_array ) ) {

				foreach ($all_accent_array as $accent_value) {
					/* unset if not in $_POST*/
					if ( !in_array( $accent_value['term_id'], $_POST['related_product_accents'] ) ) {

						$related_terms_meta = cc_get_term_meta( $accent_value['term_id'], 'related_product_color', true );

						if ( !empty( $related_terms_meta ) ) {

							if( ( $key = array_search($term_id, $related_terms_meta ) ) !== false ) {
								unset( $related_terms_meta[$key] );
								$this->cpm_remove_object_terms( $term_rel_product, $accent_value['term_id'], 'product_color' );
								cc_update_term_meta_data( $accent_value['term_id'], 'related_product_color', $related_terms_meta );
							}
						} else {

							$this->set_terms_to_product( $term_rel_product, $_POST['related_product_accents'], $set_post_taxonomy);

							foreach ($_POST['related_product_accents'] as $post_value) {


								$related_termsss = cc_get_term_meta( $post_value, 'related_product_color', true );
								if ( empty( $related_termsss ) ) {
									$related_termsss = array();
								}

								if ( !in_array( $term_id, $related_termsss ) ) {
									array_push( $related_termsss, $term_id );
								}
								if ( !empty( $related_termsss ) ) {
									cc_update_term_meta_data( $post_value, 'related_product_color', $related_termsss);
								}

							}
						}
					} else {

						$this->set_terms_to_product( $term_rel_product, $_POST['related_product_accents'], $set_post_taxonomy);

						foreach ($_POST['related_product_accents'] as $post_value) {


							$related_terms = cc_get_term_meta( $post_value, 'related_product_color', true );
							if ( empty( $related_terms ) ) {
								$related_terms = array();
							}

							if ( !in_array( $term_id, $related_terms ) ) {
								array_push( $related_terms, $term_id );
							}
							if ( !empty( $related_terms ) ) {
								cc_update_term_meta_data( $post_value, 'related_product_color', $related_terms);
							}

						}
					}
				}
			}


		} else {

			$color_rel_array[$taxonomy] = $_POST['related_'.$taxonomy];

			cc_update_term_meta_data( $term_id, 'pa_color_rel_lifes', $color_rel_array );

			$terms = get_terms( $taxonomy, array(
				'hide_empty' => false,
				'parent' => 0
				) );

			foreach ($terms as $term_value) {
				if ( !in_array( $term_value->term_id, $_POST['related_'.$taxonomy] ) ) {


					$related_terms_meta = cc_get_term_meta( $term_value->term_id, 'related_'.$taxonomy, true );

					if ( !empty( $related_terms_meta ) ) {

						if( ( $key = array_search($term_id, $related_terms_meta ) ) !== false ) {
							$this->cpm_remove_object_terms( $term_rel_product, $term_value->term_id, $taxonomy );
							unset( $related_terms_meta[$key] );
							cc_update_term_meta_data( $term_value->term_id, 'related_'.$taxonomy, $related_terms_meta );
						}
					} else {

						$this->set_terms_to_product( $term_rel_product, $_POST['related_'.$taxonomy], $set_post_taxonomy);


						foreach ($_POST['related_'.$taxonomy] as $post_value) {


							$related_termsss = cc_get_term_meta( $post_value, 'related_'.$taxonomy, true );
							if ( empty( $related_termsss ) ) {
								$related_termsss = array();
							}

							if ( !in_array( $term_id, $related_termsss ) ) {
								array_push( $related_termsss, $term_id );
							}
							if ( !empty( $related_termsss ) ) {
								cc_update_term_meta_data( $post_value, 'related_'.$taxonomy, $related_termsss);
							}

						}
					}
				} else {

					$this->set_terms_to_product( $term_rel_product, $_POST['related_'.$taxonomy], $set_post_taxonomy);

					foreach ($_POST['related_'.$taxonomy] as $post_value) {


						$related_terms = cc_get_term_meta( $post_value, 'related_'.$taxonomy, true );
						if ( empty( $related_terms ) ) {
							$related_terms = array();
						}

						if ( !in_array( $term_id, $related_terms ) ) {
							array_push( $related_terms, $term_id );
						}
						if ( !empty( $related_terms ) ) {
							cc_update_term_meta_data( $post_value, 'related_'.$taxonomy, $related_terms);
						}

					}
				}
			}
		}


	}

}


/**
* Remove the wp_remove_object_terms
*
*
*/

public function cpm_remove_object_terms( $product_ids, $term_id, $taxonomy ) {

	foreach ( $product_ids as $prod_id ) {
		wp_remove_object_terms( $prod_id, $term_id, $taxonomy );
	}
}

/**
 * taxonomy thumbnail fields.
 */
public function add_taxonomy_fields() {
	?>

	<div class="form-field">
		<label><?php _e('Choose Post','cc_product_filter'); ?></label>
		<div>
			<?php $posts = $this->generateAttributePages_CPT(); ?>
			<select name="cpt_post_id">
				<option value=""><?php _e("Create New Post",'cc_product_filter')?></option>
				<?php foreach($posts as $key => $value): ?>
					<option value="<?php echo $key;?>"><?php echo $value?></option>
				<?php endforeach;?>
			</select>
			<p><?php _e("If you choose to Create New Post, then it takes Taxonomy name and desrciption in above field as post title and content.","cc_product_filter");?></p>
		</div>
	</div>


	<div class="form-field">
		<label><?php _e( 'Thumbnail', 'cc_product_filter' ); ?></label>
		<div id="product_taxonomy_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( cc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
		<div style="line-height: 60px;">
			<input type="hidden" id="product_taxonomy_thumbnail_id" name="product_taxonomy_thumbnail_id" />
			<button type="button" class="upload_image_button button"><?php _e( 'Upload/Add image', 'cc_product_filter' ); ?></button>
			<button type="button" class="remove_image_button button"><?php _e( 'Remove image', 'cc_product_filter' ); ?></button>
		</div>
		<script type="text/javascript">

			// Only show the "remove image" button when needed
			if ( ! jQuery( '#product_taxonomy_thumbnail_id' ).val() ) {
				jQuery( '.remove_image_button' ).hide();
			}

			// Uploading files
			var file_frame;

			jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					file_frame.open();
					return;
				}

				// Create the media frame.
				file_frame = wp.media.frames.downloadable_file = wp.media({
					title: '<?php _e( "Choose an image", "cc_product_filter" ); ?>',
					button: {
						text: '<?php _e( "Use image", "cc_product_filter" ); ?>'
					},
					multiple: false
				});

				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					var attachment = file_frame.state().get( 'selection' ).first().toJSON();

					// debugger;
					if(attachment.hasOwnProperty('sizes')) {
						var thumbnail = attachment.sizes;
						if(thumbnail.hasOwnProperty('thumbnail')){
							jQuery( '#product_taxonomy_thumbnail' ).find( 'img' ).attr( 'src', attachment.url );
						} else {
							jQuery( '#product_taxonomy_thumbnail' ).find( 'img' ).attr( 'src', attachment.sizes.full.url );

						}
					} else {
						jQuery( '#product_taxonomy_thumbnail' ).find( 'img' ).attr( 'src', attachment.url );
					}

					jQuery( '#product_taxonomy_thumbnail_id' ).val( attachment.id );
					jQuery( '.remove_image_button' ).show();
				});

				// Finally, open the modal.
				file_frame.open();
			});

			jQuery( document ).on( 'click', '.remove_image_button', function() {
				jQuery( '#product_taxonomy_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
				jQuery( '#product_taxonomy_thumbnail_id' ).val( '' );
				jQuery( '.remove_image_button' ).hide();
				return false;
			});

		</script>
		<div class="clear"></div>
	</div>
	<?php
}


/**
* Set Terms to a product
*/
public function set_terms_to_product($product_id_array, $term_id_array, $taxonomy_arrays )	{
	foreach ( $product_id_array as $product_id ) {

		foreach ($taxonomy_arrays as $taxonomy_value) {
			$attributess = array();

			if ( $taxonomy_value == 'product_color' ) {
				wp_set_post_terms( $product_id, $term_id_array, $taxonomy_value, true );
			} else {

				wp_set_post_terms( $product_id, $term_id_array, $taxonomy_value, true );



				$attributes = get_post_meta( $product_id, '_product_attributes', true );

				if ( !empty( $attributes ) ) {
					$count = count( $attributes );
					$attribute_position = ++$count;
					$attributess = $attributes;

					if ( !array_key_exists( $taxonomy_value, $attributes ) ) {

						$attributess[$taxonomy_value] = array(
							'name'          => $taxonomy_value,
							'value'         => '',
				        'position'      => $attribute_position, // the order in which it is displayed
				        'is_visible'    => true, // this is the one you wanted, set to true
				        'is_variation'  => false, // set to true if it will be used for variations
				        'is_taxonomy'   => true // set to true
				        );

						array_push($attributes, $attributess );

						update_post_meta( $product_id, '_product_attributes', $attributess );
					} else {
						$attributess[$taxonomy_value]['name'] = $taxonomy_value;
						$attributess[$taxonomy_value]['value'] = '';
						$attributess[$taxonomy_value]['position'] = $attribute_position;
						$attributess[$taxonomy_value]['is_visible'] = 1;
						$attributess[$taxonomy_value]['is_variation'] = 0;
						$attributess[$taxonomy_value]['is_taxonomy'] = 1;

						update_post_meta( $product_id, '_product_attributes', $attributess );
					}
				} else {
					$attributess[$taxonomy_value] = array(
						'name' => $taxonomy_value,
						'value' => '',
						'position' => 0,
						'is_visible' => 1,
						'is_variation' => 0,
						'is_taxonomy' => 1,
						);
					update_post_meta( $post_id, '_product_attributes', $attributess );
				}
			}
		}
	}

}


/**
 * Edit taxonomy thumbnail field.
 *
 * @param mixed $term Term (category) being edited
 */
public function edit_taxonomy_fields( $term ) {

	$thumbnail_id = absint( cc_get_term_meta( $term->term_id, 'thumbnail_id', true ) );
	$post_id =  cc_get_term_meta( $term->term_id, 'related_post_id', true );

	if ( $thumbnail_id ) {
		$image = wp_get_attachment_thumb_url( $thumbnail_id );
	} else {
		$image = cc_placeholder_img_src();
	}
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e( 'Choose Post', 'cc_product_filter' ); ?></label></th>
		<td>
			<?php $posts = $this->generateAttributePages_CPT(); ?>
			<select name="cpt_post_id">
				<option value=""><?php _e("Create New Post",'cc_product_filter')?></option>
				<?php foreach($posts as $key => $value): ?>
					<option value="<?php echo $key;?>" <?php selected($key,$post_id)?> ><?php echo $value?></option>
				<?php endforeach;?>
			</select>
			<p class="description"><?php _e("If you choose to Create New Post, then it takes Taxonomy name and description in above field as post title and content.","cc_product_filter");?></p>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e( 'Thumbnail', 'cc_product_filter' ); ?></label></th>
		<td>
			<div id="product_taxonomy_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
			<div style="line-height: 60px;">
				<input type="hidden" id="product_taxonomy_thumbnail_id" name="product_taxonomy_thumbnail_id" value="<?php echo $thumbnail_id; ?>" />
				<button type="button" class="upload_image_button button"><?php _e( 'Upload/Add image', 'cc_product_filter' ); ?></button>
				<button type="button" class="remove_image_button button"><?php _e( 'Remove image', 'cc_product_filter' ); ?></button>
			</div>
			<script type="text/javascript">

				// Only show the "remove image" button when needed
				if ( '0' === jQuery( '#product_taxonomy_thumbnail_id' ).val() ) {
					jQuery( '.remove_image_button' ).hide();
				}

				// Uploading files
				var file_frame;

				jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php _e( "Choose an image", "cc_product_filter" ); ?>',
						button: {
							text: '<?php _e( "Use image", "cc_product_filter" ); ?>'
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						var attachment = file_frame.state().get( 'selection' ).first().toJSON();

						jQuery( '#product_taxonomy_thumbnail_id' ).val( attachment.id );
						jQuery( '#product_taxonomy_thumbnail' ).find( 'img' ).attr( 'src', attachment.url );
						jQuery( '.remove_image_button' ).show();
					});

					// Finally, open the modal.
					file_frame.open();
				});

				jQuery( document ).on( 'click', '.remove_image_button', function() {
					jQuery( '#product_taxonomy_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
					jQuery( '#product_taxonomy_thumbnail_id' ).val( '' );
					jQuery( '.remove_image_button' ).hide();
					return false;
				});

			</script>
			<div class="clear"></div>
		</td>
	</tr>
	<?php
}

/**
 * cc_save_taxonomy_fields function.
 *
 * @param mixed $term_id Term ID being saved
 * @param mixed $tt_id
 * @param string $taxonomy
 */
public function cc_save_taxonomy_fields( $term_id, $tt_id = '' ) {

	if ( isset( $_POST['product_taxonomy_thumbnail_id'] ) && $_POST['product_taxonomy_thumbnail_id'] !='' ) {
		cc_update_term_meta_data( $term_id, 'thumbnail_id', absint( $_POST['product_taxonomy_thumbnail_id'] ) );
	}

	if(  isset( $_POST['cpt_post_id'] ) ) {

		if( $_POST['cpt_post_id'] == '' ) {

			$taxonomy = $this->get_taxonomy_by_term_taxonomy_id($tt_id);


			// create post id and insert its ID in related_post_id term meta
			$term = get_term( $term_id, $taxonomy->taxonomy );
			$name = $term->name;
			$desc = $term->description;
			// Create post object
			$post_arr = array(
				'post_title'    => wp_strip_all_tags( $name ),
				'post_content'  => $desc,
				'post_type'     => 'attribute',
				'post_status'   => 'publish',
				'post_author'   => get_current_user_id()
				);

			// Insert the post into the database
			$post_id = wp_insert_post( $post_arr );

			if( $post_id != false ){
				cc_update_term_meta_data($term_id,'related_post_id', absint( $post_id ) );
			}

		} else {
			cc_update_term_meta_data($term_id,'related_post_id',absint($_POST['cpt_post_id']));
		}
	}


}



/**
 * Thumbnail column added to taxonomy admin.
 *
 * @param mixed $columns
 * @return array
 */
public function product_taxonomy_columns( $columns ) {
	$new_columns          = array();
	$new_columns['cb']    = $columns['cb'];
	$new_columns['thumb'] = __( 'Image', 'cc_product_filter' );


	unset( $columns['cb'] );
	$columns['related_post_id'] = __( 'Post ID', 'cc_product_filter' );
	return array_merge( $new_columns, $columns );
}

/**
 * Thumbnail column value added to taxonomy admin.
 *
 * @param string $columns
 * @param string $column
 * @param int $id
 * @return array
 */
public function product_taxonomy_column( $columns, $column, $id ) {

	if ( 'thumb' == $column ) {

		$thumbnail_id = cc_get_term_meta( $id, 'thumbnail_id', true );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = cc_placeholder_img_src();
		}

		// Prevent esc_url from breaking spaces in urls for image embeds
		// Ref: http://core.trac.wordpress.org/ticket/23605
		$image = str_replace( ' ', '%20', $image );

		$columns .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Thumbnail', 'cc_product_filter' ) . '" class="wp-post-image" height="48" width="48" />';

	} else if ( "related_post_id" == $column) {
		$related_post_id = cc_get_term_meta( $id, 'related_post_id', true );
		if ( $related_post_id ) {
			$link_text = get_edit_post_link( $related_post_id);
			$columns .= '<a href="'.$link_text.'" target="_new">'.get_the_title($related_post_id).'</a>';
		}
	}


	return $columns;
}


public function generateAttributePages_CPT(){
	$posts = array();
		/**
		 * The WordPress Query class.
		 * @link http://codex.wordpress.org/Function_Reference/WP_Query
		 *
		 */
		$args = array(
			'post_type'         => 'attribute',
			'post_status'       => 'publish',
			'order'             => 'DESC',
			'orderby'           => 'date',
			'posts_per_page'    => -1,
			);

		$query = new WP_Query( $args );
		if( $query->have_posts() ):
			while ( $query->have_posts() ) :
				$query->the_post();
			$posts[ get_the_id() ] = get_the_title();
			endwhile;
			wp_reset_query();
			endif;
			return $posts;
		}


		public function delete_taxonomy_fields( $term, $taxonomy ){

			$related_post_id = get_term_meta( $term, 'related_post_id', true );
			wp_delete_post( $related_post_id, true );

		}

// create your own API call
		private function get_taxonomy_by_term_taxonomy_id( $term_taxonomy_id = '' ) {
			global $wpdb;
			if ( empty( $term_taxonomy_id ) ) {
				return false;
			}
			$taxonomy =
			$wpdb->get_row(
				$wpdb->prepare(
					"SELECT taxonomy FROM $wpdb->term_taxonomy WHERE term_taxonomy_id = %d LIMIT 1",
					$term_taxonomy_id
					)
				);
			return $taxonomy;
		}


} // class ends

// new CC_tags();