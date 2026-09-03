<?php
ob_start();

include_once(__DIR__ . '/../../models/freeplay_model.php');
include_once(__DIR__ . '/../../models/content_model.php');
include_once(__DIR__.'/../../application/sendmail.php');

if(isset($_POST['freeplayRegisterSubmit'])){

$freeplayName = trim(htmlspecialchars($_POST['freeplayName']));
$freeplayEmail = trim(htmlspecialchars($_POST['freeplayEmail']));
$freeplayPhoneCode = trim(htmlspecialchars($_POST['freeplayPhoneCode']));
$freeplayPhoneNumber = trim(htmlspecialchars($_POST['freeplayPhoneNumber']));
$freeplayPhone = trim(htmlspecialchars($_POST['freeplayPhoneCode'])) . trim(htmlspecialchars($_POST['freeplayPhoneNumber']));
$freeplayDOB = trim(htmlspecialchars($_POST['freeplayDOB']));
$freeplayGuardianName = trim(htmlspecialchars($_POST['freeplayGuardianName']));
$freeplayAddress = trim(htmlspecialchars($_POST['freeplayAddress']));
$freeplayZip = trim(htmlspecialchars($_POST['freeplayZip']));
$freeplayWaiver = isset($_POST['freeplayWaiverCheck']) ? 1 : 0;

$validationModel = new ValidationModel();

$validateAdminUpdate = $validationModel->validateFreeplayRegister($freeplayName, $freeplayEmail, $freeplayPhoneCode, $freeplayPhoneNumber, $freeplayDOB, $freeplayGuardianName, $freeplayAddress, $freeplayZip);

if(!($validateAdminUpdate)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
$freeplayModel = new FreeplayModel();
$checkFreeplayExists = $freeplayModel->checkFreeplayExists($freeplayEmail);
if($checkFreeplayExists){
$res = array("err" => 1, "msg" => "Freeplay account with email ID already exists");
echo json_encode($res);
}
else{
$freeplayUserID = getFreeplayUserID();
if($freeplayUserID == false){
$res = array("err" => 1, "msg" => "Maximum ID limit reached");
echo json_encode($res);
}
else{
$createFreeplay = $freeplayModel->registerFreeplay($freeplayUserID, $freeplayEmail, $freeplayName, $freeplayPhone, $freeplayDOB, $freeplayGuardianName, $freeplayAddress, $freeplayZip);
if($createFreeplay){
$res = array("err" => 0, "msg" => "Freeplay registered successfully");
$sendMailInfo = array(
"freeplayEmail" => $freeplayEmail, 
"freeplayName" => $freeplayName, 
"freeplayUserID" => $freeplayUserID
);
sendUserMailNotification($sendMailInfo, $freeplayWaiver);
sendAdminMailNotification($sendMailInfo);
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to register freeplay");
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

function sendUserMailNotification($sendMailInfo, $sendMailWaiver){

$sendMailVars = array(
'sendMailMainMsg' => renderUserMailMsg($sendMailInfo)
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

new sendMail($sendMailInfo['freeplayEmail'], $sendMailInfo['freeplayName'], $sendMailSubject, $sendMailBody, $sendMailWaiver);
}

//Freeplay Mail Notification

function sendAdminMailNotification($sendMailInfo){

$sendMailVars = array(
'sendMailMainMsg' => renderAdminMailMsg($sendMailInfo)
);

//Get About Information

$contentModel = new ContentModel();
$sendMailAboutVars = $contentModel->aboutJSON();

$sendMailFreeplayEmail = $contentModel->adminEmail();
$sendMailSubject = $sendMailAboutVars['aboutJSONTitle'];
$sendMailBody = file_get_contents(__DIR__.'/../../views/email/admin/registration.html');

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

new sendMail($sendMailFreeplayEmail, $sendMailInfo['freeplayName'], $sendMailSubject, $sendMailBody);
}

function getFreeplayUserID(){
$min = 11111;
$max = 99999;
$freeplayUID = generateFreeplayUserID($min, $max);
$freeplayModel = new FreeplayModel();
if($freeplayModel->getTotalFreeplays() < (($max - $min) + 1)){
do{
$freeplayUID = generateFreeplayUserID($min, $max);
if($freeplayModel->checkUID($freeplayUID) == false){
return $freeplayUID;
break;
}
}while($freeplayModel->checkUID($freeplayUID) == true && $dne == 0);
}
else{
return false;
}
}

//Generate UID
function generateFreeplayUserID($min, $max){
$freeplayUID = 'FFFP' . rand($min, $max);
return $freeplayUID;
}

//Render Email Notification Message

function renderUserMailMsg($sendMailInfo){
$renderMailMsg = 'Hello, '. $sendMailInfo['freeplayName'].',&#60;br&#47;&#62;&#60;br&#47;&#62;'.
'Your freeplay has been successfully registered in the Freedom Fun event.&#60;br&#47;&#62;'.
'&#60;br&#47;&#62;Your registration details:&#60;br&#47;&#62;&#60;br&#47;&#62;'.
'&#60;b&#62;User ID:&#60;&#47;b&#62; '.$sendMailInfo['freeplayUserID'].'&#60;br&#47;&#62;'.
'&#60;b&#62;Email ID:&#60;&#47;b&#62; '.$sendMailInfo['freeplayEmail'].'&#60;br&#47;&#62;';
return html_entity_decode($renderMailMsg);
}

function renderAdminMailMsg($sendMailInfo){
$renderMailMsg = 'Hello,'.
'Freeplay participant ' . $sendMailInfo['freeplayName'] . ' has successfully registered in the Freedom Fun event.&#60;br&#47;&#62;'.
'&#60;br&#47;&#62;Account details:&#60;br&#47;&#62;&#60;br&#47;&#62;'.
'&#60;b&#62;User ID:&#60;&#47;b&#62; '.$sendMailInfo['freeplayUserID'].'&#60;br&#47;&#62;'.
'&#60;b&#62;Email ID:&#60;&#47;b&#62; '.$sendMailInfo['freeplayEmail'].'&#60;br&#47;&#62;';
return html_entity_decode($renderMailMsg);
}

ob_end_flush();

?>