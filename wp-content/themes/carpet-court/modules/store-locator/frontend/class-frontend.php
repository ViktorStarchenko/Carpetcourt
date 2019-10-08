<?php
/**
 * Frontend class
 *
 * @author Tijmen Smit
 * @since  1.0.0
 */

if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'WPSL_Frontend' ) ) {

    /**
     * Handle the frontend of the store locator
     *
     * @since 1.0.0
     */
    class WPSL_Frontend {

        /**
         * Keep track which scripts we need to load
         *
         * @since 2.0.0
         */
        private $load_scripts = array();

        /**
         * Keep track of the amount of maps on the page
         *
         * @since 2.0.0
         */
        private static $map_count = 0;

        /*
         * Holds the shortcode atts for the [wpsl] shortcode.
         *
         * Used to overwrite the settings just before
         * they are send to wp_localize_script.
         *
         * @since 2.1.1
         */
        public $sl_shortcode_atts;

        private $store_map_data = array();


        /**
         * Class constructor
         */
        public function __construct() {

            $this->includes();

            add_action( 'wp_ajax_store_search',        array( $this, 'store_search' ) );
            add_action( 'wp_ajax_nopriv_store_search', array( $this, 'store_search' ) );
            add_action( 'wp_enqueue_scripts',          array( $this, 'add_frontend_styles' ) );
            add_action( 'wp_footer',                   array( $this, 'add_frontend_scripts' ) );

            add_filter( 'the_content',                 array( $this, 'cpt_template' ) );

            add_shortcode( 'wpsl',                     array( $this, 'show_store_locator' ) );
            add_shortcode( 'wpsl_address',             array( $this, 'show_store_address' ) );
            add_shortcode( 'wpsl_hours',               array( $this, 'show_opening_hours' ) );
            add_shortcode( 'wpsl_map',                 array( $this, 'show_store_map' ) );
        }

        /**
         * Include the required front-end files.
         *
         * @since  2.0.0
         * @return void
         */
        public function includes() {
            require_once( WPSL_PLUGIN_DIR . 'frontend/underscore-functions.php' );
        }

        /**
         * Handle the Ajax search on the frontend.
         *
         * @since 1.0.0
         * @return json A list of store locations that are located within the selected search radius
         */
        public function store_search() {

            global $wpsl_settings;

            /*
             * Check if auto loading the locations on page load is enabled.
             *
             * If so then we save the store data in a transient to prevent a long loading time
             * in case a large amount of locations need to be displayed.
             *
             * The SQL query that selects nearby locations doesn't take that long,
             * but collecting all the store meta data in get_store_meta_data() for hunderds,
             * or thousands of stores can make it really slow.
             */
            if ( $wpsl_settings['autoload'] && isset( $_GET['autoload'] ) && $_GET['autoload'] && !$wpsl_settings['debug'] && !isset( $_GET['skip_cache'] ) ) {
                $transient_name = $this->create_transient_name();

                if ( false === ( $store_data = get_transient( 'wpsl_autoload_' . $transient_name ) ) ) {
                    $store_data = $this->find_nearby_locations();

                    if ( $store_data ) {
                        set_transient( 'wpsl_autoload_' . $transient_name, $store_data, 0 );
                    }
                }
            } else {
                $store_data = $this->find_nearby_locations();
            }

            wp_send_json( $store_data );

            exit();
        }

        /**
         * Create the name used in the wpsl autoload transient.
         *
         * @since 2.1.1
         * @return string $transient_name The transient name.
         */
        public function create_transient_name() {

            global $wpsl, $wpsl_settings;

            // Include the set autoload limit.
            $name_section = array( $wpsl_settings['autoload_limit'] );

            /*
             * Check if we need to include the cat id(s) in the transient name.
             *
             * This can only happen if the user used the
             * 'category' attr on the wpsl shortcode.
             */
            if ( isset( $_GET['filter'] ) && $_GET['filter'] ) {
                $name_section[] = absint( str_replace( ',', '', $_GET['filter'] ) );
            }

            // Include the lat value from the start location.
            if ( isset( $_GET['lat'] ) && $_GET['lat'] ) {
                $name_section[] = absint( str_replace( '.', '', $_GET['lat'] ) );
            }

            /*
             * If a multilingual plugin ( WPML or qTranslate X ) is active then we have
             * to make sure each language has his own unique transient. We do this by
             * including the lang code in the transient name.
             *
             * Otherwise if the language is for example set to German on page load,
             * and the user switches to Spanish, then he would get the incorrect
             * permalink structure ( /de/.. instead or /es/.. ) and translated
             * store details.
             */
            $lang_code = $wpsl->i18n->check_multilingual_code();

            if ( $lang_code ) {
                $name_section[] = $lang_code;
            }

            $transient_name = implode( '_', $name_section );

            return $transient_name;
        }

        /**
         * Find store locations that are located within the selected search radius.
         *
         * This happens by calculating the distance between the
         * latlng of the searched location, and the latlng from
         * the stores in the db.
         *
         * @since 2.0.0
         * @return void|array $store_data The list of stores that fall within the selected range.
         */
        public function find_nearby_locations() {

            global $wpdb, $wpsl, $wpsl_settings;

            $store_data = array();

            /*
             * Set the correct earth radius in either km or miles.
             * We need this to calculate the distance between two coordinates.
             */
            $radius = ( $wpsl_settings['distance_unit'] == 'km' ) ? 6371 : 3959;

            // The placeholder values for the prepared statement in the sql query.
            // wpsl-search-input
            $placeholder_values = array(
                $radius,
                $_GET['lat'],
                $_GET['lng'],
                $_GET['lat']
            );

            // Check if we need to filter the results by category.
            if ( isset( $_GET['filter'] ) && $_GET['filter'] ) {
                $filter_ids = array_map( 'absint', explode( ',', $_GET['filter'] ) );
                $cat_filter = "INNER JOIN $wpdb->term_relationships AS term_rel ON posts.ID = term_rel.object_id
                               INNER JOIN $wpdb->term_taxonomy AS term_tax ON term_rel.term_taxonomy_id = term_tax.term_taxonomy_id
                                      AND term_tax.taxonomy = 'wpsl_store_category'
                                      AND term_tax.term_id IN (" . implode( ',', $filter_ids ) . ")";
            } else {
                $cat_filter = '';
            }

            /*
             * If WPML is active we include 'GROUP BY lat' in the sql query
             * to prevent duplicate locations from showing up in the results.
             *
             * This is a problem when a store location for example
             * exists in 4 different languages. They would all fall within
             * the selected radius, but we only need one store ID for the 'icl_object_id'
             * function to get the correct store ID for the current language.
             */
            if ( $wpsl->i18n->wpml_exists() ) {
                $group_by = 'GROUP BY lat';
            } else {
                $group_by = 'GROUP BY posts.ID';
            }

            /*
             * If autoload is enabled we need to check if there is a limit to the
             * amount of locations we need to show.
             *
             * Otherwise include the radius and max results limit in the sql query.
             */
            if ( isset( $_GET['autoload'] ) && $_GET['autoload'] ) {
                $limit = '';

                if ( $wpsl_settings['autoload_limit'] ) {
                    $limit = 'LIMIT %d';
                    $placeholder_values[] = $wpsl_settings['autoload_limit'];
                }

                $sql_sort = 'ORDER BY distance '. $limit;
            } else {
                array_push( $placeholder_values, $this->check_store_filter( 'radius' ), $this->check_store_filter( 'max_results' ) );
                $sql_sort = 'HAVING distance < %d';
                $sql_sort .= ' ORDER BY distance LIMIT 0, %d ';
            }

            $placeholder_values = apply_filters( 'wpsl_sql_placeholder_values', $placeholder_values );

            /*
             * The sql that will check which store locations fall within
             * the selected radius based on the lat and lng values.
             */
            $sql = apply_filters( 'wpsl_sql',
                   "SELECT post_lat.meta_value AS lat,
                           post_lng.meta_value AS lng,
                           posts.ID,
                           ( %d * acos( cos( radians( %s ) ) * cos( radians( post_lat.meta_value ) ) * cos( radians( post_lng.meta_value ) - radians( %s ) ) + sin( radians( %s ) ) * sin( radians( post_lat.meta_value ) ) ) )
                        AS distance
                      FROM $wpdb->posts AS posts
                INNER JOIN $wpdb->postmeta AS post_lat ON post_lat.post_id = posts.ID AND post_lat.meta_key = 'wpsl_lat'
                INNER JOIN $wpdb->postmeta AS post_lng ON post_lng.post_id = posts.ID AND post_lng.meta_key = 'wpsl_lng'
                    $cat_filter
                     WHERE posts.post_type = 'wpsl_stores'
                       AND posts.post_status = 'publish' $group_by $sql_sort"
            );

            // echo $wpdb->prepare( $sql, $placeholder_values );die;
            $stores = $wpdb->get_results( $wpdb->prepare( $sql, $placeholder_values ) );

            if ( $stores ) {
                $store_data = apply_filters( 'wpsl_store_data', $this->get_store_meta_data( $stores ) );
            }

            return $store_data;
        }

        /**
         * Get the post meta data for the selected stores.
         *
         * @since  2.0.0
         * @param  object $stores
         * @return array  $all_stores The stores that fall within the selected range with the post meta data.
         */
        public function get_store_meta_data( $stores ) {

            global $wpsl_settings, $wpsl;

            $all_stores           = array();
            $include_post_content = apply_filters( 'wpsl_include_post_content', false );

            // Get the list of store fields that we need to filter out of the post meta data.
            $meta_field_map = $this->frontend_meta_fields();
            // var_dump($meta_field_map);
            // die();

            foreach ( $stores as $store_key => $store ) {

                // If WPML is active try to get the id of the translated page.
                if ( $wpsl->i18n->wpml_exists() ) {
                    $store->ID = $wpsl->i18n->maybe_get_wpml_id( $store->ID );

                    if ( !$store->ID ) {
                        continue;
                    }
                }

                // Get the post meta data for each store that was within the range of the search radius.
                $custom_fields = get_post_custom( $store->ID );

                foreach ( $meta_field_map as $meta_key => $meta_value ) {

                    if ( isset( $custom_fields[$meta_key][0] ) ) {
                        if ( ( isset( $meta_value['type'] ) ) && ( !empty( $meta_value['type'] ) ) ) {
                            $meta_type = $meta_value['type'];
                        } else {
                            $meta_type = '';
                        }

                        // If we need to hide the opening hours, and the current meta type is set to hours we skip it.
                        if ( $wpsl_settings['hide_hours'] && $meta_type == 'hours' ) {
                            continue;
                        }

                        // Make sure the data is safe to use on the frontend and in the format we expect it to be.
                        switch ( $meta_type ) {
                            case 'numeric':
                                $meta_data = ( is_numeric( $custom_fields[$meta_key][0] ) ) ? $custom_fields[$meta_key][0] : 0 ;
                                break;
                            case 'email':
                                $meta_data = sanitize_email( $custom_fields[$meta_key][0] );
                                break;
                            case 'url':
                                $meta_data = esc_url( $custom_fields[$meta_key][0] );
                                break;
                            case 'hours':
                                $meta_data = $this->get_opening_hours( $custom_fields[$meta_key][0], $hide_closed = false );
                                break;
                            case 'wp_editor':
                            case 'textarea':
                                $meta_data = wp_kses_post( wpautop( $custom_fields[$meta_key][0] ) );
                                break;
                            case 'text':
                            default:
                                $meta_data = sanitize_text_field( stripslashes( $custom_fields[$meta_key][0] ) );
                                break;
                        }

                        $store_meta[$meta_value['name']] = $meta_data;
                    } else {
                        $store_meta[$meta_value['name']] = '';
                    }

                    /*
                     * Include the post content if the "More info" option is enabled on the settings page,
                     * or if $include_post_content is set to true through the 'wpsl_include_post_content' filter.
                     */
                    if ( ( $wpsl_settings['more_info'] && $wpsl_settings['more_info_location'] == 'store listings' ) || $include_post_content ) {
                        $page_object               = get_post( $store->ID );
                        $store_meta['description'] = apply_filters( 'the_content', strip_shortcodes( $page_object->post_content ) );
                    }

                    $store_meta['store'] = get_the_title( $store->ID );
                    $store_meta['thumb'] = $this->get_store_thumb( $store->ID, $store_meta['store'] );
                    $store_meta['id']    = $store->ID;
                    $store_meta['avg_rating'] = $this->get_store_rating( $store->ID );
                    $store_meta['store_status'] = $this->cc_get_store_status($store->ID);

                    if ( !$wpsl_settings['hide_distance'] ) {
                        $store_meta['distance'] = round( $store->distance, 1 );
                    }

                    if ( $wpsl_settings['permalinks'] ) {
                        $store_meta['permalink'] = get_permalink( $store->ID );
                    }

                    

                }

                $all_stores[] = apply_filters( 'wpsl_store_meta', $store_meta, $store->ID );
            }

            return $all_stores;
        }

        /**
         * The store meta fields that are included in the json output.
         *
         * The wpsl_ is the name in db, the name value is used as the key in the json output.
         *
         * The type itself is used to determine how the value should be sanitized.
         * Text will go through sanitize_text_field, email through sanitize_email and so on.
         *
         * If no type is set it will default to sanitize_text_field.
         *
         * @since 2.0.0
         * @return array $store_fields The names of the meta fields used by the store
         */
        public function frontend_meta_fields() {

            $store_fields = array(
                'wpsl_address' => array(
                    'name' => 'address'
                ),
                'wpsl_address2' => array(
                    'name' => 'address2'
                ),
                'wpsl_city' => array(
                    'name' => 'city'
                ),
                'wpsl_state' => array(
                    'name' => 'state'
                ),
                'wpsl_zip' => array(
                    'name' => 'zip'
                ),
                'wpsl_country' => array(
                    'name' => 'country'
                ),
                'wpsl_lat' => array(
                    'name' => 'lat',
                    'type' => 'numeric'
                ),
                'wpsl_lng' => array(
                    'name' => 'lng',
                    'type' => 'numeric'
                ),
                'wpsl_phone' => array(
                    'name' => 'phone'
                ),
                'wpsl_fax' => array(
                    'name' => 'fax'
                ),
                'wpsl_email' => array(
                    'name' => 'email',
                    'type' => 'email'
                ),
                'wpsl_hours' => array(
                    'name' => 'hours',
                    'type' => 'hours'
                ),
                'wpsl_url' => array(
                    'name' => 'url',
                    'type' => 'url'
                ),
                'wpsl_store_status' => array(
                    'name' => 'store_status'
                ),
                'wpsl_avg_rating' => array(
                    'name' => 'avg_rating'
                )
            );

            return apply_filters( 'wpsl_frontend_meta_fields', $store_fields );
        }

        /**
         * Get the store thumbnail.
         *
         * @since 2.0.0
         * @param string       $post_id    The post id of the store
         * @param string       $store_name The name of the store
         * @return void|string $thumb      The html img tag
         */
        public function get_store_thumb( $post_id, $store_name ) {

            $attr = array(
                'class' => 'wpsl-store-thumb',
                'alt'   => $store_name
            );

            $thumb = get_the_post_thumbnail( $post_id, $this->get_store_thumb_size(), apply_filters( 'wpsl_thumb_attr', $attr ) );
            // $thumb = get_the_post_thumbnail( $post_id, 'category_image', apply_filters( 'wpsl_thumb_attr', $attr ) );

            return $thumb;
        }

        /**
         * Get the store thumbnail size.
         *
         * @since 2.0.0
         * @return array $size The thumb format
         */
        public function get_store_thumb_size() {

            $size = apply_filters( 'wpsl_thumb_size', array( 340, 260 ) );

            return $size;
        }

        public function get_store_rating( $post_id ) {
            global $wpdb;
            $comments_count = wp_count_comments($post_id);
            $ratings = $wpdb->get_var( $wpdb->prepare("
              SELECT SUM(meta_value) FROM $wpdb->commentmeta
              LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
              WHERE meta_key = 'pixrating'
              AND comment_post_ID = %d
              AND comment_approved = '1'
              AND meta_value > 0
              ", $post_id ) );
            $average = 0;

            if ( !empty( $ratings ) ) {

              $get_average = number_format( $ratings / $comments_count->all, 2, '.', '' );

              update_post_meta( $post_id, 'pixrating_average', $get_average );

              $average = (string) round( $get_average );
            }
            $args = array(
               'rating' => $average,
               'type' => 'rating',
               'number' => $comments_count,
               'echo' => false
            );
            return wp_star_rating( $args );
        }


        // function to find the store status as closed or open
        public function cc_get_store_status( $store_id ){
            $current_day = strtolower( date( 'l',current_time('timestamp') ) );
            $cur_time_str = date ( 'g:i A' , current_time( 'timestamp' ) );
            $cur_time = strtotime( $cur_time_str );
            $store_time = get_post_meta( $store_id, 'wpsl_hours' );
                if( !empty($store_time) )
                  $store_day = $store_time[0][$current_day];
                if( !empty($store_day) ){
                    $exploded_time = explode(',', $store_day[0]);
                    $start_time = strtotime($exploded_time[0]);
                    $end_time = strtotime($exploded_time[1]);
                    $current_status = "Closed";
                    if( ($cur_time >= $start_time) && ( $cur_time <= $end_time ) ){
                      $current_status = "Open Now";
                    }
                } else {
                    $current_status = "Closed";
                }
                return $current_status;
        }

        /**
         * Get the opening hours in the correct format.
         *
         * Either convert the hour values that are set through
         * a dropdown to a table, or wrap the textarea input in a <p>.
         *
         * Note: The opening hours can only be set in the textarea format by users who upgraded from 1.x.
         *
         * @since 2.0.0
         * @param  array|string $hours       The opening hours
         * @param  boolean      $hide_closed Hide the days were the location is closed
         * @return string       $hours       The formated opening hours
         */
        public function get_opening_hours( $hours, $hide_closed ) {

            $hours = maybe_unserialize( $hours );

            /*
             * If the hours are set through the dropdown then we create a table for the opening hours.
             * Otherwise we output the data entered in the textarea.
             */
            if ( is_array( $hours ) ) {
                $hours = $this->create_opening_hours_tabel( $hours, $hide_closed );
            } else {
                $hours = wp_kses_post( wpautop( $hours ) );
            }

            return $hours;
        }

        /**
         * Create a table for the opening hours.
         *
         * @since  2.0.0
         * @todo   add schema.org support.
         * @param  array   $hours       The opening hours
         * @param  boolean $hide_closed Hide the days where the location is closed
         * @return string  $hour_table  The opening hours sorted in a table
         */
        public function create_opening_hours_tabel( $hours, $hide_closed ) {

            $opening_days = wpsl_get_weekdays();

            // Make sure that we have actual opening hours, and not every day is empty.
            if ( $this->not_always_closed( $hours ) ) {
                $hour_table = '<table class="wpsl-opening-hours">';

                foreach ( $opening_days as $index => $day ) {
                    $i          = 0;
                    $hour_count = count( $hours[$index] );

                    // If we need to hide days that are set to closed then skip them.
                    if ( $hide_closed && !$hour_count ) {
                        continue;
                    }

                    $hour_table .= '<tr>';
                    $hour_table .= '<td>' . esc_html( $day ) . '</td>';

                    // If we have opening hours we show them, otherwise just show 'Closed'.
                    if ( $hour_count > 0 ) {
                        $hour_table .= '<td>';

                        while ( $i < $hour_count ) {
                            $hour        = explode( ',', $hours[$index][$i] );
                            $hour_table .= '<time>' . esc_html( $hour[0] ) . ' - ' . esc_html( $hour[1] ) . '</time>';

                            $i++;
                        }

                        $hour_table .= '</td>';
                    } else {
                        $hour_table .= '<td>' . __( 'Closed', 'wpsl' ) . '</td>';
                    }

                    $hour_table .= '</tr>';
                }

                $hour_table .= '</table>';

                return $hour_table;
            }
        }

        /**
         * Create the wpsl post type output.
         *
         * If you want to create a custom template you need to
         * create a single-wpsl_stores.php file in your theme folder.
         * You can see an example here https://wpstorelocator.co/document/create-custom-store-page-template/
         *
         * @since  2.0.0
         * @param  string $content
         * @return string $content
         */
        public function cpt_template( $content ) {

            global $wpsl_settings, $post;

            if ( isset( $post->post_type ) && $post->post_type == 'wpsl_stores' && is_single() && in_the_loop() ) {
                array_push( $this->load_scripts, 'wpsl_base' );

                $content .= '[wpsl_map]';
                $content .= '[wpsl_address]';

                if ( !$wpsl_settings['hide_hours'] ) {
                    $content .= '[wpsl_hours]';
                }
            }

            return $content;
        }

        /**
         * Handle the [wpsl] shortcode attributes.
         *
         * @since 2.1.1
         * @param array $atts Shortcode attributes
         */
        public function check_sl_shortcode_atts( $atts ) {

            // Change the category slugs into category ids.
            if ( isset( $atts['category'] ) && $atts['category'] ) {
                $term_ids = array();
                $cats     = explode( ',', $atts['category'] );

                foreach ( $cats as $key => $cat_slug ) {
                    $term_data = get_term_by( 'slug', $cat_slug, 'wpsl_store_category' );

                    if ( isset( $term_data->term_id ) && $term_data->term_id ) {
                        $term_ids[] = $term_data->term_id;
                    }
                }

                if ( $term_ids ) {
                    $this->sl_shortcode_atts['categoryIds'] = implode( ',', $term_ids );
                }
            }

            /*
             * Use a custom start location?
             *
             * If the provided location fails to geocode,
             * then the start location from the settings page is used.
             */
            if ( isset( $atts['start_location'] ) && $atts['start_location'] ) {
                $name_section   = explode( ',', $atts['start_location'] );
                $transient_name = 'wpsl_' . trim( strtolower( $name_section[0] ) ) . '_latlng';

                /*
                 * Check if we still need to geocode the start location,
                 * or if a transient with the start latlng already exists.
                 */
                if ( false === ( $start_latlng = get_transient( $transient_name ) ) ) {
                    $response = wpsl_call_geocode_api( $atts['start_location'] );

                    if ( !is_wp_error( $response ) ) {
                        $response = json_decode( $response['body'], true );

                        if ( $response['status'] == 'OK' ) {
                            $start_latlng = $response['results'][0]['geometry']['location']['lat'] . ',' . $response['results'][0]['geometry']['location']['lng'];

                            set_transient( $transient_name, $start_latlng, 0 );
                        }
                    }
                }

                if ( isset( $start_latlng ) && $start_latlng ) {
                    // @todo change the name of zoomLatLng into something that makes more sense like startLatLng in the JS / settings code!
                    $this->sl_shortcode_atts['zoomLatlng'] = $start_latlng;
                }
            }
        }

        /**
         * Handle the [wpsl] shortcode.
         *
         * @since 1.0.0
         * @param  array  $atts   Shortcode attributes
         * @return string $output The wpsl template
         */
        public function show_store_locator( $atts ) {

            global $wpsl_settings;

            $atts = shortcode_atts( array(
                'template'       => $wpsl_settings['template_id'],
                'category'       => '',
                'start_location' => ''
            ), $atts );

            $this->check_sl_shortcode_atts( $atts );

            // Make sure the required scripts are included for the wpsl shortcode.
            array_push( $this->load_scripts, 'wpsl_store_locator' );

            $template_list = wpsl_get_templates();
            $template_path = '';

            // Loop over the template list and look for a matching id with the one set on the settings page.
            foreach ( $template_list as $template ) {
                if ( $atts['template'] == $template['id'] ) {
                    $template_path = $template['path'];
                    break;
                }
            }

            // Check if we have a template path and the file exists, otherwise we use the default template.
            if ( !$template_path || ( !file_exists( $template_path ) ) ) {
                $template_path = WPSL_PLUGIN_DIR . 'frontend/templates/default.php';
            }

            $output = include( $template_path );

            return $output;
        }

        /**
         * Handle the [wpsl_address] shortcode.
         *
         * @since 2.0.0
         * @todo   add schema.org support.
         * @param  array       $atts   Shortcode attributes
         * @return void|string $output The store address
         */
        public function show_store_address( $atts ) {

            global $post, $wpsl_settings, $wpsl;

            $atts = $this->bool_check( shortcode_atts( apply_filters( 'wpsl_address_shortcode_defaults', array(
                'id'       => '',
                'name'     => true,
                'address'  => true,
                'address2' => true,
                'city'     => true,
                'state'    => true,
                'zip'      => true,
                'country'  => true,
                'phone'    => true,
                'fax'      => true,
                'email'    => true,
                'url'      => true
            ) ), $atts ) );

            if ( get_post_type() == 'wpsl_stores' ) {
                if ( empty( $atts['id'] ) ) {
                    if ( isset( $post->ID ) ) {
                        $atts['id'] = $post->ID;
                    } else {
                        return;
                    }
                }
            } else if ( empty( $atts['id'] ) ) {
                return __( 'If you use the [wpsl_address] shortcode outside a store page you need to set the ID attribute.', 'wpsl' );
            }

            $content = '<div class="wpsl-locations-details">';

            if ( $atts['name'] && $store_name = get_the_title( $atts['id'] ) ) {
                $content .= '<span><strong>' . esc_html( $store_name ) . '</strong></span>';
            }

            $content .= '<div class="wpsl-location-address">';

            if ( $atts['address'] && $store_address = get_post_meta( $atts['id'], 'wpsl_address', true ) ) {
                $content .= '<span>' . esc_html( $store_address ) . '</span><br/>';
            }

            if ( $atts['address2'] && $store_address2 = get_post_meta( $atts['id'], 'wpsl_address2', true ) ) {
                $content .= '<span>' . esc_html( $store_address2 ) . '</span><br/>';
            }

            $address_format = explode( '_', $wpsl_settings['address_format'] );
            $count = count( $address_format );
            $i = 1;

            // Loop over the address parts to make sure they are shown in the right order.
            foreach ( $address_format as $address_part ) {

                // Make sure the shortcode attribute is set to true for the $address_part, and it's not the 'comma' part.
                if ( $address_part != 'comma' && $atts[$address_part] ) {
                    $post_meta = get_post_meta( $atts['id'], 'wpsl_' . $address_part, true );

                    if ( $post_meta ) {

                        /*
                         * Check if the next part of the address is set to 'comma'.
                         * If so add the, after the current address part, otherwise just show a space
                         */
                        if ( isset( $address_format[$i] ) && ( $address_format[$i] == 'comma' ) ) {
                            $punctuation = ', ';
                        } else {
                            $punctuation = ' ';
                        }

                        // If we have reached the last item add a <br /> behind it.
                        $br = ( $count == $i ) ? '<br />' : '';

                        $content .= '<span>' . esc_html( $post_meta ) . $punctuation . '</span>' . $br;
                    }
                }

                $i++;
            }

            if ( $atts['country'] && $store_country = get_post_meta( $atts['id'], 'wpsl_country', true ) ) {
                $content .= '<span>' . esc_html( $store_country ) . '</span>';
            }

            $content .= '</div>';

            // If either the phone, fax, email or url is set to true, then add the wrap div for the contact details.
            if ( $atts['phone'] || $atts['fax'] || $atts['email'] || $atts['url'] ) {
                $content .= '<div class="wpsl-contact-details">';

                if ( $atts['phone'] && $store_phone = get_post_meta( $atts['id'], 'wpsl_phone', true ) ) {
                    $content .= esc_html( $wpsl->i18n->get_translation( 'phone_label', __( 'Phone', 'wpsl' ) ) ) . ': <span>' . esc_html( $store_phone ) . '</span><br/>';
                }

                if ( $atts['fax'] && $store_fax = get_post_meta( $atts['id'], 'wpsl_fax', true ) ) {
                    $content .= esc_html( $wpsl->i18n->get_translation( 'fax_label', __( 'Fax', 'wpsl' ) ) ) . ': <span>' . esc_html( $store_fax ) . '</span><br/>';
                }

                if ( $atts['email'] && $store_email = get_post_meta( $atts['id'], 'wpsl_email', true ) ) {
                    $content .= esc_html( $wpsl->i18n->get_translation( 'email_label', __( 'Email', 'wpsl' ) ) ) . ': <span>' . sanitize_email( $store_email ) . '</span><br/>';
                }

                if ( $atts['url'] && $store_url = get_post_meta( $atts['id'], 'wpsl_url', true ) ) {
                    $new_window = ( $wpsl_settings['new_window'] ) ? 'target="_blank"' : '' ;
                    $content   .= esc_html( $wpsl->i18n->get_translation( 'url_label', __( 'Url', 'wpsl' ) ) ) . ': <a ' . $new_window . ' href="' . esc_url( $store_url ) . '">' . esc_url( $store_url ) . '</a><br/>';
                }

                $content .= '</div>';
            }

            $content .= '</div>';

            return $content;
        }

        /**
         * Handle the [wpsl_hours] shortcode.
         *
         * @since 2.0.0
         * @param  array       $atts   Shortcode attributes
         * @return void|string $output The opening hours
         */
        public function show_opening_hours( $atts ) {

            global $post;

            $atts = $this->bool_check( shortcode_atts( apply_filters( 'wpsl_hour_shortcode_defaults', array(
                'id'          => '',
                'hide_closed' => false
            ) ), $atts ) );

            if ( get_post_type() == 'wpsl_stores' ) {
                if ( empty( $atts['id'] ) ) {
                    if ( isset( $post->ID ) ) {
                        $atts['id'] = $post->ID;
                    } else {
                        return;
                    }
                }
            } else if ( empty( $atts['id'] ) ) {
                return __( 'If you use the [wpsl_hours] shortcode outside a store page you need to set the ID attribute.', 'wpsl' );
            }

            $opening_hours = get_post_meta( $atts['id'], 'wpsl_hours' );

            if ( $opening_hours ) {
                $output = $this->get_opening_hours( $opening_hours[0], $atts['hide_closed'] );

                return $output;
            }
        }

        /**
         * Make sure the shortcode attributes are booleans
         * when they are expected to be.
         *
         * @since 2.0.4
         * @param  array $atts Shortcode attributes
         * @return array $atts Shortcode attributes
         */
        public function bool_check( $atts ) {

            foreach ( $atts as $key => $val ) {
                if ( in_array( $val, array( 'true', '1', 'yes', 'on' ) ) ) {
                    $atts[$key] = true;
                } else if ( in_array( $val, array( 'false', '0', 'no', 'off' ) ) ) {
                    $atts[$key] = false;
                }
            }

            return $atts;
        }

        /**
         * Handle the [wpsl_map] shortcode.
         *
         * @since 2.0.0
         * @param  array  $atts   Shortcode attributes
         * @return string $output The html for the map
         */
        public function show_store_map( $atts ) {

            global $wpsl_settings, $post;

            $atts = shortcode_atts( apply_filters( 'wpsl_map_shortcode_defaults', array(
                'id'               => '',
                'category'         => '',
                'width'            => '',
                'height'           => $wpsl_settings['height'],
                'zoom'             => $wpsl_settings['zoom_level'],
                'map_type'         => $wpsl_settings['map_type'],
                'map_type_control' => $wpsl_settings['type_control'],
                'map_style'        => '',
                'street_view'      => $wpsl_settings['streetview'],
                'scrollwheel'      => $wpsl_settings['scrollwheel'],
                'control_position' => $wpsl_settings['control_position']
            ) ), $atts );

            array_push( $this->load_scripts, 'wpsl_base' );

            if ( get_post_type() == 'wpsl_stores' ) {
                if ( empty( $atts['id'] ) ) {
                    if ( isset( $post->ID ) ) {
                        $atts['id'] = $post->ID;
                    } else {
                        return;
                    }
                }
            } else if ( empty( $atts['id'] ) && empty( $atts['category'] ) ) {
                return __( 'If you use the [wpsl_map] shortcode outside a store page, then you need to set the ID or category attribute.', 'wpsl' );
            }

            if ( $atts['category'] ) {
                $store_ids = get_posts( array(
                    'numberposts' => -1,
                    'post_type'   => 'wpsl_stores',
                    'post_status' => 'publish',
                    'tax_query'   => array(
                        array(
                            'taxonomy' => 'wpsl_store_category',
                            'field'    => 'slug',
                            'terms'    => explode( ',', sanitize_text_field( $atts['category'] ) )
                        ),
                    ),
                    'fields'      => 'ids'
                ) );
            } else {
                $store_ids = array_map( 'absint', explode( ',', $atts['id'] ) );
                $id_count  = count( $store_ids );
            }

            /*
             * The location url is included if:
             *
             * - Multiple ids are set.
             * - The category attr is set.
             * - The shortcode is used on a post type other then 'wpsl_stores'. No point in showing a location
             * url to the user that links back to the page they are already on.
             */
            if ( $atts['category'] || isset( $id_count ) && $id_count > 1 || get_post_type() != 'wpsl_stores' && !empty( $atts['id'] ) ) {
                $incl_url = true;
            } else {
                $incl_url = false;
            }

            $store_meta = array();
            $i          = 0;

            foreach ( $store_ids as $store_id ) {
                $lat = get_post_meta( $store_id, 'wpsl_lat', true );
                $lng = get_post_meta( $store_id, 'wpsl_lng', true );

                // Make sure the latlng is numeric before collecting the other meta data.
                if ( is_numeric( $lat ) && is_numeric( $lng ) ) {
                    $store_meta[$i] = apply_filters( 'wpsl_cpt_info_window_meta_fields', array(
                        'store'    => get_the_title( $store_id ),
                        'address'  => get_post_meta( $store_id, 'wpsl_address',  true ),
                        'address2' => get_post_meta( $store_id, 'wpsl_address2', true ),
                        'city'     => get_post_meta( $store_id, 'wpsl_city',     true ),
                        'state'    => get_post_meta( $store_id, 'wpsl_state',    true ),
                        'zip'      => get_post_meta( $store_id, 'wpsl_zip',      true ),
                        'country'  => get_post_meta( $store_id, 'wpsl_country',  true )
                    ), $store_id );

                    // Grab the permalink / url if necessary.
                    if ( $incl_url ) {
                        if ( $wpsl_settings['permalinks'] ) {
                            $store_meta[$i]['permalink'] = get_permalink( $store_id );
                        } else {
                            $store_meta[$i]['url'] = get_post_meta( $store_id, 'wpsl_url', true );
                        }
                    }

                    $store_meta[$i]['lat'] = $lat;
                    $store_meta[$i]['lng'] = $lng;
                    $store_meta[$i]['id']  = $store_id;

                    $i++;
                }
            }

            $output = '<div id="wpsl-base-gmap_' . self::$map_count . '" class="wpsl-gmap-canvas"></div>' . "\r\n";

            // Make sure the shortcode attributes are valid.
            $map_styles = $this->check_map_shortcode_atts( $atts );

            if ( $map_styles ) {
                if ( isset( $map_styles['css'] ) && !empty( $map_styles['css'] ) ) {
                    $output .= '<style>' . $map_styles['css'] . '</style>' . "\r\n";
                    unset( $map_styles['css'] );
                }

                if ( $map_styles ) {
                    $store_data['shortCode'] = $map_styles;
                }
            }

            $store_data['locations'] = $store_meta;

            $this->store_map_data[self::$map_count] = $store_data;

            self::$map_count++;

            return $output;
        }

        /**
         * Make sure the map style shortcode attributes are valid.
         *
         * The values are send to wp_localize_script in add_frontend_scripts.
         *
         * @since 2.0.0
         * @param  array $atts     The map style shortcode attributes
         * @return array $map_atts Validated map style shortcode attributes
         */
        public function check_map_shortcode_atts( $atts ) {

            $map_atts = array();

            if ( isset( $atts['width'] ) && is_numeric( $atts['width'] ) ) {
                $width = 'width:' . $atts['width'] . 'px;';
            } else {
                $width = '';
            }

            if ( isset( $atts['height'] ) && is_numeric( $atts['height'] ) ) {
                $height = 'height:' . $atts['height'] . 'px;';
            } else {
                $height = '';
            }

            if ( $width || $height ) {
                $map_atts['css'] = '#wpsl-base-gmap_' . self::$map_count . ' {' . $width . $height . '}';
            }

            if ( isset( $atts['zoom'] ) && !empty( $atts['zoom'] ) ) {
                $map_atts['zoomLevel'] = wpsl_valid_zoom_level( $atts['zoom'] );
            }

            if ( isset( $atts['map_type'] ) && !empty( $atts['map_type'] ) ) {
                $map_atts['mapType'] = wpsl_valid_map_type( $atts['map_type'] );
            }

            if ( isset( $atts['map_type_control'] ) ) {
                $map_atts['mapTypeControl'] = $this->shortcode_atts_boolean( $atts['map_type_control'] );
            }

            if ( isset( $atts['map_style'] ) && $atts['map_style'] == 'default' ) {
                $map_atts['mapStyle'] = '';
            }

            if ( isset( $atts['street_view'] ) ) {
                $map_atts['streetView'] = $this->shortcode_atts_boolean( $atts['street_view'] );
            }

            if ( isset( $atts['scrollwheel'] ) ) {
                $map_atts['scrollWheel'] = $this->shortcode_atts_boolean( $atts['scrollwheel'] );
            }

            if ( isset( $atts['control_position'] ) && !empty( $atts['control_position'] ) && ( $atts['control_position'] == 'left' || $atts['control_position'] == 'right' ) ) {
                $map_atts['controlPosition'] = $atts['control_position'];
            }

            return $map_atts;
        }

        /**
         * Set the shortcode attribute to either 1 or 0.
         *
         * @since 2.0.0
         * @param  string $att     The shortcode attribute val
         * @return int    $att_val Either 1 or 0
         */
        public function shortcode_atts_boolean( $att ) {

            if ( $att === 'true' || absint( $att ) ) {
                $att_val = 1;
            } else {
                $att_val = 0;
            }

            return $att_val;
        }

        /**
         * Make sure the filter contains a valid value, otherwise use the default value.
         *
         * @since 2.0.0
         * @return string $filter_value The filter value
         */
        public function check_store_filter( $filter ) {

            if ( isset( $_GET[$filter] ) && absint( $_GET[$filter] ) ) {
                $filter_value = $_GET[$filter];
            } else {
                $filter_value = $this->get_default_filter_value( $filter );
            }

            return $filter_value;
        }

        /**
         * Get the default selected value for a dropdown.
         *
         * @since 1.0.0
         * @param  string $type     The request list type
         * @return string $response The default list value
         */
       public function get_default_filter_value( $type ) {

           $settings    = get_option( 'wpsl_settings' );
           $list_values = explode( ',', $settings[$type] );

           foreach ( $list_values as $k => $list_value ) {

               // The default radius has a [] wrapped around it, so we check for that and filter out the [].
               if ( strpos( $list_value, '[' ) !== false ) {
                   $response = filter_var( $list_value, FILTER_SANITIZE_NUMBER_INT );
                   break;
               }
           }

           return $response;
       }

        /**
         * Check if we have a opening day that has an value, if not they are all set to closed.
         *
         * @since 2.0.0
         * @param  array   $opening_hours The opening hours
         * @return boolean True if a day is found that isn't empty
         */
        public function not_always_closed( $opening_hours ) {

            foreach ( $opening_hours as $hours => $hour ) {
                if ( !empty( $hour ) ) {
                    return true;
                }
            }
        }

        /**
         * Create the css rules based on the height / max-width that is set on the settings page.
         *
         * @since 1.0.0
         * @return string $css The custom css rules
         */
        public function get_custom_css() {

            global $wpsl_settings;

            $thumb_size = $this->get_store_thumb_size();

            $css = '<style>' . "\r\n";

            if ( isset( $thumb_size[0] ) && is_numeric( $thumb_size[0] ) && isset( $thumb_size[1] ) && is_numeric( $thumb_size[1] ) ) {
                //$css .= "\t" . "#wpsl-stores .wpsl-store-thumb {height:" . esc_attr( $thumb_size[0] ) . "px !important; width:" . esc_attr( $thumb_size[1] ) . "px !important;}" . "\r\n";
            }

            if ( $wpsl_settings['template_id'] == 'below_map' && $wpsl_settings['listing_below_no_scroll'] ) {
                $css .= "\t" . "#wpsl-gmap {height:" . esc_attr( $wpsl_settings['height'] ) . "px !important;}" . "\r\n";
                $css .= "\t" . "#wpsl-stores, #wpsl-direction-details {height:auto !important;}";
            } else {
                $css .= "\t" . "#wpsl-stores, #wpsl-direction-details, #wpsl-gmap {height:" . esc_attr( $wpsl_settings['height'] ) . "px !important;}" . "\r\n";
            }

            /*
             * If the category dropdowns are enabled then we make it
             * the same width as the search input field.
             */
            if ( $wpsl_settings['category_dropdown'] ) {
                $cat_elem = ',#wpsl-category .wpsl-dropdown';
            } else {
                $cat_elem = '';
            }

            $css .= "\t" . "#wpsl-gmap .wpsl-info-window {max-width:" . esc_attr( $wpsl_settings['infowindow_width'] ) . "px !important;}" . "\r\n";
            $css .= "\t" . ".wpsl-input label, #wpsl-radius label, #wpsl-category label {width:" . esc_attr( $wpsl_settings['label_width'] ) . "px;}" . "\r\n";
            $css .= "\t" . "#wpsl-search-input " . $cat_elem . " {width:" . esc_attr( $wpsl_settings['search_width'] ) . "px;}" . "\r\n";
            $css .= '</style>' . "\r\n";

            return $css;
        }

        /**
         * Collect the CSS classes that are placed on the outer store locator div.
         *
         * @since 2.0.0
         * @return string $classes The custom CSS rules
         */
        public function get_css_classes() {

            global $wpsl_settings;

            $classes = array();

            if ( $wpsl_settings['category_dropdown'] && $wpsl_settings['results_dropdown'] && !$wpsl_settings['radius_dropdown'] ) {
                $classes[] = 'wpsl-cat-results-filter';
            } else if ( $wpsl_settings['category_dropdown'] && ( $wpsl_settings['results_dropdown'] || $wpsl_settings['radius_dropdown'] ) ) {
                $classes[] = 'wpsl-filter';
            }

            if ( !$wpsl_settings['category_dropdown'] && !$wpsl_settings['results_dropdown'] && !$wpsl_settings['radius_dropdown'] ) {
                $classes[] = 'wpsl-no-filters';
            }

            if ( $wpsl_settings['results_dropdown'] && !$wpsl_settings['category_dropdown'] && !$wpsl_settings['radius_dropdown'] ) {
                $classes[] = 'wpsl-results-only';
            }

            $classes = apply_filters( 'wpsl_template_css_classes', $classes );

            if ( !empty( $classes ) ) {
                return join( ' ', $classes );
            }
        }

        /**
         * Collect all the attributes (language, key, region)
         * we need before making a request to the Google Maps API.
         *
         * @since 1.0.0
         * @param  string $list_type     The name of the list we need to load data for
         * @return string $dropdown_list A list with the available options for the dropdown list
         */
        public function get_dropdown_list( $list_type ) {

            global $wpsl_settings;

            $dropdown_list = '';
            $settings      = explode( ',', $wpsl_settings[$list_type] );

            // Only show the distance unit if we are dealing with the search radius.
            if ( $list_type == 'search_radius' ) {
                $distance_unit = ' '. esc_attr( $wpsl_settings['distance_unit'] );
            } else {
                $distance_unit = '';
            }

            foreach ( $settings as $index => $setting_value ) {

                // The default radius has a [] wrapped around it, so we check for that and filter out the [].
                if ( strpos( $setting_value, '[' ) !== false ) {
                    $setting_value = filter_var( $setting_value, FILTER_SANITIZE_NUMBER_INT );
                    $selected = 'selected="selected" ';
                } else {
                    $selected = '';
                }

                $dropdown_list .= '<option ' . $selected . 'value="'. absint( $setting_value ) .'">'. absint( $setting_value ) . $distance_unit .'</option>';
            }

            return $dropdown_list;
        }

        /**
         * Create the category filter.
         *
         * @since 2.0.0
         * @return string|void $category The HTML for the category dropdown, or nothing if no terms exist.
         */
        public function create_category_filter() {

            global $wpsl;

            /*
             * If the category attr is set on the wpsl shortcode, then
             * there is no need to ouput an extra category dropdown.
             */
            if ( isset( $this->sl_shortcode_atts['categoryIds'] ) ) {
                return;
            }

            $terms = get_terms( 'wpsl_store_category' );

            if ( count( $terms ) > 0 ) {
                $category = '<div id="wpsl-category">' . "\r\n";
                $category .= '<label for="wpsl-category-list">' . esc_html( $wpsl->i18n->get_translation( 'category_label', __( 'Category', 'wpsl' ) ) ) . '</label>' . "\r\n";
                $category .= '<select autocomplete="off" name="wpsl-category" id="wpsl-category-list" class="wpsl-dropdown">';
                $category .= '<option value="0">'. __( 'Any' , 'wpsl' ) .'</option>';

                foreach ( $terms as $term ) {
                    $category .= '<option value="' . $term->term_id . '" '. $this->set_selected_category( $term->term_id ) .'>' . $term->name . '</option>';
                }

                $category .= '</select>';
                $category .= '</div>' . "\r\n";

                return $category;
            }
        }

        /**
         * Set the selected category item.
         *
         * @since 2.1.2
         * @todo add support to make it check a query string for set cat
         * @param integer The term id.
         * @return string|void $category The 'selected' attribute or nothing.
         */
        public function set_selected_category( $term_id ) {

            $selected = apply_filters( 'wpsl_selected_category', $term_id );

            if ( $selected ) {
                return $selected;
            }
        }

        /**
         * Create a filename with @2x in it for the selected marker color.
         *
         * So when a user selected green.png in the admin panel. The JS on the front-end will end up
         * loading green@2x.png to provide support for retina compatible devices.
         *
         * @since 1.0.0
         * @param  string $filename The name of the seleted marker
         * @return string $filename The filename with @2x added to the end
         */
        public function create_retina_filename( $filename ) {

            $filename = explode( '.', $filename );
            $filename = $filename[0] . '@2x.' . $filename[1];

            return $filename;
        }

        /**
         * Get the default values for the max_results and the search_radius dropdown.
         *
         * @since 1.0.2
         * @return array $output The default dropdown values
         */
        public function get_dropdown_defaults() {

            global $wpsl_settings;

            $required_defaults = array(
                'max_results',
                'search_radius'
            );

            // Strip out the default values that are wrapped in [].
            foreach ( $required_defaults as $required_default ) {
                preg_match_all( '/\[([0-9]+?)\]/', $wpsl_settings[$required_default], $match, PREG_PATTERN_ORDER );
                $output[$required_default] = $match[1][0];
            }

            return $output;
        }

        /**
         * Load the required css styles.
         *
         * @since 2.0.0
         * @return void
         */
        public function add_frontend_styles() {

            $min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

            wp_enqueue_style( 'wpsl-styles', WPSL_URL . 'css/styles'. $min .'.css', '', WPSL_VERSION_NUM );
            wp_enqueue_style( 'dashicons' );
        }

        /**
         * Get the HTML for the map controls.
         *
         * The '&#xe800;' and '&#xe801;' code is for the icon font from fontello.com
         *
         * @since 2.0.0
         * @return string The HTML for the map controls
         */
        public function get_map_controls() {

            global $wpsl_settings, $is_IE;

            $classes = array();

            if ( $wpsl_settings['reset_map'] ) {
                $reset_button = '<div class="wpsl-icon-reset"><span>&#xe801;</span></div>';
            } else {
                $reset_button = '';
            }

            /*
             * IE messes up the top padding for the icon fonts from fontello >_<.
             *
             * Luckily it's the same in all IE version ( 8-11 ),
             * so adjusting the padding just for IE fixes it.
             */
            if ( $is_IE ) {
                $classes[] = 'wpsl-ie';
            }

            // If the street view option is enabled, then we need to adjust the right margin for the map control div.
            if ( $wpsl_settings['streetview'] ) {
                $classes[] = 'wpsl-street-view-exists';
            }

            if ( !empty( $classes ) ) {
                $class = 'class="' . join( ' ', $classes ) . '"';
            } else {
                $class = '';
            }

            $map_controls = '<div id="wpsl-map-controls" ' . $class . '>' . $reset_button . '<div class="wpsl-icon-direction"><span>&#xe800;</span></div></div>';

            return apply_filters( 'wpsl_map_controls', $map_controls );
        }

        /**
         * The different geolocation errors.
         *
         * They are shown when the Geolocation API returns an error.
         *
         * @since 2.0.0
         * @return array $geolocation_errors
         */
        public function geolocation_errors() {

            $geolocation_errors = array(
                'denied'       => __( 'The application does not have permission to use the Geolocation API.', 'wpsl' ),
                'unavailable'  => __( 'Location information is unavailable.', 'wpsl' ),
                'timeout'      => __( 'The geolocation request timed out.', 'wpsl' ),
                'generalError' => __( 'An unknown error occurred.', 'wpsl' )
            );

            return $geolocation_errors;
        }

        /**
         * Get the used marker properties.
         *
         * @since 2.1.0
         * @link https://developers.google.com/maps/documentation/javascript/3.exp/reference#Icon
         * @return array $marker_props The marker properties.
         */
        public function get_marker_props() {

            $marker_props = apply_filters( 'wpsl_marker_props', array(
                'scaledSize' => '24,35', // 50% of the normal image to make it work on retina screens.
                'origin'     => '0,0',
                'anchor'     => '12,35'
            ) );

            /*
             * If this is not defined, the url path will default to
             * the url path of the WPSL plugin folder + /img/markers/
             * in the wpsl-gmap.js.
             */
            if ( defined( 'WPSL_MARKER_URI' ) ) {
                $marker_props['url'] = WPSL_MARKER_URI;
            }

            return $marker_props;
        }

        /**
         * Check if the map is draggable.
         *
         * @since 2.1.0
         * @return array $draggable The draggable options.
         */
        public function maybe_draggable() {

            $draggable = apply_filters( 'wpsl_draggable_map', array(
                'enabled'    => true,
                'disableRes' => '675' // breakpoint where the dragging is disabled in px.
            ) );

            return $draggable;
        }

        /**
         * Load the required JS scripts.
         *
         * @since 1.0.0
         * @return void
         */
        public function add_frontend_scripts() {

            global $wpsl_settings, $wpsl;

            // Only load the required js files on the store locator page or individual store pages.
            if ( empty( $this->load_scripts ) ) {
                return;
            }

            $min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

            $dropdown_defaults = $this->get_dropdown_defaults();

            wp_enqueue_script( 'wpsl-gmap', ( 'https://maps.google.com/maps/api/js' . wpsl_get_gmap_api_params() ), '', null, true );

            $base_settings = array(
                'storeMarker'     => $this->create_retina_filename( $wpsl_settings['store_marker'] ),
                'mapType'         => $wpsl_settings['map_type'],
                'mapTypeControl'  => $wpsl_settings['type_control'],
                'zoomLevel'       => $wpsl_settings['zoom_level'],
                'zoomLatlng'      => $wpsl_settings['zoom_latlng'], // @todo change name into startLatlng
                'autoZoomLevel'   => $wpsl_settings['auto_zoom_level'],
                'scrollWheel'     => $wpsl_settings['scrollwheel'],
                'controlPosition' => $wpsl_settings['control_position'],
                'url'             => WPSL_URL,
                'markerIconProps' => $this->get_marker_props(),
                'draggable'       => $this->maybe_draggable(),
                'storeUrl'        => $wpsl_settings['store_url'],
                'mapTabAnchor'    => apply_filters( 'wpsl_map_tab_anchor', 'wpsl-map-tab' )
            );

            $locator_map_settings = array(
                'startMarker'       => $this->create_retina_filename( $wpsl_settings['start_marker'] ),
                'markerClusters'    => $wpsl_settings['marker_clusters'],
                'streetView'        => $wpsl_settings['streetview'],
                'autoLocate'        => $wpsl_settings['auto_locate'],
                'autoLoad'          => $wpsl_settings['autoload'],
                'markerEffect'      => $wpsl_settings['marker_effect'],
                'markerStreetView'  => $wpsl_settings['marker_streetview'],
                'markerZoomTo'      => $wpsl_settings['marker_zoom_to'],
                'newWindow'         => $wpsl_settings['new_window'],
                'resetMap'          => $wpsl_settings['reset_map'],
                'directionRedirect' => $wpsl_settings['direction_redirect'],
                'phoneUrl'          => $wpsl_settings['phone_url'],
                'moreInfoLocation'  => $wpsl_settings['more_info_location'],
                'mouseFocus'        => $wpsl_settings['mouse_focus'],
                'templateId'        => $wpsl_settings['template_id'],
                'maxResults'        => $dropdown_defaults['max_results'],
                'searchRadius'      => $dropdown_defaults['search_radius'],
                'distanceUnit'      => $wpsl_settings['distance_unit'],
                'geoLocationTimout' => apply_filters( 'wpsl_geolocation_timeout', 5000 ),
                'ajaxurl'           => admin_url( 'admin-ajax.php' ),
                'mapControls'       => $this->get_map_controls()
            );

            /*
             * If enabled, include the component filter settings.
             *
             * See https://developers.google.com/maps/documentation/javascript/geocoding#ComponentFiltering
             */
            if ( $wpsl_settings['api_region'] && $wpsl_settings['api_geocode_component'] ) {
                $locator_map_settings['geocodeComponents'] = apply_filters( 'wpsl_geocode_components', array(
                    'country' => strtoupper( $wpsl_settings['api_region'] )
                ) );
            }

            // If the marker clusters are enabled, include the js file and marker settings.
            if ( $wpsl_settings['marker_clusters'] ) {
                wp_enqueue_script( 'wpsl-cluster', WPSL_URL . 'js/markerclusterer'. $min .'.js', '', WPSL_VERSION_NUM, true  ); //not minified version is in the /js folder

                $base_settings['clusterZoom'] = $wpsl_settings['cluster_zoom'];
                $base_settings['clusterSize'] = $wpsl_settings['cluster_size'];
            }

            // Check if we need to include the infobox script and settings.
            if ( $wpsl_settings['infowindow_style'] == 'infobox' ) {
                wp_enqueue_script( 'wpsl-infobox', WPSL_URL . 'js/infobox'. $min .'.js', array( 'wpsl-gmap' ), WPSL_VERSION_NUM, true  ); // Not minified version is in the /js folder

                $base_settings['infoWindowStyle'] = $wpsl_settings['infowindow_style'];
                $base_settings = $this->get_infobox_settings( $base_settings );
            }

            // Include the map style.
            if ( !empty( $wpsl_settings['map_style'] ) ) {
                $base_settings['mapStyle'] = strip_tags( stripslashes( json_decode( $wpsl_settings['map_style'] ) ) );
            }

            wp_enqueue_script( 'wpsl-js', WPSL_URL . 'js/wpsl-gmap.js', array( 'jquery' ), WPSL_VERSION_NUM, true );
            // wp_enqueue_script( 'wpsl-js', WPSL_URL . 'js/wpsl-gmap'. $min .'.js', array( 'jquery' ), WPSL_VERSION_NUM, true );
            wp_enqueue_script( 'underscore' );

            // Check if we need to include all the settings and labels or just a part of them.
            if ( in_array( 'wpsl_store_locator', $this->load_scripts ) ) {
                $settings = wp_parse_args( $base_settings, $locator_map_settings );
                $template = 'wpsl_store_locator';
                $labels   = array(
                    'preloader'         => $wpsl->i18n->get_translation( 'preloader_label', __( 'Searching...', 'wpsl' ) ),
                    'noResults'         => $wpsl->i18n->get_translation( 'no_results_label', __( 'No results found', 'wpsl' ) ),
                    'moreInfo'          => $wpsl->i18n->get_translation( 'more_label', __( 'More info', 'wpsl' ) ),
                    'generalError'      => $wpsl->i18n->get_translation( 'error_label', __( 'Something went wrong, please try again!', 'wpsl' ) ),
                    'queryLimit'        => $wpsl->i18n->get_translation( 'limit_label', __( 'API usage limit reached', 'wpsl' ) ),
                    'directions'        => $wpsl->i18n->get_translation( 'directions_label', __( 'Directions', 'wpsl' ) ),
                    'noDirectionsFound' => $wpsl->i18n->get_translation( 'no_directions_label', __( 'No route could be found between the origin and destination', 'wpsl' ) ),
                    'startPoint'        => $wpsl->i18n->get_translation( 'start_label', __( 'Start location', 'wpsl' ) ),
                    'back'              => $wpsl->i18n->get_translation( 'back_label', __( 'Back', 'wpsl' ) ),
                    'streetView'        => $wpsl->i18n->get_translation( 'street_view_label', __( 'Street view', 'wpsl' ) ),
                    'zoomHere'          => $wpsl->i18n->get_translation( 'zoom_here_label', __( 'Zoom here', 'wpsl' ) )
                );

                wp_localize_script( 'wpsl-js', 'wpslLabels', $labels );
                wp_localize_script( 'wpsl-js', 'wpslGeolocationErrors', $this->geolocation_errors() );
            } else {
                $template = '';
                $settings = $base_settings;
            }

            // Check if we need to overwrite settings that are set through the [wpsl] shortcode.
            if ( $this->sl_shortcode_atts ) {
                foreach ( $this->sl_shortcode_atts as $shortcode_key => $shortcode_val ) {
                    $settings[$shortcode_key] = $shortcode_val;
                }
            }

            wp_localize_script( 'wpsl-js', 'wpslSettings', $settings );

            wpsl_create_underscore_templates( $template );

            if ( !empty( $this->store_map_data ) ) {
                $i = 0;

                foreach ( $this->store_map_data as $map ) {
                    wp_localize_script( 'wpsl-js', 'wpslMap_' . $i, $map );

                    $i++;
                }
            }
        }

        /**
         * Get the infobox settings.
         *
         * @since 2.0.0
         * @see http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/docs/reference.html
         * @param  array $settings The plugin settings used on the front-end in js
         * @return array $settings The plugin settings including the infobox settings
         */
        public function get_infobox_settings( $settings ) {

            $infobox_settings = apply_filters( 'wpsl_infobox_settings', array(
                'infoBoxClass'                  => 'wpsl-infobox',
                'infoBoxCloseMargin'            => '2px', // The margin can be written in css style, so 2px 2px 4px 2px for top, right, bottom, left
                'infoBoxCloseUrl'               => '//www.google.com/intl/en_us/mapfiles/close.gif',
                'infoBoxClearance'              => '40,40',
                'infoBoxDisableAutoPan'         => 0,
                'infoBoxEnableEventPropagation' => 0,
                'infoBoxPixelOffset'            => '-52,-45',
                'infoBoxZindex'                 => 1500
            ) );

            foreach ( $infobox_settings as $infobox_key => $infobox_setting ) {
                $settings[$infobox_key] = $infobox_setting;
            }

            return $settings;
        }

    }

    new WPSL_Frontend();
}
