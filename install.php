<?php 

if (!defined('ABSPATH')) {
    exit; // Bloquear acesso direto
}

global $wpdb;
$table_name = $wpdb->prefix . "lucky_numbers";

register_activation_hook(__FILE__, 'create_lucky_numbers_table');

function create_lucky_numbers_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . "lucky_numbers";

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        lucky_number varchar(10) NOT NULL,
        promotion_id mediumint(9) NOT NULL,
        order_id mediumint(9) NOT NULL,
        order_item_id mediumint(9) NOT NULL,
        customer_email varchar(100) NOT NULL,
        customer_name varchar(100) NOT NULL,
        phone varchar(15) NOT NULL,
        PRIMARY KEY (id),
        UNIQUE (order_item_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}