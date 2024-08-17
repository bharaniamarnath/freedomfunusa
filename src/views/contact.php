<?php include_once(__DIR__.'/templates/header.php'); ?>


<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Contact</h1>
</div>
</div>

</div>

<div class="container">

<div class="row justify-content-center">
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mt-1 mb-3 py-5">
<img src="public/assets/images/logos/organisation_logo.png" alt="<?php echo $aboutJSONEnc['Organisation']['title']; ?>" class="img-fluid img-contact border border-1 p-5 mb-3" />
<h5 class="card-title text-red fs-3 fw-bold"><?php echo $aboutJSONEnc['Organisation']['title']; ?></h5>
<p class="text-red fw-bold mb-0"><span class="text-blue">Phone:&nbsp;</span><?php echo $aboutJSONEnc['Organisation']['phone']; ?></p>
<p class="text-red fw-bold mb-0"><span class="text-blue">Website:&nbsp;</span><a class="text-decoration-none text-red" href="<?php echo $aboutJSONEnc['Organisation']['website']; ?>"><?php echo $aboutJSONEnc['Organisation']['websiteText']; ?></a></p>
</div>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mt-1 mb-3 py-5">
<img src="public/assets/images/logos/facilitator_logo.png" alt="<?php echo $aboutJSONEnc['Sponsor']['title']; ?>" class="img-fluid img-contact border border-1 p-5 mb-3" />
<h5 class="card-title text-red fs-3 fw-bold"><?php echo $aboutJSONEnc['Facilitator']['title']; ?></h5>
<p class="card-text text-red fw-bold mb-0"><span class="text-blue">Phone:&nbsp;</span><?php echo $aboutJSONEnc['Facilitator']['phone']; ?></p>
<p class="card-text text-red fw-bold mb-0"><span class="text-blue">Email:&nbsp;</span><?php echo $aboutJSONEnc['Facilitator']['email']; ?></p>
<p class="card-text text-red fw-bold mb-0"><span class="text-blue">Website:&nbsp;</span><a class="text-decoration-none text-red" href="<?php echo $aboutJSONEnc['Facilitator']['website']; ?>"><?php echo $aboutJSONEnc['Facilitator']['websiteText']; ?></a></p>
</div>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mt-1 mb-3 py-5">
<img src="public/assets/images/logos/sponsor_logo.png" alt="<?php echo $aboutJSONEnc['Sponsor']['title']; ?>" class="img-fluid img-contact border border-1 p-5 mb-3" />
<h5 class="card-title text-red text-uppercase fs-3 fw-bold"><?php echo $aboutJSONEnc['Sponsor']['title']; ?></h5>
<p class="card-text text-red fw-bold mb-0"><span class="text-blue">Phone:&nbsp;</span><?php echo $aboutJSONEnc['Sponsor']['phone']; ?></p>
<p class="card-text text-red fw-bold mb-0"><span class="text-blue">Email:&nbsp;</span><?php echo $aboutJSONEnc['Sponsor']['email']; ?></p>
<p class="card-text text-red fw-bold mb-0"><span class="text-blue">Website:&nbsp;</span><a class="text-decoration-none text-red" href="<?php echo $aboutJSONEnc['Sponsor']['website']; ?>"><?php echo $aboutJSONEnc['Sponsor']['websiteText']; ?></a></p>
</div>
</div>

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-red py-3 mt-5 mb-3'>
<h1 class='display-5 fw-bold text-white text-center text-uppercase mb-0'>Locate Us</h1>
</div>
</div>

<div class="row w-100 justify-content-center">
<div class="col-lg-6 my-4 shadow-sm">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d858.740516160784!2d-97.85498482461605!3d30.578616294332477!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x865b2bed8632fde3%3A0xa5502d68e9101c50!2s100%20N%20Brushy%20St%2C%20Leander%2C%20TX%2078641%2C%20USA!5e0!3m2!1sen!2sin!4v1693921954352!5m2!1sen!2sin" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
</div>

</div>


<?php include_once(__DIR__.'/templates/footer.php'); ?>