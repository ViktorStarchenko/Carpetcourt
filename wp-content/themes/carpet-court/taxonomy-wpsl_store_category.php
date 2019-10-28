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
    $term = get_term(get_queried_object()->term_id);
    $args = [
        'post_type' => 'wpsl_stores',
        'post_status' => 'publish',
        'numberposts' => -1,
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
                        <?php foreach ($stories as $store) : ?>
                        <div class="locator-info__group">
                            <div class="locator-info__ttl"><?= $store->post_title ?></div>
                            <?php $storeInfo = get_post_meta($store->ID); ?>
                            <div class="locator-info__row">
                                <div class="locator-info__col">
                                    <?php if (!empty($storeInfo['wpsl_address'][0])) : ?>
                                        <?= $storeInfo['wpsl_address'][0] ?>
                                    <?php endif; ?>
                                    <?php if (!empty($storeInfo['wpsl_address2'][0])) : ?>
                                        <br>
                                        <?= $storeInfo['wpsl_address2'][0] ?>
                                    <?php endif; ?>
                                    <?php if (!empty($storeInfo['wpsl_zip'][0])) : ?>
                                        <br>
                                        <?= $storeInfo['wpsl_zip'][0] ?>
                                    <?php endif; ?>
                                    <br><a href="<?= get_permalink($store->ID) ?>">View more</a>
                                </div>
                                <div class="locator-info__col">                                                                    <?php if (!empty($storeInfo[$story->ID]['wpsl_phone'][0])) : ?>
                                        Phone: <a href="tel:<?= str_replace(' ', '', $storeInfo[$story->ID]['wpsl_phone'][0]) ?>" >
                                            <?= $storeInfo[$story->ID]['wpsl_phone'][0] ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($storeInfo[$story->ID]['wpsl_email'][0])) : ?>
                                        <br>
                                        <a href="mailto:<?= $storeInfo[$story->ID]['wpsl_email'][0] ?>">Email this store</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
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
<?php get_footer(); ?>

