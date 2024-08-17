<?php
ob_start();
include_once(__DIR__.'/../../application/sessions.php');
include_once(__DIR__.'/../../models/admin_model.php');
include_once(__DIR__.'/../../models/content_model.php');
include_once(__DIR__.'/../../models/methods_model.php');
$sessions = new Sessions();
$adminSession = $sessions->adminSession();
if(!$adminSession){
exit(header('Location: login'));
}
?>

<?php
include_once(__DIR__.'/../templates/header_admin.php');
?>

<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Settings</h1>
</div>
</div>

</div>

<div class="container">

<?php
$adminModel = new AdminModel();
$adminEmail = $_SESSION['bccc_admin']['adminLoginEmail'];
$adminInfo = $adminModel->getAdminInfo($adminEmail);
if(empty($adminInfo) && !is_array($adminInfo)):
exit(header('Location: ../login'));
endif;
?>


<!-- Dashboard Menu -->

<div class="row">

<?php
$adminModel = new AdminModel();
$contentModel = new ContentModel();
$methodsModel = new MethodsModel();
if(empty($adminInfo) || !is_array($adminInfo)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get admin information.</div>
</div>
<?php
else:
?>

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-2">

<h1 class="fs-3 fw-bold text-red">Edit Settings</h1>

<form name="adminSettingsEditForm" id="adminSettingsEditForm" action="admin/settings/edit" method="POST" enctype="multipart/form-data">

<div class="form-group pb-3">
<label for="adminEmail" class="form-label required-field">Email</label>
<input type="email" name="adminEmail" id="adminEmail" class="form-control" required />
</div>
<div class="form-group pb-3">
<label for="adminPwd" class="form-label required-field">Password</label>
<input type="password" name="adminPwd" id="adminPwd" class="form-control" required />
</div>
<div class="form-group pb-3">
<label for="adminNewPwd" class="form-label required-field">New Password</label>
<input type="password" name="adminNewPwd" id="adminNewPwd" class="form-control" required />
</div>
<div class="form-group pb-3">
<label for="adminRepeatNewPwd" class="form-label required-field">Repeat New Password</label>
<input type="password" name="adminRepeatNewPwd" id="adminRepeatNewPwd" class="form-control" required />
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
</div>
<label id="adminTermsCheckError"></label>

<input type="hidden" value="<?php echo $methodsModel->sanitizeGet($adminInfo['frt_uid']); ?>" name="adminUID" id="adminUID" />

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="adminSettingsEditSubmit" id="adminSettingsEditSubmit" class="btn btn-red btn-lg" value="Update" />
</div>
</form>
<div class="spinner-border text-red" role="status"></div>
</div>

<?php
endif;
?>

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

<?php 
include_once(__DIR__."/../templates/footer.php"); 
ob_end_flush();
?>