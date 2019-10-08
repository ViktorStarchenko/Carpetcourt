<?php
add_action('vc_before_init', 'cc_gallery_integrateWithVC');
function cc_gallery_integrateWithVC() {

    //fetch pages
    function cc_display_pages() {
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

    vc_map(array(
            "name" => __("CC Gallery", "carpet-court"),
            "base" => "cc_gallery",
            "description" => __("Display a section of gallery.", "carpet-court"),
            "category" => __('Content', 'carpet-court'),
            "params" => array(
                    array(
                            "type" => "dropdown",
                            "heading" => __("Image or background color?", "carpet-court"),
                            "param_name" => "image_or_color",
                            'value' => array(
                                    __('None', 'carpet-court') => 'none',
                                    __('Image', 'carpet-court') => 'image',
                                    __('Background Color', 'carpet-court') => 'background_color',
                            ),
                    ),
                    array(
                            "type" => "attach_image",
                            "heading" => __("Choose Image", "carpet-court"),
                            "param_name" => "image",
                            'dependency' => array(
                                    'element' => 'image_or_color',
                                    'value' => array('image'),
                            ),
                    ),
                    array(
                            "type" => "colorpicker",
                            "heading" => __("Background color", "carpet-court"),
                            "param_name" => "background_color",
                            'dependency' => array(
                                    'element' => 'image_or_color',
                                    'value' => array('background_color'),
                            ),
                    ),
                    array(
                            "type" => "textfield",
                            "holder" => "div",
                            "heading" => __("Title", "carpet-court"),
                            "param_name" => "title",
                    ),
                    array(
                            "type" => "colorpicker",
                            "heading" => __("Title color", "carpet-court"),
                            "param_name" => "title_color",
                    ),
                    array(
                        "type" => "checkbox",
                        "heading" => __("Enable Overlay", "carpet-court"),
                        "param_name" => "enable_overlay",
                        'dependency' => array(
                            'element' => 'image_or_color',
                            'value' => array('image'),
                        ),
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
                            'type' => 'dropdown',
                            'heading' => __('On Click action', 'carpet-court'),
                            'param_name' => 'onclick_action',
                            'value' => array(
                                    __('None', 'carpet-court') => '',
                                    __('Open Images in Lightbox', 'carpet-court') => 'image_lightbox',
                                    __('Open Page in pop up', 'carpet-court') => 'page_in_popup',
                                    __('Link another page', 'carpet-court') => 'link_to_page',
                                    __('Open video in Lightbox', 'carpet-court') => 'video_lightbox',
                            ),
                            'description' => __('Select action for click.', 'carpet-court'),
                    ),
                    array(
                            "type" => "attach_images",
                            "heading" => __("Choose images to show in Lightbox", "carpet-court"),
                            "param_name" => "image_lightbox",
                            'dependency' => array(
                                    'element' => 'onclick_action',
                                    'value' => array('image_lightbox'),
                            ),
                            'description' => __('Note: Only works if chosen "image". Doesn\'t work in background color.', 'carpet-court'),
                    ),
                    array(
                            "type" => "dropdown",
                            "heading" => __("Choose page To Show in Pop up", "carpet-court"),
                            "param_name" => "page_in_popup",
                            'dependency' => array(
                                    'element' => 'onclick_action',
                                    'value' => array('page_in_popup'),
                            ),
                            'value' => cc_display_pages(),
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
                            "type" => "textfield",
                            "heading" => __("Enter Video Url", "carpet-court"),
                            "param_name" => "video_url",
                            'dependency' => array(
                                    'element' => 'onclick_action',
                                    'value' => array('video_lightbox'),
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
                    array(
                            "type" => "textfield",
                            "heading" => __("Extra Class Name", "carpet-court"),
                            "param_name" => "cc_gallery_extra_class",
                    ),
            ),
    ));
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_cc_gallery extends WPBakeryShortCode {

        protected function content($atts, $content = null) {
            $values = shortcode_atts(array(
                    'image_or_color' => '',
                    'image' => '',
                    'background_color' => '',
                    'cc_gallery_cropped' => '',
                    'title' => '',
                    'title_color' => '',
                    'enable_overlay'  =>  '',
                    'overlay_color'  =>  '',
                    'enable_divider' => '',
                    'show_divider' => '',
                    'divider_color' => '',
                    'onclick_action' => '',
                    'image_lightbox' => '',
                    'page_in_popup' => '',
                    'link_to_page' => '',
                    'link_taxonomy' => '',
                    'video_url' => '',
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
                    'cc_gallery_extra_class' => '',
            ), $atts);

            ob_start();

            $wrapper = array();
            $overlay = $overlay_color = $overlay_text_color = $overlay_title = $overlay_subtitle = $overlay_border_color = $overlay_button_text = $overlay_button_text_color = $overlay_button_bg_color = '';

            $class = '';
            $image_effect = '';

            $show_default_overlay = $default_overlay_color = '';

            $show_divider['above'] = '';
            $show_divider['below'] = '';

            $show_overlay_divider['above'] = '';
            $show_overlay_divider['below'] = '';

            $wrapper['start'] = '';
            $wrapper['end'] = '';


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

            /*on click*/
            if (isset($values['onclick_action'])) {
                if (isset($values['page_in_popup']) && $values['page_in_popup'] != '') {
                    $wrapper = $this->get_cc_click_action($values['onclick_action'], $values['page_in_popup'], $values['link_taxonomy'], $values['title']);
                } elseif (isset($values['link_to_page']) && $values['link_to_page'] != '') {
                    $link_page = vc_build_link($values['link_to_page']);
                    $wrapper = $this->get_cc_click_action($values['onclick_action'], '', $link_page,'', '', $values['link_taxonomy'], $values['title']);
                } elseif (isset($values['video_url']) && $values['video_url'] != '') {
                    $wrapper = $this->get_cc_click_action($values['onclick_action'], '', $values['video_url'], $values['link_taxonomy'], $values['title']);
                } elseif (isset($values['image_lightbox']) && $values['image_lightbox'] != '') {
                    $wrapper = $this->get_cc_click_action($values['onclick_action'], '', '', $values['image_lightbox'], $values['image'], $values['link_taxonomy'], $values['title']);
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

            /*on hover image effect*/
            if (isset($values['onhover_image_effect']) && $values['onhover_image_effect'] != '') {
                if (!empty($values['image_hover_effect'])) {
                    $image_effect = $this->get_cc_hover_image_effect($values['image_hover_effect']);
                }
            }

            if($overlay != ''){
                $class = 'cc-hover-only';
            }

            if ( isset( $values['cc_gallery_cropped'] ) && !empty( $values['cc_gallery_cropped'] ) ) {
                $cropped_size = $values['cc_gallery_cropped'];
            } else {
                $cropped_size = 'cc_gal_image';
            }

            echo '<div class="cc-gallery '.$class.' '.$values["cc_gallery_extra_class"].' ">';
            echo $wrapper['start'];
            ?>
            <div class="cc-gallery-img <?php echo $image_effect;?>">
                <?php
                if (isset($values['image_lightbox']) && $values['image_lightbox'] != '') {
                    if ('image' == $values['image_or_color']):
                        $image = wp_get_attachment_image_src($values['image'], $cropped_size);
                        echo '<a href="' . $image[0] . '" rel="prettyPhoto[pp_gal_' . $values['image'] . ']">';
                        echo '<img src="' . esc_url($image[0]) . '" width="'.$image[1].'" height="'.$image[2].'"/>';
                        // echo wp_get_attachment_image( $values['image'], $cropped_size );
                        ?>
                        <figure class="figure-cross" data-backgroundcolor-hover="<?php echo $overlay_color;?>">
                            <div class="cc-gallery-title">
                                <span class="span-cross" style="color: <?php echo $values['title_color']; ?>">
                                    <?php
                                        echo $show_divider['above'];
                                            echo $values['title'];
                                        echo $show_divider['below'];
                                    ?>
                                </span>
                            </div>
                            <?php echo $overlay; ?>
                        </figure>
                        <?php
                        echo '</a>';
                    endif;
                    if (!empty($wrapper['gallery'])) {
                        foreach ($wrapper['gallery'] as $image) {
                            echo $image;
                        }
                    }
                } else {
                    if ('image' == $values['image_or_color']):
                        $image = wp_get_attachment_image_src($values['image'], $cropped_size);
                        echo '<img src="' . esc_url($image[0]) . '" width="'.$image[1].'" height="'.$image[2].'"/>';
                    // echo wp_get_attachment_image( $values['image'], $cropped_size );
                        if(true == $show_default_overlay):
                            echo '<div class="default-overlay" style="background-color:'.$default_overlay_color.'"></div>';
                        endif;
                    else:
                        echo '<img src="' . get_template_directory_uri() . '/assets/images/no-image.png"/>';
                        echo '<div class="bgcolor-fill clearfix" style="background-color:' . $values['background_color'] . '"></div>';
                    endif;
                    ?>
                    <figure class="figure-cross" data-backgroundcolor-hover="<?php echo $overlay_color;?>">
                        <div class="cc-gallery-title">
                            <span class="span-cross" style="color: <?php echo $values['title_color']; ?>">
                                <?php
                                    echo $show_divider['above'];
                                        echo $values['title'];
                                    echo $show_divider['below'];
                                ?>
                            </span>
                        </div>
                        <?php echo $overlay; ?>
                    </figure>
                    <?php
                }
                ?>
            </div>
            <?php
            echo $wrapper['end'];
            echo '</div>';
            $output = ob_get_clean();
            ob_flush();
            return $output;
        }

        //onclick action
        protected function get_cc_click_action($action, $popup_page = '', $url_link = '', $gal_images = '', $image_id = '', $link_taxonomy = '', $value_title = '' ) {
            $div_wrapper = array();
            switch ($action) {
                case "page_in_popup":
                    if (!empty($popup_page)):
                        $div_wrapper['start'] = '<a href="'.get_permalink($popup_page).'?iframe=true&width=100%&height=100%" rel="prettyPhoto">';
                        $div_wrapper['end'] = '</a>';
                    endif;
                    break;
                case "link_to_page":
                    if (!empty($url_link) && isset($link_taxonomy) && !empty( $link_taxonomy ) && !empty( $value_title ) ){
                        $term_value = get_term_by( 'name', $value_title, 'product_cat');
                        $form_id = "'"."cc-cat-form-specials-".$term_value->term_id."'";

                        $div_wrapper['start'] = '<form id="cc-cat-form-specials-'.$term_value->term_id.'" action="' . $url_link['url'] . '" method="POST"><input name="product_cat[]" value="'.$term_value->term_id.'" type="hidden"><a href="javascript:void(0)" target="' . $url_link['target'] . '" onclick="document.getElementById('.$form_id.').submit(); return false;" title="' . $url_link['title'] . '">';
                        $div_wrapper['end'] = '</a></form>';
                    } elseif( !empty( $url_link ) ) {
                        $div_wrapper['start'] = '<a href="' . $url_link['url'] . '" target="' . $url_link['target'] . '" title="' . $url_link['title'] . '">';
                        $div_wrapper['end'] = '</a>';
                    }

                    break;
                case "video_lightbox":
                    if (!empty($url_link)):
                        $div_wrapper['start'] = '<a href="' . $url_link . '" rel="prettyPhoto">';
                        $div_wrapper['end'] = '</a>';
                    endif;
                    break;
                case "image_lightbox":
                    if (!empty($gal_images) && !empty($image_id)):
                        $gallery = array();
                        $lightbox_images = explode(',', $gal_images);
                        foreach ($lightbox_images as $lightbox_image) {
                            $image = wp_get_attachment_image_src($lightbox_image, 'full');
                            $gallery [] = '<a href="' . $image[0] . '" rel="prettyPhoto[pp_gal_' . $image_id . ']"><img src="' . esc_url($image[0]) . '" style="display:none"/></a>';
                        }
                        $div_wrapper['gallery'] = $gallery;
                    endif;
                    $div_wrapper['start'] = '';
                    $div_wrapper['end'] = '';
                    break;
                default:
                    $div_wrapper['start'] = '<div>';
                    $div_wrapper['end'] = '</div>';
                    break;
            }
            return $div_wrapper;
        }

        //on hover overlay action
        protected function get_cc_hover_overlay_action($overlay_text_color = '', $overlay_title = '', $overlay_subtitle = '', $above = '',$below = '',$overlay_border_color = '', $overlay_button_text = '', $overlay_button_text_color = '', $overlay_button_bg_color = '') {
            $output = '';
            $output .= '<span class="span-hover" style="color: '.$overlay_text_color.'"><span class="vert-wrap"><span class="vert-middle">';
            if(!empty($overlay_title)){
                $output .= '<span class="hover-cross">'.$above.$overlay_title.$below.'</span>';
            }
            if(!empty($overlay_subtitle)){
                $output .= '<span class="hover-subtext clearfix">'.$overlay_subtitle.'</span>';
            }
            if(!empty($overlay_button_text)){
                $output .= '<button class="cc-btn" style="color: '.$overlay_button_text_color.'; background-color: '.$overlay_button_bg_color.'">'.$overlay_button_text.'</button>';
            }
            $output .= '</span></span></span>';
          return $output;
        }

        //on hover image effect
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