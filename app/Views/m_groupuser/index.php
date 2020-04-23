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
          <h1 class="h3 display"><?= lang('Form.master_groupuser')?> </h1>
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
                <a href="<?= base_url('mgroupuser/add')?>"><i class = "fa fa-plus"></i> <?= lang('Form.add')?></a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id = "tableGroupUser" style="width: 100%;" class="table table-striped table-no-bordered table-hover dataTable dtr-inline collapsed " role="grid">
                <thead class=" text-primary">
                  <tr role = "row">
                    <th># </th>
                    <th><?=  lang('Form.name')?></th>
                    <th><?=  lang('Form.description')?></th>
                    <th><?=  lang('Form.createat')?></th>
                    <th class="disabled-sorting text-right"><?=  lang('Form.actions')?></th>
                  </tr>
                </thead>
                <tfoot class=" text-primary">
                  <tr role = "row">
                    <th># </th>
                    <th><?=  lang('Form.name')?></th>
                    <th><?=  lang('Form.description')?></th>
                    <th><?=  lang('Form.createat')?></th>
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

<script>

  $(document).ready(function() {   
    
    init();
    dataTable();
  });

  function dataTable(){
    var table = $('#tableGroupUser').DataTable({
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
           "targets": [ 4 ] 
        }
      ],
      columns: [
        { responsivePriority: 5, data:"Id" },
        { responsivePriority: 1, data:"GroupName" },
        { responsivePriority: 2, data:"Description" },
        { responsivePriority: 4, data:"Created" },
        { responsivePriority: 2, data:"Action" }
      ],
      "processing": true,
      "serverSide": true,
      ajax:{
        url : "<?= base_url('mgroupuser/getAllData')?>",
        dataSrc : 'data'
      },
      stateSave: true
    }); 

     // Delete a record
     table.on( 'click', '.delete', function (e) {
        $tr = $(this).closest('tr');
        var data = table.row($tr).data();
        var id = data['Id'] + "~a";
        var name = document.getElementById(id).innerHTML;
        deleteData(name, function(result){
          if (result==true)
          {
            $.ajax({
              type : "POST",
              url : "<?= base_url('mgroupuser/delete/');?>",
              data : {id : data[0]},
              success : function(data){
                console.log(data);
                var status = $.parseJSON(data);
                if(status['isforbidden']){
                  window.location = "<?= base_url('Forbidden');?>";
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

    //Like record
    table.on( 'click', '.role', function () {
        $tr = $(this).closest('tr');
        var data = table.row($tr).data();;
        var id = data["Id"];
        console.log(data);
        window.location = "<?= base_url('mgroupuser/editrole/');?>" + id;
    });

    table.on( 'click', '.reportrole', function () {
        $tr = $(this).closest('tr');
        var data = table.row($tr).data();;
        var id = data[0];
        window.location = "<?= base_url('mgroupuser/editreportrole/');?>" + id;
    });
  }

  function init(){
    
  }
</script>
      