<?php
/*
 * Template Name: Store locator page
 * Template Post Type: page
 */
?>
<?php get_header(); ?>
<?php
    $categories = get_categories([
        'taxonomy' => 'wpsl_store_category',
        'hide_empty' => false
    ]);

    $order = get_field('order', 5728);
    $region_order = get_field('region_order', 5728);

    $storeInfo = [];
    $cities = [];
    $stories = [];
    $categories = [];
    foreach ($region_order as $regionID) {
        $categories[] = get_term($regionID, 'wpsl_store_category');
    }

    foreach ($categories as $key => $category) {
        $args = [
            'post_type' => 'wpsl_stores',
            'post_status' => 'publish',
            'numberposts' => -1,
            'include' => $order,
            'orderby' => 'post__in',
            'tax_query' => array(
                array(
                    'taxonomy' => 'wpsl_store_category',
                    'field' => 'id',
                    'terms' => $category->term_id,
                    'include_children' => false
                )
            )
        ];
        $stories[$key] = get_posts($args);
        foreach ($stories[$key] as $store) {
            $storeInfo[$store->ID] = get_post_meta($store->ID);
            $cities[$key][] = $storeInfo[$store->ID]['wpsl_city'][0];
        }
        $cities[$key] = array_unique($cities[$key]);
        //sort($cities[$key]);
    }

    $mainSiteEmail = get_field("mainEmail", "option");
    if (empty($mainSiteEmail)) {
        $mainSiteEmail = "marketing@carpetcourt.nz";
    }
