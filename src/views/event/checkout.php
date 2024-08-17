<?php
ob_start();
include_once(__DIR__.'/../templates/header.php');
include_once(__DIR__.'/../../models/event_model.php');
include_once(__DIR__.'/../../models/game_model.php');
include_once(__DIR__.'/../../models/category_model.php');
include_once(__DIR__.'/../../models/misc_model.php');
?>

<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Checkout</h1>
</div>
</div>

</div>

<div class="container">

<div class="row">
<div class="col-xx-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger fw-bold text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;All sales are final. No refunds.</div>
</div>
</div>

<div class="row justify-content-start border-bottom pb-5">

<?php
if(
isset($_SESSION['bccc_event_game']) && 
is_array($_SESSION['bccc_event_game']) && 
count($_SESSION['bccc_event_game']) > 0
):
$eventModel = new EventModel();
$gameModel = new GameModel();
$categoryModel = new CategoryModel();
$miscModel = new MiscModel();

$tax_rate = ($miscModel->getTaxRate())['ffc_value'];
$subtotal_price = 0.0;
$tax = 0.0;
$shipping = 0.0;

foreach($_SESSION['bccc_event_game'] as $event_game):
$eventGameInfo= $eventModel->getEventGameByUID($event_game['eventGameUID']);
$eventInfo = $eventModel->getEventByUID($eventGameInfo['ffeg_event_uid']);
$gameInfo = $gameModel->getGameByUID($eventGameInfo['ffeg_game_uid']);
$categoryInfo = $categoryModel->getCategoryByUID($eventGameInfo['ffeg_category_uid']);
if($eventGameInfo['ffeg_availability'] == 1):
?>
<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12 my-3 d-flex align-items-stretch">
<div class="card feature-card bg-white shadow-sm border border-2 pb-3">

<?php if(is_file("public/assets/images/game/" . $gameInfo['ffg_image'])): ?>
<img src="public/assets/images/game/<?php echo $gameInfo['ffg_image']; ?>" class="card-img-top" alt="<?php echo $gameInfo['ffg_name']; ?>">
<?php else: ?>
<img src="public/assets/images/misc/fr_placeholder.png" class="card-img-top" alt="<?php echo $gameInfo['ffg_name']; ?>">
<?php endif ?>

<div class="card-body text-center">
<h5 class="card-title fs-4 text-red fw-bold mb-2"><?php echo $gameInfo['ffg_name']; ?></h5>
<span class="badge bg-warning text-gray fw-bold mb-2"><?php echo $categoryInfo['ffec_name']; ?></span>
<?php if($eventGameInfo['ffeg_game_session'] == 2): ?>
<span class="d-block fs-6 fw-bold text-blue">Additional Play Option</span>
<?php else: ?>
<span class="d-block fs-6 fw-bold text-red"><?php echo date('l', strtotime($eventGameInfo['ffeg_game_date'])); ?></span>
<span class="d-block fs-6 fw-bold text-blue"><?php echo date('F jS, Y', strtotime($eventGameInfo['ffeg_game_date'])); ?></span>
<?php endif; ?>
<p class="card-text fw-bold my-3">
<span class="d-block fs-5 text-red">&dollar;<?php echo $event_game['eventGamePrice']; ?></span>
<span class="d-block fs-6 text-blue"><?php echo $event_game['eventGameSlots']; ?>&nbsp;<?php echo $categoryInfo['ffec_name']; ?>
</span>
</p>

<div class="d-grid gap-2 justify-content-sm-center">
<button type="button" id="<?php echo $event_game['eventGameUID']; ?>" class="btn btn-red btn-sm-block btn-del-event-list-confirm"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Remove</button>
</div>

</div>

</div>
</div>

<?php
$tax += ($tax_rate/100) * $event_game['eventGameSlots'];
$subtotal_price += ($event_game['eventGamePrice']) * ($event_game['eventGameSlots']);
endif;
endforeach;
else:
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;No items found in your cart</div>
</div>
<?php
endif;
?>


</div>

<?php

if(
isset($_SESSION['bccc_event_game']) && 
is_array($_SESSION['bccc_event_game']) && 
count($_SESSION['bccc_event_game']) > 0
):

?>

<div class="row">
<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 py-3">

<h5 class="text-blue fw-bold my-3">Participant Information</h5>

