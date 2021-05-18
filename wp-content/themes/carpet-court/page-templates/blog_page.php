<?php
/**
 * Template Name: Blog page
 */
get_header();
$hero = get_field('hero');
$blogSetting = get_field('blog');

$blogCategory = get_category_by_slug('blog');
$sort = get_field('blog_sort');
$filter = get_field('blog_filter');

$posts_per_page = 12;
if (!empty($blogSetting['per_page'])) {
    $posts_per_page = $blogSetting['per_page'];
}

$sort = [];
if (!empty($blogSetting['sort'])) {
    $sort = $blogSetting['sort'];
}
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;


$cat = $blogCategory->slug;
$blogLabel = get_field('category_title', $blogCategory);
$catLabel = $blogLabel;
if (!empty($_GET['cat'])) {
    $cat = $_GET['cat'];
    $catLabel = '';
}

$orderBy = "date";
$orderType = "DESC";
$orderLabel = "Newest";
$sortKey = 0;
foreach ($sort as $key => $item) {
    if (!empty($_REQUEST['sort']) && !empty($_REQUEST['type'])) {
        if ($item['sort'] == $_REQUEST['sort'] && $item['type'] == $_REQUEST['type']) {
            $orderBy = $_REQUEST['sort'];
            $orderType = $_REQUEST['type'];
            $orderLabel = $item['title'];
            $sortKey = $key;
        }
    }
}

$taxonomies = [
    'taxonomy' => 'category',
];

$args = [
    'child_of' => $blogCategory->cat_ID,
    'hide_empty' => false
];

$childTerms = get_terms($taxonomies, $args);

foreach ($childTerms as $term) {
    if ($cat == $term->slug) {
        $catLabel = $term->name;
    }
}

$blogQuery = new WP_Query([
    'posts_per_page' => $posts_per_page,
    'category_name' => $cat,
    'paged' => $paged,
    'post_status' => 'publish',
    'order' => $orderType,
    'orderby' => $orderBy
]);

$big = 99999999999999;

