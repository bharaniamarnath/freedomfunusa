<?php

date_default_timezone_set('America/Chicago');

class ContentModel{

public function aboutJSON(){ 

$aboutJSONFile = file_get_contents(__DIR__.'/../public/content/about.json');
$aboutJSONEnc = json_decode($aboutJSONFile, true);

$aboutJSONArray = array(
'sendMailAboutTitle' => $aboutJSONEnc['EventSiteTitle'],
'sendMailAboutVenue' => $aboutJSONEnc['EventVenue'],
'sendMailAboutEventStartDate' => $aboutJSONEnc['EventDate'][0],
'sendMailAboutEventEndDate' => $aboutJSONEnc['EventDate'][1],
'sendMailAboutEventStartTime' => $aboutJSONEnc['EventTime'][0],
'sendMailAboutEventEndTime' => $aboutJSONEnc['EventTime'][1],
'sendMailAboutEventHeading' => $aboutJSONEnc['EventHeading'],
'sendMailAboutEventTagline' => $aboutJSONEnc['EventTagline'],
'sendMailAboutEventVerbiage' => $aboutJSONEnc['EventVerbiage'],
'sendMailAboutFacilitatorName' => $aboutJSONEnc['Facilitator']['title'],
'sendMailAboutFacilitatorPhone' => $aboutJSONEnc['Facilitator']['phone'],
'sendMailAboutFacilitatorEmail' => $aboutJSONEnc['Facilitator']['email'],
'sendMailAboutFacilitatorWebsite' => $aboutJSONEnc['Facilitator']['website'],
'sendMailAboutFacilitatorWebsiteText' => $aboutJSONEnc['Facilitator']['websiteText'],
'sendMailAboutFacilitatorCopyrights' => $aboutJSONEnc['Facilitator']['copyrights'],
'sendMailAboutOrgName' => $aboutJSONEnc['Organisation']['title'],
'sendMailAboutOrgPhone' => $aboutJSONEnc['Organisation']['phone'],
'sendMailAboutOrgEmail' => $aboutJSONEnc['Organisation']['email'],
'sendMailAboutOrgWebsite' => $aboutJSONEnc['Organisation']['website'],
'sendMailAboutOrgWebsiteText' => $aboutJSONEnc['Organisation']['websiteText'],
'sendMailAboutOrgCopyrights' => $aboutJSONEnc['Organisation']['copyrights'],
'sendMailAboutSponsorName' => $aboutJSONEnc['Sponsor']['title'],
'sendMailAboutSponsorPhone' => $aboutJSONEnc['Sponsor']['phone'],
'sendMailAboutSponsorEmail' => $aboutJSONEnc['Sponsor']['email'],
'sendMailAboutSponsorWebsite' => $aboutJSONEnc['Sponsor']['website'],
'sendMailAboutSponsorWebsiteText' => $aboutJSONEnc['Sponsor']['websiteText'],
'sendMailAboutSponsorCopyrights' => $aboutJSONEnc['Sponsor']['copyrights'],
'sendMailAdminEmail' => $aboutJSONEnc['EventEmail'][2]
);
return $aboutJSONArray;
}

public function adminEmail(){
$adminEmail = "bamar@tisocial.com";
return $adminEmail;
}

public function paymentResponseMessage($prCode){
$prMsg = '';
switch($prCode){
case '100':	$prMsg = 'Transaction was approved.'; break;
case '200': $prMsg = 'Transaction was declined by processor.'; break;
case '201': $prMsg = 'Do not honor.'; break;
case '202':	$prMsg = 'Insufficient funds.'; break;
case '203':	$prMsg = 'Over limit.'; break;
case '204': $prMsg = 'Transaction not allowed.'; break;
case '220': $prMsg = 'Incorrect payment information.'; break;
case '221':	$prMsg = 'No such card issuer.'; break;
case '222':	$prMsg = 'No card number on file with issuer.'; break;
case '223': $prMsg = 'Expired card.'; break;
case '224':	$prMsg = 'Invalid expiration date.'; break;
case '225':	$prMsg = 'Invalid card security code.'; break;
case '226': $prMsg = 'Invalid PIN.'; break;
case '240':	$prMsg = 'Call issuer for further information.'; break;
case '250':	$prMsg = 'Pick up card.'; break;
case '251':	$prMsg = 'Lost card.'; break;
case '252':	$prMsg = 'Stolen card.'; break;
case '253':	$prMsg = 'Fraudulent card.'; break;
case '255':	$prMsg = 'Duplicate Transaction.'; break;
case '260':	$prMsg = 'Declined with further instructions available. (View transaction response)'; break;
case '261':	$prMsg = 'Declined-Stop all recurring payments.'; break;
case '262':	$prMsg = 'Declined-Stop this recurring program.'; break;
case '263': $prMsg = 'Declined-Update cardholder data available.'; break;
case '264':	$prMsg = 'Declined-Retry in a few days.'; break;
case '300': $prMsg = 'Transaction was rejected by gateway.'; break;
case '400':	$prMsg = 'Transaction error returned by processor.'; break;
case '410':	$prMsg = 'Invalid merchant configuration.'; break;
case '411':	$prMsg = 'Merchant account is inactive.'; break;
case '420':	$prMsg = 'Communication error.'; break;
case '421':	$prMsg = 'Communication error with issuer.'; break;
case '430': $prMsg = 'Duplicate transaction at processor.'; break;
case '440':	$prMsg = 'Processor format error.'; break;
case '441':	$prMsg = 'Invalid transaction information.'; break;
case '460':	$prMsg = 'Processor feature not available.'; break;
case '461':	$prMsg = 'Unsupported card type.'; break;
default: $prMsg = 'Unknown Response'; break;
}
return $prMsg;
}

public function paymentStatusMessage($psCode){
$psMsg = '';
switch($psCode){
case '1':	$psMsg = 'SUCCESS'; break;
case '2': $psMsg = 'FAILED'; break;
case '3': $psMsg = 'ERROR'; break;
default: $psMsg = 'UNKNOWN'; break;
}
return $psMsg;
}

public function paymentMethodType($pmCode){
$pmMsg = '';
switch($pmCode){
case '1':	$pmMsg = 'Credit/Debit Card'; break;
case '2': $pmMsg = 'Direct Cash'; break;
default: $pmMsg = 'UNKNOWN'; break;
}
return $pmMsg;
}

//Get About Information
public function getAboutInfo(){
date_default_timezone_set('America/Chicago');
$about_info_data = array();
$about_info_dbfile = __DIR__.'/../public/content/about.json';
if(file_exists($about_info_dbfile)){
$about_info_data = file_get_contents($about_info_dbfile);
$about_info_data = json_decode($about_info_data, true);
}
return $about_info_data;
}

//Set About Information
public function setAboutInfo($updated){
date_default_timezone_set('America/Chicago');
$about_info_dbfile = __DIR__.'/../public/content/about.json';
if(file_exists($about_info_dbfile)){
if(file_put_contents($about_info_dbfile, $updated)){
return true;
}
else{
return false;
}
}
else{
return false;
}
}

}
?>