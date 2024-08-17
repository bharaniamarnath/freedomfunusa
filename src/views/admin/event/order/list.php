<?php
ob_start();
include_once(__DIR__.'/../../../../application/sessions.php');
include_once(__DIR__."/../../../../models/event_model.php");
include_once(__DIR__."/../../../../models/misc_model.php");
$sessions = new Sessions();
$adminSession = $sessions->adminSession();
if(!$adminSession){
exit(header('Location: ../../login'));
}
?>

<?php
include_once(__DIR__.'/../../../templates/header_admin.php');
?>

<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Orders List</h1>
</div>
</div>

</div>

<div class="container">

<div class="row justify-content-start">

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<form name="eventOrderSearchForm" id="eventOrderSearchForm" action="admin/event/order/list" method="POST">
<div class="input-group mb-3">
<input type="text" name="searchValue" id="searchValue" class="form-control" placeholder="Search" required />

<select name="searchKey" id="searchKey" class="form-select">
<option value="ffeo.ffeo_oid">Order ID</option>
<option value="ffep.ffep_first_name">First Name</option>
<option value="ffep.ffep_last_name">Last Name</option>
<option value="ffep.ffep_email">Email</option>
<option value="ffep.ffep_phone">Phone</option>
<option value="ffep.ffep_zip">Zip</option>
<option value="ffeo.ffeo_order_date">Order Date</option>
</select>

<!-- <input type="hidden" name="searchKey" id="searchKey" value="ffeo_oid" /> -->
<button  type="submit" class="btn btn-blue" name="eventOrderSearchSubmit" id="eventOrderSearchSubmit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
</div>
</form>
</div>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<form name="eventSortFilterForm" id="eventSortFilterForm" action="admin/event/order/list" method="POST">
<div class="input-group mb-3">
<select name="sortField" id="sortField" class="form-select">
<option value="ffeo.ffeo_oid">Order ID</option>
<option value="ffeo.ffeo_order_date">Order Date</option>
<option value="ffeo.ffeo_total_amt">Order Amount</option>
</select>
<button  type="submit" class="btn btn-blue" name="eventOrderSortFilterSubmit" id="eventOrderSortFilterSubmit"><i class="fa fa-sort" aria-hidden="true"></i>&nbsp;Sort</button>
</div>
</form>
</div>

<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<form name="eventClearFilterForm" id="eventClearFilterForm" action="admin/event/order/list" method="POST">
<button  type="submit" class="btn btn-red" name="eventOrderClearFilter" id="eventOrderClearFilter"><i class="fa fa-undo" aria-hidden="true"></i>&nbsp;Clear Filters</button>
</form>
</div>

</div>

<div class="row">
<?php
$eventModel = new EventModel();

$allEventOrdersSearch = array();
$allEventOrdersSort = array();
$allEventOrdersLimit = array();

//Clear Filter
if(isset($_POST['eventOrderClearFilter'])){
if(isset($_SESSION['allEventOrdersSearch'])){
unset($_SESSION['allEventOrdersSearch']);
}if(isset($_SESSION['allEventOrdersSort'])){
unset($_SESSION['allEventOrdersSort']);
}
}

//Search Filter
if(isset($_POST['searchKey']) && strlen(trim($_POST['searchKey'])) > 0 && isset($_POST['searchValue']) && strlen(trim($_POST['searchValue'])) > 0){
$searchKey = trim(htmlspecialchars($_POST['searchKey']));
$searchValue = trim(htmlspecialchars($_POST['searchValue']));
$allEventOrdersSearch[] = array(
"searchKey" => $searchKey,
"searchValue" => $searchValue
); 
$_SESSION['allEventOrdersSearch'] = $allEventOrdersSearch;
}
else{
if(isset($_SESSION['allEventOrdersSearch']) && count($_SESSION['allEventOrdersSearch']) > 0){
$allEventOrdersSearch = $_SESSION['allEventOrdersSearch'];
}
}

//Sort Filter
if(isset($_POST['sortField']) && strlen(trim($_POST['sortField'])) > 0){
$sortField = trim(htmlspecialchars($_POST['sortField']));
$allEventOrdersSort = array("sortField" => $sortField, "sortOrder" => 'DESC');
$_SESSION['allEventOrdersSort'] = $allEventOrdersSort;
}
else{
if(isset($_SESSION['allEventOrdersSort']) && count($_SESSION['allEventOrdersSort']) > 0){
$allEventOrdersSort = $_SESSION['allEventOrdersSort'];
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
$allEventOrdersLimit = array("limitOnset" => $startPage, "limitOffset" => $perPage);

$allEventOrders = $eventModel->getAllEventOrdersList($allEventOrdersSearch, $allEventOrdersSort, $allEventOrdersLimit);
if(!$allEventOrders || !is_array($allEventOrders)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;No event orders found in the record.</div>
</div>
<?php
else:
foreach($allEventOrders as $eventOrderInfo):
?>
<!-- Events -->
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<div class="card h-100 shadow-sm">
<div class="row g-0 p-1">

<div class="col-3">
<img src="public/assets/images/misc/ff_placeholder.png" class="img-fluid" alt="<?php echo $eventOrderInfo['ffe_name']; ?>">
</div>

<div class="col-9">
<div class="card-body d-flex flex-column">
<label class="info-label">Order ID</label>
<p class="card-text fs-6 text-red fw-bold mb-3"><?php echo $eventOrderInfo['ffeo_oid']; ?></p>
<label class="info-label">Order Amount</label>
<p class="card-text text-blue fw-bold fs-4 mb-1">&dollar;<?php echo number_format($eventOrderInfo['ffeo_total_amt'], 2, '.', ','); ?></p>
<label class="info-label">Order Date</label>
<p class="card-text small text-blue fw-bold"><?php echo date('F jS Y, H:i:s', strtotime($eventOrderInfo['ffeo_order_date'])); ?></p>
</div>
</div>

<div class="card-footer bg-white d-grid gap-1 d-md-flex justify-content-md-end border-0">
<a href="admin/event/order/view/<?php echo $eventOrderInfo['ffeo_oid']; ?>" class="btn btn-red btn-sm">View Order&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
</div>
</div>
</div>
</div>

<?php
endforeach;
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
$totalEventOrders = $eventModel->getTotalEventOrders();
$totalPages = ceil($totalEventOrders / $perPage);
?>
<!-- First Page -->
<li class="page-item"><a href="admin/event/order/list?page=1" class="page-link"><i class="fa fa-angle-double-left" aria-hidden="true"></i>&nbsp;First</a></li>
<?php
//Previous Page
if($currentPage > 1){
?>
<li class="page-item"><a href="admin/event/order/list?page=<?php echo $currentPage - 1 ?>" class="page-link"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;Prev</a></li>
<?php
}
//Next Page
if($currentPage < $totalPages){
?>
<li class="page-item"><a href="admin/event/order/list?page=<?php echo $currentPage + 1 ?>" class="page-link">Next&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a></li></a></li>
<?php
}
?>
<!-- Last Page -->
<li class="page-item"><a href="admin/event/order/list?page=<?php echo $totalPages; ?>" class="page-link">Last&nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li></a></li>
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

<?php 
include_once(__DIR__."/../../../templates/footer.php");
ob_end_flush();
?>