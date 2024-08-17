<?php
ob_start();
include_once(__DIR__.'/../../../application/sessions.php');
include_once(__DIR__.'/../../../models/admin_model.php');
include_once(__DIR__.'/../../../models/misc_model.php');
include_once(__DIR__.'/../../../models/methods_model.php');
$sessions = new Sessions();
$adminSession = $sessions->adminSession();
if(!$adminSession){
exit(header('Location: login'));
}
?>

<?php
include_once(__DIR__.'/../../templates/header_admin.php');
?>

<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Configuration</h1>
</div>
</div>

</div>

<div class="container">


<!-- Dashboard Menu -->

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
<div class="form-check my-3">
<input type="checkbox" class="form-check-input" id="constantInfoTermsCheck" name="constantInfoTermsCheck">
<label for="constantInfoTermsCheck" class="form-check-label required-field">Agree to Terms &amp; Conditions - <span><a class="text-decoration-none text-red" href="terms">Read Terms</a></span></label>&nbsp;<i class="fa fa-question-circle-o text-blue" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="You are required to agree to Freedom Fun Terms &amp; Policies"></i>
</div>
<label id="constantInfoTermsCheckError"></label>

<input type="hidden" value="<?php echo $methodsModel->sanitizeGet($adminInfo['frt_uid']); ?>" name="adminUID" id="adminUID" />

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="adminConstantInfoSubmit" id="adminConstantInfoSubmit" class="btn btn-red btn-lg" value="Update" />
</div>

<div class="spinner-border text-red" role="status"></div>

</form>

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

<?php 
include_once(__DIR__."/../../templates/footer.php"); 
ob_end_flush();
?>