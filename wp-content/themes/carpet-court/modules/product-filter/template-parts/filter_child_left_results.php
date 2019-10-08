<?php
/**
 * filter page used in loop as child terms
 */


$checked = checked( $single->term_id, (isset( $_POST[$taxonomy] ) && in_array( $single->term_id, $_POST[$taxonomy][0] ) ? $single->term_id : '' ), false );
$active_class = '';
if ( isset( $_POST[$taxonomy] ) && in_array( $single->term_id, $_POST[$taxonomy] ) ) {
    $active_class = 'active';
}


$termchildren = get_term_children( $single->term_id, $taxonomy );

if ( !empty( $termchildren[0] ) ) { ?>

<ul class="hidden cpm-child-ul col-<?php echo ($taxonomy=="product_color")?'two':'two'; ?>" data-parent="<?php echo $single->slug; ?>">
    <h4><?php echo ucfirst($single->name); ?> Palettes</h4>
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
        <li class="cpm-child">
            <?php if ( !empty( $child_image ) ) { ?>
            <figure class="fig-hover">

             <a href="#" class="cpm-img-checkbox">

                <img src="<?php echo esc_url($child_image) ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' );?>"  class="wp-post-image"/>
            </a>
        </figure>
        <?php } ?>
        <div class="ms-checkbox">
            <input type="checkbox" name="child_<?php echo $taxonomy ?>[]"  class="filter-checkbox-btn checkbox-custom <?php echo $taxonomy ?> cpm_hide" id="term_<?php echo $child_terms_object->term_id ?>" data-taxonomy="<?php echo $taxonomy ?>" value="<?php echo $child_terms_object->term_id ?>" data-term="<?php echo $child_terms_object->slug; ?>" <?php echo $checked;?> />
            <label for="term_<?php echo $child_terms_object->term_id ?>" class="checkbox-custom-label"><span><?php echo $child_terms_object->name ?></span></label>
        </div>
    </li>
    <?php } ?>
</ul>
<?php } ?>