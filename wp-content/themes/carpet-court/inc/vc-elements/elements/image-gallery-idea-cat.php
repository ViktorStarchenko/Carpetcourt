<?php
add_action( 'vc_before_init', 'cc_ideas_cat_integrateWithVC' );
function cc_ideas_cat_integrateWithVC() {
    vc_map( array(
    "name" => __("Idea Category", "carpet-court"),
    "base" => "cc_gal_category_element",
    "content_element" => true,
    "as_child" => array('only' => 'cc_gal_single_element'),
    "params" => array(
        /*array(
            "type"        => "dropdown",
            "heading"     => __("Choose Post Category", "carpet-court"),
            "param_name"  => "idea_post",
            'value' => cc_idea_posts(),
        ),*/
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
            // 'value' => cc_display_pages_ideas(),
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

}
add_shortcode('cc_gal_category_element','cc_gal_category_element');
function cc_gal_category_element($atts){
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

    if(!empty($values['content_display_style'])){
       if('isotope-horizontal'== $values['content_display_style']){
           $display_class = 'isotope-1xh isotope-2xw ';
       }
        elseif('isotope-vertical'== $values['content_display_style']){
            $display_class = 'isotope-2xh isotope-1xw ';
        }
        elseif('isotope-big'== $values['content_display_style']){
            $display_class = 'isotope-2xh isotope-2xw ';
        }
        else{
            $display_class = 'isotope-1xh isotope-1xw';
        }
    }
    else{
        $display_class = 'isotope-1xh isotope-1xw';
    }

    if(!empty($values['use_background'])){
        if(!empty($values['background_color'])){
            $color= $values['background_color'];
            $background = 'isotope-background';
        }
    }
    ?>
        <div class="<?php echo $termsString; ?> isotope-item <?php echo $display_class.' '.$background.' '.$image_effect.' '. $over_class;?>" style="background-color: <?php echo $color;?>">
            <?php echo $wrapper['start'];?>
                <?php if(empty($values['use_background'])):?>
                    <?php echo get_the_post_thumbnail($values['idea_post'],'cc_gal_image');?>
                <?php endif;?>
                <?php echo $overlay_div;?>
                <div class="isotop-content" data-backgroundcolor-hover="<?php echo $overlay_color;?>">
                <div class="isocontent-wrap isocontent-wrap-default">
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
    $output = ob_get_clean();
    ob_flush();
    return $output;
}
