<?php
global $wpsl_settings, $wpsl;
$autoload_class = (!$wpsl_settings['autoload']) ? 'wpsl-not-loaded' : '';

$selectedRetailerId = null;
if (isset($_GET['retailer_id'])) {
    $selectedRetailerId = $_GET['retailer_id'];
}

$postId = null;
if (isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];
} else if (isset($_GET['range'])) {
    $rangePost = get_page_by_path( $_GET['range'], OBJECT, 'post' );
    if (!is_null($rangePost)) {
        $postId = $rangePost->ID;
    }
}

$collectionId = null;
if (isset($_GET['collection_id'])) {
    $collectionId = $_GET['collection_id'];
} else if (isset($_GET['collection'])) {
    $collectionPost = get_page_by_path( $_GET['collection'], OBJECT, 'post' );
    if (!is_null($collectionPost)) {
        $collectionId = $collectionPost->ID;
    }
}

$query = null;
if (isset($_GET['address'])) {
    $query = $_GET['address'];
}

$retailersGroupCategory = get_category_by_slug('retailer-groups');
$metaQuery = [
    [
        'key'     => 'enable',
        'value'   => true,
        'compare' => '=',
    ],
];

/*
if ($postId) {
    $metaQuery[] = [
        [
            'key'     => 'range',
            'value'   => '"' . $postId . '"',
            'compare' => 'LIKE',
        ],
    ];
}
if ($collectionId) {
    $metaQuery[] = [
        [
            'key'     => 'collections',
            'value'   => '"' . $collectionId . '"',
            'compare' => 'LIKE',
        ],
    ];
}*/

$args = [
    'numberposts'   => -1,
    'category'      => $retailersGroupCategory->cat_ID,
    'post__in'      => get_field('retailers_groups_filter_order'),
    'meta_query'    => $metaQuery,
    'orderby'       => 'post__in'
];

$retailers = get_posts($args);

/*

$matressesCategory = get_category_by_slug('Beds');
$matresses = get_posts(['numberposts' => -1, 'category' => $matressesCategory->cat_ID]);

$collectionsCategory = get_category_by_slug('sleep-collections');
$collections = get_posts(['numberposts' => -1, 'category' => $collectionsCategory->cat_ID]);
*/

