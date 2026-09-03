<?php
ob_start();
include_once(__DIR__.'/../../application/sessions.php');
include_once(__DIR__.'/../../models/admin_model.php');
include_once(__DIR__.'/../../models/content_model.php');
include_once(__DIR__.'/../../models/methods_model.php');
include_once(__DIR__.'/../../models/misc_model.php');
$sessions = new Sessions();
$adminSession = $sessions->adminSession();
if(!$adminSession){
exit(header('Location: login'));
}
?>

<?php
$adminModel = new AdminModel();
$adminEmail = $_SESSION['bccc_admin']['adminLoginEmail'];
$adminInfo = $adminModel->getAdminInfo($adminEmail);
if (empty($adminInfo) && !is_array($adminInfo)):
    exit(header('Location: login'));
endif;
?>

<?php
include_once(__DIR__.'/../templates/header_admin.php');
?>

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Settings</h1>
        </div>
    </div>

</div>

<div class="container">

<!-- Dashboard Menu -->

<?php
$aboutFilePath = __DIR__."/../../public/content/about.json";
$checkAboutInfoFileExists = file_exists($aboutFilePath);
if(!$checkAboutInfoFileExists):
?>
<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get admin information.</div>
</div>
</div>
<?php
else:
$contentModel = new ContentModel();
$methodsModel = new MethodsModel();
$aboutInfo = $contentModel->getAboutInfo();
?>

<div class="row">
<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 py-2">

<form name="adminAboutInfoForm" id="adminAboutInfoForm" action="admin/config/about/edit" method="POST" enctype="multipart/form-data">


<!-- Tab Menu -->

<ul class="nav nav-tabs" id="aboutInfoTabList" role="tablist">
<li class="nav-item" role="presentation">
<button class="nav-link active" id="aboutEventTab" data-bs-toggle="tab" data-bs-target="#aboutEventPane" type="button" role="tab" aria-controls="aboutEvent" aria-selected="true">Event</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="aboutOrganisationTab" data-bs-toggle="tab" data-bs-target="#aboutOrganisationPane" type="button" role="tab" aria-controls="aboutOrganisation" aria-selected="false">Organisation</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="aboutFacilitatorTab" data-bs-toggle="tab" data-bs-target="#aboutFacilitatorPane" type="button" role="tab" aria-controls="aboutFacilitator" aria-selected="false">Facilitator</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="aboutSponsorTab" data-bs-toggle="tab" data-bs-target="#aboutSponsorPane" type="button" role="tab" aria-controls="aboutSponsor" aria-selected="false">Sponsor</button>
</li>
</ul>

<div class="tab-content" id="aboutInfoTabContent">

<!-- Event Information -->

<div class="tab-pane fade show active" id="aboutEventPane" role="tabpanel" aria-labelledby="aboutEventTab">


<h1 class="fs-3 fw-bold text-red my-3">Event Information</h1>

<div class="card shadow-sm p-3">
<div class="card-body">

<div class="form-group pb-3">
<label for="aboutInfoEventYear" class="form-label required-field">Event Year</label>
<input type="number" name="aboutInfoEventYear" id="aboutInfoEventYear" class="form-control" value="<?php echo $aboutInfo['EventYear']; ?>" required />
</div>

<div class="form-group pb-3">
<label for="aboutInfoEventVenue" class="form-label required-field">Event Venue</label>
<input type="text" name="aboutInfoEventVenue" id="aboutInfoEventVenue" class="form-control" value="<?php echo $aboutInfo['EventVenue']; ?>" required />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoEventDates">Event Dates</label>
<input type='text' class='form-control' id='aboutInfoEventDates' name='aboutInfoEventDates' value='<?php echo implode(",", $aboutInfo['EventDate']); ?>' placeholder='Event Dates' />
</div>
<div id="aboutInfoDatesHelp" class="form-text">Use commas to separate dates</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoEventTime">Event Time</label>
<input type='text' class='form-control' id='aboutInfoEventTime' name='aboutInfoEventTime' value='<?php echo implode(",", $aboutInfo['EventTime']); ?>' placeholder='Event Time' />
</div>
<div id="aboutInfoEventTime" class="form-text">Use commas to separate times</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoEventEmail">Event Email</label>
<input type='text' class='form-control' id='aboutInfoEventEmail' name='aboutInfoEventEmail' value='<?php echo implode(",", $aboutInfo['EventEmail']); ?>' placeholder='Event Email' />
</div>
<div id="aboutInfoEventEmail" class="form-text">Use commas to separate emails</div>


