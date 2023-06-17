<?php

    function display_lucky_numbers(){
        global $wpdb;
        $table_name = $wpdb->prefix . "lucky_numbers";

        $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

        echo '<h1>Lucky Numbers</h1>';

        if (count($results) > 0) {
            echo '<table>';
            echo '<tr><th>Número da sorte</th><th>Promotion ID</th><th>Order ID</th><th>Item ID</th><th>Email</th><th>Customer Name</th><th>Phone</th></tr>';

            foreach($results as $row){
                echo '<tr>';
                echo '<td>' . $row['lucky_number'] . '</td>';
                echo '<td>' . $row['promotion_id'] . '</td>';
                echo '<td>' . $row['order_id'] . '</td>';
                echo '<td>' . $row['order_item_id'] . '</td>';
                echo '<td>' . $row['customer_email'] . '</td>';
                echo '<td>' . $row['customer_name'] . '</td>';
                echo '<td>' . $row['phone'] . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo '<p>No lucky numbers found.</p>';
        }
    }

    function lucky_number_admin_page(){
        add_menu_page(
            'Lucky Numbers',
            'Lucky Numbers',
            'manage_options',
            'lucky-numbers',
            'display_lucky_numbers',
            'dashicons-tickets',
            5
        );
    }