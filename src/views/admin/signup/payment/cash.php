<?php
ob_start();

date_default_timezone_set('America/Chicago');

include_once(__DIR__."/../../../../application/errorhandler.php");
require_once(__DIR__.'/../../../../vendor/autoload.php');

//Load ENV file

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../../../../../config/');
$dotenv->load();


//About JSON File Content
$aboutJSONFile = file_get_contents(__DIR__.'/../../../../public/content/about.json');
$aboutJSONEnc = json_decode($aboutJSONFile, true);

if(isset($_SESSION['bccc_event_billing']) && !empty($_SESSION['bccc_event_billing']) && isset($_SESSION['bccc_event_order']) && !empty($_SESSION['bccc_event_order'])){
    
$total_price = trim(htmlspecialchars(stripslashes($_SESSION['bccc_event_order']['eventOrderTotal'])));
$total_price = number_format($total_price, 2, '.','');
$subtotal_price = trim(htmlspecialchars(stripslashes($_SESSION['bccc_event_order']['eventOrdersubTotal'])));
$subtotal_price = number_format($subtotal_price, 2, '.','');
$order_id = trim(htmlspecialchars(stripslashes($_SESSION['bccc_event_order']['eventOrderID'])));
$order_desc = trim(htmlspecialchars(stripslashes($_SESSION['bccc_event_order']['eventOrderDesc'])));
$tax = trim(htmlspecialchars(stripslashes($_SESSION['bccc_event_order']['eventOrderTax'])));
$tax = number_format($tax, 2, '.','');
$shipping = trim(htmlspecialchars(stripslashes($_SESSION['bccc_event_order']['eventOrderShipping'])));
$shipping = number_format($shipping, 2, '.','');
$ip_addr = trim(htmlspecialchars(stripslashes($_SESSION['bccc_event_order']['eventOrderParticipantIP'])));

}
else{
exit(header('Location: ../checkout'));
}
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="<?php echo $aboutJSONEnc['EventSiteKeywords']; ?>">
<meta name="author" content="<?php echo $aboutJSONEnc['Sponsor']['title']; ?>">
<meta name="description" content="<?php echo $aboutJSONEnc['EventSiteDescription']; ?>">
<base href="<?php echo $_ENV['OTCF_BASE_URL']; ?>" target="_self">
<title><?php echo $aboutJSONEnc['EventSiteTitle']; ?></title>
<link rel="icon"  type="image/x-icon" sizes="16x16" href="assets/icons/favicon.ico" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
<link href="public/css/main.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<script src="public/js/main.js"></script>

</head>
<body>

<!-- Page Loader Begin -->

<div id="page-loader">
<div id="page-loader-inner">
<div class="row justify-content-center">
<div class="col-12">
<img id="page-loader-img" src="public/assets/images/gifs/freedomfun_logo_loader.gif" alt="<?php echo $aboutJSONEnc['Facilitator']['title']; ?>" />
<h5 class="text-blue mx-3 mt-3">Please Wait. Loading...</h5>
</div>
</div>
</div>
</div>

<!-- Payment Loader Begin -->

<div id="payment-loader">
<div id="payment-loader-inner">
<div class="row justify-content-center">
<div class="col-12">
<img id="page-loader-img" src="public/assets/images/gifs/freedomfun_logo_loader.gif" alt="<?php echo $aboutJSONEnc['Facilitator']['title']; ?>" />
<h5 class="text-blue mx-3 mt-3">Please wait while your payment is being processed...</h5>
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
<li class="nav-item d-md-none">
<div class="nav-link text-md-left">
<img class="navbar-logo-right" src="public/assets/images/logos/sponsor_logo.png" alt="<?php echo $aboutJSONEnc['Sponsor']['title']; ?>">
</div>
</li>
</ul>
</div>
</div>
<span class="navbar-text">
<img class="navbar-logo-right d-none d-lg-block" src="public/assets/images/logos/sponsor_logo.png" alt="<?php echo $aboutJSONEnc['Sponsor']['title']; ?>">
</span>
</div>
</nav>
</div>
</div>
</div>

