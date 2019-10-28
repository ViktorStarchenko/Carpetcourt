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

    //dump($categories);

    $storeInfo = [];
    $cities = [];
    $stories = [];
    foreach ($categories as $key => $category) {
        $args = [
            'post_type' => 'wpsl_stores',
            'post_status' => 'publish',
            'numberposts' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'wpsl_store_category',
                    'field' => 'id',
                    'terms' => $category->cat_ID,
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
        sort($cities[$key]);
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
                            <?php foreach ($categories as $key => $category) : ?>
                            <div id="group-<?= $key ?>" class="acc-group">
                                <h2 class="acc-title"><?= $category->name ?></h2>
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
                                                                    <?php if (!empty($storeInfo['wpsl_address'][0])) : ?>
                                                                        <br>
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
                                                                    <a href="mailto:<?= $storeInfo[$story->ID]['wpsl_email'][0] ?>">Email this store</a>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endforeach; ?>
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
<?php get_footer();