<?php
add_action( 'vc_before_init', 'cc_designer_troubleshooting_integrateWithVC' );
function cc_designer_troubleshooting_integrateWithVC(){

    //display posts of designer troubleshooting
    function cc_troubleshoot_posts(){
        $all_posts = array();
        $args = array(
            'post_type'=>'cc_troubleshooting',
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
        "name"                    => __("Designer Troubleshooting", "carpet-court"),
        "base"                    => "cc_designer_troubleshooting",
        "description"             => __("Display Designer Troubleshooting post","carpet-court"),
        "category"                => __('Content', 'carpet-court'),
        "params"                  => array(
            array(
                "type"        => "dropdown",
                "heading"     => __("Choose Post to display", "carpet-court"),
                "param_name"  => "troubleshoot_post",
                'value' => cc_troubleshoot_posts(),
            ),
        ),
    ) );
}
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_cc_designer_troubleshooting extends WPBakeryShortCode {

        protected function content( $atts, $content = null ) {
            $values = shortcode_atts( array(
                'troubleshoot_post'  =>  '',
            ), $atts ) ;
            ob_start();
            if(!empty($values['troubleshoot_post'])):
                $ts_post = get_post($values['troubleshoot_post']);
            ?>
                <div class="cc-designer-troubleshoot">
                    <a href="<?php echo get_the_permalink($ts_post->ID)?>">
                        <div class="cc-designer-troubleshoot-img">
                            <?php
                            if(has_post_thumbnail($ts_post->ID)):
                                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($ts_post->ID), 'full' );
                                echo '<img src="'.$thumb[0].'">';
                            endif;
                            ?>
                            <div class="default-overlay"></div>
                        </div>
                        <div class="troubleshoot-content">
                        <div class="cc-ts-title">
                            <?php echo $ts_post->post_title;?>
                        </div>
                        <hr/>
                        <div class="cc-ts-date">
                            <?php
                                $date = date("F d, Y", strtotime($ts_post->post_date));
                                echo $date;
                            ?>
                        </div>
                        <div class="cc-ts-excerpt">
                            <?php echo $ts_post->post_excerpt;?>
                        </div>
                        </div>
                    </a>
                </div>
            <?php
            endif;
            $output = ob_get_clean();
            ob_flush();
            return $output;
        }
    }
}