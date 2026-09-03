<?php
ob_start();

include_once(__DIR__ . '/../../../models/category_model.php');
include_once(__DIR__ . '/../../../models/event_model.php');
include_once(__DIR__ . '/../../../models/validation_model.php');
include_once(__DIR__ . '/../../../models/content_model.php');
include_once(__DIR__.'/../../../application/sendmail.php');

if(isset($_POST['eventEditSubmit'])){

$eventName = trim(htmlspecialchars($_POST['eventName']));
$eventStartDate = trim(htmlspecialchars($_POST['eventStartDate']));
$eventEndDate = trim(htmlspecialchars($_POST['eventEndDate']));
$eventDescription = trim(htmlentities($_POST['eventDescription']));
$eventUserID= trim(htmlspecialchars($_POST['eventUID']));

$eventImage = $_FILES["eventProfileImage"]["name"];
$eventImageTemp = $_FILES["eventProfileImage"]["tmp_name"];
$eventImageSize = $_FILES["eventProfileImage"]["size"];

$validationModel = new ValidationModel();

$validateEventRegister = $validationModel->validateEventUpdate($eventName, $eventStartDate, $eventEndDate, $eventDescription);

if(!($validateEventRegister)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}


else{
try{
$eventModel = new EventModel();
$checkEventExists = $eventModel->checkUID($eventUserID);
if(!$checkEventExists){
$res = array("err" => 1, "msg" => "Update failed. Event not found in the records.");
echo json_encode($res);
}
else{
$updateEvent = $eventModel->updateEvent($eventUserID, $eventName, $eventStartDate, $eventEndDate, $eventDescription);
if($updateEvent){
if($eventImageSize > 0){

//Validate and Upload Image
$validationModel = new ValidationModel();
$validateEventImage = $validationModel->validateEventImage($eventImage, $eventImageTemp, $eventImageSize);
if(!($validateEventImage)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
uploadImage($eventImage, $eventImageTemp, $eventUserID);
}
catch(Exception $e){
$res = array("err" => 1, "msg" => "Error occured. Unable to upload profile image.");
echo json_encode($res);
}
}

}
$res = array("err" => 0, "msg" => "Event updated successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to update event details.");
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

function uploadImage($eventImage, $eventImageTemp, $eventUserID){
$eventImagePath = pathinfo($eventImage);
$eventImageFileType = $eventImagePath['extension'];
$targetDir = __DIR__."/../../../public/assets/images/event/";
$eventImageFile = strtolower(str_replace(" ", "_", $eventUserID) . "." . $eventImageFileType);
$targetFile = $targetDir . $eventImageFile;
move_uploaded_file($eventImageTemp, $targetFile);
//Add Image File Name to Database
$eventModel = new EventModel();
$eventModel->updateEventImage($eventImageFile, $eventUserID);
}

ob_end_flush();

?>