<?php
ob_start();

include_once(__DIR__ . '/../../models/participant_model.php');
include_once(__DIR__ . '/../../models/validation_model.php');
include_once(__DIR__ . '/../../models/content_model.php');
include_once(__DIR__.'/../../application/sendmail.php');

if(isset($_POST['eventParticipantRegisterSubmit'])){

$eventParticipantFirstName = trim(htmlspecialchars($_POST['eventParticipantFirstName']));
$eventParticipantLastName = trim(htmlspecialchars($_POST['eventParticipantLastName']));
$eventParticipantEmail = trim(htmlspecialchars($_POST['eventParticipantEmail']));
$eventParticipantPassword = trim(htmlspecialchars($_POST['eventParticipantPassword']));
$eventParticipantPhoneCode = explode('_', trim(htmlspecialchars($_POST['eventParticipantPhoneCode'])))[0];
$eventParticipantPhoneCountry = explode('_', trim(htmlspecialchars($_POST['eventParticipantPhoneCode'])))[1];
$eventParticipantPhoneNumber = trim(htmlspecialchars($_POST['eventParticipantPhoneNumber']));
$eventParticipantZip = trim(htmlspecialchars($_POST['eventParticipantZip']));

$validationModel = new ValidationModel();

$validateParticipant = $validationModel->validateParticipant($eventParticipantFirstName, $eventParticipantLastName, 
$eventParticipantEmail, $eventParticipantPassword, $eventParticipantPhoneCode, $eventParticipantPhoneNumber, $eventParticipantZip);

if(!($validateParticipant)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
$participantModel = new ParticipantModel();
$eventParticipantID = getEventParticipantID();
$checkParticipantExists = $participantModel->checkParticipantExists($eventParticipantID);
if($checkParticipantExists){
$res = array("err" => 1, "msg" => "Participant ID already exists");
echo json_encode($res);
}
else if($eventParticipantID == false){
$res = array("err" => 1, "msg" => "Maximum Participant ID limit reached");
echo json_encode($res);
}
else{
$eventParticipantPwdHash = PASSWORD_HASH($eventParticipantPassword, PASSWORD_DEFAULT);

$registerEventParticipant = $participantModel->registerEventParticipant(
$eventParticipantID,
$eventParticipantFirstName,
$eventParticipantLastName, 
$eventParticipantEmail,
$eventParticipantPwdHash,
$eventParticipantPhoneCode . $eventParticipantPhoneNumber, 
$eventParticipantZip
);

if($registerEventParticipant){

if(isset($_SESSION['bccc_participant_info'])){
$_SESSION['bccc_participant'] = array();
}

$res = array("err" => 0, "msg" => "Participant account registered", "redir"=> "event/participant");
echo json_encode($res);
}
else{


$event_participant_info = array(
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

$_SESSION['bccc_participant_info'] = $event_participant_info;

$res = array("err" => 1, "msg" => "Unable to register participant");
echo json_encode($res);
}
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
$participantModel = new ParticipantModel();
if($participantModel->getTotalParticipants() < (($max - $min) + 1)){
do{
$participantUID = generateEventParticipantID($min, $max);
if($participantModel->checkParticipantUID($participantUID) == false){
return $participantUID;
break;
}
}while($participantModel->checkParticipantUID($participantUID) == true && $dne == 0);
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