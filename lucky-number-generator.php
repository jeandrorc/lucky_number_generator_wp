<?php
/**
 * Plugin Name: Lucky Number Generator
 * Description: Gera números da sorte com base nos atributos do produto e envia por e-mail ao cliente.
 * Version: 1.0
 * Author: Jeandro Couto
 */
require_once plugin_dir_path(__FILE__) . 'functions.php';
require_once plugin_dir_path(__FILE__) . 'install.php';
require_once plugin_dir_path(__FILE__) . 'email.php';
require_once plugin_dir_path(__FILE__) . 'admin-page.php';
require_once plugin_dir_path(__FILE__) . 'customer-page.php';



add_action('woocommerce_order_status_completed', 'send_lucky_number_email');

add_action('admin_menu', 'lucky_number_admin_page');

