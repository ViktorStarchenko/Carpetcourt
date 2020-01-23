<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<?php // post_class(); ?>
	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
//	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	//do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * woocommerce_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	//do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
//	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	//do_action( 'woocommerce_after_shop_loop_item' );

	?>



<div class="product-card js-show-photo-parent">
    <div class="product-card-info">
        <!--<div class="product-card__subtitle"><?= get_the_terms($post->ID, 'product_brand')[0]->name ?></div>-->
        <h5 class="product-card__title"><?php the_title() ?></h5>
        <div class="product-card-color">
            <div class="product-card-color__title">Colour Range</div>
            <ul class="product-card-color__list" style="margin-left: 0">

                <?php
                $colors = get_the_terms( $product->id, 'pa_color' );
                if (!empty($colors))
                foreach ($colors as $color){
                  $color_image = get_term_meta( $color->term_id, 'cpm_color_thumbnail', true ); ?>
                    <li class="product-card-color__item js-show-photo-trigger">
                        <div style="-webkit-mask-image: url('<?= get_template_directory_uri() ?>/static/public/images/tooltip-color.svg');mask-image: url('<?= get_template_directory_uri() ?>/static/public/images/tooltip-color.svg'); background-image:url('<?= $color_image ?>');" class="product-card-color__tooltip">
                            <div class="product-card-color__tooltip-name"><?= $color->name ?></div>
                        </div>
                        <div class="product-card-color__img"><img style="min-width: 30px; min-height: 30px;" src="<?= $color_image ?>" alt="<?= $color->name ?>"/></div>
                    </li>
                <?php }
                ?>
            </ul>
        </div>
        <p class="product-card__description"><?php $text = get_the_excerpt(); $text = strWordCut($text, 170, get_the_permalink()); echo $text; ?></p>
        <ul class="product-card-features" style="margin-left: 0">
            <?php
          //  print_r( get_terms());
            $features = get_the_terms($post->ID, 'product_feature');
            if (!empty($features))
            foreach ($features as $feature){ ?>
                <li class="product-card-features__item"><?= $feature->name ?></li>
            <?php }
           ?>
        </ul><a href="<?php the_permalink(); ?>" class="product-card__link button">see the range</a>
    </div>
    <div class="product-card-photo"><img src="<?= get_field('featured_image') ?>" alt="product image"/>
        <div class="product-card-example">
            <div style="background-image:url('<?= get_template_directory_uri() ?>/static/public/images/product-tool/swatch.jpg');" class="product-card-example__item js-show-photo-target">
                <div class="product-card-example__item-name">Clare 1</div>
            </div>
            <div style="background-image:url('images/product-tool/swatch.jpg');" class="product-card-example__item js-show-photo-target">
                <div class="product-card-example__item-name">Clare 2</div>
            </div>
            <div style="background-image:url('images/product-tool/swatch.jpg');" class="product-card-example__item js-show-photo-target">
                <div class="product-card-example__item-name">Clare 3</div>
            </div>
            <div style="background-image:url('images/product-tool/swatch.jpg');" class="product-card-example__item js-show-photo-target">
                <div class="product-card-example__item-name">Clare 4</div>
            </div>
            <div style="background-image:url('images/product-tool/swatch.jpg');" class="product-card-example__item js-show-photo-target">
                <div class="product-card-example__item-name">Clare 5</div>
            </div>
            <div style="background-image:url('images/product-tool/swatch.jpg');" class="product-card-example__item js-show-photo-target">
                <div class="product-card-example__item-name">Clare 6</div>
            </div>
        </div>
    </div>
</div>

<?php

?>