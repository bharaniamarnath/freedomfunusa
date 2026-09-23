<?php
ob_start();

include_once(__DIR__ . '/../../models/validation_model.php');

if(isset($_POST['eventGameAddSubmit'])){

$eventGameUID = trim(htmlspecialchars($_POST['eventGameUID']));
$eventGamePrice = trim(htmlspecialchars($_POST['eventGamePrice']));
$eventGameSlots = trim(htmlspecialchars($_POST['eventGameSlots']));
$eventGameType = trim(htmlspecialchars($_POST['eventGameType']));
$eventGameSlotsLimit = trim(htmlspecialchars($_POST['eventGameSlotsLimit']));


$validationModel = new ValidationModel();

$validateAddEvent = $validationModel->validateAddEvent($eventGameUID, $eventGamePrice, $eventGameSlots, $eventGameSlotsLimit);

if(!($validateAddEvent)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
$event_game = array(
"eventGameReferenceID" => uniqid(),
"eventGameType" => $eventGameType,
"eventGameUID" => $eventGameUID,
"eventGamePrice" => $eventGamePrice,
"eventGameSlots" => $eventGameSlots,
"eventGameSlotslimit" => $eventGameSlotsLimit
);

if(!isset($_SESSION['bccc_event_game'])){
$_SESSION['bccc_event_game'] = array();
}

$lineItem = array(
"label" => $eventGameUID,
"amount" => $eventGamePrice
);

//Apple Pay Line Items

if(!isset($_SESSION['bccc_event_line_items'])){
$_SESSION['bccc_event_line_items'] = array();
}

if(isset($_SESSION['bccc_event_game']) && is_array($_SESSION['bccc_event_game'])){
if(checkFundExists($_SESSION['bccc_event_game'], 'eventGameUID', $eventGameUID)){
$res = array("err" => 1, "msg" => "Item already exists in your cart.");
echo json_encode($res);
}
else{
array_push($_SESSION['bccc_event_game'], $event_game);

//Apple Pay Line Items

array_push($_SESSION['bccc_event_line_items'], $lineItem);

$res = array("err" => 0, "msg" => "Item added to your cart.", "events" => $_SESSION['bccc_event_game']);
echo json_encode($res);
}
}
else{
$res = array("err" => 1, "msg" => "Unable to find your cart.");
echo json_encode($res);
}
}
}
else{
$res = array("err" => 1, "msg" => "Invalid form submission");
echo json_encode($res);
}

function checkFundExists($array, $key, $value){
foreach ($array as $item){
if(isset($item[$key]) && $item[$key] == $value){
return true;
}
}
return false;
}

ob_end_flush();

?>