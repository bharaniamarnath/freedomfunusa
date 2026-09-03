<?php
ob_start();
include_once(__DIR__ . '/../templates/header.php');
include_once(__DIR__ . '/../../models/event_model.php');
include_once(__DIR__ . '/../../models/game_model.php');
include_once(__DIR__ . '/../../models/category_model.php');
?>

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Cart</h1>
        </div>
    </div>

</div>

<div class="container">

        <?php
        if (
            isset($_SESSION['bccc_event_game']) &&
            is_array($_SESSION['bccc_event_game']) &&
            count($_SESSION['bccc_event_game']) > 0
        ):
            $eventModel = new EventModel();
            $gameModel = new GameModel();
            $categoryModel = new CategoryModel();

            $totalItems = 0;
            $subtotalAmount = 0;

            foreach ($_SESSION['bccc_event_game'] as $event_game):
                $eventGameInfo = $eventModel->getEventGameByUID($event_game['eventGameUID']);
                $eventInfo = $eventModel->getEventByUID($eventGameInfo['ffeg_event_uid']);
                $gameInfo = $gameModel->getGameByUID($eventGameInfo['ffeg_game_uid']);
                $categoryInfo = $categoryModel->getCategoryByUID($eventGameInfo['ffeg_category_uid']);

                $totalItems += $event_game['eventGameSlots'];
                $subtotalAmount += ($event_game['eventGamePrice'] * $event_game['eventGameSlots']);
                $discountAmount = 0;
                $totalAmount = 0;
        ?>

            <div class="row d-flex align-items-center gy-2 pb-3 mb-3 border-bottom">
                <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-4 col-sm-4 col-4">
                    <a class="text-decoration-none" href="event/game/view/<?php echo $event_game['eventGameUID']; ?>">
                        <img class="img-thumbnail h-100" src="public/assets/images/game/<?php echo $gameInfo['ffg_image']; ?>" alt="<?php echo $gameInfo['ffg_name']; ?>">
                    </a>
                </div>
                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-4 col-sm-4 col-4">
                    <p class="fs-5 text-red fw-bold mb-0"><?php echo $gameInfo['ffg_name']; ?></p>
                    <p class="text-gray mb-0"><?php echo $categoryInfo['ffec_name']; ?></p>
                </div>
                <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-4 col-sm-4 col-4">
                    <p class="fs-6 text-gray fw-bold mb-0">&dollar;<?php echo number_format($event_game['eventGamePrice'], 2, '.', ','); ?></p>
                </div>
                <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-4 col-sm-4 col-4">
                    <input type="number" class="form-control" id="<?php echo $event_game['eventGameUID']; ?>" value="<?php echo $event_game['eventGameSlots']; ?>" min="1" max="<?php echo $event_game['eventGameSlotslimit']; ?>" step="1" />
                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-4 col-sm-4 col-4">
                    <button type="button" id="<?php echo $event_game['eventGameUID']; ?>" data-link="event/update" class="btn btn-yellow btn-upd-confirm"><i class="fa fa-refresh d-none d-sm-inline" aria-hidden="true"></i>&nbsp;Update</button>
                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-4 col-sm-4 col-4">
                    <button type="button" id="<?php echo $event_game['eventGameUID']; ?>" data-link="event/remove" class="btn btn-red btn-del-confirm"><i class="fa fa-trash-o d-none d-sm-inline" aria-hidden="true"></i>&nbsp;Remove</button>
                </div>
            </div>

            <?php endforeach; ?>

            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                    <h1 class="fs-4 fw-bold text-red text-center mb-4">Cart summary</h1>
                    <?php
                        $discountAmount = ($subtotalAmount * 0.10);
                        $totalAmount = $subtotalAmount - $discountAmount;
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12">
                    <ul class="list-group shadow-sm">
                    <li class="list-group-item">
                    <label class="info-label">Total items
                        <span class="d-block small text-muted fw-normal">Total count per item in cart</span>
                    </label>
                    <p class="text-gray text-end fw-bold mb-0"><?php echo $totalItems; ?></p>
                    </li>
                    <li class="list-group-item">
                    <label class="info-label">Sub Total
                        <span class="d-block small text-muted">Tax calculated on checkout</span>
                    </label>
                    <p class="text-gray text-end fw-bold mb-0">&dollar;<?php echo number_format($subtotalAmount, 2, ".", ""); ?></p>
                    </li>
                    </ul>
                </div>

                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12">
                    <ul class="list-group shadow-sm">
                    <li class="list-group-item">
                    <label class="info-label">Discount
                        <span class="d-block small text-muted">Discount price excluding tax</span>
                    </label>
                    <p class="text-gray text-end fw-bold mb-0">&dollar;<?php echo number_format($discountAmount, 2, ".", ""); ?></p>
                    </li>
                    <li class="list-group-item">
                    <label class="info-label">Total
                        <span class="d-block small text-muted">Total with discount excluding tax</span>
                    </label>
                    <p class="text-red text-end fw-bold mb-0">&dollar;<?php echo number_format($totalAmount, 2, ".", ""); ?></p>
                    </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-5 border-bottom">
                    <h2 class="fs-2 text-blue text-center fw-bold mb-3">Ready to checkout?</h2>
                    <div class="d-grid justify-content-center">
                        <a role="button" class="btn btn-lg btn-red" href="event/participant">Proceed&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>

        <?php
        else:
        ?>
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
                <div class="alert alert-warning p-5">
                    <h2 class="display-1 text-center text-red"><i class="fa fa-shopping-cart" aria-hidden="true"></i></h2>
                    <p class="text-center text-gray"><i class="fa fa-exclamation-circle"></i>&nbsp;No items found in cart.</p>
                    <div class="d-flex justify-content-center">
                        <a type="button" href="event/view/FFE75100" class="btn btn-yellow fw-bold">Buy Now&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        endif;
        ?>


    <!-- More Event Games -->

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4 mt-3'>
            <h1 class='fs-3 fw-bold text-red text-center mb-0'>More from this event</h1>
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
                                <h5 class="card-title text-red fw-bold"><?php echo $gameInfo['ffg_name']; ?></h5>
                                <p class="card-text">
                                    <span class="badge bg-warning text-gray fw-bold mb-2"><?php echo $categoryInfo['ffec_name']; ?></span>
                                    <span class="d-block fs-5 fw-bold text-gray mt-2">&dollar;<?php echo number_format($gameInfo['ffg_price'], 2, '.', ','); ?></span>
                                </p>

                                <div class="d-grid gap-2 justify-content-sm-center">
                                    <?php if ($eventGameItem['ffeg_slots'] > 1): ?>
                                        <a href="event/game/view/<?php echo $eventGameItem['ffeg_uid']; ?>" class="btn btn-red btn-sm-block">Buy Now&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                                    <?php else: ?>
                                        <a href="event/game/view/<?php echo $eventGameItem['ffeg_uid']; ?>" class="btn btn-red btn-sm-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Slots Unavailable</a>
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


<!-- AJAX response Modal -->
<?php include_once(__DIR__."/../templates/modal.php");  ?>

<!-- Confirm Action Modal -->
<?php include_once(__DIR__."/../templates/confirm.php");  ?>

<?php
include_once(__DIR__ . "/../templates/footer.php");
ob_end_flush();
?>