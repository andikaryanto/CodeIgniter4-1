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
          <h1 class="h3 display"><?= lang('Form.itemstock')." ( ".$model->Name. " )"?> </h1>
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
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id = "tableGroupUser" style="width: 100%;" class="table table-striped table-no-bordered table-hover dataTable dtr-inline collapsed " role="grid">
                <thead class=" text-primary">
                  <tr role = "row">
                    <th># </th>
                    <th><?=  lang('Form.warehouse')?></th>
                    <th><?=  lang('Form.qty')?></th>
                  </tr>
                </thead>
                <tfoot class=" text-primary">
                  <tr role = "row">
                    <th># </th>
                    <th><?=  lang('Form.warehouse')?></th>
                    <th><?=  lang('Form.qty')?></th>
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
      "order" : [[1, "desc"]],
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
           "targets": [ 2 ] 
        }
      ],
      columns: [
        { responsivePriority: 1 },
        { responsivePriority: 3 },
        { responsivePriority: 2 }
      ],
      "processing": true,
      "serverSide": true,
      ajax:{
        url : "<?= baseUrl("mitem/getStock/{$model->Id}")?>",
        dataSrc : 'data'
      },
      stateSave: true
    });

  }

  function init(){
    
  }
</script>
      