<?php
ob_start();
include_once(__DIR__ . '/../../../application/sessions.php');
include_once(__DIR__ . "/../../../models/event_model.php");
include_once(__DIR__ . "/../../../models/category_model.php");
include_once(__DIR__ . "/../../../models/misc_model.php");
$sessions = new Sessions();
$adminSession = $sessions->adminSession();
if (!$adminSession) {
    exit(header('Location: ../login'));
}
?>

<?php
include_once(__DIR__ . '/../../templates/header_admin.php');
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
            <li class="breadcrumb-item active" aria-current="page">Walk-In</li>
        </ol>
    </nav>

    <div class="row justify-content-start">

        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
            <form name="allAdminEventSearchForm" id="allAdminEventSearchForm" action="admin/signup/event" method="POST">
                <div class="input-group mb-3">
                    <input type="text" name="searchValue" id="searchValue" class="form-control" placeholder="Event ID" required />
                    <input type="hidden" name="searchKey" id="searchKey" value="ffe_uid" />
                    <button type="submit" class="btn btn-blue" name="allAdminEventSearchSubmit" id="allAdminEventSearchSubmit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                </div>
            </form>
        </div>

        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
            <form name="allAdminEventSortFilterForm" id="allAdminEventSortFilterForm" action="admin/signup/event" method="POST">
                <div class="input-group mb-3">
                    <select name="sortField" id="sortField" class="form-select">
                        <option value="ffe_uid">Event ID</option>
                        <option value="ffe_created_date">Registered Date</option>
                    </select>
                    <button type="submit" class="btn btn-blue" name="allAdminEventSortFilterSubmit" id="allAdminEventSortFilterSubmit"><i class="fa fa-sort" aria-hidden="true"></i>&nbsp;Sort</button>
                </div>
            </form>
        </div>

        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
            <form name="allAdminEventClearFilterForm" id="allAdminEventClearFilterForm" action="admin/signup/event" method="POST">
                <button type="submit" class="btn btn-red" name="allAdminEventClearFilter" id="allAdminEventClearFilter"><i class="fa fa-undo" aria-hidden="true"></i>&nbsp;Reset</button>
            </form>
        </div>

    </div>

    <div class="row">
        <?php
        $eventModel = new EventModel();

        $allAdminEventSearch = array();
        $allAdminEventSort = array();
        $allAdminEventLimit = array();

        //Clear Filters
        if (isset($_POST['allAdminEventClearFilter'])) {
            if (isset($_SESSION['allAdminEventSearch'])) {
                unset($_SESSION['allAdminEventSearch']);
            }
            if (isset($_SESSION['allAdminEventSort'])) {
                unset($_SESSION['allAdminEventSort']);
            }
        }

        //Search Filter
        if (isset($_POST['searchKey']) && strlen(trim($_POST['searchKey'])) > 0 && isset($_POST['searchValue']) && strlen(trim($_POST['searchValue'])) > 0) {
            $searchKey = trim(htmlspecialchars($_POST['searchKey']));
            $searchValue = trim(htmlspecialchars($_POST['searchValue']));
            $allAdminEventSearch[] = array(
                "searchKey" => $searchKey,
                "searchValue" => $searchValue
            );
            $_SESSION['allAdminEventSearch'] = $allAdminEventSearch;
        } else {
            if (isset($_SESSION['allAdminEventSearch']) && count($_SESSION['allAdminEventSearch']) > 0) {
                $allAdminEventSearch = $_SESSION['allAdminEventSearch'];
            }
        }

        //Sort Filter
        if (isset($_POST['sortField']) && strlen(trim($_POST['sortField'])) > 0) {
            $sortField = trim(htmlspecialchars($_POST['sortField']));
            $allAdminEventSort = array("sortField" => $sortField, "sortOrder" => 'DESC');
            $_SESSION['allAdminEventSort'] = $allAdminEventSort;
        } else {
            if (isset($_SESSION['allAdminEventSort']) && count($_SESSION['allAdminEventSort']) > 0) {
                $allAdminEventSort = $_SESSION['allAdminEventSort'];
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
        $allAdminEventLimit = array("limitOnset" => $startPage, "limitOffset" => $perPage);

        $allEvents = $eventModel->getAllEvents($allAdminEventSearch, $allAdminEventSort, $allAdminEventLimit);

        if (!$allEvents || !is_array($allEvents)):
        ?>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;No events found in the record.</div>
            </div>
            <?php
        else:
            foreach ($allEvents as $event):
            ?>
                <!-- Event Info -->
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                    <div class="card h-100 shadow-sm p-3">
                        <div class="row g-0">
                            <div class="col-3">
                                <?php if (is_file("public/assets/images/event/" . $event['ffe_image'])): ?>
                                    <img src="public/assets/images/event/<?php echo $event['ffe_image']; ?>" class="img-thumbnail" alt="<?php echo $event['ffe_name']; ?>">
                                <?php else: ?>
                                    <img src="public/assets/images/misc/ff_placeholder.png" class="img-thumbnail" alt="<?php echo $event['ffe_name']; ?>">
                                <?php endif ?>
                            </div>
                            <div class="col-9">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="fs-6 text-red fw-bold mb-1"><?php echo $event['ffe_name']; ?></h5>
                                    <p class="text-gray"><?php echo date('F jS, Y', strtotime($event['ffe_start_date'])); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white d-grid gap-1 d-md-flex justify-content-md-end border-0">
                            <a href="admin/signup/list/<?php echo $event['ffe_uid'] ?>" class="btn btn-blue btn-sm">View</a>
                        </div>
                    </div>
                </div>

            <?php
            endforeach;
            ?>
        <?php
        endif;
        ?>
    </div>


    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-5 pt-5 border-top">

            <p class="fw-bold text-blue mb-3">Go to page</p>
            <!-- Pagination Begin -->
            <ul class="pagination">
                <?php
                $eventModel = new EventModel();
                $totalEvents = $eventModel->getTotalEvents();
                $totalPages = ceil($totalEvents / $perPage);
                ?>
                <!-- First Page -->
                <li class="page-item"><a href="admin/signup/event?page=1" class="page-link"><i class="fa fa-angle-double-left" aria-hidden="true"></i>&nbsp;First</a></li>
                <?php
                //Previous Page
                if ($currentPage > 1) {
                ?>
                    <li class="page-item"><a href="admin/signup/event?page=<?php echo $currentPage - 1 ?>" class="page-link"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;Prev</a></li>
                <?php
                }
                //Next Page
                if ($currentPage < $totalPages) {
                ?>
                    <li class="page-item"><a href="admin/signup/event?page=<?php echo $currentPage + 1 ?>" class="page-link">Next&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a></li></a></li>
                <?php
                }
                ?>
                <!-- Last Page -->
                <li class="page-item"><a href="admin/signup/event?page=<?php echo $totalPages; ?>" class="page-link">Last&nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li></a></li>
            </ul>
            <!-- Pagination End -->

        </div>
    </div>

</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../../templates/modal.php");  ?>

<?php
include_once(__DIR__ . "/../../templates/footer.php");
ob_end_flush();
?>