<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoEventTags">Event Tags</label>
<input type='text' class='form-control' id='aboutInfoEventTags' name='aboutInfoEventTags' value='<?php echo implode(",", $aboutInfo['EventTags']); ?>' placeholder='Event Tags' />
</div>
<div id="aboutInfoEventTags" class="form-text">Use commas to separate tags</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoEventCopyrights">Event Copyright Text</label>
<input type='text' class='form-control' id='aboutInfoEventCopyrights' name='aboutInfoEventCopyrights' value='<?php echo $aboutInfo['EventCopyrights']; ?>' placeholder='Event Tags' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoEventSiteTitle">Site Title</label>
<input type='text' class='form-control' id='aboutInfoEventSiteTitle' name='aboutInfoEventSiteTitle' value='<?php echo $aboutInfo['EventSiteTitle']; ?>' placeholder='Event Tags' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoEventSiteDesc">Site Description</label>
<input type='text' class='form-control' id='aboutInfoEventSiteDesc' name='aboutInfoEventSiteDesc' value='<?php echo $aboutInfo['EventSiteDescription']; ?>' placeholder='Event Tags' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoEventKeywords">Event Keywords</label>
<input type='text' class='form-control' id='aboutInfoEventKeywords' name='aboutInfoEventKeywords' value='<?php echo $aboutInfo['EventSiteKeywords']; ?>' placeholder='Event Tags' />
</div>
<div id="aboutInfoEventKeywords" class="form-text">Use commas to separate keywprds</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoEventEmailEventDate">Email Date Text</label>
<input type='text' class='form-control' id='aboutInfoEventEmailEventDate' name='aboutInfoEventEmailEventDate' value='<?php echo $aboutInfo['EmailEventDate']; ?>' placeholder='Email Date Text' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoEventEmailEventTime">Email Time Text</label>
<input type='text' class='form-control' id='aboutInfoEventEmailEventTime' name='aboutInfoEventEmailEventTime' value='<?php echo $aboutInfo['EmailEventTime']; ?>' placeholder='Email Time Text' />
</div>

<div class="form-group pb-3">
<label for="aboutInfoEventHeading" class="form-label required-field">Event Heading</label>
<input type="text" name="aboutInfoEventHeading" id="aboutInfoEventHeading" class="form-control" value="<?php echo $aboutInfo['EventHeading']; ?>" placeholder='Event Heading' required />
</div>

<div class="form-group pb-3">
<label for="aboutInfoEventTagline" class="form-label required-field">Event Tagline</label>
<input type="text" name="aboutInfoEventTagline" id="aboutInfoEventTagline" class="form-control" value="<?php echo $aboutInfo['EventTagline']; ?>" placeholder='Event Tagline' required />
</div>

<div class="form-group pb-3">
<label for="aboutInfoEventVerbiage" class="form-label required-field">Event Verbiage</label>
<input type="text" name="aboutInfoEventVerbiage" id="aboutInfoEventVerbiage" class="form-control" value="<?php echo $aboutInfo['EventVerbiage']; ?>" placeholder='Event Verbiage' required />
</div>

</div>
</div>

</div>


<!-- Organisation Information -->


<div class="tab-pane fade" id="aboutOrganisationPane" role="tabpanel" aria-labelledby="aboutOrganisationTab">

<h1 class="fs-3 fw-bold text-red my-3">Organisation</h1>

