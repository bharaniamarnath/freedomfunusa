<?php
ob_start();

include_once(__DIR__ . '/../../../models/event_model.php');
include_once(__DIR__ . '/../../../models/validation_model.php');
include_once(__DIR__ . '/../../../models/content_model.php');
include_once(__DIR__.'/../../../application/sendmail.php');

if(isset($_POST['eventRegisterSubmit'])){

$eventName = trim(htmlspecialchars($_POST['eventName']));
$eventStartDate = trim(htmlspecialchars($_POST['eventStartDate']));
$eventEndDate = trim(htmlspecialchars($_POST['eventEndDate']));
$eventDescription = trim(htmlentities($_POST['eventDescription']));

$eventImage = $_FILES["eventProfileImage"]["name"];
$eventImageTemp = $_FILES["eventProfileImage"]["tmp_name"];
$eventImageSize = $_FILES["eventProfileImage"]["size"];

$validationModel = new ValidationModel();

$validateEventRegister = $validationModel->validateEventRegister($eventName, $eventStartDate, $eventEndDate, $eventDescription);

if(!($validateEventRegister)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}

else{
try{
$eventModel = new EventModel();
$checkCategoryExists = $eventModel->checkEventExists($eventName, $eventStartDate);
if($checkCategoryExists){
$res = array("err" => 1, "msg" => "Event already exists in registered category");
echo json_encode($res);
}
else{
$eventUserID = getEventUID();
if($eventUserID == false){
$res = array("err" => 1, "msg" => "Maximum ID limit reached");
echo json_encode($res);
}
else{
$registerEvent = $eventModel->registerEvent($eventUserID, $eventName, $eventStartDate, $eventEndDate, $eventDescription);
if($registerEvent){

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
$res = array("err" => 0, "msg" => "Event created successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to create event.");
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

function getEventUID(){
$min = 11111;
$max = 99999;
$eventUserID = generateEventUID($min, $max);
$eventModel = new EventModel();
if($eventModel->getTotalEvents() < (($max - $min) + 1)){
do{
$eventUserID = generateEventUID($min, $max);
if($eventModel->checkUID($eventUserID) == false){
return $eventUserID;
break;
}
}while($eventModel->checkUID($eventUserID) == true && $dne == 0);
}
else{
return false;
}
}

//Generate UID
function generateEventUID($min, $max){
$eventUserID = 'FFE' . rand($min, $max);
return $eventUserID;
}

ob_end_flush();

?>