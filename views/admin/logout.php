<?php
ob_start();
include_once(__DIR__."/../../application/sessions.php");
include_once(__DIR__."/../../models/admin_model.php");
?>

<?php
$adminLogOutStatus = -1;
include_once(__DIR__.'/../../application/sessions.php');
$sessions = new Sessions();
$adminSession = $sessions->adminSession();
if($adminSession){
$adminLoginEmail = $_SESSION['bccc_admin']['adminLoginEmail'];
if(isset($adminLoginEmail) && !empty($adminLoginEmail) && $adminLoginEmail !== ''){
$adminLoginStatus = 0;
$adminModel = new AdminModel();
$adminModel->setAdminLoginStatus($adminLoginEmail, $adminLoginStatus);
unset($_SESSION['bccc_admin']);
$adminLogOutStatus = 1;
}
else{
$adminLogOutStatus = 0;
}
}
else{
exit(header('Location: login'));
}
?>

<?php 
include_once(__DIR__.'/../templates/header.php');
?>

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Administrators</h1>
        </div>
    </div>

</div>

<div class="container">
<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<?php if($adminLogOutStatus == 1): ?>
<div class="alert alert-info"><i class="fa fa-check-circle"></i>&nbsp;Administrator account <?php echo $adminLoginEmail; ?> logged out successfully</div>
<?php elseif($adminLogOutStatus == 0): ?>
<div class="alert alert-danger"><i class="fa fa-times-circle"></i>&nbsp;Unable to logout Administrator account <?php echo $adminLoginEmail; ?>. Try again.</div>
<?php elseif($adminLogOutStatus == -1): ?>
<div class="alert alert-danger"><i class="fa fa-times-circle"></i>&nbsp;Unable to get Administrator account <?php echo $adminLoginEmail; ?> login status</div>
<?php else:?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i>&nbsp;Unknown error occurred.</div>
<?php endif; ?>
<div class="d-grid gap-2 d-sm-block py-3">
<a href="admin/login" type="button" class="btn btn-red">Back to Login</a>
</div>
</div>
</div>

</div>

<?php
include_once(__DIR__.'/../templates/footer.php');
ob_end_flush();
?>