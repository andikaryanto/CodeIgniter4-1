<!-- modal -->
<div id="modalVideos" tabindex="-1" role="dialog" aria-labelledby="videosModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="videosModalLabel" class="modal-title"><?= lang('Form.picture')?></h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="card-body">
      <video id = "modalVideo" width="100%" height="100%" controls>
      </video>
      </div>
    </div>
  </div>
</div>

<script>

    function showModalVideo(){
        $('#modalVideos').modal('show')
    }

    function setModalVideoUrl(data, autoplay = false){
          console.log(data);
          var source = document.createElement('source');
          var video = document.getElementById('modalVideo');
          source.setAttribute('id', "sourceVideo");
          source.setAttribute('src', '<?= baseUrl() ?>' + data.model.Video);
          source.setAttribute('type', 'video/ogg');
          video.appendChild(source);
          if(autoplay)
            video.play();
    }

    $('#modalVideos').on('hidden.bs.modal', function(e) {
      var video = document.getElementById('modalVideo');
      video.pause();
      $( "source" ).remove();
    })

    
    
</script>
