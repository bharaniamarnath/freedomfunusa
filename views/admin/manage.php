<?php
ob_start();
include_once(__DIR__ . '/../../application/sessions.php');
include_once(__DIR__ . '/../../models/admin_model.php');
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
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Manage</h1>
        </div>
    </div>

</div>

<div class="container">

    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage</li>
        </ol>
    </nav>

    <!-- Dashboard Menu -->

    <?php
        $adminManageList = array(
            array("Orders", "View event orders, participants and games", "admin/event/order/list", "View"),
            array("Events", "Add new event, update or delete existing events", "admin/event/list", "Manage"),
            array("Games", "Add new game, update or delete existing games", "admin/game/list", "Manage"),
            array("Walk-In", "Register walk-in participants on event", "admin/signup/event", "Register"),
            array("Categories", "Add new category, update or delete existing categories", "admin/category/list", "Manage"),
            array("Settings", "Set event details, links and constants", "admin/settings", "Update"),
        );
    ?>

    <div class="row">

            <?php for ($aml = 0; $aml < count($adminManageList); $aml++): ?>

        <!-- Event Orders -->
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
            <div class="card h-100 shadow-sm p-3">
                <div class="card-body d-flex flex-column">
                    <h5 class="fs-6 <?php echo ($aml % 2 == 0) ? "text-red" : "text-blue"; ?> fw-bold"><?php echo $adminManageList[$aml][0]; ?></h5>
                    <p class="text-gray"><?php echo $adminManageList[$aml][1]; ?></p>
                </div>
                <div class="card-footer d-grid justify-content-end bg-white border-0">
                    <a href="<?php echo $adminManageList[$aml][2]; ?>" class="btn <?php echo ($aml % 2 == 0) ? "btn-red" : "btn-blue"; ?> btn-sm"><?php echo $adminManageList[$aml][3]; ?></a>
                </div>
            </div>
        </div>

        <?php endfor; ?>
    </div>

</div>

</div>

<?php
include_once(__DIR__ . "/../templates/footer.php");
ob_end_flush();
?>