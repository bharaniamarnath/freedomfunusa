<?php
ob_start();
include_once(__DIR__.'/../../../../application/sessions.php');
include_once(__DIR__."/../../../../models/event_model.php");
include_once(__DIR__."/../../../../models/game_model.php");
include_once(__DIR__."/../../../../models/category_model.php");
include_once(__DIR__."/../../../../models/content_model.php");
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
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Order</h1>
</div>
</div>

</div>

<div class="container">


<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<h1 class="fs-3 fw-bold text-red">Participant Games</h1>
</div>
</div>

<div class="row">
<?php
if(!isset($event_id) || strlen(trim($event_id)) == 0):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Unable to get Event ID <?php echo $event_id; ?></div>
</div>

<?php
else:
$eventModel = new EventModel();
$participantGames = $eventModel->getparticipantGameByOrderID($event_id);
if(!$participantGames || !is_array($participantGames)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Participant games information not found in the record.</div>
</div>
<?php
else:
foreach($participantGames as $participantGame):
$eventGameInfo = $eventModel->getEventGameByUID($participantGame['ffpg_event_game']);
$gameModel = new GameModel();
$gameInfo = $gameModel->getGameByUID($eventGameInfo['ffeg_game_uid']);
$eventInfo = $eventModel->getEventByUID($eventGameInfo['ffeg_event_uid']);
?>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<div class="card h-100 shadow-sm">
<div class="row g-0 p-1">

<div class="col-3">
<?php if(is_file("public/assets/images/game/" . $gameInfo['ffg_image'])): ?>
<img src="public/assets/images/game/<?php echo $gameInfo['ffg_image']; ?>" class="img-fluid" alt="<?php echo $gameInfo['ffg_name']; ?>">
<?php else: ?>
<img src="public/assets/images/misc/ff_placeholder.png" class="img-fluid" alt="<?php echo $gameInfo['ffg_name']; ?>">
<?php endif ?>
</div>
<div class="col-9">
<div class="card-body d-flex flex-column">
<label class="info-label">Ticket ID</label>
<p class="card-text fs-6 text-red fw-bold mb-1"><?php echo $participantGame['ffpg_uid']; ?></p>
<label class="info-label">Game</label>
<p class="card-text fs-6 text-blue fw-bold mb-1"><?php echo $gameInfo['ffg_name']; ?></p>
<label class="info-label">Event</label>
<p class="card-text small text-blue fw-bold mb-0"><?php echo $eventInfo['ffe_name']; ?></p>
<label class="info-label">Game Price</label>
<p class="card-text small text-blue fw-bold mb-1">&dollar;<?php echo number_format($participantGame['ffpg_event_price'], 2, '.', ','); ?></p>
</div>
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
<?php

if(!$participantGames || !is_array($participantGames)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-warning text-gray"><i class="fa fa-exclamation-circle"></i>&nbsp;No participant games found in records for checkin.</div>
</div>
<?php
else:

$eventModel = new EventModel();
$eventOrderInfo = $eventModel->getEventOrderByOrderID($event_id);
$eventOrderID = $eventOrderInfo['ffeo_order_id'];
if(count($participantGames) == $eventModel->getTotalCheckedIn($eventOrderID, 1)):
$eventCheckinInfo = $eventModel->getEventCheckinInfo($eventOrderID);
?>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<div class="card h-100 shadow-sm">
<div class="card-body d-flex flex-column">
<label class="info-label">Check In Status</label>
<p class="card-title fs-5 text-red fw-bold mb-1"><?php echo ($eventCheckinInfo['ffpg_checkin_status'] == 1) ? 'Checked In' : 'Not Checked In'; ?></p>
<label class="info-label">Check In Time</label>
<p class="card-title fs-6 text-blue fw-bold mb-0"><?php echo date('F jS, Y H:i A', strtotime($eventCheckinInfo['ffpg_checkin_time'])); ?></p>
</p>
</div>
</div>
</div>


<?php
else:
?>

<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">

<form id="eventCheckinForm" name="eventCheckinForm" action="admin/event/checkin" method="POST">
<div class="d-grid gap-2 py-3 justify-content-end">

<input type="hidden" value="<?php echo $eventOrderID; ?>" name="eventCheckinOrderID" id="eventCheckinOrderID" />

<input type="submit" name="eventCheckinSubmit" id="eventCheckinSubmit" class="btn btn-red btn-lg" value="Checkin" />
</div>
</form>

</div>

<?php
endif;
endif;
?>

</div>


<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 pt-5 mt-3 border-top">
<h1 class="fs-3 fw-bold text-red">Event Participant</h1>
</div>
</div>


<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<?php
$eventModel = new EventModel();
$eventParticipant = $eventModel->getEventParticipantByOrderID($event_id);
if(!$eventParticipant || empty($eventParticipant)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Event order information not found in the record.</div>
</div>
<?php else: ?>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<div class="card h-100 shadow-sm">
<div class="card-body d-flex flex-column">
<label class="info-label">Participant Name</label>
<p class="card-title fs-5 text-red fw-bold mb-1"><?php echo $eventParticipant['ffep_first_name'] . ' ' . $eventParticipant['ffep_last_name']; ?></p>
<label class="info-label">Participant ID</label>
<p class="card-title fs-6 text-blue fw-bold mb-0"><?php echo $eventParticipant['ffep_uid']; ?></p>
<label class="info-label mt-3">Email</label>
<p class="card-text small text-blue fw-bold mb-0"><?php echo $eventParticipant['ffep_email']; ?></p>
<label class="info-label">Phone</label>
<p class="card-text small text-red fw-bold mb-0"><?php echo $eventParticipant['ffep_phone']; ?></p>
<label class="info-label mt-3">Zip Code</label>
<p class="card-text small text-blue fw-bold mb-0"><?php echo $eventParticipant['ffep_zip']; ?></p>
</p>
</div>
</div>
</div>

<?php endif; ?>
</div>
</div>


<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 pt-5 mt-3 border-top">
<h1 class="fs-3 fw-bold text-red">Event Order</h1>
</div>
</div>


<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<?php
$eventModel = new EventModel();
$eventOrder = $eventModel->getEventOrderByOrderID($event_id);
if(!$eventOrder || empty($eventOrder)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Event order information not found in the record.</div>
</div>
<?php 
else:
$contentModel = new ContentModel();
?>
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<div class="card h-100 shadow-sm">
<div class="card-body d-flex flex-column">
<ul class="list-group list-group-flush">
<li class="list-group-item">
<label class="info-label">Order ID</label>
<p class="card-title fs-5 text-red fw-bold"><?php echo $eventOrder['ffeo_order_id']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Order Total</label>
<p class="card-title fs-5 text-red text-end fw-bold mb-1">&dollar;<?php echo number_format($eventOrder['ffeo_total_amt'], 2, '.', ','); ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Order Subtotal</label>
<p class="card-title fs-6 text-blue text-end fw-bold mb-0">&dollar;<?php echo number_format($eventOrder['ffeo_subtotal_amt'], 2, '.', ','); ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Tax</label>
<p class="card-title fs-6 text-blue text-end fw-bold mb-0">&dollar;<?php echo number_format($eventOrder['ffeo_tax'], 2, '.', ','); ?></p>
</li>
</ul>
<hr class="hr">
<label class="info-label mt-3">Order Date</label>
<p class="card-title text-red fw-bold mb-3"><?php echo date('F jS Y, H:i:s', strtotime($eventOrder['ffeo_order_date'])); ?></p>
<label class="info-label">Payment Method</label>
<p class="card-text small text-blue fw-bold mb-1"><?php echo $contentModel->paymentMethodType($eventOrder['ffeo_payment_method']); ?></p>
<label class="info-label">Payment Status</label>
<p class="card-text small text-red fw-bold mb-3"><?php echo $contentModel->paymentStatusMessage($eventOrder['ffeo_payment_status']); ?></p>
<label class="info-label">Transaction ID</label>
<p class="card-title small text-blue fw-bold mb-1"><?php echo $eventOrder['ffeo_transaction_id']; ?></p>
<label class="info-label">Transaction Response</label>
<p class="card-text small text-blue fw-bold mb-0"><?php echo $contentModel->paymentResponseMessage($eventOrder['ffeo_response_code']); ?></p>
</div>
</div>
</div>

<?php endif; ?>
</div>
</div>


<?php endif; ?>
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