<?php
global $wpsl_settings, $wpsl;

$output = $this->get_custom_css();
$autoload_class = (!$wpsl_settings['autoload']) ? 'class="wpsl-not-loaded"' : '';

$output .= '<style>#wpsl-stores{display: block!important;} #wpsl-direction-details{display: none!important;}</style>';
$output .= '<div class="app-store-searchbox">' . "\r\n";
$output .= "\t" . '<div class="article__search-form-item">' . "\r\n";
$output .= "\t\t" . '<input id="wpsl-search-input" type="text" value="' . apply_filters('wpsl_search_input', '') . '" name="wpsl-search-input" placeholder="" aria-required="true" />' . "\r\n";
$output .= "\t\t" . '<button type="button" id="wpsl-search-btn"><i class="app-svg search"></i></button>' . "\r\n";
$output .= "\t" . '</div>' . "\r\n";
$output .= '</div>' . "\r\n";


$output .= '<div class="app-store-filter">' . "\r\n";
$output .= "\t" . '<div class="app-store-searchbox__result">' . "\r\n";
$output .= "\t" . '</div>' . "\r\n";

if ($wpsl_settings['category_filter']) {
    $output .= "\t" . '<div class="t_center">' . "\r\n";
    $output .= "\t\t" . '<a href="" class="app-button-store-filter _inline"><span class="text">Refine your search</span> <i class="app-arrow-icon _bottom _icon-right"></i></a>' . "\r\n";
    $output .= "\t" . '</div>' . "\r\n";
    $output .= "\t" . '<div class="app-store-filter__collapse" style="">' . "\r\n";

    $output .= $this->create_category_filter();

    $output .= "\tt" . '<div class="app-store-filter__inner">' . "\r\n";
    $output .= "\tt" . '</div>' . "\r\n";
    $output .= "\t" . '</div>' . "\r\n";
}
$output .= '</div>' . "\r\n";
$output .= '</div>' . "\r\n";
$output .= '</div>' . "\r\n";


$output .= '<div class="app-filter-result">' . "\r\n";
$output .= "\t" . '<div id="wpsl-gmap" class="wpsl-gmap-canvas app-map-big"></div>' . "\r\n";
//$output .= "\t" . '<div class="app-filter-result__detail-box">' . "\r\n";
ob_start();
?>
    <div class="app-filter-result__detail-box">

    </div>

<?php
$content = ob_get_clean();
$output .= $content;

//details of store
//$output .= "\t" . '</div>' . "\r\n";

$output .= "\t" . '<div class="app-filter-result__list-box">' . "\r\n";
$output .= "\t\t" . '<div class="app-filter-result__flex-box">' . "\r\n";
$output .= "\t\t\t" . '<div class="app-filter-result__list-title app-filter-result__list-vi page-h3 app-sm-hidden">Stores we found near you:</div>' . "\r\n";
$output .= "\t\t\t" . '<div class=" app-filter-result__flex-scroll">' . "\r\n";
$output .= "\t\t\t\t" . '<div class="app-filter-result__scroll" id="wpsl-result-list" style="width: 100%!important;">' . "\r\n";
$output .= "\t\t\t\t\t" . '<div class="shadowContainer"><div class="shadow radialShadowTop"></div><div class="shadow radialShadowBottom"></div></div>' . "\r\n";
$output .= "\t\t\t\t\t" . '<div class="app-scrollbar" id="wpsl-stores"' . $autoload_class . '>' . "\r\n";
$output .= "\t\t\t\t\t\t\t" . '<ul></ul>' . "\r\n";
$output .= "\t\t\t\t\t" . '</div>' . "\r\n";

$output .= "\t\t\t\t\t" . '<div id="wpsl-direction-details">' . "\r\n";
$output .= "\t\t\t\t\t\t" . '<ul></ul>' . "\r\n";
$output .= "\t\t\t\t\t" . '</div>' . "\r\n";

$output .= "\t\t\t\t" . '</div>' . "\r\n";
$output .= "\t\t\t" . '</div>' . "\r\n";
$output .= "\tt" . '</div>' . "\r\n";
$output .= "\t" . '</div>' . "\r\n";

$output .= '</div>' . "\r\n";


return $output;