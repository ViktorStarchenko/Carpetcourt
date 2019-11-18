<?php
/*
 * Template Name: Store locator region page
 * Template Post Type: page
 */
?>
<?php get_header(); ?>
<div class="breadcrumbs">
    <div class="container container--fluid">
        <?php
        yoast_breadcrumb( '<div class="breadcrumbs-list">','</div>' );
        ?>
    </div>
</div>
<?= do_shortcode('[wpsl]'); ?>
<?php
    $order = get_field('order', 5728);
    $region_order = get_field('region_order', 5728);
    $term = get_term(get_queried_object()->term_id);
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
                'terms' => get_queried_object()->term_id,
                'include_children' => false
            )
        )
    ];
    $stories = get_posts($args);
?>
<div class="section-content">
    <div class="container">
        <div class="s-wrap">
            <div class="row">
                <div class="s-content col-md-7">
                    <h2 class="s-title">Stores in <?= $term->name ?></h2>
                    <p><?= $term->description ?></p>
                    <?php if (!empty($stories)) : ?>
                    <div class="locator-info">
                        <?= $schemeLocalBusiness = ' '; ?>
                        <?php foreach ($stories as $store) : ?>
                        <div class="locator-info__group">
                            <div class="locator-info__ttl"><?= $store->post_title ?></div>
                            <?php $storeInfo = get_post_meta($store->ID); ?>
                            <div class="locator-info__row">
                                <div class="locator-info__col">
                                    <?php if (!empty($storeInfo['wpsl_address'][0])) : ?>
                                        <?= $storeInfo['wpsl_address'][0] ?><br>
                                    <?php endif; ?>
                                    <?php if (!empty($storeInfo['wpsl_address2'][0])) : ?>
                                        <?= $storeInfo['wpsl_address2'][0] ?>
                                    <?php endif; ?>
                                    <?php if (!empty($storeInfo['wpsl_zip'][0])) : ?>
                                        <br>
                                        <?= $storeInfo['wpsl_zip'][0] ?>
                                    <?php endif; ?>
                                    <br><a href="<?= get_permalink($store->ID) ?>">View more</a>
                                </div>
                                <div class="locator-info__col">
                                    <?php if (!empty($storeInfo['wpsl_phone'][0])) : ?>
                                        Phone: <a href="tel:<?= str_replace(' ', '', $storeInfo['wpsl_phone'][0]) ?>" >
                                            <?= $storeInfo['wpsl_phone'][0] ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($storeInfo['wpsl_email'][0])) : ?>
                                        <br>
                                        <a href="mailto:<?= $storeInfo['wpsl_email'][0] ?>">Email this store</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                            <?php
                            $image[0] = '';
                            if (has_post_thumbnail( $store->ID ) ) {
                                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $store->ID ), 'large' );
                            }
                            $country = '';
                            if (!empty($storeInfo['wpsl_country_iso'][0])) {
                                $country = $storeInfo['wpsl_country_iso'][0];
                            }

                            $zip = '';
                            if (!empty($storeInfo['wpsl_zip'][0])) {
                                $country = $storeInfo['wpsl_zip'][0];
                            }

                            $city = '';
                            if (!empty($storeInfo['wpsl_city'][0])) {
                                $city = $storeInfo['wpsl_city'][0];
                            }

                            $state = '';
                            if (!empty($storeInfo['wpsl_state'][0])) {
                                $state = $storeInfo['wpsl_state'][0];
                            }

                            $address = '';
                            if (!empty($storeInfo['wpsl_address'][0])) {
                                $address = $storeInfo['wpsl_address'][0];
                            }

                            $phone = '';
                            if (!empty($storeInfo['wpsl_phone'][0])) {
                                $phone = $storeInfo['wpsl_phone'][0];
                            }

                            $lat = '';
                            if (!empty($storeInfo['wpsl_lat'][0])) {
                                $lat = $storeInfo['wpsl_lat'][0];
                            }

                            $lng = '';
                            if (!empty($storeInfo['wpsl_lng'][0])) {
                                $lng = $storeInfo['wpsl_lng'][0];
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
                            $schemeLocalBusiness .= '{
                                "@type": "LocalBusiness",
                                "priceRange":"NZD",
                                "image": [
                                    "'.$image[0].'"
                                ],
                                "@id": "'.get_permalink($store->ID).'",
                                "name": "'.$store->post_title.'",
                                "address": {
                                    "@type": "PostalAddress",
                                    "streetAddress": "'.$address.'",
                                    "addressLocality": "'.$city.'",
                                    "addressRegion": "'.$state.'",
                                    "postalCode": "'.$zip.'",
                                    "addressCountry": "'.$country.'"
                                },
                                '.$geo.'
                                "url": "'.get_permalink($store->ID).'",
                                "telephone": "'.$phone.'"
                            },';
                            ?>
                        <?php endforeach; ?>
                        <?php $schemeLocalBusiness = substr($schemeLocalBusiness, 0, -1); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="s-sidebar col-md-5">
                    <?= template_part('sidebar', []); ?>
                </div>
            </div>
        </div>
    </div>
</div>
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
<?php get_footer(); ?>

