<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Carpet_Court
 */

?>
<?php
 $articleHeader = get_field('article_header');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
        <div class="upper-header">
            <div class="upper-title"><?= $articleHeader['upper_title'];?></div>
            <div class="cat-labels">
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
        </div>
        <h1><?= $articleHeader['main_title'];?></h1>
        <div class="bottom-title"><?= $articleHeader['bottom_title'];?></div>
        <img src="<?= $articleHeader['image']['url'];?>">
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'carpet-court' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'carpet-court' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php carpet_court_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
