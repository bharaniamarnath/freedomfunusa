<?php
header_remove('ETag');
header_remove('Pragma');
header_remove('Cache-Control');
header_remove('Last-Modified');
header_remove('Expires');

header('Expires: Thu, 1 Jan 1970 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
?>

<?php
require_once(__DIR__ . "/../../application/errorhandler.php");
require_once(__DIR__ . '/../../vendor/autoload.php');

//Load ENV file

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../configuration/');
$dotenv->load();

//About JSON File Content
$aboutJSONFile = file_get_contents(__DIR__ . '/../../public/content/about.json');
$aboutJSONEnc = json_decode($aboutJSONFile, true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="<?php echo $aboutJSONEnc['EventSiteKeywords']; ?>">
    <meta name="author" content="<?php echo $aboutJSONEnc['Sponsor']['title']; ?>">
    <meta name="description" content="<?php echo $aboutJSONEnc['EventSiteDescription']; ?>">
    <base href="<?php echo $_ENV['FF_BASE_URL']; ?>" target="_self">
    <title><?php echo $aboutJSONEnc['EventSiteTitle']; ?></title>
    <link rel="icon" type="image/x-icon" sizes="16x16" href="assets/icons/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" integrity="sha512-Fm8kRNVGCBZn0sPmwJbVXlqfJmPC13zRsMElZenX6v721g/H7OukJd8XzDEBRQ2FSATK8xNF9UYvzsCtUpfeJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="public/css/main.css" />
</head>

<body>

    <!-- No Script Begin -->

    <noscript>
        <meta http-equiv="refresh" content="0; URL=error/javascript">
        Are you using a browser that doesn't support JavaScript?<br><br>
        If your browser does not support JavaScript, you can upgrade to a newer browser<br><br>
        If you have disabled JavaScript, you must re-enable JavaScript to use this page.
    </noscript>

    <!-- No Script End -->

    <!-- Page Loader Begin -->

    <div id="page-loader">
        <div id="page-loader-inner">
            <div class="row justify-content-center">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <img id="page-loader-img" src="public/assets/images/gifs/freedomfun_logo_loader.gif" alt="<?php echo $aboutJSONEnc['Facilitator']['title']; ?>" />
                    <h5 class="text-blue mx-3 mt-3">Please Wait. Loading...</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Begin -->

    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top py-3 border border-bottom-1">
                    <div class="container">
                        <a class="navbar-brand navbar-logo" href="./">
                            <img src="public/assets/images/logos/facilitator_logo.png" alt="<?php echo $aboutJSONEnc['Facilitator']['title']; ?>">
                        </a>
                        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header bg-white">
                                <a class="offcanvas-logo" href="./">
                                    <img src="public/assets/images/logos/facilitator_logo.png" alt="<?php echo $aboutJSONEnc['Facilitator']['title']; ?>">
                                </a>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body bg-white">
                                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                    <li class="nav-item">
                                        <a class="nav-link text-md-left" href="./">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-md-left" href="about">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-md-left" href="contact">Contact</a>
                                    </li>
                                    <li class="nav-item mx-lg-2">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a type="button" href="event/view/FFE75100" class="btn btn-warning text-uppercase text-gray fw-bold me-md-2">Buy Now&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                                            <a type="button" href="event/checklist" class="btn btn-red text-uppercase text-white fw-bold me-md-2"><i class="fa fa-shopping-basket" aria-hidden="true"></i>&nbsp;Your Cart</a>
                                        </div>
                                    </li>
                                    <li class="nav-item d-md-none">
                                        <a href="<?php echo $aboutJSONEnc['Sponsor']['website']; ?>">
                                            <div class="nav-link text-md-left">
                                                <img class="navbar-logo-right" src="public/assets/images/logos/sponsor_logo.png" alt="<?php echo $aboutJSONEnc['Sponsor']['title']; ?>">
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <span class="navbar-text">
                            <a href="<?php echo $aboutJSONEnc['Sponsor']['website']; ?>">
                                <img class="navbar-logo-right d-none d-lg-block" src="public/assets/images/logos/sponsor_logo.png" alt="<?php echo $aboutJSONEnc['Sponsor']['title']; ?>">
                            </a>
                        </span>
                    </div>
                </nav>
            </div>
        </div>
    </div>