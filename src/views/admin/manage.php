<?php
ob_start();
include_once(__DIR__.'/../../application/sessions.php');
include_once(__DIR__.'/../../models/admin_model.php');
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
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Manage</h1>
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

<!-- Event Orders -->
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
<div class="card h-100 shadow-sm">
<div class="card-body d-flex flex-column">
<h5 class="card-title text-blue fw-bold">Event Orders</h5>
<p class="card-text small text-gray">View event orders, participants and games</p>
</div>
<div class="card-footer d-grid justify-content-end bg-white border-0">
<a href="admin/event/order/list" class="btn btn-blue btn-sm">View Event Orders&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
</div>
</div>
</div>

<!-- Events -->
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
<div class="card h-100 shadow-sm">
<div class="card-body d-flex flex-column">
<h5 class="card-title text-red fw-bold">Events</h5>
<p class="card-text small text-gray">Add new event, update or delete existing events in category</p>
</div>
<div class="card-footer d-grid justify-content-end bg-white border-0">
<a href="admin/event/list" class="btn btn-red btn-sm">Manage Events&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
</div>
</div>
</div>

<!-- Games -->
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
<div class="card h-100 shadow-sm">
<div class="card-body d-flex flex-column">
<h5 class="card-title text-blue fw-bold">Games</h5>
<p class="card-text small text-gray">Add new game, update or delete existing games in category</p>
</div>
<div class="card-footer d-grid justify-content-end bg-white border-0">
<a href="admin/game/list" class="btn btn-blue btn-sm">Manage Games&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
</div>
</div>
</div>

<!-- Freeplay -->
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
<div class="card h-100 shadow-sm">
<div class="card-body d-flex flex-column">
<h5 class="card-title text-red fw-bold">Walk-In</h5>
<p class="card-text small text-gray">Register walk-in participants on event day</p>
</div>
<div class="card-footer d-grid justify-content-end bg-white border-0">
<a href="admin/signup/event" class="btn btn-red btn-sm">Register&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
</div>
</div>
</div>

<!-- Categories -->
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
<div class="card h-100 shadow-sm">
<div class="card-body d-flex flex-column">
<h5 class="card-title text-blue fw-bold">Categories</h5>
<p class="card-text small text-gray">Add new category, update or delete existing categories</p>
</div>
<div class="card-footer d-grid justify-content-end bg-white border-0">
<a href="admin/category/list" class="btn btn-blue btn-sm">Manage Categories&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
</div>
</div>
</div>

<!-- Administrators -->
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
<div class="card h-100 shadow-sm">
<div class="card-body d-flex flex-column">
<h5 class="card-title text-red fw-bold">Administrators</h5>
<p class="card-text small text-gray">Update account status of other administrator accounts</p>
</div>
<div class="card-footer d-grid justify-content-end bg-white border-0">
<a href="admin/administrator/list" class="btn btn-red btn-sm">Update&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
</div>
</div>
</div>


<!-- About Configure -->
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
<div class="card h-100 shadow-sm">
<div class="card-body d-flex flex-column">
<h5 class="card-title text-blue fw-bold">About Event</h5>
<p class="card-text small text-gray">Update event organiser and sponsor information</p>
</div>
<div class="card-footer d-grid justify-content-end bg-white border-0">
<a href="admin/config/about" class="btn btn-blue btn-sm">Update&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
</div>
</div>
</div>


<!-- Constant Configure -->
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
<div class="card h-100 shadow-sm">
<div class="card-body d-flex flex-column">
<h5 class="card-title text-red fw-bold">Constants</h5>
<p class="card-text small text-gray">Update tax rate, admin email, base URL</p>
</div>
<div class="card-footer d-grid justify-content-end bg-white border-0">
<a href="admin/config/constant" class="btn btn-red btn-sm">Update&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
</div>
</div>
</div>


</div>

</div>

</div>

<?php 
include_once(__DIR__."/../templates/footer.php"); 
ob_end_flush();
?>