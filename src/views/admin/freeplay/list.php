<?php
ob_start();
include_once(__DIR__.'/../../../application/sessions.php');
include_once(__DIR__."/../../../models/freeplay_model.php");
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
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Freeplay List</h1>
</div>
</div>

</div>

<div class="container">

<!-- Dashboard Menu -->

<div class="row justify-content-start">

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<form name="adminFreeplaySearchForm" id="adminFreeplaySearchForm" action="admin/freeplay/list" method="POST">
<div class="input-group mb-3">
<input type="text" name="searchValue" id="searchValue" class="form-control" placeholder="Freeplay ID" required />
<input type="hidden" name="searchKey" id="searchKey" value="fffp_uid" />
<button  type="submit" class="btn btn-blue" name="adminFreeplaySearchSubmit" id="adminFreeplaySearchSubmit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
</div>
</form>
</div>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<form name="adminFreeplaySortFilterForm" id="adminFreeplaySortFilterForm" action="admin/freeplay/list" method="POST">
<div class="input-group mb-3">
<select name="sortField" id="sortField" class="form-select">
<option value="fffp_uid">Freeplay ID</option>
<option value="fffp_created_date">Registered Date</option>
</select>
<button  type="submit" class="btn btn-blue" name="adminFreeplaySortFilterSubmit" id="adminFreeplaySortFilterSubmit"><i class="fa fa-sort" aria-hidden="true"></i>&nbsp;Sort</button>
</div>
</form>
</div>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<form name="adminFreeplayClearFilterForm" id="adminFreeplayClearFilterForm" action="admin/freeplay/list" method="POST">
<button  type="submit" class="btn btn-red" name="adminFreeplayClearFilter" id="adminFreeplayClearFilter"><i class="fa fa-undo" aria-hidden="true"></i>&nbsp;Clear Filters</button>
</form>
</div>

</div>

<div class="row">

<?php
$freeplayModel = new FreeplayModel();

$allAdminFreeplaySearch = array();
$allAdminFreeplaySort = array();
$allAdminFreeplayLimit = array();

//Clear Filters
if(isset($_POST['adminFreeplayClearFilter'])){
if(isset($_SESSION['allAdminFreeplaySearch'])){
unset($_SESSION['allAdminFreeplaySearch']);
}
if(isset($_SESSION['allAdminFreeplaySort'])){
unset($_SESSION['allAdminFreeplaySort']);
}
}

//Search Filter
if(isset($_POST['searchKey']) && strlen(trim($_POST['searchKey'])) > 0 && isset($_POST['searchValue']) && strlen(trim($_POST['searchValue'])) > 0){
$searchKey = trim(htmlspecialchars($_POST['searchKey']));
$searchValue = trim(htmlspecialchars($_POST['searchValue']));
$allAdminFreeplaySearch[] = array(
"searchKey" => $searchKey,
"searchValue" => $searchValue
); 
$_SESSION['allAdminFreeplaySearch'] = $allAdminFreeplaySearch;
}
else{
if(isset($_SESSION['allAdminFreeplaySearch']) && count($_SESSION['allAdminFreeplaySearch']) > 0){
$allAdminFreeplaySearch = $_SESSION['allAdminFreeplaySearch'];
}
}

//Sort Filter
if(isset($_POST['sortField']) && strlen(trim($_POST['sortField'])) > 0){
$sortField = trim(htmlspecialchars($_POST['sortField']));
$allAdminFreeplaySort = array("sortField" => $sortField, "sortOrder" => 'DESC');
$_SESSION['allAdminFreeplaySort'] = $allAdminFreeplaySort;
}
else{
if(isset($_SESSION['allAdminFreeplaySort']) && count($_SESSION['allAdminFreeplaySort']) > 0){
$allAdminFreeplaySort = $_SESSION['allAdminFreeplaySort'];
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
$allAdminFreeplayLimit = array("limitOnset" => $startPage, "limitOffset" => $perPage);

$allFreeplays = $freeplayModel->getAllFreeplays($allAdminFreeplaySearch, $allAdminFreeplaySort, $allAdminFreeplayLimit);
foreach($allFreeplays as $freeplayInfo):
?>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<div class="card h-100 shadow-sm">
<div class="row g-0 p-1">

<div class="col-3">
<img src="public/assets/images/misc/ff_placeholder.png" class="img-fluid" alt="<?php echo $freeplayInfo['fffp_name']; ?>">
</div>
<div class="col-9">
<div class="card-body d-flex flex-column">
<p class="card-title fs-5 text-red fw-bold mb-0"><?php echo $freeplayInfo['fffp_name']; ?></p>
<label class="info-label">Freeplay ID</label>
<p class="card-text small text-blue fw-bold mb-1"><?php echo $freeplayInfo['fffp_uid']; ?></p>
<label class="info-label">Email</label>
<p class="card-text small text-blue fw-bold mb-1"><?php echo $freeplayInfo['fffp_email']; ?></p>
</div>
</div>

</div>

<div class="card-footer bg-white d-grid gap-1 d-md-flex justify-content-md-end border-0">
<a href="admin/freeplay/view/<?php echo $freeplayInfo['fffp_uid']; ?>" class="btn btn-red btn-sm">View Freeplay&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
</div>

</div>
</div>

<?php
endforeach;
?>

</div>


<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-5 pt-5 border-top">

<p class="fw-bold text-blue text-uppercase mb-3">Go to page</p>
<!-- Pagination Begin -->
<ul class="pagination">
<?php
$freeplayModel = new FreeplayModel();
$totalFaculties = $freeplayModel->getTotalFreeplays();
$totalPages = ceil($totalFaculties / $perPage);
?>
<!-- First Page -->
<li class="page-item"><a href="admin/freeplay/list?page=1" class="page-link"><i class="fa fa-angle-double-left" aria-hidden="true"></i>&nbsp;First</a></li>
<?php
//Previous Page
if($currentPage > 1){
?>
<li class="page-item"><a href="admin/freeplay/list?page=<?php echo $currentPage - 1 ?>" class="page-link"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;Prev</a></li>
<?php
}
//Next Page
if($currentPage < $totalPages){
?>
<li class="page-item"><a href="admin/freeplay/list?page=<?php echo $currentPage + 1 ?>" class="page-link">Next&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a></li></a></li>
<?php
}
?>
<!-- Last Page -->
<li class="page-item"><a href="admin/freeplay/list?page=<?php echo $totalPages; ?>" class="page-link">Last&nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li></a></li>
</ul>
<!-- Pagination End -->

</div>
</div>


</div>

<?php 
include_once(__DIR__."/../../templates/footer.php"); 
ob_end_flush();
?>