<?php

$shopify_store = "2cb4e2-2.myshopify.com";
$api_key = "1cf2061e227c64064b56bba2eaea71ec";
$api_password = "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";
$api_version = "2023-07";

// Webhook data
$webhook_data = array(
    'webhook' => array(
        'topic' => 'products/create',
        'address' => 'https://tm-ha.com/shopify/product.php',
        'format' => 'json'
    )
);

// Create webhook
$ch = curl_init("https://$api_key:$api_password@$shopify_store/admin/api/$api_version/webhooks.json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($webhook_data));
$response = curl_exec($ch);
curl_close($ch);

// Output response
echo $response;
