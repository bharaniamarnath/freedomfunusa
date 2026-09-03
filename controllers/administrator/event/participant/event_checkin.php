<?php
ob_start();

include_once(__DIR__ . '/../../../../models/event_model.php');
include_once(__DIR__ . '/../../../../models/content_model.php');
include_once(__DIR__.'/../../../../application/sendmail.php');

if(isset($_POST['eventCheckinSubmit'])){

$eventCheckinOrderID = trim(htmlspecialchars($_POST['eventCheckinOrderID']));

try{
$eventModel = new EventModel();

$eventCheckinStatus = 1;
$eventCheckinTime = date('Y-m-d H:i:s');

$checkinEventParticipant = $eventModel->checkinEventParticipant($eventCheckinOrderID, $eventCheckinStatus, $eventCheckinTime);
if($checkinEventParticipant){
$res = array("err" => 0, "msg" => "Event checked in successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to checkin event.");
echo json_encode($res);
}

}
catch (PDOException $e){
$res = array("err" => 1, "msg" => "Error in database connection: " . $e->getMessage());
echo json_encode($res);
}

}
else{
$res = array("err" => 1, "msg" => "Invalid form submission");
echo json_encode($res);
}


ob_end_flush();

?>