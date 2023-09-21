<?php
require_once 'webhook_get.php';

function webhook_send($product_id, $title, $price)
{
    $webhook_url = 'https://2cb4e2-2.myshopify.com/admin/api/2023-07/webhooks.json';
    $webhook_data = array(
        'webhook' => array(
            'topic' => 'products/create',
            'address' => 'https://tm-ha.com/shopify/webhook_get.php',
            'format' => 'json'
        )
    );

    $headers = array(
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode('1cf2061e227c64064b56bba2eaea71ec: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')
    );

    // Call the function to create a new product on Shopify
    $response = createShopifyProduct(json_encode($webhook_data)); // Pass the JSON encoded data here

    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($webhook_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    //return @$response;
}
?>