$posts = $blogQuery->get_posts();
$total_posts = $blogQuery->found_posts;
$total_pages = $blogQuery->max_num_pages;
/*
echo "<pre>";
print_r($posts);
echo "</pre>";
*/
?>
    <main class="g-main">
        <?php if (!empty($hero['enable'])) : ?>
            <?= template_part('hero', $hero); ?>
        <?php endif; ?>
        <?php if (!empty($childTerms)) : ?>
            <div class="">
                <div class="blog-filter">
                    <a href="<?= get_permalink() ?>" style="color: <?= get_field('color', $blogCategory) ?>" class="filter-plate all <?= $cat == $blogCategory->slug ? ' active ' : '' ?>">
                        <span><?= $blogLabel ?></span>
                    </a>
                    <?php foreach ($childTerms as $term) : ?>
                        <a href="<?= get_permalink() ?>?cat=<?= $term->slug ?>" style="color: <?= get_field('color', $term) ?>" class="filter-plate <?= $term->slug == $cat ? 'active' : '' ?>">
                            <span><?= get_field('category_title', $term) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="blog-filter-container">
            <?php if (!empty($childTerms)) : ?>
                <div class="blog-filter-mobile">
                    <div class="display-mobile f-sorter">
                        <button type="button" data-toggle="dropdown" aria-expanded="false" class="ic-down-arrow dropdown-toggle">
                            <span class="filter-label">Filter by:</span>
                            <div class="current-toggle">
                                <?= $catLabel; ?>
                                <div class="f-dropdown-menu">
                                    <div class="drop-item">
                                        <?php if ($cat != $blogCategory->slug) : ?>
                                            <a href="<?= get_permalink() ?>"><?= $blogLabel ?></a>
                                        <?php else : ?>
                                            <span><?= $blogLabel ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php foreach ($childTerms as $term) : ?>
                                        <?php
                                        $label = '';
                                        if ($term->slug == $cat) {
                                            $label =  '<span>'.get_field('category_title', $term).'</span>';
                                        } else {
                                            $label =  '<a href="'.get_permalink().'?cat='.$term->slug.'" >'.get_field('category_title', $term).'</a>';
                                        }
                                        ?>
                                        <div class="drop-item"><?= $label ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($sort)) : ?>
                <div class="blog-filter-mobile">
                    <div class="display-mobile f-sorter">
                        <button type="button" data-toggle="dropdown" aria-expanded="false" class="ic-down-arrow dropdown-toggle">
                            <span class="filter-label">Sort by:</span>
                            <div class="current-toggle">
                                <?= $orderLabel ?>
                                <div class="f-dropdown-menu">
                                    <?php foreach ($sort as $key => $item) : ?>
                                        <?php
                                        if ($sortKey == $key) {
                                            $label = '<span>'.$item["label"].'</span>';
                                        } else {
                                            $sorted_uri = esc_url(add_query_arg([
                                                    'sort' => $item["sort"],
                                                    'type' => $item["type"],
                                                ]
                                            ));
                                            $label = '<a href="'.$sorted_uri.'" >'.$item["title"].'</a>';
                                        }
                                        ?>
                                        <div class="drop-item"><?= $label ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="section-blog">
            <div class="container">
                <div class="header-sort-wrap">
                    <div class="section-filter">
                        <div class="f-wrap">
                            <div class="counter">Items <?= 1 + ($paged-1) * $posts_per_page; ?> - <?= $paged*$posts_per_page > $total_posts ? $total_posts : $paged*$posts_per_page; ?> of <?= $total_posts; ?></div>
                            <?php if (!empty($sort)) : ?>
                                <div class="f-sorter display-pc">
                                    <button type="button" data-toggle="dropdown" aria-expanded="false" class="ic-down-arrow dropdown-toggle">
                                        <span class="filter-label">Sort by:</span>
                                        <div class="current-toggle">
                                            <?= $orderLabel ?>
                                            <div class="f-dropdown-menu">
                                                <?php foreach ($sort as $key => $item) : ?>
                                                    <?php
                                                    if ($sortKey == $key) {
                                                        $label = '<span>'.$item["title"].'</span>';
                                                    } else {
                                                        $sorted_uri = esc_url(add_query_arg([
                                                                'sort' => $item["sort"],
                                                                'type' => $item["type"],
                                                            ]
                                                        ));
                                                        $label = '<a href="'.$sorted_uri.'" >'.$item["title"].'</a>';
                                                    }
                                                    ?>
                                                    <div class="drop-item"><?= $label ?></div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="s-list js-card-wrapper">
                    <?php foreach ($posts as $post) : ?>
                        <?php
                        $image[0] = "";
                        if (has_post_thumbnail($post->ID)) {
                            $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large');
                        }

                        $postCategories = wp_get_post_categories($post->ID);
                        ?>
                        <div class="list-item-container">
                            <div class="list-item">
                                <div>
                                    <a href="<?= get_permalink($post->ID); ?>" style="background-image: url(<?= $image[0]; ?>)" class="card"></a>
                                    <?php if (!empty($postCategories)) : ?>
                                        <div class="card-filter-item-wrap">
                                            <?php foreach ($childTerms as $term) : ?>
                                                <?php foreach ($postCategories as $postCategory) : ?>
                                                    <?php if ($term->term_id == $postCategory) : ?>
                                                        <div class="card-filter-item" style="color: <?= get_field('color', $term) ?>" ><?= $term->name; ?></div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-label">
                                        <div class="card-blog-title"><?= $post->post_title; ?></div>
                                        <?php if (!empty($post->post_excerpt)) : ?>
                                            <?php
                                            $excerpt = strip_tags($post->post_excerpt);
                                            $excerpt = substr($excerpt, 0, 50);
                                            $excerpt = rtrim($excerpt, "!,.-");
                                            $excerpt = substr($excerpt, 0, strrpos($excerpt, ' '));
                                            ?>
                                            <div class="card-blog-description"><?= $excerpt."…"; ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-link__part">
                                    <a href="<?= get_permalink($post->ID); ?>" class="card-link">View more</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="footer-wrap">
                    <div class="counter hide-mobile">Items <?= 1 + ($paged-1) * $posts_per_page; ?> - <?= $paged*$posts_per_page > $total_posts ? $total_posts : $paged*$posts_per_page; ?> of <?= $total_posts; ?></div>
                    <nav class="pagination-wrap">
                        <div class="pagination" >
                            <?php
                            echo paginate_links( array(
                                'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                'format'  => '?paged=%#%',
                                'current' => max( 1, get_query_var('paged') ),
                                'total'   => $total_pages,
                                'prev_text'    => __('<'),
                                'next_text'    => __('>'),
                            ) );?>
                        </div>
                    </nav>
                </div>
            </div>



        </div>
    </main>
    <!--
        <script>
            jQuery(document).ready(function(){
                jQuery('.carousel-slider-blog').slick({
                    height: '100%',
                    infinite: true,
                    arrows: true,
                    prevArrow: '<span class="btn-prev-hero ic-nav-prev"></span>',
                    nextArrow: '<span class="btn-next-hero ic-nav-next"></span>',
                    speed: 600,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    rows: 0,
                    dots: true,
                    dotsClass: 'my-dots',
                    customPaging: function() { return ''; },
                    adaptiveHeight: true,
                    autoplay: false,
                    autoplaySpeed: 5000,
                    pauseOnHover: false
            });
            });
        </script>
        -->
<?php
get_footer();