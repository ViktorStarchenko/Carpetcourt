<?php

/**
 * Woo brand
 */
class Woo_Key_Feature {	
	
	private static $instance;
	public static function get_instance() {
		 	if( null == self::$instance ) {
		 		self::$instance = new Woo_Key_Feature();
		 	} 
		 	return self::$instance;
		} 


	public function __construct() {	
		
		add_action( 'init', array($this,'cc_key_feature_register') );
		
		// Add form
		add_action( 'product_feature_add_form_fields', array( $this, 'add_taxonomy_fields' ) );
		add_action( 'product_feature_edit_form_fields', array( $this, 'edit_taxonomy_fields' ), 10 );	

		// Add columns
		add_filter( 'manage_edit-product_feature_columns', array( $this, 'product_taxonomy_columns' ) );
		add_filter( 'manage_product_feature_custom_column', array( $this, 'product_taxonomy_column' ), 10, 3 );
		
		
		add_action( 'created_term', array( $this, 'cc_save_taxonomy_fields' ), 10, 3 );
		add_action( 'edit_term', array( $this, 'cc_save_taxonomy_fields' ), 10, 3 );

	}	

	/**
	 * Create a taxonomy
	 *
	 * @uses  Inserts new taxonomy object into the list
	 * @uses  Adds query vars
	 *
	 * @param string  Name of taxonomy object
	 * @param array|string  Name of the object type for the taxonomy object.
	 * @param array|string  Taxonomy arguments
	 * @return null|WP_Error WP_Error if errors, otherwise null.
	 */
	public function cc_key_feature_register(){
		
			$labels = array(
				'name'					=> _x( 'Feature', 'Feature', 'carpet-court' ),
				'singular_name'			=> _x( 'Feature', 'Feature', 'carpet-court' ),
				'search_items'			=> __( 'Search Feature', 'carpet-court' ),
				'all_items'				=> __( 'All Feature', 'carpet-court' ),
				'parent_item'			=> __( 'Parent Feature', 'carpet-court' ),
				'parent_item_colon'		=> __( 'Parent Feature', 'carpet-court' ),
				'edit_item'				=> __( 'Edit Feature', 'carpet-court' ),
				'update_item'			=> __( 'Update Feature', 'carpet-court' ),
				'add_new_item'			=> __( 'Add New Key Feature', 'carpet-court' ),
				'new_item_name'			=> __( 'New Feature Name', 'carpet-court' ),
				'menu_name'				=> __( 'Features', 'carpet-court' ),
			);
		
			$args = array(
				'labels'            => $labels,
				'public'            => true,
				'show_in_nav_menus' => true,
				'show_admin_column' => false,
				'hierarchical'      => true,
				'show_tagcloud'     => true,
				'show_ui'           => true,
				'query_var'         => true,
				'rewrite'           => true,
				'query_var'         => true,				
			);
		
		register_taxonomy( 'product_feature', array( 'product' ), $args );
		register_taxonomy_for_object_type( 'product_feature', 'product' );
		
	}
	
	/**
	 * taxonomy thumbnail fields.
	 */
	public function add_taxonomy_fields() {
		$image = wc_placeholder_img_src();
		?>		
		<div class="form-field">
			<label><?php _e( 'Thumbnail', 'carpet-court' ); ?></label>
			<div id="product_taxonomy_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
			<div style="line-height: 60px;">
				<input type="hidden" id="product_taxonomy_thumbnail_id" name="product_taxonomy_thumbnail_id" />
				<button type="button" class="upload_image_button button"><?php _e( 'Upload/Add image', 'carpet-court' ); ?></button>
				<button type="button" class="remove_image_button button"><?php _e( 'Remove image', 'carpet-court' ); ?></button>
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
						title: '<?php _e( "Choose an image", "carpet-court" ); ?>',
						button: {
							text: '<?php _e( "Use image", "carpet-court" ); ?>'
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
					jQuery( '#product_taxonomy_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( $image ); ?>' );
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
	 * Edit taxonomy thumbnail field.
	 *
	 * @param mixed $term Term (category) being edited
	 */
	public function edit_taxonomy_fields( $term ) {
		
		$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = wc_placeholder_img_src();
		}
		?>
		
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Thumbnail', 'carpet-court' ); ?></label></th>
			<td>
				<div id="product_taxonomy_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="product_taxonomy_thumbnail_id" name="product_taxonomy_thumbnail_id" value="<?php echo $thumbnail_id; ?>" />
					<button type="button" class="upload_image_button button"><?php _e( 'Upload/Add image', 'carpet-court' ); ?></button>
					<button type="button" class="remove_image_button button"><?php _e( 'Remove image', 'carpet-court' ); ?></button>
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
							title: '<?php _e( "Choose an image", "carpet-court" ); ?>',
							button: {
								text: '<?php _e( "Use image", "carpet-court" ); ?>'
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
	public function cc_save_taxonomy_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
		 
		if ( cc_is_taxonomy_exists( $taxonomy ) && isset( $_POST['product_taxonomy_thumbnail_id'] ) && $_POST['product_taxonomy_thumbnail_id'] !='' ) {
        	cc_update_term_meta_data( $term_id, 'thumbnail_id', absint( $_POST['product_taxonomy_thumbnail_id'] ) );
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
		$new_columns['thumb'] = __( 'Image', 'carpet-court' );

		unset( $columns['cb'] );

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

			$thumbnail_id = get_term_meta( $id, 'thumbnail_id', true );

			if ( $thumbnail_id ) {
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			} else {
				$image = wc_placeholder_img_src();
			}

			// Prevent esc_url from breaking spaces in urls for image embeds
			// Ref: http://core.trac.wordpress.org/ticket/23605
			$image = str_replace( ' ', '%20', $image );

			$columns .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Thumbnail', 'carpet-court' ) . '" class="wp-post-image" height="48" width="48" />';

		}

		return $columns;
	}

	


} // class ends


add_action( 'after_setup_theme', array( 'Woo_Key_Feature', 'get_instance' ) );