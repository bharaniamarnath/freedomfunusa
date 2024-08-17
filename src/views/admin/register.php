<?php include_once(__DIR__."/../templates/header.php"); ?>

<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Administrator</h1>
</div>
</div>

</div>

<div class="container">
<div class="row">
<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 py-2">

<h1 class="fs-3 fw-bold text-red mb-3">Register</h1>

<div class="card shadow-sm">
<div class="card-body">

<form name="adminRegisterForm" id="adminRegisterForm" action="admin/register" method="POST" enctype="multipart/form-data">
<div class="form-group pb-3">
<label for="adminName" class="form-label required-field">Name</label>
<input type="text" name="adminName" id="adminName" class="form-control" required />
</div>
<div class="form-group pb-3">
<label for="adminEmail" class="form-label required-field">Email</label>
<input type="email" name="adminEmail" id="adminEmail" class="form-control" required />
</div>
<div class="form-group pb-3">
<label for="adminPwd" class="form-label required-field">Password</label>
<input type="password" name="adminPwd" id="adminPwd" class="form-control" required />
</div>
<div class="form-group pb-3">
<label for="adminRepeatPwd" class="form-label required-field">Repeat Password</label>
<input type="password" name="adminRepeatPwd" id="adminRepeatPwd" class="form-control" required />
</div>
<div class="form-group mt-3">
<label for="adminProfileImage" class="form-label">Profile Image</label>
<input type="file" class="form-control" name="adminProfileImage" id="adminProfileImage" accept="image/png, image/jpeg" />
<small id="adminProfileImage_help" class="form-text text-muted mb-0">Upload a PNG or JPEG format image of ratio 1:1 and minimum of 600px.</small>
</div>
<div class="form-group my-3">
<?php
$capNumFirst = rand(1, 9);
$capNumSecond = rand(1, 9);
$capSum = (int) $capNumFirst + (int) $capNumSecond;
$capSumStr = strval($capSum);
?>
<label for="adminReCaptcha" class="form-label required-field">Resolve</label>&nbsp;<i class="fa fa-question-circle-o text-blue" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Resolve to prove you are not a spam."></i><br/>
<small class="form-text">What is <?php echo strval($capNumFirst); ?> + <?php echo strval($capNumSecond); ?>?</small>
<input type="text" class="form-control" id="adminReCaptcha" name="adminReCaptcha" placeholder="Answer">
<input class="form-control" type="hidden" id="adminReCaptchaVal" name="adminReCaptchaVal" value="<?php echo strval($capSumStr); ?>" readonly>
</div>
<div class="form-check my-3">
<input type="checkbox" class="form-check-input" id="adminTermsCheck" name="adminTermsCheck">
<label for="adminTermsCheck" class="form-check-label required-field">Agree to Terms &amp; Conditions - <span><a class="text-decoration-none text-red" href="terms">Read Terms</a></span></label>&nbsp;<i class="fa fa-question-circle-o text-blue" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="You are required to agree to Freedom Fun Terms &amp; Policies"></i>
<label id="adminTermsCheckError"></label>
</div>
<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="adminRegisterSubmit" id="adminRegisterSubmit" class="btn btn-red btn-lg" value="Register" />
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
<button type="button" class="btn btn-red" data-bs-dismiss="modal" onclick="window.location.reload();">Close</button>
</div>
</div>
</div>
</div>

<?php include_once(__DIR__."/../templates/footer.php"); ?>