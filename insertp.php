<?php
require_once 'send.php';
function insertProduct($data)
{
    $log_filename = 'insert_product_log.txt';
    file_put_contents($log_filename, "Incoming Data: \n" . $data . "\n\n", FILE_APPEND);
    $json_data = json_decode($data, true);

    // Extract product data
    $product_id = $json_data['id'];
    $title = $json_data['title'];
    $price = $json_data['variants'][0]['price'];
    $created_at = date('Y-m-d H:i:s', strtotime($json_data['created_at']));

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = '786$toqA';
    $dbname = "shop";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the insert query
    $sql = "INSERT INTO products (product_id, title, price, created_at) VALUES ('$product_id', '$title', '$price', '$created_at')";

    if ($conn->query($sql) === TRUE) {
        $response = "Data inserted into the database.";
    } else {
        $response = "Data insertion failed: " . $conn->error;
    }

    $conn->close();
    //webhook_send($product_id,$title,$price);
    return $response;
}
