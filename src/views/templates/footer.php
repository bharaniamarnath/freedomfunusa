<footer class="footer">

    <div class="container mt-3 pt-3 pb-5">

        <div class="row justify-content-center">

            <!-- About JSON File Content -->

            <?php
            $aboutJSONFile = file_get_contents(__DIR__ . '/../../public/content/about.json');
            $aboutJSONEnc = json_decode($aboutJSONFile, true);
            ?>

            <!-- Organisation -->

            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 my-3">
                <a href="<?php echo $aboutJSONEnc['Organisation']['website']; ?>"><img class="footer-logo-wide mb-4" alt="<?php echo $aboutJSONEnc['Organisation']['title']; ?>" src="public/assets/images/logos/organisation_logo.png" /></a>
                <h5 class="fw-bold text-blue"><?php echo $aboutJSONEnc['Organisation']['title']; ?></h5>
                <p>
                    <span class="text-blue">Call <?php echo $aboutJSONEnc['Organisation']['phone'] ?></span><br />
                    <a class="text-decoration-none text-blue" href="<?php echo $aboutJSONEnc['Organisation']['website']; ?>"><?php echo $aboutJSONEnc['Organisation']['websiteText']; ?></a><br />
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
                    <span class="text-blue">Call <?php echo $aboutJSONEnc['Facilitator']['phone']; ?></span><br />
                    <a class="text-decoration-none text-blue" href="<?php echo $aboutJSONEnc['Facilitator']['website']; ?>"><?php echo $aboutJSONEnc['Facilitator']['websiteText']; ?></a><br />
                    <span class="text-blue small"><?php echo $aboutJSONEnc['Facilitator']['copyrights']; ?></span>
                </p>
                <div class="pb-4 footer-smi">
                    <a href="<?php echo $aboutJSONEnc['Facilitator']['socialmedia']['facebook']; ?>"><img alt="facebook" src="public/assets/images/icons/facebook_28x.png" /></a>
                    <a href="<?php echo $aboutJSONEnc['Facilitator']['socialmedia']['twitter']; ?>"><img alt="twitter" src="public/assets/images/icons/twitter_28x.png" /></a>
                    <a href="<?php echo $aboutJSONEnc['Facilitator']['socialmedia']['instagram']; ?>"><img alt="instagram" src="public/assets/images/icons/instagram_28x.png" /></a>
                    <a href="<?php echo $aboutJSONEnc['Facilitator']['socialmedia']['youtube']; ?>"><img alt="youtube" src="public/assets/images/icons/youtube_28x.png" /></a>

                </div>
            </div>

            <!-- Sponsor -->

            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 my-3">
                <a href="<?php echo $aboutJSONEnc['Sponsor']['website']; ?>"><img class="footer-logo-wide mb-4" alt="<?php echo $aboutJSONEnc['Sponsor']['title']; ?>" src="public/assets/images/logos/sponsor_logo.png" /></a>
                <h5 class="fw-bold text-blue"><?php echo $aboutJSONEnc['Sponsor']['title']; ?></h5>
                <p>
                    <span class="text-blue">Call <?php echo $aboutJSONEnc['Sponsor']['phone']; ?></span><br />
                    <span><a class="text-decoration-none text-blue" href="mailto:<?php echo $aboutJSONEnc['Sponsor']['email']; ?>"><?php echo $aboutJSONEnc['Sponsor']['email']; ?></a></span><br />
                    <span><a class="text-decoration-none text-blue" href="<?php echo $aboutJSONEnc['Sponsor']['website']; ?>"><?php echo $aboutJSONEnc['Sponsor']['websiteText']; ?></a></span><br />
                    <span class="text-blue small"><?php echo $aboutJSONEnc['Sponsor']['copyrights']; ?>.</span><br />
                </p>
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
                    <li class="nav-item">
                        <a class="nav-link text-blue" href="faq">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-blue" href="terms">Terms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-blue" href="privacy">Privacy</a>
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

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js" integrity="sha512-YJgZG+6o3xSc0k5wv774GS+W1gx0vuSI/kr0E0UylL/Qg/noNspPtYwHPN9q6n59CTR/uhgXfjDXLTRI+uIryg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="public/js/main.js"></script>
</body>

</html>