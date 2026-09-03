<div class="modal fade" tabindex="-1" id="ajaxResponse">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header bg-white">
<h5 class="modal-title text-red fw-bold">
    <i class="fa fa-info-circle"></i>&nbsp;
    <?php echo $aboutJSONEnc['Facilitator']['title']; ?>
</h5>
</div>
<div class="modal-body text-center text-gray">
<div class="spinner-border mx-auto my-3" role="status"></div>
<i aria-hidden="true"></i>
<p class="mb-3"></p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-red" data-bs-dismiss="modal" onclick="window.location.reload();">Close</button>
</div>
</div>
</div>
</div>