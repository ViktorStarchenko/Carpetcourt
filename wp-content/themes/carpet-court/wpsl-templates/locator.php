<?php
/*
 * Template Name: Store locator page
 * Template Post Type: page
 */
?>
<?php
//wp_enqueue_script('wpsl-js', get_template_directory_uri() . '/static/public/js/libs/wpsl-gmap-custom.min.js', ['jquery'], WPSL_VERSION_NUM, true);
//wp_localize_script( 'wpsl-js', 'wpslAjaxVariables', ['retailers' => get_retailers_list(), 'retailers_groups' => get_retailers_groups() ] );
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

    //dump($cities);
    //dump($stories);



    exit();
?>
    <div class="breadcrumbs">
        <div class="container container--fluid">
            <div class="breadcrumbs-list">
                <div class="list-item"><a href="/home.html">home</a></div>
                <div class="list-item"><span>store locator</span></div>
            </div>
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

                                                <?php
                                                dump($stories[$key]);
                                                ?>

                                                <?php foreach ($stories[$key] as $story) : ?>
                                                    <?php
                                                        dump($story);
                                                        dump($storeInfo[$store->ID]['wpsl_city']);
                                                    ?>
                                                    <?php if ($storeInfo[$store->ID]['wpsl_city'][0] == $city) : ?>
                                                        <div class="locator-info__group">
                                                            <div class="locator-info__ttl"><?= $store->post_title ?></div>
                                                            <div class="locator-info__row">
                                                                <div class="locator-info__col">5 Empire Street,<br>Kaitaia, 0410<br><a href="#">View more</a></div>
                                                                <div class="locator-info__col">Phone: 09 408 4362<br><a href="#">Email this store</a></div>
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
                        <div class="assistance-box">
                            <div class="assistance-box__title">need assistance?</div>
                            <div class="assistance-box__text">Please don’t hesitate to contact us for any questions or queries that you may have.</div>
                            <div class="assistance-box__list">
                                <div class="list-item"><a href="#" class="ic-help-phone">0800 787 777</a></div>
                                <div class="list-item"><a href="#" class="ic-help-email">email us</a></div>
                                <div class="list-item"><a href="#" class="ic-help-location">PO Box 105806, Auckland</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="section-come">
        <div class="container">
            <div class="s-wrap">
                <div class="h2 s-title">Come to us, or we can come to you</div>
                <div class="s-text">Quis Aristidem non mortuum diligit? Primum divisit ineleganter; Sed utrum hortandus es nobis, Luci, inquit, an etiam tua sponte propensus es? Sed haec omittamus.</div>
                <div class="s-buttons"><a href="#" class="btn">book an in-home consultation</a><a href="#" class="btn">find a store near you</a></div>
            </div>
        </div>
    </div>

    <div class="section-badges">
        <div class="container">
            <div class="s-list">
                <div class="list-item">
                    <div class="item-image"><img src="images/badges/badge-1.svg"></div>
                    <div class="item-text">57 stores nationwide</div>
                </div>
                <div class="list-item">
                    <div class="item-image"><img src="images/badges/badge-2.svg"></div>
                    <div class="item-text">free measure &amp; quote</div>
                </div>
                <div class="list-item">
                    <div class="item-image"><img src="images/badges/badge-3.svg"></div>
                    <div class="item-text">finance options available</div>
                </div>
                <div class="list-item">
                    <div class="item-image"><img src="images/badges/badge-4.svg"></div>
                    <div class="item-text">expertise in all commercial sectors</div>
                </div>
                <div class="list-item">
                    <div class="item-image"><img src="images/badges/badge-5.svg"></div>
                    <div class="item-text">2019 Reader’s Digest Quality service award</div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-story">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <div class="s-title">the carpet court story</div>
                </div>
                <div class="col-md-8 col-lg-9">
                    <p>Carpet Court was founded in the 1960’s by a small group of like-minded flooring retailers looking to establish a better experience and provide greater value for our customers. Today our flourishing business has 57 stores nationwide with a reputation reflecting our longstanding presence in the market and the thousands of homes we have installed carpet and hardflooring into over the decades.</p>
                    <p>We are New Zealand’s most trusted and preferred flooring retailer and work hard to ensure our customers enjoy the process of purchasing flooring which can often be a confusing and stressful experience. Our Customer Service focus has been recognised by winning Gold (for the second year in a row) for flooring stores in the Reader’s Digest Quality Service Awards - an area we continually strive to improve upon.</p>
                </div>
            </div>
        </div>
    </div>

<?php get_footer();