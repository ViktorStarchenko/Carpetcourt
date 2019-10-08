<?php
function carpet_court_get_all_sliders() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'slider_sliders';
    $all_sliders = $wpdb->get_results( "SELECT id, name from " .$table_name, ARRAY_A );
    return $all_sliders;
}

function carpert_court_random_slider_meta_boxes( $post ) {
    add_meta_box(
        'random-slider-select',
        __( 'For random sliders, select sliders below' ),
        'render_random_slider_meta_box',
        'page',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'carpert_court_random_slider_meta_boxes' );

function render_random_slider_meta_box( $post ) {
    $meta_box_html = '<p>';
    $rand_slider = get_post_meta( $post->ID, 'selected_random_sliders', true );
    $selected_random_sliders = !empty( $rand_slider ) ? $rand_slider : array() ;
    $meta_box_html .= '<label for="sliders-select">Select Sliders.(multiple allowed)</label>';
    $meta_box_html .= '<select name="ran_slider[]" id="sliders-select" multiple style="width:100%;">';
    $all_sliders = carpet_court_get_all_sliders();
    wp_nonce_field( 'random_slider_meta_box_nounce', 'random_slider_meta_box_nounce_check' );
    foreach( $all_sliders as $slider ) {
        $meta_box_html .= '<option type="checkbox" value="'.$slider['id'].'" '.carpet_court_if_selected( $slider['id'], $selected_random_sliders ).'>'.$slider['name'].'</option>';
    }
    $meta_box_html .= '</select>';
    $meta_box_html .= '</p>';
    echo $meta_box_html;
}

add_action( 'save_post', 'carpert_court_random_slider_meta_value' );
function carpert_court_random_slider_meta_value( $post_id ) {
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if( !isset( $_POST['random_slider_meta_box_nounce_check'] ) || !wp_verify_nonce( $_POST['random_slider_meta_box_nounce_check'], 'random_slider_meta_box_nounce' ) ) return;
    if( !current_user_can( 'edit_post' ) ) return;

    if( isset( $_POST['ran_slider'] ) ) {
        update_post_meta( $post_id, 'selected_random_sliders', $_POST['ran_slider'] );
    }
}

function carpet_court_if_selected( $value, $meta_values ) {
    if( in_array( $value, $meta_values ) ) {
        return 'selected="selected"';
    }
}
