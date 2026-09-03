<?php
ob_start();
include_once(__DIR__.'/../../../application/sessions.php');
include_once(__DIR__."/../../../models/freeplay_model.php");
include_once(__DIR__."/../../../models/category_model.php");
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

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Freeplay</h1>
        </div>
    </div>

</div>

<div class="container">

    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="admin/manage">Manage</a></li>
            <li class="breadcrumb-item"><a href="admin/freeplay/list">Freeplay</a></li>
            <li class="breadcrumb-item active" aria-current="page">Participant</li>
        </ol>
    </nav>


<!-- Dashboard Menu -->

<div class="row">

<?php if(!isset($freeplay_id) && $freeplay_id == null && $freeplay_id == ''): ?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get student ID</div>
</div>
<?php 
else:
$freeplayModel = new FreeplayModel();
$categoryModel = new CategoryModel();
$methodsModel = new MethodsModel();
$freeplayInfo = $freeplayModel->getFreeplayByUID($freeplay_id);
if(empty($freeplayInfo) || !is_array($freeplayInfo)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get student information.</div>
</div>
<?php
else:
?>
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<!-- Display Freeplay Info -->

<img src="public/assets/images/misc/ff_placeholder.png" class="img-fluid border border-1" alt="<?php echo $freeplayInfo['fffp_name']; ?>">

</div>

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 py-3">

<ul class="list-group">
<li class="list-group-item">
<label class="info-label">Freeplay Name</label>
<p class="text-red fs-4 fw-bold mb-0"><?php echo $freeplayInfo['fffp_name']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Freeplay ID</label>
<p class="text-blue fs-5 fw-bold mb-0"><?php echo $freeplayInfo['fffp_uid']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Email</label>
<p class="text-blue fw-bold mb-0"><?php echo $freeplayInfo['fffp_email']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Phone</label>
<p class="text-blue fw-bold mb-0"><?php echo $freeplayInfo['fffp_phone']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Date of Birth</label>
<p class="text-blue fw-bold mb-0"><?php echo date('F jS Y, h:i A', strtotime($freeplayInfo['fffp_dob'])); ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Guardian Name</label>
<p class="text-blue fw-bold mb-0"><?php echo $freeplayInfo['fffp_guardian']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Address</label>
<p class="text-blue fw-bold mb-0"><?php echo $freeplayInfo['fffp_address']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Zip Code</label>
<p class="text-blue fw-bold mb-0"><?php echo $freeplayInfo['fffp_zip']; ?></p>
</li>
<li class="list-group-item">
<p class="text-muted small mb-0">Registered on <?php echo date('F jS Y, h:i A', strtotime($freeplayInfo['fffp_created_date'])); ?></p>
</li>
</ul>

</div>

<?php
endif;
endif;
?>

</div>

</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../../templates/modal.php");  ?>

<?php 
include_once(__DIR__."/../../templates/footer.php"); 
ob_end_flush();
?>