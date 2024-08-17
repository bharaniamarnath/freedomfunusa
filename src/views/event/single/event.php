<?php
ob_start();
include_once(__DIR__.'/../../../models/event_model.php');
include_once(__DIR__.'/../../../models/game_model.php');
include_once(__DIR__.'/../../../models/category_model.php');
include_once(__DIR__."/../../../models/misc_model.php");
include_once(__DIR__."/../../../models/methods_model.php");
?>

<?php
include_once(__DIR__.'/../../templates/header.php');
?>

<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Event</h1>
</div>
</div>

</div>

<!-- Promotion Banner Begin -->

<div class="container-fluid">
<div class="row justify-content-center">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 p-0">
<a href="<?php echo $aboutJSONEnc['Organisation']['website']; ?>" target=”_blank” class="text-decoration-none">
<img src="public/assets/images/features/ff_promotion_banner.png" class="img-fluid d-block mx-auto w-100" alt="<?php echo $aboutJSONEnc['EventHeading']; ?>" loading="lazy">
</a>
</div>
</div>
</div>

<!-- Promotion Banner End -->

<div class="container mt-5">


<?php if(!isset($event_id) && $event_id == null && $event_id == ''): ?>
<div class="row justify-content-center">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get event information.</div>
</div>
<?php 
else:
$eventModel = new EventModel();
$categoryModel = new CategoryModel();
$methodsModel = new MethodsModel();

$eventInfo = $eventModel->getEventByUID($event_id);
if(empty($eventInfo) || !is_array($eventInfo)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get event information.</div>
</div>
</div>
<?php
else:
?>

<div class="row justify-content-center">
<?php
$eventModel = new EventModel();
$allEventGames = $eventModel->getEventGamesByEventUID($event_id);
if(!$allEventGames || !is_array($allEventGames)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;No event games found in the record.</div>
</div>
<?php
else:
foreach($allEventGames as $eventGameItem):
$gameModel = new GameModel();
$categoryModel = new CategoryModel();
$gameInfo = $gameModel->getGameByUID($eventGameItem['ffeg_game_uid']);
$categoryInfo = $categoryModel->getCategoryByUID($eventGameItem['ffeg_category_uid']);
if($eventGameItem['ffeg_availability'] == 1):
?>



<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 my-3 d-flex align-items-stretch">
<div class="card feature-card bg-white shadow-sm border border-2 pb-3">
<?php if(is_file("public/assets/images/game/" . $gameInfo['ffg_image'])) : ?>
<img src="public/assets/images/game/<?php echo $gameInfo['ffg_image']; ?>" class="card-img-top" alt="<?php echo $gameInfo['ffg_name']; ?>">
<?php else: ?>
<img src="public/assets/images/misc/ff_placeholder.png" class="card-img-top" alt="<?php echo $gameInfo['ffg_name']; ?>">
<?php endif ?>
<div class="card-body text-center">
<h5 class="card-title text-red fw-bold text-uppercase"><?php echo $gameInfo['ffg_name']; ?></h5>
<p class="card-text">
<span class="badge bg-warning text-gray fw-bold mb-2"><?php echo $categoryInfo['ffec_name']; ?></span>
<?php if($eventGameItem['ffeg_game_session'] == 2): ?>
<span class="d-block fs-6 fw-bold text-blue">Additional Play Option</span>
<?php else: ?>
<span class="d-block fs-6 fw-bold text-red"><?php echo date('l', strtotime($eventGameItem['ffeg_game_date'])); ?></span>
<span class="d-block fs-6 fw-bold text-blue"><?php echo date('F jS, Y', strtotime($eventGameItem['ffeg_game_date'])); ?></span>
<?php endif; ?>
<span class="d-block fs-5 fw-bold text-red mt-2">&dollar;<?php echo number_format($gameInfo['ffg_price'], 2, '.', ','); ?></span>
</p>

<div class="d-grid gap-2 justify-content-sm-center">
<?php $categoryPath = 'event/game/view/'; ?>
<?php if($eventGameItem['ffeg_slots'] > 1): ?>
<a href="<?php echo $categoryPath . $eventGameItem['ffeg_uid']; ?>" class="btn btn-red btn-lg btn-sm-block">Buy Now&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
<?php else: ?>
<a href="<?php echo $categoryPath . $eventGameItem['ffeg_uid']; ?>" class="btn btn-red btn-lg btn-sm-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Slots Unavailable</a>
<?php endif; ?>
</div>

</div>
</div>
</div>


<?php
endif;
endforeach;
endif;
?>
</div>

<?php
endif;
endif;
?>

</div>

<!-- Event Gallery Begin -->

<div class="container">
<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 bg-warning px-5 py-3 mt-5 mb-0">
<h2 class="fs-2 text-grey text-center text-uppercase fw-bold mb-0">Play these games &amp; more with your tokens &amp; Wristbands!</h2>
</div>
</div>
</div>

<?php
$eventGameGallery = array(
array("trackless_train.png", "Trackless Train", "bg-red"),
array("snow_globe.png", "Snow Globe", "bg-blue"),
array("4g.png", "4G", "bg-red"),
array("mechanical_bull.png", "Mechanical Bull", "bg-blue"),
array("rockwall.png", "Rock Wall", "bg-red"),
array("laser_tag.png", "Laser Tag", "bg-blue"),
array("petting_zoo.png", "Petting Zoo", "bg-red"),
array("pony_ride.png", "Pony Ride", "bg-blue"),
);
?>

<div class="container mt-5">
<div class="row">

<?php for($egg = 0; $egg < count($eventGameGallery); $egg++): ?>

<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 my-3 d-flex align-items-stretch">
<div class="card feature-card bg-white shadow-sm border border-2">
<img src="public/assets/images/features/games/<?php echo $eventGameGallery[$egg][0]; ?>" class="card-img-top" alt="<?php echo $eventGameGallery[$egg][1]; ?>">
<div class="card-body text-center <?php echo $eventGameGallery[$egg][2]; ?>">
<h5 class="card-title text-white fw-bold text-uppercase"><?php echo $eventGameGallery[$egg][1]; ?></h5>
</div>
</div>
</div>

<?php endfor; ?>

</div>
</div>

<!-- Event Gallery End -->

<div class="container-fluid">
<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 mt-0 pt-5 border-top">
<h2 class="fs-2 text-blue text-center text-capitalize fw-bold mb-3">View <?php echo $aboutJSONEnc['EventHeading']; ?> schedule</h2>
<h2 class="fs-2 text-blue text-center text-uppercase fw-bold text-responsive-d3 mt-0"><a class="btn btn-lg btn-red" href="about">View Schedule&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a></h2>
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
include_once(__DIR__."/../../templates/footer.php"); 
ob_end_flush();
?>