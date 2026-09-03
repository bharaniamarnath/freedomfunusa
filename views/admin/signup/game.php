<?php
ob_start();
include_once(__DIR__ . '/../../../models/event_model.php');
include_once(__DIR__ . '/../../../models/game_model.php');
include_once(__DIR__ . '/../../../models/category_model.php');
include_once(__DIR__ . "/../../../models/misc_model.php");
include_once(__DIR__ . "/../../../models/methods_model.php");
?>

<?php
include_once(__DIR__ . '/../../templates/header_admin.php');
?>

<div class="container-fluid page">

    <div class="row justify-content-center">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
            <h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Event Game</h1>
        </div>
    </div>

</div>

<div class="container mt-3">

    <div class="row">

        <?php if (!isset($event_game_id) && $event_game_id == null && $event_game_id == ''): ?>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get event game ID</div>
            </div>
            <?php
        else:
            $eventModel = new EventModel();
            $gameModel = new GameModel();
            $categoryModel = new CategoryModel();
            $methodsModel = new MethodsModel();

            $eventGameInfo = $eventModel->getEventGameByUID($event_game_id);
            if (empty($eventGameInfo) || !is_array($eventGameInfo)):
            ?>
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                    <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get event game information.</div>
                </div>
            <?php
            else:
            ?>

                <!-- Display Event Info -->
                <?php
                $eventInfo = $eventModel->getEventByUID($eventGameInfo['ffeg_event_uid']);
                ?>

                <?php
                $gameModel = new GameModel();
                $gameInfo = $gameModel->getGameByUID($eventGameInfo['ffeg_game_uid']);
                $categoryInfo = $categoryModel->getCategoryByUID($eventGameInfo['ffeg_category_uid']);
                ?>

                <div class="row">

                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                        <img src="public/assets/images/game/<?php echo $gameInfo['ffg_image'] . '?v=' . uniqid(); ?>" class="img-fluid border border-1" alt="<?php echo $gameInfo['ffg_name']; ?>" />
                    </div>

                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 py-3">

                        <h3 class="display-4 text-red fw-bold"><?php echo $gameInfo['ffg_name']; ?></h3>

                        <?php $eventInfo = $eventModel->getEventByUID($eventGameInfo['ffeg_event_uid']); ?>
                        <h5 class="fs-3 text-blue fw-bold"><?php echo $eventInfo['ffe_name']; ?></h5>
                        <h5 class="fs-5 text-red fw-bold mb-3"><?php echo $categoryInfo['ffec_name']; ?></h5>

                        <p class="fs-5 text-blue fw-bold"><?php echo date('F jS, Y', strtotime($eventGameInfo['ffeg_game_date'])); ?></p>

                        <h3 class="fs-2 text-red fw-bold">&dollar;<?php echo number_format($gameInfo['ffg_price'], 2, '.', ','); ?></h3>
                        <p class="text-gray lead mt-3"><?php echo htmlspecialchars_decode($eventGameInfo['ffeg_description']); ?></p>

                        <?php
                        //Check game Date
                        $eventGameStartDate = strtotime(date('Y-m-d', strtotime($eventGameInfo['ffeg_game_date'])));
                        $currentDate = strtotime(date('Y-m-d'));

                        //Check game slots
                        if ($eventGameInfo['ffeg_slots'] <= 1):
                        ?>
                            <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;No slots available for this event game</div>

                        <?php elseif ($eventGameStartDate < $currentDate): ?>

                            <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Event game was held on <?php echo date('F jS, Y', strtotime($eventGameInfo['ffeg_game_date'])); ?></div>

                        <?php else: ?>

                            <?php if ($eventGameInfo['ffeg_slots'] < 5): ?>
                                <div class="alert alert-info text-blue"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Only <?php echo $eventGameInfo['ffeg_slots']; ?> slots left!</div>
                            <?php endif; ?>

                            <form name="eventGameAddForm" id="eventGameAddForm" action="event/add" method="POST">

                                <div class="form-group pb-3">
                                    <label for="eventGameSlots" class="form-label required-field">Quantity</label>
                                    <div class="col-md-4">
                                        <input type='number' class='form-control' id='eventGameSlots' name='eventGameSlots' placeholder='Enter Quantity' max="<?php echo $eventGameInfo['ffeg_slots']; ?>" min="1" step="1">
                                    </div>
                                </div>

                                <input type="hidden" value="<?php echo $methodsModel->sanitizeGet($eventGameInfo['ffeg_uid']); ?>" name="eventGameUID" id="eventGameUID" />
                                <input type="hidden" value="<?php echo $methodsModel->sanitizeGet(number_format($gameInfo['ffg_price'], 2, '.', ',')); ?>" name="eventGamePrice" id="eventGamePrice" />
                                <input type="hidden" value="<?php echo $methodsModel->sanitizeGet($eventGameInfo['ffeg_slots']) ?>" name="eventGameSlotsLimit" id="eventGameSlotsLimit" />
                                <input type="hidden" value="Game" name="eventGameType" id="eventGameType" />

                                <div class="d-grid gap-2 d-sm-block pb-3">
                                    <input type="submit" name="eventGameAddSubmit" id="eventGameAddSubmit" class="btn btn-red btn-lg" value="Add to Cart" />
                                </div>
                            </form>

                        <?php endif; ?>

                        <p class="text-muted mt-3">Add another game to your cart?</p>
                        <a href="admin/signup/list/<?php echo $eventInfo['ffe_uid'] ?>" class="btn btn-blue btn-sm">Add more games&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>

                        <p class="text-muted mt-3">Ready to checkout? Go to your cart.</p>
                        <a href="admin/signup/cart" class="btn btn-red btn-sm">View Cart&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>

                    </div>

                </div>
    </div>

    <div class="row justify-content-center">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-red py-3 mt-5 mb-3'>
            <h1 class='display-6 fw-bold text-white text-center text-uppercase mb-0'>More Event Items</h1>
        </div>
    </div>

    <div class="row">
        <?php
                $eventModel = new EventModel();
                $alleventGames = $eventModel->getEventGamesByEventUID($eventGameInfo['ffeg_event_uid']);
                if (!$alleventGames || !is_array($alleventGames)):
        ?>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;No event games found in the record.</div>
            </div>
            <?php
                else:
                    foreach ($alleventGames as $eventGameItem):
                        $gameModel = new GameModel();
                        $eventModel = new EventModel();
                        $categoryModel = new CategoryModel();
                        $gameInfo = $gameModel->getGameByUID($eventGameItem['ffeg_game_uid']);
                        $eventInfo = $eventModel->getEventByUID($eventGameItem['ffeg_event_uid']);
                        $categoryInfo = $categoryModel->getCategoryByUID($eventGameItem['ffeg_category_uid']);
                        if ($eventGameInfo['ffeg_game_uid'] !== $gameInfo['ffg_uid']):
            ?>

                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 my-3 d-flex align-items-stretch">
                        <div class="card feature-card bg-white shadow-sm border border-2 pb-3">
                            <?php if (is_file("public/assets/images/game/" . $gameInfo['ffg_image'])) : ?>
                                <img src="public/assets/images/game/<?php echo $gameInfo['ffg_image']; ?>" class="card-img-top" alt="<?php echo $gameInfo['ffg_name']; ?>">
                            <?php else: ?>
                                <img src="public/assets/images/misc/ff_placeholder.png" class="card-img-top" alt="<?php echo $gameInfo['ffg_name']; ?>">
                            <?php endif ?>
                            <div class="card-body text-center">
                                <h5 class="card-title fs-5 text-red fw-bold text-uppercase"><?php echo $gameInfo['ffg_name']; ?></h5>
                                <p class="card-text text-uppercase">
                                    <span class="badge bg-warning text-gray fw-bold mb-2"><?php echo $categoryInfo['ffec_name']; ?></span>
                                    <span class="d-block fs-6 fw-bold text-blue"><?php echo date('F jS, Y', strtotime($eventGameItem['ffeg_game_date'])); ?></span>
                                </p>

                                <div class="d-grid gap-2 justify-content-sm-center">
                                    <?php if ($eventGameInfo['ffeg_slots'] > 1): ?>
                                        <a href="event/game/view/<?php echo $eventGameItem['ffeg_uid']; ?>" class="btn btn-red btn-lg btn-sm-block">Buy Now&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                                    <?php else: ?>
                                        <a href="event/game/view/<?php echo $eventGameItem['ffeg_uid']; ?>" class="btn btn-red btn-lg btn-sm-block><i class=" fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Slots Unavailable</a>
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

<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../../templates/modal.php");  ?>

<?php
include_once(__DIR__ . "/../../templates/footer.php");
ob_end_flush();
?>