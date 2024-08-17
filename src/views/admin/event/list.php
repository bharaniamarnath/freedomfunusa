<?php
ob_start();
include_once(__DIR__.'/../../../application/sessions.php');
include_once(__DIR__."/../../../models/event_model.php");
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
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Events List</h1>
</div>
</div>

</div>

<div class="container">

<div class="row justify-content-start">

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<form name="allAdminEventSearchForm" id="allAdminEventSearchForm" action="admin/event/list" method="POST">
<div class="input-group mb-3">
<input type="text" name="searchValue" id="searchValue" class="form-control" placeholder="Event ID" required />
<input type="hidden" name="searchKey" id="searchKey" value="ffe_uid" />
<button  type="submit" class="btn btn-blue" name="allAdminEventSearchSubmit" id="allAdminEventSearchSubmit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
</div>
</form>
</div>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<form name="allAdminEventSortFilterForm" id="allAdminEventSortFilterForm" action="admin/event/list" method="POST">
<div class="input-group mb-3">
<select name="sortField" id="sortField" class="form-select">
<option value="ffe_uid">Event ID</option>
<option value="ffe_created_date">Registered Date</option>
</select>
<button  type="submit" class="btn btn-blue" name="allAdminEventSortFilterSubmit" id="allAdminEventSortFilterSubmit"><i class="fa fa-sort" aria-hidden="true"></i>&nbsp;Sort</button>
</div>
</form>
</div>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<form name="allAdminEventClearFilterForm" id="allAdminEventClearFilterForm" action="admin/event/list" method="POST">
<button  type="submit" class="btn btn-red" name="allAdminEventClearFilter" id="allAdminEventClearFilter"><i class="fa fa-undo" aria-hidden="true"></i>&nbsp;Clear Filters</button>
</form>
</div>

</div>

<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<a class="btn btn-red" href="admin/event/register"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Register Event</a>
</div>
</div>

<div class="row">
<?php
$eventModel = new EventModel();

$allAdminEventSearch = array();
$allAdminEventSort = array();
$allAdminEventLimit = array();

//Clear Filters
if(isset($_POST['allAdminEventClearFilter'])){
if(isset($_SESSION['allAdminEventSearch'])){
unset($_SESSION['allAdminEventSearch']);
}
if(isset($_SESSION['allAdminEventSort'])){
unset($_SESSION['allAdminEventSort']);
}
}

//Search Filter
if(isset($_POST['searchKey']) && strlen(trim($_POST['searchKey'])) > 0 && isset($_POST['searchValue']) && strlen(trim($_POST['searchValue'])) > 0){
$searchKey = trim(htmlspecialchars($_POST['searchKey']));
$searchValue = trim(htmlspecialchars($_POST['searchValue']));
$allAdminEventSearch[] = array(
"searchKey" => $searchKey,
"searchValue" => $searchValue
); 
$_SESSION['allAdminEventSearch'] = $allAdminEventSearch;
}
else{
if(isset($_SESSION['allAdminEventSearch']) && count($_SESSION['allAdminEventSearch']) > 0){
$allAdminEventSearch = $_SESSION['allAdminEventSearch'];
}
}

//Sort Filter
if(isset($_POST['sortField']) && strlen(trim($_POST['sortField'])) > 0){
$sortField = trim(htmlspecialchars($_POST['sortField']));
$allAdminEventSort = array("sortField" => $sortField, "sortOrder" => 'DESC');
$_SESSION['allAdminEventSort'] = $allAdminEventSort;
}
else{
if(isset($_SESSION['allAdminEventSort']) && count($_SESSION['allAdminEventSort']) > 0){
$allAdminEventSort = $_SESSION['allAdminEventSort'];
}
}

