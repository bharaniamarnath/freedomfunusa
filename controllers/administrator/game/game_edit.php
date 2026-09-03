<?php
ob_start();

include_once(__DIR__ . '/../../../models/game_model.php');
include_once(__DIR__ . '/../../../models/validation_model.php');
include_once(__DIR__ . '/../../../models/content_model.php');
include_once(__DIR__.'/../../../application/sendmail.php');

if(isset($_POST['gameEditSubmit'])){

$gameName = trim(htmlspecialchars($_POST['gameName']));
$gamePrice = trim(htmlspecialchars($_POST['gamePrice']));
$gameDescription = trim(htmlentities($_POST['gameDescription']));
$gameUserID= trim(htmlspecialchars($_POST['gameUID']));

$gameImage = $_FILES["gameProfileImage"]["name"];
$gameImageTemp = $_FILES["gameProfileImage"]["tmp_name"];
$gameImageSize = $_FILES["gameProfileImage"]["size"];


$validationModel = new ValidationModel();

$validateGameUpdate = $validationModel->validateGameUpdate($gameName, $gamePrice, $gameDescription);

if(!($validateGameUpdate)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
$gameModel = new GameModel();
$checkGameExists = $gameModel->checkUID($gameUserID);
if(!$checkGameExists){
$res = array("err" => 1, "msg" => "Update failed. Game not found in the records.");
echo json_encode($res);
}
else{
$updateGame = $gameModel->updateGame($gameUserID, $gameName, $gamePrice, $gameDescription);
if($updateGame){
if($gameImageSize > 0){
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
}
$res = array("err" => 0, "msg" => "Game updated successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to update game details.");
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

function uploadImage($gameImage, $gameImageTemp, $gameUserID){
$gameImagePath = pathinfo($gameImage);
$gameImageFileType = $gameImagePath['extension'];
$targetDir = __DIR__."/../../../public/assets/images/game/";
$gameImageFile = strtolower(str_replace(" ", "_", $gameUserID) . "." . $gameImageFileType);
$targetFile = $targetDir . $gameImageFile;
move_uploaded_file($gameImageTemp, $targetFile);
//Add Image File Name to Database
$gameModel = new GameModel();
$gameModel->updateGameImage($gameImageFile, $gameUserID);
}

ob_end_flush();

?>