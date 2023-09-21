<?php
require_once 'insertp.php';
define('CLIENT_SECRET', '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');

function verify_webhook($data, $hmac_header)
{
  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, CLIENT_SECRET, true));
  return hash_equals($calculated_hmac, $hmac_header);
}

$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$data = file_get_contents('php://input');
$verified = verify_webhook($data, $hmac_header);

//error_log('Webhook verified: '.var_export($verified, true)); // Check error.log to see the result
$response = $verified ? 'Webhook verified' : 'Webhook not verified';
$log = fopen("product.json", "w") or die("cant open");
fwrite($log,$data);
insertProduct($data);
fclose($log);

?>
