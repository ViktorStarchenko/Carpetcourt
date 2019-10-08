<?php
/**
 * Created by PhpStorm.
 * User: Rubal
 * Date: 2/26/16
 * Time: 1:58 PM
 */
add_action( 'vc_before_init', 'cc_img_vid_integrateWithVC' );
function cc_img_vid_integrateWithVC(){

    vc_map( array(
        "name" => __("Image and Video Gallery", "carpet-court"),
        "base" => "cc_image_vid_gallery",
        "as_parent" => array('only' => 'cc_img_vid_single_element, cc_vid_embed_gallery'),
        "content_element" => true,
        "show_settings_on_create" => false,
        "is_container" => true,
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => __("Number of Column", "carpet-court"),
                "param_name" => "no_of_column",
                'value' => array(
                    __('3 Columns', 'carpet-court') => 4,
                    __('4 Columns', 'carpet-court') => 3,
                    ),
                'std' => 4,
                ),
            ),
        "js_view" => 'VcColumnView'
        ) );

    vc_map( array(
        "name" => __("Element", "carpet-court"),
        "base" => "cc_img_vid_single_element",
        "content_element" => true,
        "as_child" => array('only' => 'cc_image_vid_gallery'),
        "params" => array(
            array(
                "type" => "attach_image",
                "heading" => __("Choose Image", "carpet-court"),
                "param_name" => "image",
                ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title", "carpet-court"),
                "param_name" => "title",
                ),
            array(
                "type" => "textarea",
                "heading" => __("Description", "carpet-court"),
                "param_name" => "description_content",
                ),
            array(
                "type" => "checkbox",
                "heading" => __("Enable Image Link", "carpet-court"),
                "param_name" => "enable_image_link",
                ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Enter Image Link", "carpet-court"),
                "param_name" => "image_url",
                'dependency' => array(
                    'element' => 'enable_image_link',
                    'value' => array('true'),
                    ),
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
                "type" => "checkbox",
                "heading" => __("Show Video in Lightbox", "carpet-court"),
                "param_name" => "show_video",
                ),
            array(
                "type" => "textfield",
                "heading" => __("Enter Video Url", "carpet-court"),
                "param_name" => "video_url",
                'dependency' => array(
                    'element' => 'show_video',
                    'value' => array('true'),
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
            )
) );
}

global $cc_img_vid_col;
global $pretty_rel;

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_cc_image_vid_gallery extends WPBakeryShortCodesContainer {

        protected function content($atts = null, $content = null){

            $values = shortcode_atts( array(
                'no_of_column'  =>  '',
                ), $atts );

            ob_start();

            global $cc_img_vid_col;
            global $pretty_rel;

            $pretty_rel = get_the_ID().'-'.rand();
            $cc_img_vid_col = 4;

            if(!empty($atts)){
                $cc_img_vid_col = $values['no_of_column'];
            }
            $pagename = get_query_var('pagename');


            echo '<div class="vc_row wpb_row vc_inner vc_row-fluid">';
            echo do_shortcode($content);
            echo '</div>';


            $output = ob_get_clean();
            ob_flush();
            return $output;

        }

    }
}




