<?php
global $wp_query;
$big = 999999999; // need an unlikely integer
if( isset( $query_args['paged'] ) ) {
    $pagination = paginate_links(
            array(
                    'base' => home_url('/') . '?paged=%#%',
                    'format' => '?paged=%#%',
                    'current' => max(1, $query_args['paged'] ),
                    'total' => $product_query->max_num_pages,
                    'type' => 'array'
            )
    );

    $pattern1 = '/paged=[\d+]+/';

    $pattern2 = '/href=["\'](.*?)["\']/';

    if (!empty($pagination)) {
        echo "<div class=\"text-center\"><div class=\"page-navi\">";
        foreach ($pagination as $links) {

            preg_match($pattern1, $links, $matches);

            if (!empty($matches)) {

                $fetch_number = explode("=", $matches[0]);

                $links = preg_replace($pattern2, ' href="#" data-href="$1" data-pagenum="' . $fetch_number[1] . '"', $links);
                // echo $links;continue;
            }

            echo str_replace('page-numbers', 'page-numbers paginate_ajax', $links);

        }
    }
    echo "</div></div>";
}