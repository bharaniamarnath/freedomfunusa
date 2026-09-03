<?php
ob_start();
include_once(__DIR__ . '/../../../application/sessions.php');
include_once(__DIR__ . '/../../../models/category_model.php');
include_once(__DIR__ . '/../../../models/event_model.php');
include_once(__DIR__ . '/../../../models/game_model.php');
include_once(__DIR__ . "/../../../models/content_model.php");
include_once(__DIR__ . "/../../../models/methods_model.php");
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
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Walk-In</h1>
        </div>
    </div>

</div>

<div class="container">

    <div class="row g-5 mb-3">

        <?php if (!isset($event_id) && $event_id == null && $event_id == ''): ?>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get event ID</div>
            </div>
            <?php
        else:
            $_SESSION['bccc_event_uid'] = $event_id;
            $eventModel = new EventModel();
            $methodsModel = new MethodsModel();
            $categoryModel = new CategoryModel();
            $contentModel = new ContentModel();
            $eventInfo = $eventModel->getEventByUID($event_id);
            if (empty($eventInfo) || !is_array($eventInfo)):
            ?>
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                    <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;Error occurred. Unable to get event information.</div>
                </div>
            <?php else: ?>

                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 col-12 py-3">
                    <img src="public/assets/images/event/<?php echo $eventInfo['ffe_image'] . '?v=' . uniqid(); ?>" class="img-fluid border border-1" alt="<?php echo $eventInfo['ffe_name']; ?>" />
                </div>

                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 col-sm-12 col-xs-12 col-12 py-2">
                    <!-- Display Event Info -->
                    <h2 class="text-red fw-bold mt-3"><?php echo $eventInfo['ffe_name']; ?></h2>
                    <p class="fs-5 text-blue fw-bold mt-3"><?php echo date('F jS, Y', strtotime($eventInfo['ffe_start_date'])); ?></p>
                    <p class="fs-6 text-gray fw-bold mt-3"><?php echo htmlspecialchars_decode($eventInfo['ffe_description']); ?></p>
                </div>

    </div>

    <div class="row">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
    <h1 class="fs-2 fw-bold text-blue mb-4">Event Games</h1>
    </div>
    </div>

    <div class="row justify-content-start mb-3">

        <?php
                $eventModel = new EventModel();
                $alleventGames = $eventModel->getEventGamesByEventUID($event_id);
                if (!$alleventGames || !is_array($alleventGames)):
        ?>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle"></i>&nbsp;No event games found in the record.</div>
            </div>
            <?php
                else:
                    foreach ($alleventGames as $eventGameItem):
                        $gameModel = new GameModel();
                        $categoryModel = new CategoryModel();
                        $gameInfo = $gameModel->getGameByUID($eventGameItem['ffeg_game_uid']);
                        $eventInfo = $eventModel->getEventByUID($eventGameItem['ffeg_event_uid']);
                        $categoryInfo = $categoryModel->getCategoryByUID($eventGameItem['ffeg_category_uid']);
            ?>

                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 d-flex align-items-stretch">
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
                                <?php if ($eventGameItem['ffeg_game_session'] == 2): ?>
                                    <?php if ($categoryInfo['ffec_uid'] == 'FFEC32244'): ?>
                                        <span class="d-block fs-6 fw-bold text-blue"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Additional Play Option</span>
                                    <?php else: ?>
                                        <span class="d-block fs-6 fw-bold text-blue"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Single Day Event</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="d-block fs-6 fw-bold text-red"><?php echo date('l', strtotime($eventGameItem['ffeg_game_date'])); ?></span>
                                    <span class="d-block fs-6 fw-bold text-blue"><?php echo date('F jS, Y', strtotime($eventGameItem['ffeg_game_date'])); ?></span>
                                <?php endif; ?>
                                <span class="d-block fs-5 fw-bold text-red mt-2">&dollar;<?php echo number_format($gameInfo['ffg_price'], 2, '.', ','); ?></span>
                            </p>

                            <div class="d-grid gap-2 justify-content-sm-center">
                                <?php if ($eventGameItem['ffeg_slots'] > 1): ?>

                                    <?php
                                    //Check game Date
                                    $eventGameStartDate = strtotime(date('Y-m-d', strtotime($eventGameItem['ffeg_game_date'])));
                                    $currentDate = strtotime(date('Y-m-d'));

                                    //Check game slots
                                    if ($eventGameItem['ffeg_slots'] <= 1):
                                    ?>
                                        <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;No slots available for this event game</div>

                                    <?php elseif ($eventGameStartDate < $currentDate): ?>

                                        <div class="alert alert-danger text-red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Event game was held on <?php echo date('F jS, Y', strtotime($eventGameInfo['ffeg_game_date'])); ?></div>

                                    <?php else: ?>

                                        <?php if ($eventGameItem['ffeg_slots'] < 5): ?>
                                            <div class="alert alert-info text-blue"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Only <?php echo $eventGameInfo['ffeg_slots']; ?> slots left!</div>
                                        <?php endif; ?>

                                        <form name="eventGameSignUpAddForm" id="eventGameSignUpAddForm<?php echo $eventGameItem['ffeg_uid']; ?>" class="eventGameSignUpAddForm">

                                            <div class="form-group pb-3">
                                                <label for="eventGameSlots" class="form-label required-field">Quantity</label>
                                                <div class="col-md-12">
                                                    <input type='number' class='form-control' id='eventGameSlots' name='eventGameSlots' placeholder='Quantity' max="<?php echo $eventGameItem['ffeg_slots']; ?>" min="1" step="1">
                                                </div>
                                            </div>

                                            <input type="hidden" value="<?php echo $methodsModel->sanitizeGet($eventGameItem['ffeg_uid']); ?>" name="eventGameUID" id="eventGameUID" />
                                            <input type="hidden" value="<?php echo $methodsModel->sanitizeGet(number_format($gameInfo['ffg_price'], 2, '.', ',')); ?>" name="eventGamePrice" id="eventGamePrice" />
                                            <input type="hidden" value="<?php echo $methodsModel->sanitizeGet($eventGameItem['ffeg_slots']) ?>" name="eventGameSlotsLimit" id="eventGameSlotsLimit" />
                                            <input type="hidden" value="Game" name="eventGameType" id="eventGameType" />

                                            <div class="d-grid gap-2 d-sm-block pb-3">
                                                <button href="admin/signup/event/add" type="button" name="eventGameSignUpAddSubmit" id="<?php echo $eventGameItem['ffeg_uid']; ?>" class="btn btn-red btn-lg eventGameSignUpAddSubmit">Add To Cart</button>
                                            </div>
                                        </form>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <a href="admin/signup/game/<?php echo $eventGameItem['ffeg_uid']; ?>" class="btn btn-red btn-lg btn-sm-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Slots Unavailable</a>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>



        <?php
                    endforeach;
                endif;
        ?>
    </div>

    <div class="row">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
    <h1 class="fs-2 fw-bold text-red">Cart</h1>
    </div>
    </div>

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


                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 d-flex align-items-stretch">
                    <div class="card feature-card bg-white shadow-sm border border-2 pb-3">
                        <img src="public/assets/images/game/<?php echo $gameInfo['ffg_image']; ?>" class="card-img-top" alt="<?php echo $gameInfo['ffg_name']; ?>">

                        <div class="card-body text-center">
                            <h5 class="card-title text-red fw-bold mb-2"><?php echo $gameInfo['ffg_name']; ?></h5>
                            <span class="badge bg-warning text-gray fw-bold mb-2"><?php echo $categoryInfo['ffec_name']; ?></span>
                            <?php if ($eventGameInfo['ffeg_game_session'] == 2): ?>
                                <?php if ($categoryInfo['ffec_uid'] == 'FFEC32244'): ?>
                                    <span class="d-block fs-6 fw-bold text-blue"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Additional Play Option</span>
                                <?php else: ?>
                                    <span class="d-block fs-6 fw-bold text-blue"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Single Day Event</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="d-block fs-6 fw-bold text-red"><?php echo date('l', strtotime($eventGameInfo['ffeg_game_date'])); ?></span>
                                <span class="d-block fs-6 fw-bold text-blue"><?php echo date('F jS, Y', strtotime($eventGameInfo['ffeg_game_date'])); ?></span>
                            <?php endif; ?>
                            <p class="card-text fw-bold mt-3 mb-0">
                                <span class="d-block fs-5 text-red">&dollar;<?php echo $event_game['eventGamePrice']; ?></span>
                                <span class="d-block fs-6 text-blue"><?php echo $event_game['eventGameSlots']; ?>&nbsp;<?php echo $categoryInfo['ffec_name']; ?>
                                    <?php if ($categoryInfo['ffec_uid'] == 'FFEC98662'): ?>
                                        <span class="small text-red">&nbsp;&#40;<?php echo ($event_game['eventGameSlots'] * 4); ?>&nbsp;Wristbands&#41;</span>
                                    <?php endif; ?>
                                </span>
                            </p>
                        </div>

                        <div class="d-grid gap-2 justify-content-sm-center">
                            <button type="button" id="<?php echo $event_game['eventGameUID']; ?>" class="btn btn-red btn-sm btn-del-confirm"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Remove</button>
                        </div>

                    </div>
                </div>


            <?php
                    endforeach;
            ?>
            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 d-grid justify-content-end py-3">
                    <a href="admin/signup/checkout" type="button" class="btn btn-red btn-lg">Proceed&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                </div>
            </div>
        <?php
                else:
        ?>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                <div class="alert alert-warning p-5">
                    <h2 class="display-1 text-center text-red"><i class="fa fa-shopping-cart" aria-hidden="true"></i></h2>
                    <p class="text-center text-gray"><i class="fa fa-exclamation-circle"></i>&nbsp;No items found in cart.</p>
                </div>
            </div>
        <?php
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

<!-- Confirm Action Modal -->
<?php include_once(__DIR__."/../../templates/confirm.php");  ?>

<?php
include_once(__DIR__ . "/../../templates/footer.php");
ob_end_flush();
?>