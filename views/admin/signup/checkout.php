<?php
ob_start();
include_once(__DIR__.'/../../templates/header_admin.php');
include_once(__DIR__.'/../../../models/event_model.php');
include_once(__DIR__.'/../../../models/game_model.php');
include_once(__DIR__.'/../../../models/category_model.php');
include_once(__DIR__.'/../../../models/misc_model.php');
include_once(__DIR__.'/../../../models/content_model.php');
include_once(__DIR__."/../../../application/sessions.php");
$sessions = new Sessions();
$eventParticipantFirstName = $eventParticipantLastName = $eventParticipantEmail = $eventParticipantPhoneCode = $eventParticipantPhoneCountry = $eventParticipantPhoneNumber = $eventParticipantZip = '';
$participantSession = $sessions->participantSession();
if($participantSession){
$eventParticipantFirstName = $_SESSION['bccc_participant']['eventParticipantFirstName'];
$eventParticipantLastName = $_SESSION['bccc_participant']['eventParticipantLastName'];
$eventParticipantEmail = $_SESSION['bccc_participant']['eventParticipantEmail'];
$eventParticipantPhoneCode = $_SESSION['bccc_participant']['eventParticipantPhoneCode'];
$eventParticipantPhoneCountry = $_SESSION['bccc_participant']['eventParticipantPhoneCountry'];
$eventParticipantPhoneNumber = $_SESSION['bccc_participant']['eventParticipantPhoneNumber'];
$eventParticipantZip = $_SESSION['bccc_participant']['eventParticipantZip'];
}
?>

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Walk-In</h1>
        </div>
    </div>

</div>

<div class="container">

    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="admin/manage">Manage</a></li>
            <li class="breadcrumb-item"><a href="admin/signup/event">Walk-In</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </nav>

<div class="row">
<div class="col-xx-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-danger fw-bold text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;All sales are final. No refunds.</div>
</div>
</div>

<div class="row justify-content-start pb-5">

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
<?php if($categoryInfo['ffec_uid'] == 'FFEC32244'): ?>
<span class="d-block fs-6 fw-bold text-blue"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Additional Play Option</span>
<?php else: ?>
<span class="d-block fs-6 fw-bold text-blue"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Single Day Event</span>
<?php endif; ?>
<?php else: ?>
<span class="d-block fs-6 fw-bold text-red"><?php echo date('l', strtotime($eventGameInfo['ffeg_game_date'])); ?></span>
<span class="d-block fs-6 fw-bold text-blue"><?php echo date('F jS, Y', strtotime($eventGameInfo['ffeg_game_date'])); ?></span>
<?php endif; ?>
<p class="card-text fw-bold mt-3 mb-0">
<span class="d-block fs-5 text-red">&dollar;<?php echo $event_game['eventGamePrice']; ?></span>
<span class="d-block fs-6 text-blue"><?php echo $event_game['eventGameSlots']; ?>&nbsp;<?php echo $categoryInfo['ffec_name']; ?>
<?php if($categoryInfo['ffec_uid'] == 'FFEC98662'): ?>
<span class="small text-red">&nbsp;&#40;<?php echo ($event_game['eventGameSlots'] * 4) ; ?>&nbsp;Wristbands&#41;</span>
<?php endif; ?>
</span>
</p>
</div>

<div class="d-grid gap-2 justify-content-sm-center">
<button type="button" id="<?php echo $event_game['eventGameUID']; ?>" class="btn btn-red btn-sm btn-del-confirm"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Remove</button>
</div>

</div>
</div>

<?php
$tax += ($tax_rate/100) * $event_game['eventGameSlots'];
$subtotal_price += ($event_game['eventGamePrice']) * ($event_game['eventGameSlots']);
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

    <div class="row">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
    <h1 class="fs-2 fw-bold text-red">Billing</h1>
    </div>
    </div>

<div class="row justify-content-center">


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
<p class="fw-bold text-blue mb-0">Sub Total
<span class="d-block small text-muted fw-normal">*Inclusive of all taxes</span></p>
<p class="fs-5 text-red text-end fw-bold mb-0">&dollar;<?php echo number_format($subtotal_price, 2, ".", ""); ?></p>
</li>
<li class="list-group-item">
<p class="fw-bold text-blue mb-0">Tax
<span class="d-block small text-muted fw-normal">Calculated per item and included to Sub Total.</span></p>
<p class="fs-5 text-red text-end fw-bold mb-0">&dollar;<?php echo number_format($tax, 2, ".", ""); ?></p>
</li>
<li class="list-group-item">
<p class="fw-bold text-blue mb-0">Total</p>
<p class="fs-4 text-red text-end fw-bold mb-0">&dollar;<?php echo number_format($total_price, 2, ".", ""); ?></p>
</li>
</ul>


</div>


<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 py-3">