<!-- Header End -->


<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-red py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Payment</h1>
</div>
</div>

</div>

<div class="container">

<!-- Required Fields Alert -->

<div class="row justify-content-center">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 py-3">
<div class="alert alert-danger fw-bold text-red mb-2"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Please click/tap on "COMPLETE PAYMENT" button to complete the cash payment.
<br/><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Proceed only if the cash payment transaction is completed or cancel the process.
</div>
<div class="alert alert-primary fw-bold text-blue mb-2">
<i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;For more details on payment and order, please contact us.
</div>
</div>
</div>


<!-- Title End -->


<div class="row justify-content-start">
<div class='col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 order-md-2 my-3'>

<div class="row">
<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 mb-3">
<h5 class="text-red fw-bold">Order Information</h5>
</div>
</div>

<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 mb-3">

<ul class="list-group shadow-sm">
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Order ID</p>
<p class="fw-bold text-red mb-3"><?php echo $order_id; ?></p>
</li>
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Order Summary</p>
<p class="fw-bold text-red mb-3"><?php echo $order_desc; ?></p>
</li>
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Order Date</p>
<p class="fw-bold text-red mb-0"><?php echo date('F jS, Y'); ?></p>
</li>
</ul>

</div>
</div>

<div class="row">
<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 my-3">
<h5 class="text-blue fw-bold">Participant Information</h5>
</div>
</div>

<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 mb-3">

<ul class="list-group shadow-sm">
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Name</p>
<p class="fw-bold text-red mb-0"><?php echo $_SESSION['bccc_event_billing']['eventBillingFirstName'].' '.$_SESSION['bccc_event_billing']['eventBillingLastName']; ?></p>
</li>
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Email</p>
<p class="fw-bold text-red mb-0"><?php echo $_SESSION['bccc_event_billing']['eventBillingEmail']; ?></p>
</li>
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Phone</p>
<p class="fw-bold text-red mb-0"><?php echo $_SESSION['bccc_event_billing']['eventBillingPhoneCode'] . $_SESSION['bccc_event_billing']['eventBillingPhoneNumber']; ?></p>
</li>
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Zip Code</p>
<p class="fw-bold text-red mb-0"><?php echo $_SESSION['bccc_event_billing']['eventBillingZip']; ?></p>
</li>
</ul>

</div>
</div>

<div class="row">
<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 my-3">
<h5 class="text-red fw-bold">Billing Information</h5>
</div>
</div>

<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3">

<ul class="list-group shadow-sm">
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Sub Total
<span class="d-block small text-muted fw-normal">*Inclusive of all taxes</span></p>
<p class="fw-bold text-red text-end mb-0">&dollar;<?php echo $subtotal_price; ?></p>
</li>
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Tax
<span class="d-block small text-muted fw-normal">Calculated per item and included to Sub Total.</span></p>
<p class="fw-bold text-red text-end mb-0">&dollar;<?php echo $tax; ?></p>
</li>
<li class="list-group-item">
<p class="fw-bold small text-blue mb-0">Total Amount</p>
<p class="fs-3 fw-bold text-red text-end mb-0">&dollar;<?php echo $total_price; ?></p>
</li>
</ul>

</div>
</div>

</div>

<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 order-md-1 my-3">

<div class="row">
<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 col-12 mb-3">
<h5 class="text-red fw-bold">Direct Cash Payment</h5>
</div>
</div>

<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

<form name="eventPaymentCashForm" id="eventPaymentCashForm" action="admin/signup/reserve" method="POST">

<div class='card shadow-sm'>
<div class='card-body'>
<p class="card-text text-blue fw-bold mt-3 mb-0">
<i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;Click below to complete direct cash payment
</p>
</div>

<div class="card-footer d-grid gap-2 my-2 bg-white border-0">
<input type="submit" name="eventPayButton" id="eventPayButton" class="btn btn-red btn-lg" value="Complete Payment" />
</div>

