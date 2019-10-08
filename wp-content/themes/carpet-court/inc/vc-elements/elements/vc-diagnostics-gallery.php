<?php

add_action( 'vc_before_init', 'cc_diagnostics_integrateWithVC' );
function cc_diagnostics_integrateWithVC() {
    //fetch pages
    function cc_display_pages_ideasss() {
        $all_pages = array();
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'page-templates/template-popup.php'
            ));
        if (!empty($pages)) {
            foreach ($pages as $page) {
                $all_pages[htmlspecialchars_decode($page->post_title)] = $page->ID;
            }
        }
        return $all_pages;
    }

    /*CC CUstom Gallery*/

    vc_map( array(
        "name" => __("Pop Up Page Image Gallery", "carpet-court"),
        "base" => "cc_diagnostics_image_gallery",
        "as_parent" => array('only' => 'cc_diagnostics_gal_single_element'),
        "content_element" => true,
        "show_settings_on_create" => false,
        "is_container" => true,
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => __("No Of Columns", "carpet-court"),
                "param_name" => "column_no",
                'value' => array(
                 __('None', 'carpet-court') => '',
                 __('Three Column', 'carpet-court') => 'three-columns',
                 __('Four Column', 'carpet-court') => 'four-columns',
                 ),
                )
            ),
        "js_view" => 'VcColumnView'
        )
    );


    vc_map( array(
        "name" => __("Pop Up Page Image", "carpet-court"),
        "base" => "cc_diagnostics_gal_single_element",
        "content_element" => true,
        "as_child" => array('only' => 'cc_diagnostics_image_gallery'),
        "params" => array(
            array(
                "type" => "attach_image",
                "heading" => __("Choose Image", "carpet-court"),
                "param_name" => "image",
                ),
            array(
                "type" => "checkbox",
                "heading" => __("Show Title", "carpet-court"),
                "param_name" => "show_title",
                ),
            array(
                "type" => "checkbox",
                "heading" => __("Enable Overlay", "carpet-court"),
                "param_name" => "enable_rollover",
                ),
            array(
                "type" => "checkbox",
                "heading" => __("Show Title On Rollover", "carpet-court"),
                "param_name" => "show_title_rollover",
                'dependency' => array(
                    'element' => 'enable_rollover',
                    'value' => 'true',
                    ),
                ),
            array(
                "type" => "checkbox",
                "heading" => __("Enable Dividers", "carpet-court"),
                "param_name" => "enable_dividers",
                ),
            array(
                "type" => "colorpicker",
                "heading" => __("Rollover Text color", "carpet-court"),
                "param_name" => "rollover_text_color",
                'dependency' => array(
                    'element' => 'show_title_rollover',
                    'value' => 'true',
                    ),
                ),
            array(
                "type" => "textfield",
                "heading" => __("Title", "carpet-court"),
                "param_name" => "img_title",
                ),
            array(
                "type" => "colorpicker",
                "heading" => __("Text color", "carpet-court"),
                "param_name" => "text_color",
                ),
            array(
                "type" => "checkbox",
                "heading" => __("Show Description", "carpet-court"),
                "param_name" => "show_description",
                ),
            array(
                "type" => "textarea",
                "heading" => __("Description", "carpet-court"),
                "param_name" => "description_content",
                ),
            array(
                "type" => "dropdown",
                "heading" => __("Choose to show in pop up or link a page", "carpet-court"),
                "param_name" => "choose_popup_link",
                'value' => array(
                    __('None', 'carpet-court') => '',
                    __('Link To Page', 'carpet-court') => 'link_to_page',
                    __('Show In Pop Up', 'carpet-court') => 'show_in_popup',
                    ),
                ),
            array(
                "type"        => "vc_link",
                "heading"     => __("Choose page To Link", "carpet-court"),
                "param_name"  => "page_link",
                'dependency' => array(
                    'element' => 'choose_popup_link',
                    'value' => 'link_to_page',
                    ),
                ),
            array(
                "type" => "dropdown",
                "heading" => __("Choose page To Show in Pop up", "carpet-court"),
                "param_name" => "page_in_popup",
                'value' => cc_display_pages_ideasss(),
                'dependency' => array(
                    'element' => 'choose_popup_link',
                    'value' => 'show_in_popup',
                    ),
                ),
            /*array(
                "type" => "checkbox",
                "heading" => __("Show BUtton", "carpet-court"),
                "param_name" => "show_button",
                ),
            array(
                "type" => "colorpicker",
                "heading" => __("Button color", "carpet-court"),
                "param_name" => "button_color",
                'dependency' => array(
                    'element' => 'show_button',
                    'value' => 'true',
                    ),
                ),
            array(
                "type" => "colorpicker",
                "heading" => __("Button Text color", "carpet-court"),
                "param_name" => "button_text_color",
                'dependency' => array(
                    'element' => 'show_button',
                    'value' => 'true',
                    ),
                    ),*/
                    ),
        )
);


if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_cc_diagnostics_image_gallery extends WPBakeryShortCodesContainer {

        protected function content($atts, $content = null){

            $col_values = shortcode_atts( array(
                'column_no' => '',
                ), $atts );
            ob_start();

            $col_class = '';
            if ( !empty( $col_values['column_no'] ) ) {
                $col_class = $col_values['column_no'];
            }
            ?>
            <div class="vc_row wpb_row vc_inner vc_row-fluid">
                <ul class="cc_filter full-width-filter <?php echo $col_class; ?>">
                    <?php echo do_shortcode($content);?>
                </ul>
            </div>

            <?php
            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        }

    }
}

}


