<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Carpet_Court
 */

$ID = get_the_ID();
$posts_per_page = 4;
$blogCategory = get_category_by_slug('blog');
$categories = wp_get_post_categories($ID);
$childTerms = get_categories();

$catIDs = [];
foreach ($categories as $category) {
    $catIDs[] = $category->term_id;
}

$blogQuery = new WP_Query([
    'posts_per_page' => $posts_per_page,
    'cat' => $catIDs,
    'post__not_in' => [$ID],
    'post_status' => 'publish'
]);

$big = 99999999999999;

$relatedPosts = $blogQuery->get_posts();
$total_posts = $blogQuery->found_posts;
$total_pages = $blogQuery->max_num_pages;

$url = get_permalink();
$title = get_the_title();

get_header(); ?>
    <div id="primary" class="content-area container">
        <main id="main" class="site-main" role="main">
            <div class="article-head">
                <div class="article-subtitle">
                    <p class=""><?= $blogCategory->name ?></p>
                    <div class="article-categories">
                        <?php if (!empty($categories)) : ?>
                            <div class="card-filter-item-wrap">
                                <?php foreach ($childTerms as $term) : ?>
                                    <?php foreach ($categories as $postCategory) : ?>
                                        <?php if ($term->term_id == $postCategory) : ?>
                                            <div class="card-filter-item" style="color: <?= get_field('color', $term) ?>" ><?= $term->name; ?></div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <h1><?= $title ?></h1>
            </div>
            <?php
                $image[0] = "";
                if (has_post_thumbnail($post->ID)) {
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($ID),'large');
                }
            ?>
            <?php if (!empty($image[0])) : ?>
                <div class="article-image">
                    <img src="<?= $image[0] ?>" alt="<?= $title ?>" />
                </div>
            <?php endif; ?>
            <div class="article-container">
                <div class="entry-content">
                    <?= apply_filters('the_content', $post->post_content); ?>
                </div>
                <div class="article-navigation">
                    <?php
                    $previous = get_previous_post();
                    $next = get_next_post();
                    ?>
                    <?php if (!empty($previous)) : ?>
                    <a href="<?= get_permalink($previous->ID) ?>" class="article-prev">
                        <div class="article-navigation-icon ic-arrow-left"></div>
                        <div>Previous article</div>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($next)) : ?>
                    <a href="<?= get_permalink($next->ID) ?>" class="article-next">
                        <div>Next article</div>
                        <div class="article-navigation-icon ic-arrow-right"></div>
                    </a>
                    <?php endif; ?>
                </div>
                <div class="social-links">
                    <div>Share</div>
                    <div class="social-items">
                        <a href="mailto:?subject=View website: <?= $title ?>&body=View website link: <?= $url ?>" class="ic-email"></a>
                        <a href="https://twitter.com/intent/tweet?text<?= $title ?>&url=<?= $url ?>" class="ic-twitter social-share-link"></a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $title ?>&t=<?= $url ?>&v=3" class="ic-facebook social-share-link"></a>
                        <a href="https://pinterest.com/pin/create/button/?url=<?= $url ?>&media=<?= $image[0] ?>&description=<?= $title ?>" class="ic-pinterest social-share-link"></a>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <?php if (!empty($relatedPosts)) : ?>
    <div class="related-posts section-blog">
        <div class="container">
            <h3 class="related-articles">Related articles</h3>
            <div class="desktop-related">
                <div class="s-list js-card-wrapper ">
                    <?php foreach ($relatedPosts as $post) : ?>
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
            </div>
            <div class="mobile-related">
                <div class="s-list js-card-wrapper ">
                    <?php foreach ($relatedPosts as $post) : ?>
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
            </div>
            <div class="more-wrap">
                <a href="<?= home_url().'/blog'; ?>" class="view-more-articles btn">View More articles</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php
get_footer();
