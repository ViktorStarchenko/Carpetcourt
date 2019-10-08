<?php
// admin head for acf conflict
function cpm_afc_vc_fix() {
    echo '<style>
    .repeater .row:before, .repeater .row:after {
        display: auto;
        content: none;
    }
    </style>';
}
add_action('admin_head', 'cpm_afc_vc_fix');

// add theme styles
// add_action('wp_footer', 'cpm_add_theme_styles', 30);
// function cpm_add_theme_styles(){}

add_filter( 'body_class','crash_body_classes', 99, 1 );
function crash_body_classes( $classes ) {
    global $post;
    if( get_field('enable_one_page_scroller', $post->ID ) ){
        $classes[] = 'onepage-scroll';
    }
    return $classes;
}

/* Convert hexdec color string to rgb(a) string */

function cpm_hex2rgba($color, $opacity = false) {

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if(empty($color))
          return $default;

    //Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
}

// function for watch video
add_action( 'wp_ajax_nopriv_cc_watch_videos', 'cc_watch_videos', 99);
add_action( 'wp_ajax_cc_watch_videos', 'cc_watch_videos', 99);
function cc_watch_videos() {
    global $post;
    global $wp_embed;
    $vid_url = $_POST['vid_url'];
    $parse_url = parse_url($vid_url);
    // print_r($parse_url);
    ob_start();
    $videoType = cc_videoType($vid_url);
    if( $videoType == 'vimeo'){
        $video_id = explode('/',$parse_url["path"]);
        ?>
        <iframe src="https://player.vimeo.com/video/<?php echo $video_id[1]; ?>?autoplay=1" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" height="600"></iframe>
        <?php
    }
    if( $videoType == 'youtu_be'){
        $video_id = explode('/',$parse_url["path"]); ?>
        <iframe src="https://www.youtube.com/embed/<?php echo $video_id[1];?>?feature=oembed&rel=0&autoplay=1" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" height="600"></iframe>
        <?php
    }
    if( $videoType == 'youtube'){
        $video_id = explode('=',$parse_url["query"]); ?>
        <iframe src="https://www.youtube.com/embed/<?php echo $video_id[1];?>?feature=oembed&rel=0&autoplay=1" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" height="600"></iframe>
        <?php
    }
    ?>
    <!-- <iframe src="https://player.vimeo.com/video/<?php echo $video_id; ?>" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0"></iframe> -->
    <?php
    echo ob_get_clean();
    die();
}

function cc_videoType($url) {
    if (strpos($url, 'youtube') > 0) {
        return 'youtube';
    } elseif (strpos($url, 'vimeo') > 0) {
        return 'vimeo';
    } elseif (strpos($url, 'youtu.be') > 0) {
        return 'youtu_be';
    } else {
        return 'unknown';
    }
}

function array_values_recursive($ary)  {
    $lst = array();
    foreach( array_keys($ary) as $k ) {
    $v = $ary[$k];
    if (is_scalar($v)) {
    $lst[] = $v;
    } elseif (is_array($v)) {
    $lst = array_merge($lst,array_values_recursive($v));
    }
    }
    return $lst;
}

// gravity form for ajax reload
add_filter("gform_confirmation_anchor", create_function("","return true;"));
// add_filter("gform_confirmation_anchor_4", create_function("","return true;"));