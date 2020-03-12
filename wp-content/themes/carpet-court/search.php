<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Carpet_Court
 */

get_header(); ?>
<section id="primary" class="content-area container cpm-margin-no-slider">
    <main id="main" class="site-main row" role="main">
        <div class="col-md-12">
            <?php
            if ( isset( $_REQUEST['s'] ) && !empty( $_REQUEST['s'] ) ) {
                $squery = new WP_Query( array(
                        's' => $_REQUEST['s'],
                        'posts_per_page' => -1
                    )
                );

                $page_array = array();
                $post_array = array();
                $product_array = array();
                $removal_array = array();
                $cc_tips_array = array();

                if ( $squery->have_posts() ) {
                    ?>

                    <header class="page-header">
                        <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'carpet-court' ), '<span>' . $_REQUEST['s'] . '</span>' ); ?></h1>
                    </header><!-- .page-header -->
                    <?php
                    while ( $squery->have_posts() ) {
                        $squery->the_post();
                        //Page search
                        if ( get_post_type() == 'page' ) {
                            if ( !in_array( get_the_ID(), $page_array ) ) {
                                array_push( $page_array, get_the_ID() );
                            }
                        }
                        //Post search
                        if ( get_post_type() == 'post' ) {
                            if ( !in_array( get_the_ID(), $post_array ) ) {
                                array_push( $post_array, get_the_ID() );
                            }
                        }
                        //Product search
                        if ( get_post_type() == 'product' ) {
                            if ( !in_array( get_the_ID(), $product_array ) ) {
                                array_push( $product_array, get_the_ID() );
                            }
                        }
                        //Product search
                        if ( get_post_type() == 'stain_removal' ) {
                            if ( !in_array( get_the_ID(), $removal_array ) ) {
                                array_push( $removal_array, get_the_ID() );
                            }
                        }
                        //Tips search
                        if ( get_post_type() == 'cc_tips' ) {
                            if ( !in_array( get_the_ID(), $cc_tips_array ) ) {
                                array_push( $cc_tips_array, get_the_ID() );
                            }
                        }
                    }
                } else {
                    get_template_part( 'template-parts/content', 'none' );
                }
            } else {
                get_template_part( 'template-parts/content', 'none' );
            }


            if ( empty( $page_array ) && empty( $post_array ) && empty( $product_array ) && empty( $removal_array ) && empty( $cc_tips_array ) ) {
                get_template_part( 'template-parts/content', 'none' );
            } else {
                //posts display
                $post_type_array = array( 'product','page', 'post', 'stain_removal', 'cc_tips');
                foreach ( $post_type_array as $post_type ) {

                    $array_types = '';
                    if ( $post_type == 'post' ) {
                        $array_types = $post_array;
                    } elseif ( $post_type == 'product' ) {
                        $array_types = $product_array;
                    } elseif ( $post_type == 'page' ) {
                        $array_types = $page_array;
                    } elseif ( $post_type == 'cc_tips' ) {
                        $array_types = $cc_tips_array;
                    } elseif ( $post_type == 'stain_removal' ) {
                        $array_types = $removal_array;
                    }

                    if ( !empty( $array_types ) ) {
                        echo '<div class="search-results">';
                        $obj = get_post_type_object( $post_type );

                        $limit = 5;

                        if (!empty($_REQUEST["posts_type"]) && $_REQUEST["posts_type"] == $post_type) {
                            $limit = count( $array_types );
                        }

                        echo "<h3 class='cc-s-header'> Displaying ".count( $array_types )." ".$obj->labels->singular_name." Results</h3>";
                        echo '<ul class="results-list">';
                        foreach ($array_types as $post_key => $postID) {
                            if ( $post_key < $limit) {
                                $posts = get_post( $postID, ARRAY_A );
                                include( get_template_directory().'/template-parts/custom-content-'.$post_type.'.php');
                            }
                        }
                        echo '</ul>';

                        if ( count( $array_types ) > $limit) {
                            $get_permalink = home_url();
                            $search_url = add_query_arg( array( 's'=> $_REQUEST['s'], 'posts_type' => $post_type ), $get_permalink );
                            // $form_id = 'cc-cat-form-specials-'.$post_type;
                            ?>
                            <a href="<?php echo esc_url($search_url); ?>">Show All</a>
                            <?php
                        }
                        echo "</div>";
                    }
                }
                //end of posts display
            }

            ?>
        </div>
    </main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();
