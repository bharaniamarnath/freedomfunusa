<?php
include_once(__DIR__ . "/../../../models/content_model.php");
include_once(__DIR__ . "/../../../models/misc_model.php");
include_once(__DIR__ . "/../../../application/sessions.php");

$sessions = new Sessions();

$isParticipantSession = $sessions->isParticipantSession();
$isCartAvailable = $sessions->isCartAvailable();

if ($isParticipantSession && $isCartAvailable) {
exit(header('Location: checkout'));
}
else {
if ($_SESSION['bccc_event_participant_info']) {
$eventPartcipantInfo = $_SESSION['bccc_event_participant_info'];
extract($eventPartcipantInfo);
}
else{
$eventParticipantFirstName = $eventParticipantLastName = $eventParticipantEmail = $eventParticipantPhoneCode = $eventParticipantPhoneCountry = $eventParticipantPhoneNumber = $eventParticipantZip = '';
}
$contentModel = new ContentModel();
} 
?>

<?php include_once(__DIR__ . "/../../templates/header.php"); ?>

<div class="container page">

<div class="row mx-auto">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
<h1 class='display-4 fw-bold text-blue text-center mb-0'>Participant</h1>
</div>
</div>

</div>

<div class="container">

<div class="row">

<div class="col-xx-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">

<p class="fw-bold fs-5 text-red">Login account</p>
<div class="alert alert-info fw-bold text-blue"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Login below if you already have an account</div>

<div class="card shadow-sm">
<div class="card-body">

<form name="participantLoginForm" id="participantLoginForm" action="event/participant/login" method="POST">
<div class="form-group pb-3">
<label class="form-label required-field">Email</label>
<input type="text" name="participantLoginEmail" id="participantLoginEmail"class="form-control" required />
</div>
<div class="form-group pb-3">
<label class="form-label required-field">Password</label>
<input type="password" name="participantLoginPwd" id="participantLoginPwd" class="form-control" required />
</div>
<div class="py-3">
<input type="submit" name="participantLoginSubmit" id="participantLoginSubmit" class="btn btn-red btn-lg" value="Login" />
</div>
</form>    


</div>

</div>
</div>

<div class="col-xx-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">

<p class="fw-bold fs-5 text-red">Register account</p>
<div class="alert alert-info fw-bold text-blue"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Register below if you do not have an account</div>

<div class="card shadow-sm">
<div class="card-body">

<form name="eventParticipantRegisterForm" id="eventParticipantRegisterForm" action="event/participant/register" method="POST">

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

<div class="form-group pb-3">
<label for="eventParticipantPassword" class="form-label required-field">Password</label>
<input type="password" name="eventParticipantPassword" id="eventParticipantPassword" class="form-control" value="<?php echo $eventParticipantEmail; ?>" required />
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
foreach ($phcodes as $phcode):
if (!empty($eventParticipantPhoneCountry)):
?>
<option value="<?php echo $phcode["pc_code"] . '_' . $phcode['pc_namecode']; ?>" <?php if ($phcode["pc_namecode"] == $eventParticipantPhoneCountry) {
                                                                    echo "selected";
                                                                } else {
                                                                } ?>><?php echo $phcode["pc_name"]; ?></option>
<?php
else:
?>
<option value="<?php echo $phcode["pc_code"] . '_' . $phcode['pc_namecode']; ?>" <?php if ($phcode["pc_namecode"] == "US") {
                                                                    echo "selected";
                                                                } else {
                                                                } ?>><?php echo $phcode["pc_name"]; ?></option>
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
<input type="submit" name="eventParticipantRegisterSubmit" id="eventParticipantRegisterSubmit" class="btn btn-red btn-lg" value="Proceed" />
</div>
</form>

</div>

</div>
</div>

</div>
</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../../templates/modal.php");  ?>

<?php include_once(__DIR__ . "/../../templates/footer.php"); ?>