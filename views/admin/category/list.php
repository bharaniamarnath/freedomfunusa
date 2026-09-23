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
            <li class="breadcrumb-item active" aria-current="page">Categories</li>
        </ol>
    </nav>

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
<div class="card h-100 shadow-sm p-3">
<div class="row g-0">

<div class="col-3">
<?php if(is_file("public/assets/images/category/" . $category['ffec_image'])): ?>
<img src="public/assets/images/category/<?php echo $category['ffec_image']; ?>" class="img-thumbnail" alt="<?php echo $category['ffec_name']; ?>">
<?php else: ?>
<img src="public/assets/images/misc/ff_placeholder.png" class="img-thumbnail" alt="<?php echo $category['ffec_name']; ?>">
<?php endif ?>
</div>
<div class="col-9">
<div class="card-body d-flex flex-column">
<h5 class="card-title fs-6 text-red fw-bold"><?php echo $category['ffec_name']; ?></h5>
<p class="text-gray"><?php echo $category['ffec_uid']; ?></p>
</div>
</div>
</div>

<div class="card-footer bg-white d-grid gap-1 d-md-flex justify-content-md-end border-0">
<a href="admin/category/edit/<?php echo $category['ffec_uid']?>" class="btn btn-blue btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</a>
<button type="button" id="<?php echo $category['ffec_uid']?>" data-link="admin/category/delete" class="btn btn-red btn-sm btn-del-confirm"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Delete</button>
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

<?php include_once(__DIR__."/../../templates/modal.php");  ?>

<!-- Confirm Action Modal -->

<?php include_once(__DIR__."/../../templates/confirm.php");  ?>

<?php 
include_once(__DIR__."/../../templates/footer.php"); 
ob_end_flush();
?>