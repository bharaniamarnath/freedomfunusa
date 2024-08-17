<?php
ob_start();
include_once(__DIR__.'/../../../application/sessions.php');
include_once(__DIR__."/../../../models/category_model.php");
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

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Register Event</h1>
</div>
</div>

</div>

<div class="container">

<div class="row">

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-2">


<div class="card shadow-sm">
<div class="card-body">

<form name="eventRegisterForm" id="eventRegisterForm" action="admin/event/register" method="POST" enctype="multipart/form-data">

<div class="form-group pb-3">
<label for="eventName" class="form-label required-field">Event Name</label>
<input type="text" name="eventName" id="eventName" class="form-control" required />
</div>

<div class='form-group my-3'>
<label class='form-label' for='eventStartDate'>Event Start Date</label>
<input class='form-control' type="text" name="eventStartDate" id="eventStartDate" required>
</div>

<div class='form-group my-3'>
<label class='form-label' for='eventEndDate'>Event End Date</label>
<input class='form-control' type="text" name="eventEndDate" id="eventEndDate" required>
</div>

<div class="form-group pb-3">
<label for="eventDescription" class="form-label required-field">Event Description</label>
<textarea name="eventDescription" id="eventDescription" class="form-control" row="3" required></textarea>
</div>

<div class="form-group">
<label for="eventProfileImage" class="form-label">Event Profile Image</label>
<input type="file" class="form-control" name="eventProfileImage" id="eventProfileImage" accept="image/png, image/jpeg" />
<small id="eventProfileImage_help" class="form-text text-muted mb-0">Upload a PNG or JPEG format image of ratio 1:1 and minimum of 600px.</small>
</div>

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="eventRegisterSubmit" id="eventRegisterSubmit" class="btn btn-red btn-lg" value="Register" />
</div>
</form>
<div class="spinner-border text-red" role="status"></div>


</div>
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

<?php 
include_once(__DIR__."/../../templates/footer.php"); 
ob_end_flush();
?>