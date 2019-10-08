<?php

add_action( 'vc_before_init', 'cc_pdf_integrateWithVC' );
function cc_pdf_integrateWithVC(){

    vc_map( array(
        "name" => __("Pdf Download", "carpet-court"),
        "base" => "cc_pdf_download",
        "description" => __("Display an area for pdf download in front.", "carpet-court"),
        "category" => __('Content', 'carpet-court'),
        "params" => array(
            array(
                "type"        => "textfield",
                "holder" => "div",
                "heading"     => __("Enter Button Text", "carpet-court"),
                "param_name"  => "button_text",
                ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Button Color", "carpet-court" ),
                "param_name" => "button_color",
            ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Button Text Color", "carpet-court" ),
                "param_name" => "button_text_color",
            ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Button Border Color", "carpet-court" ),
                "param_name" => "button_border_color",
            ),
            array(
                "type" => "my_param",
                "heading" => __("Upload a document", "carpet-court"),
                "param_name" => "upload_document",
                ),
            ),
        ) );

    vc_map( array(
        "name" => __("Subscribe to Mailchimp List", "carpet-court"),
        "base" => "cc_subscribe_mailchimp_lists",
        "description" => __("An area to subscribe to mailchimp lists in front.", "carpet-court"),
        "category" => __('Content', 'carpet-court'),
        "params" => array(
            array(
                "type"        => "textfield",
                "holder" => "div",
                "heading"     => __("Enter Button Text", "carpet-court"),
                "param_name"  => "button_text",
                ),
            array(
              'param_name'  => 'input_id',
              'heading'     => __( 'ID', 'carpet-court' ),
              'description' => __( 'Enter a unique ID.', 'carpet-court' ),
              'type'        => 'textfield',
              'holder'      => 'div'
              ),
            ),
        )
    );
}


if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_cc_subscribe_mailchimp_lists extends WPBakeryShortCode {

        protected function content( $atts, $content = null ) {
            $values = shortcode_atts(array(
                'button_text' => '',
                'input_id' => '',
                ), $atts);

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $rand = $characters[rand(0, $charactersLength - 1)];


            if ( isset( $values['button_text'] ) && !empty( $values['button_text'] ) ) {
                $button_texts = $values['button_text'];
            } else {
                $button_texts = 'Subscribe & Download';
            }

            if ( isset( $values['input_id'] ) && !empty( $values['input_id'] ) ) {
                $unique_id = $values['input_id'];
            } else {
                $unique_id = $rand;
            }

            ob_start(); ?>

            <div class="cc-pdf-list">
                <a href="#mailchimp-lists-<?php echo $unique_id; ?>" class="cpm-mailchimp-prettyPhoto cc-cpm-btn btn btn-primary btn-lg" ><?php echo $button_texts; ?></a>
                <div id="mailchimp-lists-<?php echo $unique_id; ?>" class="hide">
                    <div class="cpm-mailchimp-wrapper">

                        <span class="cpm-bold">Subscribe To Carpetcourt List.</span>
                        <form action="#" class="mailchimp-form" method="post">
                            <div class="cpm-input-wrap">

                                <select name="mailchimp_list_id">
                                    <option value="">--Select A List--</option>
                                    <?php
                                    $result_array = return_mailchimp_lists();
                                    if ( !empty( $result_array ) ) {
                                        foreach ($result_array as $lkey => $result_value) { ?>
                                        <option value="<?php echo $lkey; ?>"><?php echo $result_value; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <p class="submit-list-err"></p>

                            <input type="email" class="mailchimp_email" name="mailchimp_email" placeholder="Enter Your Email" >
                            <p class="submit-err"></p>
                            <img class="ajax-loader-chimp" src="<?php echo get_template_directory_uri().'/assets/images/ajax-loader.gif'; ?>" style="display: none;">
                        </div>
                        <button type="button" class="button-submit" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>


        <?php
        $output = ob_get_clean();
        ob_flush();
        return $output;
    }
}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_cc_pdf_download extends WPBakeryShortCode {

        protected function content( $atts, $content = null ) {

            $values = shortcode_atts(array(
                'upload_document' => '',
                'button_text'   => '',
                'button_color'  => '',
                'button_text_color' => '',
                'button_border_color'   => ''
                ), $atts);
            ob_start();

            if ( !empty( $values['upload_document'] ) ) {
                $button_text = ( isset( $values['button_text'] ) && !empty( $values['button_text'] ) ) ? $values['button_text'] : 'Subscribe & Download';

                $button_color = '';
                $button_text_color = '';
                $button_border_color = '';

                if ( isset( $values['button_color'] )  && !empty( $values['button_color'] ) ) {
                    $button_color = "background-color:".$values['button_color']."; ";
                }
                if ( isset( $values['button_text_color'] )  && !empty( $values['button_text_color'] ) ) {
                    $button_text_color = "color:".$values['button_text_color']."; ";
                }
                if ( isset( $values['button_border_color'] )  && !empty( $values['button_border_color'] ) ) {
                    $button_border_color = "border: 1px solid".$values['button_border_color']."; ";
                }

                ?>
                <div class="cc-pdf-list">

                    <a href="#inline-<?php echo $values['upload_document']; ?>" style="<?php echo $button_color.$button_text_color.$button_border_color; ?>" class="cpm-prettyPhoto cc-cpm-btn btn-cpm-cc" ><?php echo $button_text; ?></a>
                    <div id="inline-<?php echo $values['upload_document']; ?>" class="hide">
                        <div class="cpm-mailchimp-wrapper">

                            <span class="cpm-bold">Enter your email and your download will start automatically.</span>
                            <form action="#" class="mailchimp-form" method="post">
                                <div class="cpm-input-wrap">

                                    <input type="hidden" name="doc_id" value="<?php echo $values['upload_document']; ?>">
                                    <input type="email" class="mailchimp_email" name="mailchimp_email" placeholder="Enter Your Email" >
                                    <p class="submit-err"></p>
                                    <img class="ajax-loader-chimp" src="<?php echo get_template_directory_uri().'/assets/images/ajax-loader.gif'; ?>" style="display: none;">
                                </div>
                                <button type="button" class="button-submit" name="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
            $output = ob_get_clean();
            ob_flush();
            return $output;
        }
    }
}

vc_add_shortcode_param( 'my_param', 'my_param_settings_field', get_template_directory_uri().'/inc/vc-elements/assets/cc-custom-pdf.js' );
function my_param_settings_field( $settings, $value ) {
   return '<div class="my_param_block">'
   .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" />'.'<img src="'.home_url('/wp-includes/images/media/document.png').'" class="placeholder-img">'
             .'<button type="button" class="upload_image_button button">Upload</button><button type="button" class="remove_image_button button">Remove</button>' // New button element
             .'</div>';
         }

