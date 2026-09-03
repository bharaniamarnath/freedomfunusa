<?php
ob_start();
include_once(__DIR__.'/../../../../application/sessions.php');
include_once(__DIR__."/../../../../models/game_model.php");
include_once(__DIR__."/../../../../models/event_model.php");
include_once(__DIR__."/../../../../models/category_model.php");
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
            <li class="breadcrumb-item"><a href="admin/event/edit/<?php echo $event_id; ?>">Event</a></li>
            <li class="breadcrumb-item active" aria-current="page">Game</li>
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
$gameModel = new GameModel();
$categoryModel = new CategoryModel();
$eventInfo = $eventModel->getEventByUID($event_id);
?>

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

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-2">

<h3 class="text-red fw-bold">Add Event Game</h3>

<form name="eventGameRegisterForm" id="eventGameRegisterForm" action="admin/event/game/register" method="POST">

<div class="from-group my-0">
<label class="form-label required-field" for="eventGameName">Game Type</label>
</div>

<div class="input-group mb-0">
<select class="form-select" name="eventGameName" id="eventGameName" aria-label="Select Game">
<optgroup>
<option value="" selected>Select Game</option>
<?php
$allGamesSearch = array();
$allGamesSort = array("sortField" => "ffg_created_date", "sortOrder" => "DESC");
$allGamesLimit = array();
$allGames = $gameModel->getAllGames($allGamesSearch, $allGamesSort, $allGamesLimit);
foreach($allGames as $game):
?>
<option value="<?php echo $game["ffg_uid"]; ?>"><?php echo $game["ffg_name"]; ?></option>
<?php
endforeach;
?>
</optgroup>
</select>
</div>
<label id="eventGameName"></label>

<div class="from-group my-0">
<label class="form-label required-field" for="eventGameCategory">Game Category</label>
</div>

<div class="input-group mb-0">
<select class="form-select" name="eventGameCategory" id="eventGameCategory" aria-label="Select Category">
<optgroup>
<option value="" selected>Select Category</option>
<?php
$allEventCategories = $categoryModel->getCategoriesByEventUID($eventInfo['ffe_uid']);
foreach($allEventCategories as $category):
?>
<option value="<?php echo $category["ffec_uid"]; ?>"><?php echo $category["ffec_name"]; ?></option>
<?php
endforeach;
?>
</optgroup>
</select>
</div>
<label id="eventGameCategoryError"></label>

<?php
$eventModel = new EventModel();
$eventInfo = $eventModel->getEventByUID($event_id);
?>

<input type="hidden" name="eventGameEventStartDate" id="eventGameEventStartDate" value="<?php echo $eventInfo['ffe_start_date']; ?>" />
<input type="hidden" name="eventGameEventEndDate" id="eventGameEventEndDate" value="<?php echo $eventInfo['ffe_end_date']; ?>" />

<div class='form-group my-3'>
<label class='form-label required-field' for='eventGameDate'>Game Date</label>
<input class='form-control' type="text" name="eventGameDate" id="eventGameDate" required>
</div>

<div class='form-group mt-3'>
<label class='form-label required-field' for='eventGameDuration'>Game Duration</label>
</div>
<div class="input-group mb-0">
<input type='number' class='form-control' id='eventGameDuration' name='eventGameDuration' placeholder='Game Duration' max="60" min="5" step="1">
<span class="input-group-text">Minutes</span>
</div>
<div class="mb-3">
<label class="d-block my-0" id='eventGameDurationError'></label>
</div>

<div class='form-group my-3'>
<label class='form-label required-field' for='eventGameSession'>Game Session</label>
<select class="form-select" name="eventGameSession" id="eventGameSession">
<option value="">Select Session</option>
<option value="1">Single Day</option>
<option value="2">All Days</option>
</select>
</div>

<div class='form-group my-3'>
<label class='form-label required-field' for='eventGameAvailability'>Game Availability</label>
<select class="form-select" name="eventGameAvailability" id="eventGameAvailability">
<option value="">Select Availability</option>
<option value="1">Available</option>
<option value="2">Unavailable</option>
</select>
</div>

<div class="form-group pb-3">
<label for="eventGameSlots" class="form-label required-field">Game Slots</label>
<input type='number' class='form-control' id='eventGameSlots' name='eventGameSlots' placeholder='Game Slots' max="9999" min="1" step="1">
</div>

<div class="form-group pb-3">
<label for="eventGameDescription" class="form-label required-field">Game Description</label>
<textarea name="eventGameDescription" id="eventGameDescription" class="form-control" row="3" required></textarea>
</div>

<input type="hidden" name="eventGameEvent" id="eventGameEvent" value="<?php echo $event_id; ?>" />

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="eventGameRegisterSubmit" id="eventGameRegisterSubmit" class="btn btn-red btn-lg" value="Register" />
</div>
</form>

</div>
</div>
</div>

<?php
endif;
?>

</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../../../templates/modal.php");  ?>

<?php 
include_once(__DIR__."/../../../templates/footer.php"); 
ob_end_flush();
?>