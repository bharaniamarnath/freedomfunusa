<?php include_once(__DIR__.'/templates/header.php'); ?>


<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>About Event</h1>
</div>
</div>

</div>

<!-- Promotion Banner Begin -->

<div class="container-fluid">
<div class="row justify-content-center">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 p-0">
<a href="<?php echo $aboutJSONEnc['Organisation']['website']; ?>" target=”_blank” class="text-decoration-none">
<img src="public/assets/images/features/ff_promotion_banner.png" class="img-fluid d-block mx-auto w-100" alt="<?php echo $aboutJSONEnc['EventHeading']; ?>" loading="lazy">
</a>
</div>
</div>
</div>

<!-- Promotion Banner End -->

<div class="container mt-3">

<div class="row">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-5">

<p class="lead text-center">
Join us for Leander’s most festive event! The 2023 Old Town Christmas Festival is coming <span class="fw-bold">Saturday, December 2<sup>nd</sup></span>.
</p>
<p class="lead text-center">
The best way to kick off the holiday season is by shopping, dancing, singing, playing, eating and meeting Santa at the Old Town Christmas Festival! Start your stocking stuffing and present shopping while enjoying the most fun of the season!
</p>
</div>
</div>

</div>

<!-- Schedule Table Start -->

<div class="container mt-3">


<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-red py-3 mb-3'>
<h1 class='display-6 fw-bold text-white text-center text-uppercase mb-0'>Schedule of Events</h1>
</div>
</div>

<div class="row justify-content-center">
<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12 col-12 py-3">

<?php
$scheduleJSONFile = file_get_contents(__DIR__.'/../public/content/schedule.json');
$scheduleJSONEnc = json_decode($scheduleJSONFile, true);
?>

<div class="table-responsive">
<table class="table table-striped table-schedule">

<thead>
<tr>
<th scope="col" class="fs-4 text-red">Times</th>
<th scope="col" class="fs-4 text-blue">Events</th>
</tr>
</thead>

<tbody>

<?php
foreach($scheduleJSONEnc as $scheduleItem):
?>

<tr>
<th scope="row"><?php echo $scheduleItem['time']; ?></th>
<td><?php echo html_entity_decode($scheduleItem['event']); ?></td>
</tr>
<?php
endforeach;
?>

</tbody>
</table>
</div>

</div>
</div>
</div>

<!-- Schedule Table End -->

<div class="container mt-3">
<div class="row justify-content-center">
<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 py-5">
<h5 class="text-blue fw-bold text-center mb-3">Presented By</h5>
<img class="d-block img-fluid mx-auto" src="public/assets/images/features/ff_presented_by_logo.png" />
<h5 class="text-red fw-bold text-center mt-3">Leander</h5>
</div>
</div>
</div>

<?php include_once(__DIR__.'/templates/footer.php'); ?>