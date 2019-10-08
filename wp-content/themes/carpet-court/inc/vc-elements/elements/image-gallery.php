<?php
/**
 * Created by PhpStorm.
 * User: Rubal
 * Date: 2/26/16
 * Time: 1:58 PM
 */
add_action( 'vc_before_init', 'cc_ideas_integrateWithVC' );
function cc_ideas_integrateWithVC(){

    //fetch pages
    function cc_display_pages_ideas() {
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

    //fetch product tags
    function cc_products_tags_fetch() {
        $all_tags = array();
        $terms = get_terms( array(
            'taxonomy' => 'product_tag',
            'hide_empty' => false,
            ) );

        if ( !empty( $terms ) ) {

            foreach ($terms as $term_value) {
                $all_tags[htmlspecialchars_decode($term_value->name)] = $term_value->term_id;
            }
        }

        return $all_tags;

    }

    //display posts of ideas
    function cc_idea_postss(){
        $all_posts = array();
        $idea_args = array(
            'post_type'=>'cc_ideas',
            'post_status'=>'publish',
            'posts_per_page'=> -1,
            );
        $posts = get_posts( $idea_args );
        foreach ($posts as $post_value) {
            $all_posts[html_entity_decode(utf8_decode($post_value->post_title))] = $post_value->ID;
        }
        wp_reset_postdata();
        wp_reset_query();
        return $all_posts;
    }
    function cc_idea_categories() {
        $all_idea_terms = get_terms( array( 'taxonomy' => 'cc_idea_cat' ) );
        $terms_array = array();
        if( ! empty( $all_idea_terms ) ) {
            foreach( $all_idea_terms as $idea_term ) {
                $terms_array[html_entity_decode( utf8_decode( $idea_term->name ) )] = $idea_term->term_id;
            }
        }
        return $terms_array;

    }


    vc_map( array(
        "name" => __("Image Gallery", "carpet-court"),
        "base" => "cc_image_gallery",
        "as_parent" => array('only' => 'cc_gal_single_element, cc_gal_cat_element'),
        "content_element" => true,
        "show_settings_on_create" => false,
        "is_container" => true,
        "params" => array(
            array(
                "type" => "checkbox",
                "heading" => __("Show Filter", "carpet-court"),
                "param_name" => "show_filter",
                )
            ),
        "js_view" => 'VcColumnView'
        ) );

    vc_map( array(
        "name" => __("Idea", "carpet-court"),
        "base" => "cc_gal_single_element",
        "content_element" => true,
        "as_child" => array('only' => 'cc_image_gallery'),
        "params" => array(
            array(
                "type"        => "dropdown",
                "heading"     => __("Choose Post", "carpet-court"),
                "param_name"  => "idea_post",
                'value' => cc_idea_postss(),
                ),
            array(
                "type" => "checkbox",
                "heading" => __("Show Title", "carpet-court"),
                "param_name" => "show_title",
                ),
            array(
                "type" => "checkbox",
                "heading" => __("Show Excerpt", "carpet-court"),
                "param_name" => "show_excerpt",
                ),
            array(
                "type" => "checkbox",
                "heading" => __("Use background color instead of Featured Image", "carpet-court"),
                "param_name" => "use_background",
                ),
            array(
                "type" => "colorpicker",
                "heading" => __("Background color", "carpet-court"),
                "param_name" => "background_color",
                'dependency' => array(
                    'element' => 'use_background',
                    'value' => 'true',
                    ),
                ),
            array(
                "type" => "checkbox",
                "heading" => __("Use Background Color Overlay ", "carpet-court"),
                "param_name" => "use_color_overlay",
                ),
            array(
                "type" => "colorpicker",
                "heading" => __("Overlay color", "carpet-court"),
                "param_name" => "use_overlay_color",
                'dependency' => array(
                    'element' => 'use_color_overlay',
                    'value' => 'true',
                    ),
                ),
            array(
                "type" => "dropdown",
                "heading" => __("Content Display Style", "carpet-court"),
                "param_name" => "content_display_style",
                'value' => array(
                    __('Small Square', 'carpet-court') => 'isotope-small',
                    __('Vertical Rectangle', 'carpet-court') => 'isotope-vertical',
                    __('Horizontal Rectangle', 'carpet-court') => 'isotope-horizontal',
                    __('Large Square', 'carpet-court') => 'isotope-big',
                    ),
                ),
            array(
                'type' => 'dropdown',
                'heading' => __('On Click action', 'carpet-court'),
                'param_name' => 'onclick_action',
                'value' => array(
                    __('None', 'carpet-court') => '',
                    __('Show large Image', 'carpet-court') => 'large_image',
                    __('Open Page in pop up', 'carpet-court') => 'page_in_popup',
                    __('Link another page', 'carpet-court') => 'link_to_page',
                    ),
                'description' => __('Select action for click.', 'carpet-court'),
                ),
            array(
                "type" => "dropdown",
                "heading" => __("Choose page To Show in Pop up", "carpet-court"),
                "param_name" => "page_in_popup",
                'dependency' => array(
                    'element' => 'onclick_action',
                    'value' => array('page_in_popup'),
                    ),
                'value' => cc_display_pages_ideas(),
                ),
            array(
                "type" => "vc_link",
                "heading" => __("Choose page To Link", "carpet-court"),
                "param_name" => "link_to_page",
                'dependency' => array(
                    'element' => 'onclick_action',
                    'value' => array('link_to_page'),
                    ),
                ),
            array(
                "type" => "attach_image",
                "heading" => __("Choose Image", "carpet-court"),
                "param_name" => "large_image",
                'dependency' => array(
                    'element' => 'onclick_action',
                    'value' => array('large_image'),
                    ),
                ),
            array(
                'type' => 'checkbox',
                'heading' => __('On Hover Overlay action', 'carpet-court'),
                'param_name' => 'onhover_overlay_action',
                'value' => array(
                    __('Show Overlay', 'carpet-court') => 'show_overlay',
                    ),
                ),
            array(
                "type" => "colorpicker",
                "heading" => __("Hover Overlay color", "carpet-court"),
                "param_name" => "hover_overlay_color",
                'dependency' => array(
                    'element' => 'onhover_overlay_action',
                    'value' => array('show_overlay'),
                    ),
                ),
            array(
                "type" => "colorpicker",
                "heading" => __("Hover Overlay Text Color", "carpet-court"),
                "param_name" => "hover_overlay_text_color",
                'dependency' => array(
                    'element' => 'onhover_overlay_action',
                    'value' => array('show_overlay'),
                    ),
                ),
            array(
                "type" => "textfield",
                "heading" => __("Hover Overlay Title", "carpet-court"),
                "param_name" => "hover_overlay_title",
                'dependency' => array(
                    'element' => 'onhover_overlay_action',
                    'value' => array('show_overlay'),
                    ),
                ),
            array(
                "type" => "textfield",
                "heading" => __("Hover Overlay Sub Title", "carpet-court"),
                "param_name" => "hover_overlay_subtitle",
                'dependency' => array(
                    'element' => 'onhover_overlay_action',
                    'value' => array('show_overlay'),
                    ),
                ),
            array(
                "type" => "dropdown",
                "heading" => __("Enable Overlay Divider", "carpet-court"),
                "param_name" => "enable_overlay_divider",
                'value' => array(
                    __('No', 'carpet-court') => 'no',
                    __('Yes', 'carpet-court') => 'yes',
                    ),
                'dependency' => array(
                    'element' => 'onhover_overlay_action',
                    'value' => array('show_overlay'),
                    ),
                ),
            array(
                "type" => "checkbox",
                "heading" => __("Show Divider:", "carpet-court"),
                "param_name" => "show_overlay_divider",
                'dependency' => array(
                    'element' => 'enable_overlay_divider',
                    'value' => array('yes'),
                    ),
                'value' => array(
                    __('Above Title', 'carpet-court') => 'above',
                    __('Below Title', 'carpet-court') => 'below',
                    ),
                ),
            array(
                "type" => "colorpicker",
                "heading" => __("Divider Color", "carpet-court"),
                "param_name" => "overlay_divider_color",
                'dependency' => array(
                    'element' => 'enable_overlay_divider',
                    'value' => array('yes'),
                    ),
                ),
            array(
                "type" => "dropdown",
                "heading" => __("Enable Overlay Border", "carpet-court"),
                "param_name" => "overlay_border",
                'value' => array(
                    __('No', 'carpet-court') => 'no',
                    __('Yes', 'carpet-court') => 'yes',
                    ),
                'dependency' => array(
                    'element' => 'onhover_overlay_action',
                    'value' => array('show_overlay'),
                    ),
                ),
            array(
                "type" => "colorpicker",
                "heading" => __("Overlay Border Color", "carpet-court"),
                "param_name" => "overlay_border_color",
                'dependency' => array(
                    'element' => 'overlay_border',
                    'value' => array('yes'),
                    ),
                ),
            array(
                "type" => "dropdown",
                "heading" => __("Enable Button", "carpet-court"),
                "param_name" => "overlay_button",
                'value' => array(
                    __('No', 'carpet-court') => 'no',
                    __('Yes', 'carpet-court') => 'yes',
                    ),
                'dependency' => array(
                    'element' => 'onhover_overlay_action',
                    'value' => array('show_overlay'),
                    ),
                ),
            array(
                "type" => "textfield",
                "heading" => __("Hover Overlay Button Text", "carpet-court"),
                "param_name" => "overlay_button_text",
                'dependency' => array(
                    'element' => 'overlay_button',
                    'value' => array('yes'),
                    ),
                ),
            array(
                "type" => "colorpicker",
                "heading" => __("Hover Overlay Button Text Color", "carpet-court"),
                "param_name" => "overlay_button_text_color",
                'dependency' => array(
                    'element' => 'overlay_button',
                    'value' => array('yes'),
                    ),
                ),
            array(
                "type" => "colorpicker",
                "heading" => __("Hover Overlay Button Background Color", "carpet-court"),
                "param_name" => "overlay_button_bg_color",
                'dependency' => array(
                    'element' => 'overlay_button',
                    'value' => array('yes'),
                    ),
                ),
            array(
                'type' => 'checkbox',
                'heading' => __('On Hover Image effect', 'carpet-court'),
                'param_name' => 'onhover_image_effect',
                'value' => array(
                    __('Show Image Effect', 'carpet-court') => 'show_image_effect',
                    ),
                ),
            array(
                "type" => "dropdown",
                "heading" => __("Image Hover Effect", "carpet-court"),
                "param_name" => "image_hover_effect",
                'value' => array(
                    __('None', 'carpet-court') => 'none',
                    __('Zoom', 'carpet-court') => 'zoom_image',
                    __('Grayscale', 'carpet-court') => 'grayscale_image',
                    ),
                'dependency' => array(
                    'element' => 'onhover_image_effect',
                    'value' => array('show_image_effect'),
                    ),
                ),
            )
) );
vc_map( array(
    "name" => __("Idea Category", "carpet-court"),
    "base" => "cc_gal_cat_element",
    "content_element" => true,
    "as_child" => array('only' => 'cc_image_gallery'),
    "params" => array(
        array(
            "type"        => "dropdown",
            "heading"     => __("Choose Category", "carpet-court"),
            "param_name"  => "idea_post_category",
            'value' => cc_idea_categories(),
            ),
        array(
            "type"        => "Text",
            "heading"     => __("Limit", "carpet-court"),
            "param_name"  => "idea_post_category_limit",
            'value' => '',
            ),
        array(
            "type" => "checkbox",
            "heading" => __("Show Title", "carpet-court"),
            "param_name" => "show_title",
            ),
        array(
            "type" => "checkbox",
            "heading" => __("Show Excerpt", "carpet-court"),
            "param_name" => "show_excerpt",
            ),
        array(
            "type" => "checkbox",
            "heading" => __("Use background color instead of Featured Image", "carpet-court"),
            "param_name" => "use_background",
            ),
        array(
            "type" => "colorpicker",
            "heading" => __("Background color", "carpet-court"),
            "param_name" => "background_color",
            'dependency' => array(
                'element' => 'use_background',
                'value' => 'true',
                ),
            ),
        array(
            "type" => "dropdown",
            "heading" => __("Content Display Style", "carpet-court"),
            "param_name" => "content_display_style",
            'value' => array(
                __('Small Square', 'carpet-court') => 'isotope-small',
                __('Vertical Rectangle', 'carpet-court') => 'isotope-vertical',
                __('Horizontal Rectangle', 'carpet-court') => 'isotope-horizontal',
                __('Large Square', 'carpet-court') => 'isotope-big',
                ),
            ),
        array(
            'type' => 'checkbox',
            'heading' => __('On Hover Overlay action', 'carpet-court'),
            'param_name' => 'onhover_overlay_action',
            'value' => array(
                __('Show Overlay', 'carpet-court') => 'show_overlay',
                ),
            ),
        array(
            "type" => "colorpicker",
            "heading" => __("Hover Overlay color", "carpet-court"),
            "param_name" => "hover_overlay_color",
            'dependency' => array(
                'element' => 'onhover_overlay_action',
                'value' => array('show_overlay'),
                ),
            ),
        array(
            "type" => "colorpicker",
            "heading" => __("Hover Overlay Text Color", "carpet-court"),
            "param_name" => "hover_overlay_text_color",
            'dependency' => array(
                'element' => 'onhover_overlay_action',
                'value' => array('show_overlay'),
                ),
            ),
        array(
            "type" => "textfield",
            "heading" => __("Hover Overlay Title", "carpet-court"),
            "param_name" => "hover_overlay_title",
            'dependency' => array(
                'element' => 'onhover_overlay_action',
                'value' => array('show_overlay'),
                ),
            ),
        array(
            "type" => "textfield",
            "heading" => __("Hover Overlay Sub Title", "carpet-court"),
            "param_name" => "hover_overlay_subtitle",
            'dependency' => array(
                'element' => 'onhover_overlay_action',
                'value' => array('show_overlay'),
                ),
            ),
        array(
            "type" => "dropdown",
            "heading" => __("Enable Overlay Divider", "carpet-court"),
            "param_name" => "enable_overlay_divider",
            'value' => array(
                __('No', 'carpet-court') => 'no',
                __('Yes', 'carpet-court') => 'yes',
                ),
            'dependency' => array(
                'element' => 'onhover_overlay_action',
                'value' => array('show_overlay'),
                ),
            ),
        array(
            "type" => "checkbox",
            "heading" => __("Show Divider:", "carpet-court"),
            "param_name" => "show_overlay_divider",
            'dependency' => array(
                'element' => 'enable_overlay_divider',
                'value' => array('yes'),
                ),
            'value' => array(
                __('Above Title', 'carpet-court') => 'above',
                __('Below Title', 'carpet-court') => 'below',
                ),
            ),
        array(
            "type" => "colorpicker",
            "heading" => __("Divider Color", "carpet-court"),
            "param_name" => "overlay_divider_color",
            'dependency' => array(
                'element' => 'enable_overlay_divider',
                'value' => array('yes'),
                ),
            ),
        array(
            "type" => "dropdown",
            "heading" => __("Enable Overlay Border", "carpet-court"),
            "param_name" => "overlay_border",
            'value' => array(
                __('No', 'carpet-court') => 'no',
                __('Yes', 'carpet-court') => 'yes',
                ),
            'dependency' => array(
                'element' => 'onhover_overlay_action',
                'value' => array('show_overlay'),
                ),
            ),
        array(
            "type" => "colorpicker",
            "heading" => __("Overlay Border Color", "carpet-court"),
            "param_name" => "overlay_border_color",
            'dependency' => array(
                'element' => 'overlay_border',
                'value' => array('yes'),
                ),
            "type" => "dropdown",
            "heading" => __("Enable Button", "carpet-court"),
            "param_name" => "overlay_button",
            'value' => array(
                __('No', 'carpet-court') => 'no',
                __('Yes', 'carpet-court') => 'yes',
                ),
            'dependency' => array(
                'element' => 'onhover_overlay_action',
                'value' => array('show_overlay'),
                ),
            ),
        array(
            "type" => "textfield",
            "heading" => __("Hover Overlay Button Text", "carpet-court"),
            "param_name" => "overlay_button_text",
            'dependency' => array(
                'element' => 'overlay_button',
                'value' => array('yes'),
                ),
            ),
        array(
            "type" => "colorpicker",
            "heading" => __("Hover Overlay Button Text Color", "carpet-court"),
            "param_name" => "overlay_button_text_color",
            'dependency' => array(
                'element' => 'overlay_button',
                'value' => array('yes'),
                ),
            ),
        array(
            "type" => "colorpicker",
            "heading" => __("Hover Overlay Button Background Color", "carpet-court"),
            "param_name" => "overlay_button_bg_color",
            'dependency' => array(
                'element' => 'overlay_button',
                'value' => array('yes'),
                ),
            ),
        array(
            'type' => 'checkbox',
            'heading' => __('On Hover Image effect', 'carpet-court'),
            'param_name' => 'onhover_image_effect',
            'value' => array(
                __('Show Image Effect', 'carpet-court') => 'show_image_effect',
                ),
            ),
        array(
            "type" => "dropdown",
            "heading" => __("Image Hover Effect", "carpet-court"),
            "param_name" => "image_hover_effect",
            'value' => array(
                __('None', 'carpet-court') => 'none',
                __('Zoom', 'carpet-court') => 'zoom_image',
                __('Grayscale', 'carpet-court') => 'grayscale_image',
                ),
            'dependency' => array(
                'element' => 'onhover_image_effect',
                'value' => array('show_image_effect'),
                ),
            ),
        )
) );

/*CC CUstom Gallery*/

vc_map( array(
    "name" => __("Masonry Image Gallery", "carpet-court"),
    "base" => "cc_masonary_image_gallery",
    "as_parent" => array('only' => 'cc_masonary_gal_single_element'),
    "content_element" => true,
    "show_settings_on_create" => false,
    "is_container" => true,
    "js_view" => 'VcColumnView'
    ) );

vc_map( array(
    "name" => __("Masonry Image", "carpet-court"),
    "base" => "cc_masonary_gal_single_element",
    "content_element" => true,
    "as_child" => array('only' => 'cc_masonary_image_gallery'),
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
            "type" => "textfield",
            "heading" => __("Title", "carpet-court"),
            "param_name" => "img_title",
            ),
        array(
            "type" => "checkbox",
            "heading" => __("Show Sub Title", "carpet-court"),
            "param_name" => "show_sub_title",
            ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => __("Sub Title", "carpet-court"),
            "param_name" => "sub_title",
            ),
        array(
            "type" => "dropdown",
            "heading" => __("Enable Divider", "carpet-court"),
            "param_name" => "enable_divider",
            'value' => array(
                __('No', 'carpet-court') => 'no',
                __('Yes', 'carpet-court') => 'yes',
                ),
            ),
        array(
            "type" => "checkbox",
            "heading" => __("Show Divider:", "carpet-court"),
            "param_name" => "show_divider",
            'dependency' => array(
                'element' => 'enable_divider',
                'value' => array('yes'),
                ),
            'value' => array(
                __('Above Title', 'carpet-court') => 'above',
                __('Below Title', 'carpet-court') => 'below',
                ),
            ),
        array(
            "type" => "colorpicker",
            "heading" => __("Divider Color", "carpet-court"),
            "param_name" => "divider_color",
            'dependency' => array(
                'element' => 'enable_divider',
                'value' => array('yes'),
                ),
            ),
        array(
            "type" => "checkbox",
            "heading" => __("Use Text Color ", "carpet-court"),
            "param_name" => "use_color_overlay",
            ),
        array(
            "type" => "colorpicker",
            "heading" => __("Text color", "carpet-court"),
            "param_name" => "use_text_color",
            'dependency' => array(
                'element' => 'use_color_overlay',
                'value' => 'true',
                ),
            ),

        array(
            "type" => "checkbox",
            "heading" => __("Enable Rollover", "carpet-court"),
            "param_name" => "enable_rollover",
            ),
        array(
            "type" => "checkbox",
            "heading" => __("Use background color for text content", "carpet-court"),
            "param_name" => "use_background",
            "dependency" => array(
                'element' => 'enable_rollover',
                'value' => 'true',
                )
            ),
        array(
            "type" => "colorpicker",
            "heading" => __("Background color", "carpet-court"),
            "param_name" => "background_color",
            'dependency' => array(
                'element' => 'use_background',
                'value' => 'true',
                ),
            ),
        array(
            "type" => "checkbox",
            "heading" => __("Enable Zoom In", "carpet-court"),
            "param_name" => "enable_zoom_in",
            ),
        array(
            "type" => "dropdown",
            "heading" => __("Content Display Style", "carpet-court"),
            "param_name" => "content_display_style",
            'value' => array(
                __('Small Square', 'carpet-court') => 'isotope-small',
                __('Horizontal Rectangle', 'carpet-court') => 'isotope-horizontal',
                __('Large Square', 'carpet-court') => 'isotope-big',
                ),
            ),
        array(
            'type' => 'dropdown',
            'heading' => __('On Click action', 'carpet-court'),
            'param_name' => 'onclick_action',
            'value' => array(
                __('None', 'carpet-court') => '',
                __('Show large Image', 'carpet-court') => 'large_image',
                __('Link another page', 'carpet-court') => 'link_to_page',
                __('Link Product Tags', 'carpet-court') => 'link_to_tags',
                __('Show Video', 'carpet-court') => 'show_video',
                ),
            'description' => __('Select action for click.', 'carpet-court'),
            ),
        array(
            "type" => "textfield",
            "heading" => __("Video Url", "carpet-court"),
            "param_name" => "video_link",
            'dependency' => array(
                'element' => 'onclick_action',
                'value' => array('show_video'),
                ),
            ),
        array(
            "type" => "dropdown",
            "heading" => __("Select Tag", "carpet-court"),
            "param_name" => "product_tags_link",
            "value" => cc_products_tags_fetch(),
            'dependency' => array(
                'element' => 'onclick_action',
                'value' => array('link_to_tags'),
                ),
            ),
        array(
            "type" => "vc_link",
            "heading" => __("Choose page To Link", "carpet-court"),
            "param_name" => "link_to_page",
            'dependency' => array(
                'element' => 'onclick_action',
                'value' => array('link_to_page'),
                ),
            ),
        array(
            "type" => "attach_image",
            "heading" => __("Choose Image", "carpet-court"),
            "param_name" => "large_image",
            'dependency' => array(
                'element' => 'onclick_action',
                'value' => array('large_image'),
                ),
            ),
        )
)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_cc_masonary_image_gallery extends WPBakeryShortCodesContainer {

        protected function content($atts, $content = null){
            ob_start();
            ?>
            <div id="cc-isotope-list" class="cpm-masonry">
                <?php echo do_shortcode($content);?>
            </div>

            <?php
            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        }

    }
}

}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_cc_image_gallery extends WPBakeryShortCodesContainer {

        protected function content($atts, $content = null){
            $values = shortcode_atts( array(
                'show_filter'  =>  '',
                ), $atts );

            ob_start();

            $terms = array();

            if('true' == $values['show_filter']):

                if(!empty($content)):

                    $pattern = '/idea_post="[\d+]+"/';
                preg_match_all($pattern, $content, $matches);

                $pattern2 = '/[\d+]+/';
                $post_ids = array();
                foreach($matches[0] as $match){
                    preg_match($pattern2, $match, $target);
                    /*fetch posts ids*/
                    $post_ids[] = $target[0];
                }
                foreach($post_ids as $post_id){
                    $temp = get_the_terms($post_id,'cc_idea_cat');
                    if(!empty($temp)):
                        foreach($temp as $cat_name){
                            /*fetch category names*/
                            $terms[$cat_name->slug] = $cat_name->name;
                        }
                        endif;
                    }
                    ?>
                    <div class="isotope-filter">
                        <ul id="filters">
                            <li><a href="#" data-filter="*" class="selected">ALL</a></li>
                            <?php
                            foreach ( $terms as $key => $value ) {
                                echo "<li><a href='#' data-filter='.".$key."'>" . $value. "</a></li>\n";
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                    endif;
                    endif;
                    ?>
                    <!-- <div class="vc_row wpb_row vc_inner vc_row-fluid"> -->
                    <div id="isotope-list" class="cpm-isotope-list">
                        <?php echo do_shortcode($content);?>
                    </div>
                    <!-- </div> -->
                    <?php
                    $output = ob_get_contents();
                    ob_end_clean();
                    return $output;
                }

            }
        }


        add_shortcode('cc_gal_single_element','cc_gal_single_element');
        function cc_gal_single_element($atts){

            $values = shortcode_atts( array(
                'idea_post'  =>  '',
                'show_title'  =>  '',
                'show_excerpt'  =>  '',
                'use_background'  =>  '',
                'background_color'  =>  '',
                'content_display_style'  =>  '',
                'onclick_action'  =>  '',
                'page_in_popup'  =>  '',
                'link_to_page'  =>  '',
                'large_image'  =>  '',
                'onhover_overlay_action' => '',
                'hover_overlay_color' => '',
                'hover_overlay_text_color' => '',
                'hover_overlay_title' => '',
                'hover_overlay_subtitle' => '',
                'enable_overlay_divider' => '',
                'show_overlay_divider' => '',
                'overlay_divider_color' => '',
                'overlay_border' => '',
                'overlay_border_color' => '',
                'overlay_button' => '',
                'overlay_button_text' => '',
                'overlay_button_text_color' => '',
                'overlay_button_bg_color' => '',
                'onhover_image_effect' => '',
                'image_hover_effect' => '',
                'use_color_overlay' => '',
                'use_overlay_color' => ''
                ), $atts );

            ob_start();

            $wrapper = array();
            $image_effect = '';
            $over_class = $overlay_div = '';
            $overlay = $overlay_color = $overlay_text_color = $overlay_title = $overlay_subtitle = $overlay_border_color = $overlay_button_text = $overlay_button_text_color = $overlay_button_bg_color = '';
            $show_overlay_divider['above'] = '';
            $show_overlay_divider['below'] = '';
            $wrapper['start'] =  $wrapper['end'] = '';


            /*on click*/
            if (isset($values['onclick_action'])) {
                if (isset($values['page_in_popup']) && $values['page_in_popup'] != '') {
                    $wrapper = get_idea_click_action($values['onclick_action'], $values['page_in_popup']);
                } elseif (isset($values['link_to_page']) && $values['link_to_page'] != '') {
                    $link_page = vc_build_link($values['link_to_page']);
                    $wrapper = get_idea_click_action($values['onclick_action'], '', $link_page);
                }  elseif (isset($values['large_image']) && $values['large_image'] != '') {
                    $wrapper = get_idea_click_action($values['onclick_action'],'','',$values['large_image']);
                }
            }


            /*on hover overlay*/
            if (isset($values['onhover_overlay_action']) && $values['onhover_overlay_action'] != '') {

                /*hover overlay divider options*/
                if( isset($values['enable_overlay_divider']) && 'yes'== $values['enable_overlay_divider'] ){
                    $overlay_divider = explode(',',$values['show_overlay_divider']);
                    if(in_array('above',$overlay_divider)){
                        $show_overlay_divider['above']='<i class="isotope-seperator seperator-top" style="background-color: '.$values['overlay_divider_color'].'"></i>';
                    }
                    if(in_array('below',$overlay_divider)){
                        $show_overlay_divider['below']='<i class="isotope-seperator seperator-bottom" style="background-color: '.$values['overlay_divider_color'].'"></i>';
                    }
                }

                if (!empty($values['hover_overlay_color'])) {
                    $overlay_color = $values['hover_overlay_color'];
                }
                if (!empty($values['hover_overlay_text_color'])) {
                    $overlay_text_color = $values['hover_overlay_text_color'];
                }
                if (!empty($values['hover_overlay_title'])) {
                    $overlay_title = $values['hover_overlay_title'];
                }
                if (!empty($values['hover_overlay_subtitle'])) {
                    $overlay_subtitle = $values['hover_overlay_subtitle'];
                }
                if ('yes' == $values['overlay_border']) {
                    if (!empty($values['overlay_border_color'])) {
                        $overlay_border_color = $values['overlay_border_color'];
                    }
                }
                if ('yes' == $values['overlay_button']) {
                    if (!empty($values['overlay_button_text'])) {
                        $overlay_button_text = $values['overlay_button_text'];
                    }
                    if (!empty($values['overlay_button_text_color'])) {
                        $overlay_button_text_color = $values['overlay_button_text_color'];
                    }
                    if (!empty($values['overlay_button_bg_color'])) {
                        $overlay_button_bg_color = $values['overlay_button_bg_color'];
                    }
                }
                $overlay = get_idea_hover_overlay_action( $overlay_text_color,$overlay_title, $overlay_subtitle,$show_overlay_divider['above'],$show_overlay_divider['below'], $overlay_border_color, $overlay_button_text, $overlay_button_text_color, $overlay_button_bg_color);
            }

            if($overlay != ''){
                $over_class = 'isotope-hover-only';
                $overlay_div = '<div class="default-overlay"></div>';
            }

            /*on hover image effect*/
            if (isset($values['onhover_image_effect']) && $values['onhover_image_effect'] != '') {
                if (!empty($values['image_hover_effect'])) {
                    $image_effect = get_idea_hover_image_effect($values['image_hover_effect']);
                }
            }

            $color = $display_class = $background = '';

            $idea = get_post($values['idea_post'] );
            $termsArray = get_the_terms($values['idea_post'],'cc_idea_cat');
            $termsString = "";
            if(!empty($termsArray)){
                foreach ( $termsArray as $term ) {
                    $termsString .= $term->slug.' ';

                }
            }

            $fbk_img = '';
            $crop_size = '';
            if(!empty($values['content_display_style'])){
             if('isotope-horizontal'== $values['content_display_style']){
                 $display_class = 'isotope-1xh isotope-2xw ';
                 $fbk_img = get_template_directory_uri().'/assets/images/horizontal-rect.png';
                 $crop_size = 'idea_horizontal';
             }
             elseif('isotope-vertical'== $values['content_display_style']){
                $display_class = 'isotope-2xh isotope-1xw ';
                $fbk_img = get_template_directory_uri().'/assets/images/verticle-rect.png';
                $crop_size = 'idea_vertical';
            }
            elseif('isotope-big'== $values['content_display_style']){
                $display_class = 'isotope-2xh isotope-2xw ';
                $fbk_img = get_template_directory_uri().'/assets/images/large.png';
                $crop_size = 'idea_large';
            }
            else{
                $display_class = 'isotope-1xh isotope-1xw';
                $fbk_img = get_template_directory_uri().'/assets/images/small.png';
                $crop_size = 'idea_small';
            }
        }
        else{
            $display_class = 'isotope-1xh isotope-1xw';
            $fbk_img = get_template_directory_uri().'/assets/images/small.png';
            $crop_size = 'idea_small';
        }

        if(!empty($values['use_background'])){
            if(!empty($values['background_color'])){
                $color= $values['background_color'];
                $background = 'isotope-background';
            }
        }
        $style_tag = '';
        if( !empty( $values['use_color_overlay'] ) ) {
            if( !empty( $values['use_overlay_color'] ) ) {
                $overlay_backgroud_color = $values['use_overlay_color'];
                $style_tag = 'style="background-color:'.$overlay_backgroud_color.'"';
            } else {
                $style_tag = '';
            }
        }
        ?>
        <div class="<?php echo $termsString; ?> isotope-item <?php echo $display_class.' '.$background.' '.$image_effect.' '. $over_class;?>" style="background-color: <?php echo $color;?>">
            <?php echo $wrapper['start'];?>
            <?php if(empty($values['use_background'])){?>
            <?php echo get_the_post_thumbnail($values['idea_post'],$crop_size);?>
            <?php }else { ?>
            <img src="<?php echo $fbk_img; ?>">
            <?php } ?>
            <?php echo $overlay_div;?>
            <div class="isotop-content" data-backgroundcolor-hover="<?php echo $overlay_color;?>">
                <div class="isocontent-wrap isocontent-wrap-default" <?php echo $style_tag; ?>>
                    <div class="isocontent-span">
                        <?php if(!empty($values['show_title'])):?>
                            <span class="idea-title">
                                <i class="isotope-seperator seperator-top"></i>
                                <?php echo $idea->post_title; ?>
                                <i class="isotope-seperator seperator-bottom"></i>
                            </span>
                        <?php endif;?>
                        <?php if(!empty($values['show_excerpt'])):?>
                            <span class="idea-excerpt"><?php echo $idea->post_excerpt; ?></span>
                        <?php endif;?>
                    </div>
                </div>
                <div class="idea-hover-overlay">
                    <?php echo $overlay; ?>
                </div>
            </div>
            <?php echo $wrapper['end'];?>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
    add_shortcode('cc_gal_cat_element','cc_gal_cat_element');
    function cc_gal_cat_element($atts){

        $values = shortcode_atts( array(
            'idea_post_category'  =>  '',
            'idea_post_category_limit'  =>  '',
            'show_title'  =>  '',
            'show_excerpt'  =>  '',
            'use_background'  =>  '',
            'background_color'  =>  '',
            'content_display_style'  =>  '',
            'onclick_action'  =>  '',
            'page_in_popup'  =>  '',
            'link_to_page'  =>  '',
            'large_image'  =>  '',
            'onhover_overlay_action' => '',
            'hover_overlay_color' => '',
            'hover_overlay_text_color' => '',
            'hover_overlay_title' => '',
            'hover_overlay_subtitle' => '',
            'enable_overlay_divider' => '',
            'show_overlay_divider' => '',
            'overlay_divider_color' => '',
            'overlay_border' => '',
            'overlay_border_color' => '',
            'overlay_button' => '',
            'overlay_button_text' => '',
            'overlay_button_text_color' => '',
            'overlay_button_bg_color' => '',
            'onhover_image_effect' => '',
            'image_hover_effect' => '',
            ), $atts );

        ob_start();

        $wrapper = array();
        $image_effect = '';
        $over_class = $overlay_div = '';
        $overlay = $overlay_color = $overlay_text_color = $overlay_title = $overlay_subtitle = $overlay_border_color = $overlay_button_text = $overlay_button_text_color = $overlay_button_bg_color = '';
        $show_overlay_divider['above'] = '';
        $show_overlay_divider['below'] = '';
        $wrapper['start'] =  $wrapper['end'] = '';

        /*on click*/
        if (isset($values['onclick_action'])) {
            if (isset($values['page_in_popup']) && $values['page_in_popup'] != '') {
                $wrapper = get_idea_click_action($values['onclick_action'], $values['page_in_popup']);
            } elseif (isset($values['link_to_page']) && $values['link_to_page'] != '') {
                $link_page = vc_build_link($values['link_to_page']);
                $wrapper = get_idea_click_action($values['onclick_action'], '', $link_page);
            }  elseif (isset($values['large_image']) && $values['large_image'] != '') {
                $wrapper = get_idea_click_action($values['onclick_action'],'','',$values['large_image']);
            }
        }


        /*on hover overlay*/
        if (isset($values['onhover_overlay_action']) && $values['onhover_overlay_action'] != '') {

            /*hover overlay divider options*/
            if( isset($values['enable_overlay_divider']) && 'yes'== $values['enable_overlay_divider'] ){
                $overlay_divider = explode(',',$values['show_overlay_divider']);
                if(in_array('above',$overlay_divider)){
                    $show_overlay_divider['above']='<i class="isotope-seperator seperator-top" style="background-color: '.$values['overlay_divider_color'].'"></i>';
                }
                if(in_array('below',$overlay_divider)){
                    $show_overlay_divider['below']='<i class="isotope-seperator seperator-bottom" style="background-color: '.$values['overlay_divider_color'].'"></i>';
                }
            }

            if (!empty($values['hover_overlay_color'])) {
                $overlay_color = $values['hover_overlay_color'];
            }
            if (!empty($values['hover_overlay_text_color'])) {
                $overlay_text_color = $values['hover_overlay_text_color'];
            }
            if (!empty($values['hover_overlay_title'])) {
                $overlay_title = $values['hover_overlay_title'];
            }
            if (!empty($values['hover_overlay_subtitle'])) {
                $overlay_subtitle = $values['hover_overlay_subtitle'];
            }
            if ('yes' == $values['overlay_border']) {
                if (!empty($values['overlay_border_color'])) {
                    $overlay_border_color = $values['overlay_border_color'];
                }
            }
            if ('yes' == $values['overlay_button']) {
                if (!empty($values['overlay_button_text'])) {
                    $overlay_button_text = $values['overlay_button_text'];
                }
                if (!empty($values['overlay_button_text_color'])) {
                    $overlay_button_text_color = $values['overlay_button_text_color'];
                }
                if (!empty($values['overlay_button_bg_color'])) {
                    $overlay_button_bg_color = $values['overlay_button_bg_color'];
                }
            }
            $overlay = get_idea_hover_overlay_action( $overlay_text_color,$overlay_title, $overlay_subtitle,$show_overlay_divider['above'],$show_overlay_divider['below'], $overlay_border_color, $overlay_button_text, $overlay_button_text_color, $overlay_button_bg_color);
        }

        if($overlay != ''){
            $over_class = 'isotope-hover-only';
            $overlay_div = '<div class="default-overlay"></div>';
        }

        /*on hover image effect*/
        if (isset($values['onhover_image_effect']) && $values['onhover_image_effect'] != '') {
            if (!empty($values['image_hover_effect'])) {
                $image_effect = get_idea_hover_image_effect($values['image_hover_effect']);
            }
        }

        $color = $display_class = $background = '';

    // $idea = get_post($values['idea_post'] );
        $termsArray = get_term( $values['idea_post_category'], 'cc_idea_cat' );
    // $termsArray = get_the_terms($values['idea_post'],'cc_idea_cat');
        $termsString = $termsArray->slug;

        $fbk_img = '';
        $crop_size = '';

        if(!empty($values['content_display_style'])){
         if('isotope-horizontal'== $values['content_display_style']){
             $display_class = 'isotope-1xh isotope-2xw ';
             $fbk_img = get_template_directory_uri().'/assets/images/horizontal-rect.png';
             $crop_size = 'idea_horizontal';
         }
         elseif('isotope-vertical'== $values['content_display_style']){
            $display_class = 'isotope-2xh isotope-1xw ';
            $fbk_img = get_template_directory_uri().'/assets/images/verticle-rect.png';
            $crop_size = 'idea_vertical';
        }
        elseif('isotope-big'== $values['content_display_style']){
            $display_class = 'isotope-2xh isotope-2xw ';
            $fbk_img = get_template_directory_uri().'/assets/images/large.png';
            $crop_size = 'idea_large';
        }
        else{
            $display_class = 'isotope-1xh isotope-1xw';
            $fbk_img = get_template_directory_uri().'/assets/images/small.png';
            $crop_size = 'idea_small';
        }
    }
    else{
        $display_class = 'isotope-1xh isotope-1xw';
        $fbk_img = get_template_directory_uri().'/assets/images/small.png';
        $crop_size = 'idea_small';
    }

    if(!empty($values['use_background'])){
        if(!empty($values['background_color'])){
            $color= $values['background_color'];
            $background = 'isotope-background';
        }
    }
    $idea_gallery_by_category_query = new WP_Query(
        array(
            'post_type' => 'cc_ideas',
            'posts_per_page' => $values['idea_post_category_limit'],
            'tax_query' => array(
                array(
                    'taxonomy' => 'cc_idea_cat', 'field' =>
                    'term_id',
                    'terms' =>
                    $values['idea_post_category']
                    )
                )

            )
        );
    while( $idea_gallery_by_category_query->have_posts() ) :
        $idea_gallery_by_category_query->the_post();
    ?>

    <div class="<?php echo $termsString; ?> isotope-item here <?php echo $display_class.' '.$background.' '.$image_effect.' '. $over_class;?>" style="background-color: <?php echo $color;?>">
        <?php echo $wrapper['start'];?>
        <?php if(empty($values['use_background'])){?>
        <?php echo get_the_post_thumbnail($values['idea_post'],$crop_size);?>
        <?php }else { ?>
        <img src="<?php echo $fbk_img; ?>">
        <?php } ?>
        <?php echo $overlay_div;?>
        <div class="isotop-content" data-backgroundcolor-hover="<?php echo $overlay_color;?>">
            <div class="isocontent-wrap isocontent-wrap-default">
                <div class="isocontent-span">
                    <?php if(!empty($values['show_title'])):?>
                        <span class="idea-title">
                            <i class="isotope-seperator seperator-top"></i>
                            <?php echo get_the_title(); ?>
                            <i class="isotope-seperator seperator-bottom"></i>
                        </span>
                    <?php endif;?>
                    <?php if(!empty($values['show_excerpt'])):?>
                        <span class="idea-excerpt"><?php echo get_the_excerpt(); ?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="idea-hover-overlay">
                <?php echo $overlay; ?>
            </div>
        </div>
        <?php echo $wrapper['end'];?>
    </div>
    <?php
    endwhile; wp_reset_postdata();
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}



add_shortcode('cc_masonary_gal_single_element','cc_masonary_gal_single_element');
function cc_masonary_gal_single_element($atts){

   $values = shortcode_atts( array(
    'image'  =>  '',
    'img_title' => '',
    'show_title'  =>  '',
    'show_sub_title'  =>  '',
    'sub_title' => '',
    'enable_divider'    => '',
    'show_divider'  => '',
    'divider_color' => '',
    'use_background'  =>  '',
    'background_color'  =>  '',
    'content_display_style'  =>  '',
    'onclick_action'  =>  '',
    'link_to_page'  =>  '',
    'large_image'  =>  '',
    'link_to_tags'  =>  '',
    'onhover_overlay_action' => '',
    'hover_overlay_color' => '',
    'hover_overlay_text_color' => '',
    'hover_overlay_title' => '',
    'hover_overlay_subtitle' => '',
    'enable_overlay_divider' => '',
    'show_overlay_divider' => '',
    'overlay_divider_color' => '',
    'overlay_border' => '',
    'overlay_border_color' => '',
    'overlay_button' => '',
    'overlay_button_text' => '',
    'overlay_button_text_color' => '',
    'overlay_button_bg_color' => '',
    'onhover_image_effect' => '',
    'image_hover_effect' => '',
    'use_color_overlay' => '',
    'use_text_color' => '',
    'enable_rollover' => '',
    'show_video'  =>  '',
    'product_tags_link' => '',
    'video_link'  =>  '',
    'enable_zoom_in'    => '',
    ), $atts );

   ob_start();

   $wrapper = array();
   $image_effect = '';
   $over_class = $overlay_div = '';
   $overlay = $overlay_color = $overlay_text_color = $overlay_title = $overlay_subtitle = $overlay_border_color = $overlay_button_text = $overlay_button_text_color = $overlay_button_bg_color = '';
   $show_overlay_divider['above'] = '';
   $show_overlay_divider['below'] = '';
   $wrapper['start'] =  $wrapper['end'] = '';


   /*on click*/
   if (isset($values['onclick_action'])) {
     if (isset($values['link_to_page']) && $values['link_to_page'] != '') {
        $link_page = vc_build_link($values['link_to_page']);
        $wrapper = get_idea_click_action($values['onclick_action'], '', $link_page);
    }  elseif (isset($values['large_image']) && $values['large_image'] != '') {
        $wrapper = get_idea_click_action($values['onclick_action'],'','',$values['large_image']);
    } elseif (isset($values['video_link']) && $values['video_link'] != '') {
        $wrapper = get_idea_click_action($values['onclick_action'],'','',$values['video_link']);
    } elseif ( isset( $values['product_tags_link'] ) && !empty( $values['product_tags_link'] ) ) {
        $wrapper = get_idea_click_action($values['onclick_action'],'','',$values['product_tags_link']);
    }
}

/*divider options*/
$show_divider['above'] = '';
$show_divider['below'] = '';
if( isset($values['enable_divider']) && 'yes'== $values['enable_divider'] ){
    $divider = explode(',',$values['show_divider']);
    if(in_array('above',$divider)){
        $color_divider = ( !empty( $values['divider_color'] ) ) ? $values['divider_color'] : '#fff';
        $show_divider['above']='<i class="line line-top" style="background-color: '.$color_divider.'"></i>';
    }
    if(in_array('below',$divider)){
        $color_divider = ( !empty( $values['divider_color'] ) ) ? $values['divider_color'] : '#fff';
        $show_divider['below']='<i class="line line-bottom" style="background-color: '.$color_divider.'"></i>';
    }
}


/*on hover overlay*/
if (isset($values['onhover_overlay_action']) && $values['onhover_overlay_action'] != '') {

    /*hover overlay divider options*/
    if( isset($values['enable_overlay_divider']) && 'yes'== $values['enable_overlay_divider'] ){
        $overlay_divider = explode(',',$values['show_overlay_divider']);
        if(in_array('above',$overlay_divider)){
            $show_overlay_divider['above']='<i class="isotope-seperator seperator-top" style="background-color: '.$values['overlay_divider_color'].'"></i>';
        }
        if(in_array('below',$overlay_divider)){
            $show_overlay_divider['below']='<i class="isotope-seperator seperator-bottom" style="background-color: '.$values['overlay_divider_color'].'"></i>';
        }
    }

    if (!empty($values['hover_overlay_color'])) {
        $overlay_color = $values['hover_overlay_color'];
    }
    if (!empty($values['hover_overlay_text_color'])) {
        $overlay_text_color = $values['hover_overlay_text_color'];
    }
    if (!empty($values['hover_overlay_title'])) {
        $overlay_title = $values['hover_overlay_title'];
    }
    if (!empty($values['hover_overlay_subtitle'])) {
        $overlay_subtitle = $values['hover_overlay_subtitle'];
    }
    if ('yes' == $values['overlay_border']) {
        if (!empty($values['overlay_border_color'])) {
            $overlay_border_color = $values['overlay_border_color'];
        }
    }
    if ('yes' == $values['overlay_button']) {
        if (!empty($values['overlay_button_text'])) {
            $overlay_button_text = $values['overlay_button_text'];
        }
        if (!empty($values['overlay_button_text_color'])) {
            $overlay_button_text_color = $values['overlay_button_text_color'];
        }
        if (!empty($values['overlay_button_bg_color'])) {
            $overlay_button_bg_color = $values['overlay_button_bg_color'];
        }
    }
    $overlay = get_idea_hover_overlay_action( $overlay_text_color,$overlay_title, $overlay_subtitle,$show_overlay_divider['above'],$show_overlay_divider['below'], $overlay_border_color, $overlay_button_text, $overlay_button_text_color, $overlay_button_bg_color);
}

if($overlay != ''){
    $over_class = 'isotope-hover-only';
    $overlay_div = '<div class="default-overlay"></div>';
}

/*on hover image effect*/
if (isset($values['onhover_image_effect']) && $values['onhover_image_effect'] != '') {
    if (!empty($values['image_hover_effect'])) {
        $image_effect = get_idea_hover_image_effect($values['image_hover_effect']);
    }
}

$color = $display_class = $background = '';


$crop_size = '';
$crop_width = '';
$crop_height = '';

if(!empty($values['content_display_style'])){
 if( 'isotope-horizontal'== $values['content_display_style'] ) {
       // $display_class = 'isotope-1xh isotope-2xw ';
    $display_class = 'isotope-6xw ';
    $crop_size = 'masonry_horizontal';
    $crop_width = '951px';
    $crop_height = '315px';
} elseif ('isotope-vertical'== $values['content_display_style'] ) {
    // $display_class = 'isotope-2xh isotope-1xw ';
    $display_class = 'isotope-4xw ';
    $crop_size = 'masonry_large';
    $crop_width = '951px';
    $crop_height = '630px';
} elseif ('isotope-big'== $values['content_display_style']) {
    // $display_class = 'isotope-2xh isotope-2xw ';
    $display_class = 'isotope-8xw ';
    $crop_size = 'masonry_large';
    $crop_width = '951px';
    $crop_height = '630px';
}
else {
    // $display_class = 'isotope-1xh isotope-1xw';
    $display_class = 'isotope-4xw';
    $crop_size = 'masonry_small';
    $crop_width = '476px';
    $crop_height = '315px';
}
} else{
    // $display_class = 'isotope-1xh isotope-1xw';
    $display_class = 'isotope-4xw';
    $crop_size = 'masonry_small';
    $crop_width = '476px';
    $crop_height = '315px';
}



/*Enable Rollover*/
$style_tag = '';

/*Title color*/
if( !empty( $values['use_color_overlay'] ) ) {
    if( !empty( $values['use_text_color'] ) ) {
        $overlay_backgroud_color = $values['use_text_color'];
        $style_tag = 'style="color:'.$overlay_backgroud_color.'"';
    } else {
        $style_tag = '';
    }
}

$masonry_class = '';
if ( $values['enable_rollover'] == true ) {
    $masonry_class = 'rollover-title';
    /*Rollover Background*/
    if(!empty($values['use_background'])){
        if(!empty($values['background_color'])){
            $color= $values['background_color'];
            $background = 'isotope-background';
        }
    }
}else{
    $masonry_class = 'overlay-title';
}

/*Enable Zoom In*/
$zoom_in_class = '';
if ( $values['enable_zoom_in'] == true) {
    $zoom_in_class = 'masonry_gallery_zoom';
}


if ( $values['onclick_action'] == 'show_video' && !empty( $values['video_link'] ) ) { ?>

<div class="isotope-item masonary-item <?php echo $zoom_in_class; ?> <?php echo $masonry_class; ?> <?php echo $display_class;?>" >
    <?php

    $explode_url = explode("https://carpetcourt.wistia.com/medias/", $values['video_link'] );

    if ( !empty( $explode_url[1] ) ) { ?>

    <a class="cc-fancy-box" href="#<?php echo $explode_url[1]; ?>" data-videoid="<?php echo $explode_url[1]; ?>">
        <?php
    } else { ?>
    <a href="<?php echo $values['video_link']; ?>" rel="prettyPhoto">
        <?php
    }
    $image = wp_get_attachment_image_src( $values['image'], $crop_size );
    // echo wp_get_attachment_image( $values['image'], $crop_size );
    ?>

    <img src="<?php echo esc_url($image[0]); ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>">

    <div class="bg-img" style="background:url('<?php echo $image[0]; ?>')"></div>

    <?php echo $overlay_div; ?>

    <div class="content" style="background: <?php echo $color;?>">
        <div class="vert-wrap">
            <div class="vert-middle">
                <?php if( !empty( $values['show_title']) ):

                echo $show_divider['above']; ?>

                <h3 <?php echo $style_tag; ?>><?php echo $values['img_title']; ?></h3>
                <?php
                echo $show_divider['below'];

                if ( $values['show_sub_title'] ) {

                    if ( !empty( $values['sub_title'] ) ) { ?>
                    <div class="masonry-sub"><?php echo $values['sub_title']; ?></div>
                    <?php }
                }
                ?>

            <?php endif;?>
        </div>
    </div>
</div>
</a>
</div>
<?php
} else {
    ?>
    <div class="isotope-item masonary-item <?php echo $zoom_in_class; ?> <?php echo $masonry_class; ?> <?php echo $display_class;?>" >
        <?php echo $wrapper['start'];?>
        <?php
        $image = wp_get_attachment_image_src( $values['image'], $crop_size );
        // echo wp_get_attachment_image( $values['image'], $crop_size );
        ?>

        <img src="<?php echo esc_url($image[0]); ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>">

        <div class="bg-img" style="background:url('<?php echo $image[0]; ?>')"></div>

        <?php echo $overlay_div; ?>

        <div class="content" style="background: <?php echo $color;?>">
            <div class="vert-wrap">
                <div class="vert-middle">
                    <?php if( !empty( $values['show_title']) ):

                    echo $show_divider['above']; ?>

                    <h3 <?php echo $style_tag; ?>><?php echo $values['img_title']; ?></h3>
                    <?php
                    echo $show_divider['below'];

                    if ( $values['show_sub_title'] == true ) {

                        if ( !empty( $values['sub_title'] ) ) { ?>
                        <div class="masonry-sub"><?php echo $values['sub_title']; ?></div>
                        <?php }
                    }
                    ?>

                <?php endif;?>
            </div>
        </div>
    </div>

    <?php echo $wrapper['end'];?>
</div>
<?php
}
$output = ob_get_contents();
ob_end_clean();
return $output;

}

//onclick action
function get_idea_click_action($action, $popup_page = '', $url_link = '',$large_image='') {
    $div_wrapper = array();
    switch ($action) {
        case "page_in_popup":
        if (!empty($popup_page)):
            $div_wrapper['start'] = '<a href="'.get_permalink($popup_page).'?iframe=true&width=100%&height=100%" rel="prettyPhoto">';
        $div_wrapper['end'] = '</a>';
        endif;
        break;
        case "link_to_page":
        if (!empty($url_link)):
            $div_wrapper['start'] = '<a href="' . $url_link['url'] . '" target="' . $url_link['target'] . '" title="' . $url_link['title'] . '">';
        $div_wrapper['end'] = '</a>';
        endif;
        break;
        case "large_image":
        if (!empty($large_image)):
            $image = wp_get_attachment_image_src($large_image, 'full');
        $div_wrapper['start'] = '<a href="' . $image[0] . '" rel="prettyPhoto">';
        $div_wrapper['end'] = '</a>';
        endif;
        break;
        case "link_to_tags":
        $form_id = "'"."cc-cat-form-specials-".$large_image."'";
        $div_wrapper['start'] = '<form id="cc-cat-form-specials-'.$large_image.'" action="'.esc_url(home_url()).'/product-filter/" method="POST"><input name="product_tag[]" value="'.$large_image.'" type="hidden"><a href="javascript:void(0)" onclick="document.getElementById('.$form_id.').submit(); return false;">';
        $div_wrapper['end'] = '</a></form>';
        break;
        default:
        $div_wrapper['start'] = '<div>';
        $div_wrapper['end'] = '</div>';
        break;
    }
    return $div_wrapper;
}


//on hover overlay action
function get_idea_hover_overlay_action($overlay_text_color = '', $overlay_title = '', $overlay_subtitle = '', $above = '',$below = '',$overlay_border_color = '', $overlay_button_text = '', $overlay_button_text_color = '', $overlay_button_bg_color = '') {
    $output = '';
    $output .= '<div class="isocontent-wrap" style="color: '.$overlay_text_color.'"> <div class="isocontent-span">';
    if(!empty($overlay_title)){
        $output .= '<span class="idea-title">'.$above.$overlay_title.$below.'</span>';
    }
    if(!empty($overlay_subtitle)){
        $output .= '<span class="hover-subtext clearfix">'.$overlay_subtitle.'</span>';
    }
    if(!empty($overlay_button_text)){
        $output .= '<button class="cc-btn" style="color: '.$overlay_button_text_color.'; background-color: '.$overlay_button_bg_color.'">'.$overlay_button_text.'</button>';
    }
    $output .= '</div></div>';
    return $output;
}

//on hover image effect
function get_idea_hover_image_effect($image_effect){
    $img_effect_class = '';
    switch ($image_effect) {
        case "zoom_image":
        $img_effect_class = 'cc-gallery-zoom';
        break;
        case "grayscale_image":
        $img_effect_class = 'grayscale';
        break;
        default:
        $img_effect_class = '';
        break;
    }
    return $img_effect_class;
}


add_action( 'wp_ajax_show_popup_video', 'cc_show_popup_video' );
add_action( 'wp_ajax_nopriv_show_popup_video', 'cc_show_popup_video' );
function cc_show_popup_video() {
    $video_id = $_POST['video_id'];

    ob_start();
    ?>

    <div class="vid-pop-up">
        <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
        <div class="wistia_responsive_padding" style="padding:56.25% 0 28px 0;position:relative;">
            <div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;">
                <div class="wistia_embed wistia_async_<?php echo $video_id; ?> videoFoam=true" style="height:100%;width:100%">&nbsp;</div>
            </div>
        </div>
    </div>
    <?php
    $content = ob_get_clean();
    echo $content;
    die();
}
