<?php

add_filter( 'wpsl_admin_marker_dir', 'custom_admin_marker_dir' );
function custom_admin_marker_dir() {

    $admin_marker_dir = get_stylesheet_directory() . '/wpsl-templates/markers/';

    return $admin_marker_dir;
}
add_filter('wpsl_templates', 'custom_templates');
define( 'WPSL_MARKER_URI', dirname( get_bloginfo( 'stylesheet_url') ) . '/wpsl-templates/markers/' );

//Store locator
function custom_templates($templates)
{
    /**
     * The 'id' is for internal use and must be unique ( since 2.0 ).
     * The 'name' is used in the template dropdown on the settings page.
     * The 'path' points to the location of the custom template,
     * in this case the folder of your active theme.
     */
    $templates[] = [
        'id'   => 'custom',
        'name' => 'Custom template',
        'path' => get_stylesheet_directory() . '/' . 'wpsl-templates/find-a-store.php',
    ];

    return $templates;
}

function get_ajax_posts() {

    //dump($_POST);

    $metaQuery = [];
    if (!empty($_POST['category'])) {
        $categoryID = (int) $_POST['category'];
        $metaQuery = [
            [
                'taxonomy' => 'wpsl_store_category',
                'field' => 'id',
                'terms' => $categoryID,
                'include_children' => false
            ]
        ];
    }

    $args = [
        'post_type' => 'wpsl_stores',
        'post_status' => 'publish',
        'numberposts' => -1,
        'tax_query' => $metaQuery
    ];

    $ajaxposts = get_posts( $args );

    echo json_encode( $ajaxposts );

    exit;
}

add_action('wp_ajax_get_ajax_posts', 'get_ajax_posts');
add_action('wp_ajax_nopriv_get_ajax_posts', 'get_ajax_posts');

function get_ajax_post() {

    //dump($_POST);

    $ID = (int) $_POST['store'];

    $ajaxpost = get_post( $ID );
    $ajaxpostInfo = get_post_meta($ID);

    $holidaysByCarpet = get_field('carpet_holidays', 'option');
    $holidayByStore = get_field('store_holidays', $ID);

    $mainHolidays = [];
    if (!empty($holidaysByCarpet) && $holidaysByCarpet['enable']) {
        $mainHolidays = $holidaysByCarpet['holiday'];
    }

    $storeHolidays = [];
    if (!empty($holidayByStore) && $holidayByStore['enable']) {
        $storeHolidays = $holidayByStore['holiday'];
    }

    $holidays = array_merge($storeHolidays, $mainHolidays);
    $holidayHtml = "";

    if (!empty($holidays)) {
        $holidayHtml = '<ul class="locator-holiday">';
        foreach ($holidays as $item) {
            if (!empty($item['title'])) {
                $workingTime = 'Closed';
                if (!empty($item['working_time'])) {
                    $workingTime = $item['working_time'];
                }

                if (mb_strtolower($workingTime) == 'closed') {
                    $workingTime = '<span class="locator-holiday__close">'.$workingTime.'</span>';
                }
                $holidayHtml .= '
                 <li class="locator-holiday__row">
                    <div class="locator-holiday__left">'.$item['title'].'</div>
                    <div class="locator-holiday__right">'.$workingTime.'</div>
                 </li>';
            }
        }
        $holidayHtml .= '</ul>';
    }

    if (!empty($ajaxpost)) {

        $ajaxResult = [
            'address' => '',
            'address2' => '',
            'phone' => '',
            'email' => '',
            'url' => get_permalink($ajaxpost->ID),
            'work' => '',
            'holidays' => $holidayHtml,
            'store' => $ajaxpost->post_title,
            'store_status' => ''
        ];

        if (!empty($ajaxpostInfo['wpsl_address'][0])) {
            $ajaxResult['address'] = $ajaxpostInfo['wpsl_address'][0];
        }

        if (!empty($ajaxpostInfo['wpsl_address2'][0])) {
            $ajaxResult['address2'] = $ajaxpostInfo['wpsl_address2'][0];
        }

        if (!empty($ajaxpostInfo['wpsl_phone'][0])) {
            $ajaxResult['phone'] = $ajaxpostInfo['wpsl_phone'][0];
        }

        if (!empty($ajaxpostInfo['wpsl_email'][0])) {
            $ajaxResult['email'] = $ajaxpostInfo['wpsl_email'][0];
        }

        if (!empty($ajaxpostInfo['wpsl_hours'][0])) {
            $ajaxResult['work'] = scheduled($ajaxpostInfo);
        }

        echo json_encode( $ajaxResult );
        exit;
    }

    echo json_encode( '' );
    exit;
}

