<!-- modal -->
<div id="modalFamilycardlivestock" tabindex="-1" role="dialog" aria-labelledby="familycardlivestockModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="familycardlivestockModalLabel" class="modal-title"><?= lang('Form.familycardlivestock') ?></h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="card-body">
        <div class="toolbar">
          <!--        Here you can write extra buttons/actions for the toolbar
                                  -->
        </div>
        <div class="material-datatables">
          <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <!-- <div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="datatables_length"><label>Show <select name="datatables_length" aria-controls="datatables" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="-1">All</option></select> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="datatables_filter" class="dataTables_filter"><label><span class="bmd-form-group bmd-form-group-sm"><input type="search" class="form-control form-control-sm" placeholder="Search records" aria-controls="datatables"></span></label></div></div></div> -->
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table data-page-length="5" id="tableModalFamilycardlivestock" class="table table-striped table-no-bordered table-hover dataTable dtr-inline collapsed" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                    <thead class=" text-primary">
                      <th># </th>
                      <th>NIK</th>
                      <th><?= lang('Form.name') ?></th>
                      <!-- <th><?= lang('Form.description') ?></th> -->
                    </thead>
                    <tfoot class=" text-primary">
                      <tr role="row">
                        <th># </th>
                        <th>NIK</th>
                        <th><?= lang('Form.name') ?></th>
                        <!-- <th><?= lang('Form.description') ?></th> -->
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
  var tableFamilycardlivestock;
  var familyid = 0;
  var url = "<?= baseUrl("mfamilycardlivestock/getDataModal/") ?>"
  $(document).ready(function() {
    loadModalFamilycardlivestock(0);
  });

  function changeFamilyCardId(familycardid){
    familyid = familycardid;
    reload();
  }

  function reload(){
      tableFamilycardlivestock.ajax.url(url + familyid);
      tableFamilycardlivestock.ajax.reload(null, true);
  }

  function loadModalFamilycardlivestock(familycardid = 0) {

    tableFamilycardlivestock = $("#tableModalFamilycardlivestock").DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [
        [5, 10, 15, 20, -1],
        [5, 10, 15, 20, "All"]
      ],
      responsive: true,
      language: {
        search: "_INPUT_",
        "search": "<?= lang('Form.search') ?>" + " : ",
      },
      "columnDefs": [{
          targets: 'disabled-sorting',
          orderable: false
        },
        {
          "targets": [0],
          "visible": false,
          "searchable": false
        }
      ],
      "processing": true,
      "serverSide": true,
      ajax: {
        url: url + familyid,
        dataSrc: 'data'
      },
      stateSave: true
    });

    // Edit record
    tableFamilycardlivestock.on('click', '.rowdetail', function() {
      $tr = $(this).closest('tr');

      var data = tableFamilycardlivestock.row($tr).data();
      var id = $tr.attr('id');

      $("#M_Familycardlivestock_Id").val(data[0]);
      $("#familycardlivestock").val(data[1]);
      $('#modalFamilycardlivestock').modal('hide');
    });

  }
  
  $('#modalFamilycardlivestock').on('show.bs.modal', function(e) {
    reload();
  })

 
</script>