</form>

</div>

</div>
</div>

<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
<div class="alert alert-danger text-red fw-bold mt-3" id="pg-process-error"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Please fill all the required fields with valid details.</div>
<div class="alert alert-danger text-red fw-bold mt-3" id="pg-process-alert"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;Please wait while your payment is being processed.</div>
</div>
</div>


<?php if(isset($_SESSION['bccc_event_order']) && !empty($_SESSION['bccc_event_order'])): ?>

<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

<div class='card'>

<div class='card-body'>
<p class="text-blue fw-bold mb-1"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Click below to use a different payment method for your registration.</p>
<a href="admin/signup/checkout" class="btn btn-red btn-sm my-2">Change Payment Method&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>

</div>

</div>

</div>
</div>

<?php endif; ?>


</div>


</div>

</div>
</div>

<!-- Container End -->


<footer class="footer">

<div class="container mt-3 pt-3 pb-5">

<div class="row justify-content-center">

<!-- Organisation -->

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 my-3">
<a href="<?php echo $aboutJSONEnc['Organisation']['website']; ?>"><img class="footer-logo-wide mb-4" alt="<?php echo $aboutJSONEnc['Organisation']['title']; ?>" src="public/assets/images/logos/organisation_logo.png" /></a>
<h5 class="fw-bold text-blue"><?php echo $aboutJSONEnc['Organisation']['title']; ?></h5>
<p>
<span class="text-blue">Call <?php echo $aboutJSONEnc['Organisation']['phone'] ?></span><br/>
<a class="text-decoration-none text-blue" href="<?php echo $aboutJSONEnc['Organisation']['website']; ?>"><?php echo $aboutJSONEnc['Organisation']['websiteText']; ?></a><br/>
<span class="text-blue small"><?php echo $aboutJSONEnc['Organisation']['copyrights']; ?></span>
</p>
<div class="pb-4 footer-smi">
<a href="<?php echo $aboutJSONEnc['Organisation']['socialmedia']['facebook']; ?>"><img alt="facebook" src="public/assets/images/icons/facebook_28x.png" /></a>
<a href="<?php echo $aboutJSONEnc['Organisation']['socialmedia']['twitter']; ?>"><img alt="twitter" src="public/assets/images/icons/twitter_28x.png" /></a>
<a href="<?php echo $aboutJSONEnc['Organisation']['socialmedia']['instagram']; ?>"><img alt="instagram" src="public/assets/images/icons/instagram_28x.png" /></a>
<a href="<?php echo $aboutJSONEnc['Organisation']['socialmedia']['youtube']; ?>"><img alt="youtube" src="public/assets/images/icons/youtube_28x.png" /></a>
</div>
</div>

<!-- Facilitator -->

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 my-3">
<a href="<?php echo $aboutJSONEnc['Facilitator']['website']; ?>"><img class="footer-logo-wide mb-4" alt="<?php echo $aboutJSONEnc['Facilitator']['title']; ?>" src="public/assets/images/logos/facilitator_logo.png" /></a>
<h5 class="fw-bold text-blue"><?php echo $aboutJSONEnc['Facilitator']['title']; ?></h5>
<p>
<a class="text-decoration-none text-blue" href="<?php echo $aboutJSONEnc['Facilitator']['website']; ?>"><?php echo $aboutJSONEnc['Facilitator']['websiteText']; ?></a><br/>
<span class="text-blue small"><?php echo $aboutJSONEnc['Facilitator']['copyrights']; ?></span>
</p>
<div class="pb-4 footer-smi">
<a href="<?php echo $aboutJSONEnc['Facilitator']['socialmedia']['facebook']; ?>"><img alt="facebook" src="public/assets/images/icons/facebook_28x.png" /></a>
<a href="<?php echo $aboutJSONEnc['Facilitator']['socialmedia']['instagram']; ?>"><img alt="instagram" src="public/assets/images/icons/instagram_28x.png" /></a>
<a href="<?php echo $aboutJSONEnc['Facilitator']['socialmedia']['youtube']; ?>"><img alt="youtube" src="public/assets/images/icons/youtube_28x.png" /></a>
<a href="<?php echo $aboutJSONEnc['Facilitator']['socialmedia']['pinterest']; ?>"><img alt="pinterest" src="public/assets/images/icons/pinterest_28x.png" /></a>

