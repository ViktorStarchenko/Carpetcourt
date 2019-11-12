<?php
global $wpsl_settings, $wpsl;
$taxonomy = 'wpsl_store_category';
$ID = 0;
$regionID = 0;
if (is_single()) {
    $ID = get_the_ID();
    $regions = get_the_terms($ID, $taxonomy);
    if (!empty($regions)) {
        $regionID = $regions[0]->term_id;
    }
}
if (is_tax($taxonomy)) {
    $regionID = get_queried_object()->term_id;
}
$categories = get_categories([
    'taxonomy' => $taxonomy,
    'hide_empty' => false
]);
ob_start();
?>
<style>
    .hide{
        display: none;
    }
    .breadcrumbs-list, .breadcrumbs-list a, .breadcrumbs-list span{
        margin: 0 8px;
        position: relative;
        color: #808487;
        font-size: .75rem;
        line-height: 1rem;
        padding: 2px 0;
        display: block;
        text-decoration: none;
    }
    ._custom-today, ._custom-today span{
        font-weight: bold;
    }
    .locator-info__col div{
        display: flex;
        justify-content: space-between;
    }
    .locator-hero .s-locator .body-form select{
        position: relative;
        z-index: 2;
    }
    h2.acc-title a{
        text-decoration: none;
    }
</style>
<script>
    isStore = <?= $ID ?>;
</script>
<script>
    jQuery(document).ready(function () {
        const regionSelect = jQuery("#regions");
        const storeSelect = jQuery("#stories");
        const footerInfo = jQuery(".s-locator__footer");
        const headerInfo = jQuery(".header-box");

        getStories(regionSelect.val());
        regionSelect.on('change', function () {
            var category = jQuery(this).val();
            isStore = 0;
            console.log(isStore);
            footerInfo.addClass("hide");
            headerInfo.addClass("hide");
            getStories(category);
        });

        storeSelect.on('change', function () {
            var store = jQuery(this).val();
            footerInfo.addClass("hide");
            headerInfo.addClass("hide");
            isStore = 0;
            getStore(store);
        });
        function getStories(category = 0) {
            storeSelect.attr("disabled", true);
            if (category > 0) {
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url('admin-ajax.php');?>',
                    dataType: "json",
                    data: { action : 'get_ajax_posts', category: category },
                    success: function( response ) {
                        let selected = '';
                        if ( isStore === 0 ){
                            selected = ' selected="selected" ';
                        }
                        storeSelect.html('<option ' + selected + ' value="0">-Select Store-</option>');
                        jQuery.each( response, function( key, value ) {
                            let selected = '';
                            if (isStore > 0) {
                                selected = ' selected="selected" ';
                            }
                            storeSelect.append('<option ' + selected + ' value="' + value.ID + '">' + value.post_title + '</option>');
                        } );
                        storeSelect.attr("disabled", false);
                        storeSelect.val(isStore);
                        if ( isStore > 0 ) {
                            setTimeout(function () {
                                storeSelect.trigger('change');
                            }, 1000);
                        }
                    }
                });
            } else {
                storeSelect.val(0).trigger('change');
            }
        }

        function getStore(store = 0) {
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php');?>',
                dataType: "json",
                data: { action : 'get_ajax_post', store: store },
                success: function( response ) {
                    if (response) {

                        jQuery(".phone").html(response.phone).attr("href", "tel:"+response.phone);
                        jQuery(".email").attr("href", "mailto:"+response.email);
                        jQuery(".address").html(response.address);
                        jQuery(".address2").html(response.address2);
                        jQuery(".url").attr("href", response.url);
                        jQuery(".store-title").html(response.store);

                        jQuery(".mon").html(response.work.monday);
                        jQuery(".tue").html(response.work.tuesday);
                        jQuery(".wed").html(response.work.wednesday);
                        jQuery(".thu").html(response.work.thursday);
                        jQuery(".fri").html(response.work.friday);
                        jQuery(".sat").html(response.work.saturday);
                        jQuery(".sun").html(response.work.sunday);
                        jQuery(".today").html(response.work.today);

                        footerInfo.removeClass("hide");
                        headerInfo.removeClass("hide");
                    }
                }
            });
        }
    });
</script>
<?php wp_enqueue_script('wpsl-js', get_template_directory_uri() . '/wpsl-templates/custom-wpsl-gmap.js', ['jquery'], WPSL_VERSION_NUM, true); ?>

    <div class="locator-hero">
        <div class="container container--fluid">
            <div class="s-wrap">
                <div class="s-locator">
                    <div class="s-locator__header">
                        <h1 class="header-title">store locator</h1>
                        <div class="header-box hide">
                            <div class="header-subtitle">Use my current location to find the nearest store:</div>
                            <div class="header-address"><span class="store-title"></span><a href="#" class="url">View store</a></div>
                        </div>
                    </div>
                    <div class="s-locator__body">
                        <div class="body-form">
                            <div class="body-form__title">Please select a region and store.</div>
                            <div class="body-form__control">
                                <select name="region" id="regions">
                                    <option value="0">-Select Region-</option>
                                    <?php foreach ($categories as $category) : ?>
                                        <?php
                                            $selected = '';
                                            if ($category->term_id == $regionID) {
                                                $selected = ' selected="selected" ';
                                            }
                                        ?>
                                        <option <?= $selected ?> value="<?= $category->term_id ?>"><?= $category->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="body-form__control" >
                                <select id="stories">
                                    <option value="0">-Select Store-</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="s-locator__footer hide">
                        <div class="locator-info">
                            <div class="locator-info__group">
                                <div class="locator-info__ttl">Address</div>
                                <div class="locator-info__row">
                                    <div class="locator-info__col"><span class="address"></span><br><span class="address2"></span></div>
                                    <div class="locator-info__col">Phone:
                                        <a href="" class="phone"></a><br>
                                        <a href="#" class="email">Email this store</a>
                                    </div>
                                </div>
                            </div>
                            <div class="locator-info__group">
                                <div class="locator-info__ttl">Store Hours</div>
                                <div class="locator-info__row">
                                    <div class="locator-info__col">
                                        <div class="_custom-today">Today: <span class="today"></span></div>
                                        <div class="">Mon: <span class="mon"></span></div>
                                        <div class="">Tue: <span class="tue"></span></div>
                                        <div class="">Wed: <span class="wed"></span></div>
                                        <a href="#" class="url">View more</a>
                                    </div>
                                    <div class="locator-info__col">
                                        <div class="">Thu: <span class="thu"></span></div>
                                        <div class="">Fri: <span class="fri"></span></div>
                                        <div class="">Sat: <span class="sat"></span></div>
                                        <div class="">Sun: <span class="sun"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="s-map">
                    <div id="wpsl-gmap" class="wpsl-gmap-canvas app-map-big displaysNoneTabs"></div>
                </div>
            </div>
        </div>
    </div>

    <?php /*
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

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    */ ?>
<?php return ob_get_clean();