ob_start();
?>
    <style>
        #wpsl-stores {
            display: block !important;
        }
        #wpsl-direction-details {
            display: none !important;
        }
    </style>

     <?php /*
                        <div class="app-store-filter__title"><span>Mattresses</span></div>
                        <div class="app-store-filter__list">
                            <?php foreach ($matresses as $matresse): ?>
                                <ul class="app-store-filter__list-nav">
                                    <li><label class="app-button-filter _inline<?= $matresse->ID == $postId ? ' active' : '' ?>"><?= $matresse->post_title ?>
                                            <input type="checkbox" name="range" value="<?= $matresse->ID ?>" <?= $matresse->ID == $postId ? ' checked="checked"' : '' ?> style="display: none;"/>
                                        </label></li>

                                    <?php $subRanges = get_field('sub_ranges', $matresse); ?>
                                    <?php foreach ($subRanges as $subRange): ?>
                                        <?php $lowerCase = preg_match('/([0-9]+)i/', $subRange->post_title) ?>
                                        <li>
                                            <label  class="app-button-filter _inline<?= $lowerCase ? ' _lower-case' : '' ?>">&#8985; &nbsp;<?= $subRange->post_title ?>
                                                <input type="checkbox" name="sub_range" value="<?= $subRange->ID ?>" style="display: none;"/>
                                            </label></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endforeach; ?>
                        </div>
                        */ ?>
     <?php /*
                        <div class="app-store-filter__title"><span>Collections</span></div>
                        <div class="app-store-filter__list">
                            <?php foreach ($collections as $collection): ?>
                                <ul class="app-store-filter__list-nav">
                                    <li><label class="app-button-filter _inline<?= $collection->ID == $collectionId ? ' active' : '' ?>"><?= $collection->post_title ?>
                                            <input type="checkbox" name="collections" value="<?= $collection->ID ?>" <?= $collection->ID == $collectionId ? ' checked="checked"' : '' ?> style="display: none;"/>
                                        </label>
                                    </li>
                                </ul>
                            <?php endforeach; ?>
                        </div>
                        */ ?>


    <div class="locator-hero">
        <div class="container container--fluid">
            <div class="s-wrap">
                <div class="s-locator">
                    <div class="s-locator__header">
                        <h1 class="header-title">store locator</h1>
                        <div class="header-subtitle">Use my current location to find the nearest store:</div>
                        <div class="header-address">Grey Lynn, Auckland<a href="#">View store</a></div>
                    </div>
                    <div class="s-locator__body">
                        <div class="body-form">
                            <div class="body-form__title">Please select a region and store.</div>
                            <div class="body-form__control">
                                <select>
                                    <option value="placeholder">-Select Region-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div class="body-form__control">
                                <select disabled="">
                                    <option value="placeholder">-Select Store-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="s-locator__footer">
                        <div class="locator-info">
                            <div class="locator-info__group">
                                <div class="locator-info__ttl">Address</div>
                                <div class="locator-info__row">
                                    <div class="locator-info__col">6/8 Morningside Dr,<br>Sandringham, Auckland,<br>1025</div>
                                    <div class="locator-info__col">Phone: 09 601 8090<br><a href="#">Email this store</a></div>
                                </div>
                            </div>
                            <div class="locator-info__group">
                                <div class="locator-info__ttl">Store Hours</div>
                                <div class="locator-info__row">
                                    <div class="locator-info__col">Today: 8:30am - 5:00pm<br>Mon: 8:30am - 5:00pm<br>Tue: 8:30am - 5:00pm<br>Wed: 8:30am - 5:00pm<br><a href="#">View more</a></div>
                                    <div class="locator-info__col">Thu: 8:30am - 5:00pm<br>Fri: 8:30am - 5:00pm<br>Sat: 9:00am - 4:00pm<br>Sun: 10:00am - 4:00pm</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="s-map"><iframe width="100%" height="100%" src="https://maps.google.com/maps?width=100%&amp;height=100%&amp;hl=en&amp;q=1%20Grafton%20Street%2C%20Dublin%2C%20Ireland+(My%20Business%20Name)&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no"></iframe></div>
            </div>
        </div>
    </div>

    <div class="section-content">
        <div class="container">
            <div class="page-hat">
                <div class="row">
                    <div class="col-lg-5">
                        <h1 class="h3 page-hat__title"><?= get_the_title() ?></h1>
                    </div>
                </div>
            </div>
            <div class="store-section">
                <div class="page-layout">
                    <div class="row">

                        <div class="page-layout__col col-lg-5">
                            <div class="search-filter">
                                <div class="filter-label">Filter By:</div>
                                <div class="filter-list">
                                    <?php foreach ($retailers as $retailer): ?>
                                        <label class="app-button-filter filter-item  <?= $retailer->ID == $selectedRetailerId ? 'active' : null ?>">
                                            <span class="filter-item__text"><?= get_field('name', $retailer->ID) ?></span>
                                            <span class="filter-item__icon"></span>
                                            <input class="retailer-filter-button" type="checkbox" name="retailer" data-name="<?= $retailer->post_name ?>" value="<?= $retailer->ID ?>" style="display: none;" <?= $retailer->ID == $selectedRetailerId ? 'checked="checked"' : null ?>/>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <form class="search-form">
                                <div class="form-group">
                                    <div class="form-group__control">
                                        <input id="wpsl-search-input" type="text" value="<?= $query ?>" placeholder="" name="wpsl-search-input">
                                        <button id="wpsl-search-btn"><i class="app-svg search"></i></button>
                                    </div>
                                </div>
                            </form>
                            <div class="search-location hidden-sm-min">
                                <div class="search-location__text">- OR -</div>
                                <div class="search-location__button">
                                    <button type="button" class="btn btn-default"><span class="ic ic2-btn-location"></span><span>Use my current location</span></button>
                                </div>
                            </div>

                            <div id="wpsl-result-list">
                                <div class="search-list" id="wpsl-stores">
                                </div>
                                <div id="wpsl-direction-details" style="display: none;">
                                    <ul></ul>
                                </div>
                            </div>
                        </div>
                        <div class="page-layout__col col-lg-7">
                            <div id="wpsl-gmap" class="wpsl-gmap-canvas app-map-big displaysNoneTabs"></div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
<?php return ob_get_clean();