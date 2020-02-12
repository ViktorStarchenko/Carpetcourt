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
    <?php

    ?>
    <h2 id="h2"></h2>
    <p><?php
        $url = get_permalink();
        $cat_slug = explode('/', $url)[4];
        $prod_term = get_term_by( 'slug', $cat_slug, 'product_cat' );
        echo $prod_term->description;
        ?>
    </p>
</div>
</div>


<style>
    .section-come{
        background-color: rgb(245, 246, 246);
        margin-top: 50px;
    }
</style>
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

<script src="<?= get_template_directory_uri() ?>/static/public/js/libs/jquery-3.2.1.min.js"></script>
<script src="<?= get_template_directory_uri() ?>/static/public/js/libs/slick.min.js"></script>
<script src="<?= get_template_directory_uri() ?>/static/public/js/libs/magnific-popup.min.js"></script>
<script src="<?= get_template_directory_uri() ?>/static/public/js/bootstrap.min.js"></script>
<script>
    document.getElementById('h2').innerText = document.getElementsByTagName('h1')[0].innerText;
</script>