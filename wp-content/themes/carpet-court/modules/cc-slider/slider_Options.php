<?php
if(function_exists('current_user_can'))
    if (!current_user_can('manage_options')) {
        die('Access Denied');
    }
if (!function_exists('current_user_can')) {
    die('Access Denied');
}
function showStyles($op_type = "0")
{
global $wpdb;
    $query = "SELECT *  from " . $wpdb->prefix . "slider_params ";
    $rows = $wpdb->get_results($query);
    $param_values = array();
    foreach ($rows as $row) {
        $key = $row->name;
        $value = $row->value;
        $param_values[$key] = $value;
    }
    html_showStyles($param_values, $op_type);
}

function cc_slider_save_general_options(){
    global $wpdb;
    $table_name = $wpdb->prefix . "slider_params";

    $params = $_POST['params'];
    foreach( $params as $key => $val) {
        $update_query  = "UPDATE `".$table_name."` SET ";
        $update_query .= "`value` = '{$val}' ";
        $update_query .= "WHERE `name` = '{$key}' ";    
        $wpdb->query($update_query);        
    }
}
