<?php
ob_start();

include_once(__DIR__ . '/../../models/participant_model.php');
include_once(__DIR__ . '/../../models/validation_model.php');

if(isset($_POST['participantLoginSubmit'])){

$participantLoginEmail = trim(htmlspecialchars($_POST['participantLoginEmail']));
$participantLoginPwd = trim(htmlspecialchars($_POST['participantLoginPwd']));

$validationModel = new ValidationModel();

$validateParticipantLogin = $validationModel->validateParticipantLogin($participantLoginEmail, $participantLoginPwd);

if(!($validateParticipantLogin)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
$participantModel = new ParticipantModel();
$checkParticipantLogin = $participantModel->checkParticipantLogin($participantLoginEmail, $participantLoginPwd);
if($checkParticipantLogin){
$participantLoginStatus = 1;
$participantModel->setParticipantLoginStatus($participantLoginEmail, $participantLoginStatus);

$participantLoginEmailInfo = $participantModel->getEventParticipantByEmailID($participantLoginEmail);
$bccc_event_participant = array(
'participantLoginEmail' => $participantLoginEmail,
'ParticipantLoginStatus' => $participantLoginStatus,
'ParticipantLoginFirstName' =>$participantLoginEmailInfo['ffep_first_name'],
'ParticipantLoginLastName' =>$participantLoginEmailInfo['ffep_last_name'],
'ParticipantLoginPhone' =>$participantLoginEmailInfo['ffep_phone'],
'ParticipantLoginZipCode' =>$participantLoginEmailInfo['ffep_zip'],
);
$_SESSION['bccc_event_participant'] = $bccc_event_participant;
$res = array("err" => 0, "msg" => "Participant login success", "redir"=> "event/checkout");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Participant login failed");
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