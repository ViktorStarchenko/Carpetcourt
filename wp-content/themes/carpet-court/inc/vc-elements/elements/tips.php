<?php
add_action( 'vc_before_init', 'cc_designer_tips_integrateWithVC' );
function cc_designer_tips_integrateWithVC(){

    //display categories of designer tips
    function cc_tips_categories() {
        $all_terms = array();
        $terms = get_terms( 'cc_design_cat');
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $all_terms[html_entity_decode(utf8_decode($term->name))] = $term->term_id;
            }
        }
        return $all_terms;
    }

    //display posts of designer tips
    function cc_tips_posts(){
        $all_posts = array();
        $args = array(
            'post_type'=>'cc_tips',
            'post_status'=>'publish',
            'posts_per_page'=> -1,
        );
        $posts = get_posts( $args );
        foreach ($posts as $post_value) {
            $all_posts[html_entity_decode(utf8_decode($post_value->post_title))] = $post_value->ID; 
        }
        wp_reset_postdata();
        wp_reset_query();
        return $all_posts;
    }

    vc_map( array(
        "name"                    => __("Designer Tips", "carpet-court"),
        "base"                    => "cc_designer_tips",
        "description"             => __("Display Designer Tips in carousel.","carpet-court"),
        "category"                => __('Content', 'carpet-court'),
        "params"                  => array(
            array(
                'type' => 'dropdown',
                'heading' => __( 'Select Category or Posts', 'carpet-court' ),
                'param_name' => 'select_attribute',
                'value' => array(
                    __( 'None', 'carpet-court' ) => '',
                    __( 'Category', 'carpet-court' ) => 'category',
                    __( 'Posts', 'carpet-court' ) => 'post',
                ),
            ),
            array(
                "type"        => "checkbox",
                "heading"     => __("Choose category", "carpet-court"),
                "param_name"  => "design_category",
                'dependency' => array(
                    'element' => 'select_attribute',
                    'value' => array( 'category'),
                ),
                'value' => cc_tips_categories(),
            ),
            array(
                "type"        => "checkbox",
                "heading"     => __("Choose Posts", "carpet-court"),
                "param_name"  => "design_posts",
                'dependency' => array(
                    'element' => 'select_attribute',
                    'value' => array( 'post'),
                ),
                'value' => cc_tips_posts(),
            ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Text color", "carpet-court" ),
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
                "type" => "colorpicker",
                "heading" => __("Hover Overlay color", "carpet-court"),
                "param_name" => "hover_overlay_color",
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
    class WPBakeryShortCode_cc_designer_tips extends WPBakeryShortCode {

        protected function content( $atts, $content = null ) {
            $values = shortcode_atts( array(
                'select_attribute'  =>  '',
                'design_category'  =>  '',
                'design_posts'  =>  '',
                'text_color'  =>  '',
                'enable_overlay'  =>  '',
                'overlay_color'  =>  '',
                'hover_overlay_color'  =>  '',
                'onhover_image_effect' => '',
                'image_hover_effect' => '',
            ), $atts ) ;
            ob_start();
            $show_default_overlay = $default_overlay_color = '';
                if(!empty($values['select_attribute'])):
                    $text_color = $values['text_color'];
                    $overlay_color = $values['hover_overlay_color'];
                    $image_effect = '';

                    /*default image overlay*/
                    if( isset($values['enable_overlay']) && 'true' == $values['enable_overlay'] ){
                        $show_default_overlay = true;
                        if(!empty($values['overlay_color'])){
                            $default_overlay_color = $values['overlay_color'];
                        }
                    }

                    /*on hover image effect*/
                    if (isset($values['onhover_image_effect']) && $values['onhover_image_effect'] != '') {
                        if (!empty($values['image_hover_effect'])) {
                            $image_effect = $this->get_cc_hover_image_effect($values['image_hover_effect']);
                        }
                    }
                    echo '<ul class="cc-designer-tips">';
                        if(!empty($values['design_category'])):
                            $args = $this->cc_set_designer_args($values['design_category'],'cat');
                            $this->cc_fetch_designer_posts($args,$text_color,$overlay_color,$image_effect,$show_default_overlay,$default_overlay_color);
                        elseif(!empty($values['design_posts'])):
                            $args = $this->cc_set_designer_args($values['design_posts'],'post');
                            $this->cc_fetch_designer_posts($args,$text_color,$overlay_color,$image_effect,$show_default_overlay,$default_overlay_color);
                        endif;
                    echo '</ul>';
                endif;
            $output = ob_get_clean();
            ob_flush();
            return $output;
        }

        protected function cc_set_designer_args($ids,$case){
            $args = '';
            switch($case){
                case "cat":
                    $args = array(
                        'post_type' => 'cc_tips',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'cc_design_cat',
                                'field'    => 'id',
                                'terms'    => explode(',',$ids)
                            ),
                        ),
                    );
                    break;
                case "post":
                    $args = array(
                        'post_type' => 'cc_tips',
                        'post__in' => explode(',',$ids)
                    );
                    break;
                default:
                    echo '';
            }
            return $args;
        }

        protected function cc_fetch_designer_posts($args,$text_color='',$overlay_color='',$image_effect='',$show_default_overlay='',$default_overlay_color=''){
            $all_post = new WP_Query($args);
            while($all_post->have_posts()):$all_post->the_post();
                $terms = get_the_terms( get_the_ID() , 'cc_design_cat' );
                $term_id = '';
                if(!empty($terms)){
                    $term_id = $terms[0]->term_id;
                }
                ?>
                <li>
                    <a href="<?php the_permalink();?>" class="<?php echo $image_effect;?>">
                        <?php
                        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'shop_catalog' );
                        if(!empty($thumb)):
                            echo '<img src="'.$thumb[0].'">';
                            if(true == $show_default_overlay):
                                echo '<div class="default-overlay" style="background-color:'.$default_overlay_color.'"></div>';
                            endif;
                        else:
                            $image = cc_placeholder_img_src('300x300');
                            echo '<img src="'.esc_url($image).'">';
                        endif;
                        ?>
                        <figure class="cc-tips-details" style="color: <?php echo $text_color;?>">
                            <span>
                                <div class="cc-tip-title">
                                    <?php the_title();?>
                                </div>
                                <!--<div class="cc-tip-date">
                                    <?php //echo get_the_date();?>
                                </div>-->
                                <div class="cc-tip-category" style="background-color:<?php the_field('color',  'cc_design_cat_' . $term_id ); ?> ">
                                    <?php
                                    $categories = get_the_terms( get_the_ID(), 'cc_design_cat' );
                                    if(!empty($categories)):
                                        foreach($categories as $category){
                                            echo $category->name;
                                        }
                                    endif;
                                    ?>
                                </div>
                            </span>
                        </figure>
                        <div class="tips-overlay" data-backgroundcolor-hover="<?php echo $overlay_color;?>"></div>
                    </a>
                </li>
            <?php
            endwhile;wp_reset_postdata();
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