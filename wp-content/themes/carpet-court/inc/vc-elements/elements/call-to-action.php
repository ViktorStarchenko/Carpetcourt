<?php
add_action( 'vc_before_init', 'cc_call_to_action_integrateWithVC' );
function cc_call_to_action_integrateWithVC(){
    vc_map( array(
        "name"                    => __("CC Call to Action Button", "carpet-court"),
        "base"                    => "cc_call_to_action",
        "description"             => __("Display a button along with text.","carpet-court"),
        "category"                => __('Content', 'carpet-court'),
        "params"                  => array(
            array(
                "type"        => "textfield",
                "holder" => "div",
                "heading"     => __("Enter Description Text", "carpet-court"),
                "param_name"  => "description_text",
            ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Description Text Color", "carpet-court" ),
                "param_name" => "description_text_color",
            ),
            array(
                "type"        => "textfield",
                "holder" => "div",
                "heading"     => __("Enter Button Text", "carpet-court"),
                "param_name"  => "button_text",
            ),
            array(
                "type"        => "textfield",
                "heading"     => __("Enter Link", "carpet-court"),
                "param_name"  => "button_link",
            ), 
            array(
                "type"        => "dropdown",
                "heading"     => __("Open link in", "carpet-court"),
                "param_name"  => "cc_link_target", 
                "admin_label" => true, 
                "value"       => array(
                    'Same Window'   => '_parent', 
                    'New Window'  => '_blank'
                ),
            ),
            array(
                "type"        => "dropdown",
                "heading"     => __("Position of button", "carpet-court"),
                "param_name"  => "cc_position_btn", 
                "admin_label" => true, 
                "value"       => array(
                    'Right'  => 'right',
                    'Left'   => 'left', 
                    'None'   => 'none'
                ),
            ),
            array(
                "type"        => "dropdown",
                "heading"     => __("Text Alignment of button", "carpet-court"),
                "param_name"  => "cc_align_btn", 
                "admin_label" => true, 
                "value"       => array(
                    'Center'   => 'center',
                    'Left'   => 'left', 
                    'Right'  => 'right'
                ),
            ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Button Text Color", "carpet-court" ),
                "param_name" => "button_text_color",
            ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Button Background Color", "carpet-court" ),
                "param_name" => "button_background_color",
            ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Button Text Color on Hover", "carpet-court" ),
                "param_name" => "button_hover_text_color",
            ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Button Background Color on Hover", "carpet-court" ),
                "param_name" => "button_hover_background_color",
            ),
        ),
    ) );
}
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_cc_call_to_action extends WPBakeryShortCode {

        protected function content( $atts, $content = null ) {
            $values = shortcode_atts( array(
                'description_text'  =>  '',
                'description_text_color'  =>  '#ffffff',
                'button_text'  =>  '',
                'button_link' => 'javascript:void(0)',
                'cc_link_target'  =>  '_parent',
                'cc_position_btn'  =>  'right',
                'cc_align_btn'  =>  'center',
                'button_text_color' => '#ef404d',
                'button_background_color' => '#ffffff',
                'button_hover_text_color' => '#ffffff',
                'button_hover_background_color' => '#ef404d',
            ), $atts ) ;
            ob_start();
            ?>
            <div class="cc-call-to-action">
                <h3 class="inline-group" style="color:<?php echo $values['description_text_color'];?>">
                    <?php echo $values['description_text'];?>
                </h3>
                <?php 
                    $float = 'float: '.$values['cc_position_btn'];
                    if( $values['cc_position_btn'] == 'none'){
                        $float = 'float: '.$values['cc_position_btn'].'; clear:both; display:block; margin-top:10px';
                    }
                ?>
                <a class="btn inline-group btn-cta" href="<?php echo $values['button_link']; ?>" target="<?php echo $values['cc_link_target']; ?>" data-color-hover="<?php echo $values['button_hover_text_color'];?>" data-bgcolor-hover="<?php echo $values['button_hover_background_color'];?>" style="color:<?php echo $values['button_text_color'];?>;background-color: <?php echo $values['button_background_color'];?>; <?php echo $float;?>; text-align: <?php echo $values['cc_align_btn'];?> ">
                    <?php echo $values['button_text'];?>
                </a>
            </div>
            <?php
            $output = ob_get_clean();
            ob_flush();
            return $output;
        }
    }
}