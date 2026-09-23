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

<div class="container-fluid page">

    <div class="row justify-content-center">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
            <h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Event</h1>
        </div>
    </div>

</div>

<div class="container mt-5">

    <div class="row justofy-content-center">

        <?php if (!isset($category_id) && $category_id == null && $category_id == ''): ?>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get student ID</div>
            </div>
            <?php
        else:
            $eventModel = new EventModel();
            $categoryModel = new CategoryModel();
            $methodsModel = new MethodsModel();

            $categoryInfo = $categoryModel->getCategoryByUID($category_id);
            if (empty($categoryInfo) || !is_array($categoryInfo)):
            ?>
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                    <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get event information.</div>
                </div>
            <?php
            else:
            ?>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                    <?php if (is_file("public/assets/images/category/" . $categoryInfo['ffec_image'])) : ?>
                        <img src="public/assets/images/category/<?php echo $categoryInfo['ffec_image'] . '?v=' . uniqid(); ?>" class="card-img-top" alt="<?php echo $eventCategory['ffec_name']; ?>">
                    <?php else: ?>
                        <img src="public/assets/images/misc/ff_placeholder.png" class="card-img-top" alt="<?php echo $eventCategory['ffec_name']; ?>">
                    <?php endif ?>
                </div>

                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">

                    <!-- Display Category Info -->
                    <h2 class="display-4 text-red fw-bold"><?php echo $categoryInfo['ffec_name']; ?></h2>
                    <p class="text-blue fs-5 fw-bold my-0"><?php echo date('F jS, Y', strtotime($categoryInfo['ffec_created_date'])); ?></p>
                    <p class="text-gray lead mt-3"><?php echo htmlspecialchars_decode($categoryInfo['ffec_description']); ?></p>
                </div>

    </div>


    <div class="row justify-content-center">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-red py-3 mt-5 mb-3'>
            <h1 class='display-5 fw-bold text-white text-center text-uppercase mb-0'>Event Category Games</h1>
        </div>
    </div>

    <div class="row">
        <?php
                $eventModel = new EventModel();
                $alleventGames = $eventModel->getEventGamesByEventCategory($categoryInfo['ffec_event_uid'], $category_id);
                if (!$alleventGames || !is_array($alleventGames)):
        ?>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;No event category games found in the record.</div>
            </div>
            <?php
                else:
                    foreach ($alleventGames as $eventGameItem):
                        $gameModel = new GameModel();
                        $gameInfo = $gameModel->getGameByUID($eventGameItem['ffeg_game_uid']);
                        if ($eventGameItem['ffeg_availability'] == 1):
            ?>

                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 my-3 d-flex align-items-stretch">
                        <div class="card feature-card bg-white shadow-sm border border-2 pb-3">
                            <?php if (is_file("public/assets/images/game/" . $gameInfo['ffg_image'])) : ?>
                                <img src="public/assets/images/game/<?php echo $gameInfo['ffg_image']; ?>" class="card-img-top" alt="<?php echo $gameInfo['ffg_name']; ?>">
                            <?php else: ?>
                                <img src="public/assets/images/misc/ff_placeholder.png" class="card-img-top" alt="<?php echo $gameInfo['ffg_name']; ?>">
                            <?php endif ?>
                            <div class="card-body text-center">
                                <h5 class="card-title text-red fw-bold text-uppercase"><?php echo $gameInfo['ffg_name']; ?></h5>
                                <p class="card-text text-uppercase">
                                    <span class="d-block fs-6 fw-bold text-blue"><?php echo date('F jS, Y', strtotime($eventGameItem['ffeg_game_date'])); ?></span>
                                </p>

                                <div class="d-grid gap-2 justify-content-sm-center">
                                    <?php if ($eventGameItem['ffeg_slots'] > 1): ?>
                                        <a href="event/game/view/<?php echo $eventGameItem['ffeg_uid']; ?>" class="btn btn-red btn-lg btn-sm-block">Buy Now&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                                    <?php else: ?>
                                        <a href="event/game/view/<?php echo $eventGameItem['ffeg_uid']; ?>" class="btn btn-red btn-lg btn-sm-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Slots Unavailable</a>
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

</div>

<?php
            endif;
        endif;
?>

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../../templates/modal.php");  ?>

<?php
include_once(__DIR__ . "/../../templates/footer.php");
ob_end_flush();
?>