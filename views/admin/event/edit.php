<?php
ob_start();
include_once(__DIR__.'/../../../application/sessions.php');
include_once(__DIR__.'/../../../models/category_model.php');
include_once(__DIR__.'/../../../models/event_model.php');
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
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Event</h1>
        </div>
    </div>

</div>

<div class="container">

    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="admin/manage">Manage</a></li>
            <li class="breadcrumb-item"><a href="admin/event/list">Events</a></li>
            <li class="breadcrumb-item active" aria-current="page">Event</li>
        </ol>
    </nav>

<div class="row">

<?php if(!isset($event_id) && $event_id == null && $event_id == ''): ?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get event ID</div>
</div>
<?php 
else:
$eventModel = new EventModel();
$methodsModel = new MethodsModel();
$categoryModel = new CategoryModel();
$contentModel = new ContentModel();
$eventInfo = $eventModel->getEventByUID($event_id);
if(empty($eventInfo) || !is_array($eventInfo)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get event information.</div>
</div>
<?php else: ?>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<img src="public/assets/images/event/<?php echo $eventInfo['ffe_image'].'?v='.uniqid(); ?>" class="img-fluid border border-1" alt="<?php echo $eventInfo['ffe_name']; ?>" />
<!-- Display Class Info -->
<ul class="list-group mt-3">
<li class="list-group-item">
<label class="info-label">Event Name</label>
<p class="text-gray fs-6 fw-bold mb-0"><?php echo $eventInfo['ffe_name']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Event ID</label>
<p class="text-gray fs-6 mb-0"><?php echo $eventInfo['ffe_uid']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Registered Date</label>
<p class="text-gray fs-6 mb-0"><?php echo date('F jS, Y', strtotime($eventInfo['ffe_created_date'])); ?></p>
</li>
</ul>
</div>

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 py-2">

<h1 class="fs-3 fw-bold text-red mb-4">Edit Event</h1>

<form name="eventEditForm" id="eventEditForm" action="admin/event/edit" method="POST">

<div class="form-group pb-3">
<label for="eventName" class="form-label required-field">Event Name</label>
<input type="text" name="eventName" id="eventName" class="form-control" value="<?php echo $eventInfo['ffe_name']; ?>" required />
</div>

<div class='form-group my-3'>
<label class='form-label' for='eventStartDate'>Event Start Date</label>
<input class='form-control' type="text" name="eventStartDate" id="eventStartDate" value="<?php echo date('Y-m-d', strtotime($eventInfo['ffe_start_date'])); ?>" required>
</div>

<div class='form-group my-3'>
<label class='form-label' for='eventEndDate'>Event End Date</label>
<input class='form-control' type="text" name="eventEndDate" id="eventEndDate" value="<?php echo date('Y-m-d', strtotime($eventInfo['ffe_end_date'])); ?>" required>
</div>


<div class="form-group pb-3">
<label for="eventDescription" class="form-label required-field">Event Description</label>
<textarea name="eventDescription" id="eventDescription" class="form-control" required><?php echo $eventInfo['ffe_description']; ?></textarea>
</div>

<div class="form-group">
<label for="eventProfileImage" class="form-label">Event Profile Image</label>
<input type="file" class="form-control" name="eventProfileImage" id="eventProfileImage" accept="image/png, image/jpeg" />
<small id="eventProfileImage_help" class="form-text text-muted mb-0">Upload a PNG or JPEG format image of ratio 1:1 and minimum of 600px.</small>
</div>

<input type="hidden" value="<?php echo $methodsModel->sanitizeGet($eventInfo['ffe_uid']); ?>" name="eventUID" id="eventUID">

<div class="d-grid gap-2 d-sm-block d-md-flex justify-content-md-end py-3">
<input type="submit" name="eventEditSubmit" id="eventEditSubmit" class="btn btn-red btn-lg" value="Update" />
</div>
</form>

</div>

</div>

<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<h1 class="fs-2 fw-bold text-red mb-4">Event Games</h1>
<a href="admin/event/<?php echo $event_id; ?>/game/register/" class="btn btn-blue btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Register Game</a>
</div>
</div>

<div class="row">
<?php
$eventModel = new EventModel();
$alleventGames = $eventModel->getEventGamesByEventUID($event_id);
if(!$alleventGames || !is_array($alleventGames)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;No event games found in the record.</div>
</div>
<?php
else:
foreach($alleventGames as $eventGameItem):
$gameModel = new GameModel();
$gameInfo = $gameModel->getGameByUID($eventGameItem['ffeg_game_uid']);
$eventInfo = $eventModel->getEventByUID($eventGameItem['ffeg_event_uid']);
?>
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<div class="card h-100 shadow-sm p-3">
<div class="row g-0">

<div class="col-3">
<?php if(is_file("public/assets/images/game/" . $gameInfo['ffg_image'])): ?>
<img src="public/assets/images/game/<?php echo $gameInfo['ffg_image']; ?>" class="img-thumbnail" alt="<?php echo $gameInfo['ffg_name']; ?>">
<?php else: ?>
<img src="public/assets/images/misc/ff_placeholder.png" class="img-thumbnail" alt="<?php echo $gameInfo['ffg_name']; ?>">
<?php endif ?>
</div>
<div class="col-9">
<div class="card-body d-flex flex-column">
<p class="card-title fs-5 text-red fw-bold mb-0"><?php echo $gameInfo['ffg_name']; ?></p>
<p class="card-text text-blue fw-bold mb-0">&dollar;<?php echo number_format($gameInfo['ffg_price'], 2, '.', ','); ?></p>
<p class="card-text small text-gray"><?php echo date('F jS, Y', strtotime($eventGameItem['ffeg_game_date'])); ?></p>
</div>
</div>
</div>

<div class="card-footer bg-white d-grid gap-1 d-md-flex justify-content-md-end border-0">
<a href="admin/event/<?php echo $eventGameItem['ffeg_event_uid']; ?>/game/edit/<?php echo $eventGameItem['ffeg_uid']; ?>" class="btn btn-blue btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</a>
<button type="button" id="<?php echo $eventGameItem['ffeg_uid']?>" data-link="admin/event/game/delete" class="btn btn-red btn-sm btn-del-confirm"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Delete</button>
</div>
</div>
</div>

<?php
endforeach;
endif;
?>
</div>

</div>



<?php
endif;
endif;
?>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../../templates/modal.php");  ?>

<!-- Confirm Action Modal -->
<?php include_once(__DIR__."/../../templates/confirm.php");  ?>

<?php 
include_once(__DIR__."/../../templates/footer.php"); 
ob_end_flush();
?>