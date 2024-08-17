<?php
ob_start();
include_once(__DIR__.'/../../../application/sessions.php');
include_once(__DIR__.'/../../../models/admin_model.php');

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
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Administrators</h1>
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

<div class="row justify-content-start">

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<form name="adminAdministratorSearchForm" id="adminAdministratorSearchForm" action="admin/administrator/list" method="POST">
<div class="input-group mb-3">
<input type="text" name="searchValue" id="searchValue" class="form-control" placeholder="Student ID" required />
<input type="hidden" name="searchKey" id="searchKey" value="ffa_uid" />
<button  type="submit" class="btn btn-blue" name="adminAdministratorSearchSubmit" id="adminAdministratorSearchSubmit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
</div>
</form>
</div>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<form name="fundSortFilterForm" id="fundSortFilterForm" action="admin/administrator/list" method="POST">
<div class="input-group mb-3">
<select name="sortField" id="sortField" class="form-select">
<option value="ffa_uid">Administrator ID</option>
<option value="ffa_created_date">Registered Date</option>
</select>
<button  type="submit" class="btn btn-blue" name="adminAdministratorSortFilterSubmit" id="adminAdministratorSortFilterSubmit"><i class="fa fa-sort" aria-hidden="true"></i>&nbsp;Sort</button>
</div>
</form>
</div>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<form name="adminAdministratorFilterForm" id="adminAdministratorFilterForm" action="admin/administrator/list" method="POST">
<button  type="submit" class="btn btn-red" name="adminAdministratorClearFilter" id="adminAdministratorClearFilter"><i class="fa fa-undo" aria-hidden="true"></i>&nbsp;Clear Filters</button>
</form>
</div>

</div>

<div class="row">

<?php
$adminModel = new AdminModel();

$alladminAdministratorSearch = array();
$alladminAdministratorSort = array();
$alladminAdministratorLimit = array();

//Clear Filters
if(isset($_POST['adminAdministratorClearFilter'])){
if(isset($_SESSION['alladminAdministratorSearch'])){
unset($_SESSION['alladminAdministratorSearch']);
}
if(isset($_SESSION['alladminAdministratorSort'])){
unset($_SESSION['alladminAdministratorSort']);
}
}

//Search Filter
if(isset($_POST['searchKey']) && strlen(trim($_POST['searchKey'])) > 0 && isset($_POST['searchValue']) && strlen(trim($_POST['searchValue'])) > 0){
$searchKey = trim(htmlspecialchars($_POST['searchKey']));
$searchValue = trim(htmlspecialchars($_POST['searchValue']));
$alladminAdministratorSearch[] = array(
"searchKey" => $searchKey,
"searchValue" => $searchValue
); 
$_SESSION['alladminAdministratorSearch'] = $alladminAdministratorSearch;
}
else{
if(isset($_SESSION['alladminAdministratorSearch']) && count($_SESSION['alladminAdministratorSearch']) > 0){
$alladminAdministratorSearch = $_SESSION['alladminAdministratorSearch'];
}
}

//Sort Filter
if(isset($_POST['sortField']) && strlen(trim($_POST['sortField'])) > 0){
$sortField = trim(htmlspecialchars($_POST['sortField']));
$alladminAdministratorSort = array("sortField" => $sortField, "sortOrder" => 'DESC');
$_SESSION['alladminAdministratorSort'] = $alladminAdministratorSort;
}
else{
if(isset($_SESSION['alladminAdministratorSort']) && count($_SESSION['alladminAdministratorSort']) > 0){
$alladminAdministratorSort = $_SESSION['alladminAdministratorSort'];
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
$alladminAdministratorLimit = array("limitOnset" => $startPage, "limitOffset" => $perPage);

$allAdmins = $adminModel->getAllAdmins($alladminAdministratorSearch, $alladminAdministratorSort, $alladminAdministratorLimit);
foreach($allAdmins as $adminInfo):
?>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<div class="card h-100 shadow-sm">
<div class="row g-0 p-1">

<div class="col-3">
<?php if(is_file("public/assets/images/admin/" . $adminInfo['ffa_image'])): ?>
<img src="public/assets/images/admin/<?php echo $adminInfo['ffa_image']; ?>" class="img-fluid" alt="<?php echo $adminInfo['ffa_name']; ?>">
<?php else: ?>
<img src="public/assets/images/misc/fr_placeholder.png" class="img-fluid" alt="<?php echo $adminInfo['ffa_name']; ?>">
<?php endif ?>
</div>
<div class="col-9">
<div class="card-body d-flex flex-column">
<p class="card-title fs-5 text-red fw-bold mb-0"><?php echo $adminInfo['ffa_name']; ?></p>
<label class="info-label">Administrator ID</label>
<p class="card-text small text-blue fw-bold mb-1"><?php echo $adminInfo['ffa_uid']; ?></p>
<label class="info-label">Email</label>
<p class="card-text small text-blue fw-bold mb-1"><?php echo $adminInfo['ffa_email']; ?></p>
</div>

<div class="card-footer bg-white d-grid gap-1 d-md-flex justify-content-md-end border-0">
<a href="admin/administrator/edit/<?php echo $adminInfo['ffa_uid']; ?>" class="btn btn-red btn-sm">View Administrator&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
</div>

</div>
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
$adminModel = new AdminModel();
$totalAdministrators = $adminModel->getTotalAdmins();
$totalPages = ceil($totalAdministrators / $perPage);
?>
<!-- First Page -->
<li class="page-item"><a href="admin/administrator/list?page=1" class="page-link"><i class="fa fa-angle-double-left" aria-hidden="true"></i>&nbsp;First</a></li>
<?php
//Previous Page
if($currentPage > 1){
?>
<li class="page-item"><a href="admin/administrator/list?page=<?php echo $currentPage - 1 ?>" class="page-link"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;Prev</a></li>
<?php
}
//Next Page
if($currentPage < $totalPages){
?>
<li class="page-item"><a href="admin/administrator/list?page=<?php echo $currentPage + 1 ?>" class="page-link">Next&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a></li></a></li>
<?php
}
?>
<!-- Last Page -->
<li class="page-item"><a href="admin/administrator/list?page=<?php echo $totalPages; ?>" class="page-link">Last&nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li></a></li>
</ul>
<!-- Pagination End -->

</div>
</div>


</div>

<?php 
include_once(__DIR__."/../../templates/footer.php"); 
ob_end_flush();
?>