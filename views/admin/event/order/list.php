<?php
ob_start();
include_once(__DIR__ . '/../../../../application/sessions.php');
include_once(__DIR__ . "/../../../../models/event_model.php");
include_once(__DIR__ . "/../../../../models/misc_model.php");
$sessions = new Sessions();
$adminSession = $sessions->adminSession();
if (!$adminSession) {
    exit(header('Location: ../../login'));
}
?>

<?php
include_once(__DIR__ . '/../../../templates/header_admin.php');
?>

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Orders</h1>
        </div>
    </div>

</div>

<div class="container">

    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orders</li>
        </ol>
    </nav>

    <div class="row justify-content-start">

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
            <form name="eventOrderSearchForm" id="eventOrderSearchForm" action="admin/event/order/list" method="POST">
                <div class="input-group mb-3">
                    <input type="text" name="searchValue" id="searchValue" class="form-control" placeholder="Search" required />

                    <select name="searchKey" id="searchKey" class="form-select">
                        <option value="ffeo.ffeo_oid">Order ID</option>
                        <option value="ffep.ffep_first_name">First Name</option>
                        <option value="ffep.ffep_last_name">Last Name</option>
                        <option value="ffep.ffep_email">Email</option>
                        <option value="ffep.ffep_phone">Phone</option>
                        <option value="ffep.ffep_zip">Zip</option>
                        <option value="ffeo.ffeo_order_date">Order Date</option>
                    </select>

                    <!-- <input type="hidden" name="searchKey" id="searchKey" value="ffeo_oid" /> -->
                    <button type="submit" class="btn btn-blue" name="eventOrderSearchSubmit" id="eventOrderSearchSubmit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                </div>
            </form>
        </div>

        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
            <form name="eventSortFilterForm" id="eventSortFilterForm" action="admin/event/order/list" method="POST">
                <div class="input-group mb-3">
                    <select name="sortField" id="sortField" class="form-select">
                        <option value="ffeo.ffeo_oid">Order ID</option>
                        <option value="ffeo.ffeo_order_date">Order Date</option>
                        <option value="ffeo.ffeo_total_amt">Order Amount</option>
                    </select>
                    <button type="submit" class="btn btn-blue" name="eventOrderSortFilterSubmit" id="eventOrderSortFilterSubmit"><i class="fa fa-sort" aria-hidden="true"></i>&nbsp;Sort</button>
                </div>
            </form>
        </div>

        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
            <form name="eventClearFilterForm" id="eventClearFilterForm" action="admin/event/order/list" method="POST">
                <button type="submit" class="btn btn-red" name="eventOrderClearFilter" id="eventOrderClearFilter"><i class="fa fa-undo" aria-hidden="true"></i>&nbsp;Reset</button>
            </form>
        </div>

    </div>

    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
            <?php
            $eventModel = new EventModel();

            $allEventOrdersSearch = array();
            $allEventOrdersSort = array();
            $allEventOrdersLimit = array();

            //Clear Filter
            if (isset($_POST['eventOrderClearFilter'])) {
                if (isset($_SESSION['allEventOrdersSearch'])) {
                    unset($_SESSION['allEventOrdersSearch']);
                }
                if (isset($_SESSION['allEventOrdersSort'])) {
                    unset($_SESSION['allEventOrdersSort']);
                }
            }

            //Search Filter
            if (isset($_POST['searchKey']) && strlen(trim($_POST['searchKey'])) > 0 && isset($_POST['searchValue']) && strlen(trim($_POST['searchValue'])) > 0) {
                $searchKey = trim(htmlspecialchars($_POST['searchKey']));
                $searchValue = trim(htmlspecialchars($_POST['searchValue']));
                $allEventOrdersSearch[] = array(
                    "searchKey" => $searchKey,
                    "searchValue" => $searchValue
                );
                $_SESSION['allEventOrdersSearch'] = $allEventOrdersSearch;
            } else {
                if (isset($_SESSION['allEventOrdersSearch']) && count($_SESSION['allEventOrdersSearch']) > 0) {
                    $allEventOrdersSearch = $_SESSION['allEventOrdersSearch'];
                }
            }

            //Sort Filter
            if (isset($_POST['sortField']) && strlen(trim($_POST['sortField'])) > 0) {
                $sortField = trim(htmlspecialchars($_POST['sortField']));
                $allEventOrdersSort = array("sortField" => $sortField, "sortOrder" => 'DESC');
                $_SESSION['allEventOrdersSort'] = $allEventOrdersSort;
            } else {
                if (isset($_SESSION['allEventOrdersSort']) && count($_SESSION['allEventOrdersSort']) > 0) {
                    $allEventOrdersSort = $_SESSION['allEventOrdersSort'];
                }
            }

            //Pagination
            $currentPage = 1;
            $perPage = 9;
            if (isset($_GET['page']) && $_GET['page'] !== '' && is_numeric($_GET['page'])):
                $currentPage = trim(htmlspecialchars($_GET['page']));
            else:
                $currentPage = 1;
            endif;
            $startPage = ($currentPage - 1) * $perPage;
            $allEventOrdersLimit = array("limitOnset" => $startPage, "limitOffset" => $perPage);

            $allEventOrders = $eventModel->getAllEventOrdersList($allEventOrdersSearch, $allEventOrdersSort, $allEventOrdersLimit);
            if (!$allEventOrders || !is_array($allEventOrders)):
            ?>
                <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;No event orders found in the record.</div>
            <?php
            else:
            ?>
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-schedule">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Order Amount</th>
                                <th>Order Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allEventOrders as $eventOrderInfo): ?>
                                <!-- Events -->
                                <tr>
                                    <td>
                                        <div class="img-table">
                                            <img src="public/assets/images/misc/ff_placeholder.png" class="img-fluid" alt="<?php echo $eventOrderInfo['ffe_name']; ?>">
                                        </div>
                                    </td>
                                    <td><b><?php echo $eventOrderInfo['ffeo_oid']; ?></b></td>
                                    <td>&dollar;<?php echo number_format($eventOrderInfo['ffeo_total_amt'], 2, '.', ','); ?></td>
                                    <td><?php echo date('F jS Y, H:i:s', strtotime($eventOrderInfo['ffeo_order_date'])); ?></td>
                                    <td>
                                        <a type="button" href="admin/event/order/view/<?php echo $eventOrderInfo['ffeo_oid']; ?>" class="btn btn-red btn-sm">View&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-5 pt-5 border-top">

            <p class="fw-bold text-blue mb-3">Go to page</p>
            <!-- Pagination Begin -->
            <ul class="pagination">
                <?php
                $eventModel = new EventModel();
                $totalEventOrders = $eventModel->getTotalEventOrders();
                $totalPages = ceil($totalEventOrders / $perPage);
                ?>
                <!-- First Page -->
                <li class="page-item"><a href="admin/event/order/list?page=1" class="page-link"><i class="fa fa-angle-double-left" aria-hidden="true"></i>&nbsp;First</a></li>
                <?php
                //Previous Page
                if ($currentPage > 1) {
                ?>
                    <li class="page-item"><a href="admin/event/order/list?page=<?php echo $currentPage - 1 ?>" class="page-link"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;Prev</a></li>
                <?php
                }
                //Next Page
                if ($currentPage < $totalPages) {
                ?>
                    <li class="page-item"><a href="admin/event/order/list?page=<?php echo $currentPage + 1 ?>" class="page-link">Next&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a></li></a></li>
                <?php
                }
                ?>
                <!-- Last Page -->
                <li class="page-item"><a href="admin/event/order/list?page=<?php echo $totalPages; ?>" class="page-link">Last&nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li></a></li>
            </ul>
            <!-- Pagination End -->

        </div>
    </div>

</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../../../templates/modal.php");  ?>

<?php
include_once(__DIR__ . "/../../../templates/footer.php");
ob_end_flush();
?>