<?php
ob_start();

if(isset($_POST['itemUID']) && !empty($_POST['itemUID'])){

$eventGameUID = trim(htmlspecialchars($_POST['itemUID']));
$eventGameSlots = trim(htmlspecialchars($_POST['itemContent']));

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
    $_SESSION['bccc_event_game'][$pos]['eventGameSlots'] = $eventGameSlots;
    $res = array("err" => 0, "msg" => "Item updated in your cart.");
    echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Unable to update item in your cart.");
echo json_encode($res);
}
}
else{
$res = array("err" => 1, "msg" => "Unable to find your cart.");
echo json_encode($res);
}

}
else{
$res = array("err" => 1, "msg" => "Invalid form submission");
echo json_encode($res);
}

ob_end_flush();

?>