<?php
ob_start();

include_once(__DIR__.'/event_gateway.php');
include_once(__DIR__.'/event_process.php');

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '../../configuration/defuse-crypto.phar');

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

if(isset($_SESSION['bccc_event_order']) && !empty($_SESSION['bccc_event_order']) && isset($_SESSION['bccc_participant']) && !empty($_SESSION['bccc_participant'])){

//Payment and Order Information
$amount = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_order']['eventOrderTotal'])));
$amount = number_format($amount, 2, '.', '');
$tax = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_order']['eventOrderTax'])));
$tax = number_format($tax, 2, '.', '');
$shipping = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_order']['eventOrderShipping'])));
$shipping = number_format($shipping, 2, '.', '');
$order_id = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_order']['eventOrderID'])));
$order_desc = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_order']['eventOrderDesc'])));
$ip_addr = trim(stripslashes($_SESSION['bccc_event_order']['eventOrderParticipantIP']));
$first_name = trim(stripslashes(htmlspecialchars($_SESSION['bccc_participant']['ParticipantLoginFirstName'])));
$last_name = trim(stripslashes(htmlspecialchars($_SESSION['bccc_participant']['ParticipantLoginLastName'])));
$email = trim(stripslashes(htmlspecialchars($_SESSION['bccc_participant']['participantLoginEmail'])));
$company = $address1 = $address2 = $city = $state = $country = $fax = $website = '';
$phone = trim(stripslashes(htmlspecialchars($_SESSION['bccc_participant']['ParticipantLoginPhone'])));
$zip = trim(stripslashes(htmlspecialchars($_SESSION['bccc_participant']['ParticipantLoginZipCode'])));

//Set Payment Token Type String
$payment_token_type_string = "";

if($_SESSION['bccc_event_order']['eventCheckoutPaymentMethod'] == 1 && isset($_POST['payment_token'])){
$payment_token_type_string = "payment_token=" . urlencode($_POST['payment_token']) . "&";
}
elseif($_SESSION['bccc_event_order']['eventCheckoutPaymentMethod'] == 2 && isset($_POST['payment_token'])){
$payment_token_type_string = "payment=" . urlencode('check') . "&payment_token=" . urlencode($_POST['payment_token']) . "&";
}
else{
$payment_token_type_string = "payment_token=" . urlencode($_POST['payment_token']) . "&"; 
}

//Process Payment

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

$gw = new gwapi();
$db_enc_key = Key::loadFromAsciiSafeString($_ENV['DB_ENC_KEY']);
$pg_sec_key = Crypto::decrypt($_ENV['PG_SEC_KEY'], $db_enc_key);
$gw->setLogin($pg_sec_key);
$gw->setBilling($first_name, $last_name, $company, $address1, $address2, $city, $state, $zip, $country, $phone, $fax, $email, $website);
$gw->setShipping($first_name, $last_name, $company, $address1, $address2, $city, $state, $zip, $country, $email);
$gw->setOrder($order_id, $order_desc, $tax, $shipping, $order_id, $ip_addr);

$r = $gw->doSale($amount, $payment_token_type_string);

//Process payment response
if(isset($gw->responses) && !empty($gw->responses)){
$_SESSION['bccc_event_payment'] = $gw->responses;
new Process();
exit();
}
else{
header('Location: event/payment/error');
exit();
}
}
else{
header('Location: event/payment/error');  
}
?>