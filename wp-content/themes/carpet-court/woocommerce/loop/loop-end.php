<?php
/**
 * Product Loop End
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-end.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
?>
<style>
    .page-numbers{
        text-decoration:none;color:#808487;font-family:Omnes-Regular;font-size:15px;letter-spacing:.16px;padding:11px 15px;text-align:center;
        border-right-color: rgb(227, 229, 231);
    }
    .woocommerce-pagination{
        display: none;
    }
</style>
</div>
</div>

<?php
global $wp_query;
$big = 999999999;
$pages = paginate_links(array(
    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
    'format' => '?page=%#%',
    'current' => max(1, get_query_var('paged')),
    'total' => $wp_query->max_num_pages,
    'prev_next' => false,
    'type' => 'array',
    'prev_next' => TRUE,
    'prev_text' => '<',
    'next_text' => '>',
));
if (is_array($pages)) {
    $current_page = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
    echo '<div class="pagination-wrap"><div class="pagination">';
    foreach ($pages as $i => $page) {
        if ($current_page == 1 && $i == 0) {
            echo "$page";
        } else {
            if ($current_page != 1 && $current_page == $i) {
                echo "$page";
            } else {
                echo "$page";
            }
        }
    }
    echo '</div></div>';
}
?>

<div class="category-content category-content--align_r">
    <h2><?php single_cat_title(); ?></h2>
    <p><?php
        $term_id = get_queried_object_id();
        $prod_term = get_term($term_id,'product_cat');
        echo $prod_term->description;
        ?>
    </p>
</div>
</div>
<div class="come-to-us">
    <div class="packaging">
        <div class="category-content category-content--center">
            <h2>Come to us, or we can come to you</h2>
            <p>Quis Aristidem non mortuum diligit? Primum divisit ineleganter; Sed utrum hortandus es nobis, Luci, inquit, an etiam tua sponte propensus es? Sed haec omittamus.</p>
        </div>
        <div class="come-to-us__bttns"><a href="<?= home_url()?>/measure-and-quote" class="button" style="margin: 10px">book an in-home consultation</a><a href="<?= home_url()?>/store-finder" class="button" style="margin: 10px">find a store near you</a></div>
    </div>
</div>
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
                <li data-naming="Honey Parquet 0" class="swatch-gallery-thumbs__item js-product-trigger">
                    <div class="swatch-gallery-thumbs__img"><img src="<?= get_template_directory_uri() ?>/static/public/images/colors/color-1.png" alt="color"></div>
                </li>
                <li data-naming="Honey Parquet 1" class="swatch-gallery-thumbs__item js-product-trigger">
                    <div class="swatch-gallery-thumbs__img"><img src="<?= get_template_directory_uri() ?>/static/public/images/colors/color-2.png" alt="color"></div>
                </li>
                <li data-naming="Honey Parquet 2" class="swatch-gallery-thumbs__item js-product-trigger">
                    <div class="swatch-gallery-thumbs__img"><img src="<?= get_template_directory_uri() ?>/static/public/images/colors/color-3.png" alt="color"></div>
                </li>
                <li data-naming="Honey Parquet 3" class="swatch-gallery-thumbs__item js-product-trigger">
                    <div class="swatch-gallery-thumbs__img"><img src="<?= get_template_directory_uri() ?>/static/public/images/colors/color-4.png" alt="color"></div>
                </li>
                <li data-naming="Honey Parquet 4" class="swatch-gallery-thumbs__item js-product-trigger">
                    <div class="swatch-gallery-thumbs__img"><img src="<?= get_template_directory_uri() ?>/static/public/images/colors/color-5.png" alt="color"></div>
                </li>
                <li data-naming="Honey Parquet 5" class="swatch-gallery-thumbs__item js-product-trigger">
                    <div class="swatch-gallery-thumbs__img"><img src="<?= get_template_directory_uri() ?>/static/public/images/colors/color-6.png" alt="color"></div>
                </li>
            </ul>
            <div class="swatch-gallery__select js-select-color"></div>
            <div class="swatch-gallery-preview">
                <div style="background-image:url('<?= get_template_directory_uri() ?>/static/public/images/product-preview/product-preview.png');" class="swatch-gallery-preview__item js-product-target"></div>
                <div style="background-image:url('<?= get_template_directory_uri() ?>/static/public/images/product-preview/product-preview.png');" class="swatch-gallery-preview__item js-product-target"></div>
                <div style="background-image:url('<?= get_template_directory_uri() ?>/static/public/images/product-preview/product-preview.png');" class="swatch-gallery-preview__item js-product-target"></div>
                <div style="background-image:url('<?= get_template_directory_uri() ?>/static/public/images/product-preview/product-preview.png');" class="swatch-gallery-preview__item js-product-target"></div>
                <div style="background-image:url('<?= get_template_directory_uri() ?>/static/public/images/product-preview/product-preview.png');" class="swatch-gallery-preview__item js-product-target"></div>
                <div style="background-image:url('<?= get_template_directory_uri() ?>/static/public/images/product-preview/product-preview.png');" data-trig-index="5" class="swatch-gallery-preview__item js-product-target"></div>
            </div>
        </div>
    </div>
</div>
<script src="<?= get_template_directory_uri() ?>/static/public/js/libs/jquery-3.2.1.min.js"></script>
<script src="<?= get_template_directory_uri() ?>/static/public/js/libs/slick.min.js"></script>
<script src="<?= get_template_directory_uri() ?>/static/public/js/libs/magnific-popup.min.js"></script>
<script src="<?= get_template_directory_uri() ?>/static/public/js/bootstrap.min.js"></script>
<script src="<?= get_template_directory_uri() ?>/static/public/js/app.min.js"></script>