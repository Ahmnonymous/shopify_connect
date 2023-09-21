<?php
define('SHOPIFY_API_KEY', '1cf2061e227c64064b56bba2eaea71ec');
define('SHOPIFY_API_PASSWORD', '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');
define('SHOPIFY_STORE_URL', 'https://2cb4e2-2.myshopify.com/admin/api/2023-07/products.json');

function createShopifyProduct($data)
{
    $json_data = json_decode($data, true);

    // Extract product data
    $id = $json_data['id'];
    $title = $json_data['title'];
    $price = $json_data['price'];

    // Prepare the product data for Shopify API
    $product_data = array(
        'product' => array(
            'title' => $title,
            'body_html' => '',
            'variants' => array(
                array(
                    'price' => $price
                )
            )
        )
    );
    // Send the product data to Shopify API to create a new product
    $ch = curl_init(SHOPIFY_STORE_URL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($product_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode(SHOPIFY_API_KEY . ':' . SHOPIFY_API_PASSWORD)
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    // Check the response from the Shopify API for any error handling if required
    // You can also log the response for debugging purposes
    // error_log($response);

    return $response;
}

// Handle the incoming webhook payload
$data = file_get_contents('php://input');
$response = createShopifyProduct($data);

// Send a response back to acknowledge the webhook
http_response_code(200);
echo $response;
