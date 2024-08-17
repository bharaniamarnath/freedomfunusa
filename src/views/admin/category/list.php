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
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Category List</h1>
</div>
</div>

</div>

<div class="container">

<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<a class="btn btn-red" href="admin/category/register"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Register Category</a>
</div>
</div>

<div class="row">
<?php
$categoryModel = new CategoryModel();
$allCategories = $categoryModel->getAllCategories();
if(!$allCategories || !is_array($allCategories)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;No categories found in the list</div>
</div>
<?php
else:
foreach($allCategories as $category):
?>
<!-- Category Info -->
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<div class="card h-100 shadow-sm">
<div class="row g-0 p-1">

<div class="col-3">
<?php if(is_file("public/assets/images/category/" . $category['ffec_image'])): ?>
<img src="public/assets/images/category/<?php echo $category['ffec_image']; ?>" class="img-fluid" alt="<?php echo $category['ffec_name']; ?>">
<?php else: ?>
<img src="public/assets/images/misc/ff_placeholder.png" class="img-fluid" alt="<?php echo $category['ffec_name']; ?>">
<?php endif ?>
</div>
<div class="col-9">
<div class="card-body d-flex flex-column">
<h5 class="card-title fs-6 text-red fw-bold"><?php echo $category['ffec_name']; ?></h5>
<label class="info-label">Category Code</label>
<p class="card-text small text-blue fw-bold"><?php echo $category['ffec_uid']; ?></p>
</div>
</div>
</div>

<div class="card-footer bg-white d-grid gap-1 d-md-flex justify-content-md-end border-0">
<a href="admin/category/edit/<?php echo $category['ffec_uid']?>" class="btn btn-blue btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</a>
<button type="button" id="<?php echo $category['ffec_uid']?>" class="btn btn-red btn-sm btn-del-category-confirm"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Delete</button>
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
<a href="admin/category/delete" type="button" class="btn btn-red btn-del-category">Yes</a>
<button type="button" class="btn btn-blue" data-bs-dismiss="modal">No</button>
</div>
</div>
</div>
</div>

<?php 
include_once(__DIR__."/../../templates/footer.php"); 
ob_end_flush();
?>