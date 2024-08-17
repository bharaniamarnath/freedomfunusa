<?php
ob_start();

include_once(__DIR__.'/event_gateway.php');
include_once(__DIR__.'/event_process.php');

if(isset($_SESSION['bccc_event_billing']) && !empty($_SESSION['bccc_event_billing']) && isset($_SESSION['bccc_event_order']) && !empty($_SESSION['bccc_event_order'])){

//Payment and Order Information
$amount = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_order']['eventOrderTotal'])));
$amount = number_format($amount, 2, '.', '');
$tax = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_order']['eventOrderTax'])));
$tax = number_format($tax, 2, '.', '');
$shipping = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_order']['eventOrderShipping'])));
$shipping = number_format($shipping, 2, '.', '');
$order_id = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_order']['eventOrderID'])));
$order_desc = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_order']['eventOrderDesc'])));
$first_name = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_billing']['eventBillingFirstName'])));
$last_name = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_billing']['eventBillingLastName'])));
$phone = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_billing']['eventBillingPhoneCountry']))) . trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_billing']['eventBillingPhoneNumber'])));
$email = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_billing']['eventBillingEmail'])));
$address1 = $address2 = $city = $state = $country = '';
$zip = trim(stripslashes(htmlspecialchars($_SESSION['bccc_event_billing']['eventBillingZip'])));
$ip_addr = trim(stripslashes($_SESSION['bccc_event_order']['eventOrderParticipantIP']));

//Set Payment Token Type String
$payment_token_type_string = "";

if($_SESSION['bccc_event_billing']['eventBillingPaymentMethod'] == 1 && isset($_POST['payment_token'])){
$payment_token_type_string = "payment_token=" . urlencode($_POST['payment_token']) . "&";
}
else{
$payment_token_type_string = "payment_token=" . urlencode($_POST['payment_token']) . "&"; 
}

//Process Payment
$gw = new gwapi();
$gw->setLogin("z5dJv6R5rp2sQT2gu4nYx43cJ2P7nHHH");
$gw->setBilling($first_name, $last_name, "", $address1, $address2, $city, $state, $zip, $country, $phone, "", $email, "");
$gw->setShipping($first_name, $last_name, "", $address1, $address2, $city, $state, $zip, $country, $email);
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