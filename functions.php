<?php

function generate_lucky_number() {
    $series = rand(1, 5); // Gera um número aleatório entre 1 e 5 para a série
    $random_number = str_pad(rand(1, 99999), 4, '0', STR_PAD_LEFT);
    return $series . $random_number;
}

function get_lucky_number_details_from_attributes($product) {
    $attributes = $product->get_attributes();
    $lucky_number_count = 0;
    $promotion_id = 0;

    if (isset($attributes['pa_numeros'])) {
        $numero_attribute = $attributes['pa_numeros'];
        if ($numero_attribute->is_taxonomy()) {
            $terms = wp_get_post_terms($product->get_id(), 'pa_numeros');
            if (!empty($terms) && !is_wp_error($terms)) {
                $lucky_number_count = (int) $terms[0]->name;
            }
        } else {
            $lucky_number_count = (int) $numero_attribute->get_options()[0];
        }
    }

    if (isset($attributes['pa_commercial_promotion'])) {
        $promotion_attribute = $attributes['pa_commercial_promotion'];
        $promotion_slug = $promotion_attribute->is_taxonomy()
            ? wp_get_post_terms($product->get_id(), 'pa_commercial_promotion')[0]->name
            : $promotion_attribute->get_options()[0];

        $promotion_post = get_page_by_path($promotion_slug, OBJECT, 'page');
        if ($promotion_post !== null) {
            $promotion_id = $promotion_post->ID;
        }
    }

    return array($lucky_number_count, $promotion_id);
}

function format_customer_name($customer_name) {
    $formatted_name = strtoupper(str_replace(' ', '-', $customer_name));
    return $formatted_name;
}
