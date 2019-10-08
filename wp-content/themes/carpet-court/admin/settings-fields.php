<?php
Redux::setSection( $opt_name, array(
    'title' => __( 'General Settings', 'carpet-court' ),
    'id'    => 'general',
    'icon'  => 'el el-home',
    'fields'     => array(
        array(
            'id'        => 'logo',
            'type'      => 'media',
            'title'     => __( 'Logo', 'carpet-court' ),
            'width'     => 300,
            'height'    => 70,
            'default'   => array(
                'url'       => get_template_directory_uri().'/images/logo.png',
                'width'     =>368,
                'height'    =>51,
                )
            ),
        array(
            'id'       => 'favicon',
            'type'     => 'media',
            'title'    => __( 'Fav Icon', 'carpet-court' ),
            ),
        )
    ) );

Redux::setSection( $opt_name, array(
    'title' => __( 'Header Menu Settings', 'carpet-court' ),
    'id'    => 'header-menu',
    'icon'  => 'el el-website',
    'fields'     => array(
        array(
            'id'       => 'menu-opt-switch',
            'type'     => 'switch',
            'title'    => __('Enable Ubermenu?', 'carpet-court'),
            'subtitle' => __('Enable to use ubermenu instead of simple one.', 'carpet-court'),
            'default'  => false,
            ),
        array(
            'id'       => 'sticky-header',
            'type'     => 'checkbox',
            'title'    => __( 'Sticky Header?', 'carpet-court' ),
            'default'  => '1'
            ),
        array(
            'id'       => 'nav-background-color',
            'type'     => 'color_rgba',
            'output'   => array( 'background-color' => '.site-header>#cc-navbar'),
            'title'    => __( 'Header background Color', 'carpet-court' ),
            'default'   => array(
                'color'     => '#fdfdfd',
                'alpha'     => 1
                ),
            'options'       => array(
                'show_input'                => true,
                'show_initial'              => true,
                'show_alpha'                => true,
                'show_palette'              => true,
                'show_palette_only'         => false,
                'show_selection_palette'    => true,
                'max_palette_size'          => 10,
                'allow_empty'               => true,
                'clickout_fires_change'     => false,
                'choose_text'               => 'Choose',
                'cancel_text'               => 'Cancel',
                'show_buttons'              => true,
                'use_extended_classes'      => true,
                    'palette'                   => null,  // show default
                    'input_text'                => 'Select Color'
                    ),
            ),
        array(
            'id'       => 'nav-color-non-overlap',
            'type'     => 'color_rgba',
            'output'   => array( 'background-color' => '.no-overlap .site-header>#cc-navbar'),
            'title'    => __( 'Header background Color for non overlapping pages', 'carpet-court' ),
            'default'   => array(
                'color'     => '#fdfdfd',
                'alpha'     => 1
                ),
            'options'       => array(
                'show_input'                => true,
                'show_initial'              => true,
                'show_alpha'                => true,
                'show_palette'              => true,
                'show_palette_only'         => false,
                'show_selection_palette'    => true,
                'max_palette_size'          => 10,
                'allow_empty'               => true,
                'clickout_fires_change'     => false,
                'choose_text'               => 'Choose',
                'cancel_text'               => 'Cancel',
                'show_buttons'              => true,
                'use_extended_classes'      => true,
                    'palette'                   => null,  // show default
                    'input_text'                => 'Select Color'
                    ),
            ),
        array(
            'id'       => 'nav-color-sticky',
            'type'     => 'color_rgba',
            'output'   => array( 'background-color' => '.site-header #cc-navbar.navbar.shrink'),
            'title'    => __( 'Header background Color after Sticky', 'carpet-court' ),
            'default'   => array(
                'color'     => '#fdfdfd',
                'alpha'     => 1
                ),
            'options'       => array(
                'show_input'                => true,
                'show_initial'              => true,
                'show_alpha'                => true,
                'show_palette'              => true,
                'show_palette_only'         => false,
                'show_selection_palette'    => true,
                'max_palette_size'          => 10,
                'allow_empty'               => true,
                'clickout_fires_change'     => false,
                'choose_text'               => 'Choose',
                'cancel_text'               => 'Cancel',
                'show_buttons'              => true,
                'use_extended_classes'      => true,
                    'palette'                   => null,  // show default
                    'input_text'                => 'Select Color'
                    ),
            ),
        )
) );

