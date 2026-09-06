<?php
include_once(__DIR__."/../../../models/event_model.php");
include_once(__DIR__."/../../../models/game_model.php");
include_once(__DIR__."/../../../models/category_model.php");
include_once(__DIR__."/../../../models/content_model.php");
include_once(__DIR__."/../../../models/misc_model.php");
include_once(__DIR__."/../../../application/sessions.php");
$contentModel = new ContentModel();
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

<?php include_once(__DIR__."/../../templates/header_admin.php"); ?>

<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Participant</h1>
</div>
</div>

</div>

<div class="container">

<div class="row">

<div class="col-xx-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">

<p class="fw-bold fs-5 text-blue text-uppercase">Please fill valid information in all the required fields below.</p>
<div class="alert alert-danger fw-bold text-red">The information you provide below is required for verification of your event registration.</div>

<div class="card shadow-sm">
<div class="card-body">

<form name="eventParticipantRegisterForm" id="eventParticipantRegisterForm" action="admin/signup/participant" method="POST">

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

<div class="d-grid gap-2 d-sm-block py-3">
<input type="submit" name="eventParticipantRegisterSubmit" id="eventParticipantRegisterSubmit" class="btn btn-red btn-lg" value="Proceed" />
</div>
</form>

</div>

</div>
</div>

</div>


<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Checkout</h1>
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
<span class="d-block fs-6 fw-bold text-red"><?php echo date('l', strtotime($eventGameInfo['ffeg_game_date'])); ?></span>
<span class="d-block fs-6 fw-bold text-blue"><?php echo date('F jS, Y', strtotime($eventGameInfo['ffeg_game_date'])); ?></span>
<p class="card-text fw-bold mt-3 mb-0">
<span class="d-block fs-5 text-red">&dollar;<?php echo $event_game['eventGamePrice']; ?></span>
<span class="d-block fs-6 text-blue"><?php echo $event_game['eventGameSlots']; ?>&nbsp;Tickets</span>
</p>
</div>

<div class="d-grid gap-2 justify-content-sm-center">
<button type="button" id="<?php echo $event_game['eventGameUID']; ?>" class="btn btn-red btn-sm btn-del-event-list-confirm"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Remove</button>
</div>

</div>
</div>

<?php
$subtotal_price += $event_game['eventGamePrice'] * $event_game['eventGameSlots'];
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


</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../../templates/modal.php");  ?>

<?php include_once(__DIR__."/../../templates/footer.php"); ?>