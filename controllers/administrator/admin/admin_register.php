<?php
ob_start();

include_once(__DIR__ . '/../../../models/admin_model.php');
include_once(__DIR__ . '/../../../models/validation_model.php');
include_once(__DIR__ . '/../../../models/content_model.php');
include_once(__DIR__.'/../../../application/sendmail.php');

if(isset($_POST['adminRegisterSubmit'])){

$adminPwd = trim(htmlspecialchars($_POST['adminPwd']));
$adminName = trim(htmlspecialchars($_POST['adminName']));
$adminEmail = trim(htmlspecialchars($_POST['adminEmail']));

$adminImage = $_FILES["adminProfileImage"]["name"];
$adminImageTemp = $_FILES["adminProfileImage"]["tmp_name"];
$adminImageSize = $_FILES["adminProfileImage"]["size"];

$validationModel = new ValidationModel();

$validateAdminRegister = $validationModel->validateAdminRegister($adminName, $adminEmail, $adminPwd);

if(!($validateAdminRegister)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
$adminModel = new AdminModel();
$checkAdminExists = $adminModel->checkAdminExists($adminEmail);
if($checkAdminExists){
$res = array("err" => 1, "msg" => "Administrator with email ID already exists");
echo json_encode($res);
}
else{
$adminUserID = getAdminUserID();
if($adminUserID == false){
$res = array("err" => 1, "msg" => "Maximum ID limit reached");
echo json_encode($res);
}
else{
$adminPwdHash = PASSWORD_HASH($adminPwd, PASSWORD_DEFAULT);
$createAdmin = $adminModel->registerAdmin($adminUserID, $adminPwdHash, $adminName, $adminEmail);
if($createAdmin){

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

$sendMailInfo = array(
"adminEmail" => $adminEmail, 
"adminName" => $adminName, 
"adminUserID" => $adminUserID
);
sendUserMailNotification($sendMailInfo);
sendAdminMailNotification($sendMailInfo);

$res = array("err" => 0, "msg" => "Administrator account created successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to create administrator profile.");
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

function uploadImage($adminImage, $adminImageTemp, $adminUserID){
$adminImagePath = pathinfo($adminImage);
$adminImageFileType = $adminImagePath['extension'];
$targetDir = __DIR__."/../../public/assets/images/admin/";
$adminImageFile = strtolower(str_replace(" ", "_", $adminUserID) . "." . $adminImageFileType);
$targetFile = $targetDir . $adminImageFile;
move_uploaded_file($adminImageTemp, $targetFile);
//Add Image File Name to Database
$adminModel = new AdminModel();
$adminModel->updateAdminImage($adminImageFile, $adminUserID);
}

function sendUserMailNotification($sendMailInfo){

$sendMailVars = array(
'sendMailMainMsg' => renderMailUserMsg($sendMailInfo)
);

//Get About Information

$contentModel = new ContentModel();
$sendMailAboutVars = $contentModel->aboutJSON();

$sendMailSubject = $sendMailAboutVars['aboutJSONTitle'];
$sendMailBody = file_get_contents(__DIR__.'/../../views/email/user/registration.html');

if(isset($sendMailVars)){
foreach($sendMailVars as $k=>$v){
$sendMailBody = str_replace('{'. strtoupper($k) . '}', $v, $sendMailBody);
}
}

if(isset($sendMailAboutVars)){
foreach($sendMailAboutVars as $k=>$v){
$sendMailBody = str_replace('{'. strtoupper($k) . '}', $v, $sendMailBody);
}
}

new sendMail($sendMailInfo['adminEmail'], $sendMailInfo['adminName'], $sendMailSubject, $sendMailBody);
}

//Admin Mail Notification

function sendAdminMailNotification($sendMailInfo){

$sendMailVars = array(
'sendMailMainMsg' => renderMailAdminMsg($sendMailInfo)
);

//Get About Information

$contentModel = new ContentModel();
$sendMailAboutVars = $contentModel->aboutJSON();

$sendMailAdminEmail = $contentModel->adminEmail();
$sendMailSubject = $sendMailAboutVars['aboutJSONTitle'];
$sendMailBody = file_get_contents(__DIR__.'/../../views/email/user/registration.html');

if(isset($sendMailVars)){
foreach($sendMailVars as $k=>$v){
$sendMailBody = str_replace('{'. strtoupper($k) . '}', $v, $sendMailBody);
}
}

if(isset($sendMailAboutVars)){
foreach($sendMailAboutVars as $k=>$v){
$sendMailBody = str_replace('{'. strtoupper($k) . '}', $v, $sendMailBody);
}
}

new sendMail($sendMailAdminEmail, $sendMailInfo['adminName'], $sendMailSubject, $sendMailBody);
}

function getAdminUserID(){
$min = 11111;
$max = 99999;
$adminUID = generateAdminUserID($min, $max);
$adminModel = new AdminModel();
if($adminModel->getTotalAdmins() < (($max - $min) + 1)){
do{
$adminUID = generateAdminUserID($min, $max);
if($adminModel->checkUID($adminUID) == false){
return $adminUID;
break;
}
}while($adminModel->checkUID($adminUID) == true && $dne == 0);
}
else{
return false;
}
}

//Generate UID
function generateAdminUserID($min, $max){
$adminUID = 'FRA' . rand($min, $max);
return $adminUID;
}

//Render Email Notification Message

function renderMailUserMsg($sendMailInfo){
$renderMailMsg = 'Hello, '. $sendMailInfo['adminName'].',&#60;br&#47;&#62;&#60;br&#47;&#62;'.
'Your administrator account has been successfully registered in the Freedom Fun app.&#60;br&#47;&#62;'.
'&#60;br&#47;&#62;Your account details:&#60;br&#47;&#62;&#60;br&#47;&#62;'.
'&#60;b&#62;User ID:&#60;&#47;b&#62; '.$sendMailInfo['adminUserID'].'&#60;br&#47;&#62;'.
'&#60;b&#62;Email ID:&#60;&#47;b&#62; '.$sendMailInfo['adminEmail'].'&#60;br&#47;&#62;';
return html_entity_decode($renderMailMsg);
}

function renderMailAdminMsg($sendMailInfo){
$renderMailMsg = 'Hello,&#60;br&#47;&#62;&#60;br&#47;&#62;'.
'Administrator ' . $sendMailInfo['adminName'] . ' account has been successfully registered in the Freedom Fun app.&#60;br&#47;&#62;'.
'&#60;br&#47;&#62;Account details:&#60;br&#47;&#62;&#60;br&#47;&#62;'.
'&#60;b&#62;User ID:&#60;&#47;b&#62; '.$sendMailInfo['adminUserID'].'&#60;br&#47;&#62;'.
'&#60;b&#62;Email ID:&#60;&#47;b&#62; '.$sendMailInfo['adminEmail'].'&#60;br&#47;&#62;';
return html_entity_decode($renderMailMsg);
}

ob_end_flush();

?>