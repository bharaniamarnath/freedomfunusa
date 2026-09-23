<?php
ob_start();

if(isset($_POST['eventRemoveUID']) && !empty($_POST['eventRemoveUID'])){

$eventGameUID = trim(htmlspecialchars($_POST['eventRemoveUID']));


if(isset($_SESSION['bccc_event_game']) && is_array($_SESSION['bccc_event_game'])){

$flag = 0;
$pos = null;

$total_event_games = count($_SESSION['bccc_event_game']);

for($i = 0; $i < $total_event_games; $i++){
if($_SESSION['bccc_event_game'][$i]['eventGameUID'] == $eventGameUID){
$pos = $i;
}
}

if($_SESSION['bccc_event_game'][$pos]['eventGameUID'] == $eventGameUID){
array_splice($_SESSION['bccc_event_game'], $pos, 1);
$res = array("err" => 0, "msg" => "Event game removed from cart.");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Unable to remove event game from cart.");
echo json_encode($res);
}
}
else{
$res = array("err" => 1, "msg" => "Unable to get event game cart.");
echo json_encode($res);
}

}
else{
$res = array("err" => 1, "msg" => "Invalid form submission");
echo json_encode($res);
}

ob_end_flush();

?>