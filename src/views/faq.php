<?php include_once(__DIR__.'/templates/header.php'); ?>

<div class="container-fluid page">

<div class="row justify-content-center">
<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 bg-blue py-3 mt-0 mb-3'>
<h1 class='display-4 fw-bold text-white text-center text-uppercase mb-0'>FAQ</h1>
</div>
</div>

</div>

<div class="container">

<?php
//About JSON File Content
$faqJSONFile = file_get_contents(__DIR__.'/../public/content/faq.json');
$faqJSONEnc = json_decode($faqJSONFile, true);
$faqItemCount = 0;
$faqSubItemCount = 0;

foreach($faqJSONEnc as $faqItem):
?>
<div class="row justify-content-center">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">

<h3 class="fs-4 text-red fw-bold mb-3"><?php echo $faqItem['section']; ?></h3>
<div class="accordion accordion-flush" id=" accordion-faq-<?php echo $faqItemCount; ?>">
<?php
foreach ($faqItem['faqs'] as $faq):
?>

<div class="accordion-item mb-3">
<h2 class="accordion-header border border-1" id="faq-title-<?php echo $faqSubItemCount; ?>">
<button class="accordion-button collapsed text-blue fs-5 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-<?php echo $faqSubItemCount; ?>" aria-expanded="false" aria-controls="faq-title-<?php echo $faqSubItemCount; ?>">
<?php echo $faq['title']; ?>
</button>
</h2>
<div id="faq-content-<?php echo $faqSubItemCount; ?>" class="accordion-collapse collapse" aria-labelledby="faq-title-<?php echo $faqSubItemCount; ?>" data-bs-parent="#accordion-faq-<?php echo $faqItemCount; ?>">
<div class="accordion-body">
<?php echo html_entity_decode($faq['content']); ?>
</div>
</div>
</div>


<?php
$faqSubItemCount += 1;
endforeach;
?>
</div>

</div>
</div>
<?php
$faqItemCount += 1;
endforeach;
?>

<div class="row justify-content-center">
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 py-3">
<div class="alert alert-info text-blue mb-1"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;For more information about schedule, registration, participation and payment in the event, please contact <a href="tel:8553864255" class="text-decoration-none">855-FUN-4ALL</a></div>

</div>
</div>

</div>


<?php include_once(__DIR__.'/templates/footer.php'); ?>