<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>

<?php
/**
 * woocommerce_before_single_product hook.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form();
    return;
}
?>
<style>
    .g-main{
        padding-top: 22px !important;
    }
    @media (max-width: 1279px){
        .g-main{
            padding-top: 10px !important;
        }
    }
    @media (max-width: 767px){
        .g-main{
            padding-top: 43px !important;
        }
    }
    img{
        max-width: none;
    }
    .wish-button.custom-addtowishlist-btn{
        text-decoration: none;
    }
    .wish-button.custom-addtowishlist-btn:hover{
        color: red;
    }
    .review-form-success{
        display: none;
    }
    .fas.fa-thumbs-up:hover{
        color: green;
    }
    .fas.fa-thumbs-down:hover{
        color: red;
    }
    .yith-wcwl-wishlistexistsbrowse.show, .yith-wcwl-wishlistaddedbrowse.show{
        padding-top: 20px;
        padding-left: 10px;
    }
</style>

<?php
$primary = new WPSEO_Primary_Term('product_cat', get_the_ID());
$primary = $primary->get_primary_term();
$primary = get_term_by('term_taxonomy_id', $primary);
?>
<?php $cat = get_the_terms( $post->ID, 'product_cat' )[0]; ?>
<div class="js-check-padding">
    <main class="g-main">
        <!-- SVG Sprite-->
        <div style="display: none;" class="svg-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><symbol id="arrow_right"><path fill="#fff" d="M8.808 1.242a.42.42 0 01.604-.584l3.885 4.015a.42.42 0 01.116.328.603.603 0 01.002.044c0 .266-.175.484-.396.5L9.412 9.276a.42.42 0 11-.604-.584l3.042-3.148H1.06c-.232 0-.42-.224-.42-.5s.188-.5.42-.5h10.944z"/></symbol><symbol id="close"><path fill="currentColor" d="M27.296.654L15 12.938 2.705.654a1.45 1.45 0 00-2.05 2.052L12.961 15 .655 27.295a1.45 1.45 0 102.05 2.051L15 17.062l12.296 12.284a1.45 1.45 0 102.05-2.051L17.038 15 29.345 2.706a1.45 1.45 0 10-2.05-2.052z"/></symbol><symbol id="drop_arrow"><path d="M11.045.77a.507.507 0 01.704.729L6.346 6.718a.506.506 0 01-.704 0L.244 1.498A.506.506 0 11.948.77l5.046 4.88z"/></symbol><symbol id="finger-down"><path fill="currentColor" d="M13.168 7.656a1.478 1.478 0 01-1.08.455H9.87a1.333 1.333 0 00.152.367 6.593 6.593 0 01.3.59c.051.117.101.277.152.479.051.202.076.404.076.606a3.42 3.42 0 01-.044.67c-.024.16-.056.292-.096.399-.04.106-.104.226-.192.359a1.12 1.12 0 01-.32.323 1.756 1.756 0 01-.48.207 2.397 2.397 0 01-.66.084.493.493 0 01-.36-.152 1.385 1.385 0 01-.273-.399 2.37 2.37 0 01-.156-.414 7.701 7.701 0 01-.1-.487 20.007 20.007 0 00-.108-.483 2.546 2.546 0 00-.14-.386 1.222 1.222 0 00-.248-.383c-.176-.176-.445-.495-.808-.957a14.65 14.65 0 00-.808-.966c-.278-.303-.48-.46-.608-.47a.525.525 0 01-.344-.164.48.48 0 01-.144-.347V1.474c0-.138.05-.256.152-.355a.53.53 0 01.36-.155C5.36.958 5.782.84 6.438.612c.41-.138.732-.243.964-.314a9.91 9.91 0 01.972-.232c.416-.082.8-.124 1.152-.124h1.032c.71.011 1.235.219 1.577.623.31.367.44.848.392 1.443.208.197.352.447.432.75.09.324.09.636 0 .933.245.325.36.689.344 1.093 0 .17-.04.372-.12.607.294.335.44.73.44 1.188 0 .415-.152.774-.455 1.077zM1.333 7.09a.493.493 0 01-.36-.152.49.49 0 01-.152-.359V1.474a.49.49 0 01.152-.36.494.494 0 01.36-.15h2.305c.138 0 .258.05.36.15a.49.49 0 01.152.36v5.105a.49.49 0 01-.152.359.493.493 0 01-.36.152zm1.384-4.958a.5.5 0 00-.36-.148.495.495 0 00-.364.148.492.492 0 00-.148.363.5.5 0 00.148.359c.099.1.22.152.364.152.14 0 .26-.051.36-.152a.49.49 0 00.153-.36.485.485 0 00-.153-.362z"/></symbol><symbol id="finger-up"><path fill="currentColor" d="M13.012 6.046c0 .457-.146.853-.44 1.188.08.234.12.436.12.607.016.404-.099.768-.344 1.092.09.298.09.61 0 .934a1.55 1.55 0 01-.432.75c.048.595-.083 1.076-.392 1.443-.342.404-.867.612-1.577.622H8.915c-.352 0-.736-.041-1.152-.123a10.21 10.21 0 01-.972-.232 44.448 44.448 0 01-.964-.315c-.656-.229-1.078-.346-1.264-.35a.53.53 0 01-.36-.156.477.477 0 01-.153-.355V6.038a.48.48 0 01.144-.347.525.525 0 01.345-.164c.128-.01.33-.167.608-.47.277-.304.546-.625.808-.966.363-.462.632-.781.808-.957.096-.096.179-.223.248-.383.07-.16.116-.288.14-.387.024-.098.06-.259.108-.482a7.7 7.7 0 01.1-.487c.03-.117.082-.255.156-.415a1.39 1.39 0 01.272-.398.493.493 0 01.36-.152c.246 0 .466.028.66.084.196.056.356.125.481.207.125.083.232.19.32.323s.152.253.192.36c.04.105.072.238.096.398a3.42 3.42 0 01.044.67c0 .202-.025.404-.076.606-.05.202-.101.362-.152.479a6.588 6.588 0 01-.3.59 1.335 1.335 0 00-.152.367h2.217c.416 0 .776.152 1.08.455.303.303.455.662.455 1.077zm-9.985-.51c.138 0 .258.05.36.15a.49.49 0 01.152.36v5.105a.49.49 0 01-.152.359.493.493 0 01-.36.151H.722a.494.494 0 01-.36-.151.49.49 0 01-.152-.359V6.046a.49.49 0 01.152-.36.493.493 0 01.36-.15zm-.769 4.594a.49.49 0 00-.152-.36.493.493 0 00-.36-.15.489.489 0 00-.364.15.496.496 0 00-.148.36c0 .143.05.264.148.363.099.098.22.147.364.147a.5.5 0 00.36-.147.485.485 0 00.152-.363z"/></symbol><symbol id="star"><path d="M9.834 1.049c.21-.645 1.122-.645 1.332 0l1.983 6.105a.7.7 0 00.666.483h6.419c.678 0 .96.868.411 1.267l-5.193 3.773a.7.7 0 00-.254.782l1.984 6.105c.21.645-.529 1.181-1.078.782l-5.193-3.773a.7.7 0 00-.822 0l-5.193 3.773c-.549.399-1.287-.137-1.078-.782l1.984-6.105a.7.7 0 00-.254-.783L.355 8.904c-.549-.399-.267-1.267.411-1.267h6.419a.7.7 0 00.666-.483z" fill="currentcolor" stroke="#f13e4b"/></symbol></svg></div>
        <div class="packaging-product">
            <div class="crumps">
                <ul class="crumps-list" style="margin-left: 0;" itemscope itemtype="http://schema.org/BreadcrumbList">
                    <li class="crumps-list__item" itemprop="itemListElement" itemscope
                        itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="<?= home_url() ?>">
                            <span itemprop="name">  home</span>
                        </a>
                    </li>
                    <?php
                    $primary = new WPSEO_Primary_Term('product_cat', get_the_ID());
                    $primary = $primary->get_primary_term();
                    $primary = get_term_by('term_taxonomy_id', $primary);
                    ?>
                    <li class="crumps-list__item" itemprop="itemListElement" itemscope
                        itemtype="http://schema.org/ListItem" >
                        <a itemprop="item" href="<?= get_category_link($primary->term_id); ?>" style="text-transform: lowercase">
                            <span itemprop="name"><?= $primary->name; ?></span>
                        </a>
                    </li>
                    <li class="crumps-list__item" itemprop="itemListElement" itemscope
                        itemtype="http://schema.org/ListItem">
                        <a href="#" itemprop="item">
                            <span itemprop="name"><?php the_title() ?></span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="product-grid">
                <div class="product-grid__media">
                    <h2 class="product-slider-title"><?php the_title() ?></h2>
                    <?php
                    $feature_tag = get_field('feature_tag');
                    $gallery_tag = get_field('gallery_tag');
                    ?>
                    <div class="product-slider-wrap">
                        <div class="product-slider-main">
                            <div class="product-slider zoom-wrap">
                                <?php if (!empty(get_field('featured_image'))) : ?>
                                    <span class="slide">
                                        <img id="zoom-trigger-1" data-target="zoom-target-1" src="<?= get_field('featured_image') ?>" alt="product image" data-large-img="<?= get_field('featured_image') ?>" class="product-slider-img"/>
                                        <?php if (!empty($feature_tag)) : ?>
                                            <p class="thumnbs-tag"><?= $feature_tag ?></p>
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                                <?php $gallery_images = get_field('gallery_images');
                                foreach ($gallery_images as $key => $gallery_image){ ?>
                                    <?php $i = $key + 2; ?>
                                    <span class="slide">
                                    <img id="zoom-trigger-<?= $i ?>" data-target="zoom-target-<?= $i ?>" src="<?= $gallery_image['gallery_images_url'] ?>" alt="product image" data-large-img="<?= $gallery_image['gallery_images_url'] ?>" class="product-slider-img"/>
                                    <?php if (!empty($gallery_tag[$key]['gallery_images_tag'])) : ?>
                                        <p class="thumnbs-tag"><?= $gallery_tag[$key]['gallery_images_tag'] ?></p>
                                    <?php endif; ?>
                                </span>
                                <?php }
                                ?>
                            </div>
                            <div class="product-slider-nav">
                                <button type="button" class="btn btn-prev btn-prev-main ic-nav-prev"></button>
                                <button type="button" class="btn btn-next btn-next-main ic-nav-next" style="min-width: 0;"></button>
                            </div>
                            <div class="product-slider-dots"></div>
                            <div class="product-slider-zoom">
                                <!-- this count = img count-->
                                <!-- this id = img data-target-->
                                <?php
                                $count = count($gallery_images) + 1;
                                for ( $k = 1; $k <= $count; $k++ ) {
                                    ?>
                                    <div id="zoom-target-<?= $k ?>" class="img-zoom-result"></div>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                        <div class="product-slider-thumnbs-wrap">
                            <div class="product-slider-thumnbs">
                                <?php if (!empty(get_field('featured_image'))) : ?>
                                    <div class="thumnbs-slide">
                                        <img data-lazy="<?= get_field('featured_image') ?>" alt="product image"/>
                                    </div>
                                <?php endif; ?>
                                <?php foreach ($gallery_images as $key => $gallery_image) : ?>
                                    <div class="thumnbs-slide">
                                        <img data-lazy="<?= $gallery_image['gallery_images_url'] ?>" alt="product image"/>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="product-slider-nav">
                                <button type="button" class="btn btn-prev btn-prev-thumbs ic-nav-prev"></button>
                                <button type="button" class="btn btn-next btn-next-thumbs ic-nav-next" style="min-width: 0;"></button>
                            </div>
                        </div>
                    </div>

                    <div class="product-features">
                        <?php
                        $features = get_the_terms($post->ID, 'product_feature');
                        if (!empty($features))
                            foreach ($features as $feature){ ?>
                                <?php
                                $thumbnail_id = cc_get_term_meta($feature->term_id, 'thumbnail_id', true);
                                $image = cc_placeholder_img_src();
                                if ($thumbnail_id) {
                                    // $image = wp_get_attachment_thumb_url( $thumbnail_id );
                                    $image = wp_get_attachment_image_src($thumbnail_id, 'category_image');
                                    $image = $image[0];
                                }

                                // Prevent esc_url from breaking spaces in urls for image embeds
                                // Ref: http://core.trac.wordpress.org/ticket/23605
                                $image = str_replace(' ', '%20', $image);
                                ?>
                                <div class="product-features__item"><img src="<?= esc_url($image) ?>" alt="<?= $feature->name ?>"/></div>
                            <?php }
                        ?>
                    </div>
                </div>
                <?php
                $wc_product = wc_get_product(get_the_ID());
                $currency = get_woocommerce_currency_symbol();
                $on_sale = false;
                $on_sale_without_discount =  product_on_sale_without_discount($wc_product->get_id());

                if($wc_product->is_on_sale()) {
                    $on_sale = true;
                }
                $special_offer = get_field('special_offers', $post_id);
                ?>
                <div class="product-grid__description">
                    <div class="product-description">
                        <?php if($on_sale): ?>
                            <div class="product-description__sales">
                                <div class="product-sales-banner">Sale</div>
                            </div>
                        <?php endif;?>
                        <h1 class="product-description__title"><?php the_title() ?></h1>
                        <p><?php the_content(); ?></p>
                    </div>
                    <?php
                    $colors = get_the_terms( $product->id, 'pa_color' );
                    $currentColour = get_field('current_colour', $post->ID);
                    $relatedProducts = get_field('related_products', $post->ID);

                    ?>
                    <div class="product-extend">
                        <div class="product-price">
                            <?php if($on_sale): ?>
                                <div class="product-price__value"><span class="-old"><?= $currency.$wc_product->get_regular_price() ?></span><span class="-new"><?= $currency.$wc_product->get_sale_price() ?></span></div>
                            <?php else : ?>
                                <div class="product-price__value"><span><?= $currency.$wc_product->get_regular_price() ?></span></div>
                            <?php endif; ?>
                            <div class="product-price__unit">*per sqm</div>
                        </div>
                        <div class="product-special"><?php if($on_sale_without_discount): ?><?php echo !empty($special_offer) ? $special_offer : '' ?><?php endif; ?></div>
                    </div>
                    <div class="product-selector js-product-parent">
                        <div class="product-selector__title">Selected Colour:
                            <?php if (!empty($colors)) : ?>
                                <div class="product-selector__title-select js-select-color">
                                    <?php foreach ($colors as $color) : ?>
                                        <?php if ($color->term_id == $currentColour) : ?>
                                            <?php $color_image = get_term_meta( $color->term_id, 'cpm_color_thumbnail', true ); ?>
                                            <?= $color->name ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($currentColour) && !empty($relatedProducts)) : ?>
                            <div class="product-selector-inner">
                                <a href="#" class="product-selector-preview js-show-swatch">
                                    <?php if (!empty($colors)) : ?>
                                        <?php foreach ($colors as $color) : ?>
                                            <?php if ($color->term_id == $currentColour) : ?>
                                                <?php $color_image = get_term_meta( $color->term_id, 'cpm_color_thumbnail', true ); ?>
                                                <div style="background-image:url('<?= $color_image ?>');" class="product-selector-preview__item js-product-target js-sw-color color-<?= $color->slug ?>" data-name="<?= $color->name ?>" data-color="<?= $color->slug ?>"></div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <?php foreach ($relatedProducts as $relatedProduct) : ?>
                                            <?php if ($relatedProduct == $post->ID) : ?>
                                            <?php else : ?>
                                                <?php
                                                $relatedProductColour = get_field('current_colour', $relatedProduct);
                                                $color = get_term_by('term_taxonomy_id', $relatedProductColour);
                                                ?>
                                                <?php if (!empty($color) && !empty($relatedProductColour)) : ?>
                                                    <?php $color_image = get_term_meta($relatedProductColour, 'cpm_color_thumbnail', true ); ?>
                                                    <div style="background-image:url('<?= $color_image ?>');" class="product-selector-preview__item js-product-target js-sw-color color-<?= $color->slug ?>" data-name="<?= $color->name ?>" data-color="<?= $color->slug ?>"></div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <div class="product-selector-preview__button"><span>Open Swatch Gallery</span></div></a>
                                </a>
                                <ul class="product-selector-thumbs">
                                    <?php if (!empty($colors)) : ?>
                                        <?php foreach ($colors as $color) : ?>
                                            <?php if ($color->term_id == $currentColour) : ?>
                                                <?php $color_image = get_term_meta( $color->term_id, 'cpm_color_thumbnail', true ); ?>

                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php foreach ($relatedProducts as $relatedProduct) : ?>
                                            <?php
                                            $relatedProductColour = get_field('current_colour', $relatedProduct);
                                            $color = get_term_by('term_taxonomy_id', $relatedProductColour);
                                            ?>
                                            <?php if (!empty($color) && !empty($relatedProductColour)) : ?>
                                                <?php $color_image = get_term_meta($relatedProductColour, 'cpm_color_thumbnail', true ); ?>
                                                <?php if ($relatedProduct == $post->ID) : ?>
                                                    <li data-naming="<?= $color->name ?>" class="product-selector-thumbs__item js-product-trigger is-active color-<?= $color->slug ?>" data-name="<?= $color->name ?>" data-color="<?= $color->slug ?>">
                                                        <div class="product-selector-thumbs__img">
                                                            <img style="min-width: 34px; min-height: 34px;" src="<?= $color_image ?>" alt="<?= $color->name ?>"/>
                                                        </div>
                                                    </li>
                                                <?php else : ?>
                                                    <li class="product-selector-thumbs__item js-product-trigger color-<?= $color->slug ?>" data-name="<?= $color->name ?>" data-color="<?= $color->slug ?>">
                                                        <a href="<?= get_permalink($relatedProduct) ?>">
                                                            <div class="product-selector-thumbs__img">
                                                                <img style="min-width: 34px; min-height: 34px;" src="<?= $color_image ?>" alt="<?= $color->name ?>"/>
                                                            </div>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php else : ?>
                            <div class="product-selector-inner"><a href="#" class="product-selector-preview js-show-swatch">
                                    <?php
                                    if (!empty($colors))
                                        foreach ($colors as $color){
                                            $color_image = get_term_meta( $color->term_id, 'cpm_color_thumbnail', true ); ?>
                                            <div style="background-image:url('<?= $color_image ?>');" class="product-selector-preview__item js-product-target"></div>
                                        <?php }
                                    ?>
                                    <div class="product-selector-preview__button"><span>Open Swatch Gallery</span></div></a>
                                <ul class="product-selector-thumbs">
                                    <?php
                                    if (!empty($colors))
                                        foreach ($colors as $color){
                                            $color_image = get_term_meta( $color->term_id, 'cpm_color_thumbnail', true ); ?>
                                            <li data-naming="<?= $color->name ?>" class="product-selector-thumbs__item js-product-trigger">
                                                <div class="product-selector-thumbs__img"><img style="min-width: 34px; min-height: 34px;" src="<?= $color_image ?>" alt="<?= $color->name ?>"/></div>
                                            </li>
                                        <?php }
                                    ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="product producr-button-row"><a href="<?= home_url()?>/measure-and-quote" class="button">Book measure and quote</a>
                        <?php /*
                        <div class="user-wishlist pull-right clearfix">
                            <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                        </div>
                        <a href="#" class="wish-button custom-addtowishlist-btn">
                            <!-- toggle .is-active class-->
                            <span class="wish-button__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="21" viewBox="0 0 23 21" class="hear-icon">
                                    <path fill="currentColor" d="M22.151 6.333a6.161 6.161 0 0 1-1.424 3.939l-8.901 9.962a.738.738 0 0 1-1.1 0l-1.392-1.556-3.06-3.423c-2.814-3.149-4.405-4.93-4.468-5.005A6.15 6.15 0 0 1 .4 6.324C.442 2.837 3.302.042 6.779.08a6.415 6.415 0 0 1 4.497 1.818A6.406 6.406 0 0 1 15.762.08a6.32 6.32 0 0 1 6.39 6.244zM10.694 3.456a4.944 4.944 0 0 0-3.921-1.9 4.843 4.843 0 0 0-4.897 4.778 4.662 4.662 0 0 0 1.06 2.968c.044.05 1.774 1.988 4.436 4.966l.002.003 3.06 3.423.841.94 8.332-9.324a4.67 4.67 0 0 0 1.068-2.972 4.847 4.847 0 0 0-4.908-4.782 4.939 4.939 0 0 0-3.91 1.9.738.738 0 0 1-1.163 0z" class="hear-icon-border"></path>
                                    <path fill="currentColor" d="M15.762.08a6.32 6.32 0 0 1 6.39 6.244v.009a6.161 6.161 0 0 1-1.425 3.939l-8.901 9.962a.738.738 0 0 1-1.1 0l-1.392-1.556-3.06-3.423c-2.814-3.149-4.405-4.93-4.468-5.005A6.15 6.15 0 0 1 .4 6.324C.442 2.837 3.302.042 6.779.08a6.415 6.415 0 0 1 4.497 1.818A6.406 6.406 0 0 1 15.762.08z" class="hear-icon-bg"></path>
                                </svg>
                            </span><span class="wish-button__text">Add to Wishlist</span>
                        </a>
 */ ?>
                    </div>

                    <div class="product-info">
                        <p class="product-info-title js-accordeon-title">
                            Product Info
                            <span class="product-info-title__icon">
                                <svg class="icon drop_arrow">
                                    <use xlink:href="#drop_arrow"></use>
                                </svg>
                            </span>
                        </p>
                        <div class="js-accordeon-content">
                            <div class="product-info-content">
                                <?php
                                $brands = get_the_terms( $product->id, 'product_brand' );
                                if (!empty($brands)) {
                                    $list = [];
                                    foreach ($brands as $key => $brand) {
                                        $list[] = $brand->name;
                                    }
                                }
                                ?>
                                <?php if (!empty($list)) : ?>
                                    <dl>
                                        <dt>Brand:</dt>
                                        <dd><?= implode(', ', $list); ?></dd>
                                    </dl>
                                <?php endif; ?>
                                <dl>
                                    <dt>Category:</dt>
                                    <dd><?= $primary->name ?></dd>
                                </dl>
                                <?php
                                $list = [];
                                $ID = get_the_ID();
                                $fibres = get_the_terms( $product->id, 'pa_fibres' );
                                $attribute = get_post_meta($ID, '_product_attributes', true);
                                if (!empty($attribute['pa_fibres']) && $attribute['pa_fibres']['is_visible'] == 1) {
                                    if (!empty($fibres)) {
                                        foreach ($fibres as $key => $fibre) {
                                            $list[] = $fibre->name;
                                        }
                                    }
                                }
                                ?>
                                <?php if (!empty($list)) : ?>
                                    <dl>
                                        <dt>Fibre:</dt>
                                        <dd><?= implode(', ', $list); ?></dd>
                                    </dl>
                                <?php endif; ?>
                                <?php if (!empty(get_field('best_for'))) : ?>
                                    <dl>
                                        <dt>Best For:</dt>
                                        <dd><?= get_field('best_for') ?></dd>
                                    </dl>
                                <?php endif; ?>
                                <?php if ($material = get_the_terms( $product->id, 'pa_materials' )) : ?>
                                    <dl>
                                        <dt>Material:</dt>
                                        <dd><?= $material[0]->name ?></dd>
                                    </dl>
                                <?php endif; ?>
                                <?php if ($width = get_field('width' )) : ?>
                                    <dl>
                                        <dt>Width:</dt>
                                        <dd><?= $width ?></dd>
                                    </dl>
                                <?php endif; ?>
                                <?php if ($length = get_field('length' )) : ?>
                                    <dl>
                                        <dt>Length:</dt>
                                        <dd><?= $length ?></dd>
                                    </dl>
                                <?php endif; ?>
                                <?php if ($thickness = get_field('thickness' )) : ?>
                                    <dl>
                                        <dt>Thickness:</dt>
                                        <dd><?= $thickness ?></dd>
                                    </dl>
                                <?php endif; ?>
                                <?php if ($width_oz = get_field('width_oz' )) : ?>
                                    <dl>
                                        <dt>Weight:</dt>
                                        <dd><?= $width_oz ?></dd>
                                    </dl>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="product-info">
                        <p class="product-info-title js-accordeon-title">
                            Finance Options
                            <span class="product-info-title__icon">
                                <svg class="icon drop_arrow">
                                    <use xlink:href="#drop_arrow"></use>
                                </svg>
                            </span>
                        </p>
                        <div class="js-accordeon-content">
                            <div class="product-info-content">
                                <a href="<?= home_url() ?>/q-card">Find out more</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <h2 class="review-form__title">Ratings & Reviews</h2>
            <div class="review-form"><span class="review-form__btn js-accordeon-title">Write a review<span class="review-form__btn-icon">
								<svg class="icon drop_arrow">
									<use xlink:href="#drop_arrow"></use>
								</svg></span></span>
                <div class="review-form__form js-accordeon-content">
                    <p class="review-form__subtitle">Your email address will not be published. Required fields are marked *</p>

                    <?php
                    $commenter = wp_get_current_commenter();

                    $comment_form = array(
                        'title_reply'          => '',
                        'comment_notes_before' => '',
                        'title_reply_before'   => '<span id="reply-title" class="comment-reply-title">',
                        'title_reply_after'    => '</span>',
                        'comment_notes_after'  => '',
                        'fields'               => array(
                            'author' => '<div class="review-form__row"><div class="review-form__item"><input type="text" id="author" name="author" placeholder="Your name*" required="required" value="' . esc_attr( $commenter['comment_author'] ) . '"/></div>',
                            'email'  => '<div class="review-form__item"><input type="email" id="email" name="email" placeholder="Email *" required="required" value="' . esc_attr( $commenter['comment_author_email'] ) . '"/></div></div>',
                        ),
                        'label_submit'  => __( 'Submit', 'woocommerce' ),
                        'logged_in_as'  => '',
                        'submit_button' => '<br><input type="submit" name="%1$s" id="%2$s" class="%3$s button" value="%4$s" />
                        </div>
                    </div>',
                    );

                    if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
                        $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'woocommerce' ), esc_url( $account_page_url ) ) . '</p>';
                    }

                    $comment_form['comment_field'] = '<div class="review-form__row">
                        <div class="review-form__item">
                            <textarea id="comment" name="comment" placeholder="Your review *" required="required"></textarea>
                        </div>';

                    if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
                        $comment_form['comment_field'] .= '<div class="review-form__item">
                            <div class="raiting-stars-wrap">
										<p>Your Rating</p>
										<div class="raiting-stars" na>
											<input id="raiting-radio5" type="radio" name="rating" value="5"/>
											<label for="raiting-radio5">
												<svg class="icon star">
													<use xlink:href="#star"></use>
												</svg>
											</label>
											<input id="raiting-radio4" type="radio" name="rating" value="4"/>
											<label for="raiting-radio4">
												<svg class="icon star">
													<use xlink:href="#star"></use>
												</svg>
											</label>
											<input id="raiting-radio3" type="radio" name="rating" value="3"/>
											<label for="raiting-radio3">
												<svg class="icon star">
													<use xlink:href="#star"></use>
												</svg>
											</label>
											<input id="raiting-radio2" type="radio" name="rating" value="2"/>
											<label for="raiting-radio2">
												<svg class="icon star">
													<use xlink:href="#star"></use>
												</svg>
											</label>
											<input id="raiting-radio1" type="radio" name="rating" value="1"/>
											<label for="raiting-radio1">
												<svg class="icon star">
													<use xlink:href="#star"></use>
												</svg>
											</label>
										</div>
                            </div>';
                    }

                    comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
                    ?>



                </div>
            </div>
        </div>
        <div class="review-form-success" <?php if(strpos($_SERVER['REQUEST_URI'], '/comment-page-')) echo 'style="display: block"'; ?>>Thank you! Your review has been sent</div>


        <!-- Reviews output -->
        <div class="packaging-product">
            <div class="review-wrap">
                <?php
                $comments = get_comments(['post_id' => $post->ID, 'status' => 'approve']);
                if( $comments )
                    foreach ($comments as $comment) {
                        $words = explode(" ", $comment->comment_author);
                        $acronym = "";
                        foreach ($words as $w) {
                            $acronym .= $w[0];
                        }
                        $rating = get_comment_meta($comment->comment_ID, 'rating', true);
                        ?>
                        <div class="review">
                            <div class="review-user">
                                <div class="review-user-logo">
                                    <div class="review-user-logo__abr"><?= $acronym ?></div>
                                    <div class="review-user-logo__icon"></div>
                                </div>
                                <div class="review-user-info">
                                    <div class="review-user-info__name"><?= $comment->comment_author ?></div>
                                    <div class="review-user-info__location" style="display: none">New York, NY</div>
                                </div>
                            </div>
                            <div class="review-content">
                                <div class="review-content-raiting">
                                    <!-- add class star-rating--${raiting}{number:string} for show rating-->
                                    <!-- for example star-rating--five or star-rating--three-->
                                    <div class="star-rating star-rating--five">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="74" height="11" viewBox="0 0 74 11">
                                            <?php for($i=1; $i<2; $i++){ ?>
                                                <?php if($rating < 1)break; ?>
                                                <path fill="transparent" stroke="#00b262" d="M2.432 11.01a.405.405 0 0 1-.386-.532L3.221 6.85.128 4.601a.405.405 0 0 1 .238-.735h3.825L5.368.24a.406.406 0 0 1 .773 0l1.176 3.626h3.825a.406.406 0 0 1 .239.735l-3.095 2.25 1.177 3.627a.406.406 0 0 1-.625.454L5.754 8.69 2.67 10.93a.406.406 0 0 1-.238.079"></path>
                                                <?php if($rating < 2)break; ?>
                                                <path fill="transparent" stroke="#00b262" d="M17.872 11.01a.405.405 0 0 1-.386-.532l1.176-3.628-3.094-2.249a.405.405 0 0 1 .238-.735h3.825L20.808.24a.406.406 0 0 1 .773 0l1.176 3.626h3.825a.406.406 0 0 1 .239.735l-3.095 2.25 1.177 3.627a.406.406 0 0 1-.625.454L21.194 8.69l-3.084 2.24a.406.406 0 0 1-.238.079"></path>
                                                <?php if($rating < 3)break; ?>
                                                <path fill="transparent" stroke="#00b262" d="M33.302 11.01a.405.405 0 0 1-.386-.532l1.176-3.628-3.094-2.249a.405.405 0 0 1 .238-.735h3.825L36.238.24a.406.406 0 0 1 .773 0l1.176 3.626h3.825a.406.406 0 0 1 .239.735l-3.095 2.25 1.177 3.627a.406.406 0 0 1-.625.454L36.624 8.69l-3.084 2.24a.406.406 0 0 1-.238.079"></path>
                                                <?php if($rating < 4)break; ?>
                                                <path fill="transparent" stroke="#00b262" d="M48.732 11.01a.405.405 0 0 1-.386-.532l1.176-3.628-3.094-2.249a.405.405 0 0 1 .238-.735h3.825L51.668.24a.406.406 0 0 1 .773 0l1.176 3.626h3.825a.406.406 0 0 1 .239.735l-3.095 2.25 1.177 3.627a.406.406 0 0 1-.625.454L52.054 8.69l-3.084 2.24a.406.406 0 0 1-.238.079"></path>
                                                <?php if($rating < 5)break; ?>
                                                <path fill="transparent" stroke="#00b262" d="M64.162 11.01a.405.405 0 0 1-.386-.532l1.176-3.628-3.094-2.249a.405.405 0 0 1 .238-.735h3.825L67.098.24a.406.406 0 0 1 .773 0l1.176 3.626h3.825a.406.406 0 0 1 .239.735l-3.095 2.25 1.177 3.627a.406.406 0 0 1-.625.454L67.484 8.69 64.4 10.93a.406.406 0 0 1-.238.079"></path>
                                            <?php } ?>
                                        </svg>
                                    </div>
                                </div>
                                <div class="review-content__title" style="display: none">Love it!</div>
                                <div class="review-content__text">
                                    <p><?= $comment->comment_content ?></p>
                                </div>
                            </div>
                            <div class="review-btns">
                                <?php
                                $comment_id = $comment->comment_ID;
                                $like_count = get_comment_meta( $comment_id, 'cld_like_count', true );
                                $dislike_count = get_comment_meta( $comment_id, 'cld_dislike_count', true );
                                $post_id = get_the_ID();
                                $cld_settings = get_option( 'cld_settings' );
                                /**
                                 * Filters like count
                                 *
                                 * @param type int $like_count
                                 * @param type int $comment_id
                                 *
                                 * @since 1.0.0
                                 */
                                $like_count = apply_filters( 'cld_like_count', $like_count, $comment_id );

                                /**
                                 * Filters dislike count
                                 *
                                 * @param type int $dislike_count
                                 * @param type int $comment_id
                                 *
                                 * @since 1.0.0
                                 */
                                $dislike_count = apply_filters( 'cld_dislike_count', $dislike_count, $comment_id );
                                if ( $cld_settings['basic_settings']['status'] != 1 ) {
                                    // if comments like dislike is disabled from backend
                                    return;
                                }
                                $liked_ips = get_comment_meta( $comment_id, 'cld_ips', true );

                                //get user ip
                                if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {

                                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                                } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {

                                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                } else {
                                    $ip = $_SERVER['REMOTE_ADDR'];
                                }
                                $user_ip = apply_filters( 'wpb_get_ip', $ip );


                                if ( empty( $liked_ips ) ) {
                                    $liked_ips = array();
                                }
                                if ( is_user_logged_in() ) {
                                    $liked_users = get_comment_meta( $comment_id, 'cld_users', true );
                                    $liked_users = (empty( $liked_users )) ? array() : $liked_users;
                                    $current_user_id = get_current_user_id();
                                    if ( in_array( $current_user_id, $liked_users ) ) {
                                        $user_check = 1;
                                        $already_liked = 1;
                                    } else {
                                        $user_check = 0;
                                    }
                                } else {
                                    $user_check = 1;
                                    $already_liked = 0;
                                }

                                if ( $cld_settings['basic_settings']['like_dislike_resistriction'] == 'user' && !empty( $cld_settings['basic_settings']['login_link'] ) && $user_check == 1 && $already_liked == 0 ) {
                                    $href = $cld_settings['basic_settings']['login_link'];
                                } else {
                                    $href = 'javascript:void(0)';
                                }


                                // $this->print_array($liked_ips);
                                $user_ip_check = (in_array( $user_ip, $liked_ips )) ? 1 : 0;
                                $like_title = isset( $cld_settings['basic_settings']['like_hover_text'] ) ? esc_attr( $cld_settings['basic_settings']['like_hover_text'] ) : __( 'Like', CLD_TD );
                                $dislike_title = isset( $cld_settings['basic_settings']['dislike_hover_text'] ) ? esc_attr( $cld_settings['basic_settings']['dislike_hover_text'] ) : __( 'Dislike', CLD_TD );

                                //$this->print_array( $cld_settings );
                                ?>
                                <div class="cld-like-dislike-wrap cld-<?php echo esc_attr( $cld_settings['design_settings']['template'] ); ?>">
                                    <?php
                                    /**
                                     * Like Dislike Order
                                     */
                                    if ( $cld_settings['basic_settings']['display_order'] == 'like-dislike' ) {
                                        if ( $cld_settings['basic_settings']['like_dislike_display'] != 'dislike_only' ) {
                                            include(CLD_PATH . 'inc/views/frontend/like.php');
                                        }
                                        if ( $cld_settings['basic_settings']['like_dislike_display'] != 'like_only' ) {
                                            include(CLD_PATH . 'inc/views/frontend/dislike.php');
                                        }
                                    } else {
                                        /**
                                         * Dislike Like Order
                                         */
                                        if ( $cld_settings['basic_settings']['like_dislike_display'] != 'like_only' ) {
                                            include(CLD_PATH . 'inc/views/frontend/dislike.php');
                                        }
                                        if ( $cld_settings['basic_settings']['like_dislike_display'] != 'dislike_only' ) {
                                            include(CLD_PATH . 'inc/views/frontend/like.php');
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>




                        <?php
                    }
                ?>

            </div>
        </div>
        <style>
            .section-come{
                background-color: rgb(245, 246, 246);
                margin-top: 50px;
            }
        </style>
        <?php
        // go to action section
        $goToAction = get_field('go_to_action', 35060);
        if (!empty($goToAction)) {
            if (!empty($goToAction['enable'])) {
                echo template_part('goToAction', $goToAction);
            }
        }

        ?>
        <div class="packaging">
            <div class="vantage">
                <dl class="vantage-item">
                    <dt class="vantage-item__logo"><img src="<?= get_template_directory_uri() ?>/static/public/images/vantage/stores.svg" alt="stores"/></dt>
                    <dd class="vantage-item__text">57 stores nationwide</dd>
                </dl>
                <dl class="vantage-item">
                    <dt class="vantage-item__logo"><img src="<?= get_template_directory_uri() ?>/static/public/images/vantage/quote.svg" alt="quote"/></dt>
                    <dd class="vantage-item__text">free measure & quote</dd>
                </dl>
                <dl class="vantage-item">
                    <dt class="vantage-item__logo"><img src="<?= get_template_directory_uri() ?>/static/public/images/vantage/finance.svg" alt="finance"/></dt>
                    <dd class="vantage-item__text">finance options available</dd>
                </dl>
                <dl class="vantage-item">
                    <dt class="vantage-item__logo"><img src="<?= get_template_directory_uri() ?>/static/public/images/vantage/commercial.svg" alt="commercial"/></dt>
                    <dd class="vantage-item__text">expertise in all commercial sectors</dd>
                </dl>
                <dl class="vantage-item">
                    <dt class="vantage-item__logo"><img src="<?= get_template_directory_uri() ?>/static/public/images/vantage/quality.svg" alt="quality"/></dt>
                    <dd class="vantage-item__text">2019 Reader’s Digest Quality service award </dd>
                </dl>
            </div>
        </div>
        <div class="carpet-story">
            <div class="packaging">
                <h5 class="carpet-story__title">the carpet court story</h5>
                <div class="carpet-story__text">
                    <p>Carpet Court was founded in the 1960’s by a small group of like-minded flooring retailers looking to establish a better experience and provide greater value for our customers. Today our flourishing business has 57 stores nationwide with a reputation reflecting our longstanding presence in the market and the thousands of homes we have installed carpet and hardflooring into over the decades. </p>
                    <p>We are New Zealand’s most trusted and preferred flooring retailer and work hard to ensure our customers enjoy the process of purchasing flooring which can often be a confusing and stressful experience. Our Customer Service focus has been recognised by winning Gold (for the second year in a row) for flooring stores in the Reader’s Digest Quality Service Awards - an area we continually strive to improve upon. </p>
                </div>
            </div>
        </div>
    </main>


    <div class="g-search">
        <button type="button" class="btn search-opener ic-icon-cross"></button>
        <div class="container">
            <div class="search-wrap">
                <form class="search-form">
                    <input type="text" placeholder="type keyword(s) here">
                    <button type="submit" class="btn btn-submit">Search</button>
                </form>
            </div>
        </div>
    </div>

    <div class="swatch-gallery-wrap js-swatch-parent">
        <div class="swatch-gallery js-product-parent">
            <button aria-label="close modal" class="swatch-gallery__close js-show-swatch">
                <svg class="icon close">
                    <use xlink:href="#close"></use>
                </svg>
            </button>
            <div class="swatch-gallery__title">Swatch Gallery</div>
            <div class="swatch-gallery-inner">
                <ul class="swatch-gallery-thumbs">
                    <?php
                    if (!empty($currentColour) && !empty($relatedProducts)) { ?>
                        <?php if (!empty($colors)) : ?>
                            <?php foreach ($colors as $color) : ?>
                                <?php if ($color->term_id == $currentColour) : ?>
                                    <?php $color_image = get_term_meta( $color->term_id, 'cpm_color_thumbnail', true ); ?>

                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php foreach ($relatedProducts as $relatedProduct) : ?>
                                <?php
                                $relatedProductColour = get_field('current_colour', $relatedProduct);
                                $color = get_term_by('term_taxonomy_id', $relatedProductColour);
                                ?>
                                <?php if (!empty($color) && !empty($relatedProductColour)) : ?>
                                    <?php $color_image = get_term_meta($relatedProductColour, 'cpm_color_thumbnail', true ); ?>
                                    <li data-naming="<?= $color->name ?>" class="swatch-gallery-thumbs__item js-product-trigger" data-color="<?= $color->slug ?>">
                                        <div class="swatch-gallery-thumbs__img"><img src="<?= $color_image ?>" alt="<?= $color->name ?>"></div>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                   <?php }
                    else{
                        if (!empty($colors))
                            foreach ($colors as $color){
                                $color_image = get_term_meta( $color->term_id, 'cpm_color_thumbnail', true ); ?>
                                <li data-naming="<?= $color->name ?>" class="swatch-gallery-thumbs__item js-product-trigger" data-color="<?= $color->slug ?>">
                                    <div class="swatch-gallery-thumbs__img"><img src="<?= $color_image ?>" alt="<?= $color->name ?>"></div>
                                </li>
                            <?php }

                    }
                    ?>

                </ul>
                <div class="swatch-gallery__select js-select-color"></div>
                <div class="swatch-gallery-preview">
                    <?php
                    if (!empty($currentColour) && !empty($relatedProducts)) {
                        $image_count = 0; ?>
                        <?php if (!empty($colors)) : ?>
                            <?php foreach ($colors as $color) : ?>
                                <?php if ($color->term_id == $currentColour) : ?>
                                    <?php $color_image = get_term_meta( $color->term_id, 'cpm_color_thumbnail', true ); ?>

                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php foreach ($relatedProducts as $relatedProduct) : ?>
                                <?php
                                $relatedProductColour = get_field('current_colour', $relatedProduct);
                                $color = get_term_by('term_taxonomy_id', $relatedProductColour);
                                ?>
                                <?php if (!empty($color) && !empty($relatedProductColour)) : ?>
                                    <?php $color_image = get_term_meta($relatedProductColour, 'cpm_color_thumbnail', true ); ?>
                                    <div style="background-image:url('<?= $color_image ?>');" class="swatch-gallery-preview__item js-product-target"></div>
                                <?php  $image_count++; endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    <?php }
                    else {
                        $image_count = 0;
                    if (!empty($colors))
                        foreach ($colors as $color){
                            $color_image = get_term_meta( $color->term_id, 'cpm_color_thumbnail', true ); ?>
                            <div style="background-image:url('<?= $color_image ?>');" class="swatch-gallery-preview__item js-product-target"></div>
                            <?php
                            $image_count++;
                        }
                    }
                    ?>
                    <div style="background-image:url('<?= get_template_directory_uri() ?>/static/public/images/product-preview/product-preview.png');" data-trig-index="<?= $image_count?>" class="swatch-gallery-preview__item js-product-target"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
/**
 * woocommerce_after_single_product_summary hook.
 *
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */
//do_action( 'woocommerce_after_single_product_summary' );
?>

<?php
/**
 * woocommerce_before_single_product_summary hook.
 *
 * @hooked woocommerce_show_product_sale_flash - 10
 * @hooked woocommerce_show_product_images - 20
 */
//do_action( 'woocommerce_before_single_product_summary' );
?>


<?php
/**
 * woocommerce_single_product_summary hook.
 *
 * @hooked woocommerce_template_single_title - 5
 * @hooked woocommerce_template_single_rating - 10
 * @hooked woocommerce_template_single_price - 10
 * @hooked woocommerce_template_single_excerpt - 20
 * @hooked woocommerce_template_single_add_to_cart - 30
 * @hooked woocommerce_template_single_meta - 40
 * @hooked woocommerce_template_single_sharing - 50
 */
//do_action( 'woocommerce_single_product_summary' );
?>


<?php do_action( 'woocommerce_after_single_product' ); ?>
<script type="text/javascript">
      $(document).ready(function() {
    if (window.location.href.indexOf("/product/rugs/") > -1) {
      $('.product-price__unit').hide();
    }
  });
</script>