<!-- modal -->
<div id="modalGroupUser" tabindex="-1" role="dialog" aria-labelledby="groupUserModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="groupUserModalLabel" class="modal-title">Group User</h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="card-body">
        <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar
                                  -->
        </div>
        <div class="material-datatables">
          <div id = "datatables_wrapper" class = "dataTables_wrapper dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table data-page-length="5" id = "tableModalGroupUser" class="table table-striped table-no-bordered table-hover dataTable dtr-inline collapsed" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                    <thead class=" text-primary">
                        
                        <th># </th>
                        <th><?=  lang('Form.group_user')?></th>
                        <!-- <th><?=  lang('Form.description')?></th> -->
                    </thead>
                    <tfoot class=" text-primary">
                      <tr role = "row">
                        <th># </th>
                        <th><?=  lang('Form.group_user')?></th>
                        <!-- <th><?=  lang('Form.description')?></th> -->
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
  </div>
</div>
<script type = "text/javascript">
  var tableGroup ;
  $(document).ready(function() {  
    loadModalGroup();
  });

  function loadModalGroup(){
    tableGroup  = $("#tableModalGroupUser").DataTable({
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
            url : "<?= baseUrl('mgroupuser/getDataModal')?>",
            dataSrc : 'data'
        },
        stateSave: true
    });
     // Edit record
     tableGroup.on( 'click', '.rowdetail', function () {
        $tr = $(this).closest('tr');

        var data = tableGroup.row($tr).data();
        var id = $tr.attr('id');

        $("#M_Groupuser_Id").val(data[0]);
        $("#groupname").val(data[1]);
        $('#modalGroupUser').modal('hide');
     } );
  }

  $('#tableModalGroupUser').on('show.bs.modal', function (e) {
      tableGroup.ajax.reload(null, true);
    })
</script>