<div class="card shadow-sm p-3">
<div class="card-body">

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoOrganisationTitle">Title</label>
<input type='text' class='form-control' id='aboutInfoOrganisationTitle' name='aboutInfoOrganisationTitle' value='<?php echo $aboutInfo['Organisation']['title']; ?>' placeholder='Organisation Title' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoOrganisationPhone">Phone</label>
<input type='text' class='form-control' id='aboutInfoOrganisationPhone' name='aboutInfoOrganisationPhone' value='<?php echo $aboutInfo['Organisation']['phone']; ?>' placeholder='Organisation Phone Number' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoOrganisationEmail">Email</label>
<input type='text' class='form-control' id='aboutInfoOrganisationEmail' name='aboutInfoOrganisationEmail' value='<?php echo $aboutInfo['Organisation']['email']; ?>' placeholder='Organisation Email' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoOrganisationWebsite">Website</label>
<input type='text' class='form-control' id='aboutInfoOrganisationWebsite' name='aboutInfoOrganisationWebsite' value='<?php echo $aboutInfo['Organisation']['website']; ?>' placeholder='Organisation Website' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoOrganisationWebsiteText">Website Text</label>
<input type='text' class='form-control' id='aboutInfoOrganisationWebsiteText' name='aboutInfoOrganisationWebsiteText' value='<?php echo $aboutInfo['Organisation']['websiteText']; ?>' placeholder='Organisation Website Text' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoOrganisationCopyrights">Copyright Text</label>
<textarea class='form-control' id='aboutInfoOrganisationCopyrights' name='aboutInfoOrganisationCopyrights'><?php echo $aboutInfo['Organisation']['copyrights']; ?></textarea>
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoOrganisationFacebook">Facebook</label>
<input type='text' class='form-control' id='aboutInfoOrganisationFacebook' name='aboutInfoOrganisationFacebook' value='<?php echo $aboutInfo['Organisation']['socialmedia']['facebook']; ?>' placeholder='Organisation Facebook' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoOrganisationTwitter">Twitter</label>
<input type='text' class='form-control' id='aboutInfoOrganisationTwitter' name='aboutInfoOrganisationTwitter' value='<?php echo $aboutInfo['Organisation']['socialmedia']['twitter']; ?>' placeholder='Organisation Twitter' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoOrganisationInstagram">Instagram</label>
<input type='text' class='form-control' id='aboutInfoOrganisationInstagram' name='aboutInfoOrganisationInstagram' value='<?php echo $aboutInfo['Organisation']['socialmedia']['instagram']; ?>' placeholder='Organisation Instagram' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoOrganisationYoutube">Youtube</label>
<input type='text' class='form-control' id='aboutInfoOrganisationYoutube' name='aboutInfoOrganisationYoutube' value='<?php echo $aboutInfo['Organisation']['socialmedia']['youtube']; ?>' placeholder='Organisation Youtube' />
</div>

</div>
</div>

</div>


<!-- Facilitator Information -->


<div class="tab-pane fade" id="aboutFacilitatorPane" role="tabpanel" aria-labelledby="aboutFacilitatorTab">

<h1 class="fs-3 fw-bold text-red my-3">Facilitator</h1>


<div class="card shadow-sm p-3">
<div class="card-body">

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoFacilitatorTitle">Title</label>
<input type='text' class='form-control' id='aboutInfoFacilitatorTitle' name='aboutInfoFacilitatorTitle' value='<?php echo $aboutInfo['Facilitator']['title']; ?>' placeholder='Event Facilitator Title' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoFacilitatorWebsite">Website</label>
<input type='text' class='form-control' id='aboutInfoFacilitatorWebsite' name='aboutInfoFacilitatorWebsite' value='<?php echo $aboutInfo['Facilitator']['website']; ?>' placeholder='Event Facilitator Website' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoFacilitatorWebsiteText">Website Text</label>
<input type='text' class='form-control' id='aboutInfoFacilitatorWebsiteText' name='aboutInfoFacilitatorWebsiteText' value='<?php echo $aboutInfo['Facilitator']['websiteText']; ?>' placeholder='Event Facilitator Website Text' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoFacilitatorCopyrights">Copyright Text</label>
<textarea class='form-control' id='aboutInfoFacilitatorCopyrights' name='aboutInfoFacilitatorCopyrights'><?php echo $aboutInfo['Facilitator']['copyrights']; ?></textarea>
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoFacilitatorFacebook">Facebook</label>
<input type='text' class='form-control' id='aboutInfoFacilitatorFacebook' name='aboutInfoFacilitatorFacebook' value='<?php echo $aboutInfo['Facilitator']['socialmedia']['facebook']; ?>' placeholder='Event Facilitator Facebook' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoFacilitatorTwitter">Twitter</label>
<input type='text' class='form-control' id='aboutInfoFacilitatorTwitter' name='aboutInfoFacilitatorTwitter' value='<?php echo $aboutInfo['Facilitator']['socialmedia']['twitter']; ?>' placeholder='Event Facilitator Twitter' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoFacilitatorInstagram">Instagram</label>
<input type='text' class='form-control' id='aboutInfoFacilitatorInstagram' name='aboutInfoFacilitatorInstagram' value='<?php echo $aboutInfo['Facilitator']['socialmedia']['instagram']; ?>' placeholder='Event Facilitator Instagram' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoFacilitatorYoutube">Youtube</label>
<input type='text' class='form-control' id='aboutInfoFacilitatorYoutube' name='aboutInfoFacilitatorYoutube' value='<?php echo $aboutInfo['Facilitator']['socialmedia']['youtube']; ?>' placeholder='Event Facilitator Youtube' />
</div>