<?php
if(isset($_SESSION['bccc_event_participant']) && !empty($_SESSION['bccc_event_participant']) && is_array($_SESSION['bccc_event_participant'])):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
<ul class="list-group shadow-sm">
<li class="list-group-item">
<p class="text-blue small fw-bold mb-0">Name</p>
<p class="text-red fw-bold mb-0"><?php echo $_SESSION['bccc_event_participant']['eventParticipantFirstName'] . ' ' . $_SESSION['bccc_event_participant']['eventParticipantLastName']; ?></p>
</li>
<li class="list-group-item">
<p class="text-blue small fw-bold mb-0">Email</p>
<p class="text-red fw-bold mb-0"><?php echo $_SESSION['bccc_event_participant']['eventParticipantEmail']; ?></p>
</li>
<li class="list-group-item">
<p class="text-blue small fw-bold mb-0">Phone</p>
<p class="text-red fw-bold mb-0"><?php echo $_SESSION['bccc_event_participant']['eventParticipantPhoneCode'] . $_SESSION['bccc_event_participant']['eventParticipantPhoneNumber']; ?></p>
</li>
<li class="list-group-item">
<p class="text-blue small fw-bold mb-0">Zip Code</p>
<p class="text-red fw-bold mb-0">
<?php echo $_SESSION['bccc_event_participant']['eventParticipantZip']; ?>
</p>
</li>
<li class="list-group-item">
<div class="d-grid gap-2 justify-content-end">
<a href="event/participant" class="btn btn-red"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Update</a>
</div>
</li>
</ul>
<?php
else:
?>
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Event participant information not found</div>
<?php
endif;
?>

</div>
</div>

<?php
else:
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Add items to cart to proceed to checkout</div>
</div>

<?php
endif;
?>

<?php

if(
isset($_SESSION['bccc_event_game']) && 
is_array($_SESSION['bccc_event_game']) && 
count($_SESSION['bccc_event_game']) > 0
):

//Calculate Tax and Shipping Rate

//Tax included in each item

$total_price = $subtotal_price;
?>

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<h5 class="text-red fw-bold my-3">Billing Information</h5>

<ul class="list-group shadow-sm">
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Sub Total
<span class="d-block small text-muted fw-normal">*Inclusive of all taxes</span></p>
<p class="text-red text-end fw-bold mb-0">&dollar;<?php echo number_format($subtotal_price, 2, ".", ""); ?></p>
</li>
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Tax
<span class="d-block small text-muted fw-normal">Calculated per item and included to Sub Total.</span></p>
<p class="text-red text-end fw-bold mb-0">&dollar;<?php echo number_format($tax, 2, ".", ""); ?></p>
</li>
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Total</p>
<p class="fs-4 text-red text-end fw-bold mb-0">&dollar;<?php echo number_format($total_price, 2, ".", ""); ?></p>
</li>
</ul>

</div>
</div>

<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 mt-3 pt-5 border-top">
<h2 class="fs-2 text-blue text-center text-capitalize fw-bold mb-3">Ready to Checkout?</h2>
<form id="eventCheckoutForm" name="eventCheckoutForm" action="event/checkout" method="POST">
<div class="d-grid gap-2 justify-content-center">

<input type="hidden" value="<?php echo $subtotal_price; ?>" name="eventCheckoutSubtotal" id="eventCheckoutSubtotal" />
<input type="hidden" value="<?php echo $tax; ?>" name="eventCheckoutTax" id="eventCheckoutTax" />
<input type="hidden" value="<?php echo $shipping; ?>" name="eventCheckoutShipping" id="eventCheckoutShipping" />
<input type="hidden" value="<?php echo $total_price; ?>" name="eventCheckoutTotal" id="eventCheckoutTotal" />

<input type="submit" name="eventCheckoutSubmit" id="eventCheckoutSubmit" class="btn btn-red btn-lg btn-sm-block" value="Checkout" />
</div>
</form>

<label id="eventCheckoutError"></label>

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
<p class="text-red fw-bold mb-0">Confirm remove selected?</p>
</div>
<div class="modal-footer">
<a href="event/remove" type="button" class="btn btn-red btn-del-event-list">Yes</a>
<button type="button" class="btn btn-blue" data-bs-dismiss="modal">No</button>
</div>
</div>
</div>
</div>

<?php 
include_once(__DIR__."/../templates/footer.php"); 
ob_end_flush();
?>