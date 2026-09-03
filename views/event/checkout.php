<?php
ob_start();
include_once(__DIR__.'/../templates/header.php');
include_once(__DIR__.'/../../models/event_model.php');
include_once(__DIR__.'/../../models/game_model.php');
include_once(__DIR__.'/../../models/participant_model.php');
include_once(__DIR__.'/../../models/category_model.php');
include_once(__DIR__.'/../../models/misc_model.php');
?>

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Checkout</h1>
        </div>
    </div>

</div>

<div class="container">

<div class="row justify-content-start">

<?php
if(
isset($_SESSION['bccc_event_game']) && 
is_array($_SESSION['bccc_event_game']) && 
count($_SESSION['bccc_event_game']) > 0
):

$eventModel = new EventModel();
$gameModel = new GameModel();
$participantModel = new ParticipantModel();
$categoryModel = new CategoryModel();
$miscModel = new MiscModel();

$taxRate = ($miscModel->getTaxRate())['ffc_value'];
$taxAmount = 0;
$discountAmount = 0;
$subtotalAmount = 0;
$totalAmount = 0;
$shipping = 0;

?>

<div class="col-xx-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger fw-bold text-red"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;All sales are final. No refunds.</div>
</div>

<?php

foreach($_SESSION['bccc_event_game'] as $event_game):
$eventGameInfo= $eventModel->getEventGameByUID($event_game['eventGameUID']);
$eventInfo = $eventModel->getEventByUID($eventGameInfo['ffeg_event_uid']);
$gameInfo = $gameModel->getGameByUID($eventGameInfo['ffeg_game_uid']);
$categoryInfo = $categoryModel->getCategoryByUID($eventGameInfo['ffeg_category_uid']);
if($eventGameInfo['ffeg_availability'] == 1):

$subtotalPerItem = ($event_game['eventGamePrice'] * $event_game['eventGameSlots']);
$taxAmount += ($taxRate / 100) * $event_game['eventGameSlots'];
$subtotalAmount += $subtotalPerItem;
?>

    <div class="row d-flex align-items-center gy-2 pb-3 border-bottom">
        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-4 col-sm-4 col-4">
            <a class="text-decoration-none" href="event/game/view/<?php echo $event_game['eventGameUID']; ?>">
                <img class="img-thumbnail h-100" src="public/assets/images/game/<?php echo $gameInfo['ffg_image']; ?>" alt="<?php echo $gameInfo['ffg_name']; ?>">
            </a>
        </div>
        <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-4 col-sm-4 col-4">
            <p class="fs-5 text-red fw-bold mb-0"><?php echo $gameInfo['ffg_name']; ?></p>
            <p class="text-gray mb-0"><?php echo $categoryInfo['ffec_name']; ?></p>
        </div>
        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-4 col-sm-4 col-4">
            <p class="fs-6 text-gray fw-bold mb-0">&dollar;<?php echo number_format($event_game['eventGamePrice'], 2, '.', ','); ?></p>
        </div>
        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-4 col-sm-4 col-4">
            <p class="fs-6 text-blue fw-bold mb-0">	&#215;&nbsp;<?php echo $event_game['eventGameSlots']; ?></p>
        </div>
        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-4 col-sm-4 col-4">
            <p class="fs-6 text-red fw-bold mb-0">&dollar;<?php echo number_format($subtotalPerItem, 2, '.', ','); ?></p>
        </div>
    </div>

<?php
endif;
endforeach;
?>
</div>

<div class="row">
<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 py-3">

<h5 class="text-red fw-bold my-3">Participant Details</h5>

<?php
if(isset($_SESSION['bccc_event_participant']) && !empty($_SESSION['bccc_event_participant']) && is_array($_SESSION['bccc_event_participant'])):
    $eventParticipantInfo = $participantModel->getEventParticipantByEmailID($_SESSION['bccc_event_participant']['participantLoginEmail']);
    if(!empty($eventParticipantInfo) && is_array($eventParticipantInfo)):
