<?php
ob_start();
include_once(__DIR__ . '/../templates/header.php');
include_once(__DIR__ . '/../../models/event_model.php');
include_once(__DIR__ . '/../../models/game_model.php');
include_once(__DIR__ . '/../../models/category_model.php');
?>

<div class="container-fluid page">

    <div class="row justify-content-center">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
            <h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Cart</h1>
        </div>
    </div>

</div>

<div class="container">

    <div class="row">

        <?php
        if (
            isset($_SESSION['bccc_event_game']) &&
            is_array($_SESSION['bccc_event_game']) &&
            count($_SESSION['bccc_event_game']) > 0
        ):
            $eventModel = new EventModel();
            $gameModel = new GameModel();
            $categoryModel = new CategoryModel();

            foreach ($_SESSION['bccc_event_game'] as $event_game):
                $eventGameInfo = $eventModel->getEventGameByUID($event_game['eventGameUID']);
                $eventInfo = $eventModel->getEventByUID($eventGameInfo['ffeg_event_uid']);
                $gameInfo = $gameModel->getGameByUID($eventGameInfo['ffeg_game_uid']);
                $categoryInfo = $categoryModel->getCategoryByUID($eventGameInfo['ffeg_category_uid']);
        ?>


                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 my-3 d-flex align-items-stretch">
                    <div class="card feature-card bg-white shadow-sm border border-2 pb-3">
                        <img src="public/assets/images/game/<?php echo $gameInfo['ffg_image']; ?>" class="card-img-top" alt="<?php echo $gameInfo['ffg_name']; ?>">

                        <div class="card-body text-center">
                            <h5 class="card-title text-red fw-bold mb-2"><?php echo $gameInfo['ffg_name']; ?></h5>
                            <span class="badge bg-warning text-gray fw-bold mb-2"><?php echo $categoryInfo['ffec_name']; ?></span>
                            <p class="card-text">
                                <?php if ($eventGameInfo['ffeg_game_session'] == 2): ?>
                                    <span class="d-block fs-6 fw-bold text-blue">Additional Play Option</span>
                                <?php else: ?>
                                    <span class="d-block fs-6 fw-bold text-red"><?php echo date('l', strtotime($eventGameInfo['ffeg_game_date'])); ?></span>
                                    <span class="d-block fs-6 fw-bold text-blue"><?php echo date('F jS, Y', strtotime($eventGameInfo['ffeg_game_date'])); ?></span>
                                <?php endif; ?>
                                <span class="d-block fs-5 text-red fw-bold mt-2">&dollar;<?php echo number_format($event_game['eventGamePrice'], 2, '.', ','); ?></span>
                                <span class="d-block fs-6 text-blue fw-bold"><?php echo $event_game['eventGameSlots']; ?>&nbsp;<?php echo $categoryInfo['ffec_name']; ?>
                                    <?php if ($categoryInfo['ffec_uid'] == 'FFEC98662'): ?>
                                        <span class="small text-red">&nbsp;&#40;<?php echo ($event_game['eventGameSlots'] * 4); ?>&nbsp;Wristbands&#41;</span>
                                    <?php endif; ?>
                                </span>
                            </p>

                            <div class="d-grid gap-2 justify-content-sm-center">
                                <button type="button" id="<?php echo $event_game['eventGameUID']; ?>" class="btn btn-red btn-sm-block btn-del-event-list-confirm"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Remove</button>
                            </div>

                        </div>

                    </div>
                </div>


            <?php
            endforeach;
            ?>


            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 mt-3 pt-5 border-top">
                <h2 class="fs-2 text-blue text-center text-capitalize fw-bold mb-3">Ready to Checkout?</h2>
                <h2 class="fs-2 text-blue text-center text-uppercase fw-bold text-responsive-d3 mt-0"><a class="btn btn-lg btn-red" href="event/participant">Proceed&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a></h2>
            </div>


        <?php
        else:
        ?>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                <div class="alert alert-danger p-5">
                    <h2 class="display-1 text-center text-red"><i class="fa fa-shopping-cart" aria-hidden="true"></i></h2>
                    <p class="text-center text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;No items found in cart.</p>
                    <div class="d-flex justify-content-center">
                        <a type="button" href="event/view/FFE75100" class="btn btn-blue text-uppercase fw-bold">Buy Now&nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        <?php
        endif;
        ?>

    </div>


    <!-- More Event Games -->

    <div class="row justify-content-center">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-red py-3 mt-5 mb-3'>
            <h1 class='fs-3 fw-bold text-white text-center text-uppercase mb-0'>More From This Event</h1>
        </div>
    </div>

    <div class="row justify-content-start">
        <?php
        $eventModel = new EventModel();
        $allEventGamesSearch = array();
        $allEventGamesSort = array();
        $allEventGamesLimit = array("limitOnset" => 0, "limitOffset" => 3);
        $allEventGames = $eventModel->getAllEventGames($allEventGamesSearch, $allEventGamesSort, $allEventGamesLimit);
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
                $eventInfo = $eventModel->getEventByUID($eventGameItem['ffeg_event_uid']);
                $categoryInfo = $categoryModel->getCategoryByUID($eventGameItem['ffeg_category_uid']);
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
                                <p class="card-text">
                                    <span class="badge bg-warning text-gray fw-bold mb-2"><?php echo $categoryInfo['ffec_name']; ?></span>
                                    <?php if ($eventGameItem['ffeg_game_session'] == 2): ?>
                                        <span class="d-block fs-6 fw-bold text-blue">Additional Play Option</span>
                                    <?php else: ?>
                                        <span class="d-block fs-6 fw-bold text-red"><?php echo date('l', strtotime($eventGameItem['ffeg_game_date'])); ?></span>
                                        <span class="d-block fs-6 fw-bold text-blue"><?php echo date('F jS, Y', strtotime($eventGameItem['ffeg_game_date'])); ?></span>
                                    <?php endif; ?>
                                    <span class="d-block fs-5 fw-bold text-red mt-2">&dollar;<?php echo number_format($gameInfo['ffg_price'], 2, '.', ','); ?></span>
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



</div>


<!-- AJAX response Modal -->

<div class="modal fade" tabindex="-1" id="ajaxResponse">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-white">
                <h5 class="modal-title text-red fw-bold"><?php echo $aboutJSONEnc['Facilitator']['title']; ?></h5>
            </div>
            <div class="modal-body text-center">
                <i class="fa fa-5x mb-3" aria-hidden="true"></i>
                <p class="fw-bold mb-0"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-red" data-bs-dismiss="modal" onclick="window.location.reload();">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Action Modal -->

<div class="modal fade" tabindex="-1" id="confirmAction">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-white">
                <h5 class="modal-title text-red fw-bold"><?php echo $aboutJSONEnc['Facilitator']['title']; ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fa fa-exclamation-circle fa-5x text-red mb-3" aria-hidden="true"></i>
                <p class="text-red fw-bold mb-0">Confirm remove selected?</p>
            </div>
            <div class="modal-footer">
                <a href="event/remove" type="button" class="btn btn-red btn-del-event-list">Yes</a>
                <button type="button" class="btn btn-blue" data-bs-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<?php
include_once(__DIR__ . "/../templates/footer.php");
ob_end_flush();
?>