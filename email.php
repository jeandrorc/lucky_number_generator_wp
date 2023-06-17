<?php
function send_lucky_number_email($order_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "lucky_numbers";

    $order = wc_get_order($order_id);
    $email = $order->get_billing_email();
    $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
    $phone = $order->get_billing_phone();

    $lucky_numbers = array();

    foreach ($order->get_items() as $item_id => $item) {
        $product = $item->get_product();
        list($lucky_number_count, $promotion_id) = get_lucky_number_details_from_attributes($product);
        for ($i = 0; $i < $lucky_number_count; $i++) {

            // Verifique se já existe um número da sorte para o item do pedido
            $existing_lucky_number_for_item = $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM $table_name WHERE order_item_id = %d",
                $item_id
            ));

            if ($existing_lucky_number_for_item > 0) {
                // Se já existir um número da sorte para este item, pare o processo
                break;
            }

            do {
                // Gere o número da sorte
                $lucky_number = generate_lucky_number();

                // Verifique se o número da sorte gerado já existe para a promoção atual e o item do pedido
                $existing_lucky_number = $wpdb->get_var($wpdb->prepare(
                    "SELECT COUNT(*) FROM $table_name WHERE lucky_number = %s AND promotion_id = %d",
                    $lucky_number, $promotion_id
                ));
            } while ($existing_lucky_number > 0);

            $wpdb->insert(
                $table_name,
                array(
                    'lucky_number' => $lucky_number,
                    'promotion_id' => $promotion_id,
                    'order_id' => $order_id,
                    'order_item_id' => $item_id,
                    'customer_email' => $email,
                    'customer_name' => $customer_name,
                    'phone' => $phone
                ),
                array('%s', '%d', '%d', '%d', '%s', '%s', '%s')
            );

            $lucky_numbers[] = $lucky_number;
        }
    }

    if (count($lucky_numbers) < 1) {
        return;
    }
    // Envie um único e-mail com todos os números da sorte gerados
    $subject = 'Seus números da sorte';
    $message = '<html>
                  <body>
                      <h1>Seus números da sorte</h1>
                      <p>Olá, aqui estão os números da sorte que você recebeu com a sua compra:</p>
                      <ul>';
    foreach ($lucky_numbers as $lucky_number) {
        $message .= "<li>$lucky_number</li>";
    }
    $message .= '   </ul>
                    <p>Boa sorte!</p>
                  </body>
                </html>';

    $headers = array('Content-Type: text/html; charset=UTF-8');


    wp_mail($email, $subject, $message, $headers);
}
