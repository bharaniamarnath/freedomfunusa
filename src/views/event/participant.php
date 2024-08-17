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
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Participant</h1>
</div>
</div>

</div>

<div class="container">

<div class="row">

<div class="col-xx-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">

<p class="fw-bold fs-5 text-blue text-uppercase">Please fill valid information in all the required fields below.</p>
<div class="alert alert-danger fw-bold text-red">The information you provide below is required for verification of your event registration.</div>

<div class="card shadow-sm">
<div class="card-body">

<form name="eventParticipantInfoForm" id="eventParticipantInfoForm" action="event/participant" method="POST">

<div class="row">

<div class="form-group col-md-6 pb-3">
<label for="eventParticipantFirstName" class="form-label required-field">First Name</label>
<input type="text" name="eventParticipantFirstName" id="eventParticipantFirstName" class="form-control" value="<?php echo $eventParticipantFirstName; ?>" required />
</div>

<div class="form-group col-md-6 pb-3">
<label for="eventParticipantLastName" class="form-label required-field">Last Name</label>
<input type="text" name="eventParticipantLastName" id="eventParticipantLastName" class="form-control" value="<?php echo $eventParticipantLastName; ?>" required />
</div>

</div>

<div class="form-group pb-3">
<label for="eventParticipantEmail" class="form-label required-field">Email</label>
<input type="email" name="eventParticipantEmail" id="eventParticipantEmail" class="form-control" value="<?php echo $eventParticipantEmail; ?>" required />
</div>

<div class="from-group my-0">
<label class="form-label required-field" for="eventParticipantPhoneNumber">Phone</label>
</div>

<div class="input-group mb-0">
<select class="form-select" name="eventParticipantPhoneCode" id="eventParticipantPhoneCode" aria-label="Select Country">
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
<input class="form-control" size="10" type="text" name="eventParticipantPhoneNumber" id="eventParticipantPhoneNumber" value="<?php echo $eventParticipantPhoneNumber; ?>" required />
</div>
<label id="eventParticipantPhoneNumberError"></label>


<div class="form-group pb-3">
<label for="eventParticipantZip" class="form-label required-field">Zip Code</label>
<input type="number" name="eventParticipantZip" id="eventParticipantZip" class="form-control" value="<?php echo $eventParticipantZip; ?>" required />
</div>

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="eventParticipantInfoSubmit" id="eventParticipantInfoSubmit" class="btn btn-red btn-lg" value="Proceed" />
</div>
</form>
<div class="spinner-border text-red" role="status"></div>
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
<button type="button" class="btn btn-red" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<?php include_once(__DIR__."/../templates/footer.php"); ?>