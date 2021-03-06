<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Master</li>
    </ul>
  </div>
</div>
<section>
  <div class="container-fluid">
    <!-- Page Header-->
    <header> 
          <h1 class="h3 display"><?= lang('Form.mastercommunity')?> </h1>
      </tr>
    </header>
    <div class="row">

      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class = "row">
              <div class="col-6">
                <h4><?= lang('Form.data')?></h4>
              </div>
              <div class="col-6 text-right">
                <a href="<?= baseUrl('mcommunity/add')?>"><i class = "fa fa-plus"></i> <?= lang('Form.add')?></a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id = "tableSubvillageDisaster" style="width: 100%;" class="table table-striped table-no-bordered table-hover dataTable dtr-inline collapsed " role="grid">
                <thead class=" text-primary">
                  <tr role = "row">
                    <th># </th>
                    <th><?=  lang('Form.name')?></th>
                    <th><?=  lang('Form.subvillage')?></th>
                    <th><?=  lang('Form.address')?></th>
                    <th><?=  lang('Form.serviceperiod')?></th>
                    <th><?=  lang('Form.endservice')?></th>
                    <th><?=  lang('Form.telephone')?></th>
                    <th class="disabled-sorting text-right"><?=  lang('Form.actions')?></th>
                  </tr>
                </thead>
                <tfoot class=" text-primary">
                  <tr role = "row">
                    <th># </th>
                    <th><?=  lang('Form.name')?></th>
                    <th><?=  lang('Form.subvillage')?></th>
                    <th><?=  lang('Form.address')?></th>
                    <th><?=  lang('Form.serviceperiod')?></th>
                    <th><?=  lang('Form.endservice')?></th>
                    <th><?=  lang('Form.telephone')?></th>
                    <th class="disabled-sorting text-right"><?=  lang('Form.actions')?></th>
                  </tr>
                </tfoot>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</section>

<!-- modal -->
<div id="modalSubvillageDisaster" tabindex="-1" role="dialog" aria-labelledby="communityModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="communityModalLabel" class="modal-title"><?= lang('Form.picture')?></h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="card-body">
        <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar
                                  -->
              <img id="villageDisImage" src="https://picsum.photos/300/200?image=1061" alt="Image 1061" class="img-fluid" height="100%" width="100%">
        </div>
        
      </div>
    </div>
  </div>
</div>

<script>

  $(document).ready(function() {   
    
    init();
    dataTable();
  });

  function dataTable(){
    var table = $('#tableSubvillageDisaster').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]],
      "order" : [[2, "desc"]],
      responsive: true,
      language: {
      search: "_INPUT_",
      "search": "<?= lang('Form.search')?>"+" : "
      },
      "columnDefs": [ 
        {
          targets: 'disabled-sorting', 
          orderable: false
        },
        {
          "targets": [ 0 ],
          "visible": false,
          "searchable": false
        },
        {
           "className": "td-actions text-right", 
           "targets": [ 7 ] 
        }
      ],
      columns: [
        { responsivePriority: 1 },
        { responsivePriority: 3 },
        { responsivePriority: 4 },
        { responsivePriority: 5 },
        { responsivePriority: 6 },
        { responsivePriority: 7 },
        { responsivePriority: 8 },
        { responsivePriority: 2 }
      ],
      "processing": true,
      "serverSide": true,
      ajax:{
        url : "<?= baseUrl('M_community/getAllData')?>",
        dataSrc : 'data'
      },
      stateSave: true
    }); 

     // Delete a record
     table.on( 'click', '.delete', function (e) {
        $tr = $(this).closest('tr');
        var data = table.row($tr).data();
        var id = data[0] + "~a";
        var name = document.getElementById(id).innerHTML;
        console.log(name);
        deleteData(name, function(result){
          if (result==true)
          {
            
            $.ajax({
              type : "POST",
              url : "<?= baseUrl('mcommunity/delete/');?>",
              data : {id : data[0]},
              success : function(data){
                console.log(data);
                var status = $.parseJSON(data);
                if(status['isforbidden']){
                  window.location = "<?= baseUrl('Forbidden');?>";
                } else {
                  if(!status['status']){
                    for(var i=0 ; i< status['msg'].length; i++){
                      var message = status['msg'][i];
                      setNotification(message, 3, "bottom", "right");
                    }
                  } else {
                    for(var i=0 ; i< status['msg'].length; i++){
                      var message = status['msg'][i];
                      setNotification(message, 2, "bottom", "right");
                    }
                    table.row($tr).remove().draw();
                    e.preventDefault();
                  }
                }
              }
            });
          }
        });
      });

    table.on( 'click', '.image', function (e) {
      $tr = $(this).closest('tr');
      var data = table.row($tr).data();
      var id = data[0];
      console.log(id);
      $.ajax({
        type : "POST",
        url : "<?= baseUrl('mcommunity/getData');?>",
        data : {id : data[0]},
        success : function(data){
          var model = $.parseJSON(data);
          var dom = document.getElementById('villageDisImage');
          dom.src = "<?= baseUrl()?>" + model.PhotoUrl; 

          var label = document.getElementById("communityModalLabel");
          label.innerHTML = model.Name;

        }
      });
    });

  }

  function init(){
    
  }
</script>
      