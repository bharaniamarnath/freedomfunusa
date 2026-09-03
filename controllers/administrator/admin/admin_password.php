<?php
ob_start();

include_once(__DIR__ . '/../../../models/admin_model.php');
include_once(__DIR__ . '/../../../models/validation_model.php');
include_once(__DIR__ . '/../../../models/content_model.php');
include_once(__DIR__.'/../../../application/sendmail.php');

if(isset($_POST['adminPasswordEditSubmit'])){

$adminPwd = trim(htmlspecialchars($_POST['adminPwd']));
$adminNewPwd = trim(htmlspecialchars($_POST['adminNewPwd']));
$adminEmail = trim(htmlspecialchars($_POST['adminEmail']));
$adminAccountStatus = trim(htmlspecialchars($_POST['adminAccountStatus']));

$validationModel = new ValidationModel();

$validateAdminPwdUpdate = $validationModel->validateAdminPwdUpdate($adminPwd, $adminNewPwd);

if(!($validateAdminPwdUpdate)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
$adminModel = new AdminModel();
$checkAdminExists = $adminModel->checkAdminExists($adminEmail);
if(!$checkAdminExists){
$res = array("err" => 1, "msg" => "Update failed. Admin not found in the records.");
echo json_encode($res);
}
else{
$checkAdminLogin = $adminModel->checkAdminLogin($adminEmail, $adminPwd);
if($checkAdminLogin){
$adminNewPwdHash = PASSWORD_HASH($adminNewPwd, PASSWORD_DEFAULT);
$updateAdminSettings = $adminModel->updateAdminSettings($adminEmail, $adminNewPwdHash);
if($updateAdminSettings){
$res = array("err" => 0, "msg" => "Administrator settings updated successfully", "redir"=> "admin/login?u=1");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to update administrator settings.");
echo json_encode($res);
}
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to verify administrator login information.");
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

ob_end_flush();

?>