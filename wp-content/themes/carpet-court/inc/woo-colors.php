<?php

/**
 * Woo Colors
 */
class Woo_colors {

	private static $instance;

	public static function get_instance() {
	 	if( null == self::$instance ) {
	 		self::$instance = new Woo_colors();
	 	}
	 	return self::$instance;
	}


	public function __construct() {

		add_action( 'init', array($this,'cc_color_register'), 10 );
		// Add form
		add_action( 'product_color_add_form_fields', array( $this, 'add_taxonomy_fields' ) );
		add_action( 'product_color_edit_form_fields', array( $this, 'edit_taxonomy_fields' ), 10 );

		add_action( 'pa_color_add_form_fields', array( $this, 'pa_color_add_taxonomy_fields' ) );
		add_action( 'pa_color_edit_form_fields', array( $this, 'pa_color_edit_taxonomy_fields' ), 10 );

		// Add columns
		add_filter( 'manage_edit-product_color_columns', array( $this, 'product_taxonomy_columns' ) );
		add_filter( 'manage_product_color_custom_column', array( $this, 'product_taxonomy_column' ), 10, 3 );


		add_action( 'created_product_color', array( $this, 'color_save_taxonomy_fields' ), 10, 2 );

		add_action( 'edit_product_color', array( $this, 'color_save_taxonomy_fields' ), 10, 2 );

		add_action('pre_delete_term', array( $this, 'delete_taxonomy_fields'), 10, 2 );



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
	public function cc_color_register(){
			$labels = array(
				'name'					=> _x( 'Colour Life', 'Colour', 'carpet-court' ),
				'singular_name'			=> _x( 'Colour', 'Colour', 'carpet-court' ),
				'search_items'			=> __( 'Search Colours', 'carpet-court' ),
				'all_items'				=> __( 'All Colours', 'carpet-court' ),
				'parent_item'			=> __( 'Parent Colour', 'carpet-court' ),
				'parent_item_colon'		=> __( 'Parent Colour', 'carpet-court' ),
				'edit_item'				=> __( 'Edit Colour', 'carpet-court' ),
				'update_item'			=> __( 'Update Colour', 'carpet-court' ),
				'add_new_item'			=> __( 'Add New Colour', 'carpet-court' ),
				'new_item_name'			=> __( 'New Colour Name', 'carpet-court' ),
				'menu_name'				=> __( 'Colours', 'carpet-court' ),
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

		register_taxonomy( 'product_color', array( 'product' ), $args );
		register_taxonomy_for_object_type( 'product_color', 'product' );

	}

	/**
	 * taxonomy thumbnail fields.
	 */
	public function add_taxonomy_fields() {
		$image = wc_placeholder_img_src();
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

						console.log(attachment);

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
	 * Pa Color taxonomy thumbnail fields.
	 */
	public function pa_color_add_taxonomy_fields() {
		$image = wc_placeholder_img_src();
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
						console.log(attachment.id);

						jQuery( '#product_taxonomy_thumbnail_id' ).val( attachment.id );
						jQuery( '#product_taxonomy_thumbnail' ).find( 'img' ).attr( 'src', attachment.url );
						// jQuery( '#product_taxonomy_thumbnail' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
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
		$post_id =  get_term_meta( $term->term_id, 'related_post_id', true );


		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = wc_placeholder_img_src();
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
	 * Pa Color Edit taxonomy thumbnail field.
	 *
	 * @param mixed $term Term (category) being edited
	 */
	public function pa_color_edit_taxonomy_fields( $term ) {

		$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
		$post_id =  get_term_meta( $term->term_id, 'related_post_id', true );


		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = wc_placeholder_img_src();
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

	public function color_save_taxonomy_fields( $term_id, $tt_id = '' ) {

		if ( isset( $_POST['product_taxonomy_thumbnail_id'] ) && $_POST['product_taxonomy_thumbnail_id'] !='' ) {
        	update_term_meta( $term_id, 'thumbnail_id', absint( $_POST['product_taxonomy_thumbnail_id'] ) );
		} elseif ( empty( $_POST['product_taxonomy_thumbnail_id'] ) ) {
			update_term_meta( $term_id, 'thumbnail_id', absint( $_POST['product_taxonomy_thumbnail_id'] ) );
		}

		if( isset( $_POST['cpt_post_id'] ) ) {

			if( $_POST['cpt_post_id'] == '' ) {

				// create post id and insert its ID in related_post_id term meta
				$term = get_term( $term_id, 'product_color' );
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
				$post_id = post_exists( $post_arr['post_title'] );

				if ( $post_id == 0 && !is_numeric($post_arr['post_title'])){
					//$post_id = wp_insert_post( $post_arr );
				}

				if( $post_id != false ){
					update_term_meta($term_id,'related_post_id', absint( $post_id ) );
				}

			} else {
				update_term_meta($term_id,'related_post_id',absint($_POST['cpt_post_id']));
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
		$new_columns['thumb'] = __( 'Image', 'carpet-court' );

		unset( $columns['cb'] );
		$columns['related_post_id'] = __( 'Post ID', 'cc_product_filter' );
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

		} else if ( "related_post_id" == $column) {
			$related_post_id = get_term_meta( $id, 'related_post_id', true );
			$link_text = get_edit_post_link( $related_post_id);
			$columns .= '<a href="'.$link_text.'" target="_new">'.get_the_title($related_post_id).'</a>';
		}


		return $columns;
	}

	public function generateAttributePages_CPT(){
		$posts = array();

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


	public function delete_taxonomy_fields($term, $taxonomy ){
		$related_post_id = get_term_meta( $term, 'related_post_id', true );
		wp_delete_post( $related_post_id );
	}


} // class ends

add_action( 'after_setup_theme', array( 'Woo_colors', 'get_instance' ) );