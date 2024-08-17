<?php
ob_start();

include_once(__DIR__ . '/../../models/event_model.php');
include_once(__DIR__ . '/../../models/validation_model.php');
include_once(__DIR__ . '/../../models/content_model.php');
include_once(__DIR__.'/../../application/sendmail.php');

if(isset($_POST['eventParticipantInfoSubmit'])){

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

if(!isset($_SESSION['bccc_event_participant'])){
$_SESSION['bccc_event_participant'] = array();
}

$_SESSION['bccc_event_participant'] = $event_participant;

$res = array("err" => 0, "msg" => "Participant information processed", "redir"=> "/" . basename(dirname(__FILE__, 3)) . "/admin/signup/checkout");
echo json_encode($res);
}

}
}
else{
$res = array("err" => 1, "msg" => "Invalid form submission");
echo json_encode($res);
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