<!-- modal -->
<div id="modalImages" tabindex="-1" role="dialog" aria-labelledby="imagesModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="imagesModalLabel" class="modal-title"><?= lang('Form.picture')?></h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="card-body">
            <img id="modalImg" src="https://picsum.photos/300/200?image=1061" alt="Image 1061" class="img-fluid" height="100%" width="100%">
      </div>
    </div>
  </div>
</div>

<script>

    function showModalImage(){
        $('#modalImages').modal('show')
    }
    
</script>
