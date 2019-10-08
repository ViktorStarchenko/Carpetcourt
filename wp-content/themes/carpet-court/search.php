<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Carpet_Court
 */

get_header(); ?>

<section id="primary" class="content-area container">
    <main id="main" class="site-main row" role="main">
        <div class="col-md-12">

            <?php
            if ( have_posts() ) : ?>

                <header class="page-header">
                    <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'carpet-court' ), '<span>' . $_GET['s'] . '</span>' ); ?></h1>
                </header><!-- .page-header -->
                <?php
                echo '<ul class="results-list">';
                    /* Start the Loop */
                    while ( have_posts() ) : the_post();

                        /**
                         * Run the loop for the search to output the results.
                         * If you want to overload this in a child theme then include a file
                         * called content-search.php and that will be used instead.
                         */
                        get_template_part( 'template-parts/content', 'search' );

                    endwhile;
                echo '</ul>';
                the_posts_navigation();

            else :

                get_template_part( 'template-parts/content', 'none' );

            endif; ?>
        </div>
    </main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();
