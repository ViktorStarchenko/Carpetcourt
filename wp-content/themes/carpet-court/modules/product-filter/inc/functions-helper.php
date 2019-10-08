<?php
function cc_placeholder_img_src($size = NULL) {
    $image = PATH_URL . 'images/placeholder.png' ;
    if ( !is_null($size) && $size != '' ){
        $org_size = $size;
        $size ='-'.$size;
        $image = PATH .'images/placeholder' . $size . '.png';
        if ( file_exists( $image ) ){
            return PATH_URL . 'images/placeholder' . $size . '.png' ;
        } else {
            return 'http://placehold.it/'.$org_size;
        }
    }
    return $image;
}

function cc_isNull( $var ) {

	if( is_null( $var ) ) {
		return $var;
	}
}

function cc_update_term_meta_data( $term_id, $term_key, $term_data ) {

    update_term_meta( $term_id, $term_key, $term_data );
}

function cc_is_taxonomy_exists($taxonomy_name = NULL ){

	if( !is_null( $taxonomy_name ) ) {
		return taxonomy_exists($taxonomy_name);
	}
}

function cc_get_term_meta( $term_id, $term_key, $single = true ) {

	return get_term_meta( $term_id, $term_key, $single );
}

function cc_filter_template_loop($taxonomy = NULL ) {
    $args = array(
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'       => 'ASC',
        'parent'   => 0
        );
    $loop_life = get_terms( $taxonomy, $args );
    $counter = 0;
    foreach($loop_life as $single) {
        $explode_tax = explode('_', $taxonomy);

        if ( $taxonomy != 'product_color' ) {
            // if( ($counter > 0) && ($counter % 3) == 0 && $taxonomy != 'pa_filter-colour' ) echo '</ul><ul class="cc_filter full-width-filter '.$explode_tax[1].'">';
        }

    $counter++;

    $thumbnail_id = cc_get_term_meta( $single->term_id, 'thumbnail_id', true );

    $image = cc_placeholder_img_src('340x260');
    if ( $thumbnail_id ) {
        $image = wp_get_attachment_image_src( $thumbnail_id, 'category_image' );
        $image = $image[0];
    }

        // Prevent esc_url from breaking spaces in urls for image embeds
        // Ref: http://core.trac.wordpress.org/ticket/23605
    $image = str_replace( ' ', '%20', $image );
    $template_path = PATH.'template-parts/filter_image_title.php';
    include( $template_path ) ;
    } // loop
}

function cc_filter_template_looppp($taxonomy = NULL ) {
    $args = array(
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'       => 'ASC',
        'parent'   => 0
        );
    $loop_life = get_terms( $taxonomy, $args );
    $counter = 0;
    foreach($loop_life as $single) {
        $explode_tax = explode('_', $taxonomy);

        if ( $taxonomy != 'product_color' ) {
            // if( ($counter > 0) && ($counter % 3) == 0 ) echo '</ul><ul class="cc_filter full-width-filter">';
        }

    $counter++;

    $thumbnail_id = cc_get_term_meta( $single->term_id, 'thumbnail_id', true );

    $image = cc_placeholder_img_src('340x260');
    if ( $thumbnail_id ) {
        $image = wp_get_attachment_image_src( $thumbnail_id, 'colour_palettes' );
        $image = $image[0];
    }

        // Prevent esc_url from breaking spaces in urls for image embeds
        // Ref: http://core.trac.wordpress.org/ticket/23605
    $image = str_replace( ' ', '%20', $image );
    $template_path = PATH.'template-parts/filter_image_title.php';
    include( $template_path ) ;
    } // loop
}

function cc_cpm_filter_template_loop($taxonomy = NULL ) {
	$args = array(
       'hide_empty' => false,
       'orderby'    => 'name',
       'order'       => 'ASC',
       'parent'   => 0
       );
	$loop_life = get_terms( $taxonomy, $args );
    $counter = 0;
    foreach($loop_life as $single) {
        $explode_tax = explode('_', $taxonomy);
        if ( $taxonomy != 'pa_sell' ) {
            # code...
            // if( ($counter > 0) && ($counter % 3) == 0 ) echo '</ul><ul class="cc_filter full-width-filter '.$explode_tax[1].'">';
        }
        $counter++;

        $thumbnail_id = cc_get_term_meta( $single->term_id, 'thumbnail_id', true );

        $image = cc_placeholder_img_src('340x260');
        if ( $thumbnail_id ) {
            $image = wp_get_attachment_image_src( $thumbnail_id, 'category_image' );
            $image = $image[0];
        }

    	// Prevent esc_url from breaking spaces in urls for image embeds
    	// Ref: http://core.trac.wordpress.org/ticket/23605
        $image = str_replace( ' ', '%20', $image );
        $template_path = PATH.'template-parts/cpm_filter_image_title.php';
        include( $template_path ) ;
    } // loop
}