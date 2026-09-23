<?php
ob_start();

include_once(__DIR__ . '/../../../../models/event_model.php');

if(isset($_POST['deleteUID']) && !empty($_POST['deleteUID'])){

$eventGameUID = trim(htmlspecialchars($_POST['deleteUID']));


if($eventGameUID == ''){
$res = array("err" => 1, "msg" => "Unable to get event game ID");
echo json_encode($res);
}
else{
try{
$eventModel = new EventModel();
$checkEventGameUID = $eventModel->checkEventGameUID($eventGameUID);
if($checkEventGameUID){
$deleteEvent = $eventModel->deleteEventGame($eventGameUID);
if($deleteEvent){
$res = array("err" => 0, "msg" => "Event Game deleted successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Unable to delete event game from records");
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