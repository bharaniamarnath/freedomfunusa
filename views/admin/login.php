<?php include_once(__DIR__.'/../templates/header.php'); ?>

<div class="container-fluid page">

<div class="row mx-auto">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
<h1 class='display-4 fw-bold text-blue text-center mb-0'>Administrator</h1>
</div>
</div>

</div>

<div class="container">
<div class="row">
<div class="col-xxl-5 col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12 col-12 py-2">

<h1 class="fs-3 fw-bold text-red mb-3">Login</h1>

<div class="card shadow-sm p-3">
<div class="card-body">
<?php
if(isset($_GET['u']) && strlen(trim($_GET['u']) > 0) && trim($_GET['u']) == 1):
?>
<div class="alert alert-info text-blue"><i class="fa fa-check-circle"></i>&nbsp;Administrator profile updated successfully. Login to verify.</div>
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

</div>
</div>

<div class="alert alert-info mt-4">
<p class="text-blue fw-bold"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Register administrator account below</p>
<a href="admin/register" class="btn btn-blue btn-sm ">Register</a>
</div>

</div>
</div>
</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../templates/modal.php");  ?>

<?php include_once(__DIR__.'/../templates/footer.php'); ?>