?>
    <div class="breadcrumbs">
        <div class="container container--fluid">
            <?php
                yoast_breadcrumb( '<div class="breadcrumbs-list">','</div>' );
            ?>
        </div>
    </div>
    <?= do_shortcode('[wpsl]'); ?>
    <?php if (!empty($categories)) : ?>
    <div class="section-content">
        <div class="container">
            <div class="s-wrap">
                <div class="row">
                    <div class="s-content col-md-7">
                        <div class="locator-accordion">
                            <?= $schemeLocalBusiness = ' '; ?>
                            <?php foreach ($categories as $key => $category) : ?>
                                    <div id="group-<?= $key ?>" class="acc-group">
                                <h2 class="acc-title"><a href="/store-category/<?= $category->slug ?>" ><?= $category->name ?></a></h2>
                                <?php if (!empty($cities[$key])) : ?>
                                <?php foreach ($cities[$key] as $key2 => $city) : ?>
                                <div class="acc-panel">
                                    <div class="acc-head"><a data-toggle="collapse" href="#panel-<?= $key ?>-<?= $key2 ?>" class="acc-link collapsed"><?= $city ?></a></div>
                                    <div id="panel-<?= $key ?>-<?= $key2 ?>" data-parent="#group-<?= $key ?>" class="collapse">
                                        <div class="acc-body">
                                            <div class="locator-info">
                                                <?php foreach ($stories[$key] as $story) : ?>
                                                    <?php if ($storeInfo[$story->ID]['wpsl_city'][0] == $city) : ?>
                                                        <div class="locator-info__group">
                                                            <div class="locator-info__ttl"><?= $story->post_title ?></div>
                                                            <div class="locator-info__row">
                                                                <div class="locator-info__col">
                                                                    <?php if (!empty($storeInfo[$story->ID]['wpsl_address'][0])) : ?>
                                                                        <?= $storeInfo[$story->ID]['wpsl_address'][0] ?>
                                                                    <?php endif; ?>
                                                                    <?php if (!empty($storeInfo[$story->ID]['wpsl_address2'][0])) : ?>
                                                                        <br>
                                                                        <?= $storeInfo[$story->ID]['wpsl_address2'][0] ?>
                                                                    <?php endif; ?>
                                                                    <?php if (!empty($storeInfo[$story->ID]['wpsl_zip'][0])) : ?>
                                                                        <br>
                                                                        <?= $storeInfo[$story->ID]['wpsl_zip'][0] ?>
                                                                    <?php endif; ?>
                                                                    <br>
                                                                    <a href="<?= get_permalink($story->ID) ?>">View more</a>
                                                                </div>
                                                                <div class="locator-info__col">
                                                                    <?php if (!empty($storeInfo[$story->ID]['wpsl_phone'][0])) : ?>
                                                                    Phone: <a href="tel:<?= str_replace(' ', '', $storeInfo[$story->ID]['wpsl_phone'][0]) ?>" >
                                                                        <?= $storeInfo[$story->ID]['wpsl_phone'][0] ?>
                                                                    </a>
                                                                    <?php endif; ?>
                                                                    <?php if (!empty($storeInfo[$story->ID]['wpsl_email'][0])) : ?>
                                                                    <br>
                                                                    <a href="mailto:<?= $storeInfo[$story->ID]['wpsl_email'][0] ?>?bcc=<?= $mainSiteEmail ?>">Email this store</a>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php
                                                        $image[0] = '';
                                                        if (has_post_thumbnail( $post->ID ) ) {
                                                            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
                                                        }
                                                        $country = '';
                                                        if (!empty($storeInfo[$story->ID]['wpsl_country_iso'][0])) {
                                                            $country = $storeInfo[$story->ID]['wpsl_country_iso'][0];
                                                        }

                                                        $zip = '';
                                                        if (!empty($storeInfo[$story->ID]['wpsl_zip'][0])) {
                                                            $country = $storeInfo[$story->ID]['wpsl_zip'][0];
                                                        }

                                                        $city = '';
                                                        if (!empty($storeInfo[$story->ID]['wpsl_city'][0])) {
                                                            $city = $storeInfo[$story->ID]['wpsl_city'][0];
                                                        }

                                                        $state = '';
                                                        if (!empty($storeInfo[$story->ID]['wpsl_state'][0])) {
                                                            $state = $storeInfo[$story->ID]['wpsl_state'][0];
                                                        }

                                                        $address = '';
                                                        if (!empty($storeInfo[$story->ID]['wpsl_address'][0])) {
                                                            $address = $storeInfo[$story->ID]['wpsl_address'][0];
                                                        }

                                                        $phone = '';
                                                        if (!empty($storeInfo[$story->ID]['wpsl_phone'][0])) {
                                                            $phone = $storeInfo[$story->ID]['wpsl_phone'][0];
                                                        }

                                                        $lat = '';
                                                        if (!empty($storeInfo[$story->ID]['wpsl_lat'][0])) {
                                                            $lat = $storeInfo[$story->ID]['wpsl_lat'][0];
                                                        }

                                                        $lng = '';
                                                        if (!empty($storeInfo[$story->ID]['wpsl_lng'][0])) {
                                                            $lng = $storeInfo[$story->ID]['wpsl_lng'][0];
                                                        }

                                                        $geo = '';
                                                        if (!empty($lat) && !empty($lng)) {
                                                            $geo = '
                                                                   "geo": {
                                                                    "@type": "GeoCoordinates",
                                                                    "latitude": '.$lat.',
                                                                    "longitude": '.$lng.'
                                                                },
                                                            ';
                                                        }

													    $openHours = '';
														if (!empty($storeInfo[$story->ID]['wpsl_hours'][0])) {
															//$phone = $storeInfo[$story->ID]['wpsl_hours'][0];
                                                            $daysArray = unserialize($storeInfo[$story->ID]['wpsl_hours'][0]);
                                                            $daysCount = count($daysArray);
                                                            $daysArrayKeys = array_keys($daysArray);
                                                           // var_dump($daysArrayKeys);
															$daysOfWeek = [];
                                                            for ($i = 0; $i < $daysCount; $i++) {
                                                                if (!empty($daysArray[$daysArrayKeys[$i]]) && ($daysArray[$daysArrayKeys[$i]][0] == $daysArray[$daysArrayKeys[$i+1]][0] || $daysArray[$daysArrayKeys[$i-1]][0] == $daysArray[$daysArrayKeys[$i]][0]) ){
                                                                    $daysOfWeek['same']['weekdays'][] = ucfirst($daysArrayKeys[$i]);
                                                                    $daysOfWeek['same']['opens'] = explode(',', $daysArray[$daysArrayKeys[$i]][0])[0];
                                                                    $daysOfWeek['same']['closes'] = explode(',', $daysArray[$daysArrayKeys[$i]][0])[1];
                                                                } elseif (!empty($daysArray[$daysArrayKeys[$i]])) {
																	$daysOfWeek['separate']['weekdays'] = ucfirst($daysArrayKeys[$i]);
																	$daysOfWeek['separate']['opens'] = explode(',', $daysArray[$daysArrayKeys[$i]][0])[0];
																	$daysOfWeek['separate']['closes'] = explode(',', $daysArray[$daysArrayKeys[$i]][0])[1];
                                                                }

                                                            }

                                                            if (!empty($daysOfWeek)) {
																foreach ($daysOfWeek as $key => $group) {
																	$days = $group['weekdays'];
																	if ($key == 'same') {
																		$days = implode(', ',array_values($group['weekdays']));
																		$days = '['.$days .']';
																	}
																	$openHours .= '                                                                     
                                                                    {
                                                                        "@type": "OpeningHoursSpecification",
                                                                        "dayOfWeek": '.$days .',
                                                                        "opens": "' .$group['opens']. '",
                                                                        "closes": "' .$group['closes']. '"
                                                                    },';
																}
                                                            }

														}

                                                        $schemeLocalBusiness .= '{
                                                                "@type": "LocalBusiness",
                                                                "priceRange":"NZD",
                                                                "image": [
                                                                    "'.$image[0].'"
                                                                ],
                                                                "@id": "'.get_permalink($story->ID).'",
                                                                "name": "'.$story->post_title.'",
                                                                "address": {
                                                                    "@type": "PostalAddress",
                                                                    "streetAddress": "'.$address.'",
                                                                    "addressLocality": "'.$city.'",
                                                                    "addressRegion": "'.$state.'",
                                                                    "postalCode": "'.$zip.'",
                                                                    "addressCountry": "'.$country.'"
                                                                },
                                                                '.$geo.'
                                                                "url": "'.get_permalink($story->ID).'",
                                                                "telephone": "'.$phone.'",
                                                                "openingHoursSpecification": [' .$openHours .'];
                                                            },';
                                                        ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                            <?php $schemeLocalBusiness = substr($schemeLocalBusiness, 0, -1); ?>
                        </div>
                    </div>
                    <div class="s-sidebar col-md-5">
                        <?= template_part('sidebar', []); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php
        $homePage = get_option( 'page_on_front' );
        // go to action section
        $goToAction = get_field('go_to_action', $homePage);
        if (!empty($goToAction)) {
            if (!empty($goToAction['enable'])) {
                echo template_part('goToAction', $goToAction);
            }
        }

        // badges section
        $badges = get_field('badges', $homePage);
        if (!empty($badges)) {
            if (!empty($badges['enable'])) {
                echo template_part('badges', $badges);
            }
        }

        // story section
        $story = get_field('story', $homePage);
        if (!empty($story)) {
            if (!empty($story['enable'])) {
                echo template_part('story', $story);
            }
        }
    ?>
<?php
$logo = get_field('logo', 'option');
$footer = get_field('footer', 'option');
$organizationPhone = '';
$organizationAddress = '';
foreach ($footer['contacts'] as $contact) {
    if ($contact['type']=='ic-help-phone') {
        $organizationPhone = ' "telephone": "'.$contact['title'].'", ';
    }
    if ($contact['type']=='ic-help-location') {
        $organizationAddress = ' "address": "'.$contact['title'].'" ';
    }
}
?>
    <script type="application/ld+json">

        {
            "@context": {
                "@vocab": "http://schema.org/"
            },
            "@graph": [
                {
                    "@id": "<?= get_option( 'home' ); ?>",
                    "@type": "Organization",
                    "name": "<?= get_bloginfo() ?>",
                    "url" : "<?= get_option( 'home' ); ?>",
                    "logo" : "<?= $logo['dark']['url'] ?>",
                    <?= $organizationPhone; ?>
                    <?= $organizationAddress; ?>
                },
                <?= $schemeLocalBusiness; ?>
            ]
        }
    </script>
<?php get_footer();