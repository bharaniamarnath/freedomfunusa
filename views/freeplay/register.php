<?php
include_once(__DIR__."/../../models/content_model.php");
include_once(__DIR__."/../../models/misc_model.php");
$contentModel = new ContentModel();
?>

<?php include_once(__DIR__."/../templates/header.php"); ?>

<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Freeplay</h1>
</div>
</div>

</div>

<div class="container">
<div class="row">

<div class="col-xx-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">

<div class="card shadow-sm">
<div class="card-body">

<form name="freeplayRegisterForm" id="freeplayRegisterForm" action="freeplay/register" method="POST">

<div class="form-group pb-3">
<label for="freeplayName" class="form-label required-field">Name</label>
<input type="text" name="freeplayName" id="freeplayName" class="form-control" required />
</div>

<div class="form-group pb-3">
<label for="freeplayEmail" class="form-label required-field">Email</label>
<input type="email" name="freeplayEmail" id="freeplayEmail" class="form-control" required />
</div>

<div class="from-group my-0">
<label class="form-label required-field" for="freeplayPhone">Phone</label>
</div>

<div class="input-group mb-0">
<select class="form-select" name="freeplayPhoneCode" id="freeplayPhoneCode" aria-label="Select Country">
<optgroup>
<option value="" selected>Select Country</option>
<?php
$miscModel = new MiscModel();
$phcodes = $miscModel->getAllPhoneCodes();
foreach($phcodes as $phcode):
?>
<option value="<?php echo $phcode["pc_code"]; ?>" <?php if($phcode["pc_namecode"] == "US"){ echo "selected"; } else{} ?>><?php echo $phcode["pc_name"]; ?></option>
<?php
endforeach;
?>
</optgroup>
</select>
<input class="form-control" size="10" type="text" name="freeplayPhoneNumber" id="freeplayPhoneNumber" />
</div>
<label id="freeplayPhoneError"></label>

<div class='form-group my-3'>
<label class='form-label' for='freeplayDOB'>Date of Birth</label>
<input class='form-control' type="text" name="freeplayDOB" id="freeplayDOB" required>
</div>

<div class="form-group pb-3">
<label for="freeplayGuardianName" class="form-label required-field">Guardian's Name</label>
<input type="text" name="freeplayGuardianName" id="freeplayGuardianName" class="form-control" required />
</div>

<div class="form-group pb-3">
<label for="freeplayAddress" class="form-label required-field">Address</label>
<textarea name="freeplayAddress" id="freeplayAddress" class="form-control" row="3" required></textarea>
</div>

<div class="form-group pb-3">
<label for="freeplayZip" class="form-label required-field">Zip Code</label>
<input type="number" name="freeplayZip" id="freeplayZip" class="form-control" required />
</div>

<div class="form-group my-3">
<?php
$capNumFirst = rand(1, 9);
$capNumSecond = rand(1, 9);
$capSum = (int) $capNumFirst + (int) $capNumSecond;
$capSumStr = strval($capSum);
?>
<label for="freeplayReCaptcha" class="form-label required-field">Resolve</label>&nbsp;<i class="fa fa-question-circle-o text-blue" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Resolve to prove you are not a spam."></i><br/>
<small class="form-text">What is <?php echo strval($capNumFirst); ?> + <?php echo strval($capNumSecond); ?>?</small>
<input type="text" class="form-control" id="freeplayReCaptcha" name="freeplayReCaptcha" placeholder="Answer">
<input class="form-control" type="hidden" id="freeplayReCaptchaVal" name="freeplayReCaptchaVal" value="<?php echo strval($capSumStr); ?>" readonly>
</div>
<div class="form-check mt-5">
<input type="checkbox" class="form-check-input" id="freeplayTermsCheck" name="freeplayTermsCheck">
<label for="freeplayTermsCheck" class="form-check-label required-field">Agree to Terms &amp; Conditions - <span><a class="text-decoration-none text-red" href="terms">Read Terms</a></span></label>&nbsp;<i class="fa fa-question-circle-o text-blue" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="You are required to agree to Freedom Fun Terms &amp; Policies"></i>
</div>
<label id="freeplayTermsCheckError"></label>

<div class='form-check mb-3'>
<input type='checkbox' class='form-check-input' id='freeplayWaiverCheck' name='freeplayWaiverCheck' value='1'>
<label class='form-check-label' for='freeplayWaiverCheck'>I have read the Warning, Acknowledgement Risks, Assumption of Risk &amp; Responsibility, Authorization, Release of Liability &amp; Parent Consent<br/><span><a class='text-decoration-none text-red' href='freeplay/waiver'>read or download here</a></span></label>
<label id='freeplayWaiverCheckError'></label>
</div>

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="freeplayRegisterSubmit" id="freeplayRegisterSubmit" class="btn btn-red btn-lg" value="Register" />
</div>

</form>

</div>
</div>

</div>
</div>
</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../templates/modal.php");  ?>

<?php include_once(__DIR__."/../templates/footer.php"); ?>