<?php
ob_start();

include_once(__DIR__ . '/../../../models/admin_model.php');
include_once(__DIR__ . '/../../../models/validation_model.php');

if(isset($_POST['adminLoginSubmit'])){

$adminLoginEmail = trim(htmlspecialchars($_POST['adminLoginEmail']));
$adminLoginPwd = trim(htmlspecialchars($_POST['adminLoginPwd']));

$validationModel = new ValidationModel();

$validateAdminLogin = $validationModel->validateAdminLogin($adminLoginEmail, $adminLoginPwd);

if(!($validateAdminLogin)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
$adminModel = new AdminModel();
$checkAdminLogin = $adminModel->checkAdminLogin($adminLoginEmail, $adminLoginPwd);
if($checkAdminLogin){
$adminLoginStatus = 1;
$adminModel->setAdminLoginStatus($adminLoginEmail, $adminLoginStatus);
$bccc_admin = array(
'adminLoginEmail' => $adminLoginEmail,
'adminLoginStatus' => $adminLoginStatus
);
$_SESSION['bccc_admin'] = $bccc_admin;
$res = array("err" => 0, "msg" => "Administrator login success", "redir"=> "admin/dashboard");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Administrator login failed");
echo json_encode($res);
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