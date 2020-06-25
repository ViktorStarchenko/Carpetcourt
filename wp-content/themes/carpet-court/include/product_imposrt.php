<?php
include 'libs/src/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Box\Spout\Common\Type;
add_action('admin_menu', 'import_product_plugin_setup_menu');

function import_product_plugin_setup_menu(){
    add_menu_page( 'Import product', 'Import product', 'manage_options', 'import-product-plugin', 'import_product_init' );
}

add_action('admin_menu', 'export_product_plugin_setup_menu');

function export_product_plugin_setup_menu(){
    add_menu_page( 'Export product', 'Export product', 'manage_options', 'export-product-plugin', 'export_product_init' );
}

function export_product_init() {
    export_products_to_file();
}

function export_products_to_file() {

    $args = [
        'post_type'           => 'product',
        'post_status'         => 'publish',
        'ignore_sticky_posts' => 1,
        'posts_per_page'      => -1,
    ];

    $products = wc_get_products($args);
    if (!empty($products)) {
        $metaData[] = [
            'title'      => 'title',
            'categories' => 'categories',
            'brands'     => 'brands',
            'features'   => 'features',
            'delivery'   => 'delivery',
            'colors'     => 'colors',
            'style'      => 'style',
            'wood'       => 'wood',
            'colourACF'  => 'colourACF',
        ];
        foreach ($products as $product) {
            $id = $product->get_id();

            $style = [];
            $wood = [];
            $colourACF = [];

            $fields = get_fields($id);
            if (!empty($fields['style_filter'])) {
                $style = $fields['style_filter'];
            }

            if (!empty($fields['wood_shade'])) {
                $wood = $fields['wood_shade'];
            }

            if (!empty($fields['colour_filter'])) {
                $colourACF = $fields['colour_filter'];
            }

            $categoriesData = export_category($id, 'product_cat');
            $brandsData = export_category($id, 'product_brand');
            $featuresData = export_category($id, 'product_feature');
            $deliveryData = export_category($id, 'product_delivery');
            $colorsData = export_category($id, 'product_color');

            $metaData[] = [
                'title'      => $product->get_title(),
                'categories' => $categoriesData,
                'brands'     => $brandsData,
                'features'   => $featuresData,
                'delivery'   => $deliveryData,
                'colors'     => $colorsData,
                'style'      => implode('|', $style),
                'wood'       => implode('|', $wood),
                'colourACF'  => implode('|', $colourACF),
            ];
        }
        $fileName = dirname(__FILE__).'/../../../uploads/wp_products_export.csv';
        $fp = fopen($fileName, 'w');
        foreach ($metaData as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
    }

    echo "<a href='/wp-content/uploads/wp_products_export.csv' target='_blank'>Download</a>";
}

function export_category($id, $tax) {
    $taxes = get_the_terms($id, $tax);
    $taxData = [];
    if (!empty($taxes)) {
        foreach ($taxes as $tax) {
            $taxData[] = $tax->slug;
        }
    }
    $taxData = implode('|', $taxData);

    return $taxData;
}

function import_category($id, $taxonomy, $data) {
    $taxes = get_terms([
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
    ]);
    $taxData = [];
    $importData = explode('|', $data);
    if (!empty($taxes)) {
        foreach ($taxes as $tax) {
            foreach ($importData as $item) {
                if ($item == $tax->slug) {
                    $taxData[] = $tax->term_id;
                }
            }
        }
    }
    $dd = wp_set_object_terms($id, $taxData, $taxonomy);

    /*
    if ($taxonomy == 'product_color' && !empty($data)) {
        dump($id);
        dump($taxData);
        dump($dd);
    }
    */

    return $taxData;
}

function import_ACF($id, $data, $slug) {
    $import = [];

    if (!empty($data)) {
        $object = get_field_object($slug, $id);
        if (!empty($object)) {
            $key = $object['key'];
            $data = explode('|', $data);
            dump($id);
            dump($object);

            foreach ($object['choices'] as $choice => $value) {
                foreach ($data as $item) {
                    if ($choice == $item) {
                        $import[] = $choice;
                    }
                }
            }
            update_field($key, $import, $id);
        }
    }

    return $import;
}

function import_product_init() {
    import_supplier_companies_from_file();

    echo '<h1>There you can import product from csv, odc or xlsx files!</h1>';
    echo '<h2>Upload a File</h2>';
    echo '<form  method="post" enctype="multipart/form-data">';
    echo '<input type="file" id="product_upload_csv" name="product_upload_csv"></input>';
    submit_button('Upload');
    echo '</form>';
}

// The functions which is going to do the job
function import_supplier_companies_from_file() {
    $allowed_file_types = [
        'xlsx',
        'csv',
        'ods'
    ];

    if(isset($_FILES['product_upload_csv'])){

        $csv = $_FILES['product_upload_csv'];

        $uploaded = media_handle_upload('product_upload_csv', 0);
        // Error checking using WP functions
        if(is_wp_error($uploaded)){
            echo "Error uploading file: " . $uploaded->get_error_message();
        } else {
            $data = array();
            $errors = array();
            set_time_limit(0);

            // Require some Wordpress core files for processing images
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');

            // Download and parse the xlsx
            $filePath = get_attached_file( $uploaded );

            $paramms = array(
                'title'      => 0,
                'categories' => 1,
                'brands'     => 2,
                'features'   => 3,
                'delivery'   => 4,
                'colors'     => 5,
                'style'      => 6,
                'wood'       => 7,
                'colourACF'  => 8,
            );

            $ext = pathinfo($csv['name'], PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed_file_types)) {
                $errors[] = 'Import allowed only for .xlsx, .csv and .ods files';
            } else {
                if ( is_readable( $filePath ) ) {
                    $type = Type::XLSX;
                    switch($ext) {
                        case 'xlsx';
                            $type = Type::XLSX;
                            break;
                        case 'csv';
                            $type = Type::CSV;
                            break;
                        case 'ods';
                            $type = Type::ODS;
                            break;
                        default;
                            $type = Type::XLSX;
                            break;
                    }

                    $reader = ReaderFactory::createFromType($type);
                    $reader->open($filePath);
                    $i = 0;
                    foreach ($reader->getSheetIterator() as $sheet) {
                        $y = 0;
                        foreach ($sheet->getRowIterator() as $r) {
                            $row = $r->toArray();
                            if ($row[0] == 'title') {
                                continue;
                            }
                            //dump($row);
                            $product = get_page_by_title($row[$paramms['title']], OBJECT, 'product');

                            if (!empty($product->ID)) {
                                $categoriesData = import_category($product->ID, 'product_cat', $row[$paramms['categories']]);
                                $brandsData = import_category($product->ID, 'product_brand', $row[$paramms['brands']]);
                                $featuresData = import_category($product->ID, 'product_feature', $row[$paramms['features']]);
                                $deliveryData = import_category($product->ID, 'product_delivery', $row[$paramms['delivery']]);
                                $colorsData = import_category($product->ID, 'product_color', $row[$paramms['colors']]);
                                $styleData = import_ACF($product->ID, $row[$paramms['style']], 'style_filter');
                                $woodData = import_ACF($product->ID, $row[$paramms['wood']], 'wood_shade');
                                $colorsData = import_ACF($product->ID, $row[$paramms['colourACF']], 'colour_filter');
                            }
                            $y++;
                        }
                        $i++;
                    }
                    $reader->close();
                } else {
                    $errors[] = "File '$filePath' could not be opened. Check the file's permissions to make sure it's readable by your server.";
                }

                if ( ! empty( $errors ) ) {
                    foreach ($errors as $error) {
                        echo $error;
                    }
                } else {
                    echo 'Import succesfully finished!';
                }
            }
        }
    }
}

?>
