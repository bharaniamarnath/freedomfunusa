<?php
ob_start();

include_once(__DIR__ . '/../../../../models/event_model.php');
include_once(__DIR__ . '/../../../../models/validation_model.php');
include_once(__DIR__ . '/../../../../models/content_model.php');
include_once(__DIR__.'/../../../../application/sendmail.php');

if(isset($_POST['eventGameRegisterSubmit'])){

$eventGameEvent = trim(htmlspecialchars($_POST['eventGameEvent']));
$eventGameName = trim(htmlspecialchars($_POST['eventGameName']));
$eventGameCategory = trim(htmlspecialchars($_POST['eventGameCategory']));
$eventGameDate = trim(htmlspecialchars($_POST['eventGameDate']));
$eventGameDuration = trim(htmlspecialchars($_POST['eventGameDuration']));
$eventGameSession = trim(htmlspecialchars($_POST['eventGameSession']));
$eventGameAvailability = trim(htmlspecialchars($_POST['eventGameAvailability']));
$eventGameSlots = trim(htmlspecialchars($_POST['eventGameSlots']));
$eventGameDescription = trim(htmlentities($_POST['eventGameDescription']));

$validationModel = new ValidationModel();

$validateAdminRegister = $validationModel->validateEventGameRegister($eventGameEvent, $eventGameCategory, $eventGameName, $eventGameDate, $eventGameDuration, $eventGameSession, $eventGameSlots, $eventGameAvailability, $eventGameDescription);

if(!($validateAdminRegister)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
$eventModel = new EventModel();
$checkEventGameExists = $eventModel->checkEventGameExists($eventGameEvent, $eventGameName, $eventGameDate);
if($checkEventGameExists){
$res = array("err" => 1, "msg" => "Game already exists in registered event and date");
echo json_encode($res);
}
else{
$eventGameUserID = getEventGameUID();
if($eventGameUserID == false){
$res = array("err" => 1, "msg" => "Maximum ID limit reached");
echo json_encode($res);
}
else{
$registerEventGame = $eventModel->registerEventGame($eventGameUserID, $eventGameEvent, $eventGameCategory, $eventGameName, $eventGameDate, $eventGameDuration, $eventGameSession, $eventGameSlots, $eventGameAvailability, $eventGameDescription);
if($registerEventGame){
$res = array("err" => 0, "msg" => "Event Game created successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to create Event Game.");
echo json_encode($res);
}
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

function getEventGameUID(){
$min = 11111;
$max = 99999;
$eventGameUserID = generateEventGameUID($min, $max);
$eventModel = new EventModel();
if($eventModel->getTotalEventGames() < (($max - $min) + 1)){
do{
$eventGameUserID = generateEventGameUID($min, $max);
if($eventModel->checkUID($eventGameUserID) == false){
return $eventGameUserID;
break;
}
}while($eventModel->checkEventGameUID($eventGameUserID) == true && $dne == 0);
}
else{
return false;
}
}

//Generate UID
function generateEventGameUID($min, $max){
$eventGameUserID = 'FFEG' . rand($min, $max);
return $eventGameUserID;
}

ob_end_flush();

?>