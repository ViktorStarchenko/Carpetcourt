<?php
add_action( 'vc_before_init', 'cc_product_cat_gallery_integrateWithVC' );
function cc_product_cat_gallery_integrateWithVC(){

    //display categories of products
    function cc_display_product_cat() {
        $all_terms = array();
        $terms = get_terms( 'product_cat', array(
            'hide_empty' => 0,
        ) );

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $all_terms[htmlspecialchars_decode($term->name)] = $term->term_id;
            }
        }
        return $all_terms;
    }
    //display floor attribute of products
    function cc_display_floor_life_cat() {
        $all_terms = array();
        $terms = get_terms( 'pa_floor', array(
            'hide_empty' => 0,
        ) );

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $all_terms[htmlspecialchars_decode($term->name)] = $term->term_id;
            }
        }
        return $all_terms;
    }
    //display style attribute of products
    function cc_display_style_life_cat() {
        $all_terms = array();
        $terms = get_terms( 'pa_style', array(
            'hide_empty' => 0,
        ) );

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $all_terms[htmlspecialchars_decode($term->name)] = $term->term_id;
            }
        }
        return $all_terms;
    }
    //display color attribute of products
    function cc_display_color_life_cat() {
        $all_terms = array();
        $terms = get_terms( 'pa_color', array(
            'hide_empty' => 0,
        ) );

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $all_terms[htmlspecialchars_decode($term->name)] = $term->term_id;
            }
        }
        return $all_terms;
    }

    vc_map( array(
        "name"                    => __("Product Category Image Gallery ", "carpet-court"),
        "base"                    => "cc_product_cat_gallery",
        "description"             => __("Display product category gallery.","carpet-court"),
        "category"                => __('Content', 'carpet-court'),
        "params"                  => array(
            array(
                'type' => 'dropdown',
                'heading' => __( 'Select Product attribute', 'carpet-court' ),
                'param_name' => 'select_attribute',
                'value' => array(
                    __( 'None', 'carpet-court' ) => '',
                    __( 'Type', 'carpet-court' ) => 'product_cat',
                    __( 'Floor Life', 'carpet-court' ) => 'pa_floor',
                    __( 'Style Life', 'carpet-court' ) => 'pa_style',
                    __( 'Color Life', 'carpet-court' ) => 'pa_color',
                ),
                'description' => __( 'Select attribute to display their categories', 'carpet-court' ),
            ),
            array(
                "type"        => "dropdown",
                "heading"     => __("Choose Type", "carpet-court"),
                "param_name"  => "product_cat",
                'dependency' => array(
                    'element' => 'select_attribute',
                    'value' => array( 'product_cat'),
                ),
                'value' => cc_display_product_cat(),
            ),
            array(
                "type"        => "dropdown",
                "heading"     => __("Choose Floor Life", "carpet-court"),
                "param_name"  => "pa_floor",
                'dependency' => array(
                    'element' => 'select_attribute',
                    'value' => array( 'pa_floor'),
                ),
                'value' => cc_display_floor_life_cat(),
            ),
            array(
                "type"        => "dropdown",
                "heading"     => __("Choose Style Life", "carpet-court"),
                "param_name"  => "pa_style",
                'dependency' => array(
                    'element' => 'select_attribute',
                    'value' => array( 'pa_style'),
                ),
                'value' => cc_display_style_life_cat(),
            ),
            array(
                "type"        => "dropdown",
                "heading"     => __("Choose Color Life", "carpet-court"),
                "param_name"  => "pa_color",
                'dependency' => array(
                    'element' => 'select_attribute',
                    'value' => array( 'pa_color'),
                ),
                'value' => cc_display_color_life_cat(),
            ),
            array(
                "type" => "colorpicker",
                "heading" => __("Text color", "carpet-court"),
                "param_name" => "text_color",
            ),
            array(
                "type" => "checkbox",
                "heading" => __("Enable Overlay", "carpet-court"),
                "param_name" => "enable_overlay",
            ),
            array(
                "type" => "colorpicker",
                "heading" => __("Overlay color", "carpet-court"),
                "param_name" => "overlay_color",
                'dependency' => array(
                    'element' => 'enable_overlay',
                    'value' => array('true'),
                ),
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
        ),
    ) );
}
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_cc_product_cat_gallery extends WPBakeryShortCode {

        protected function content( $atts, $content = null ) {
            $values = shortcode_atts( array(
                'select_attribute'  =>  '',
                'product_cat'  =>  '',
                'pa_floor'  =>  '',
                'pa_style'  =>  '',
                'pa_color'  =>  '',
                'text_color'  =>  '',
                'enable_overlay'  =>  '',
                'overlay_color'  =>  '',
                'enable_divider' => '',
                'show_divider' => '',
                'divider_color' => '',
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
            ), $atts ) ;

            ob_start();

            /*separate categories in new array*/
            $categories = array();
            $class = '';
            $image_effect = '';
            $show_default_overlay = $default_overlay_color = '';
            $overlay = $overlay_color = $overlay_text_color = $overlay_title = $overlay_subtitle = $overlay_border_color = $overlay_button_text = $overlay_button_text_color = $overlay_button_bg_color = '';

            $show_divider['above'] = '';
            $show_divider['below'] = '';

            $show_overlay_divider['above'] = '';
            $show_overlay_divider['below'] = '';

            $categories['product_cat'] = $values['product_cat'];
            $categories['pa_floor'] = $values['pa_floor'];
            $categories['pa_style'] = $values['pa_style'];
            $categories['pa_color'] = $values['pa_color'];

            if(!empty($categories)){
                foreach($categories as $taxonomy => $term_id ){

                    if(!empty($term_id)){

                        /*default image overlay*/
                        if( isset($values['enable_overlay']) && 'true' == $values['enable_overlay'] ){
                            $show_default_overlay = true;
                            if(!empty($values['overlay_color'])){
                                $default_overlay_color = $values['overlay_color'];
                            }
                        }

                        /*divider options*/
                        if( isset($values['enable_divider']) && 'yes'== $values['enable_divider'] ){
                            $divider = explode(',',$values['show_divider']);
                            if(in_array('above',$divider)){
                                $show_divider['above']='<i class="line top" style="background-color: '.$values['divider_color'].'"></i>';
                            }
                            if(in_array('below',$divider)){
                                $show_divider['below']='<i class="line bottom" style="background-color: '.$values['divider_color'].'"></i>';
                            }
                        }

                        /*on hover overlay*/
                        if (isset($values['onhover_overlay_action']) && $values['onhover_overlay_action'] != '') {

                            /*hover overlay divider options*/
                            if( isset($values['enable_overlay_divider']) && 'yes'== $values['enable_overlay_divider'] ){
                                $overlay_divider = explode(',',$values['show_overlay_divider']);
                                if(in_array('above',$overlay_divider)){
                                    $show_overlay_divider['above']='<i class="line top" style="background-color: '.$values['overlay_divider_color'].'"></i>';
                                }
                                if(in_array('below',$overlay_divider)){
                                    $show_overlay_divider['below']='<i class="line bottom" style="background-color: '.$values['overlay_divider_color'].'"></i>';
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
                            $overlay = $this->get_cc_hover_overlay_action( $overlay_text_color,$overlay_title, $overlay_subtitle,$show_overlay_divider['above'],$show_overlay_divider['below'], $overlay_border_color, $overlay_button_text, $overlay_button_text_color, $overlay_button_bg_color);
                        }
                        /*on hover overlay close*/

                        /*on hover image effect*/
                        if (isset($values['onhover_image_effect']) && $values['onhover_image_effect'] != '') {
                            if (!empty($values['image_hover_effect'])) {
                                $image_effect = $this->get_cc_hover_image_effect($values['image_hover_effect']);
                            }
                        }
                        /*on hover image close*/

                        if($overlay != ''){
                            $class = 'cc-hover-only';
                        }

                        $category = get_category($term_id);
                        ?>
                        <div class="cc-gallery <?php echo $class;?>">
                            <form id="cc-cat-form-<?php echo $term_id;?>" action="<?php echo home_url('/');?>product-filter/" method="POST">
                            <input type="hidden" name="<?php echo $taxonomy;?>[]" value="<?php echo $term_id;?>">
                            <a href="javascript:void(0)" onclick="document.getElementById('cc-cat-form-<?php echo $term_id;?>').submit(); return false;">
                                <div class="cc-gallery-img <?php echo $image_effect;?>">
                                    <?php
                                    $cat_image = absint( get_term_meta($term_id, 'thumbnail_id', true ) );
                                    if( !$cat_image ){
                                        $cat_image = absint( get_woocommerce_term_meta($term_id, 'thumbnail_id', true ) );
                                    }
                                    if ( $cat_image ) {
                                        $image = wp_get_attachment_image_src( $cat_image,'cc_gal_image' );
                                    } else {
                                        $image[0] = wc_placeholder_img_src();
                                    }
                                    ?>
                                    <img src="<?php echo esc_url( $image[0] );?>"/>
                                    <?php if(true == $show_default_overlay){
                                        echo '<div class="default-overlay" style="background-color:'.$default_overlay_color.'"></div>';
                                    }?>
                                    <figure class="figure-cross" data-backgroundcolor-hover="<?php echo $overlay_color;?>">
                                        <div class="cc-gallery-title">
                                            <span class="span-cross" style="color: <?php echo $values['text_color']; ?>">
                                                <?php
                                                    echo $show_divider['above'];
                                                        echo $category->name;
                                                    echo $show_divider['below'];
                                                ?>
                                            </span>
                                        </div>
                                        <?php echo $overlay; ?>
                                    </figure>
                                </div>
                            </a>
                            </form>
                        </div>
                    <?php
                    }
                }
            }
            $output = ob_get_clean();
            ob_flush();
            return $output;
        }

        /*on hover overlay action*/
        protected function get_cc_hover_overlay_action($overlay_text_color = '', $overlay_title = '', $overlay_subtitle = '',$above = '',$below = '', $overlay_border_color = '', $overlay_button_text = '', $overlay_button_text_color = '', $overlay_button_bg_color = '') {
            $output = '';
            $output .= '<span class="span-hover" style="color: '.$overlay_text_color.'">';
            if(!empty($overlay_title)){
                $output .= '<span class="hover-cross">'.$above.$overlay_title.$below.'</span>';
            }
            if(!empty($overlay_subtitle)){
                $output .= '<span class="hover-subtext clearfix">'.$overlay_subtitle.'</span>';
            }
            if(!empty($overlay_button_text)){
                $output .= '<button class="cc-btn" style="color: '.$overlay_button_text_color.'; background-color: '.$overlay_button_bg_color.'">'.$overlay_button_text.'</button>';
            }
            $output .= '</span>';
            return $output;
        }

        /*on hover image effect*/
        protected function get_cc_hover_image_effect($image_effect){
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

    }
}