<?php
ob_start();

include_once(__DIR__ . '/../../models/event_model.php');
include_once(__DIR__ . '/../../models/validation_model.php');
include_once(__DIR__ . '/../../models/content_model.php');

if(isset($_POST['eventCheckoutSubmit'])){

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

$contentModel = new ContentModel();
$eventInfoJSON = $contentModel->aboutJSON();

$eventOrderDesc = $eventInfoJSON["aboutJSONEventHeading"];
$eventOrderDate = date('Y-m-d H:i:s');
$eventParticipantIP = $_SERVER['REMOTE_ADDR'];

$validationModel = new ValidationModel();

$validateGameRegister = $validationModel->validateEventCheckout($eventCheckoutSubtotal, $eventCheckoutTax, $eventCheckoutShipping, $eventCheckoutTotal);

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
"eventOrderShipping" => $eventCheckoutShipping,
);

$_SESSION["bccc_event_order"] = $eventOrder;

if($eventCheckoutPaymentMethod == 1){
$res = array("err" => 0, "msg" => "Event billing information processed. Proceeding to card payment.", "redir"=> "event/payment/card");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Invalid payment method found");
echo json_encode($res);
}

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
$eventOrderUID = generateFundOrderID($min, $max);
$eventModel = new EventModel();
if($eventModel->getTotalEventOrders() < (($max - $min) + 1)){
do{
$eventOrderUID = generateFundOrderID($min, $max);
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
function generateFundOrderID($min, $max){
$eventOrderUID = 'FFEO' . rand($min, $max);
return $eventOrderUID;
}

ob_end_flush();

?>