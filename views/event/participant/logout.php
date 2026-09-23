<?php
ob_start();
include_once(__DIR__."/../../../application/sessions.php");
include_once(__DIR__."/../../../models/participant_model.php");

$participantLogOutStatus = -1;
$sessions = new Sessions();
$participantSession = $sessions->participantSession();
if($participantSession){
$participantLoginEmail = $_SESSION['bccc_participant']['participantLoginEmail'];
if(isset($participantLoginEmail) && !empty($participantLoginEmail) && $participantLoginEmail !== ''){
$participantLoginStatus = 0;
$participantModel = new ParticipantModel();
$participantModel->setParticipantLoginStatus($participantLoginEmail, $participantLoginStatus);
unset($_SESSION['bccc_participant']);
$participantLogOutStatus = 1;
}
else{
$participantLogOutStatus = 0;
}
}
else{
exit(header('Location: event/participant'));
}
?>

<?php 
include_once(__DIR__.'/../../templates/header.php');
?>

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Participants</h1>
        </div>
    </div>

</div>

<div class="container">
<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<?php if($participantLogOutStatus == 1): ?>
<div class="alert alert-info"><i class="fa fa-check-circle"></i>&nbsp;Participant account <?php echo $participantLoginEmail; ?> logged out successfully</div>
<?php elseif($participantLogOutStatus == 0): ?>
<div class="alert alert-danger"><i class="fa fa-times-circle"></i>&nbsp;Unable to logout participant account <?php echo $participantLoginEmail; ?>. Try again.</div>
<?php elseif($participantLogOutStatus == -1): ?>
<div class="alert alert-danger"><i class="fa fa-times-circle"></i>&nbsp;Unable to get participant account <?php echo $participantLoginEmail; ?> login status</div>
<?php else:?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i>&nbsp;Unknown error occurred.</div>
<?php endif; ?>
<div class="d-grid gap-2 d-sm-block py-3">
<a href="event/participant" type="button" class="btn btn-red">Back to Login</a>
</div>
</div>
</div>

</div>

<?php
include_once(__DIR__.'/../../templates/footer.php');
ob_end_flush();
?>