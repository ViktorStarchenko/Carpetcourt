<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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
        .g-main{
            padding-top: 57px !important;
        }
        @media (max-width: 1279px){
            .g-main{
                padding-top: 43px !important;
            }
        }
        .filter-item__label{
            padding-left: 30px;
        }
        .filter-item__label::before{
            position: absolute;
            left: 0;
            top: 1px;
        }

        .crumps-list {
            margin-bottom: 0px;
            margin-left: 0
        }
        @media (min-width: 468.1px) {
            .crumps-list {
                margin-left: 0;
                padding: 15px 0px;
            }
           .packaging .category-grid {
                border-top: 1px solid rgba(219, 219, 219, .5);
            }
        }
        @media (max-width: 468px) {
            .crumps-list {
                text-align: center;
                padding: 25px 0px 0px;
                margin-left: 40%;
            }
        }
        .crumps-list__item:not(:last-child)::after {
            content:"/";
        }
        .crumps-list__item a {
            text-transform:capitalize;
        }
    </style>

    <main class="g-main">
    <!-- SVG Sprite-->
    <div style="display: none;" class="svg-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><symbol id="arrow_right"><path fill="#fff" d="M8.808 1.242a.42.42 0 01.604-.584l3.885 4.015a.42.42 0 01.116.328.603.603 0 01.002.044c0 .266-.175.484-.396.5L9.412 9.276a.42.42 0 11-.604-.584l3.042-3.148H1.06c-.232 0-.42-.224-.42-.5s.188-.5.42-.5h10.944z"/></symbol><symbol id="close"><path fill="currentColor" d="M27.296.654L15 12.938 2.705.654a1.45 1.45 0 00-2.05 2.052L12.961 15 .655 27.295a1.45 1.45 0 102.05 2.051L15 17.062l12.296 12.284a1.45 1.45 0 102.05-2.051L17.038 15 29.345 2.706a1.45 1.45 0 10-2.05-2.052z"/></symbol><symbol id="drop_arrow"><path d="M11.045.77a.507.507 0 01.704.729L6.346 6.718a.506.506 0 01-.704 0L.244 1.498A.506.506 0 11.948.77l5.046 4.88z"/></symbol><symbol id="finger-down"><path fill="currentColor" d="M13.168 7.656a1.478 1.478 0 01-1.08.455H9.87a1.333 1.333 0 00.152.367 6.593 6.593 0 01.3.59c.051.117.101.277.152.479.051.202.076.404.076.606a3.42 3.42 0 01-.044.67c-.024.16-.056.292-.096.399-.04.106-.104.226-.192.359a1.12 1.12 0 01-.32.323 1.756 1.756 0 01-.48.207 2.397 2.397 0 01-.66.084.493.493 0 01-.36-.152 1.385 1.385 0 01-.273-.399 2.37 2.37 0 01-.156-.414 7.701 7.701 0 01-.1-.487 20.007 20.007 0 00-.108-.483 2.546 2.546 0 00-.14-.386 1.222 1.222 0 00-.248-.383c-.176-.176-.445-.495-.808-.957a14.65 14.65 0 00-.808-.966c-.278-.303-.48-.46-.608-.47a.525.525 0 01-.344-.164.48.48 0 01-.144-.347V1.474c0-.138.05-.256.152-.355a.53.53 0 01.36-.155C5.36.958 5.782.84 6.438.612c.41-.138.732-.243.964-.314a9.91 9.91 0 01.972-.232c.416-.082.8-.124 1.152-.124h1.032c.71.011 1.235.219 1.577.623.31.367.44.848.392 1.443.208.197.352.447.432.75.09.324.09.636 0 .933.245.325.36.689.344 1.093 0 .17-.04.372-.12.607.294.335.44.73.44 1.188 0 .415-.152.774-.455 1.077zM1.333 7.09a.493.493 0 01-.36-.152.49.49 0 01-.152-.359V1.474a.49.49 0 01.152-.36.494.494 0 01.36-.15h2.305c.138 0 .258.05.36.15a.49.49 0 01.152.36v5.105a.49.49 0 01-.152.359.493.493 0 01-.36.152zm1.384-4.958a.5.5 0 00-.36-.148.495.495 0 00-.364.148.492.492 0 00-.148.363.5.5 0 00.148.359c.099.1.22.152.364.152.14 0 .26-.051.36-.152a.49.49 0 00.153-.36.485.485 0 00-.153-.362z"/></symbol><symbol id="finger-up"><path fill="currentColor" d="M13.012 6.046c0 .457-.146.853-.44 1.188.08.234.12.436.12.607.016.404-.099.768-.344 1.092.09.298.09.61 0 .934a1.55 1.55 0 01-.432.75c.048.595-.083 1.076-.392 1.443-.342.404-.867.612-1.577.622H8.915c-.352 0-.736-.041-1.152-.123a10.21 10.21 0 01-.972-.232 44.448 44.448 0 01-.964-.315c-.656-.229-1.078-.346-1.264-.35a.53.53 0 01-.36-.156.477.477 0 01-.153-.355V6.038a.48.48 0 01.144-.347.525.525 0 01.345-.164c.128-.01.33-.167.608-.47.277-.304.546-.625.808-.966.363-.462.632-.781.808-.957.096-.096.179-.223.248-.383.07-.16.116-.288.14-.387.024-.098.06-.259.108-.482a7.7 7.7 0 01.1-.487c.03-.117.082-.255.156-.415a1.39 1.39 0 01.272-.398.493.493 0 01.36-.152c.246 0 .466.028.66.084.196.056.356.125.481.207.125.083.232.19.32.323s.152.253.192.36c.04.105.072.238.096.398a3.42 3.42 0 01.044.67c0 .202-.025.404-.076.606-.05.202-.101.362-.152.479a6.588 6.588 0 01-.3.59 1.335 1.335 0 00-.152.367h2.217c.416 0 .776.152 1.08.455.303.303.455.662.455 1.077zm-9.985-.51c.138 0 .258.05.36.15a.49.49 0 01.152.36v5.105a.49.49 0 01-.152.359.493.493 0 01-.36.151H.722a.494.494 0 01-.36-.151.49.49 0 01-.152-.359V6.046a.49.49 0 01.152-.36.493.493 0 01.36-.15zm-.769 4.594a.49.49 0 00-.152-.36.493.493 0 00-.36-.15.489.489 0 00-.364.15.496.496 0 00-.148.36c0 .143.05.264.148.363.099.098.22.147.364.147a.5.5 0 00.36-.147.485.485 0 00.152-.363z"/></symbol><symbol id="star"><path d="M9.834 1.049c.21-.645 1.122-.645 1.332 0l1.983 6.105a.7.7 0 00.666.483h6.419c.678 0 .96.868.411 1.267l-5.193 3.773a.7.7 0 00-.254.782l1.984 6.105c.21.645-.529 1.181-1.078.782l-5.193-3.773a.7.7 0 00-.822 0l-5.193 3.773c-.549.399-1.287-.137-1.078-.782l1.984-6.105a.7.7 0 00-.254-.783L.355 8.904c-.549-.399-.267-1.267.411-1.267h6.419a.7.7 0 00.666-.483z" fill="currentcolor" stroke="#f13e4b"/></symbol></svg></div>
    <?php $term = get_queried_object(); ?>
    <div style="background-image:url(<?= get_field('category_banner', $term) ?>);" class="category-head">
        <h1><?php single_cat_title(); ?></h1>
    </div>
    <div class="packaging"> 
        <div class="crumps">
            <ul class="crumps-list" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li class="crumps-list__item" itemprop="itemListElement" itemscope
                    itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="<?= home_url() .'/product-filter' ?>">
                         <span itemprop="name">
                        Shop
                         </span>
                        <meta itemprop="position" content="1" />
                    </a>
                </li>
                <li class="crumps-list__item" itemprop="itemListElement" itemscope
                    itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="<?= get_category_link($term->term_id); ?>">
                         <span itemprop="name">
                        <?= $term->name; ?>
                         </span>
                        <meta itemprop="position" content="2" />
                    </a>
                </li>
            </ul>
        </div>
    <div class="category-grid">
    <div class="category-grid__sidebar js-accordeon-wrap">
        <button class="js-accordeon-title filters-wrap-btn">Filter By</button>
        <form class="filters-wrap js-accordeon-content js-accordeon-wrap">
            <div class="filter">
                <p class="filter-title js-accordeon-title is-opened">Type<span class="filter-title__icon">
											<svg class="icon drop_arrow">
												<use xlink:href="#drop_arrow"></use>
											</svg></span></p>
                <div class="js-accordeon-content" id="t">
                    <div class="filter-content">
                        <?php $all_cats = get_categories(['taxonomy' => 'product_cat']);
                        $cur_cat_id = get_queried_object_id();
                        $num = 0;
                        foreach ($all_cats as $category){
                            ?>
                            <div class="filter-item"  onchange="filter('t')">
                                <input type="radio" name="Type" id="Type<?= $num?>" class="filter-item__input" <?php if($category->term_id == $cur_cat_id) echo "checked"; ?> slug="<?= $category->slug ?>" />
                                <label for="Type<?= $num?>" class="filter-item__label"><?= $category->name ?></label>
                            </div>
                            <?php
                            $num++;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!--
            <div class="filter">
                <p class="filter-title js-accordeon-title">Lifestyle<span class="filter-title__icon">
											<svg class="icon drop_arrow">
												<use xlink:href="#drop_arrow"></use>
											</svg></span></p>
                <div class="js-accordeon-content" id="l">
                    <div class="filter-content">
                        <?php
                        $lifestyles = explode(', ', 'Quiet Life, Affordable Life, Family Life, Busy Life, High Life, Holiday Life');
                        $num = 0;
                        $get_lifestyles = $_GET['lifestyle'];
                        $checked_lifestyles = explode(' ', $get_lifestyles);
                        foreach ($lifestyles as $lifestyle){ ?>
                            <div class="filter-item" onchange="filter('l')">
                                <input type="checkbox" name="Lifestyle" id="Features<?= $num ?>" class="filter-item__input" lifestyle="<?= str_replace(' ', '-', strtolower($lifestyle)) ?>" <?php if(in_array(str_replace(' ', '-', strtolower($lifestyle)), $checked_lifestyles)) echo 'checked'; ?>/>
                                <label for="Features<?= $num ?>" class="filter-item__label"><?= $lifestyle ?></label>
                            </div>
                            <?php
                            $num++;
                        }
                        ?>
                    </div>
                </div>
            </div>
            -->
            <?php if ($cur_cat_id == 7){ ?>
            <div class="filter">
                <?php
                $fibre_slugs = array();
                $all_fibre = get_terms(['taxonomy' => 'pa_fibres']);
                $num = 0;
                $get_fibre = $_GET['fibre'];
                $checked_fibre = explode(' ', $get_fibre);
                ?>
                <p class="filter-title js-accordeon-title <?php if ($get_fibre) echo 'is-opened'; ?>">Fibre<span class="filter-title__icon">
											<svg class="icon drop_arrow">
												<use xlink:href="#drop_arrow"></use>
											</svg></span></p>
                <div class="js-accordeon-content" id="fb">
                    <div class="filter-content">
                        <?php foreach ($all_fibre as $c_fibre){ ?>
                            <div class="filter-item" onchange="filter('fb')">
                                <input type="checkbox" name="Fibre" id="Fibre<?= $num ?>" class="filter-item__input" fibre="<?= $c_fibre->slug ?>" <?php if(in_array($c_fibre->slug, $checked_fibre)) echo 'checked'; ?>/>
                                <label for="Fibre<?= $num ?>" class="filter-item__label"><?= $c_fibre->name ?></label>
                            </div>
                            <?php
                            $num++;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!--
            <div class="filter">
                <?php
                $colour_slugs = array();
                $all_colours = get_terms(['taxonomy' => 'product_color']);
                $num = 0;
                $get_colours = $_GET['colour'];
                $checked_colours = explode(' ', $get_colours);
                ?>
                <p class="filter-title js-accordeon-title <?php if ($get_colours) echo 'is-opened'; ?>">Colours<span class="filter-title__icon">
											<svg class="icon drop_arrow">
												<use xlink:href="#drop_arrow"></use>
											</svg></span></p>
                <div class="js-accordeon-content" id="c">
                    <div class="filter-content">
                        <?php foreach ($all_colours as $c_colour){ ?>
                            <div class="filter-item" onchange="filter('c')">
                                <input type="checkbox" name="Colours" id="Colours<?= $num ?>" class="filter-item__input" colour="<?= $c_colour->slug ?>" <?php if(in_array($c_colour->slug, $checked_colours)) echo 'checked'; ?>/>
                                <label for="Colours<?= $num ?>" class="filter-item__label"><?= $c_colour->name ?></label>
                            </div>
                            <?php
                            $num++;
                        }
                        ?>
                    </div>
                </div>
            </div>
            -->
            <div class="filter">
                <?php
                $feature_slugs = array();
                $all_features = get_terms(['taxonomy' => 'product_feature']);
                $num = 0;
                $get_features = $_GET['feature'];
                $checked_features = explode(' ', $get_features);
                ?>
                <p class="filter-title js-accordeon-title <?php if ($get_features) echo 'is-opened'; ?>">Features<span class="filter-title__icon">
											<svg class="icon drop_arrow">
												<use xlink:href="#drop_arrow"></use>
											</svg></span></p>
                <div class="js-accordeon-content" id="f">
                    <div class="filter-content">
                        <?php foreach ($all_features as $c_feature){ ?>
                            <div class="filter-item" onchange="filter('f')">
                                <input type="checkbox" name="Features" id="Features<?= $num ?>" class="filter-item__input" feature="<?= $c_feature->slug ?>" <?php if(in_array($c_feature->slug, $checked_features)) echo 'checked'; ?>/>
                                <label for="Features<?= $num ?>" class="filter-item__label"><?= $c_feature->name ?></label>
                            </div>
                            <?php
                            $num++;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="category-grid__main">

    <script>
        function filter(field) {
            var cur_url = window.location.href;
            var url = cur_url.split('?');
            var new_url = '';// = '?a=' + field;
            var i;

            var radios = document.getElementsByName('Type');
            for (i = 0, length = radios.length; i < length; i++) {
                if (radios[i].checked) {
                    var curRadioId = radios[i].id;
                    break;
                }
            }
            curRadioItem = document.getElementById(curRadioId);
            var slug = curRadioItem.getAttribute('slug');


            var curCheckboxId;
            var curCheckboxItem;
            var checkboxes;
            var first;
            var delimiter = '?';

            //fibre
            if (slug == 'carpet') {
                checkboxes = document.getElementsByName('Fibre');
                first = '';
                var fibre = delimiter + 'fibre=';
                for (i = 0, length = checkboxes.length; i < length; i++) {
                    if (checkboxes[i].checked) {
                        curCheckboxId = checkboxes[i].id;
                        curCheckboxItem = document.getElementById(curCheckboxId);
                        fibre += first;
                        first = '+';
                        fibre += curCheckboxItem.getAttribute('fibre');
                    }
                }
                if (first == '+') {
                    new_url += fibre;
                    delimiter = '&';
                }
            }

            //colours
            /*
            checkboxes = document.getElementsByName('Colours');
            first = '';
            var colour = delimiter + 'colour=';
            for (i = 0, length = checkboxes.length; i < length; i++) {
                if (checkboxes[i].checked) {
                    curCheckboxId = checkboxes[i].id;
                    curCheckboxItem = document.getElementById(curCheckboxId);
                    colour += first;
                    first = '+';
                    colour += curCheckboxItem.getAttribute('colour');
                }
            }
            if (first == '+'){
                new_url += colour;
                delimiter = '&';
            }
            */

            //features
            checkboxes = document.getElementsByName('Features');
            first = '';
            var feature = delimiter + 'feature=';
            for (i = 0, length = checkboxes.length; i < length; i++) {
                if (checkboxes[i].checked) {
                    curCheckboxId = checkboxes[i].id;
                    curCheckboxItem = document.getElementById(curCheckboxId);
                    feature += first;
                    first = '+';
                    feature += curCheckboxItem.getAttribute('feature');
                }
            }
            if (first == '+'){
                new_url += feature;
                delimiter = '&';
            }

            window.location.replace("<?= home_url(); ?>/products/" + slug + new_url);
        }

        /*
        window.addEventListener("load", function(){
            var url_string = window.location.href;
            var url = new URL(url_string);
            var a = url.searchParams.get("a");

            switch (a){
                case 'f': {document.getElementById('t').style.display = "none"; document.getElementById('f').style.display = "block"; break}
                case 'fb': {document.getElementById('t').style.display = "none"; document.getElementById('fb').style.display = "block"; break}
                case 'c': {document.getElementById('t').style.display = "none"; document.getElementById('c').style.display = "block"; break}
            }
        });
         */
    </script>

<?php
global $wp_query;

$add_attr = array(
    'tax_query' => array(
    'relation' => 'AND',
),);


//fibre
if ($_GET['fibre']){
    $feature_array = array(
        'taxonomy' => 'pa_fibres',
        'field' => 'name',
        'terms' => $checked_fibre,
    );
    $add_attr['tax_query'][] = $feature_array;
}

/*
if ($_GET['colour']){
    $feature_array = array(
        'taxonomy' => 'product_color',
        'field' => 'name',
        'terms' => $checked_colours,
    );
    $add_attr['tax_query'][] = $feature_array;
}
*/

//features
if ($_GET['feature']) {
    $feature_array = array(
        'taxonomy' => 'product_feature',
        'field' => 'slug',
        'terms' => $checked_features,
    );
    $add_attr['tax_query'][] = $feature_array;
}

$args = array_merge( $wp_query->query_vars, $add_attr );

query_posts( $args );
?>

