<?php
/**
 * Template Name: Blog page
 */
get_header();
$blogCategory = get_category_by_slug('blog');
$sort = get_field('blog_sort');
$filter = get_field('blog_filter');

$posts_per_page = 12;
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;


$cat = $_GET['cat_id'] ?? 'blog';
$catLabel = 'View all';
foreach ($filter as $item) {
	if (!empty($_GET['cat_id'])) {
		if ($item['slug'] == $_GET['cat_id']) {
			$cat = $_GET['cat_id'];
			$catLabel = $item['label'];
		}
	}
}

$orderBy = "date";
$order = "DESC";
$orderLabel = "Newest";
foreach ($sort as $item) {
	if (!empty($_REQUEST['sort']) && !empty($_REQUEST['type'])) {
		if ($item['orderby'] == $_REQUEST['sort'] && $item['order'] == $_REQUEST['type']) {
			$orderBy = $_REQUEST['sort'];
			$order = $_REQUEST['type'];
			$orderLabel = $item['label'];
		}
	}
}
$custom_query = new WP_Query(array(
	'posts_per_page' => $posts_per_page,
	'category_name' => $cat,
	'paged' => $paged,
	'post_status' => 'publish',
	'order' => $order,
	'orderby' => $orderBy
));

$big = 99999999999999;

$total_posts = $custom_query->found_posts;
$total_pages = $custom_query->max_num_pages;

$heroSlider = get_field('hero_slider');
?>
	<main class="g-main">
		<div class="section-hero">
			<div class="carousel-wrap cursor">
				<div class="carousel-slider">
                    <?php foreach ($heroSlider as $item) : ?>
                    <div class="slide">
                        <a href="#" >
                            <img src="<?= $item['image']['url']?>" class="slide-image hidden-xs-max">
                        </a>
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
		<div class="locator-hero-filter">
            <div class="filter-plate all <?= $cat === 'blog' ? 'active' : '' ?>"><a href="?cat_id=blog">View all</a></div>
            <div class="filter-plate fl <?= $cat === 'be-floored' ? 'active' : '' ?>"><a href="?cat_id=be-floored">Be Floored</a></div>
            <div class="filter-plate hd <?= $cat === 'be-handy' ? 'active' : '' ?>"><a href="?cat_id=be-handy">Be Handy</a></div>
            <div class="filter-plate st <?= $cat === 'be-styled' ? 'active' : '' ?>"><a href="?cat_id=be-styled">Be Styled</a></div>
            <div class="filter-plate dt <?= $cat === 'be-up-to-date' ? 'active' : '' ?>"><a href="?cat_id=be-up-to-date">Be Up To Date</a></div>
		</div>
        <div class="filter-mobile f-sorter">
            <button type="button" data-toggle="dropdown" aria-expanded="false" class="ic-down-arrow dropdown-toggle">Filter by: <div class="current-toggle"><?= $catLabel; ?>
                    <div class="f-dropdown-menu">
						<?php foreach ($filter as $item) : ?>
							<?php
							if ($item["label"] == $catLabel) {
								$label = '<span>'.$item["label"].'</span>';
							} else {
								$sorted_uri = esc_url(add_query_arg([
										'cat_id' => $item["slug"]
									]
								));
								$label = '<a href="'.$sorted_uri.'" >'.$item["label"].'</a>';
							}
							?>
                            <div class="drop-item"><?= $label ?></div>
						<?php endforeach; ?>
                    </div>
                </div></button>
        </div>
		<?php if (!empty($sort)) : ?>
            <div class="f-sorter display-mobile">
                <button type="button" data-toggle="dropdown" aria-expanded="false" class="ic-down-arrow dropdown-toggle">Sort by: <div class="current-toggle"><?= $orderLabel ?>
                        <div class="f-dropdown-menu">
							<?php foreach ($sort as $item) : ?>
								<?php
								if ($item["label"] == $orderLabel) {
									$label = '<span>'.$item["label"].'</span>';
								} else {
									$sorted_uri = esc_url(add_query_arg([
											'sort' => $item["orderby"],
											'type' => $item["order"],
										]
									));
									$label = '<a href="'.$sorted_uri.'" >'.$item["label"].'</a>';
								}
								?>
                                <div class="drop-item"><?= $label ?></div>
							<?php endforeach; ?>
                        </div>
                    </div></button>

            </div>
		<?php endif; ?>

		<div class="section-category blog-block">
			<div class="container">
                <div class="header-sort-wrap">
                    <div class="section-filter">
                        <div class="f-wrap">
                            <div class="counter">Items <?= 1 + ($paged-1) * $posts_per_page; ?> - <?= $paged*$posts_per_page > $total_posts ? $total_posts : $paged*$posts_per_page; ?> of <?= $total_posts; ?></div>
                            <?php if (!empty($sort)) : ?>
                                <div class="f-sorter display-pc">
                                    <button type="button" data-toggle="dropdown" aria-expanded="false" class="ic-down-arrow dropdown-toggle">Sort by: <div class="current-toggle"><?= $orderLabel ?>
                                            <div class="f-dropdown-menu">
												<?php foreach ($sort as $item) : ?>
													<?php
													if ($item["label"] == $orderLabel) {
														$label = '<span>'.$item["label"].'</span>';
													} else {
														$sorted_uri = esc_url(add_query_arg([
														        'sort' => $item["orderby"],
                                                                'type' => $item["order"],
                                                            ]
                                                        ));
														$label = '<a href="'.$sorted_uri.'" >'.$item["label"].'</a>';
													}
													?>
                                                    <div class="drop-item"><?= $label ?></div>
												<?php endforeach; ?>
                                            </div>
                                        </div></button>

                                </div>
							<?php endif; ?>
                        </div>
                    </div>
                </div>
				<div class="s-list js-card-wrapper">
                          <?php
                                while($custom_query->have_posts()) :
									$custom_query->the_post();
                              ?>
                        <div class="list-item"><a href="<?= get_permalink(); ?>" style="background-image: url(&quot;<?= get_the_post_thumbnail_url(); ?>&quot;)" class="card"></a>
                            <div class="card-filter-item-wrap">
								<?php foreach (get_the_category(get_the_ID()) as $item) :
                                    switch ($item->slug) {
                                        case 'be-floored':?>
                                            <div class="card-filter-item fl"><?= $item->cat_name?></div>
                                            <?php break;
                                        case 'be-handy':?>
                                            <div class="card-filter-item hd"><?= $item->cat_name?></div>
                                            <?php  break;
                                        case 'be-styled':?>
                                            <div class="card-filter-item st"><?= $item->cat_name?></div>
                                            <?php break;
                                        case 'be-up-to-date':?>
                                            <div class="card-filter-item dt"><?= $item->cat_name?></div>
                                           <?php break;

                                    }
                                    ?>

                                <?php endforeach; ?>
                            </div>
                            <div class="card-label">
                                <div class="card-label__part">
                                    <div class="card-blog-title"><?php the_title(); ?></div>
                                </div>
                                <div class="card-label__part">
                                    <div class="card-link"><?= the_excerpt()?></div>
                                </div>
                            </div>
                        </div>
                              <?php endwhile; ?>
				</div>
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
							'total'   => $custom_query->max_num_pages,
							'prev_text'    => __('<'),
							'next_text'    => __('>'),
						) );?>
                    </div>
                </nav>
            </div>


		</div>
	</main>
<?php
get_footer();