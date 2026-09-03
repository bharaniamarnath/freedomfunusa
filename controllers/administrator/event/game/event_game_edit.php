<?php
ob_start();

include_once(__DIR__ . '/../../../../models/event_model.php');
include_once(__DIR__ . '/../../../../models/validation_model.php');
include_once(__DIR__ . '/../../../../models/content_model.php');
include_once(__DIR__.'/../../../../application/sendmail.php');

if(isset($_POST['eventGameEditSubmit'])){

$eventGameEvent = trim(htmlspecialchars($_POST['eventGameEvent']));
$eventGameName = trim(htmlspecialchars($_POST['eventGameName']));
$eventGameCategory = trim(htmlspecialchars($_POST['eventGameCategory']));
$eventGameDate = trim(htmlspecialchars($_POST['eventGameDate']));
$eventGameDuration = trim(htmlspecialchars($_POST['eventGameDuration']));
$eventGameSession = trim(htmlspecialchars($_POST['eventGameSession']));
$eventGameSlots = trim(htmlspecialchars($_POST['eventGameSlots']));
$eventGameAvailability = trim(htmlspecialchars($_POST['eventGameAvailability']));
$eventGameDescription = trim(htmlentities($_POST['eventGameDescription']));
$eventGameUserID = trim(htmlspecialchars($_POST['eventGameUID']));

$validationModel = new ValidationModel();

$validateAdminRegister = $validationModel->validateEventGameUpdate($eventGameEvent, $eventGameCategory, $eventGameName, $eventGameDate, $eventGameDuration, $eventGameSession, $eventGameSlots, $eventGameAvailability, $eventGameDescription);

if(!($validateAdminRegister)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
$eventGameModel = new EventModel();
$checkEventExists = $eventGameModel->checkEventGameUID($eventGameUserID);
if(!$checkEventExists){
$res = array("err" => 1, "msg" => "Update failed. Event Game not found in the records.");
echo json_encode($res);
}
else{
$updateEvent = $eventGameModel->updateEventGame($eventGameUserID, $eventGameEvent, $eventGameCategory, $eventGameName, $eventGameDate, $eventGameDuration, $eventGameSession, $eventGameSlots, $eventGameAvailability, $eventGameDescription);
if($updateEvent){
$res = array("err" => 0, "msg" => "Event Game updated successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to update event game details.");
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

ob_end_flush();

?>