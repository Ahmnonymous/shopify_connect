<?php
// Your Shopify API credentials and store URL
define('SHOPIFY_API_KEY', '1cf2061e227c64064b56bba2eaea71ec');
define('SHOPIFY_API_PASSWORD', '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');
define('SHOPIFY_STORE_URL', 'https://2cb4e2-2.myshopify.com/admin/api/2023-07/products.json');

// Step 1: Get a list of all products
$ch = curl_init(SHOPIFY_STORE_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode(SHOPIFY_API_KEY . ':' . SHOPIFY_API_PASSWORD)
]);
$response = curl_exec($ch);
curl_close($ch);

// Step 2: Parse the response to get product IDs
$products = json_decode($response, true)['products'];
$products_to_delete = [];
foreach ($products as $product) {
    $products_to_delete[] = $product['id'];
}
// Step 4: Display all products
foreach ($products as $product) {
    echo "Product ID: " . $product['id'] . "<br>";
    echo "Title: " . $product['title'] . "<br>";
    echo "Price: " . $product['variants'][0]['price'] . "<br>";
    echo "<hr>";
}

// Step 5: Delete all products
foreach ($products_to_delete as $product_id) {
    $delete_url = "https://2cb4e2-2.myshopify.com/admin/api/2023-07/products/{$product_id}.json";
    $ch = curl_init($delete_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode(SHOPIFY_API_KEY . ':' . SHOPIFY_API_PASSWORD)
    ]);
    $delete_response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);

    // Check the $delete_response for success or errors
}
