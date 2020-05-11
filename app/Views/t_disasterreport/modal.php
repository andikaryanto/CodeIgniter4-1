<!-- modal -->
<div id="modalDisasterreport" tabindex="-1" role="dialog" aria-labelledby="disasterreportModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="disasterreportModalLabel" class="modal-title"><?= lang('Form.disasterreport')?></h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="card-body">
        <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar
                                  -->
        </div>
        <div class="material-datatables">
          <div id = "datatables_wrapper" class = "dataTables_wrapper dt-bootstrap4">
            <!-- <div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="datatables_length"><label>Show <select name="datatables_length" aria-controls="datatables" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="-1">All</option></select> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="datatables_filter" class="dataTables_filter"><label><span class="bmd-form-group bmd-form-group-sm"><input type="search" class="form-control form-control-sm" placeholder="Search records" aria-controls="datatables"></span></label></div></div></div> -->
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table data-page-length="5" id = "tableModalDisasterreport" class="table table-striped table-no-bordered table-hover dataTable dtr-inline collapsed" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                    <thead class=" text-primary">
                        <th># </th>
                        <th><?=  lang('Form.number')?></th>
                        <th><?=  lang('Form.reportername')?></th>
                        <th><?=  lang('Form.date')?></th>
                        <th><?=  lang('Form.disaster')?></th>
                        <!-- <th><?=  lang('Form.description')?></th> -->
                    </thead>
                    <tfoot class=" text-primary">
                      <tr role = "row">
                        <th># </th>
                        <th><?=  lang('Form.number')?></th>
                        <th><?=  lang('Form.reportername')?></th>
                        <th><?=  lang('Form.date')?></th>
                        <th><?=  lang('Form.disaster')?></th>
                        <!-- <th><?=  lang('Form.description')?></th> -->
                      </tr>
                    </tfoot>
                    
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    var tableDisasterreport;
    $(document).ready(function() { 
        loadModalDisasterreport();
    });
    
    function loadModalDisasterreport(){

      tableDisasterreport = $("#tableModalDisasterreport").DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]],
        responsive: true,
        language: {
        search: "_INPUT_",
        "search": "<?= lang('Form.search')?>"+" : ",
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
          }
        ],
        "processing": true,
        "serverSide": true,
        ajax:{
            url : "<?= baseUrl('tdisasterreport/getDataModal')?>",
            dataSrc : 'data'
        },
        stateSave: true
      });

      // Edit record
      tableDisasterreport.on( 'click', '.rowdetail', function () {
            $tr = $(this).closest('tr');

            var data = tableDisasterreport.row($tr).data();
            var id = $tr.attr('id');

            $("#T_Disasterreport_Id").val(data[0]);
            $("#disasterreport").val(data[1]);
            $('#modalDisasterreport').modal('hide');
      } );
    }

    $('#modalDisasterreport').on('show.bs.modal', function (e) {
      tableDisasterreport.ajax.reload(null, true);
    })
</script>
