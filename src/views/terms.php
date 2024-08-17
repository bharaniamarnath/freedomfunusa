<?php include_once(__DIR__.'/templates/header.php'); ?>

<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>Terms</h1>
</div>
</div>

</div>

<div class="container">


<?php
//About JSON File Content
$termsJSONFile = file_get_contents(__DIR__.'/../public/content/terms.json');
$termsJSONEnc = json_decode($termsJSONFile, true);
$termsItemCount = 0;
$termsSubItemCount = 0;

foreach($termsJSONEnc as $termsItem):
?>
<div class="row justify-content-center">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">

<h3 class="fs-4 text-red fw-bold mb-3"><?php echo $termsItem['section']; ?></h3>
<h5 class="fs-6 text-blue fw-bold mb-3"><?php echo $termsItem['description']; ?></h5>
<?php
foreach ($termsItem['terms'] as $term):
echo $term['term'];
$termsSubItemCount += 1;
endforeach;
?>

<?php
$termsItemCount += 1;
endforeach;
?>


</div>

<?php include_once(__DIR__.'/templates/footer.php'); ?>