</div>
</div>

</div>


<div class="tab-pane fade" id="aboutSponsorPane" role="tabpanel" aria-labelledby="aboutSponsorTab">

<h1 class="fs-3 fw-bold text-red my-3">Sponsor</h1>

<div class="card shadow-sm p-3">
<div class="card-body">

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoSponsorTitle">Title</label>
<input type='text' class='form-control' id='aboutInfoSponsorTitle' name='aboutInfoSponsorTitle' value='<?php echo $aboutInfo['Sponsor']['title']; ?>' placeholder='Event Sponsor Title' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoSponsorPhone">Phone</label>
<input type='text' class='form-control' id='aboutInfoSponsorPhone' name='aboutInfoSponsorPhone' value='<?php echo $aboutInfo['Sponsor']['phone']; ?>' placeholder='Event Sponsor Phone Number' />
</div>


<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoSponsorEmail">Email</label>
<input type='text' class='form-control' id='aboutInfoSponsorEmail' name='aboutInfoSponsorEmail' value='<?php echo $aboutInfo['Sponsor']['email']; ?>' placeholder='Event Sponsor Email' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoSponsorWebsite">Website</label>
<input type='text' class='form-control' id='aboutInfoSponsorWebsite' name='aboutInfoSponsorWebsite' value='<?php echo $aboutInfo['Sponsor']['website']; ?>' placeholder='Event Sponsor Website' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoSponsorWebsiteText">Website Text</label>
<input type='text' class='form-control' id='aboutInfoSponsorWebsiteText' name='aboutInfoSponsorWebsiteText' value='<?php echo $aboutInfo['Sponsor']['websiteText']; ?>' placeholder='Event Sponsor Website Text' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoSponsorCopyrights">Copyright Text</label>
<textarea class='form-control' id='aboutInfoSponsorCopyrights' name='aboutInfoSponsorCopyrights'><?php echo $aboutInfo['Sponsor']['copyrights']; ?></textarea>
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoSponsorFacebook">Facebook</label>
<input type='text' class='form-control' id='aboutInfoSponsorFacebook' name='aboutInfoSponsorFacebook' value='<?php echo $aboutInfo['Sponsor']['socialmedia']['facebook']; ?>' placeholder='Event Sponsor Facebook' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoSponsorTwitter">Twitter</label>
<input type='text' class='form-control' id='aboutInfoSponsorTwitter' name='aboutInfoSponsorTwitter' value='<?php echo $aboutInfo['Sponsor']['socialmedia']['twitter']; ?>' placeholder='Event Sponsor Twitter' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoSponsorInstagram">Instagram</label>
<input type='text' class='form-control' id='aboutInfoSponsorInstagram' name='aboutInfoSponsorInstagram' value='<?php echo $aboutInfo['Sponsor']['socialmedia']['instagram']; ?>' placeholder='Event Sponsor Instagram' />
</div>

<div class='form-group mb-3'>
<label class="form-label" for="aboutInfoSponsorYoutube">Youtube</label>
<input type='text' class='form-control' id='aboutInfoSponsorYoutube' name='aboutInfoSponsorYoutube' value='<?php echo $aboutInfo['Sponsor']['socialmedia']['youtube']; ?>' placeholder='Event Sponsor Youtube' />
</div>

</div>
</div>

</div>

</div>

<!-- Submit Form -->

<div class="card shadow-sm p-3 mt-3">
<div class="card-body">

