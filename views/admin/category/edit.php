<?php
ob_start();
include_once(__DIR__.'/../../../application/sessions.php');
include_once(__DIR__.'/../../../models/category_model.php');
include_once(__DIR__.'/../../../models/event_model.php');
include_once(__DIR__."/../../../models/misc_model.php");
include_once(__DIR__."/../../../models/methods_model.php");
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
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Category</h1>
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

<?php if(!isset($category_id) && $category_id == null && $category_id == ''): ?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get category ID</div>
</div>
<?php 
else:
$categoryModel = new CategoryModel();
$methodsModel = new MethodsModel();
$categoryInfo = $categoryModel->getCategoryByUID($category_id);
if(empty($categoryInfo) || !is_array($categoryInfo)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get category information.</div>
</div>
<?php
else:
?>
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<?php if(is_file("public/assets/images/category/" . $categoryInfo['ffec_image'])): ?>
<img src="public/assets/images/category/<?php echo $categoryInfo['ffec_image']; ?>" class="img-fluid border" alt="<?php echo $categoryInfo['frtm_name']; ?>">
<?php else: ?>
<img src="public/assets/images/misc/ff_placeholder.png" class="img-fluid border" alt="<?php echo $categoryInfo['ffec_name']; ?>">
<?php endif ?>
<!-- Display Category Info -->
<ul class="list-group mt-3">
<li class="list-group-item">
<label class="info-label">Category Name</label>
<p class="text-gray fs-6 fw-bold mb-0"><?php echo $categoryInfo['ffec_name']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Category ID</label>
<p class="text-gray fs-6 mb-0"><?php echo $categoryInfo['ffec_uid']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Registered Date</label>
<p class="text-gray fs-6 mb-0"><?php echo date('F jS, Y', strtotime($categoryInfo['ffec_created_date'])); ?></p>
</li>

</ul>
</div>

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-2">

<h1 class="fs-3 fw-bold text-red">Edit Category</h1>

<form name="categoryEditForm" id="categoryEditForm" action="admin/category/edit" method="POST" enctype="multipart/form-data">

<div class="form-group pb-3">
<label for="categoryName" class="form-label required-field">Category Name</label>
<input type="text" name="categoryName" id="categoryName" class="form-control" value="<?php echo $methodsModel->sanitizeGet($categoryInfo['ffec_name']); ?>" required />
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
<textarea name="categoryDescription" id="categoryDescription" class="form-control" row="3" required><?php echo $methodsModel->sanitizeGet($categoryInfo['ffec_description']); ?></textarea>
</div>

<div class="form-group">
<label for="categoryProfileImage" class="form-label">Category Profile Image</label>
<input type="file" class="form-control" name="categoryProfileImage" id="categoryProfileImage" accept="image/png, image/jpeg" />
<small id="categoryProfileImage_help" class="form-text text-muted mb-0">Upload a PNG or JPEG format image of ratio 1:1 and minimum of 600px.</small>
</div>

<input type="hidden" value="<?php echo $methodsModel->sanitizeGet($categoryInfo['ffec_uid']); ?>" name="categoryUID" id="categoryUID">

<div class="d-grid gap-2 d-sm-block d-md-flex justify-content-md-end py-3">
<input type="submit" name="categoryEditSubmit" id="categoryEditSubmit" class="btn btn-red btn-lg" value="Update" />
</div>
</form>
</div>
</div>
</div>

<?php
endif;
endif;
?>

<!-- AJAX response Modal -->

<?php include_once(__DIR__."/../../templates/modal.php");  ?>

<?php 
include_once(__DIR__."/../../templates/footer.php"); 
ob_end_flush();
?>