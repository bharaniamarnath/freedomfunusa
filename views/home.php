<?php
include_once(__DIR__ . '/templates/header.php');
include_once(__DIR__ . '/../models/event_model.php');
include_once(__DIR__ . '/../models/category_model.php');
include_once(__DIR__ . '/../models/game_model.php');
?>


<!-- Hero Begin -->

<div class="container page">


<div id="snowfall" class="row flex-md-row-reverse justify-content-center align-items-center bg-red rounded-3 mx-auto mb-4 px-4 py-5">
  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4 snowfall-content">
    <img src="public/assets/images/features/ff_hero_banner.png" class="img-fluid border border-5 rounded-3" alt="<?php echo $aboutJSONEnc['EventHeading']; ?>" loading="lazy">
  </div>

  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 snowfall-content">

            <h1 class="display-5 text-white text-uppercase fw-bold lh-1 mb-4">Skip The Lines and Save!</h1>
            <p class="lead text-white mb-4">Pre purchase your Old Town Christmas Festival tokens &amp; wristbands now!</p>
            <div class="d-grid gap-2 d-lg-flex justify-content-md-start">
                <a type="button" href="event/game/view/FFEG15062" class="btn btn-yellow btn-lg fw-bold me-md-2">
                    Buy Tokens&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                </a>
                <a type="button" href="event/game/view/FFEG67649" class="btn btn-blue btn-lg fw-bold">
                    Buy Wristbands&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>

    </div>

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
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 mt-5">
            <h2 class="fs-4 text-red text-center fw-bold text-responsive-d3 mb-3">For more information about the event</h2>
            <h2 class="fs-2 text-blue text-center fw-bold text-responsive-d3 mt-0">Visit <a class="text-decoration-none text-blue" href="https://visitleandertx.com/leander-attractions-and-activities/leander-festivals/old-town-christmas-festival/">visitleandertx.com</a></h2>
        </div>
    </div>
</div>

<?php include_once(__DIR__ . '/templates/footer.php'); ?>