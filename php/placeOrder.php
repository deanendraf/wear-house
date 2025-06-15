<?php
/*Install Midtrans PHP Library (https://github.com/Midtrans/midtrans-php)
composer require midtrans/midtrans-php
                              
Alternatively, if you are not using **Composer**, you can download midtrans-php library 
(https://github.com/Midtrans/midtrans-php/archive/master.zip), and then require 
the file manually.   

require_once dirname(__FILE__) . '/pathofproject/Midtrans.php'; */

require_once dirname(__FILE__) . '/midtrans-php-master/Midtrans.php';

//SAMPLE REQUEST START HERE

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-o3ceHB2qx85_GG7N0_ziaMBP';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;

// Validasi Email
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Invalid email format.";
    exit;
}

// Validasi Nama
if (empty($_POST['name']) || !preg_match("/^[a-zA-Z\s'-]+$/", $_POST['name'])) {
    http_response_code(400);
    echo "Invalid name format.";
    exit;
}

// Validasi No HP
if (empty($_POST['phone']) || !preg_match("/^\+?\d{9,15}$/", $_POST['phone'])) {
    http_response_code(400);
    echo "Invalid phone number format.";
    exit;
}



$params = array(
    'transaction_details' => array(
        'order_id' => rand(),
        'gross_amount' => $_POST['total'],
    ),
    'item_details' => json_decode($_POST['items'], true),
    'customer_details' => array(
        'first_name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
    ),
    'callbacks' => array(
        'finish' => 'http://localhost/BSI/Project/'
    )
);

$snapToken = \Midtrans\Snap::getSnapToken($params);
echo $snapToken;
?>