<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active"><?= lang('Form.setting') ?> </li>
    </ul>
  </div>
</div>
<section>
  <div class="container-fluid">
    <!-- Page Header-->
    <header>
      <!-- <h1 class="h3 display"><?= lang('Form.mainsetup') ?> </h1> -->

    </header>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h4><?= lang('Form.setting') ?></h4>
              </div>
              <div class="col-sm-6 text-right">
                <!-- <a href="<?= baseUrl('maccount') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <div id="accordion" role="tablist">
              <div class="card-collapse">
                <div class="card-header" role="tab" id="headingOne">
                  <h5 class="mb-0">
                    <a data-toggle="collapse" href="#masteruser" aria-expanded="false" aria-controls="masteruser" class="collapsed">
                      <?= lang('Form.master') . " / " . lang('Form.user') ?>
                    </a>
                  </h5>
                </div>
                <div id="masteruser" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                  <div class="card-body">
                    <form method="post" action="<?= baseUrl('setting/saveuserlocation') ?>">
                      <div class="row">
                        <div class="col-md-10">
                          <div class="form-group bmd-form-group">
                            <div class="i-checks">
                              <?= formInput(
                                array(
                                  "id" => "TrackUser",
                                  "type" => "checkbox",
                                  "class" => "form-control-custom",
                                  "name" => "TrackUser"
                                )
                              ) ?>
                              <?= formLabel("Telusur Lokasi Pengguna", array("for" => "TrackUser")) ?>

                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="submit" value="<?= lang('Form.save') ?>" class="btn btn-primary">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="card-collapse">
                <div class="card-header" role="tab" id="headingOne">
                  <h5 class="mb-0">
                    <a data-toggle="collapse" href="#masterimpact" aria-expanded="false" aria-controls="masterimpact" class="collapsed">
                      <?= lang('Form.master') . " / " . lang('Form.impact') ?>
                    </a>
                  </h5>
                </div>
                <div id="masterimpact" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                  <div class="card-body">
                    <form method="post" action="<?= baseUrl('setting/saveimpactcompensation') ?>">
                      <div class="row">
                        <?= formLabel("Bantuan", array("for" => "Compensation", "class" => "col-sm-2 col-form-label")) ?>
                        <div class="col-md-10">
                          <div class="form-group bmd-form-group">
                            <?= formInput(
                              array(
                                "id" => "Compensation",
                                "type" => "text",
                                "placeholder" => "Biaya Bantuan 1M(perseegi)",
                                "class" => "form-control money2",
                                "name" => "Compensation",
                                "value" => $impactmodel->DecimalValue
                              )
                            ) ?>
                          </div>
                        </div>
                      </div>  
                      <div class="form-group">
                        <input type="submit" value="<?= lang('Form.save') ?>" class="btn btn-primary">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="card-collapse">
                <div class="card-header" role="tab" id="headingOne">
                  <h5 class="mb-0">
                    <a data-toggle="collapse" href="#transdisasterreport" aria-expanded="false" aria-controls="transdisasterreport" class="collapsed">
                      <?= lang('Form.transaction') . " / " . lang('Form.disasterreport') ?>
                    </a>
                  </h5>
                </div>
                <div id="transdisasterreport" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                  <div class="card-body">
                    <form method="post" action="<?= baseUrl('setting/savedisasterreport') ?>">
                      <div class="row">
                        <label class="col-sm-2 col-form-label"><?= lang('Form.numberformat') ?></label>
                        <div class="col-md-10">
                          <div class="form-group bmd-form-group">
                            <input id="disasterreportformatnumber" type="text" class="form-control transnumberformat" name="disasterreportformatnumber" value="<?= $disasterreportmodel->StringValue ?>">
                            <span class="bmd-help text-primary"><?= lang('Info.membernumberformat') ?></span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="submit" value="<?= lang('Form.save') ?>" class="btn btn-primary">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="card-collapse">
                <div class="card-header" role="tab" id="headingOne">
                  <h5 class="mb-0">
                    <a data-toggle="collapse" href="#transdisasteroccur" aria-expanded="false" aria-controls="transdisasteroccur" class="collapsed">
                      <?= lang('Form.transaction') . " / " . lang('Form.disasteroccur') ?>
                    </a>
                  </h5>
                </div>
                <div id="transdisasteroccur" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                  <div class="card-body">
                    <form method="post" action="<?= baseUrl('setting/savedisasteroccur') ?>">
                      <div class="row">
                        <label class="col-sm-2 col-form-label"><?= lang('Form.numberformat') ?></label>
                        <div class="col-md-10">
                          <div class="form-group bmd-form-group">
                            <input id="disasteroccurformatnumber" type="text" class="form-control transnumberformat" name="disasteroccurformatnumber" value="<?= $disasteroccurmodel->StringValue ?>">
                            <span class="bmd-help text-primary"><?= lang('Info.membernumberformat') ?></span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="submit" value="<?= lang('Form.save') ?>" class="btn btn-primary">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="card-collapse">
                <div class="card-header" role="tab" id="headingOne">
                  <h5 class="mb-0">
                    <a data-toggle="collapse" href="#transinoutitem" aria-expanded="false" aria-controls="transinoutitem" class="collapsed">
                      <?= lang('Form.transaction') . " / " . lang('Form.inoutitem') ?>
                    </a>
                  </h5>
                </div>
                <div id="transinoutitem" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                  <div class="card-body">
                    <form method="post" action="<?= baseUrl('setting/saveinoutitem') ?>">
                      <div class="row">
                        <label class="col-sm-2 col-form-label"><?= lang('Form.numberformat') ?></label>
                        <div class="col-md-10">
                          <div class="form-group bmd-form-group">
                            <input id="inoutitemformatnumber" type="text" class="form-control transnumberformat" name="inoutitemformatnumber" value="<?= $inoutitemmodel->StringValue ?>">
                            <span class="bmd-help text-primary"><?= lang('Info.membernumberformat') ?></span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="submit" value="<?= lang('Form.save') ?>" class="btn btn-primary">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function() {
    initsetting();
    // loadModalChartOfAccount();
  });

  function initsetting() {
    <?php
    if ($userlocationmodel->BooleanValue == 1) {
      ?>
      $('#TrackUser').prop('checked', true);
    <?php
    }
    ?>
  }


  function loadModalChartOfAccount() {
    var table = $('#tablemodalChartOfAccounts').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [
        [5, 10, 15, 20, -1],
        [5, 10, 15, 20, "All"]
      ],
      responsive: true,
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search records",
      }
    });

    // Edit record
    table.on('click', '.rowdetail', function() {
      $tr = $(this).closest('tr');

      var data = table.row($tr).data();
      var id = $tr.attr('id');

      $("#paymentcoaid").val(id);
      $("#paymentcoaname").val(data[0] + " " + data[1]);
      $('#modalChartOfAccounts').modal('hide');
    });
  }
</script>