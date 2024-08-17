<?php
ob_start();

include_once(__DIR__ . '/../../../models/admin_model.php');
include_once(__DIR__ . '/../../../models/content_model.php');
include_once(__DIR__.'/../../../application/sendmail.php');

if(isset($_POST['adminAdministratorEditSubmit'])){

$AdministratorStatus = trim(htmlspecialchars($_POST['adminStatus']));
$AdministratorUID = trim(htmlspecialchars($_POST['adminUID']));

if($AdministratorStatus == '' && $AdministratorUID == ''){
$res = array("err" => 1, "msg" => "No input found in one or more required fields");
echo json_encode($res);
}
else{
try{
$adminModel = new adminModel();

$checkAdminExists = $adminModel->checkUID($AdministratorUID);
if(!$checkAdminExists){
$res = array("err" => 1, "msg" => "Update failed. Administrator not found in the records.");
echo json_encode($res);
}
else{
$updateAdminStatus = $adminModel->updateAdminStatus($AdministratorUID, $AdministratorStatus);
if($updateAdminStatus){
$res = array("err" => 0, "msg" => "Administrator account status updated successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to update Administrator account status.");
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