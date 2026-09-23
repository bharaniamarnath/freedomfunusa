<?php
ob_start();

include_once(__DIR__ . '/../../../models/game_model.php');

if(isset($_POST['deleteUID']) && !empty($_POST['deleteUID'])){

$gameUID = trim(htmlspecialchars($_POST['deleteUID']));


if($gameUID == ''){
$res = array("err" => 1, "msg" => "Unable to get game ID");
echo json_encode($res);
}
else{
try{
$gameModel = new GameModel();
$checkGameUID = $gameModel->checkUID($gameUID);
if($checkGameUID){
$gameInfo = $gameModel->getGameByUID($gameUID);
$deleteGame = $gameModel->deleteGame($gameUID);
if($deleteGame){
$gameImage = __DIR__.'/../../../public/assets/images/game/'.$gameInfo['ffg_image'];
if(file_exists($gameImage)){
unlink($gameImage);
}
$res = array("err" => 0, "msg" => "Game deleted successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Unable to delete game from records");
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