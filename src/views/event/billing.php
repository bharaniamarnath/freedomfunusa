<?php
include_once(__DIR__."/../../models/content_model.php");
include_once(__DIR__."/../../models/misc_model.php");
include_once(__DIR__."/../../application/sessions.php");
$contentModel = new ContentModel();
$sessions = new Sessions();
$eventParticipantFirstName = $eventParticipantLastName = $eventParticipantEmail = $eventParticipantPhoneCode = $eventParticipantPhoneCountry = $eventParticipantPhoneNumber = $eventParticipantZip = '';
$isParticipantSession = $sessions->isParticipantSession();
if($isParticipantSession){
$eventParticipantFirstName = $_SESSION['bccc_event_participant']['eventParticipantFirstName'];
$eventParticipantLastName = $_SESSION['bccc_event_participant']['eventParticipantLastName'];
$eventParticipantEmail = $_SESSION['bccc_event_participant']['eventParticipantEmail'];
$eventParticipantPhoneCode = $_SESSION['bccc_event_participant']['eventParticipantPhoneCode'];
$eventParticipantPhoneCountry = $_SESSION['bccc_event_participant']['eventParticipantPhoneCountry'];
$eventParticipantPhoneNumber = $_SESSION['bccc_event_participant']['eventParticipantPhoneNumber'];
$eventParticipantZip = $_SESSION['bccc_event_participant']['eventParticipantZip'];
}
?>

<?php include_once(__DIR__."/../templates/header.php"); ?>

<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Billing</h1>
</div>
</div>

</div>

<div class="container">

<div class="row justify-content-start">

<div class="col-xx-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">

<p class="fw-bold fs-5 text-blue text-uppercase">Please fill valid billing information in all the required fields below.</p>
<div class="alert alert-danger fw-bold text-red">The information you provide below is required for verification of your bank account/card &amp; order payment.</div>

<form name="eventBillingInfoForm" id="eventBillingInfoForm" action="event/billing" method="POST">

<div class="row">
<div class="col-12">

<div class="card shadow-sm">
<div class="card-body">

<div class="row">

<div class="form-group col-md-6 pb-3">
<label for="eventBillingFirstName" class="form-label required-field">First Name</label>
<input type="text" name="eventBillingFirstName" id="eventBillingFirstName" class="form-control" value="<?php echo $eventParticipantFirstName; ?>" required />
</div>

<div class="form-group col-md-6 pb-3">
<label for="eventBillingLastName" class="form-label required-field">Last Name</label>
<input type="text" name="eventBillingLastName" id="eventBillingLastName" class="form-control" value="<?php echo $eventParticipantLastName; ?>" required />
</div>

</div>

<div class="form-group pb-3">
<label for="eventBillingEmail" class="form-label required-field">Email</label>
<input type="email" name="eventBillingEmail" id="eventBillingEmail" class="form-control" value="<?php echo $eventParticipantEmail; ?>" required />
</div>

<div class="from-group my-0">
<label class="form-label required-field" for="eventBillingPhone">Phone</label>
</div>

<div class="input-group mb-0">
<select class="form-select" name="eventBillingPhoneCode" id="eventBillingPhoneCode" aria-label="Select Country">
<optgroup>
<option value="" selected>Select Country</option>
<?php
$miscModel = new MiscModel();
$phcodes = $miscModel->getAllPhoneCodes();
foreach($phcodes as $phcode):
if(!empty($eventParticipantPhoneCountry)):
?>
<option value="<?php echo $phcode["pc_code"].'_'.$phcode['pc_namecode']; ?>" <?php if($phcode["pc_namecode"] == $eventParticipantPhoneCountry){ echo "selected"; } else{} ?>><?php echo $phcode["pc_name"]; ?></option>
<?php
else:
?>
<option value="<?php echo $phcode["pc_code"].'_'.$phcode['pc_namecode']; ?>" <?php if($phcode["pc_namecode"] == "US"){ echo "selected"; } else{} ?>><?php echo $phcode["pc_name"]; ?></option>
<?php
endif;
endforeach;
?>
</optgroup>
</select>
<input class="form-control" size="10" type="text" name="eventBillingPhoneNumber" id="eventBillingPhoneNumber" value="<?php echo $eventParticipantPhoneNumber; ?>" required />
</div>
<label id="eventBillingPhoneError"></label>

<div class="form-group pb-3">
<label for="eventBillingZip" class="form-label required-field">Zip Code</label>
<input type="number" name="eventBillingZip" id="eventBillingZip" class="form-control" value="<?php echo $eventParticipantZip; ?>" required />
</div>

</div>
</div>
</div>
</div>

<div class="row">
<div class="col-12 mt-3">

<div class="card shadow-sm">
<div class="card-body">

