<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Carpet_Court
 */

get_header(); ?>
	<link href='http://fonts.googleapis.com/css?family=Monoton' rel='stylesheet' type='text/css'>
	<div id="primary" class="content-area container">
		<div class="row">
		<main id="main" class="site-main col-md-12" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title text-center">
                        <?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'carpet-court' ); ?>
                    </h1>
				</header><!-- .page-header -->

				<div class="page-content">

					<div class="error-notfound">
						<p id="error">E<span>r</span>ror</p>
						<p id="code">4<span>0</span><span>4</span></p>
					</div>
					<div class="notfound-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try our search once again ?', 'carpet-court' ); ?></p>

						<?php get_search_form();?>
					</div>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
		</div>
	</div><!-- #primary -->

<?php
get_footer();