?>
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
<ul class="list-group shadow-sm">
<li class="list-group-item">
<label class="info-label">Name</label>
<p class="text-gray fs-6 mb-0"><?php echo $eventParticipantInfo['ffep_first_name'] . ' ' . $eventParticipantInfo['ffep_last_name']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Email</label>
<p class="text-gray fs-6 mb-0"><?php echo $eventParticipantInfo['ffep_email']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Phone</label>
<p class="text-gray fs-6 mb-0"><?php echo $eventParticipantInfo['ffep_phone']; ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Zip Code</label>
<p class="text-gray fs-6 mb-0"><?php echo $eventParticipantInfo['ffep_zip']; ?></p>
</li>
<li class="list-group-item">
<div class="d-grid gap-2 justify-content-end">
<a href="event/participant" class="btn btn-red"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Update</a>
</div>
</li>
</ul>
<?php else: ?>
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Unable to get event participant information</div>
<?php endif; ?> 
<?php else: ?>
<div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Event participant information not found</div>
<?php endif; ?>

</div>
</div>

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
<h5 class="text-red fw-bold my-3">Billing Details</h5>

<?php
$discountAmount = ($subtotalAmount * 0.10);
$totalAmount = $subtotalAmount - $discountAmount;
?>

<ul class="list-group shadow-sm">
<li class="list-group-item">
<label class="info-label">Subtotal
    <span class="d-block small text-muted">*Inclusive of all taxes</span>
</label>
<p class="text-gray text-end fw-bold mb-0">&dollar;<?php echo number_format($subtotalAmount, 2, ".", ""); ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Tax
    <span class="d-block small text-muted fw-normal">Calculated per item and included to subtotal.</span>
</label>
<p class="text-gray text-end fw-bold mb-0">&dollar;<?php echo number_format($taxAmount, 2, ".", ""); ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Discount
    <span class="d-block small text-muted fw-normal">Calculated on subtotal including tax</span>
</label>
<p class="text-gray text-end fw-bold mb-0">&dollar;<?php echo number_format($discountAmount, 2, ".", ""); ?></p>
</li>
<li class="list-group-item">
<label class="info-label">Total</label>
<p class="text-red text-end fw-bold mb-0">&dollar;<?php echo number_format($totalAmount, 2, ".", ""); ?></p>
</li>

<li class="list-group-item">
<label class="info-label">Payment Method</label>

<form id="eventCheckoutForm" name="eventCheckoutForm" action="event/checkout" method="POST">

<div class="form-check mt-3">
<input class="form-check-input" type="radio" name="eventCheckoutPaymentMethod" id="eventCheckoutPaymentMethodCard" value="1">
<label class="form-check-label text-gray" for="eventCheckoutPaymentMethod">Bank Card</label>
</div>

<input type="hidden" value="<?php echo $subtotalAmount; ?>" name="eventCheckoutSubtotal" id="eventCheckoutSubtotal" />
<input type="hidden" value="<?php echo $taxAmount; ?>" name="eventCheckoutTax" id="eventCheckoutTax" />
<input type="hidden" value="<?php echo $shipping; ?>" name="eventCheckoutShipping" id="eventCheckoutShipping" />
<input type="hidden" value="<?php echo $totalAmount; ?>" name="eventCheckoutTotal" id="eventCheckoutTotal" />

<div class="d-grid justify-content-end">
<input type="submit" name="eventCheckoutSubmit" id="eventCheckoutSubmit" class="btn btn-red btn-lg btn-sm-block mt-2" value="Proceed" />
</div>
</form>

<label id="eventCheckoutError"></label>
</li>

</ul>

</div>
</div>


<?php
else:
?>

<div class="alert alert-warning p-5">
<h2 class="display-1 text-center text-red"><i class="fa fa-shopping-cart" aria-hidden="true"></i></h2>
<p class="text-center text-gray"><i class="fa fa-exclamation-circle"></i>&nbsp;No items found in cart.</p>
<div class="d-flex justify-content-center">
<a type="button" href="event/view/FFE75100" class="btn btn-yellow fw-bold">Buy Now&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
</div>
</div>

<?php
endif;
?>

</div>
</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../templates/modal.php");  ?>

<!-- Confirm Action Modal -->
<?php include_once(__DIR__."/../templates/confirm.php");  ?>

<?php 
include_once(__DIR__."/../templates/footer.php"); 
ob_end_flush();
?>