<!-- Select Payment Method -->

<div class="from-group">
<label class='form-label' for='eventBillingPaymentMethod'>Payment Method</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="eventBillingPaymentMethod" id="eventBillingPaymentMethodCard" value="1">
<label class="form-check-label text-red" for="eventBillingPaymentMethodCard">Credit/Debit Card</label>
</div>

<!-- <div class="form-check">
<input class="form-check-input" type="radio" name="eventBillingPaymentMethod" id="eventBillingPaymentMethodCheck" value="2">
<label class="form-check-label text-red" for="eventBillingPaymentMethodCheck">Electronic Check</label>
</div> -->

<label id="eventBillingPaymentMethodError"></label>

</div>
</div>
</div>
</div>

<div class="row">
<div class="col-12 mt-3">

<div class="card shadow-sm">
<div class="card-body">


<div class="form-group my-3">
<?php
$capNumFirst = rand(1, 9);
$capNumSecond = rand(1, 9);
$capSum = (int) $capNumFirst + (int) $capNumSecond;
$capSumStr = strval($capSum);
?>
<label for="eventBillingReCaptcha" class="form-label required-field">Resolve</label>&nbsp;<i class="fa fa-question-circle-o text-blue" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Resolve to prove you are not a spam."></i><br/>
<small class="form-text">What is <?php echo strval($capNumFirst); ?> + <?php echo strval($capNumSecond); ?>?</small>
<input type="text" class="form-control" id="eventBillingReCaptcha" name="eventBillingReCaptcha" placeholder="Answer">
<input class="form-control" type="hidden" id="eventBillingReCaptchaVal" name="eventBillingReCaptchaVal" value="<?php echo strval($capSumStr); ?>" readonly>
</div>

<div class="form-check mt-5">
<input type="checkbox" class="form-check-input" id="eventBillingTermsCheck" name="eventBillingTermsCheck">
<label for="eventBillingTermsCheck" class="form-check-label required-field">Agree to Terms &amp; Conditions - <span><a class="text-decoration-none text-red" href="terms">Read Terms</a></span></label>&nbsp;<i class="fa fa-question-circle-o text-blue" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="You are required to agree to Freedom Fun Terms &amp; Policies"></i>
</div>
<label id="eventBillingTermsCheckError" class="mb-3"></label>

<div class="form-check">
<input type="checkbox" class="form-check-input" id="eventBillingWaiverCheck" name="eventBillingWaiverCheck">
<label for="eventBillingWaiverCheck" class="form-check-label required-field">I understand by completing this registration, I have reviewed and agreed to the waiver of liability form
&nbsp;<span><a class="text-decoration-none text-red" href="waiver"><i class="fa fa-floppy-o" aria-hidden="true"></i></a></span>
</label>
</div>
<label id="eventBillingWaiverCheckError" class="mb-3"></label>

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="eventBillingInfoSubmit" id="eventBillingInfoSubmit" class="btn btn-red btn-lg" value="Proceed" />
</div>
</form>
<div class="spinner-border text-red" role="status"></div>

</div>
</div>
</div>
</div>

</div>

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12">

<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 my-3">
<h5 class="text-red fw-bold mb-0">Billing Information</h5>
</div>
</div>

<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
<ul class="list-group shadow-sm">
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Sub Total
<span class="d-block small text-muted fw-normal">*Inclusive of all taxes</span></p>
<p class="text-red text-end fw-bold mb-0">&dollar;<?php echo number_format($_SESSION["bccc_event_order"]["eventOrdersubTotal"], 2, ".", ""); ?></p>
</li>
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Tax
<span class="d-block small text-muted fw-normal">Calculated per item and included to Sub Total.</span></p>
<p class="text-red text-end fw-bold mb-0">&dollar;<?php echo number_format($_SESSION["bccc_event_order"]["eventOrderTax"], 2, ".", ""); ?></p>
</li>
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Total</p>
<p class="fs-4 text-red text-end fw-bold mb-0">&dollar;<?php echo number_format($_SESSION["bccc_event_order"]["eventOrderTotal"], 2, ".", ""); ?></p>
</li>
</ul>
</div>

</div>

</div>

</div>
</div>

<!-- AJAX response Modal -->

<div class="modal fade" tabindex="-1" id="ajaxResponse">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header bg-white">
<h5 class="modal-title text-red fw-bold"><?php echo $aboutJSONEnc['Facilitator']['title']; ?></h5>
</div>
<div class="modal-body text-center">
<i class="fa fa-5x mb-3" aria-hidden="true"></i>
<p class="fw-bold mb-0"></p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-red" data-bs-dismiss="modal" onclick="window.location.reload();">Close</button>
</div>
</div>
</div>
</div>

<?php include_once(__DIR__."/../templates/footer.php"); ?>