<?php
ob_start();
include_once(__DIR__ . '/../../../application/sessions.php');
include_once(__DIR__ . "/../../../models/freeplay_model.php");
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
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Freeplay</h1>
        </div>
    </div>

</div>

<div class="container">

    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="admin/manage">Manage</a></li>
            <li class="breadcrumb-item active" aria-current="page">Freeplay</li>
        </ol>
    </nav>

    <!-- Dashboard Menu -->

    <div class="row justify-content-start">

        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
            <form name="adminFreeplaySearchForm" id="adminFreeplaySearchForm" action="admin/freeplay/list" method="POST">
                <div class="input-group mb-3">
                    <input type="text" name="searchValue" id="searchValue" class="form-control" placeholder="Freeplay ID" required />
                    <input type="hidden" name="searchKey" id="searchKey" value="fffp_uid" />
                    <button type="submit" class="btn btn-blue" name="adminFreeplaySearchSubmit" id="adminFreeplaySearchSubmit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                </div>
            </form>
        </div>

        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
            <form name="adminFreeplaySortFilterForm" id="adminFreeplaySortFilterForm" action="admin/freeplay/list" method="POST">
                <div class="input-group mb-3">
                    <select name="sortField" id="sortField" class="form-select">
                        <option value="fffp_uid">Freeplay ID</option>
                        <option value="fffp_created_date">Registered Date</option>
                    </select>
                    <button type="submit" class="btn btn-blue" name="adminFreeplaySortFilterSubmit" id="adminFreeplaySortFilterSubmit"><i class="fa fa-sort" aria-hidden="true"></i>&nbsp;Sort</button>
                </div>
            </form>
        </div>

        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
            <form name="adminFreeplayClearFilterForm" id="adminFreeplayClearFilterForm" action="admin/freeplay/list" method="POST">
                <button type="submit" class="btn btn-red" name="adminFreeplayClearFilter" id="adminFreeplayClearFilter"><i class="fa fa-undo" aria-hidden="true"></i>&nbsp;Reset</button>
            </form>
        </div>

    </div>

    <div class="row">

        <?php
        $freeplayModel = new FreeplayModel();

        $allAdminFreeplaySearch = array();
        $allAdminFreeplaySort = array();
        $allAdminFreeplayLimit = array();

        //Clear Filters
        if (isset($_POST['adminFreeplayClearFilter'])) {
            if (isset($_SESSION['allAdminFreeplaySearch'])) {
                unset($_SESSION['allAdminFreeplaySearch']);
            }
            if (isset($_SESSION['allAdminFreeplaySort'])) {
                unset($_SESSION['allAdminFreeplaySort']);
            }
        }

        //Search Filter
        if (isset($_POST['searchKey']) && strlen(trim($_POST['searchKey'])) > 0 && isset($_POST['searchValue']) && strlen(trim($_POST['searchValue'])) > 0) {
            $searchKey = trim(htmlspecialchars($_POST['searchKey']));
            $searchValue = trim(htmlspecialchars($_POST['searchValue']));
            $allAdminFreeplaySearch[] = array(
                "searchKey" => $searchKey,
                "searchValue" => $searchValue
            );
            $_SESSION['allAdminFreeplaySearch'] = $allAdminFreeplaySearch;
        } else {
            if (isset($_SESSION['allAdminFreeplaySearch']) && count($_SESSION['allAdminFreeplaySearch']) > 0) {
                $allAdminFreeplaySearch = $_SESSION['allAdminFreeplaySearch'];
            }
        }

        //Sort Filter
        if (isset($_POST['sortField']) && strlen(trim($_POST['sortField'])) > 0) {
            $sortField = trim(htmlspecialchars($_POST['sortField']));
            $allAdminFreeplaySort = array("sortField" => $sortField, "sortOrder" => 'DESC');
            $_SESSION['allAdminFreeplaySort'] = $allAdminFreeplaySort;
        } else {
            if (isset($_SESSION['allAdminFreeplaySort']) && count($_SESSION['allAdminFreeplaySort']) > 0) {
                $allAdminFreeplaySort = $_SESSION['allAdminFreeplaySort'];
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
        $allAdminFreeplayLimit = array("limitOnset" => $startPage, "limitOffset" => $perPage);

        $allFreeplays = $freeplayModel->getAllFreeplays($allAdminFreeplaySearch, $allAdminFreeplaySort, $allAdminFreeplayLimit);
        
        
        if (!$allFreeplays || !is_array($allFreeplays)):
            ?>
                <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;No freeplay records found in the record.</div>
            <?php
            else:
            ?>
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-schedule">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allFreeplays as $freeplayInfo): ?>
                                <!-- Events -->
                                <tr>
                                    <td>
                                        <div class="img-table">
                                            <img src="public/assets/images/misc/ff_placeholder.png" class="img-fluid" alt="<?php echo $freeplayInfo['fffp_name']; ?>">
                                        </div>
                                    </td>
                                    <td><b><?php echo $freeplayInfo['fffp_uid']; ?></b></td>
                                    <td><?php echo $freeplayInfo['fffp_name']; ?></td>
                                    <td><?php echo $freeplayInfo['fffp_email']; ?></td>
                                    <td><?php echo date('F jS Y, H:i:s', strtotime($eventOrderInfo['fffp_created_date'])); ?></td>
                                    <td>
                                        <a type="button" href="admin/freeplay/view/<?php echo $freeplayInfo['fffp_uid']; ?>" class="btn btn-red btn-sm">View&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

    </div>


    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-5 pt-5 border-top">

            <p class="fw-bold text-blue text-uppercase mb-3">Go to page</p>
            <!-- Pagination Begin -->
            <ul class="pagination">
                <?php
                $freeplayModel = new FreeplayModel();
                $totalFaculties = $freeplayModel->getTotalFreeplays();
                $totalPages = ceil($totalFaculties / $perPage);
                ?>
                <!-- First Page -->
                <li class="page-item"><a href="admin/freeplay/list?page=1" class="page-link"><i class="fa fa-angle-double-left" aria-hidden="true"></i>&nbsp;First</a></li>
                <?php
                //Previous Page
                if ($currentPage > 1) {
                ?>
                    <li class="page-item"><a href="admin/freeplay/list?page=<?php echo $currentPage - 1 ?>" class="page-link"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;Prev</a></li>
                <?php
                }
                //Next Page
                if ($currentPage < $totalPages) {
                ?>
                    <li class="page-item"><a href="admin/freeplay/list?page=<?php echo $currentPage + 1 ?>" class="page-link">Next&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a></li></a></li>
                <?php
                }
                ?>
                <!-- Last Page -->
                <li class="page-item"><a href="admin/freeplay/list?page=<?php echo $totalPages; ?>" class="page-link">Last&nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li></a></li>
            </ul>
            <!-- Pagination End -->

        </div>
    </div>


</div>

<?php
include_once(__DIR__ . "/../../templates/footer.php");
ob_end_flush();
?>