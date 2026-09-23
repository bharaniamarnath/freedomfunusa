<?php
ob_start();
include_once(__DIR__.'/../../../application/sessions.php');
include_once(__DIR__."/../../../models/misc_model.php");
$sessions = new Sessions();
$adminSession = $sessions->adminSession();
if(!$adminSession){
exit(header('Location: ../login'));
}
?>

<?php
include_once(__DIR__.'/../../templates/header_admin.php');
?>

<div class="container-fluid page">

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Game</h1>
        </div>
    </div>

</div>

</div>

<div class="container">

    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="admin/manage">Manage</a></li>
            <li class="breadcrumb-item"><a href="admin/game/list">Games</a></li>
            <li class="breadcrumb-item active" aria-current="page">Game</li>
        </ol>
    </nav>

<div class="row">

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-2">

<div class="card shadow-sm">
<div class="card-body">

<form name="gameRegisterForm" id="gameRegisterForm" action="admin/game/register" method="POST" enctype="multipart/form-data">

<div class="form-group pb-3">
<label for="gameName" class="form-label required-field">Game Name</label>
<input type="text" name="gameName" id="gameName" class="form-control" required />
</div>

<div class="form-group">
<label for="gamePrice" class="form-label required-field">Game Price</label>
</div>

<div class="input-group">
<div class="input-group-prepend">
<span class="input-group-text">$</span>
</div>
<input type="text" name="gamePrice" id="gamePrice" class="form-control" required />
</div>
<label class="mb-3" id="gamePriceError"></label>

<div class="form-group pb-3">
<label for="gameDescription" class="form-label required-field">Game Description</label>
<textarea name="gameDescription" id="gameDescription" class="form-control" row="3" required></textarea>
</div>

<div class="form-group">
<label for="gameProfileImage" class="form-label">Game Profile Image</label>
<input type="file" class="form-control" name="gameProfileImage" id="gameProfileImage" accept="image/png, image/jpeg" />
<small id="gameProfileImage_help" class="form-text text-muted mb-0">Upload a PNG or JPEG format image of ratio 1:1 and minimum of 600px.</small>
</div>

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="gameRegisterSubmit" id="gameRegisterSubmit" class="btn btn-red btn-lg" value="Register" />
</div>
</form>

</div>
</div>

</div>
</div>
</div>

</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../../templates/modal.php");  ?>

<?php 
include_once(__DIR__."/../../templates/footer.php"); 
ob_end_flush();
?>