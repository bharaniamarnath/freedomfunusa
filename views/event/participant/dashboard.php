<?php
ob_start();
include_once(__DIR__ . '/../../../application/sessions.php');
include_once(__DIR__ . '/../../../models/participant_model.php');

$sessions = new Sessions();
$participantSession = $sessions->participantSession();
if (!$participantSession) {
    exit(header('Location: event/participant'));
}
?>

<?php
include_once(__DIR__ . '/../../templates/header.php');
?>

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Dashboard</h1>
        </div>
    </div>

</div>

<div class="container">

    <?php
    $participantModel = new ParticipantModel();
    $participantEmail = $_SESSION['bccc_participant']['participantLoginEmail'];
    $participantInfo = $participantModel->getEventParticipantByEmailID($participantEmail);
    if (empty($participantInfo) && !is_array($participantInfo)):
        exit(header('Location: event/participant'));
    endif;
    ?>

    <!-- Dashboard -->

            <div class="row">

                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
            <div class="card h-100 shadow-sm p-3">
                <div class="card-body d-flex flex-column">
                    <h5 class="fs-5 text-red text-capitalize fw-bold mb-2"><?php echo $participantInfo['ffep_first_name'] . '&nbsp;' . $participantInfo['ffep_last_name']; ?></h5>
                    <p class="text-gray fw-bold mb-0"><?php echo $participantInfo['ffep_email']; ?></p>
                    <p class="text-gray">Last Login:&nbsp;<?php echo $participantInfo['ffep_last_login']; ?></p>
                </div>
                <div class="card-footer d-grid justify-content-end bg-white border-0">
                    <a href="event/participant/logout" class="btn btn-red btn-sm">Logout</a>
                </div>
            </div>
        </div>

</div>

<?php
include_once(__DIR__ . "/../../templates/footer.php");
ob_end_flush();
?>