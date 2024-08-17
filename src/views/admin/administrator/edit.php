<?php
ob_start();
include_once(__DIR__.'/../../../application/sessions.php');
include_once(__DIR__."/../../../models/admin_model.php");
include_once(__DIR__."/../../../models/methods_model.php");
include_once(__DIR__."/../../../models/misc_model.php");
$sessions = new Sessions();
$adminSession = $sessions->adminSession();
if(!$adminSession){
exit(header('Location: ../login'));
}
$adminModel = new AdminModel();
$adminEmail = $_SESSION['bccc_admin']['adminLoginEmail'];
$adminInfo = $adminModel->getAdminInfo($adminEmail);
if(empty($adminInfo) && !is_array($adminInfo)):
exit(header('Location: login'));
endif;
?>

<?php
include_once(__DIR__.'/../../templates/header_admin.php');
?>

<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Edit Administrator</h1>
</div>
</div>

</div>

<div class="container">


<!-- Dashboard Menu -->

<div class="row">

<?php if(!isset($admin_id) && $admin_id == null && $admin_id == ''): ?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get administrator ID</div>
</div>
<?php 
else:
$adminModel = new AdminModel();
$methodsModel = new MethodsModel();
$adminInfo = $adminModel->getAdminByUID($admin_id);
if(empty($adminInfo) || !is_array($adminInfo)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get administrator information.</div>
</div>
<?php
else:
?>
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<!-- Display Administrator Info -->

<?php if(is_file("public/assets/images/admin/" . $adminInfo['ffa_image'])): ?>
<img src="public/assets/images/admin/<?php echo $adminInfo['ffa_image']; ?>" class="img-fluid border" alt="<?php echo $adminInfo['ffa_name']; ?>">
<?php else: ?>
<img src="public/assets/images/misc/fr_placeholder.png" class="img-fluid" alt="<?php echo $adminInfo['ffa_name']; ?>">
<?php endif ?>

<ul class="list-group mt-3">
<li class="list-group-item">
<label class="info-label">Administrator Name</label>
<p class="text-red fs-4 fw-bold mb-0"><?php echo $adminInfo['ffa_name']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Administrator ID</label>
<p class="text-blue fs-5 fw-bold mb-0"><?php echo $adminInfo['ffa_uid']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Email</label>
<p class="text-blue fw-bold mb-0"><?php echo $adminInfo['ffa_email']; ?></p>
</li>
<li class="list-group-item">
<p class="text-muted small mb-0">Registered on <?php echo date('F jS Y, h:i A', strtotime($adminInfo['ffa_created_date'])); ?></p>
</li>
</ul>
</div>

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-2">

<h1 class="fs-3 fw-bold text-red">Edit Administrator</h1>

<label class="info-label mb-1">Account Status</label>
<?php if($adminInfo['ffa_acc_status'] == 1): ?>
<h5 class="text-blue fw-bold"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;Active</h5>
<?php elseif($adminInfo['ffa_acc_status'] == 0): ?>
<h5 class="text-red fw-bold"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Inactive&sol;Suspended</h5>
<?php else: ?>
<h5 class="text-red fw-bold"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Unknown</h5>
<?php endif; ?>
<hr class="hr">


<form name="adminAdministratorEditForm" id="adminAdministratorEditForm" action="admin/administrator/edit" method="POST">

<div class="form-group pb-0">
<label for="adminStatus" class="form-label required-field">Administrator Account Status</label>
<div class="form-check">
<input class="form-check-input" type="radio" name="adminStatus" id="adminStatusActive" value="1" <?php if($adminInfo['ffa_acc_status'] == 1): ?>checked<?php endif; ?>>
<label class="form-check-label" for="adminStatusActive">Active</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="adminStatus" id="adminStatusInactive" value="0" <?php if($adminInfo['ffa_acc_status'] == 0): ?>checked<?php endif; ?>>
<label class="form-check-label" for="adminStatusInactive">Inactive</label>
</div>
</div>
<label id="adminStatusError"></label>


<input type="hidden" value="<?php echo $methodsModel->sanitizeGet($adminInfo['ffa_uid']); ?>" name="adminUID" id="adminUID">

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="adminAdministratorEditSubmit" id="adminAdministratorEditSubmit" class="btn btn-red btn-lg" value="Update" />
</div>
</form>
<div class="spinner-border text-red" role="status"></div>
</div>

<?php
endif;
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
include_once(__DIR__."/../../templates/footer.php"); 
ob_end_flush();
?>