Redux::setSection( $opt_name, array(
    'title' => __( 'Footer Settings', 'carpet-court' ),
    'id'    => 'footer',
    'icon'  => 'el el-website',
    'fields'     => array(
        array(
            'id'        => 'footer_logo',
            'type'      => 'media',
            'title'     => __( 'Footer Logo', 'carpet-court' ),
            ),
        array(
            'id'       => 'show_custom_logo',
            'type'     => 'checkbox',
            'title'    => __( 'Show Custom Logo?', 'carpet-court' ),
                // 'default'  => '1'
            ),
        array(
            'id'        => 'footer_custom_logo',
            'type'      => 'media',
            'title'     => __( 'Footer Custom Logo', 'carpet-court' ),
            ),
        array(
            'type'      => 'text',
            'id'        => 'footer_custom_link',
            'title'     => __('Link To Custom Logo','carpet-court'),
            'placeholder'   =>__('Enter Link','carpet-court'),
            ),
        array(
            'id'               => 'site_info',
            'type'             => 'textarea',
            'title'            => __('Site Info', 'carpet-court'),
            'args'   => array(
                'teeny'            => true,
                'textarea_rows'    => 8,
                'media_buttons'    => false,
                ),
            ),
        array(
            'type'      => 'text',
            'id'        => 'contact_tel',
            'title'     => __('Contact Number','carpet-court'),
            'placeholder'   =>__('Contact Number','carpet-court'),
            ),
        array(
            'type'      => 'text',
            'id'        => 'contact_email',
            'title'     => __('Contact Email','carpet-court'),
            'placeholder'   =>__('Contact Email','carpet-court'),
            ),
        array(
            'id'               => 'po_box',
            'type'             => 'textarea',
            'title'            => __('P.O Box', 'carpet-court'),
            'args'   => array(
                'teeny'            => true,
                'textarea_rows'    => 8,
                'media_buttons'    => false,
                ),
            ),
        array(
            'id'               => 'copyright',
            'type'             => 'textarea',
            'title'            => __('Copyright Text', 'carpet-court'),
            'args'   => array(
                'teeny'            => true,
                'textarea_rows'    => 8,
                'media_buttons'    => false,
                ),
            ),
        array(
            'type'      => 'text',
            'id'        => 'cc_instagram',
            'title'     => __('Instagram','carpet-court'),
            'placeholder' => __('Instagram link','carpet-court'),
            ),
        array(
            'type'      => 'text',
            'id'        => 'cc_youtube',
            'title'     => __('Youtube','carpet-court'),
            'placeholder' => __('Youtube link','carpet-court'),
            ),
        array(
            'type'      => 'text',
            'id'        => 'facebook',
            'title'     => __('Facebook','carpet-court'),
            'placeholder' => __('Facebook link','carpet-court'),
            ),
        array(
            'type'      => 'text',
            'id'        => 'pinterest',
            'title'     => __('Pinterest','carpet-court'),
            'placeholder' => __('Pinterest link','carpet-court'),
            ),

        )
    ) );

    // diagnostic filter setting
Redux::setSection( $opt_name, array(
    'title'   => __( 'Diagnostic Filter Icons', 'carpet-court' ),
    'id'      => 'diagnostic',
    'icon'    => 'el el-website',
    'fields'  =>  array(
        array(
            'id'    => 'product_cat',
            'type'  => 'media',
            'title'    => __('category',"carpet-court"),
            ),
        array(
            'id'    => 'pa_floor',
            'type'  => 'media',
            'title'    => __('Floor Life',"carpet-court"),
            ),
        array(
            'id'    => 'pa_style',
            'type'  => 'media',
            'title'    => __('Style Life',"carpet-court"),
            ),
        array(
            'id'    => 'pa_looks',
            'type'  => 'media',
            'title'    => __('Looks',"carpet-court"),
            ),
        array(
            'id'    => 'product_color',
            'type'  => 'media',
            'title'    => __('Colour Palettes',"carpet-court"),
            ),
        array(
            'id'    => 'product_brand',
            'type'  => 'media',
            'title'    => __('Brands',"carpet-court"),
            ),
        array(
            'id'    => 'pa_quality',
            'type'  => 'media',
            'title'    => __('Quality',"carpet-court"),
            ),
        array(
            'id'    => 'pa_rooms',
            'type'  => 'media',
            'title'    => __('Room',"carpet-court"),
            ),
        array(
            'id'    => 'cpm_accents',
            'type'  => 'media',
            'title'    => __('Accent Colours',"carpet-court"),
            ),
        array(
            'id'    => 'pa_filter-colour',
            'type'  => 'media',
            'title'    => __('Colours',"carpet-court"),
            ),
        array(
            'id'    => 'additional_option',
            'type'  => 'media',
            'title'    => __('Additional Options',"carpet-court"),
            ),
        array(
            'id'    => 'product_feature',
            'type'  => 'media',
            'title'    => __('Features',"carpet-court"),
            ),
        )
    ));


     // Product Finance images and link
Redux::setSection( $opt_name, array(
   'title'   => __( 'Product Finance Settings', 'carpet-court' ),
   'id'      => 'product_finance',
   'icon'    => 'el el-website',
   'fields'  =>  array(
       array(
           'id'    => 'product_finance_media',
           'type'  => 'media',
           'title'    => __('Product Finance',"carpet-court"),
           ),
       array(
           'type'      => 'text',
           'id'        => 'product_finance_link',
           'title'     => __('Finance','carpet-court'),
           'placeholder' => __('Finance link','carpet-court'),
           'default'    => '#'
           ),
       )
   )
);