//Pagination
$currentPage = 1;
$perPage = 9;
if(isset($_GET['page']) && $_GET['page'] !== '' && is_numeric($_GET['page'])):
$currentPage = trim(htmlspecialchars($_GET['page']));
else:
$currentPage = 1;
endif;
$startPage = ($currentPage - 1) * $perPage;
$allAdminEventLimit = array("limitOnset" => $startPage, "limitOffset" => $perPage);

$allEvents = $eventModel->getAllEvents($allAdminEventSearch, $allAdminEventSort, $allAdminEventLimit);

if(!$allEvents || !is_array($allEvents)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;No events found in the record.</div>
</div>
<?php
else:
foreach($allEvents as $event):
?>
<!-- Event Info -->
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<div class="card h-100 shadow-sm">
<div class="row g-0 p-1">

<div class="col-3">
<?php if(is_file("public/assets/images/event/" . $event['ffe_image'])): ?>
<img src="public/assets/images/event/<?php echo $event['ffe_image']; ?>" class="img-fluid" alt="<?php echo $event['ffe_name']; ?>">
<?php else: ?>
<img src="public/assets/images/misc/ff_placeholder.png" class="img-fluid" alt="<?php echo $event['ffe_name']; ?>">
<?php endif ?>
</div>
<div class="col-9">
<div class="card-body d-flex flex-column">
<h5 class="card-title text-red fw-bold"><?php echo $event['ffe_name']; ?></h5>
<label class="info-label">Event Date</label>
<p class="card-text small text-blue fw-bold"><?php echo date('F jS, Y', strtotime($event['ffe_start_date'])); ?></p>
</div>
</div>
</div>

<div class="card-footer bg-white d-grid gap-1 d-md-flex justify-content-md-end border-0">
<a href="admin/event/edit/<?php echo $event['ffe_uid']?>" class="btn btn-blue btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</a>
<button type="button" id="<?php echo $event['ffe_uid']?>" class="btn btn-red btn-sm btn-del-event-confirm"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Delete</button>
</div>
</div>
</div>

<?php
endforeach;
?>
<?php
endif;
?>
</div>


<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-5 pt-5 border-top">

<p class="fw-bold text-blue text-uppercase mb-3">Go to page</p>
<!-- Pagination Begin -->
<ul class="pagination">
<?php
$eventModel = new EventModel();
$totalEvents = $eventModel->getTotalEvents();
$totalPages = ceil($totalEvents / $perPage);
?>
<!-- First Page -->
<li class="page-item"><a href="admin/event/list?page=1" class="page-link"><i class="fa fa-angle-double-left" aria-hidden="true"></i>&nbsp;First</a></li>
<?php
//Previous Page
if($currentPage > 1){
?>
<li class="page-item"><a href="admin/event/list?page=<?php echo $currentPage - 1 ?>" class="page-link"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;Prev</a></li>
<?php
}
//Next Page
if($currentPage < $totalPages){
?>
<li class="page-item"><a href="admin/event/list?page=<?php echo $currentPage + 1 ?>" class="page-link">Next&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a></li></a></li>
<?php
}
?>
<!-- Last Page -->
<li class="page-item"><a href="admin/event/list?page=<?php echo $totalPages; ?>" class="page-link">Last&nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li></a></li>
</ul>
<!-- Pagination End -->

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

<!-- Confirm Action Modal -->

<div class="modal fade" tabindex="-1" id="confirmAction">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header bg-white">
<h5 class="modal-title text-red fw-bold"><?php echo $aboutJSONEnc['Facilitator']['title']; ?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body text-center">
<i class="fa fa-exclamation-circle fa-5x text-red mb-3" aria-hidden="true"></i>
<p class="text-red fw-bold mb-0">Confirm delete selected?</p>
</div>
<div class="modal-footer">
<a href="admin/event/delete" type="button" class="btn btn-red btn-del-event">Yes</a>
<button type="button" class="btn btn-blue" data-bs-dismiss="modal">No</button>
</div>
</div>
</div>
</div>

<?php 
include_once(__DIR__."/../../templates/footer.php"); 
ob_end_flush();
?>