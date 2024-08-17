<?php include_once(__DIR__.'/../templates/header.php'); ?>

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

<h1 class="fs-3 fw-bold text-red mb-3">Login</h1>

<div class="card shadow-sm p-3">
<div class="card-body">
<?php
if(isset($_GET['u']) && strlen(trim($_GET['u']) > 0) && trim($_GET['u']) == 1):
?>
<div class="alert alert-info text-blue"><i class="fa fa-check-circle"></i>&nbsp;Administrator profile settings updated successfully. Login to verify.</div>
<?php
endif;
?>
<form name="adminLoginForm" id="adminLoginForm" action="admin/login" method="POST">
<div class="form-group pb-3">
<label class="form-label">Username</label>
<input type="text" name="adminLoginEmail" id="adminLoginEmail"class="form-control" required />
</div>
<div class="form-group pb-3">
<label class="form-label">Password</label>
<input type="password" name="adminLoginPwd" id="adminLoginPwd" class="form-control" required />
</div>
<div class="py-3">
<input type="submit" name="adminLoginSubmit" id="adminLoginSubmit" class="btn btn-red btn-lg" value="Login" />
</div>
</form>
<div class="spinner-border" role="status"></div>

<hr class="hr">
<p class="text-blue fw-bold">Register administrator account below</p>
<a href="admin/register" class="btn btn-red btn-sm ">Register Account</a>

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

<?php include_once(__DIR__.'/../templates/footer.php'); ?>