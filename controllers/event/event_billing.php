<?php
ob_start();

include_once(__DIR__ . '/../../models/event_model.php');
include_once(__DIR__ . '/../../models/validation_model.php');
include_once(__DIR__ . '/../../models/content_model.php');
include_once(__DIR__.'/../../application/sendmail.php');

if(isset($_POST['eventBillingInfoSubmit'])){

//Get Checkout Event Bill Information

$eventBillingFirstName = trim(htmlspecialchars($_POST['eventBillingFirstName']));
$eventBillingLastName = trim(htmlspecialchars($_POST['eventBillingLastName']));
$eventBillingEmail = trim(htmlspecialchars($_POST['eventBillingEmail']));
$eventBillingPhoneCode = explode('_', trim(htmlspecialchars($_POST['eventBillingPhoneCode'])))[0];
$eventBillingPhoneCountry = explode('_', trim(htmlspecialchars($_POST['eventBillingPhoneCode'])))[1];
$eventBillingPhoneNumber = trim(htmlspecialchars($_POST['eventBillingPhoneNumber'])) ;
$eventBillingZip = trim(htmlspecialchars($_POST['eventBillingZip']));
$eventBillingPaymentMethod = trim(htmlspecialchars($_POST['eventBillingPaymentMethod']));


$validationModel = new ValidationModel();

$validateBilling = $validationModel->validateBilling($eventBillingFirstName, $eventBillingLastName, 
$eventBillingEmail, $eventBillingPhoneCode, $eventBillingPhoneNumber, $eventBillingZip, $eventBillingPaymentMethod);

if(!($validateBilling)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{

$eventBilling = array(
"eventBillingFirstName" => $eventBillingFirstName,
"eventBillingLastName" => $eventBillingLastName,
"eventBillingEmail" => $eventBillingEmail,
"eventBillingPhoneCode" => $eventBillingPhoneCode,
"eventBillingPhoneCountry" => $eventBillingPhoneCountry,
"eventBillingPhoneNumber" => $eventBillingPhoneNumber,
"eventBillingZip" => $eventBillingZip,
"eventBillingPaymentMethod" => $eventBillingPaymentMethod
);

$_SESSION["bccc_event_billing"] = $eventBilling;

if($eventBillingPaymentMethod == 1){
$res = array("err" => 0, "msg" => "Event billing information processed. Proceeding to card payment.", "redir"=> "/" . basename(dirname(__FILE__, 3)) . "/event/payment/card");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Invalid payment method found");
echo json_encode($res);
}

}
catch (PDOException $e){
$res = array("err" => 1, "msg" => "Error in database connection: " . $e->getMessage());
echo json_encode($res);
}
}
}
else{
$res = array("err" => 1, "msg" => "Invalid form submission");
echo json_encode($res);
}

ob_end_flush();

?>