<h5 class="text-red fw-bold my-3">Participant Information</h5>

<form id="eventSignUpCheckoutForm" name="eventSignUpCheckoutForm" action="admin/signup/checkout" method="POST">

<div class="card shadow-sm">
<div class="card-body">

<div class="row">

<div class="form-group col-md-6 pb-3">
<label for="eventParticipantFirstName" class="form-label required-field">First Name</label>
<input type="text" name="eventParticipantFirstName" id="eventParticipantFirstName" class="form-control" value="<?php echo $eventParticipantFirstName; ?>" required />
</div>

<div class="form-group col-md-6 pb-3">
<label for="eventParticipantLastName" class="form-label required-field">Last Name</label>
<input type="text" name="eventParticipantLastName" id="eventParticipantLastName" class="form-control" value="<?php echo $eventParticipantLastName; ?>" required />
</div>

</div>

<div class="form-group pb-3">
<label for="eventParticipantEmail" class="form-label required-field">Email</label>
<input type="email" name="eventParticipantEmail" id="eventParticipantEmail" class="form-control" value="<?php echo $eventParticipantEmail; ?>" required />
</div>

<div class="from-group my-0">
<label class="form-label required-field" for="eventParticipantPhoneNumber">Phone</label>
</div>

<div class="input-group mb-0">
<select class="form-select" name="eventParticipantPhoneCode" id="eventParticipantPhoneCode" aria-label="Select Country">
<optgroup>
<option value="" selected>Select Country</option>
<?php
$miscModel = new MiscModel();
$phcodes = $miscModel->getAllPhoneCodes();
foreach($phcodes as $phcode):
if(!empty($eventParticipantPhoneCountry)):
?>
<option value="<?php echo $phcode["pc_code"].'_'.$phcode['pc_namecode']; ?>" <?php if($phcode["pc_namecode"] == $eventParticipantPhoneCountry){ echo "selected"; } else{} ?>><?php echo $phcode["pc_name"]; ?></option>
<?php
else:
?>
<option value="<?php echo $phcode["pc_code"].'_'.$phcode['pc_namecode']; ?>" <?php if($phcode["pc_namecode"] == "US"){ echo "selected"; } else{} ?>><?php echo $phcode["pc_name"]; ?></option>
<?php
endif;
endforeach;
?>
</optgroup>
</select>
<input class="form-control" size="10" type="text" name="eventParticipantPhoneNumber" id="eventParticipantPhoneNumber" value="<?php echo $eventParticipantPhoneNumber; ?>" required />
</div>
<label id="eventParticipantPhoneNumberError"></label>


<div class="form-group pb-3">
<label for="eventParticipantZip" class="form-label required-field">Zip Code</label>
<input type="number" name="eventParticipantZip" id="eventParticipantZip" class="form-control" value="<?php echo $eventParticipantZip; ?>" required />
</div>

</div>
</div>



<h5 class="text-red fw-bold my-3">Payment Method</h5>

<div class="card shadow-sm">
<div class="card-body">

<!-- Select Payment Method -->

<div class="from-group mb-2">
<label class='form-label' for='eventCheckoutPaymentMethodCard'>Select Payment Method</label>
</div>

<div class="form-check mb-2">
<input class="form-check-input" type="radio" name="eventCheckoutPaymentMethod" id="eventCheckoutPaymentMethodCard" value="1">
<label class="form-check-label text-red" for="eventCheckoutPaymentMethodCard">Credit/Debit Card</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="eventCheckoutPaymentMethod" id="eventCheckoutPaymentMethodCash" value="2">
<label class="form-check-label text-red" for="eventCheckoutPaymentMethodCash">Direct Cash</label>
</div>

<label id="eventCheckoutPaymentMethodError"></label>

</div>
</div>

<input type="hidden" value="<?php echo $subtotal_price; ?>" name="eventCheckoutSubtotal" id="eventCheckoutSubtotal" />
<input type="hidden" value="<?php echo $tax; ?>" name="eventCheckoutTax" id="eventCheckoutTax" />
<input type="hidden" value="<?php echo $shipping; ?>" name="eventCheckoutShipping" id="eventCheckoutShipping" />
<input type="hidden" value="<?php echo $total_price; ?>" name="eventCheckoutTotal" id="eventCheckoutTotal" />


<div class="d-grid gap-2 d-sm-block py-3">
<a href="admin/signup/list/<?php echo $_SESSION['bccc_event_uid']; ?>" class='btn btn-blue btn-lg'><i class="fa fa-chevron-circle-left" aria-hidden="true"></i>&nbsp;Back</a>
<input type="submit" name="eventSignUpCheckoutSubmit" id="eventSignUpCheckoutSubmit" class="btn btn-red btn-lg" value="Checkout" />
</div>

<label id="eventCheckoutError"></label>

</form>

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