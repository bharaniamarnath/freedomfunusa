<?php
ob_start();

include_once(__DIR__ . '/../../../models/content_model.php');
include_once(__DIR__ . '/../../../models/methods_model.php');

if(isset($_POST['adminAboutInfoSubmit'])){

//Event

$aboutInfoEventYear = trim(htmlentities($_POST['aboutInfoEventYear']));
$aboutInfoEventVenue = trim(htmlentities($_POST['aboutInfoEventVenue']));
$aboutInfoEventDates = trim(htmlentities($_POST['aboutInfoEventDates']));
$aboutInfoEventDates = explode(',', $aboutInfoEventDates);
$aboutInfoEventTime = trim(htmlentities($_POST['aboutInfoEventTime']));
$aboutInfoEventTime = explode(',', $aboutInfoEventTime);
$aboutInfoEventEmail = trim(htmlentities($_POST['aboutInfoEventEmail']));
$aboutInfoEventEmail = explode(',', $aboutInfoEventEmail);
$aboutInfoEventTags = trim(htmlentities($_POST['aboutInfoEventTags']));
$aboutInfoEventTags = explode(',', $aboutInfoEventTags);
$aboutInfoEventCopyrights = trim(htmlentities($_POST['aboutInfoEventCopyrights']));
$aboutInfoEventSiteTitle = trim(htmlentities($_POST['aboutInfoEventSiteTitle']));
$aboutInfoEventSiteDesc = trim(htmlentities($_POST['aboutInfoEventSiteDesc']));
$aboutInfoEventKeywords = trim(htmlentities($_POST['aboutInfoEventKeywords']));
$aboutInfoEventEmailEventDate = trim(htmlentities($_POST['aboutInfoEventEmailEventDate']));
$aboutInfoEventEmailEventTime = trim(htmlentities($_POST['aboutInfoEventEmailEventTime']));
$aboutInfoEventHeading = trim(htmlentities($_POST['aboutInfoEventHeading']));
$aboutInfoEventTagline = trim(htmlentities($_POST['aboutInfoEventTagline']));
$aboutInfoEventVerbiage = trim(htmlentities($_POST['aboutInfoEventVerbiage']));

//Organisation

$aboutInfoOrganisationTitle = trim(htmlentities($_POST['aboutInfoOrganisationTitle']));
$aboutInfoOrganisationPhone = trim(htmlentities($_POST['aboutInfoOrganisationPhone']));
$aboutInfoOrganisationEmail = trim(htmlentities($_POST['aboutInfoOrganisationEmail']));
$aboutInfoOrganisationWebsite = trim(htmlentities($_POST['aboutInfoOrganisationWebsite']));
$aboutInfoOrganisationWebsiteText = trim(htmlentities($_POST['aboutInfoOrganisationWebsiteText']));
$aboutInfoOrganisationCopyrights = trim(htmlentities($_POST['aboutInfoOrganisationCopyrights']));
$aboutInfoOrganisationFacebook = trim(htmlentities($_POST['aboutInfoOrganisationFacebook']));
$aboutInfoOrganisationInstagram = trim(htmlentities($_POST['aboutInfoOrganisationInstagram']));
$aboutInfoOrganisationYoutube = trim(htmlentities($_POST['aboutInfoOrganisationYoutube']));
$aboutInfoOrganisationTwitter = trim(htmlentities($_POST['aboutInfoOrganisationTwitter']));

//Facilitator

$aboutInfoFacilitatorTitle = trim(htmlentities($_POST['aboutInfoFacilitatorTitle']));
$aboutInfoFacilitatorWebsite = trim(htmlentities($_POST['aboutInfoFacilitatorWebsite']));
$aboutInfoFacilitatorWebsiteText = trim(htmlentities($_POST['aboutInfoFacilitatorWebsiteText']));
$aboutInfoFacilitatorCopyrights = trim(htmlentities($_POST['aboutInfoFacilitatorCopyrights']));
$aboutInfoFacilitatorFacebook = trim(htmlentities($_POST['aboutInfoFacilitatorFacebook']));
$aboutInfoFacilitatorTwitter = trim(htmlentities($_POST['aboutInfoFacilitatorTwitter']));
$aboutInfoFacilitatorInstagram = trim(htmlentities($_POST['aboutInfoFacilitatorInstagram']));
$aboutInfoFacilitatorYoutube = trim(htmlentities($_POST['aboutInfoFacilitatorYoutube']));

//Sponsor

$aboutInfoSponsorTitle = trim(htmlentities($_POST['aboutInfoSponsorTitle']));
$aboutInfoSponsorPhone = trim(htmlentities($_POST['aboutInfoSponsorPhone']));
$aboutInfoSponsorEmail = trim(htmlentities($_POST['aboutInfoSponsorEmail']));
$aboutInfoSponsorWebsite = trim(htmlentities($_POST['aboutInfoSponsorWebsite']));
$aboutInfoSponsorWebsiteText = trim(htmlentities($_POST['aboutInfoSponsorWebsiteText']));
$aboutInfoSponsorCopyrights = trim(htmlentities($_POST['aboutInfoSponsorCopyrights']));
$aboutInfoSponsorFacebook = trim(htmlentities($_POST['aboutInfoSponsorFacebook']));
$aboutInfoSponsorTwitter = trim(htmlentities($_POST['aboutInfoSponsorTwitter']));
$aboutInfoSponsorInstagram = trim(htmlentities($_POST['aboutInfoSponsorInstagram']));
$aboutInfoSponsorYoutube = trim(htmlentities($_POST['aboutInfoSponsorYoutube']));


if(
//Event
$aboutInfoEventYear == '' && $aboutInfoEventVenue == '' && $aboutInfoEventDates == '' && $aboutInfoEventTime == '' && 
$aboutInfoEventEmail == '' && $aboutInfoEventTags == '' && $aboutInfoEventCopyrights == '' && $aboutInfoEventSiteTitle == '' &&
$aboutInfoEventSiteDesc == '' && $aboutInfoEventKeywords == '' && $aboutInfoEventEmailEventDate == '' && $aboutInfoEventEmailEventTime == '' &&
$aboutInfoEventHeading == '' && $aboutInfoEventTagline == '' && $aboutInfoEventVerbiage = ''
//Organisation
){
$res = array("err" => 1, "msg" => "No input found in one or more required fields");
echo json_encode($res);
}
else{
try{
$aboutFilePath = __DIR__."/../../../public/content/about.json";
$checkAboutInfoFileExists = file_exists($aboutFilePath);
if(!$checkAboutInfoFileExists){
$res = array("err" => 1, "msg" => "Update failed. About information records not found.");
echo json_encode($res);
}
else{
$contentModel = new ContentModel();
$aboutInfo = $contentModel->getAboutInfo();

//Event

$aboutInfo['EventYear'] = $aboutInfoEventYear;
$aboutInfo['EventVenue'] = $aboutInfoEventVenue;
$aboutInfo['EventDate'] = $aboutInfoEventDates;
$aboutInfo['EventTime'] = $aboutInfoEventTime;
$aboutInfo['EventEmail'] = $aboutInfoEventEmail;
$aboutInfo['EventTags'] = $aboutInfoEventTags;
$aboutInfo['EventCopyrights'] = $aboutInfoEventCopyrights;
$aboutInfo['EventSiteTitle'] = $aboutInfoEventSiteTitle;
$aboutInfo['EventSiteDescription'] = $aboutInfoEventSiteDesc;
$aboutInfo['EventSiteKeywords'] = $aboutInfoEventKeywords;
$aboutInfo['EmailEventDate'] = $aboutInfoEventEmailEventDate;
$aboutInfo['EmailEventTime'] = $aboutInfoEventEmailEventTime;
$aboutInfo['EventHeading'] = $aboutInfoEventHeading;
$aboutInfo['EventTagline'] = $aboutInfoEventTagline;
$aboutInfo['EventVerbiage'] = $aboutInfoEventVerbiage;

//Organisation

$aboutInfo['Organisation']['title'] = $aboutInfoOrganisationTitle;
$aboutInfo['Organisation']['phone'] = $aboutInfoOrganisationPhone;
$aboutInfo['Organisation']['email'] = $aboutInfoOrganisationEmail;
$aboutInfo['Organisation']['website'] = $aboutInfoOrganisationWebsite;
$aboutInfo['Organisation']['websiteText'] = $aboutInfoOrganisationWebsiteText;
$aboutInfo['Organisation']['copyrights'] = $aboutInfoOrganisationCopyrights;
$aboutInfo['Organisation']['socialmedia']['facebook'] = $aboutInfoOrganisationFacebook;
$aboutInfo['Organisation']['socialmedia']['twitter'] = $aboutInfoOrganisationTwitter;
$aboutInfo['Organisation']['socialmedia']['instagram'] = $aboutInfoOrganisationInstagram;
$aboutInfo['Organisation']['socialmedia']['youtube'] = $aboutInfoOrganisationYoutube;

//Facilitator

$aboutInfo['Facilitator']['title'] = $aboutInfoFacilitatorTitle;
$aboutInfo['Facilitator']['website'] = $aboutInfoFacilitatorWebsite;
$aboutInfo['Facilitator']['websiteText'] = $aboutInfoFacilitatorWebsiteText;
$aboutInfo['Facilitator']['copyrights'] = $aboutInfoFacilitatorCopyrights;
$aboutInfo['Facilitator']['socialmedia']['facebook'] = $aboutInfoFacilitatorFacebook;
$aboutInfo['Facilitator']['socialmedia']['twitter'] = $aboutInfoFacilitatorTwitter;
$aboutInfo['Facilitator']['socialmedia']['instagram'] = $aboutInfoFacilitatorInstagram;
$aboutInfo['Facilitator']['socialmedia']['youtube'] = $aboutInfoFacilitatorYoutube;

//Sponsor

$aboutInfo['Sponsor']['title'] = $aboutInfoSponsorTitle;
$aboutInfo['Sponsor']['phone'] = $aboutInfoSponsorPhone;
$aboutInfo['Sponsor']['website'] = $aboutInfoSponsorWebsite;
$aboutInfo['Sponsor']['websiteText'] = $aboutInfoSponsorWebsiteText;
$aboutInfo['Sponsor']['email'] = $aboutInfoSponsorEmail;
$aboutInfo['Sponsor']['copyrights'] = $aboutInfoSponsorCopyrights;
$aboutInfo['Sponsor']['socialmedia']['facebook'] = $aboutInfoSponsorFacebook;
$aboutInfo['Sponsor']['socialmedia']['twitter'] = $aboutInfoSponsorTwitter;
$aboutInfo['Sponsor']['socialmedia']['instagram'] = $aboutInfoSponsorInstagram;
$aboutInfo['Sponsor']['socialmedia']['youtube'] = $aboutInfoSponsorYoutube;

if(empty($aboutInfo)){
$res = array("err" => 1, "msg" => "Error occured. Unable to process about information.");
echo json_encode($res);
}
else{
$aboutInfoEncode = json_encode($aboutInfo, JSON_PRETTY_PRINT);
$updateAboutInfo = $contentModel->setAboutInfo($aboutInfoEncode);
if($updateAboutInfo){
$res = array("err" => 0, "msg" => "About information updated successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to update about information.");
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


ob_end_flush();

?>