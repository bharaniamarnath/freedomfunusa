<?php
ob_start();

include_once(__DIR__.'/../../../models/content_model.php');

if(isset($_SESSION['bccc_event_participant']) && isset($_SESSION['bccc_event_game']) && isset($_SESSION['bccc_event_payment']) && isset($_SESSION['bccc_event_order'])){
if($_SESSION['bccc_event_payment']['response'] == 1){
$contentModel = new ContentModel();
$rc = $contentModel->paymentStatusMessage($_SESSION['bccc_event_payment']['response']);
$pc = $contentModel->paymentResponseMessage($_SESSION['bccc_event_payment']['response_code']);
unset($_SESSION['bccc_event_participant']);
unset($_SESSION['bccc_event_game']);
unset($_SESSION['bccc_event_payment']);
unset($_SESSION['bccc_event_order']);
unset($_SESSION['bccc_event_billing']);
}
}
else{
exit(header('Location: ../../home'));
}
?>

<?php include_once(__DIR__.'/../../templates/header.php'); ?>

<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Payment</h1>
        </div>
    </div>

</div>

<!-- Container Begin -->

<div class="container">

<div class="row justify-content-center">

<div class='col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 my-5 p-5'>
<h2 class="display-1 text-red text-center"><i class="fa fa-check-circle" aria-hidden="true"></i></h2>
<h2 class='fw-bold text-blue text-center'><span class='text-red fs-2'>SUCCESS</span><br/><br/>Your Freedom Fun event registration has been successfully processed.</h2>
<p class='fs-5 fw-bold text-red text-center my-4'>Payment status<br/><small class="text-blue fw-bold"><?php if(isset($rc)){ echo $rc; } else{ echo 'Unknown'; } ?></small></p>
<p class='fs-5 fw-bold text-red text-center my-4'>Transaction status<br/><small class="text-blue fw-bold"><?php if(isset($pc)){ echo $pc; } else{ echo 'Unknown'; } ?></small></p>
<p class='fs-5 fw-bold text-red text-center my-4'>Please check your registered email for more details.<br/><small class="text-blue fw-normal">(Email not received? Check your email's junk/spam folder. Or maybe the email you registered is incorrect. Please check or contact us for more information.)</small></p>
<div class='d-grid gap-2 d-sm-flex justify-content-sm-center'>
<a href="home" class='btn btn-red btn-lg text-uppercase fw-bold'>Back to Main Page</a>
</div>
</div>

</div>
</div>

<!-- Footer -->

<?php 
include_once(__DIR__.'/../../templates/footer.php');
ob_end_flush();
?>