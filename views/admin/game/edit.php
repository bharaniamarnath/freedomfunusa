<?php
ob_start();
include_once(__DIR__.'/../../../application/sessions.php');
include_once(__DIR__.'/../../../models/category_model.php');
include_once(__DIR__.'/../../../models/game_model.php');
include_once(__DIR__."/../../../models/content_model.php");
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
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Game</h1>
        </div>
    </div>

</div>

<div class="container">

    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="admin/manage">Manage</a></li>
            <li class="breadcrumb-item"><a href="admin/game/list">Games</a></li>
            <li class="breadcrumb-item active" aria-current="page">Game</li>
        </ol>
    </nav>

<div class="row">

<?php if(!isset($game_id) && $game_id == null && $game_id == ''): ?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get game ID</div>
</div>
<?php 
else:
$gameModel = new GameModel();
$methodsModel = new MethodsModel();
$contentModel = new ContentModel();
$gameInfo = $gameModel->getGameByUID($game_id);
if(empty($gameInfo) || !is_array($gameInfo)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get game information.</div>
</div>
<?php
else:
?>
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<img src="public/assets/images/game/<?php echo $gameInfo['ffg_image'].'?v='.uniqid(); ?>" class="img-fluid border border-1" alt="<?php echo $gameInfo['ffg_name']; ?>" />


<!-- Display Class Info -->
<ul class="list-group mt-3">

<li class="list-group-item">
<label class="info-label">Game Name</label>
<p class="text-gray fs-6 fw-bold mb-0"><?php echo $gameInfo['ffg_name']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Game ID</label>
<p class="text-gray fs-6 mb-0"><?php echo $gameInfo['ffg_uid']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Registered Date</label>
<p class="text-gray fs-6 mb-0"><?php echo date('F jS, Y', strtotime($gameInfo['ffg_created_date'])); ?></p>
</li>

</ul>
</div>

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 py-2">

<h1 class="fs-3 fw-bold text-red">Edit Game</h1>

<form name="gameEditForm" id="gameEditForm" action="admin/game/edit" method="POST">

<div class="form-group pb-3">
<label for="gameName" class="form-label required-field">Game Name</label>
<input type="text" name="gameName" id="gameName" class="form-control" value="<?php echo $gameInfo['ffg_name']; ?>" required />
</div>

<div class="form-group">
<label for="gamePrice" class="form-label required-field">Game Price</label>
</div>

<div class="input-group">
<div class="input-group-prepend">
<span class="input-group-text">$</span>
</div>
<input type="text" name="gamePrice" id="gamePrice" class="form-control" value="<?php echo number_format($gameInfo['ffg_price'], 2, '.', ','); ?>" required />
</div>
<label class="mb-3" id="gamePriceError"></label>

<div class="form-group pb-3">
<label for="gameDescription" class="form-label required-field">Game Description</label>
<textarea name="gameDescription" id="gameDescription" class="form-control" required><?php echo $gameInfo['ffg_description']; ?></textarea>
</div>

<div class="form-group">
<label for="gameProfileImage" class="form-label">Game Profile Image</label>
<input type="file" class="form-control" name="gameProfileImage" id="gameProfileImage" accept="image/png, image/jpeg" />
<small id="gameProfileImage_help" class="form-text text-muted mb-0">Upload a PNG or JPEG format image of ratio 1:1 and minimum of 600px.</small>
</div>

<input type="hidden" value="<?php echo $methodsModel->sanitizeGet($gameInfo['ffg_uid']); ?>" name="gameUID" id="gameUID">

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="gameEditSubmit" id="gameEditSubmit" class="btn btn-red btn-lg" value="Update" />
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