add_shortcode( 'cc_diagnostics_gal_single_element','cc_diagnostics_gal_single_element' );
function cc_diagnostics_gal_single_element( $atts ) {

 $values = shortcode_atts( array(
    'image'  =>  '',
    'img_title' => '',
    'show_title'  =>  '',
    'show_title_rollover'  =>  '',
    'rollover_text_color'  =>  '',
    'text_color'  =>  '',
    'show_description'  =>  '',
    'description_content'  =>  '',
    'choose_popup_link' => '',
    'page_in_popup'  =>  '',
    'page_link'     => '',
    'enable_rollover'     => '',
    'enable_dividers'     => '',
    // 'show_button'  =>  '',
    // 'button_color'  =>  '',
    // 'button_text_color'  =>  '',
    ), $atts );

 ob_start();

 $image = wp_get_attachment_image_src( $values['image'], 'category_image' );

   $title = str_replace(' ', '-', strtolower($values['img_title'])); // Replaces all spaces with hyphens.

   $stripped_title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);

   if (isset($values['choose_popup_link']) && $values['choose_popup_link'] != '') {
     if (isset($values['page_in_popup']) && $values['page_in_popup'] != '') {
        $wrapper = get_diagnostics_click_action( $values['choose_popup_link'], $values['page_in_popup'] );
    } elseif ( isset( $values['page_link'] ) && $values['page_link'] != '' ) {
        $link_page = vc_build_link($values['page_link']);
        $wrapper = get_diagnostics_click_action( $values['choose_popup_link'], $link_page );
    }
}
?>

<li class="col-md-4 col-sm-4 col-xs-12 wow fadeInUp">
    <?php  echo $wrapper['start']; ?>
    <div class="grid-item-content">
        <div class="fig-wrap">
            <figure class="fig-hover">
                <img src="<?php echo esc_url($image[0]); ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' ); ?>" width="340" height="260" class="wp-post-image" >
                <div class="cpm-block-title">
                    <div class="c-table">
                    <?php

                        $span_class = '';
                        if ( $values['enable_dividers'] == true ) {
                            $span_class = 't-cell';
                        } else {
                            $span_class = 'cpm-cell';
                        }
                    ?>
                      <span class="<?php echo $span_class; ?>">
                          <?php if ( $values['show_title'] ) {

                            $text_color = '';

                            if ( !empty( $values['text_color'] ) ) {
                                $text_color = 'style="color:'.$values['text_color'].';"';
                            }
                            ?>
                            <h3 class="title" <?php echo $text_color; ?>><?php echo $values['img_title']; ?></h3>
                            <?php } ?>
                        </span>
                    </div>
                </div>
            </figure>

            <?php

                if ( $values['enable_rollover'] == true) {
            ?>

            <figcaption class="hover-title fig-hover-one">
                <div class="fig-title" >
                    <div class="vert-middle">
                        <div class="div">
                            <?php
                            if ( $values['show_title_rollover'] ) {
                                $rollover_text_color = '';

                                if ( !empty( $values['rollover_text_color'] ) ) {
                                    $rollover_text_color = 'style="color:'.$values['rollover_text_color'].';"';
                                }
                                ?>

                                <h3 class="title" <?php echo $rollover_text_color; ?> ><?php echo $values['img_title']; ?></h3>
                                <?php
                            }

                            if ( $values['show_description'] ) { ?>
                            <p><?php echo $values['description_content']; ?></p>
                            <?php }

                           /* if ( !empty( $values['show_button'] ) ) {

                                echo $wrapper['start'];
                                $button_text_color = '';
                                if ( !empty($values['button_text_color'] ) ) {
                                    $button_text_color = 'style="color:'.$values['button_text_color'].'"';
                                }
                                ?>
                                <span <?php echo $button_text_color; ?>>

                                    VIEW MORE
                                </span>
                                <?php echo $wrapper['end'];
                            }*/ ?>

                            <!-- </a> -->
                        </div>
                    </div>
                </div>
            </figcaption>
            <?php } ?>
        </div>
    </div>
    <?php echo $wrapper['end']; ?>
</li>

<?php

$return_content = ob_get_contents();
ob_end_clean();
return $return_content;
}

function get_diagnostics_click_action( $page_action = '', $url_link = '' ) {
    $div_wrapper = array();

    switch ($page_action) {
        case "show_in_popup":
        if (!empty($url_link)):
            $div_wrapper['start'] = '<a href="'.get_permalink($url_link).'?iframe=true&width=100%&height=100%" rel="prettyPhoto">';
        $div_wrapper['end'] = '</a>';
        endif;
        break;

        case "link_to_page":
        if (!empty($url_link)):
            $div_wrapper['start'] = '<a href="' . $url_link['url'] . '" target="' . $url_link['target'] . '" title="' . $url_link['title'] . '">';
        $div_wrapper['end'] = '</a>';
        endif;
        break;

        default:
        $div_wrapper['start'] = '<div>';
        $div_wrapper['end'] = '</div>';
        break;

    }
    return $div_wrapper;
}