<?php
ob_start();
include_once(__DIR__ . '/../../../models/event_model.php');
include_once(__DIR__ . '/../../../models/category_model.php');
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

        <?php if (!isset($event_id) && $event_id == null && $event_id == ''): ?>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get event ID</div>
            </div>
            <?php
        else:
            $categoryModel = new CategoryModel();
            $eventCategories = $categoryModel->getCategoriesByEventUID($event_id);
            foreach ($eventCategories as $eventCategory):
                $eventModel = new EventModel();
                $eventInfo = $eventModel->getEventByUID($eventCategory['ffec_event_uid']);
                $eventGamesByCategory = $eventModel->getEventGamesByEventCategory($eventCategory['ffec_event_uid'], $eventCategory['ffec_uid']);
            ?>

                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 my-3 d-flex align-items-stretch">
                    <div class="card feature-card bg-white shadow-sm border border-2 pb-3">
                        <?php if (is_file("public/assets/images/category/" . $eventCategory['ffec_image'])) : ?>
                            <img src="public/assets/images/category/<?php echo $eventCategory['ffec_image']; ?>" class="card-img-top" alt="<?php echo $eventCategory['ffec_name']; ?>">
                        <?php else: ?>
                            <img src="public/assets/images/misc/ff_placeholder.png" class="card-img-top" alt="<?php echo $eventCategory['ffec_name']; ?>">
                        <?php endif ?>
                        <div class="card-body text-center">
                            <h5 class="card-title text-red fw-bold text-uppercase"><?php echo $eventCategory['ffec_name']; ?></h5>
                            <p class="card-text">
                                <span class="d-block fs-6 fw-bold text-blue"><?php echo $eventInfo['ffe_name']; ?></span>
                                <span class="d-block fs-6 fw-bold text-red"><?php echo count($eventGamesByCategory) > 0 ? count($eventGamesByCategory) . ' Game(s)' : 'No Games'; ?></span>
                            </p>

                            <div class="d-grid gap-2 justify-content-sm-center">
                                <a href="event/category/view/<?php echo $eventCategory['ffec_uid']; ?>" class="btn btn-red btn-lg btn-sm-block">View Category&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                            </div>

                        </div>
                    </div>
                </div>


        <?php
            endforeach;
        endif;
        ?>


    </div>

</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../../templates/modal.php");  ?>

<?php
include_once(__DIR__ . "/../../templates/footer.php");
ob_end_flush();
?>