<div class="form-group my-3">
<?php
$capNumFirst = rand(1, 9);
$capNumSecond = rand(1, 9);
$capSum = (int) $capNumFirst + (int) $capNumSecond;
$capSumStr = strval($capSum);
?>
<label for="aboutInfoReCaptcha" class="form-label required-field">Resolve</label>&nbsp;<i class="fa fa-question-circle-o text-blue" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Resolve to prove you are not a spam."></i><br/>
<small class="form-text">What is <?php echo strval($capNumFirst); ?> + <?php echo strval($capNumSecond); ?>?</small>
<input type="text" class="form-control" id="aboutInfoReCaptcha" name="aboutInfoReCaptcha" placeholder="Answer">
<input class="form-control" type="hidden" id="aboutInfoReCaptchaVal" name="aboutInfoReCaptchaVal" value="<?php echo strval($capSumStr); ?>" readonly>
</div>

<input type="hidden" value="<?php echo $methodsModel->sanitizeGet($adminInfo['frt_uid']); ?>" name="adminUID" id="adminUID" />

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="adminAboutInfoSubmit" id="adminAboutInfoSubmit" class="btn btn-red btn-lg" value="Update" />
</div>

</div>
</div>

</form>

</div>
</div>


<?php
endif;
?>

<!-- Constants -->

<?php
$miscModel = new MiscModel();
$methodsModel = new MethodsModel();
$taxRateValue = $miscModel->getConstantInfo('tax_rate');
$adminEmaileValue = $miscModel->getConstantInfo('admin_email');
$baseURLValue = $miscModel->getConstantInfo('base_url');
?>

<div class="row">
<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 py-2">

<h1 class="fs-3 fw-bold text-red my-3">Constants</h1>

<form name="adminConstantInfoForm" id="adminConstantInfoForm" action="admin/config/constant/edit" method="POST">


<div class="card shadow-sm p-3">
<div class="card-body">

<div class="form-group pb-3">
<label for="constantInfoTaxRate" class="form-label required-field">Tax Rate</label>
<input type="number" name="constantInfoTaxRate" id="constantInfoTaxRate" class="form-control" value="<?php echo number_format($taxRateValue['ffc_value'], 3, '.', ','); ?>" step=".001" required />
</div>

<div class="form-group pb-3">
<label for="constantInfoAdminEmail" class="form-label required-field">Admin Email</label>
<input type="text" name="constantInfoAdminEmail" id="constantInfoAdminEmail" class="form-control" value="<?php echo $adminEmaileValue['ffc_value']; ?>" required />
</div>

<div class="form-group pb-3">
<label for="constantInfoBaseURL" class="form-label required-field">Base URL</label>
<input type="url" name="constantInfoBaseURL" id="constantInfoBaseURL" class="form-control" value="<?php echo $baseURLValue['ffc_value']; ?>" required />
</div>

<!-- Submit Form -->
 

<div class="form-group my-3">
<?php
$capNumFirst = rand(1, 9);
$capNumSecond = rand(1, 9);
$capSum = (int) $capNumFirst + (int) $capNumSecond;
$capSumStr = strval($capSum);
?>
<label for="constantInfoReCaptcha" class="form-label required-field">Resolve</label>&nbsp;<i class="fa fa-question-circle-o text-blue" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Resolve to prove you are not a spam."></i><br/>
<small class="form-text">What is <?php echo strval($capNumFirst); ?> + <?php echo strval($capNumSecond); ?>?</small>
<input type="text" class="form-control" id="constantInfoReCaptcha" name="constantInfoReCaptcha" placeholder="Answer">
<input class="form-control" type="hidden" id="constantInfoReCaptchaVal" name="constantInfoReCaptchaVal" value="<?php echo strval($capSumStr); ?>" readonly>
</div>

<input type="hidden" value="<?php echo $methodsModel->sanitizeGet($adminInfo['frt_uid']); ?>" name="adminUID" id="adminUID" />

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="adminConstantInfoSubmit" id="adminConstantInfoSubmit" class="btn btn-red btn-lg" value="Update" />
</div>

</form>

</div>
</div>

</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../templates/modal.php");  ?>

<?php 
include_once(__DIR__."/../templates/footer.php"); 
ob_end_flush();
?>