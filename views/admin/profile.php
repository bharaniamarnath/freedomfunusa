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
$adminModel = new AdminModel();
$adminEmail = $_SESSION['bccc_admin']['adminLoginEmail'];
$adminInfo = $adminModel->getAdminInfo($adminEmail);
if(empty($adminInfo) && !is_array($adminInfo)):
exit(header('Location: login'));
endif;
?>

<?php
include_once(__DIR__.'/../templates/header_admin.php');
?>

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Profile</h1>
        </div>
    </div>

</div>

<div class="container">


    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </nav>



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

<ul class="list-group mt-3">

<li class="list-group-item">
<label class="info-label">Admin Name</label>
<p class="text-gray fs-6 fw-bold mb-0"><?php echo $adminInfo['ffa_name']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Admin ID</label>
<p class="text-gray fs-6 mb-0"><?php echo $adminInfo['ffa_uid']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Admin Email</label>
<p class="text-gray fs-6 mb-0"><?php echo $adminInfo['ffa_email']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Registered Date</label>
<p class="text-gray fs-6 mb-0"><?php echo date('F jS, Y', strtotime($adminInfo['ffa_created_date'])); ?></p>
</li>

</ul>

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

</div>


<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-2">

<h1 class="fs-3 fw-bold text-red">Update Password</h1>

<form name="adminPasswordEditForm" id="adminPasswordEditForm" action="admin/password/edit" method="POST" enctype="multipart/form-data">
<div class="form-group pb-3">
<label for="adminPwd" class="form-label required-field">Current Password</label>
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

<input type="hidden" value="<?php echo $methodsModel->sanitizeGet($adminInfo['ffa_email']); ?>" name="adminEmail" id="adminEmail" />
<input type="hidden" value="<?php echo $methodsModel->sanitizeGet($adminInfo['ffa_acc_status']); ?>" name="adminAccountStatus" id="adminAccountStatus" />

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="adminPasswordEditSubmit" id="adminPasswordEditSubmit" class="btn btn-red btn-lg" value="Update" />
</div>
</form>

</div>

<?php
endif;
?>

</div>

</div>

</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../templates/modal.php");  ?>

<?php 
include_once(__DIR__."/../templates/footer.php"); 
ob_end_flush();
?>