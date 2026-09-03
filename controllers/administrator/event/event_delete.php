<?php
ob_start();

include_once(__DIR__ . '/../../../models/event_model.php');

if(isset($_POST['deleteUID']) && !empty($_POST['deleteUID'])){

$eventUID = trim(htmlspecialchars($_POST['deleteUID']));


if($eventUID == ''){
$res = array("err" => 1, "msg" => "Unable to get event ID");
echo json_encode($res);
}
else{
try{
$eventModel = new EventModel();
$checkEventUID = $eventModel->checkUID($eventUID);
if($checkEventUID){
$eventInfo = $eventModel->getEventByUID($eventUID);
$deleteEvent = $eventModel->deleteEvent($eventUID);
if($deleteEvent){
$eventImage = __DIR__.'/../../../public/assets/images/event/'.$eventInfo['ffe_image'];
if(file_exists($eventImage)){
unlink($eventImage);
}
$res = array("err" => 0, "msg" => "Event deleted successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Unable to delete event from records");
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
$res = array("err" => 1, "msg" => "Unable to get event ID");
echo json_encode($res);
}

ob_end_flush();

?>