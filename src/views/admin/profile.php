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
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Profile</h1>
</div>
</div>

</div>

<div class="container">

<?php
$adminModel = new AdminModel();
$adminEmail = $_SESSION['bccc_admin']['adminLoginEmail'];
$adminInfo = $adminModel->getAdminInfo($adminEmail);
if(empty($adminInfo) && !is_array($adminInfo)):
exit(header('Location: login'));
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
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<!-- Display Administrator Info -->
<img src="public/assets/images/admin/<?php echo $adminInfo['ffa_image'].'?v='.uniqid(); ?>" class="img-fluid border border-1" alt="<?php echo $adminInfo['ffa_name']; ?>" />
<h2 class="text-red fw-bold mt-3"><?php echo $adminInfo['ffa_name']; ?></h2>
<label class="info-label">Administrator ID</label>
<h5 class="text-gray fw-bold mb-3"><?php echo $adminInfo['ffa_uid']; ?></h5>

<label class="info-label">Email</label>
<p class="text-blue fw-bold"><?php echo $adminInfo['ffa_email']; ?></p>

<p class="text-muted small">Registered on <?php echo date('F jS Y, h:i A', strtotime($adminInfo['ffa_created_date'])); ?></p>

</div>

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-2">

<h1 class="fs-3 fw-bold text-red">Edit Administrator</h1>

<form name="adminProfileEditForm" id="adminProfileEditForm" action="admin/profile/edit" method="POST" enctype="multipart/form-data">

<div class="form-group pb-3">
<label for="adminName" class="form-label required-field">Name</label>
<input type="text" name="adminName" id="adminName" class="form-control" value="<?php echo $methodsModel->sanitizeGet($adminInfo['ffa_name']); ?>" required />
</div>
<div class="form-group pb-3">
<label for="adminEmail" class="form-label required-field">Email</label>
<input type="email" name="adminEmail" id="adminEmail" class="form-control" value="<?php echo $methodsModel->sanitizeGet($adminInfo['ffa_email']); ?>" required />
</div>

<div class="form-group mt-3">
<label for="adminProfileImage" class="form-label">Profile Image</label>
<input type="file" class="form-control" name="adminProfileImage" id="adminProfileImage" />
<small id="adminProfileImage_help" class="form-text text-muted mb-0">Upload a PNG format image of ratio 1:1 and minimum of 600px.</small>
</div>
<div class="form-group my-3">

<input type="hidden" value="<?php echo $methodsModel->sanitizeGet($adminInfo['ffa_uid']); ?>" name="adminUID" id="adminUID" />
<input type="hidden" value="<?php echo $methodsModel->sanitizeGet($adminInfo['ffa_acc_status']); ?>" name="adminAccountStatus" id="adminAccountStatus" />

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="adminProfileEditSubmit" id="adminProfileEditSubmit" class="btn btn-red btn-lg" value="Update" />
</div>
</form>
<div class="spinner-border text-red" role="status"></div>
</div>

<?php
endif;
?>

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
include_once(__DIR__."/../templates/footer.php"); 
ob_end_flush();
?>