function scheduled($ajaxpostInfo) {
    $work = unserialize($ajaxpostInfo['wpsl_hours'][0]);

    $ajaxResult = [
        'today' => 'Closed',
        'monday' => 'Closed',
        'tuesday' => 'Closed',
        'wednesday' => 'Closed',
        'thursday' => 'Closed',
        'friday' => 'Closed',
        'saturday' => 'Closed',
        'sunday' => 'Closed'
    ];

    $week = [
        1 => 'monday',
        2 => 'tuesday',
        3 => 'wednesday',
        4 => 'thursday',
        5 => 'friday',
        6 => 'saturday',
        7 => 'sunday',
    ];

    $date = new DateTime();
    $weekNumber = $date->format("N");
    if (!empty($work[$week[$weekNumber]][0])) {
        $ajaxResult['today'] = str_replace(',', ' — ', $work[$week[$weekNumber]][0]);
    }

    if (!empty($work['monday'][0])) {
        $ajaxResult['monday'] =  str_replace(',', ' — ', $work['monday'][0]);
    }

    if (!empty($work['tuesday'][0])) {
        $ajaxResult['tuesday'] =  str_replace(',', ' — ', $work['tuesday'][0]);
    }

    if (!empty($work['wednesday'][0])) {
        $ajaxResult['wednesday'] =  str_replace(',', ' — ', $work['wednesday'][0]);
    }

    if (!empty($work['thursday'][0])) {
        $ajaxResult['thursday'] =  str_replace(',', ' — ', $work['thursday'][0]);
    }

    if (!empty($work['friday'][0])) {
        $ajaxResult['friday'] =  str_replace(',', ' — ', $work['friday'][0]);
    }

    if (!empty($work['saturday'][0])) {
        $ajaxResult['saturday'] =  str_replace(',', ' — ', $work['saturday'][0]);
    }

    if (!empty($work['sunday'][0])) {
        $ajaxResult['sunday'] =  str_replace(',', ' — ', $work['sunday'][0]);
    }

    return $ajaxResult;
}

// Fire AJAX action for both logged in and non-logged in users
add_action('wp_ajax_get_ajax_post', 'get_ajax_post');
add_action('wp_ajax_nopriv_get_ajax_post', 'get_ajax_post');

add_filter('wpsl_store_data', 'custom_store_data_response');

function custom_store_data_response($stores_meta)
{
    if (!empty($_GET['stories'])){
        $ID = (int) $_GET['stories'];
        $posts[] = get_post($ID);
    } else {
        $metaQuery = [];
        if (!empty($_GET['categories'])) {
            $categoryID = (int) $_GET['categories'];
            $metaQuery = [
                [
                    'taxonomy' => 'wpsl_store_category',
                    'field' => 'id',
                    'terms' => $categoryID,
                    'include_children' => false
                ]
            ];
        }

        $args = [
            'post_type' => 'wpsl_stores',
            'post_status' => 'publish',
            'numberposts' => -1,
            'tax_query' => $metaQuery
        ];

        $posts = get_posts($args);
    }

    $result = [];
    foreach ($stores_meta as $key => $store) {
        foreach ($posts as $post) {
            if ($post->ID == $store['id']) {
                $result[] = $store;
            }
        }
    }

    return $result;
}