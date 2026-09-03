<?php
ob_start();
include_once(__DIR__ . '/../../../models/event_model.php');
include_once(__DIR__ . '/../../../models/event_model.php');
include_once(__DIR__ . "/../../../models/misc_model.php");
include_once(__DIR__ . "/../../../models/methods_model.php");
?>

<?php
include_once(__DIR__ . '/../../templates/header.php');
?>

<div class="container-fluid page">

    <div class="row justify-content-center">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
            <h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Event Categories</h1>
        </div>
    </div>

</div>

<div class="container">

    <div class="row">

        <?php
        $eventModel = new EventModel();
        $allEventsSearch = array();
        $allEventsSort = array();
        $allEventsLimit = array();
        $allEvents = $eventModel->getAllEvents($allEventsSearch, $allEventsSort, $allEventsLimit);
        foreach ($allEvents as $event):
        ?>

            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 my-3 d-flex align-items-stretch">
                <div class="card feature-card bg-white shadow-sm border border-2 pb-3">
                    <?php if (is_file("public/assets/images/event/" . $event['ffe_image'])) : ?>
                        <img src="public/assets/images/event/<?php echo $event['ffe_image']; ?>" class="card-img-top" alt="<?php echo $event['ffe_name']; ?>">
                    <?php else: ?>
                        <img src="public/assets/images/misc/ff_placeholder.png" class="card-img-top" alt="<?php echo $event['ffe_name']; ?>">
                    <?php endif ?>
                    <div class="card-body text-center">
                        <h5 class="card-title text-red fw-bold text-uppercase"><?php echo $event['ffe_name']; ?></h5>
                        <p class="card-text text-uppercase">
                            <span class="d-block fs-5 fw-bold text-blue"><?php echo $event['ffe_start_date']; ?></span>
                        </p>

                        <div class="d-grid gap-2 justify-content-sm-center">
                            <a href="event/view/<?php echo $event['ffe_uid']; ?>" class="btn btn-red btn-lg btn-sm-block">View Event&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                            <a href="event/categories/<?php echo $event['ffe_uid']; ?>" class="btn btn-blue btn btn-sm-block">View Categories&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                        </div>

                    </div>
                </div>
            </div>

        <?php
        endforeach;
        ?>


    </div>

</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../../templates/modal.php");  ?>

<?php
include_once(__DIR__ . "/../../templates/footer.php");
ob_end_flush();
?>