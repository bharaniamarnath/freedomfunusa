<?php
ob_start();
include_once(__DIR__ . '/../../../models/event_model.php');
include_once(__DIR__ . '/../../../models/game_model.php');
include_once(__DIR__ . '/../../../models/category_model.php');
include_once(__DIR__ . "/../../../models/misc_model.php");
include_once(__DIR__ . "/../../../models/methods_model.php");
?>

<?php
include_once(__DIR__ . '/../../templates/header.php');
?>

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Event</h1>
        </div>
    </div>

</div>

<!-- Promotion Banner Begin -->

<div class="container">
    <div class="row mx-auto rounded-3 overflow-hidden">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 p-0">
            <a href="<?php echo $aboutJSONEnc['Organisation']['website']; ?>" target=”_blank” class="text-decoration-none">
                <img src="public/assets/images/features/ff_promotion_banner.png" class="img-fluid d-block mx-auto w-100" alt="<?php echo $aboutJSONEnc['EventHeading']; ?>" loading="lazy">
            </a>
        </div>
    </div>
</div>

<!-- Promotion Banner End -->

<div class="container">


    <?php if (!isset($event_id) && $event_id == null && $event_id == ''): ?>
        <div class="row justify-content-center mt-4">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get event information.</div>
            </div>
            <?php
        else:
            $eventModel = new EventModel();
            $categoryModel = new CategoryModel();
            $methodsModel = new MethodsModel();

            $eventInfo = $eventModel->getEventByUID($event_id);
            if (empty($eventInfo) || !is_array($eventInfo)):
            ?>
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                    <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get event information.</div>
                </div>
        </div>
    <?php
            else:
    ?>

        <div class="row justify-content-center my-4">
            <?php
                $eventModel = new EventModel();
                $allEventGames = $eventModel->getEventGamesByEventUID($event_id);
                if (!$allEventGames || !is_array($allEventGames)):
            ?>
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                    <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;No event games found in the record.</div>
                </div>
                <?php
                else:
                    foreach ($allEventGames as $eventGameItem):
                        $gameModel = new GameModel();
                        $categoryModel = new CategoryModel();
                        $gameInfo = $gameModel->getGameByUID($eventGameItem['ffeg_game_uid']);
                        $categoryInfo = $categoryModel->getCategoryByUID($eventGameItem['ffeg_category_uid']);
                        if ($eventGameItem['ffeg_availability'] == 1):
                ?>



                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12 my-3 d-flex align-items-stretch">
                            <div class="card feature-card bg-white shadow-sm border border-2 pb-3">
                                <?php if (is_file("public/assets/images/game/" . $gameInfo['ffg_image'])) : ?>
                                    <img src="public/assets/images/game/<?php echo $gameInfo['ffg_image']; ?>" class="card-img-top" alt="<?php echo $gameInfo['ffg_name']; ?>">
                                <?php else: ?>
                                    <img src="public/assets/images/misc/ff_placeholder.png" class="card-img-top" alt="<?php echo $gameInfo['ffg_name']; ?>">
                                <?php endif ?>
                                <div class="card-body text-center">
                                <h5 class="card-title text-red fw-bold"><?php echo $gameInfo['ffg_name']; ?></h5>
                                <p class="card-text">
                                    <span class="badge bg-warning text-gray fw-bold mb-2"><?php echo $categoryInfo['ffec_name']; ?></span>
                                    <span class="d-block fs-5 fw-bold text-gray mt-2">&dollar;<?php echo number_format($gameInfo['ffg_price'], 2, '.', ','); ?></span>
                                </p>

                                    <div class="d-grid gap-2 justify-content-sm-center">
                                        <?php $categoryPath = 'event/game/view/'; ?>
                                        <?php if ($eventGameItem['ffeg_slots'] > 1): ?>
                                            <a href="<?php echo $categoryPath . $eventGameItem['ffeg_uid']; ?>" class="btn btn-red btn-sm-block">Buy Now&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                                        <?php else: ?>
                                            <a href="<?php echo $categoryPath . $eventGameItem['ffeg_uid']; ?>" class="btn btn-red btn-sm-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Slots Unavailable</a>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        </div>


            <?php
                        endif;
                    endforeach;
                endif;
            ?>
        </div>

<?php
            endif;
        endif;
?>

</div>

<!-- Event Gallery Begin -->

<div class="container">
    <div class="row mx-auto">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 p-4">
            <h2 class="fs-1 text-red text-center fw-bold mb-0">Play these games &amp; more</h2>
            <h2 class="fs-2 text-blue text-center fw-bold mt-1 mb-0">with your tokens &amp; wristbands!</h2>
        </div>
    </div>
</div>


<?php
$eventGameGallery = array(
    array("trackless_train.png", "Trackless Train"),
    array("snow_globe.png", "Snow Globe"),
    array("4g.png", "4G"),
    array("mechanical_bull.png", "Mechanical Bull"),
    array("rockwall.png", "Rock Wall"),
    array("laser_tag.png", "Laser Tag"),
    array("petting_zoo.png", "Petting Zoo"),
    array("pony_ride.png", "Pony Ride"),
);
?>

<div class="container">
    <div class="row mt-2">
        <div class="event-gallery-carousel owl-carousel owl-theme m-0 p-0">

        <?php for ($egg = 0; $egg < count($eventGameGallery); $egg++): ?>

        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 rounded item">
            <div class="card rounded-3 shadow-sm">
                <img src="public/assets/images/features/games/<?php echo $eventGameGallery[$egg][0]; ?>" class="card-img-top rounded p-2" alt="<?php echo $eventGameGallery[$egg][1]; ?>">
                <div class="card-body text-center">
                    <h5 class="card-title <?php echo ($egg % 2 == 0) ? "text-red" : "text-blue"; ?> fw-bold"><?php echo $eventGameGallery[$egg][1]; ?></h5>
                </div>
            </div>
        </div>

        <?php endfor; ?>
        
        </div>
    </div>
</div>

<!-- Event Gallery End -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 mt-0 pt-5 border-top">
            <h2 class="fs-2 text-blue text-center fw-bold mb-3">View <?php echo $aboutJSONEnc['EventHeading']; ?> schedule</h2>
            <h2 class="fs-2 text-blue text-center fw-bold text-responsive-d3 mt-0"><a class="btn btn-lg btn-red" href="about">View Schedule&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a></h2>
        </div>
    </div>
</div>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../../templates/modal.php");  ?>

<?php
include_once(__DIR__ . "/../../templates/footer.php");
ob_end_flush();
?>