add_shortcode('cc_img_vid_single_element','cc_img_vid_single_element');
function cc_img_vid_single_element($atts){

    $values = shortcode_atts( array(
        'image'  =>  '',
        'title'  =>  '',
        'description_content'   => '',
        'enable_image_link' => '',
        'image_url'  =>  '',
        'title_color'  =>  '',
        'enable_overlay'  =>  '',
        'overlay_color'  =>  '',
        'enable_divider'  =>  '',
        'show_divider'  =>  '',
        'divider_color'  =>  '',
        'show_video'  =>  '',
        'video_url'  =>  '',
        'onhover_image_effect' => '',
        'image_hover_effect' => '',
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
        ), $atts );

    global $cc_img_vid_col;
    global $pretty_rel;

    ob_start();

    $video = '';

    $class = '';

    $show_default_overlay = $default_overlay_color = '';

    $overlay = $overlay_color = $overlay_text_color = $overlay_title = $overlay_subtitle = $overlay_border_color = $overlay_button_text = $overlay_button_text_color = $overlay_button_bg_color = '';

    $img_effect_class = '';

    $show_divider['above'] = '';
    $show_divider['below'] = '';

    $show_overlay_divider['above'] = '';
    $show_overlay_divider['below'] = '';


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

    /*video in lightbox*/
    if( isset($values['show_video']) && true == $values['show_video'] ){
        if(!empty($values['video_url'])){
            $video = $values['video_url'];
        }

    }

    /*on hover image effect*/
    if (isset($values['onhover_image_effect']) && $values['onhover_image_effect'] != '') {
        if (!empty($values['image_hover_effect'])) {
            switch ($values['image_hover_effect']) {
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
        $overlay = get_hover_overlay_img_vid( $overlay_text_color,$overlay_title, $overlay_subtitle,$show_overlay_divider['above'],$show_overlay_divider['below'], $overlay_border_color, $overlay_button_text, $overlay_button_text_color, $overlay_button_bg_color);
    }

    if($overlay != ''){
        $class = 'cc-hover-only';
    }



    ?>
    <div class="wpb_column vc_column_container mt-10 mb-10 vc_col-sm-6 vc_col-md-<?php echo $cc_img_vid_col;?>">
        <div class="vc_column-inner ">
            <div class="cc-gallery <?php echo $class;?>">
                <div class="cc-gallery-img <?php echo $img_effect_class;?>">
                    <?php
                    $image = wp_get_attachment_image_src($values['image'], 'cc_gal_image');

                    $explode_url = explode("https://carpetcourt.wistia.com/medias/", $video );

                    if ( !empty( $explode_url ) && !empty( $explode_url[1] ) && count( $explode_url ) == 2) {

                        $image_vid_url = '';
                        if ( !empty( $image ) ) {
                            $image_vid_url = $image[0]; ?>
                            <a class="cc-fancy-box" href="#<?php echo $explode_url[1]; ?>" data-videoid="<?php echo $explode_url[1]; ?>">

                                <img src="<?php echo $image_vid_url; ?>">
                                <?php if(true == $show_default_overlay){
                                    echo '<div class="default-overlay" style="background-color:'.$default_overlay_color.'"></div>';
                                } ?>
                                <div class="cc-img-vid-gallery">
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
                                        <div class="cc-gallery-description">
                                            <?php echo $values['description_content']; ?>
                                        </div>
                                        <?php echo $overlay; ?>
                                    </figure>
                                </div>
                            </a>
                            <?php
                        } else {
                            ?>


                            <div class="wistia_responsive_padding" style="padding: 56.25% 0 28px 0; position: relative;">
                                <div class="wistia_responsive_wrapper" style="height: 100%; left: 0; position: absolute; top: 0; width: 100%;"><span class="wistia_embed wistia_async_<?php echo $explode_url[1]; ?> popover=true popoverAnimateThumbnail=true videoFoam=true" style="display: inline-block; height: 100%; width: 100%;"> </span></div>
                            </div>
                            <div class="cc-img-vid-gallery">
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
                                    <div class="cc-gallery-description">
                                            <?php echo $values['description_content']; ?>
                                        </div>
                                    <?php echo $overlay; ?>
                                </figure>
                            </div>
                            <?php } ?>
                            <?php
                        } else {

                            if(!empty($video)){
                                echo '<a href="'.$video.'" rel="prettyPhoto[img_vid_'.$pretty_rel.']">';
                            } else {
                                $enable_image_link = $values['enable_image_link'];
                                $link = $values['image_url'];
                                if ( $enable_image_link == true ) {
                                    # code...
                                    echo '<a href="'.$link.'" >';
                                } else {
                                    echo '<a href="'.$image[0].'" rel="prettyPhoto[img_vid_'.$pretty_rel.']" >';
                                }
                            }
                            ?>
                            <img src="<?php echo esc_url($image[0])?>"/>
                            <?php if(true == $show_default_overlay){
                                echo '<div class="default-overlay" style="background-color:'.$default_overlay_color.'"></div>';
                            } ?>

                            <div class="cc-img-vid-gallery">
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
                                    <div class="cc-gallery-description">
                                            <?php echo $values['description_content']; ?>
                                        </div>
                                    <?php echo $overlay; ?>
                                </figure>
                            </div>
                            <?php echo '</a>';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $output = ob_get_clean();
        ob_flush();
        return $output;

    }

    function get_hover_overlay_img_vid($overlay_text_color = '', $overlay_title = '', $overlay_subtitle = '', $above = '',$below = '',$overlay_border_color = '', $overlay_button_text = '', $overlay_button_text_color = '', $overlay_button_bg_color = '') {
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
