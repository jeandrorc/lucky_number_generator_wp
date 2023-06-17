<?php
class LuckyNumbers {
    public function __construct() {
        add_action('init', array($this, 'add_lucky_numbers_endpoint'));
        add_filter('woocommerce_account_menu_items', array($this, 'new_menu_items'));
        add_action('woocommerce_account_lucky-numbers_endpoint', array($this, 'lucky_numbers_endpoint_content'));
    }

    public function add_lucky_numbers_endpoint() {
        add_rewrite_endpoint('lucky-numbers', EP_ROOT | EP_PAGES);
    }

    public function new_menu_items($items) {
        $logout = $items['customer-logout'];
        unset($items['customer-logout']);
        $items['lucky-numbers'] = 'Números da Sorte';
        $items['customer-logout'] = $logout;
        return $items;
    }

    public function lucky_numbers_endpoint_content() {
        global $wpdb;
        $table_name = $wpdb->prefix . "lucky_numbers";
        $results = $wpdb->get_results("SELECT * FROM $table_name WHERE customer_email ='" . wp_get_current_user()->user_email . "'", ARRAY_A);
    
        include 'templates/luck-numbers-table.php';  // inclui o arquivo de template
    }

}

new LuckyNumbers();
