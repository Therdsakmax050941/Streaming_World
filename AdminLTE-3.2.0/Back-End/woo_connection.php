<?php
// Include the WooCommerce API client library
require __DIR__ . '/vendor/autoload.php';

// Initialize the WooCommerce client
$consumer_key = "ck_c6222492ed9890963ed94cb8704514662d133e2a";
$consumer_secret = "cs_4adc9d2aa9a747177561624c9281b1badebcb2ce";
$store_url = "https://streamth.co/"; // URL ของเว็บไซต์ WooCommerce ของคุณ

$woocommerce = new Automattic\WooCommerce\Client(
    $store_url,
    $consumer_key,
    $consumer_secret,
    [
        'version' => 'wc/v3',
    ]
);


?>