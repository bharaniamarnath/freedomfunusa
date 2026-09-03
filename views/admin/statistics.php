<?php
ob_start();
include_once(__DIR__ . '/../../application/sessions.php');
include_once(__DIR__ . '/../../models/admin_model.php');
include_once(__DIR__ . '/../../models/statistics_model.php');
include_once(__DIR__ . '/../../models/category_model.php');

$sessions = new Sessions();
$adminSession = $sessions->adminSession();
if (!$adminSession) {
    exit(header('Location: login'));
}
?>

<?php
$adminModel = new AdminModel();
$adminEmail = $_SESSION['bccc_admin']['adminLoginEmail'];
$adminInfo = $adminModel->getAdminInfo($adminEmail);
if (empty($adminInfo) && !is_array($adminInfo)):
    exit(header('Location: login'));
endif;
?>

<?php
include_once(__DIR__ . '/../templates/header_admin.php');
?>

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Statistics</h1>
        </div>
    </div>

</div>


<div class="container">

    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="admin/manage">Manage</a></li>
            <li class="breadcrumb-item active" aria-current="page">Statistics</li>
        </ol>
    </nav>

<?php $statisticsModel = new StatisticsModel(); ?>

    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-2">

            <!-- Tab Menu -->

            <ul class="nav nav-tabs" id="statisticsInfoTabList" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="statisticsEventTab" data-bs-toggle="tab" data-bs-target="#statisticsEventPane" type="button" role="tab" aria-controls="statisticsEvent" aria-selected="true">Events</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="statisticsParticipantTab" data-bs-toggle="tab" data-bs-target="#statisticsParticipantPane" type="button" role="tab" aria-controls="statisticsParticipant" aria-selected="false">Participants</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="statisticsOrderTab" data-bs-toggle="tab" data-bs-target="#statisticsOrderPane" type="button" role="tab" aria-controls="statisticsOrder" aria-selected="false">Orders</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="statisticsMiscTab" data-bs-toggle="tab" data-bs-target="#statisticsMiscPane" type="button" role="tab" aria-controls="statisticsMisc" aria-selected="false">Misc</button>
                </li>
            </ul>

            <div class="tab-content" id="statisticsInfoTabContent">

                <!-- Events Statistics -->

                <div class="tab-pane fade show active" id="statisticsEventPane" role="tabpanel" aria-labelledby="aboutEventTab">

                    <!-- Events  -->

                    <div class="row justify-content-start">

                        <h3 class="text-red fw-bold mt-5">Events</h3>

                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <label class="info-label">Total Events</label>
                                    <p class="card-text text-blue fw-bold fs-3 mb-0">
                                        <?php
                                        $totalEvents = $statisticsModel->getTotalEvents();
                                        echo (!empty($totalEvents) && $totalEvents > 0) ? $totalEvents : "0";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <label class="info-label">Total Event Games</label>
                                    <p class="card-text text-blue fw-bold fs-3 mb-0">
                                        <?php
                                        $totalEventGames = $statisticsModel->getTotalEventGames();
                                        echo (!empty($totalEventGames) && $totalEventGames > 0) ? $totalEventGames : "0";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row justify-content-start">

                        <h3 class="text-red fw-bold mt-5">Event Games</h3>
                        <h5 class="text-blue fw-bold mt-3">By Date</h5>

                        <?php
                        $totalEventGamesByDate = $statisticsModel->getTotalEventGamesByDate();
                        foreach ($totalEventGamesByDate as $eventGamesByDate):
                        ?>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body d-flex flex-column">
                                        <label class="info-label"><?php echo date('F jS, Y', strtotime($eventGamesByDate['ffeg_game_date'])); ?></label>
                                        <p class="card-text text-blue fw-bold fs-3 mb-0">
                                            <span><?php echo $eventGamesByDate['event_games_count']; ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endforeach;
                        ?>

                    </div>

                    <div class="row justify-content-start">

                        <h5 class="text-blue fw-bold mt-3">By Event</h5>

                        <?php
                        $totalEventGamesByEvent = $statisticsModel->getTotalEventGamesByEvent();
                        if (empty($totalEventGamesByEvent) || !is_array($totalEventGamesByEvent)):
                        ?>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">
                                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>&nbsp;No records found</div>
                            </div>
                            <?php
                        else:
                            foreach ($totalEventGamesByEvent as $eventGamesByEvent):
                            ?>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <label class="info-label"><?php echo $eventGamesByEvent['ffe_name']; ?></label>
                                            <p class="card-text text-blue fw-bold fs-3 mb-0">
                                                <span><?php echo $eventGamesByEvent['event_games_count']; ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </div>

                    <div class="row justify-content-start">

                        <h5 class="text-blue fw-bold mt-3">By Category</h5>

                        <?php
                        $totalEventGamesByCategory = $statisticsModel->getTotalEventGamesByCategory();
                        if (empty($totalEventGamesByCategory) || !is_array($totalEventGamesByCategory)):
                        ?>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">
                                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>&nbsp;No records found</div>
                            </div>
                            <?php
                        else:
                            foreach ($totalEventGamesByCategory as $eventGamesByCategory):
                            ?>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <label class="info-label"><?php echo $eventGamesByCategory['ffec_name']; ?></label>
                                            <p class="card-text text-blue fw-bold fs-3 mb-0">
                                                <span><?php echo $eventGamesByCategory['event_games_count']; ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </div>


                    <div class="row justify-content-start">

                        <h3 class="text-red fw-bold mt-5">Games</h3>

                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <label class="info-label">Total Games &amp; Addons</label>
                                    <p class="card-text text-blue fw-bold fs-3 mb-0">
                                        <?php
                                        $totalGames = $statisticsModel->getTotalGames();
                                        echo (!empty($totalGames) && $totalGames > 0) ? $totalGames : "0";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="row justify-content-start">

                        <h3 class="text-red fw-bold mt-5">Categories</h3>

                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <label class="info-label">Total Categories</label>
                                    <p class="card-text text-blue fw-bold fs-3 mb-0">
                                        <?php
                                        $totalCategories = $statisticsModel->getTotalCategories();
                                        echo (!empty($totalCategories) && $totalCategories > 0) ? $totalCategories : "0";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>


                <!-- Participants Information -->


                <div class="tab-pane fade" id="statisticsParticipantPane" role="tabpanel" aria-labelledby="statisticsParticipantTab">

                    <div class="row justify-content-start">

                        <h3 class="text-red fw-bold mt-5">Participants</h3>

                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <label class="info-label">Total Participants</label>
                                    <p class="card-text text-blue fw-bold fs-3 mb-0">
                                        <?php
                                        $totalParticipants = $statisticsModel->getTotalParticipants();
                                        echo (!empty($totalParticipants) && $totalParticipants > 0) ? $totalParticipants : "0";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row justify-content-start">

                        <h3 class="text-red fw-bold mt-5">Registrations</h3>

                        <h5 class="text-blue fw-bold mt-3">By Events</h5>

                        <?php
                        $totalParticipantsByEvent = $statisticsModel->getTotalParticipantsByEvent();
                        if (empty($totalParticipantsByEvent) || !is_array($totalParticipantsByEvent)):
                        ?>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">
                                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>&nbsp;No records found</div>
                            </div>
                            <?php
                        else:
                            foreach ($totalParticipantsByEvent as $participantsByEvent):
                            ?>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <label class="info-label"><?php echo $participantsByEvent['ffe_name']; ?></label>
                                            <p class="card-text text-blue fw-bold fs-3 mb-0">
                                                <span><?php echo $participantsByEvent['event_participants']; ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </div>

                    <div class="row justify-content-start">

                        <h5 class="text-blue fw-bold mt-3">By Event Games</h5>

                        <?php
                        $totalParticipantsByEventGames = $statisticsModel->getTotalParticipantsByEventGames();
                        if (empty($totalParticipantsByEventGames) || !is_array($totalParticipantsByEventGames)):
                        ?>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">
                                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>&nbsp;No records found</div>
                            </div>
                            <?php
                        else:
                            foreach ($totalParticipantsByEventGames as $participantsByEventGames):
                            ?>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <label class="text-blue small"><?php echo $participantsByEventGames['ffe_name']; ?></label>
                                            <label class="info-label"><?php echo $participantsByEventGames['ffg_name']; ?></label>
                                            <p class="card-text text-blue fw-bold fs-3 mb-0">
                                                <span><?php echo $participantsByEventGames['event_participants']; ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </div>

                    <div class="row justify-content-start">

                        <h5 class="text-blue fw-bold mt-3">By State</h5>

                        <?php
                        $totalParticipantsByState = $statisticsModel->getTotalParticipantsByState();
                        if (empty($totalParticipantsByState) || !is_array($totalParticipantsByState)):
                        ?>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">
                                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>&nbsp;No records found</div>
                            </div>
                            <?php
                        else:
                            foreach ($totalParticipantsByState as $participantsByState):
                            ?>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <label class="info-label"><?php echo $participantsByState['st_name']; ?></label>
                                            <p class="card-text text-blue fw-bold fs-3 mb-0">
                                                <span><?php echo $participantsByState['event_participants']; ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </div>

                </div>


                <!-- Orders Information -->


                <div class="tab-pane fade" id="statisticsOrderPane" role="tabpanel" aria-labelledby="statisticsOrderTab">

                    <div class="row justify-content-start">

                        <h3 class="text-red fw-bold mt-5">Orders</h3>

                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <label class="info-label">Total Orders Revenue</label>
                                    <p class="card-text text-blue fw-bold fs-3 mb-0">
                                        <?php
                                        $allEventsAmount = $statisticsModel->getAllEventsAmount();
                                        echo (!empty($allEventsAmount) && $allEventsAmount['total_amt'] > 0) ? '&dollar;' . number_format($allEventsAmount['total_amt'], 2, '.', ',') : '&dollar;0.00';
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <label class="info-label">Total Orders Count</label>
                                    <p class="card-text text-blue fw-bold fs-3 mb-0">
                                        <?php
                                        $totalEventOrders = $statisticsModel->getTotalEventOrders();
                                        echo (!empty($totalEventOrders) && $totalEventOrders > 0) ? $totalEventOrders : "0";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row justify-content-start">

                        <h5 class="text-blue fw-bold mt-3">By Event Games</h5>

                        <?php
                        $totalAmountByEventGames = $statisticsModel->getTotalAmountByEventGames();
                        if (empty($totalAmountByEventGames) || !is_array($totalAmountByEventGames)):
                        ?>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">
                                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>&nbsp;No records found</div>
                            </div>
                            <?php
                        else:
                            foreach ($totalAmountByEventGames as $amountByEventGames):
                            ?>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <label class="text-blue small"><?php echo $amountByEventGames['ffe_name']; ?></label>
                                            <label class="info-label"><?php echo $amountByEventGames['ffg_name']; ?></label>
                                            <p class="card-text text-blue fw-bold fs-3 mb-0">
                                                <span>&dollar;<?php echo !empty($amountByEventGames['event_amount']) && $amountByEventGames['event_amount'] > 0 ? number_format($amountByEventGames['event_amount'], 2, '.', ',') : '0.00'; ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </div>

                    <div class="row justify-content-start">

                        <h5 class="text-blue fw-bold mt-3">By Order Date</h5>

                        <?php
                        $totalAmountByOrderDate = $statisticsModel->getTotalOrdersByOrderDate();
                        if (empty($totalAmountByOrderDate) || !is_array($totalAmountByOrderDate)):
                        ?>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">
                                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>&nbsp;No records found</div>
                            </div>
                            <?php
                        else:
                            foreach ($totalAmountByOrderDate as $amountByOrderDate):
                            ?>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <label class="text-blue small"><?php echo $amountByOrderDate['ffe_name']; ?></label>
                                            <label class="info-label"><?php echo date('F jS, Y', strtotime($amountByOrderDate['order_date'])); ?></label>
                                            <p class="card-text text-blue fw-bold fs-3 mb-0">
                                                <span>&dollar;<?php echo !empty($amountByOrderDate['event_amount']) && $amountByOrderDate['event_amount'] > 0 ? number_format($amountByOrderDate['event_amount'], 2, '.', ',') : '0.00'; ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </div>

                </div>


                <div class="tab-pane fade" id="statisticsMiscPane" role="tabpanel" aria-labelledby="aboutSponsorTab">

                    <div class="row justify-content-start">

                        <h3 class="text-red fw-bold mt-5">Slots</h3>

                        <h5 class="text-blue fw-bold mt-3">By Event Games</h5>

                        <?php
                        $totalEventGameSlots = $statisticsModel->getTotalEventGameSlots();
                        if (empty($totalEventGameSlots) || !is_array($totalEventGameSlots)):
                        ?>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">
                                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>&nbsp;No records found</div>
                            </div>
                            <?php
                        else:
                            foreach ($totalEventGameSlots as $eventGameSlots):
                            ?>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <label class="text-blue small"><?php echo $eventGameSlots['ffe_name']; ?></label>
                                            <label class="text-red small"><?php echo $eventGameSlots['ffg_name']; ?></label>
                                            <p class="card-text text-blue fw-bold fs-3 mb-0">
                                                <span><?php echo $eventGameSlots['ffeg_slots']; ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>


</div>


<?php
include_once(__DIR__ . "/../templates/footer.php");
ob_end_flush();
?>