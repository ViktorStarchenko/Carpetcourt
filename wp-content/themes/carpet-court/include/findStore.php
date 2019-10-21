<?php

add_action( 'wp_ajax_update_entry_retailer', 'update_entry_retailer' );
add_action( 'wp_ajax_nopriv_update_entry_retailer', 'update_entry_retailer' );



add_filter('wpsl_templates', 'custom_templates');

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

add_filter('wpsl_listing_template', 'custom_listing_template');

function custom_listing_template()
{
    global $wpsl, $wpsl_settings;

    $listing_template = '<div data-store-id="<%= id %>" class="app-filter-result__list-item app-filter-result__list-vi"><div class="_divider"></div>' . "\r\n";
    $listing_template .= "\t\t" . '   <div class="article-inline-goods__title"></div>' . "\r\n";
    $listing_template .= "\t\t" . '   <div class="article-inline-goods__subtitle"><%= city %> </div>' . "\r\n";

    $listing_template .= "\t\t" . '<div class="app-filter-result__list-item-bottom">' . "\r\n";
    $listing_template .= "\t\t\t" . '<a href="#" class="retailer-info-show app-button-reserve _inline js-show-store-details" data-name="" >Store details <span class="app-svg button-reserve _icon-right"></span></a>' . "\r\n";
    //$listing_template .= "\t\t\t" . '<% if ( twist ) { %>' . "\r\n";
    //$listing_template .= "\t\t\t" . '<div class="app-sleep-selector-modal _size-small _twist-modal-popup" style="display: none;"><a href="#" class="ga-link  app-modal-close-twist-css app-modal-close-twist"></a><div class="app-sleep-selector-modal__flex"><div class="article-news-box"><div class="page-h3"><%= twist.modal_title %></div><div id="newsletter-form-block"><div class="article__send-form"><%=twist.modal_text %></div><div class="_button"><a href="#" class="app-button-submit app-button-reserve _inline app-modal-close-twist"><%= twist.modal_button %></a></div></div></div></div></div>' . "\r\n";
    //$listing_template .= "\t\t\t" . '<% } %>' . "\r\n";
    //$listing_template .= "\t\t\t" . '<% if ( offers && offers[0].hot ) {  %>' . "\r\n";
    //$listing_template .= "\t\t\t" . '<div class="deals-available-sign"> <span>special offers available</span><img src="' . get_stylesheet_directory_uri() . '/img/label.png"></div>' . "\r\n";
    //$listing_template .= "\t\t\t" . '<% } %>' . "\r\n";
    $listing_template .= "\t\t" . '</div>' . "\r\n";

    //$listing_template .= include 'wpsl-templates/listing-details.php';
    $listing_template .= "\t\t" . '<a class="wpsl-directions" style="display: none;"></a>' . "\r\n";
    $listing_template .= "\t" . '</div>' . "\r\n";

    $listing_template = '<div class="list-item app-filter-result__list-item app-filter-result__list-vi" data-store-id="<%= id %>" >
                            <div class="h5 item-title"><%= store %></div>
                            <div class="item-text"><%= address %>,<br><%= city %> <%= zip %><br><%= phone %></div>
                            <div class="item-buttons">
                                <div class="item-buttons__wrap">
                                    <button type="button" class="btn btn-round retailer-info-show app-button-reserve _inline js-show-store-details hidden-xs-max"><span class="ic ic-btn-arrow"></span><span>View on map</span></button>
                                    <a target="_blank" href="https://www.google.com/maps/dir/?api=1&destination=<%= encodeURIComponent(address) %>,<%= encodeURIComponent(city) %>,<%= encodeURIComponent(country) %>"  class="btn btn-round hidden-sm-min"><span class="ic ic-btn-arrow"></span><span>Get Directions</span></a>
                                </div>
                                <% if(offers){ %>
                                    <% if(offers.length > 0) { %>
                                    <div class="item-buttons__wrap">
                                        <button type="button" data-toggle="modal" data-target="#promotionsModal-<%= id %>" class="btn btn-round"><span class="ic ic-btn-arrow"></span><span>View promotions</span></button>
                                    </div>
                                    <% } %>
                                <% } %>
                            </div>
                            <% if(offers){ %>
                                    <% if(offers.length > 0) { %>
                            <div id="promotionsModal-<%= id %>" tabindex="-1" role="dialog" aria-hidden="true" class="modal modal-promotions fade">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <button type="button" data-dismiss="modal" aria-hidden="true" class="modal-close"><span class="ic ic-icon-cross"></span></button>
                                        <div class="modal-header">
                                            <div class="h5 modal-title">Available Deals At:</div>
                                        </div>
                                        <div class="modal-body">
                                            <div class="details-list">
                                            
                                            <% for(var i in offers) { %>
                                                <div class="details-list__cell">
                                                    <div class="detail-item">
                                                        <div class="detail-item__wrap">
                                                            <div class="h5 detail-item__title"><%= offers[i].title %></div>
                                                            <div class="detail-item__text"><%= offers[i].excerpt %></div>
                                                        </div>
                                                        <div class="detail-item__wrap">
                                                        <% if(retailer_url[offers[i].id]) { %>
                                                            <div class="detail-item__button"><a href="<%= retailer_url[offers[i].id] %>" data-name="<%= offers[i].name %>" class="btn btn-round"><span class="ic ic-btn-arrow"></span><span>View Promotion</span></a></div>
                                                        <% } else { %>
                                                            <div class="detail-item__button"><a href="<%= retailer_url %>" data-name="<%= offers[i].name %>" class="btn btn-round"><span class="ic ic-btn-arrow"></span><span>View Promotion</span></a></div>
                                                        <% } %>
                                                            <div class="detail-item__date">Offer ends <%= offers[i].ends %></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <% } %>
                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                    <% } %>
                            <% } %>
                        </div>';

    return $listing_template;
}

