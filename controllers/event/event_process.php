<?php
ob_start();

include_once(__DIR__ . '/../../models/event_model.php');
include_once(__DIR__ . '/../../models/game_model.php');
include_once(__DIR__ . '/../../models/content_model.php');
include_once(__DIR__ . '/../../models/misc_model.php');
include_once(__DIR__.'/../../application/sendmail.php');

class Process{

public function __construct(){

if(
isset($_SESSION['bccc_event_payment']) && !empty($_SESSION['bccc_event_payment']) && 
isset($_SESSION['bccc_event_order']) && !empty($_SESSION['bccc_event_order']) && 
isset($_SESSION['bccc_event_billing']) && !empty($_SESSION['bccc_event_billing']) && 
isset($_SESSION['bccc_event_game']) && !empty($_SESSION['bccc_event_game']) && 
isset($_SESSION['bccc_event_participant']) && !empty($_SESSION['bccc_event_participant'])
){
if($_SESSION['bccc_event_payment']['response'] == '1'){
$this->processSuccess();
exit(header('Location: payment/success'));
}
elseif($_SESSION['bccc_event_payment']['response'] == '2'){
//$this->processFailed();
exit(header('Location: payment/failed'));
}
elseif($_SESSION['bccc_event_payment']['response'] == '3'){
//$this->processError();
exit(header('Location: payment/error'));
}
else{
//$this->processError();
exit(header('Location: payment/error'));
}
}
else{
//$this->processError();
exit(header('Location: payment/error'));
}
}

private function processSuccess(){
$eventModel = new EventModel();
$gameModel = new GameModel();
$contentModel = new ContentModel();

$registerEventOrder = $eventModel->registerEventOrder(
$_SESSION['bccc_event_order']['eventOrderID'],
$_SESSION['bccc_event_payment']['orderid'],
$_SESSION['bccc_event_payment']['transactionid'],
$_SESSION['bccc_event_order']['eventOrderDate'],
$_SESSION['bccc_event_payment']['response'],
$_SESSION['bccc_event_payment']['responsetext'],
$_SESSION['bccc_event_payment']['response_code'],
$_SESSION["bccc_event_billing"]['eventBillingPaymentMethod'],
$_SESSION['bccc_event_order']['eventOrdersubTotal'],
$_SESSION['bccc_event_order']['eventOrderTax'],
$_SESSION['bccc_event_order']['eventOrderShipping'],
$_SESSION['bccc_event_order']['eventOrderTotal'],
$_SESSION['bccc_event_order']['eventOrderParticipantIP']
);

$registerEventParticipant = $eventModel->registerEventParticipant(
$_SESSION['bccc_event_participant']['eventParticipantID'],
$_SESSION['bccc_event_order']['eventOrderID'],
$_SESSION['bccc_event_participant']['eventParticipantFirstName'],
$_SESSION['bccc_event_participant']['eventParticipantLastName'], 
$_SESSION['bccc_event_participant']['eventParticipantEmail'], 
$_SESSION['bccc_event_participant']['eventParticipantPhoneCode'] . $_SESSION['bccc_event_participant']['eventParticipantPhoneNumber'], 
$_SESSION['bccc_event_participant']['eventParticipantZip']
);

$sendMailInfo = array(
"eventParticipantID" => $_SESSION['bccc_event_participant']['eventParticipantID'], 
"eventOrderID" => $_SESSION['bccc_event_order']['eventOrderID'], 
"eventParticipantName" => $_SESSION['bccc_event_participant']['eventParticipantFirstName'] . ' ' . $_SESSION['bccc_event_participant']['eventParticipantLastName'], 
"eventParticipantEmail" => $_SESSION['bccc_event_participant']['eventParticipantEmail'],
);

$sendMailOrderInfo = array(
"eventTransactionID" => $_SESSION['bccc_event_payment']['transactionid'],
"eventOrderDate" => $_SESSION['bccc_event_order']['eventOrderDate'],
"eventPaymentStatus" => $contentModel->paymentStatusMessage($_SESSION['bccc_event_payment']['response']),
"eventResponseText" => $_SESSION['bccc_event_payment']['responsetext'],
"eventResponseMessage" => $contentModel->paymentResponseMessage($_SESSION['bccc_event_payment']['response_code']),
"eventPaymentMethod" => $contentModel->paymentMethodType($_SESSION["bccc_event_billing"]['eventBillingPaymentMethod']),
"eventSubTotal" => $_SESSION['bccc_event_order']['eventOrdersubTotal'],
"eventTax" => $_SESSION['bccc_event_order']['eventOrderTax'],
"eventShipping" => $_SESSION['bccc_event_order']['eventOrderShipping'],
"eventTotal" => $_SESSION['bccc_event_order']['eventOrderTotal'],
);

$sendMailEventsInfo = array();

$totalEventParticipantGames = $this->totalEventParticipantGames($_SESSION['bccc_event_game']);
$eventParticipantGamesTicketID = $this->eventParticipantGamesTicketID($totalEventParticipantGames);

$totalParticpantGamesCount = 0;

foreach($_SESSION['bccc_event_game'] as $event_game){

for($i = 0; $i < $event_game['eventGameSlots']; $i++){

$participantGameTicketID = 'FFPG' . $eventParticipantGamesTicketID[$totalParticpantGamesCount];

$registerEventParticipantGame = $eventModel->registerEventParticipantGame(
$participantGameTicketID,
$event_game['eventGameUID'],
$_SESSION['bccc_event_order']['eventOrderID'],
$event_game['eventGameType'],
$event_game['eventGamePrice']
);

$updateEventGameSlots = $eventModel->updateEventGameSlots($event_game['eventGameUID'], 0);


$totalParticpantGamesCount += 1;

}

$eventGameEmailInfo = $eventModel->getEventGameByUID($event_game['eventGameUID']);
$gameEmailInfo = $gameModel->getGameByUID($eventGameEmailInfo['ffeg_game_uid']);
$gameEmailPrice = $event_game['eventGameSlots'] * $event_game['eventGamePrice'];

$sendMailEventInfo = array(
"eventGameUID" => $gameEmailInfo['ffg_name'],
"eventOrderID" => $_SESSION['bccc_event_order']['eventOrderID'],
"eventGameType" => $event_game['eventGameType'],
"eventGameSlots" => $event_game['eventGameSlots'],
"eventGamePrice" => $gameEmailPrice
);

array_push($sendMailEventsInfo, $sendMailEventInfo);

}

$this->sendUserMailNotification($sendMailInfo, $sendMailEventsInfo, $sendMailOrderInfo);
$this->sendAdminMailNotification($sendMailInfo, $sendMailEventsInfo, $sendMailOrderInfo);

$this->sendUserTextNotification(
$_SESSION['bccc_event_participant']['eventParticipantPhoneCode'] . $_SESSION['bccc_event_participant']['eventParticipantPhoneNumber'], 
$_SESSION['bccc_event_participant']['eventParticipantFirstName'] . ' ' . $_SESSION['bccc_event_participant']['eventParticipantLastName'], 
$_SESSION['bccc_event_order']['eventOrderID']
);

}

//Total Event Participant Games

private function totalEventParticipantGames($participant_games){
$total_participant_games = 0;
foreach($participant_games as $participant_game){
for($i = 0; $i < $participant_game['eventGameSlots']; $i++){
$total_participant_games += 1;
}
}
return $total_participant_games;
}

//Generate Event Participant Games Ticket ID

private function eventParticipantGamesTicketID($totalEventParticipantGames){
$gamesTicketIDRange = range(11111, 99999);
shuffle($gamesTicketIDRange);
$gamesTicketIDRandom = array_slice($gamesTicketIDRange, 0, $totalEventParticipantGames);
return $gamesTicketIDRandom;
}


//User Mail Notification

private function sendUserMailNotification($sendMailInfo, $sendMailEventsInfo, $sendMailOrderInfo){

$sendMailEventsVars = '';

$sendMailWaiver = 1;

foreach($sendMailEventsInfo as $sendMailEventInfo){
$sendMailEventsVars .= $this->renderEventMailMsg($sendMailEventInfo);
}

$sendMailVars = array(
'sendMailMainMsg' => $this->renderUserMailMsg($sendMailInfo),
'sendMailEventsMsg' => $sendMailEventsVars,
'sendMailOrderMsg' => $this->renderOrderMailMsg($sendMailOrderInfo)
);


//Get About Information

$contentModel = new ContentModel();
$sendMailAboutVars = $contentModel->aboutJSON();

$sendMailSubject = $sendMailAboutVars['aboutJSONTitle'];
$sendMailBody = file_get_contents(__DIR__.'/../../views/email/user/event.html');

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

new sendMail($sendMailInfo['eventParticipantEmail'], $sendMailInfo['eventParticipantName'], $sendMailSubject, $sendMailBody, $sendMailWaiver);
}

//Admin Mail Notification

private function sendAdminMailNotification($sendMailInfo, $sendMailEventsInfo, $sendMailOrderInfo){

$sendMailEventsVars = '';

$sendMailWaiver = 0;

foreach($sendMailEventsInfo as $sendMailEventInfo){
$sendMailEventsVars .= $this->renderEventMailMsg($sendMailEventInfo);
}

$sendMailVars = array(
'sendMailMainMsg' => $this->renderAdminMailMsg($sendMailInfo),
'sendMailEventsMsg' => $sendMailEventsVars,
'sendMailOrderMsg' => $this->renderOrderMailMsg($sendMailOrderInfo)
);

//Get About Information

$contentModel = new ContentModel();
$sendMailAboutVars = $contentModel->aboutJSON();

$miscModel = new MiscModel();
$adminEmaileValue = $miscModel->getConstantInfo('admin_email');
$sendMailAdminEmail = $adminEmaileValue['ffc_value'];

$sendMailSubject = $sendMailAboutVars['aboutJSONTitle'];
$sendMailBody = file_get_contents(__DIR__.'/../../views/email/admin/event.html');

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

new sendMail($sendMailAdminEmail, $sendMailInfo['eventParticipantName'], $sendMailSubject, $sendMailBody, $sendMailWaiver);
}

//Send SMS Notification

private function sendUserTextNotification($smsEventParticipantPhone, $smsEventParticipantName, $smsEventID){

//About JSON Content
$contentModel = new ContentModel();
$smsMailAboutVars = $contentModel->aboutJSON();

//Set Message

$smsEventParticipantMessage = "Hi " . $smsEventParticipantName . "! Thanks for registering at Freedom Fun USA - " . $smsMailAboutVars['aboutJSONEventHeading'] . " event. Your Order ID is " . $smsEventID . ". Please check your email for more details.";
$smsEventParticipantMessage = urlencode($smsEventParticipantMessage);

//SMS Gateway Settings

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api-mapper.clicksend.com/http/v2/send.php?method=http&username=bamar@touchintl.com&key=2E96304B-EE6E-C976-A471-0072C503890E&to=$smsEventParticipantPhone&message=$smsEventParticipantMessage");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch); 
curl_close($ch); 

}


//Render Email Notification Message

private function renderUserMailMsg($sendMailInfo){

//About JSON Content
$contentModel = new ContentModel();
$renderMailAboutVars = $contentModel->aboutJSON();

$renderMailMsg = 'Hello, '.$sendMailInfo['eventParticipantName'].',&#60;br&#47;&#62;&#60;br&#47;&#62;'.
'Thank you for registering at Freedom Fun USA - ' .$renderMailAboutVars['aboutJSONEventHeading']. ' event.&#60;br&#47;&#62;'.
'&#60;br&#47;&#62;&#60;b&#62;Your event details:&#60;&#47;b&#62;&#60;br&#47;&#62;&#60;br&#47;&#62;'.
'&#60;b&#62;Order ID:&#60;&#47;b&#62; '.$sendMailInfo['eventOrderID'].'&#60;br&#47;&#62;'.
'&#60;b&#62;Email:&#60;&#47;b&#62; '.$sendMailInfo['eventParticipantEmail'].'&#60;br&#47;&#62;';
return html_entity_decode($renderMailMsg);
}

private function renderAdminMailMsg($sendMailInfo){

//About JSON Content
$contentModel = new ContentModel();
$renderMailAboutVars = $contentModel->aboutJSON();

$renderMailMsg = 'Hello,&#60;br&#47;&#62;&#60;br&#47;&#62;'.
$sendMailInfo['eventParticipantName'] . ' registered at Freedom Fun USA - ' .$renderMailAboutVars['aboutJSONEventHeading']. ' event.&#60;br&#47;&#62;'.
'&#60;br&#47;&#62;&#60;b&#62;Event details:&#60;&#47;b&#62;&#60;br&#47;&#62;&#60;br&#47;&#62;'.
'&#60;b&#62;Order ID:&#60;&#47;b&#62; '.$sendMailInfo['eventOrderID'].'&#60;br&#47;&#62;'.
'&#60;b&#62;Email:&#60;&#47;b&#62; '.$sendMailInfo['eventParticipantEmail'].'&#60;br&#47;&#62;';
return html_entity_decode($renderMailMsg);
}

private function renderEventMailMsg($sendMailEventInfo){
$rendered = '&#60;b&#62;Item:&#60;&#47;b&#62; '.$sendMailEventInfo['eventGameUID'].'&#60;br&#47;&#62;'.
$rendered = '&#60;b&#62;Quantity:&#60;&#47;b&#62; '.$sendMailEventInfo['eventGameSlots'].'&#60;br&#47;&#62;'.
'&#60;b&#62;Price:&#60;&#47;b&#62; &#36;'.number_format($sendMailEventInfo['eventGamePrice'], 2, ".", "").'&#60;br&#47;&#62;&#60;br&#47;&#62;';
return html_entity_decode($rendered);
}

private function renderOrderMailMsg($sendMailOrderInfo){
$renderMailMsg = '&#60;b&#62;Sub Total:&#60;&#47;b&#62; &#36;'.number_format($sendMailOrderInfo['eventSubTotal'], 2, ".", "").'&#60;br&#47;&#62;'.
'&#60;b&#62;Tax Rate:&#60;&#47;b&#62; &#36;'.number_format($sendMailOrderInfo['eventTax'], 2, ".", "").'&#60;br&#47;&#62;'.
'&#60;b&#62;Total Amount:&#60;&#47;b&#62; &#36;'.number_format($sendMailOrderInfo['eventTotal'], 2, ".", "").'&#60;br&#47;&#62;'.
'&#60;br&#47;&#62;'.
'&#60;b&#62;Order Date:&#60;&#47;b&#62; '.$sendMailOrderInfo['eventOrderDate'].'&#60;br&#47;&#62;'.
'&#60;b&#62;Payment Method:&#60;&#47;b&#62; '.$sendMailOrderInfo['eventPaymentMethod'].'&#60;br&#47;&#62;'.
'&#60;b&#62;Payment Status:&#60;&#47;b&#62; '.$sendMailOrderInfo['eventPaymentStatus'].'&#60;br&#47;&#62;'.
'&#60;b&#62;Transaction ID:&#60;&#47;b&#62; '.$sendMailOrderInfo['eventTransactionID'].'&#60;br&#47;&#62;'.
'&#60;br&#47;&#62;&#60;b&#62;Response:&#60;&#47;b&#62;&#60;br&#47;&#62;'.
'&#60;b&#62;Payment:&#60;&#47;b&#62; '.$sendMailOrderInfo['eventResponseText'].'&#60;br&#47;&#62;'.
'&#60;b&#62;Transaction:&#60;&#47;b&#62; '.$sendMailOrderInfo['eventResponseMessage'].'&#60;br&#47;&#62;';
return html_entity_decode($renderMailMsg);
}

}
?>