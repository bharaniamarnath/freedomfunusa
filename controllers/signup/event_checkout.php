<?php
ob_start();

include_once(__DIR__ . '/../../models/event_model.php');
include_once(__DIR__ . '/../../models/validation_model.php');
include_once(__DIR__ . '/../../models/content_model.php');

if(isset($_POST['eventSignUpCheckoutSubmit'])){

//Get Participant Information

$eventParticipantFirstName = trim(htmlspecialchars($_POST['eventParticipantFirstName']));
$eventParticipantLastName = trim(htmlspecialchars($_POST['eventParticipantLastName']));
$eventParticipantEmail = trim(htmlspecialchars($_POST['eventParticipantEmail']));
$eventParticipantPhoneCode = explode('_', trim(htmlspecialchars($_POST['eventParticipantPhoneCode'])))[0];
$eventParticipantPhoneCountry = explode('_', trim(htmlspecialchars($_POST['eventParticipantPhoneCode'])))[1];
$eventParticipantPhoneNumber = trim(htmlspecialchars($_POST['eventParticipantPhoneNumber']));
$eventParticipantZip = trim(htmlspecialchars($_POST['eventParticipantZip']));

$validationModel = new ValidationModel();

$validateParticipant = $validationModel->validateParticipant($eventParticipantFirstName, $eventParticipantLastName, 
$eventParticipantEmail, $eventParticipantPhoneCode, $eventParticipantPhoneNumber, $eventParticipantZip);

if(!($validateParticipant)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
$eventModel = new EventModel();
$eventParticipantID = getEventParticipantID();
$checkParticipantExists = $eventModel->checkParticipantExists($eventParticipantID);
if($checkParticipantExists){
$res = array("err" => 1, "msg" => "Participant ID already exists");
echo json_encode($res);
}
else if($eventParticipantID == false){
$res = array("err" => 1, "msg" => "Maximum Participant ID limit reached");
echo json_encode($res);
}
else{
$event_participant = array(
"eventParticipantReferenceID" => uniqid(),
"eventParticipantID" => $eventParticipantID,
"eventParticipantFirstName" => $eventParticipantFirstName,
"eventParticipantLastName" => $eventParticipantLastName,
"eventParticipantEmail" => $eventParticipantEmail,
"eventParticipantPhoneCode" => $eventParticipantPhoneCode,
"eventParticipantPhoneCountry" => $eventParticipantPhoneCountry,
"eventParticipantPhoneNumber" => $eventParticipantPhoneNumber,
"eventParticipantZip" => $eventParticipantZip
);

if(!isset($_SESSION['bccc_participant'])){
$_SESSION['bccc_participant'] = array();
}

$_SESSION['bccc_participant'] = $event_participant;
}
}

//Get Checkout Event Bill Information

$eventCheckoutSubtotal = trim(htmlspecialchars($_POST['eventCheckoutSubtotal']));
$eventCheckoutSubtotal = number_format($eventCheckoutSubtotal, 2, ".", "");

$eventCheckoutTax = trim(htmlspecialchars($_POST['eventCheckoutTax']));
$eventCheckoutTax = number_format($eventCheckoutTax, 2, ".", "");

$eventCheckoutShipping = trim(htmlspecialchars($_POST['eventCheckoutShipping']));
$eventCheckoutShipping = number_format($eventCheckoutShipping, 2, ".", "");

$eventCheckoutTotal = trim(htmlspecialchars($_POST['eventCheckoutTotal']));
$eventCheckoutTotal = number_format($eventCheckoutTotal, 2, ".", "");


$eventCheckoutPaymentMethod = trim(htmlspecialchars($_POST['eventCheckoutPaymentMethod']));

$eventOrderDesc = "Freedom Fun Event";
$eventOrderDate = date('Y-m-d H:i:s');
$eventParticipantIP = $_SERVER['REMOTE_ADDR'];

$validationModel = new ValidationModel();

$validateGameRegister = $validationModel->validateEventSignUpCheckout($eventCheckoutSubtotal, $eventCheckoutTax, $eventCheckoutShipping, $eventCheckoutTotal, $eventCheckoutPaymentMethod);

if(!($validateGameRegister)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
$eventModel = new EventModel();
$eventOrderID = getEventOrderID();
$checkEventOrderExists = $eventModel->checkEventOrderExists($eventOrderID);
if($checkEventOrderExists){
$res = array("err" => 1, "msg" => "Event Order ID already exists");
echo json_encode($res);
}
else if($eventOrderID == false){
$res = array("err" => 1, "msg" => "Maximum Event ID limit reached");
echo json_encode($res);
}
else{

$eventOrder = array(
"eventOrderID" => $eventOrderID,
"eventOrderDesc" => $eventOrderDesc,
"eventOrderDate" => $eventOrderDate,
"eventOrderParticipantIP" => $eventParticipantIP,
"eventOrdersubTotal" => $eventCheckoutSubtotal,
"eventOrderTotal" => $eventCheckoutTotal,
"eventOrderTax" => $eventCheckoutTax,
"eventOrderShipping" => $eventCheckoutShipping
);

$_SESSION["bccc_event_order"] = $eventOrder;

}

$eventBilling = array(
"eventBillingFirstName" => $eventParticipantFirstName,
"eventBillingLastName" => $eventParticipantLastName,
"eventBillingEmail" => $eventParticipantEmail,
"eventBillingPhoneCode" => $eventParticipantPhoneCode,
"eventBillingPhoneCountry" => $eventParticipantPhoneCountry,
"eventBillingPhoneNumber" => $eventParticipantPhoneNumber,
"eventBillingZip" => $eventParticipantZip,
"eventBillingPaymentMethod" => $eventCheckoutPaymentMethod
);

$_SESSION["bccc_event_billing"] = $eventBilling;

if($eventCheckoutPaymentMethod == 1){
$res = array("err" => 0, "msg" => "Event billing information processed. Proceeding to card payment.", "redir"=> "/" . basename(dirname(__FILE__, 3)) . "/admin/signup/payment/card");
echo json_encode($res);
}
else if($eventCheckoutPaymentMethod == 2){
$res = array("err" => 0, "msg" => "Event billing information processed. Proceeding to cash payment.", "redir"=> "/" . basename(dirname(__FILE__, 3)) . "/admin/signup/payment/cash");
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

function getEventOrderID(){
$min = 11111;
$max = 99999;
$eventOrderUID = generateEventOrderID($min, $max);
$eventModel = new EventModel();
if($eventModel->getTotalEventOrders() < (($max - $min) + 1)){
do{
$eventOrderUID = generateEventOrderID($min, $max);
if($eventModel->checkEventOrderUID($eventOrderUID) == false){
return $eventOrderUID;
break;
}
}while($eventModel->checkEventOrderUID($eventOrderUID) == true && $dne == 0);
}
else{
return false;
}
}

//Generate UID
function generateEventOrderID($min, $max){
$eventOrderUID = 'FFEO' . rand($min, $max);
return $eventOrderUID;
}

function getEventParticipantID(){
$min = 11111;
$max = 99999;
$participantUID = generateEventParticipantID($min, $max);
$eventModel = new EventModel();
if($eventModel->getTotalParticipants() < (($max - $min) + 1)){
do{
$participantUID = generateEventParticipantID($min, $max);
if($eventModel->checkParticipantUID($participantUID) == false){
return $participantUID;
break;
}
}while($eventModel->checkParticipantUID($participantUID) == true && $dne == 0);
}
else{
return false;
}
}

//Generate UID
function generateEventParticipantID($min, $max){
$participantUID = 'FFEP' . rand($min, $max);
return $participantUID;
}

ob_end_flush();

?>