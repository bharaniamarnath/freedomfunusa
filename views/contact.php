<?php include_once(__DIR__ . '/templates/header.php'); ?>


<div class="container page">

    <div class="row mx-auto">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-4 fw-bold text-blue text-center mb-0'>Contact</h1>
        </div>
    </div>

</div>

<div class="container">

    <div class="row mb-4">

        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 my-3">
            <div class="card rounded-3 shadow-sm p-3">
                <img src="public/assets/images/logos/organisation_logo.png" class="card-img-top w-50 p-4" alt="<?php echo $aboutJSONEnc['Organisation']['title']; ?>">
                <ul class="list-group list-group-flush px-2">
                    <li class="list-group-item">
                        <h5 class="text-gray fw-bold mb-0"><?php echo $aboutJSONEnc['Organisation']['title']; ?></h5>
                    </li>
                    <li class="list-group-item">
                        <label class="info-label">Phone</label>
                        <p class="text-gray mb-0"><?php echo $aboutJSONEnc['Organisation']['phone']; ?></p>
                    </li>
                    <li class="list-group-item">
                        <label class="info-label">Website</label>
                        <p class="mb-0">
                            <a class="text-decoration-none" href="<?php echo $aboutJSONEnc['Organisation']['website']; ?>">
                                <?php echo $aboutJSONEnc['Organisation']['websiteText']; ?>
                            </a>
                        </p>
                    </li>
                </ul>
            </div>
        </div>

        
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 my-3">
            <div class="card  rounded-3 shadow-sm p-3">
                <img src="public/assets/images/logos/facilitator_logo.png" class="card-img-top w-50 p-4" alt="<?php echo $aboutJSONEnc['Sponsor']['title']; ?>">
                <ul class="list-group list-group-flush px-2">
                    <li class="list-group-item">
                        <h5 class="text-gray fw-bold mb-0"><?php echo $aboutJSONEnc['Facilitator']['title']; ?></h5>
                    </li>
                    <li class="list-group-item">
                        <label class="info-label">Phone</label>
                        <p class="text-gray mb-0"><?php echo $aboutJSONEnc['Facilitator']['phone']; ?></p>
                    </li>
                    <li class="list-group-item">
                        <label class="info-label">Email</label>
                        <p class="text-gray mb-0"><?php echo $aboutJSONEnc['Facilitator']['email']; ?></p>
                    </li>
                    <li class="list-group-item">
                        <label class="info-label">Website</label>
                        <p class="mb-0">
                            <a class="text-decoration-none" href="<?php echo $aboutJSONEnc['Facilitator']['website']; ?>">
                                <?php echo $aboutJSONEnc['Facilitator']['websiteText']; ?>
                            </a>
                        </p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 my-3">
            <div class="card rounded-3 shadow-sm p-3">
                <img src="public/assets/images/logos/sponsor_logo.png" class="card-img-top w-50 p-4" alt="<?php echo $aboutJSONEnc['Sponsor']['title']; ?>">
                <ul class="list-group list-group-flush px-2">
                    <li class="list-group-item">
                        <h5 class="text-gray fw-bold mb-0"><?php echo $aboutJSONEnc['Sponsor']['title']; ?></h5>
                    </li>
                    <li class="list-group-item">
                        <label class="info-label">Phone</label>
                        <p class="text-gray mb-0"><?php echo $aboutJSONEnc['Sponsor']['phone']; ?></p>
                    </li>
                    <li class="list-group-item">
                        <label class="info-label">Email</label>
                        <p class="text-gray mb-0"><?php echo $aboutJSONEnc['Sponsor']['email']; ?></p>
                    </li>
                    <li class="list-group-item">
                        <label class="info-label">Website</label>
                        <p class="mb-0">
                            <a class="text-decoration-none" href="<?php echo $aboutJSONEnc['Sponsor']['website']; ?>">
                                <?php echo $aboutJSONEnc['Sponsor']['websiteText']; ?>
                            </a>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row mx-auto mb-2">
        <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-4'>
            <h1 class='display-5 fw-bold text-red text-center mb-0'>Location</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mx-auto my-4 rounded-3 shadow-sm">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d858.740516160784!2d-97.85498482461605!3d30.578616294332477!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x865b2bed8632fde3%3A0xa5502d68e9101c50!2s100%20N%20Brushy%20St%2C%20Leander%2C%20TX%2078641%2C%20USA!5e0!3m2!1sen!2sin!4v1693921954352!5m2!1sen!2sin" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

</div>


<?php include_once(__DIR__ . '/templates/footer.php'); ?>