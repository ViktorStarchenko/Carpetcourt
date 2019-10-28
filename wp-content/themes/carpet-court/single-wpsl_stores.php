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
    $storeInfo = get_post_meta($post->ID);
    $work = scheduled($storeInfo);
?>
<div class="section-content">
    <div class="container">
        <div class="s-wrap">
            <div class="row">
                <div class="s-content col-md-6">
                    <h2 class="s-title hidden-md-min"><?= $post->post_title ?></h2>
                    <?php
                        $image[0] = '';
                        if (has_post_thumbnail( $post->ID ) ) {
                            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
                        }
                    ?>
                    <?php if (!empty($image[0])) : ?>
                    <img src="<?= $image[0] ?>" class="s-image">
                    <?php endif; ?>
                </div>
                <div class="s-sidebar col-md-6">
                    <h2 class="s-title hidden-sm-max"><?= $post->post_title ?></h2>
                    <?= $post->post_content ?>
                    <div class="locator-info">
                        <div class="locator-info__group">
                            <div class="locator-info__ttl">Address</div>
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
                                </div>
                                <div class="locator-info__col">
                                    <?php if (!empty($storeInfo['wpsl_phone'][0])) : ?>
                                        Phone:
                                        <a href="tel:<?= str_replace(' ', '', $storeInfo['wpsl_phone'][0]) ?>"><?= $storeInfo['wpsl_phone'][0] ?></a>
                                        <br>
                                    <?php endif; ?>
                                    <?php if (!empty($storeInfo['wpsl_email'][0])) : ?>
                                        <a href="mailto:<?= $storeInfo['wpsl_email'][0] ?>">Email this store</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($work)) : ?>
                        <div class="locator-info__group">
                            <div class="locator-info__ttl">Store Hours</div>
                            <div class="locator-info__row">
                                <div class="locator-info__col">
                                    <div class="">Today: <?= $work['today'] ?></div>
                                    <div class="">Mon: <?= $work['monday'] ?></div>
                                    <div class="">Tue: <?= $work['tuesday'] ?></div>
                                    <div class="">Wed: <?= $work['wednesday'] ?></div>
                                </div>
                                <div class="locator-info__col">
                                    <div class="">Thu: <?= $work['thursday'] ?></div>
                                    <div class="">Fri: <?= $work['friday'] ?></div>
                                    <div class="">Sat: <?= $work['saturday'] ?></div>
                                    <div class="">Sun: <?= $work['sunday'] ?></div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $testimonials = get_field('store_testimonial'); ?>
<?php if (!empty($testimonials)) : ?>
<div class="locator-reviews">
    <div class="carousel-wrap cursor">
        <div class="carousel-slider">
            <?php foreach ($testimonials as $testimonial) : ?>
            <div class="slide">
                <div class="slide-wrap">
                    <div class="slide-icon ic2-icon-quote"></div>
                    <div class="slide-text"><?= $testimonial['testimonial_content'] ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="carousel-nav">
            <button type="button" class="btn btn-prev ic-nav-prev"></button>
            <button type="button" class="btn btn-next ic-nav-next"></button>
        </div>
        <div class="carousel-dots"></div>
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
<?php get_footer(); ?>
