<?php
ob_start();
include_once(__DIR__.'/../../../application/sessions.php');
include_once(__DIR__."/../../../models/event_model.php");
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

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Categories</h1>
        </div>
    </div>

</div>

<div class="container">

    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="admin/manage">Manage</a></li>
            <li class="breadcrumb-item"><a href="admin/category/list">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Category</li>
        </ol>
    </nav>

<div class="row">

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-2">

<h1 class="fs-3 fw-bold text-red mb-3">Register Category</h1>

<div class="card shadow-sm">
<div class="card-body">

<form name="categoryRegisterForm" id="categoryRegisterForm" action="admin/category/register" method="POST" enctype="multipart/form-data">

<div class="form-group pb-3">
<label for="categoryName" class="form-label required-field">Category Name</label>
<input type="text" name="categoryName" id="categoryName" class="form-control" required />
</div>

<div class="from-group my-0">
<label class="form-label required-field" for="categoryEvent">Category Event</label>
</div>

<div class="input-group mb-0">
<select class="form-select" name="categoryEvent" id="categoryEvent" aria-label="Select Event">
<optgroup>
<option value="" selected>Select Event</option>
<?php
$eventModel = new EventModel();
$allEventsSearch = array();
$allEventsSort = array("sortField"=>"ffe_name", "sortOrder" => "DESC");
$allEventsLimit = array();
$allEvents = $eventModel->getAllEvents($allEventsSearch, $allEventsSort, $allEventsLimit);
foreach($allEvents as $event):
?>
<option value="<?php echo $event["ffe_uid"]; ?>"><?php echo $event["ffe_name"]; ?></option>
<?php
endforeach;
?>
</optgroup>
</select>
</div>
<label id="categoryEventError"></label>

<div class="form-group pb-3">
<label for="categoryDescription" class="form-label required-field">Category Description</label>
<textarea name="categoryDescription" id="categoryDescription" class="form-control" row="3" required></textarea>
</div>

<div class="form-group">
<label for="categoryProfileImage" class="form-label">Category Profile Image</label>
<input type="file" class="form-control" name="categoryProfileImage" id="categoryProfileImage" accept="image/png, image/jpeg" />
<small id="categoryProfileImage_help" class="form-text text-muted mb-0">Upload a PNG or JPEG format image of ratio 1:1 and minimum of 600px.</small>
</div>

<div class="form-group col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 my-3">
<?php
$capNumFirst = rand(1, 9);
$capNumSecond = rand(1, 9);
$capSum = (int) $capNumFirst + (int) $capNumSecond;
$capSumStr = strval($capSum);
?>
<label for="categoryReCaptcha" class="form-label required-field">Resolve</label>&nbsp;<i class="fa fa-question-circle-o text-blue" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Resolve to prove you are not a spam."></i><br/>
<small class="form-text">What is <?php echo strval($capNumFirst); ?> + <?php echo strval($capNumSecond); ?>?</small>
<input type="text" class="form-control" id="categoryReCaptcha" name="categoryReCaptcha" placeholder="Answer">
<input class="form-control" type="hidden" id="categoryReCaptchaVal" name="categoryReCaptchaVal" value="<?php echo strval($capSumStr); ?>" readonly>
</div>
<div class="form-check my-3">
<input type="checkbox" class="form-check-input" id="categoryTermsCheck" name="categoryTermsCheck">
<label for="categoryTermsCheck" class="form-check-label required-field">Agree to Terms &amp; Conditions - <span><a class="text-decoration-none text-red" href="terms">Read Terms</a></span></label>&nbsp;<i class="fa fa-question-circle-o text-blue" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="You are required to agree to Freedom Fun Terms &amp; Policies"></i>
<label id="categoryTermsCheckError"></label>
</div>
<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="categoryRegisterSubmit" id="categoryRegisterSubmit" class="btn btn-red btn-lg" value="Register" />
</div>
</form>

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