/*
add_filter('wpsl_sql', function ($sql) {
    $retailersFilter = isset($_GET['retailers']) ? $_GET['retailers'] : [];

    $join = '';
    $where = '';

    if (!empty($retailersFilter)) {
        $join .= 'INNER JOIN wp_postmeta AS retailer ON retailer.post_id = posts.ID AND retailer.meta_key = \'retailer\'';
        $where .= 'AND retailer.meta_value IN (' . implode(',', $retailersFilter) . ')';
    }

    $sql = "SELECT post_lat.meta_value AS lat,
                           post_lng.meta_value AS lng,
                           posts.ID, 
                           ( %d * acos( cos( radians( %s ) ) * cos( radians( post_lat.meta_value ) ) * cos( radians( post_lng.meta_value ) - radians( %s ) ) + sin( radians( %s ) ) * sin( radians( post_lat.meta_value ) ) ) ) 
                        AS distance
                      FROM wp_posts AS posts
                INNER JOIN wp_postmeta AS post_lat ON post_lat.post_id = posts.ID AND post_lat.meta_key = 'wpsl_lat'
                INNER JOIN wp_postmeta AS post_lng ON post_lng.post_id = posts.ID AND post_lng.meta_key = 'wpsl_lng'
                $join
                    
                     WHERE posts.post_type = 'wpsl_stores'
                       $where
                       AND posts.post_status = 'publish' GROUP BY posts.ID ORDER BY distance LIMIT %d";

    return $sql;
});

add_filter('wpsl_sql_placeholder_values', function ($placeholder_values) {
    $placeholder_values[4] = isset($_GET['max_results']) ? $_GET['max_results'] : 100;
    return $placeholder_values;
});

add_filter('wpsl_store_data', 'custom_store_data_response');

function custom_store_data_response($stores_meta)
{
    $specialOffersCategory = get_category_by_slug('special-offers');

    $rangesFilter = isset($_GET['ranges']) ? $_GET['ranges'] : [];
    $collectionsFilter = isset($_GET['collections']) ? $_GET['collections'] : [];
    $subRangesFilter = isset($_GET['sub_ranges']) ? $_GET['sub_ranges'] : [];
    $storeId = isset($_GET['item_id']) ? $_GET['item_id'] : false;
    $baseQuery = [
        'relation' => 'AND',
        [
            'key'     => 'start_date',
            'value'   => date('Y-m-d'),
            'compare' => '<=',
            'type'    => 'DATE',
        ],
        [
            'key'     => 'end_date',
            'value'   => date('Y-m-d'),
            'compare' => '>=',
            'type'    => 'DATE',
        ],
    ];

    $offersList =  get_posts([
        'category'   => $specialOffersCategory->cat_ID,
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_query' => $baseQuery,
    ]);


    $offerPosts = [];
    $promo_url = [];
    foreach ($offersList as $offer){
        $flag = false;
        $retailers = [];
        if(get_field('not_all_stores_in_participate', $offer->ID)){
            $stores = get_field('stores', $offer->ID);
            //$retailer_ID = get_field('retailer_special', $offer->ID);

            $i = 0;
            foreach ($stores as $store){
                $retailers[$i] = get_field('retailer', $store->ID);
                $offerPosts[$offer->ID][$retailers[$i]->ID]['stores'] = $stores;
                $i++;
            }
        }
        else{
            $retailers[0] = get_field('retailer_groups', $offer->ID);
            $flag = true;
        }

        $promo_urls = get_field("promotion_link", $offer->ID);
        if(!empty($promo_urls)){
            foreach ($promo_urls as $link){
                $promo_url[$offer->ID][$link['promotion_link_retailer']->ID] = $link['url_for_find_store'];
            }
        }

        foreach ($retailers as $retailer){
            if(isset($retailer->ID) && !empty($retailer->ID)){
                $offerPosts[$offer->ID][$retailer->ID]['retailer'] = $retailer->ID;
                $offerPosts[$offer->ID][$retailer->ID]['id'] = $offer->ID;
                $offerPosts[$offer->ID][$retailer->ID]['title'] = get_field('title', $offer->ID);
                $offerPosts[$offer->ID][$retailer->ID]['name'] = $retailer->post_name;
                $offerPosts[$offer->ID][$retailer->ID]['hot'] = get_field('hot_deals', $offer->ID);
                $offerPosts[$offer->ID][$retailer->ID]['promotion_sub_title'] = get_field('sub_title', $offer->ID);
                $offerPosts[$offer->ID][$retailer->ID]['cta_button'] = get_field('cta_button', $offer->ID);
                if($flag)
                    $offerPosts[$offer->ID][$retailer->ID]['groups'] = 1;
            }
        }
    }


    $result = [];
    foreach ($stores_meta as $store_meta) {
        if ($storeId && $store_meta['id'] !== $storeId) {
            continue;
        }

//        $store = get_post($store_meta['id']);
        // START FILTERS
        $retailer = get_field('retailer', $store_meta['id']);

        if (false == get_field('enable', $retailer->ID)) {
            continue;
        }

        $twists = [];
        $baseTwists = [];
        $store_meta['base_benefits'] = false;
        $baseTwistImage = null;

        if (!empty($rangesFilter)) {
            $ranges = get_field('ranges', $store_meta['id']);

            $inArray = false;
            foreach ($ranges as $range) {
                if (in_array($range->ID, $rangesFilter)) {
                    $inArray = true;
                    $retailerTwists = get_field('retailer_twist', $range->ID);
                    $baseBenefits = get_field('benefits', $range->ID);
                    $baseTwists = array_merge($baseTwists, get_field('basic_twists', $range->ID));
                    if (!empty($baseBenefits)) {
                        $store_meta['base_benefits'] = $baseBenefits;
                        $baseTwistImage = get_field('twist_image', $range->ID);
                    }

                    if (!empty($retailerTwists)) {
                        foreach ($retailerTwists as $retailerTwist) {
                            $retailerTwist->range = $range->post_title;
                            $twists[] = $retailerTwist;
                        }
                    }
                    break;
                }
            }

            if (false === $inArray) {
                continue;
            }
        }

        // END FILTERS
        $store_meta['twist'] = false;
        $store_meta['twist_benefits'] = false;
        foreach ($twists as $twist) {
            $retailerGroup = get_field('retailer_group', $twist->ID);
            if ($retailer->ID == $retailerGroup->ID) {
                $twist->modal_title = get_option("retailers_twists_modal_title");
                $twist->modal_button = get_option("retailers_twists_modal_button_text");
                $retailerDisplayName = get_field('display_name', $retailer->ID);
                $retailerDisplayName = !empty($retailerDisplayName) ? $retailerDisplayName : $retailer->post_title;
                $twist->modal_text = str_replace('%RetailerGroup%', $retailerDisplayName, get_option("retailers_twists_modal_text"));
                $twist->modal_text = str_replace('%TwistName%', $twist->post_title, $twist->modal_text);
                $twist->modal_text = str_replace('%SelectedRangeName%', $twist->range, $twist->modal_text);
                $twist->image = get_the_post_thumbnail_url($twist->ID);
                $twist->benefits_title = get_field('benefit_title', $twist->ID);
                $store_meta['twist'] = $twist;
                $benefits = get_field('benefits', $twist->ID);
                if (!empty($benefits)) {
                    foreach ($benefits as $benefit) {
                        $benefit->info = get_field('info', $benefit->ID);
                        $store_meta['twist_benefits'][] = $benefit;
                    }

                }
                break;
            }
        }
        $store_meta['base_twist'] = false;
        foreach ($baseTwists as $twist) {
            $retailerGroup = get_field('retailer', $twist->ID);
            if ($retailer->ID == $retailerGroup->ID) {
                $baseTImage = get_field('image', $twist->ID);
                $twist->image = !empty($baseTImage) ? $baseTImage : $baseTwistImage;
                $twist->benefits_title = get_field('benefits_title', $twist->ID);
                $store_meta['base_twist'] = $twist;
                break;
            }
        }

        $offers = null;

        foreach ($offerPosts as $itemOffer){
            if(isset($itemOffer[$retailer->ID])&&!empty($itemOffer[$retailer->ID])){
                if(isset($itemOffer[$retailer->ID]['groups'])){
                    $date = new DateTime(get_field('end_date', $itemOffer[$retailer->ID]['id']));
                    if(empty($itemOffer[$retailer->ID]['cta_button'])){
                        $itemOffer[$retailer->ID]['cta_button'] = 'Show';
                    }
                    $offers[] = [
                        'title' => $itemOffer[$retailer->ID]['title'],
                        'name' => $itemOffer[$retailer->ID]['name'],
                        'hot' => $itemOffer[$retailer->ID]['hot'],
                        'ends' => $date->format('d F Y'),
                        'id' => $itemOffer[$retailer->ID]['id'],
                        'excerpt' => get_the_excerpt($itemOffer[$retailer->ID]['id']),
                        'sub_title' => $itemOffer[$retailer->ID]['promotion_sub_title'],
                        'cta_button' => $itemOffer[$retailer->ID]['cta_button'],
                    ];
                } else {
                    foreach ($itemOffer[$retailer->ID]['stores'] as $store){
                        if($store_meta['id']==$store->ID){
                            $date = new DateTime(get_field('end_date', $itemOffer[$retailer->ID]['id']));
                            if(empty($itemOffer[$retailer->ID]['cta_button'])){
                                $itemOffer[$retailer->ID]['cta_button'] = 'Show';
                            }
                            $offers[] = [
                                'title' => $itemOffer[$retailer->ID]['title'],
                                'name' => $itemOffer[$retailer->ID]['name'],
                                'hot' => $itemOffer[$retailer->ID]['hot'],
                                'ends' => $date->format('d F Y'),
                                'id' => $itemOffer[$retailer->ID]['id'],
                                'excerpt' => get_the_excerpt($itemOffer[$retailer->ID]['id']),
                                'sub_title' => $itemOffer[$retailer->ID]['promotion_sub_title'],
                                'cta_button' => $itemOffer[$retailer->ID]['cta_button'],
                            ];
                        }
                    }
                }
            }

            if(isset($promo_url[$itemOffer[$retailer->ID]['id']][$retailer->ID])){
                if(!empty($promo_url[$itemOffer[$retailer->ID]['id']][$retailer->ID])){
                    $store_meta['retailer_url'][$itemOffer[$retailer->ID]['id']] = $promo_url[$itemOffer[$retailer->ID]['id']][$retailer->ID];
                }
                else{
                    $store_meta['retailer_url'][$itemOffer[$retailer->ID]['id']] = '/special-offers?retailer='.$retailer->ID;
                }
            }
        }

        if(!isset($store_meta['retailer_url'])||empty($store_meta['retailer_url'])){
            $store_meta['retailer_url'] = '/special-offers?retailer='.$retailer->ID;
        }

        $store_meta['retailer'] = get_field('name', $retailer->ID);
        $store_meta['retailer_image'] = get_the_post_thumbnail_url($retailer);

        //$retailer_url = get_field('retailer_url', $retailer->ID);

        $store_meta['offers'] = $offers;
        $store_meta['ranges_show'] = 0;

        $ranges_list = [];
        $ranges_show = get_field('ranges_show', $retailer->ID);
        if($ranges_show){

            $store_meta['ranges_show'] = 1;
            $ranges = get_field('ranges', $store_meta['id']);

            if(!empty($ranges)){
                $r = 0;
                foreach ($ranges as $range_item){
                    $ranges_list[$r]['title'] = $range_item->post_title;
                    $ranges_list[$r]['id'] = $range_item->ID;
                    $ranges_list[$r]['link'] = get_permalink($range_item->ID);
                    $r++;
                }
            }
        }

        $store_meta['ranges'] = $ranges_list;

        $result[] = $store_meta;
    }

    //dump($stores_meta);
    //dump($result);

    return $result;
}

function get_retailers_list() {
    $retailers = [];
    try {

        $retailers = wp_cache_get( 'retailers_wpsl_search' );
        if ( false === $retailers ) {
            $allRetailers = get_posts([
                'numberposts' => -1,
                'post_type' => 'wpsl_stores',
                'post_status' => 'publish'
            ]);

            if (!empty($allRetailers)) {
                foreach ($allRetailers as $retailer) {
                    $rangesIds = [];
                    $subRangesIds = [];
                    $ranges = get_field('ranges', $retailer->ID);
                    if (!empty($ranges)) {
                        $rangesIds = array_map(function($obj){return "$obj->ID";}, $ranges);
                    }
                    $subranges = get_field('sub_ranges', $retailer->ID);
                    if (!empty($subranges)) {
                        $subRangesIds = array_map(function($obj){return "$obj->ID";}, $subranges);
                    }
                    $storeRetailer = get_field('retailer', $retailer->ID);
                    $retailers[] = [
                        'id' => $retailer->ID,
                        'title' => $retailer->post_title,
                        'city' => $retailer->wpsl_city,
                        'address' => $retailer->wpsl_address,
                        'lat' => $retailer->wpsl_lat,
                        'lng' => $retailer->wpsl_lng,
                        'retailer_id' => "$storeRetailer->ID",
                        'ranges' => $rangesIds,
                        'subranges' => $subRangesIds
                    ];
                }
            }

            if (!empty($retailers)) {
                wp_cache_set( 'retailers_wpsl_search', $retailers, '', 3600);
            }
        }
    } catch (Exception $e) { }

    return $retailers;
}

function get_retailers_groups() {
    $retailers = [];
    try {

        $retailers = wp_cache_get( 'retailers_groups_wpsl_search' );
        if ( false === $retailers ) {

            $category = get_category_by_slug('retailer-groups');
            $allRetailers = get_posts([
                'numberposts' => -1,
                'category'   => $category->cat_ID,
                'post_status' => 'publish'
            ]);

            if (!empty($allRetailers)) {
                foreach ($allRetailers as $retailer) {
                    $retailers[] = [
                        'id' => $retailer->ID,
                        'title' => get_field('display_name', $retailer->ID)
                    ];
                }
            }

            if (!empty($retailers)) {
                wp_cache_set( 'retailers_groups_wpsl_search', $retailers, '', 3600);
            }
        }
    } catch (Exception $e) { }

    return $retailers;
}

add_filter('wpsl_meta_box_fields', 'add_retailer_group_meta');

function add_retailer_group_meta($wpsl_meta_box_fields) {

    $wpsl_meta_box_fields[__( 'Additional Information', 'wpsl' )]['retailer'] = [
        'label' => __( 'Retailer', 'wpsl' )
    ];

    return $wpsl_meta_box_fields;
}


add_action( 'restrict_manage_posts', 'wpse45436_admin_posts_filter_restrict_manage_posts' );


// Add retailers filter to stores list in admin section
function wpse45436_admin_posts_filter_restrict_manage_posts(){

    if( ! is_admin() )
        return;

    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    //only add filter to post type you want
    if ('wpsl_stores' == $type){
        //change this to the list of values you want to show
        //in 'label' => 'value' format

        $retailersGroupCategory = get_category_by_slug('retailer-groups');
        $metaQuery = [
            [
                'key'     => 'enabled',
                'value'   => true,
                'compare' => '=',
            ],
        ];



        $args = [
            'numberposts'   => -1,
            'category'      => $retailersGroupCategory->cat_ID,
            'meta_query'    => $metaQuery,
            'post_type'     => 'post',
        ];

        $retailers = get_posts($args);

        $values = [];
        foreach ($retailers as $retailer) {
            $values[$retailer->post_title] = $retailer->ID;
        }
        if (!empty($values)) {
            ?>
            <select name="retailer_group">
                <option value=""><?php _e('Filter By ', 'wose45436'); ?></option>
                <?php
                $current_v = isset($_GET['retailer_group'])? $_GET['retailer_group']:'';
                foreach ($values as $label => $value) {
                    printf
                    (
                        '<option value="%s"%s>%s</option>',
                        $value,
                        $value == $current_v? ' selected="selected"':'',
                        $label
                    );
                }
                ?>
            </select>
            <?php
        }
    }
}


add_filter( 'parse_query', 'wpse45436_posts_filter' );

function wpse45436_posts_filter( $query ){
    if( ! is_admin() )
        return;

    global $pagenow;
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ( 'wpsl_stores' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['retailer_group']) && $_GET['retailer_group'] != '') {
        if ($query->get('post_type') == 'wpsl_stores') {
            $query->set('meta_key', 'retailer');

            $query->set('meta_value', $_GET['retailer_group']);
        }

    }
}

add_filter('wpsl_meta_box_fields', 'add_retailer_group_meta');
*/