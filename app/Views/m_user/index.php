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
          <h1 class="h3 display"><?= lang('Form.master_user')?> </h1>
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
                <a href="<?= baseUrl('muser/add')?>"><i class = "fa fa-plus"></i> <?= lang('Form.add')?></a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <div class="table-responsive">
                <table data-page-length="5" id = "tableUser" class="table table-striped table-no-bordered table-hover dataTable dtr-inline collapsed" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                  <thead class=" text-primary">
                      <th># </th>
                      <th><?=  lang('Form.user')?></th>
                      <th><?=  lang('Form.group_user')?></th>
                      <th><?=  lang('Form.isactive')?></th>
                      <th class="disabled-sorting text-right"><?=  lang('Form.actions')?></th>
                  </thead>
                  <tfoot class=" text-primary">
                    <tr role = "row">
                      <th># </th>
                      <th><?=  lang('Form.user')?></th>
                      <th><?=  lang('Form.group_user')?></th>
                      <th><?=  lang('Form.isactive')?></th>
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
  </div>
</section>
<script type = "text/javascript">
  $(document).ready(function() {    
    init();
    dataTable();
  });

  function dataTable(){
    var table = $('#tableUser').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]],
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
        { responsivePriority: 5 },
        { responsivePriority: 1 },
        { responsivePriority: 3 },
        { responsivePriority: 4 },
        { responsivePriority: 2 }
      ],
      "processing": true,
      "serverSide": true,
      ajax:{
        url : "<?= baseUrl('muser/getAllData')?>",
        dataSrc : 'data'
      },
      stateSave: true
    }); 

     // Edit record
     table.on( 'click', '.edit', function () {
        $tr = $(this).closest('tr');
        var data = table.row($tr).data();
        var id = data[0] + "~a";
        window.location = "<?= baseUrl('muser/edit/');?>" + data[0];
     } );

     // Delete a record
     table.on( 'click', '.activate', function (e) {
        $tr = $(this).closest('tr');
        var data = table.row($tr).data();
        var id = data[0] + "~a";
        window.location = "<?= baseUrl('muser/activate/');?>" + data[0];
     });
  }

  function init(){
    
  }

  function delete_user(id, name){
    deleteData(name, function(result){
      if (result==true)
        window.location = "<?= baseUrl('muser/delete/');?>" + id;
    });
  } 
  function activate_user(id){
    window.location = "<?= baseUrl('muser/activate/');?>" + id;
  }
</script>
      