<?php
include_once(__DIR__ . '/templates/header.php');
include_once(__DIR__ . '/../models/event_model.php');
include_once(__DIR__ . '/../models/category_model.php');
include_once(__DIR__ . '/../models/game_model.php');
?>


<!-- Promotion Banner Begin -->

<div class="container-fluid promo">
    <div class="row justify-content-center">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 p-0">
            <a href="<?php echo $aboutJSONEnc['Organisation']['website']; ?>" target=”_blank” class="text-decoration-none">
                <img src="public/assets/images/features/ff_promotion_banner.png" class="img-fluid d-block mx-auto w-100" alt="<?php echo $aboutJSONEnc['EventHeading']; ?>" loading="lazy">
            </a>
        </div>
    </div>
</div>

<!-- Promotion Banner End -->

<!-- Hero Begin -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 bg-blue p-5 mb-0">
            <h2 class="fs-1 text-white text-center text-uppercase fw-bold mb-3">Skip The Lines and Save!</h2>
            <p class="fs-4 text-white text-center mt-0 mb-4">Pre purchase your Old Town Christmas Festival tokens &amp; wristbands now!</p>
            <div class="d-grid gap-2 d-md-flex justify-content-center">
                <a type="button" href="event/token/view/FFEG15062" class="btn btn-warning btn-lg fw-bold px-4 me-md-2">Buy Tokens&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                <a type="button" href="event/wristband/view/FFEG67649" class="btn btn-outline-light btn-lg fw-bold px-4 me-md-2">Buy Wristbands&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Event Gallery Begin -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 bg-warning px-5 py-3 mb-0">
            <h2 class="fs-1 text-grey text-center text-uppercase fw-bold mb-0">Play these games &amp; more with your tokens &amp; Wristbands!</h2>
        </div>
    </div>
</div>


<?php
$eventGameGallery = array(
    array("trackless_train.png", "Trackless Train", "bg-red"),
    array("snow_globe.png", "Snow Globe", "bg-blue"),
    array("4g.png", "4G", "bg-red"),
    array("mechanical_bull.png", "Mechanical Bull", "bg-blue"),
    array("rockwall.png", "Rock Wall", "bg-red"),
    array("laser_tag.png", "Laser Tag", "bg-blue"),
    array("petting_zoo.png", "Petting Zoo", "bg-red"),
    array("pony_ride.png", "Pony Ride", "bg-blue"),
);
?>

<div class="container mt-5">
    <div class="row">

        <?php for ($egg = 0; $egg < count($eventGameGallery); $egg++): ?>

            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 my-3 d-flex align-items-stretch">
                <div class="card feature-card bg-white shadow-sm border border-2">
                    <img src="public/assets/images/features/games/<?php echo $eventGameGallery[$egg][0]; ?>" class="card-img-top" alt="<?php echo $eventGameGallery[$egg][1]; ?>">
                    <div class="card-body text-center <?php echo $eventGameGallery[$egg][2]; ?>">
                        <h5 class="card-title text-white fw-bold text-uppercase"><?php echo $eventGameGallery[$egg][1]; ?></h5>
                    </div>
                </div>
            </div>

        <?php endfor; ?>

    </div>
</div>

<!-- Hero End -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 mt-5">
            <h2 class="fs-4 text-red text-center text-capitalize fw-bold text-responsive-d3 mb-3">For more information about the event</h2>
            <h2 class="fs-2 text-blue text-center text-uppercase fw-bold text-responsive-d3 mt-0">Visit <a class="text-decoration-none text-blue" href="https://visitleandertx.com/leander-attractions-and-activities/leander-festivals/old-town-christmas-festival/">visitleandertx.com</a></h2>
        </div>
    </div>
</div>

<?php include_once(__DIR__ . '/templates/footer.php'); ?>