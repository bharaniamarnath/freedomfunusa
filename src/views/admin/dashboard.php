<?php
ob_start();
include_once(__DIR__ . '/../../application/sessions.php');
include_once(__DIR__ . '/../../models/admin_model.php');
include_once(__DIR__ . '/../../models/event_model.php');
include_once(__DIR__ . '/../../models/statistics_model.php');
$sessions = new Sessions();
$adminSession = $sessions->adminSession();
if (!$adminSession) {
    exit(header('Location: login'));
}
?>

<?php
include_once(__DIR__ . '/../templates/header_admin.php');
?>

<div class="container-fluid page">

    <div class="row justify-content-center">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
            <h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Dashboard</h1>
        </div>
    </div>

</div>

<div class="container">

    <?php
    $adminModel = new AdminModel();
    $adminEmail = $_SESSION['bccc_admin']['adminLoginEmail'];
    $adminInfo = $adminModel->getAdminInfo($adminEmail);
    if (empty($adminInfo) && !is_array($adminInfo)):
        exit(header('Location: login'));
    endif;
    ?>

    <!-- Dashboard Welcome -->

    <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 col-12 py-3">

            <div class="list-group">

                <a href="#" class="list-group-item list-group-item-action disabled" aria-current="true" aria-disabled="true">
                    <div class="d-flex w-100 justify-content-between img-dashboard py-3">
                        <?php if (is_file("public/assets/images/admin/" . $adminInfo['ffa_image'])) : ?>
                            <img src="public/assets/images/admin/<?php echo $adminInfo['ffa_image']; ?>" class="img-fluid" alt="<?php echo $adminInfo['ffa_name']; ?>">
                        <?php else: ?>
                            <img src="public/assets/images/misc/ff_placeholder.png" class="img-fluid" alt="<?php echo $adminInfo['ffa_name']; ?>">
                        <?php endif ?>
                    </div>
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="fw-bold text-red mb-1"><?php echo $adminInfo['ffa_name']; ?></h5>
                    </div>
                    <small class="text-muted">Last logged in at <?php echo date('F jS, Y h:i A', strtotime($adminInfo['ffa_last_login'])); ?></small>
                </a>

                <a href="admin/dashboard" class="list-group-item list-group-item-action text-blue" aria-current="true">
                    <i class="fa fa-tachometer" aria-hidden="true"></i>&nbsp;Dashboard
                </a>
                <a href="admin/event/order/list" class="list-group-item list-group-item-action text-blue">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>&nbsp;Orders
                </a>
                <a href="admin/event/list" class="list-group-item list-group-item-action text-blue">
                    <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;Events
                </a>
                <a href="admin/category/list" class="list-group-item list-group-item-action text-blue">
                    <i class="fa fa-th-large" aria-hidden="true"></i>&nbsp;Categories
                </a>
                <a href="admin/statistics" class="list-group-item list-group-item-action text-blue">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;Statistics
                </a>
                <a href="admin/config/about" class="list-group-item list-group-item-action text-blue">
                    <i class="fa fa-cog" aria-hidden="true"></i>&nbsp;Settings
                </a>
                <a href="admin/administrator/list" class="list-group-item list-group-item-action text-blue">
                    <i class="fa fa-user" aria-hidden="true"></i>&nbsp;Profile
                </a>
                <a href="admin/logout" class="list-group-item list-group-item-action text-blue">
                    <i class="fa fa-power-off" aria-hidden="true"></i>&nbsp;Logout
                </a>
            </div>

        </div>


        <!-- Dashboard Menu -->

        <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12 col-12 py-3">

            <!-- Card Begin -->

            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                    <h2 class="text-red fw-bold">Overview</h2>
                </div>
            </div>


            <?php
            $statisticsModel = new StatisticsModel();
            $totalAmountByDate = $statisticsModel->getTotalAmountByOrderDate();
            if (is_null($totalAmountByDate) || empty($totalAmountByDate)) {
                echo "No records found";
            } else {
                $totalAmountByDateChart = [];
                foreach ($totalAmountByDate as $totalAmountByDateItem) {
                    array_push($totalAmountByDateChart, array('y' => $totalAmountByDateItem['ffeo_total_amt_date'], 'label' => $totalAmountByDateItem['ffeo_order_date_only']));
                }
            }
            ?>

            <div class="row">

                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text my-0">
                            <div id="totalAmountByDateChart" style="height: 360px; width: 100%;"></div>
                            </p>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3 mt-3">
                    <h4 class="text-red fw-bold">By Orders</h4>
                </div>
            </div>

            <div class="row">

                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <p class="card-title text-red fw-bold mb-1">Total Events Amount</p>
                            <p class="card-text text-blue fw-bold fs-3 my-0">&dollar;
                                <?php
                                $eventModel = new EventModel();
                                $allEventsAmount = $eventModel->getAllEventsAmount();
                                if (is_null($allEventsAmount['total_amt']) || empty($allEventsAmount['total_amt'])) {
                                    echo "0.00";
                                } else {
                                    echo number_format($allEventsAmount['total_amt'], 2, '.', ',');
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- By Payment Method -->

            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3 mt-3">
                    <h4 class="text-blue fw-bold">By Payment Methods</h4>
                </div>
            </div>

            <div class="row">

                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <p class="card-title text-red fw-bold mb-1">Total Orders By Card</p>
                            <p class="card-text text-blue fw-bold fs-3 my-0">
                                <?php
                                $statisticsModel = new StatisticsModel();
                                $allEventOrderByCardPayment = $statisticsModel->getTotalByPaymentMethod(1);
                                if (is_null($allEventOrderByCardPayment) || empty($allEventOrderByCardPayment)) {
                                    echo "0";
                                } else {
                                    echo $allEventOrderByCardPayment;
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <p class="card-title text-red fw-bold mb-1">Total Orders By Cash</p>
                            <p class="card-text text-blue fw-bold fs-3 my-0">
                                <?php
                                $statisticsModel = new StatisticsModel();
                                $allEventOrderByCardPayment = $statisticsModel->getTotalByPaymentMethod(2);
                                if (is_null($allEventOrderByCardPayment) || empty($allEventOrderByCardPayment)) {
                                    echo "0";
                                } else {
                                    echo $allEventOrderByCardPayment;
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>

            </div>





            <!-- By Game Type -->

            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3 mt-3">
                    <h4 class="text-red fw-bold">By Game Type</h4>
                </div>
            </div>

            <div class="row">

                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <p class="card-title text-red fw-bold mb-1">Wristband</p>
                            <p class="card-text text-blue fw-bold fs-3 my-0">
                                <?php
                                $statisticsModel = new StatisticsModel();
                                $allWristbandEventOrders = $statisticsModel->getTotalOrdersByEventGameCategory('Wristband');
                                if (is_null($allWristbandEventOrders) || empty($allWristbandEventOrders)) {
                                    echo "0";
                                } else {
                                    echo count($allWristbandEventOrders);
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <p class="card-title text-red fw-bold mb-1">Token</p>
                            <p class="card-text text-blue fw-bold fs-3 my-0">
                                <?php
                                $statisticsModel = new StatisticsModel();
                                $allWristbandEventOrders = $statisticsModel->getTotalOrdersByEventGameCategory('Token');
                                if (is_null($allWristbandEventOrders) || empty($allWristbandEventOrders)) {
                                    echo "0";
                                } else {
                                    echo count($allWristbandEventOrders);
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>

            </div>



            <!-- Card End -->

            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 pt-5 pb-3 mt-3 border-top">
                    <h2 class="text-blue fw-bold">Recent Orders</h2>
                </div>
            </div>
            <div class="row">
                <?php
                $eventModel = new EventModel();
                $allEventOrdersSearch = array();
                $allEventOrdersSort = array("sortField" => 'ffeo_total_amt', "sortOrder" => 'DESC');
                $allEventOrdersLimit = array("limitOnset" => 0, "limitOffset" => 3);
                $allEventOrders = $eventModel->getAllEventOrders($allEventOrdersSearch, $allEventOrdersSort, $allEventOrdersLimit);
                if (!$allEventOrders || empty($allEventOrders)):
                ?>
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                        <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;No event orders found in record</div>
                    </div>
                    <?php
                else:
                    foreach ($allEventOrders as $eventOrderInfo):
                    ?>
                        <!-- Events -->
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <label class="info-label">Order ID</label>
                                    <p class="card-title text-red fw-bold mb-0"><?php echo $eventOrderInfo['ffeo_oid']; ?></p>
                                    <label class="info-label mt-1">Order Amount</label>
                                    <p class="card-text text-blue fw-bold fs-4 mb-0">&dollar;<?php echo number_format($eventOrderInfo['ffeo_total_amt'], 2, '.', ','); ?></p>
                                    <label class="info-label mt-1">Order Date</label>
                                    <p class="card-text small text-blue fw-bold"><?php echo date('F jS Y, H:i:s', strtotime($eventOrderInfo['ffeo_order_date'])); ?></p>
                                </div>
                                <div class="card-footer bg-white border-0 d-grid justify-content-end">
                                    <a href="admin/event/order/view/<?php echo $eventOrderInfo['ffeo_oid']; ?>" class="btn btn-red btn-sm">View Order&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>

                    <?php
                    endforeach;
                    ?>
            </div>

            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                    <a href="admin/event/order/list" class="btn btn-red btn-small">View All Event Orders&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                </div>
            </div>

        <?php
                endif;
        ?>


        </div>
    </div>
</div>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script>
    var totalAmountByDateChartData = <?php echo json_encode(array_reverse($totalAmountByDateChart), JSON_NUMERIC_CHECK); ?>;
</script>

<?php
include_once(__DIR__ . "/../templates/footer.php");
ob_end_flush();
?>