<?php
ob_start();

include_once(__DIR__ . '/../../../models/admin_model.php');
include_once(__DIR__ . '/../../../models/validation_model.php');
include_once(__DIR__ . '/../../../models/content_model.php');
include_once(__DIR__.'/../../../application/sendmail.php');

if(isset($_POST['adminProfileEditSubmit'])){

$adminName = trim(htmlspecialchars($_POST['adminName']));
$adminEmail = trim(htmlspecialchars($_POST['adminEmail']));
$adminUID = trim(htmlspecialchars($_POST['adminUID']));

$adminImage = $_FILES["adminProfileImage"]["name"];
$adminImageTemp = $_FILES["adminProfileImage"]["tmp_name"];
$adminImageSize = $_FILES["adminProfileImage"]["size"];

$validationModel = new ValidationModel();

$validateAdminUpdate = $validationModel->validateAdminUpdate($adminName, $adminEmail);

if(!($validateAdminUpdate)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
$adminModel = new AdminModel();
$checkAdminExists = $adminModel->checkUID($adminUID);
if(!$checkAdminExists){
$res = array("err" => 1, "msg" => "Update failed. Admin not found in the records.");
echo json_encode($res);
}
else{
$updateAdmin = $adminModel->updateAdmin($adminName, $adminEmail, $adminUID);
if($updateAdmin){

//Validate and Upload Image
if($adminImageSize > 0){
$validationModel = new ValidationModel();
$validateAdminImage = $validationModel->validateAdminImage($adminImage, $adminImageTemp, $adminImageSize);
if(!($validateAdminImage)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
uploadImage($adminImage, $adminImageTemp, $adminUserID);
}
catch(Exception $e){
$res = array("err" => 1, "msg" => "Error occured. Unable to upload profile image.");
echo json_encode($res);
}
}
}

$res = array("err" => 0, "msg" => "Administrator profile updated successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to update Administrator profile.");
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

function uploadImage($adminImage, $adminImageTemp, $adminUID){
$adminImagePath = pathinfo($adminImage);
$adminImageFileType = $adminImagePath['extension'];
$adminImageFile = strtolower(str_replace(" ", "_", $adminUID) . "." . $adminImageFileType);
$targetDir = __DIR__."/../../public/assets/images/admin/";
$targetFile = $targetDir . $adminImageFile;
move_uploaded_file($adminImageTemp, $targetFile);
//Add Image File Name to Database
$adminModel = new AdminModel();
$adminModel->updateAdminImage($adminImageFile, $adminUID);
}


ob_end_flush();

?>