</div>
</div>

<!-- Sponsor -->

<!-- Sponsor -->

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 my-3">
<a href="<?php echo $aboutJSONEnc['Sponsor']['website']; ?>"><img class="footer-logo-wide mb-4" alt="<?php echo $aboutJSONEnc['Sponsor']['title']; ?>" src="public/assets/images/logos/sponsor_logo.png" /></a>
<h5 class="fw-bold text-blue"><?php echo $aboutJSONEnc['Sponsor']['title']; ?></h5>
<p>
<span class="text-blue">Call <?php echo $aboutJSONEnc['Sponsor']['phone']; ?></span><br/>
<span><a class="text-decoration-none text-blue" href="mailto:<?php echo $aboutJSONEnc['Sponsor']['email']; ?>"><?php echo $aboutJSONEnc['Sponsor']['email']; ?></a></span><br/>
<span><a class="text-decoration-none text-blue" href="<?php echo $aboutJSONEnc['Sponsor']['website']; ?>"><?php echo $aboutJSONEnc['Sponsor']['websiteText']; ?></a></span><br/></p>
<div class="pb-4 footer-smi">
<a href="<?php echo $aboutJSONEnc['Sponsor']['socialmedia']['facebook']; ?>"><img alt="facebook" src="public/assets/images/icons/facebook_28x.png" /></a>
<a href="<?php echo $aboutJSONEnc['Sponsor']['socialmedia']['twitter']; ?>"><img alt="twitter" src="public/assets/images/icons/twitter_28x.png" /></a>
<a href="<?php echo $aboutJSONEnc['Sponsor']['socialmedia']['instagram']; ?>"><img alt="instagram" src="public/assets/images/icons/instagram_28x.png" /></a>
<a href="<?php echo $aboutJSONEnc['Sponsor']['socialmedia']['youtube']; ?>"><img alt="youtube" src="public/assets/images/icons/youtube_28x.png" /></a>

</div>
</div>

</div>
</div>

<!-- Footer Menu -->

<div class="container mt-3 pb-2">
<div class="row justify-content-center">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center">

<ul class="nav justify-content-center">
<li class="nav-item">
<a class="nav-link text-blue" href="./">Home</a>
</li>
</ul>

</div>
</div>
</div>

<!-- Secure Payment Section -->

<div class="container mt-3 pb-2">
<div class="row justify-content-center">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center">

<p class="fw-bold text-red"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;100% Secure SSL Transaction</p>
<p class="fw-bold fs-4">
<i class="fa fa-cc-visa text-blue" aria-hidden="true"></i>&nbsp;
<i class="fa fa-cc-mastercard text-red" aria-hidden="true"></i>&nbsp;
<i class="fa fa-cc-discover text-blue" aria-hidden="true"></i>&nbsp;
<i class="fa fa-credit-card text-red" aria-hidden="true"></i>
</p>

</div>
</div>
</div>


<!-- Copyright Start -->

<div class="container mt-3 pb-5">
<div class="row justify-content-center">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center py-4">
<p class="py-0 my-0 text-blue">&copy; Copyrights <?php echo date("Y"); ?>&nbsp;<?php echo $aboutJSONEnc['EventCopyrights']; ?></p>
</div>
</div>

</div>
</footer>

<!-- Footer End -->

<script>
$(window).on("load", function() {
$('#page-loader').fadeOut();
$("#payment-loader").hide();
document.getElementById("pg-process-error").style.display = 'none';
});
</script>

</body>
</html>

<?php
ob_end_flush();
?>
