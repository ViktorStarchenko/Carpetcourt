<?php
add_action( 'vc_before_init', 'cc_page_link_integrateWithVC' );
function cc_page_link_integrateWithVC(){
    vc_map( array(
        "name"                    => __("CC Page Link ", "carpet-court"),
        "base"                    => "cc_page_link",
        "description"             => __("Display a text with link to page.","carpet-court"),
        "category"                => __('Content', 'carpet-court'),
        "params"                  => array(
            array(
                "type" => "attach_image",
                "heading" => __("Choose Image", "carpet-court"),
                "param_name" => "image",
                ),
            array(
                "type"        => "textfield",
                "holder" => "div",
                "heading"     => __("Title", "carpet-court"),
                "param_name"  => "page_title",
                "description" => __("Enter Title","carpet-court"),
                ),
            array(
                "type"        => "textarea_html",
                "heading"     => __("Description", "carpet-court"),
                "param_name"  => "content",
                "description" => __("Enter short description", "carpet-court"),
                ),
            array(
                'type' => 'dropdown',
                'heading' => __('Action', 'carpet-court'),
                'param_name' => 'selected_action',
                'value' => array(
                    __('None', 'carpet-court') => '',
                    __('Show Video', 'carpet-court') => 'show_video',
                    __('Link another page', 'carpet-court') => 'link_to_page',
                    ),
                'description' => __('Select action for click.', 'carpet-court'),
                ),
            array(
                "type"        => "vc_link",
                "heading"     => __("Choose page To Link", "carpet-court"),
                "param_name"  => "page_link",
                'dependency' => array(
                    'element' => 'selected_action',
                    'value' => array('link_to_page'),
                    ),
                ),
            array(
                "type"        => "textfield",
                "holder" => "div",
                "heading"     => __("Add Video Url", "carpet-court"),
                "param_name"  => "video_url",
                'dependency' => array(
                    'element' => 'selected_action',
                    'value' => array('show_video'),
                    ),
                ),
            array(
                "type"        => "textfield",
                "holder" => "div",
                "heading"     => __("Text on Hover", "carpet-court"),
                "param_name"  => "text_on_hover",
                ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Text color on Hover", "carpet-court" ),
                "param_name" => "text_color_hover",
                ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Background color on Hover", "carpet-court" ),
                "param_name" => "background_color_hover",
                ),
            array(
                "type" => "checkbox",
                "heading" => __( "Is active?", "carpet-court" ),
                "param_name" => "is_active",
                ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Text color on Active", "carpet-court" ),
                "param_name" => "text_color_active",
                'dependency' => array(
                    'element' => 'is_active',
                    'value' => 'true',
                    ),
                ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Background color on Active", "carpet-court" ),
                "param_name" => "background_color_active",
                'dependency' => array(
                    'element' => 'is_active',
                    'value' => 'true',
                    ),
                ),
            array(
                'type' => 'css_editor',
                'heading' => __( 'Css', 'carpet-court' ),
                'param_name' => 'css',
                'group' => __( 'Design options', 'carpet-court' ),
                ),
            ),
        ) );
}
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_cc_page_link extends WPBakeryShortCode {

        protected function content( $atts, $content = null ) {
            $values = shortcode_atts( array(
                'image'  =>  '',
                'page_title'  =>  '',
                'page_link'=>'',
                'text_on_hover'=>'',
                'text_color_hover'=>'',
                'background_color_hover'=>'',
                'is_active'=>'',
                'text_color_active'=>'',
                'background_color_active'=>'',
                'css'=>'',
                'link_to_page' => '',
                'video_url' => '',
                'show_video' => '',
                'selected_action' => '',
                ), $atts ) ;
            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $values['css'], ' ' ), $this->settings['base'], $atts );
            $link = vc_build_link( $values['page_link']);

            $hover_text = '';
            if(!empty($values['text_on_hover'])){
                $hover_text = '<div class="pg-link-hover-text"><span><h3>'.$values['text_on_hover'].' <i class="fa fa-angle-right"></i></h3></span></div>';
            }

            $border_color = 'style = "border-color:#54c6d3"';
            if(!empty($values['background_color_hover'])){
                $border_color = 'style = "border-color:'.$values['background_color_hover'].'"';
            }

            $active = $active_color = $active_bg_color = '';
            if('true' == $values['is_active']){
                $border_color = '';
                $active = 'true';
                $active_color = 'style = "color:'.$values['text_color_active'].'"';
                $active_bg_color = 'style = "background-color:'.$values['background_color_active'].'"';
            }

            ob_start();
            $image = wp_get_attachment_image_src($values['image'], 'cc_gal_image');

            if( $values['selected_action'] == 'show_video' ) { ?>
        <div class="cc-hover-block <?php echo esc_attr( $css_class ); ?>" data-backgroundcolor-hover = "<?php echo $values['background_color_hover'];?>" data-active="<?php echo $active;?>" <?php echo $active_bg_color;?> <?php echo $border_color;?>>
            <?php

            $explode_url = explode("https://carpetcourt.wistia.com/medias/", $values['video_url'] );
            if ( !empty( $explode_url[1] ) ) { ?>

            <a class="cc-fancy-box" href="#<?php echo $explode_url[1]; ?>" data-videoid="<?php echo $explode_url[1]; ?>">
                <?php } else { ?>
                <a href="<?php echo $values['video_url']; ?>" rel="prettyPhoto">
                    <?php } ?>
                    <div class="cc-hover-info" data-textcolor-hover = "<?php echo $values['text_color_hover'];?>">
                        <?php
                        if ( !empty( $image[0] ) ) { ?>


                        <img src="<?php echo esc_url($image[0])?>"/>
                        <?php
                    }
                    ?>
                    <h3 class="cc-page-title alt-text" <?php echo $active_color;?>>
                        <?php echo $values['page_title']; ?>
                    </h3>
                    <hr/>
                    <div class="cc-page-content" <?php echo $active_color;?>>
                        <?php echo $content; ?>
                    </div>
                    <?php echo $hover_text;?>
                </div>
            </a>
        </div>
        <?php
    } else { ?>

            <div class="cc-hover-block <?php echo esc_attr( $css_class ); ?>" data-backgroundcolor-hover = "<?php echo $values['background_color_hover'];?>" data-active="<?php echo $active;?>" <?php echo $active_bg_color;?> <?php echo $border_color;?>>
                <a href="<?php echo $link['url'] ;?>" target="<?php echo $link['target'];?>" title="<?php echo $link['title'];?>">
                    <div class="cc-hover-info" data-textcolor-hover = "<?php echo $values['text_color_hover'];?>">
                        <?php
                        if ( !empty( $image[0] ) ) { ?>


                        <img src="<?php echo esc_url($image[0])?>"/>
                        <?php
                    }
                    ?>
                    <h3 class="cc-page-title alt-text" <?php echo $active_color;?>>
                        <?php echo $values['page_title']; ?>
                    </h3>
                    <hr/>
                    <div class="cc-page-content" <?php echo $active_color;?>>
                        <?php echo $content; ?>
                    </div>
                    <?php echo $hover_text;?>
                </div>
            </a>
        </div>
        <?php } ?>
    <?php
    $output = ob_get_clean();
    ob_flush();
    return $output;
}
}
}