<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Carpet_Court
 */

get_header(); ?>

    <div id="primary" class="content-area container">
        <main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', get_post_format() );

				the_post_navigation( array(
					'next_text' => '<span class="meta-nav" aria-hidden="true">Next article</span> ' .
						'<span class="screen-reader-text">Next article</span> ' ,
					'prev_text' => '<span class="meta-nav" aria-hidden="true">Previous article</span> ' .
						'<span class="screen-reader-text">Previous article</span> ',
				) );

			endwhile; // End of the loop.
			?>
            <div class="social-links"><span>Share</span>
                <img class="social-img" src="<?= get_template_directory_uri()?>/static/public/images/mail.png">
                <img class="social-img" src="<?= get_template_directory_uri()?>/static/public/images/tw.png">
                <img class="social-img" src="<?= get_template_directory_uri()?>/static/public/images/fb.png">

            <img class="social-img" src="<?= get_template_directory_uri()?>/static/public/images/pin.png">


            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
    <div class="relatedposts">
        <h3 class="related-articles">Related articles</h3>
		<?php

        $category_link = get_page_uri( 'blog');

        $orig_post = $post;
		global $post;
		$tags = wp_get_post_tags($post->ID);
		if ($tags) {
			$tag_ids = array();
			foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			$args=array(
				'tag__in' => $tag_ids,
				'post__not_in' => array($post->ID),
				'posts_per_page'=>4, // Number of related posts to display.
				'caller_get_posts'=>1
			);

			$my_query = new wp_query( $args );?>


				<?php
				while($my_query->have_posts()) :
					$my_query->the_post();
					?>
                    <div class="list-item display-pc">  <a rel="external" href="<?php the_permalink()?>"><?php the_post_thumbnail('large'); ?><br />
                        </a>
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
    <div class="mobile-slider">
		<?php
		while($my_query->have_posts()) :
			$my_query->the_post();
			?>
            <div class="list-item display-pcl">  <a rel="external" href="<?php the_permalink()?>"><?php the_post_thumbnail('large'); ?>
                </a >
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
                        <div class="card-link">Coastal inspired home..<a href="<?= get_permalink(); ?>" class="view-more">View more</a></div>
                    </div>
                </div>
            </div>


		<?php endwhile; ?>
    </div>
            <div class="more-wrap">
                <a href="<?= get_site_url().'/blog'; ?>" class="view-more-articles btn">View More articles</a>
            </div>
			<?php
		}
		$post = $orig_post;
		wp_reset_query();
		?>
    <script>
        jQuery(document).ready(function(){
            jQuery('.mobile-slider').slick({
                height: '100%',
                infinite: true,
                arrows: true,
                prevArrow: '<span class="btn-prev-mobile ic-nav-prev"></span>',
                nextArrow: '<span class="btn-next-mobile ic-nav-next"></span>',
                speed: 600,
                slidesToShow: 1,
                slidesToScroll: 1,
                rows: 0,
                dots: true,
                dotsClass: 'list-unstyled',
                customPaging: function() { return ''; },
                adaptiveHeight: true,
                autoplay: false,
                autoplaySpeed: 5000,
                pauseOnHover: false
        });
        });
    </script>
<?php
get_footer();
