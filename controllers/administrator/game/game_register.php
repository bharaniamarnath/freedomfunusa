<?php
ob_start();

include_once(__DIR__ . '/../../../models/game_model.php');
include_once(__DIR__ . '/../../../models/validation_model.php');
include_once(__DIR__ . '/../../../models/content_model.php');
include_once(__DIR__.'/../../../application/sendmail.php');

if(isset($_POST['gameRegisterSubmit'])){

$gameName = trim(htmlspecialchars($_POST['gameName']));
$gamePrice = trim(htmlspecialchars($_POST['gamePrice']));
$gameDescription = trim(htmlentities($_POST['gameDescription']));

$gameImage = $_FILES["gameProfileImage"]["name"];
$gameImageTemp = $_FILES["gameProfileImage"]["tmp_name"];
$gameImageSize = $_FILES["gameProfileImage"]["size"];

$validationModel = new ValidationModel();

$validateGameRegister = $validationModel->validateGameRegister($gameName, $gamePrice, $gameDescription);

if(!($validateGameRegister)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
$gameModel = new GameModel();
$checkGameExists = $gameModel->checkGameExists($gameName);
if($checkGameExists){
$res = array("err" => 1, "msg" => "Game already exists in registered event");
echo json_encode($res);
}
else{
$gameUserID = getGameUID();
if($gameUserID == false){
$res = array("err" => 1, "msg" => "Maximum ID limit reached");
echo json_encode($res);
}
else{
$registerGame = $gameModel->registerGame($gameUserID, $gameName, $gamePrice, $gameDescription);
if($registerGame){

//Validate and Upload Image
$validationModel = new ValidationModel();
$validateGameImage = $validationModel->validateGameImage($gameImage, $gameImageTemp, $gameImageSize);
if(!($validateGameImage)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
uploadImage($gameImage, $gameImageTemp, $gameUserID);
}
catch(Exception $e){
$res = array("err" => 1, "msg" => "Error occured. Unable to upload profile image.");
echo json_encode($res);
}
}

$res = array("err" => 0, "msg" => "Game created successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to create game.");
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

function uploadImage($gameImage, $gameImageTemp, $gameUserID){
$gameImagePath = pathinfo($gameImage);
$gameImageFileType = $gameImagePath['extension'];
$gameImageFile = strtolower(str_replace(" ", "_", $gameUserID) . "." . $gameImageFileType);
$targetDir = __DIR__."/../../../public/assets/images/game/";
$targetFile = $targetDir . $gameImageFile;
move_uploaded_file($gameImageTemp, $targetFile);
//Add Image File Name to Database
$gameModel = new GameModel();
$gameModel->updateGameImage($gameImageFile, $gameUserID);
}

function getGameUID(){
$min = 11111;
$max = 99999;
$gameUserID = generateGameUID($min, $max);
$gameModel = new GameModel();
if($gameModel->getTotalGames() < (($max - $min) + 1)){
do{
$gameUserID = generateGameUID($min, $max);
if($gameModel->checkUID($gameUserID) == false){
return $gameUserID;
break;
}
}while($gameModel->checkUID($gameUserID) == true && $dne == 0);
}
else{
return false;
}
}

//Generate UID
function generateGameUID($min, $max){
$gameUserID = 'FFG' . rand($min, $max);
return $gameUserID;
}

ob_end_flush();

?>