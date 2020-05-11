<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Master </li>
    </ul>
  </div>
</div>
<section>
  <div class="container-fluid">
    <!-- Page Header-->
    <header>
      <h1 class="h3 display"><?= lang('Form.disasterreport') ?> </h1>
      </tr>
    </header>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-6">
                <h4><?= lang('Form.add') ?></h4>
              </div>
              <div class="col-6 text-right">
                <!-- <a href="<?= baseUrl('tdisasterreport') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpenMultipart(baseUrl('tdisasterreport/addsave')) ?>
            <div class="row">
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel("ReportNo") ?>
                    <?= formInput(
                      array(
                        "id" => "ReportNo",
                        "type" => "text",
                        "placeholder" => "AUTO",
                        "class" => "form-control",
                        "name" => "ReportNo",
                        "value" => $model->ReportNo,
                        "readonly" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang('Form.community'), array("for" => "community")) ?>
                  <div class="input-group has-success">
                    <?= formInput(
                      array(
                        "id" => "M_Community_Id",
                        "hidden" => "",
                        "type" => "text",
                        "name" => "M_Community_Id",
                        "value" => $model->M_Community_Id
                      )
                    )
                    ?>
                    <?= formInput(
                      array(
                        "id" => "community",
                        "type" => "text",
                        "placeholder" => lang('Form.community'),
                        "class" => "form-control clearable",
                        "name" => "community",
                        "value" => $model->get_M_Community()->Name,
                        "required" => "",
                        "readonly" => ""
                      )
                    ) ?>
                    <div class="input-group-append">
                      <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalCommunity"><i class="fa fa-search"></i></button>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang("Form.reportername")) ?>
                    <?= formInput(
                      array(
                        "id" => "ReporterName",
                        "type" => "text",
                        "placeholder" => lang("Form.reportername"),
                        "class" => "form-control",
                        "name" => "ReporterName",
                        "value" => $model->ReporterName,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang("Form.telephone")) ?>
                    <?= formInput(
                      array(
                        "id" => "Phone",
                        "type" => "text",
                        "placeholder" => lang("Form.telephone"),
                        "class" => "form-control",
                        "name" => "Phone",
                        "value" => $model->Phone,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang('Form.subvillage'), array("for" => "subvillage")) ?>
                  <div class="input-group has-success">
                    <?= formInput(
                      array(
                        "id" => "M_Subvillage_Id",
                        "hidden" => "",
                        "type" => "text",
                        "name" => "M_Subvillage_Id",
                        "value" => $model->M_Subvillage_Id
                      )
                    )
                    ?>
                    <?= formInput(
                      array(
                        "id" => "subvillage",
                        "type" => "text",
                        "placeholder" => lang('Form.subvillage'),
                        "class" => "form-control clearable",
                        "name" => "subvillage",
                        "value" => $model->get_M_Subvillage()->Name,
                        "required" => "",
                        "readonly" => ""
                      )
                    ) ?>
                    <div class="input-group-append">
                      <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalSubvillage"><i class="fa fa-search"></i></button>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-md-6 col-12 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang('Form.disaster'), array("for" => "disaster")) ?>
                  <div class="input-group has-success">
                    <?= formInput(
                      array(
                        "id" => "M_Disaster_Id",
                        "hidden" => "",
                        "type" => "text",
                        "name" => "M_Disaster_Id",
                        "value" => $model->M_Disaster_Id
                      )
                    )
                    ?>
                    <?= formInput(
                      array(
                        "id" => "disaster",
                        "type" => "text",
                        "placeholder" => lang('Form.disaster'),
                        "class" => "form-control clearable",
                        "name" => "disaster",
                        "value" => $model->get_M_Disaster()->Name,
                        "required" => "",
                        "readonly" => ""
                      )
                    ) ?>
                    <div class="input-group-append">
                      <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalDisaster"><i class="fa fa-search"></i></button>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel("RT") ?>
                  <?= formInput(
                    array(
                      "id" => "RT",
                      "type" => "text",
                      "placeholder" => "RT",
                      "class" => "form-control",
                      "name" => "RT",
                      "value" => $model->RT
                    )
                  ) ?>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel("RW") ?>
                  <?= formInput(
                    array(
                      "id" => "RW",
                      "type" => "text",
                      "placeholder" => "RW",
                      "class" => "form-control",
                      "name" => "RW",
                      "value" => $model->RW
                    )
                  ) ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel(lang("Form.date")) ?>
                  <?= formInput(
                    array(
                      "id" => "DateOccur",
                      "type" => "text",
                      "placeholder" => lang("Form.date"),
                      "class" => "datetimepicker form-control",
                      "name" => "DateOccur",
                      "value" => $model->DateOccur
                    )
                  ) ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang("Form.latitude")) ?>
                  <?= formInput(
                    array(
                      "id" => "Latitude",
                      "type" => "text",
                      "placeholder" => lang("Form.latitude"),
                      "class" => "form-control",
                      "name" => "Latitude",
                      "value" => $model->Latitude
                    )
                  ) ?>
                  <small class="form-text"><a href = "#" onclick="showModalMap('#Latitude', '#Longitude')">Pilih dari map</a></small>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang("Form.longitude")) ?>
                  <?= formInput(
                    array(
                      "id" => "Longitude",
                      "type" => "text",
                      "placeholder" => lang("Form.longitude"),
                      "class" => "form-control",
                      "name" => "Longitude",
                      "value" => $model->Longitude
                    )
                  ) ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel(lang("Form.cronology")) ?>
                  <?= formTextArea(
                    $model->Cronology,
                    array(
                      "id" => "Cronology",
                      "type" => "text",
                      "placeholder" => lang("Form.cronology"),
                      "class" => "form-control",
                      "name" => "Cronology"
                    )
                  ) ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang('Form.picture'), array("for" => "photo")) ?>
                  <?= formInput(
                    array(
                      "id" => "photo",
                      "accept" => "image/jpg, image/jpeg, image/png",
                      "type" => "file",
                      "placeholder" => lang('Form.picture'),
                      "class" => "form-control",
                      "name" => "photo"
                    )
                  ) ?>
                </div>
              </div>
              <div class="col-md-6 col-12 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang('Form.video'), array("for" => "Video")) ?>
                  <?= formInput(
                    array(
                      "id" => "photo",
                      "accept" => "video/*",
                      "type" => "file",
                      "placeholder" => lang('Form.video'),
                      "class" => "form-control",
                      "name" => "video"
                    )
                  ) ?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <?= formInput(
                array(
                  "type" => "submit",
                  "class" => "btn btn-primary",
                  "value" => lang('Form.save'),
                )
              ) ?>
              <?= formLink(
                lang('Form.cancel'),
                array(
                  "href" => baseUrl('tdisasterreport'),
                  "value" => lang('Form.cancel'),
                  "class" => "btn btn-primary",
                )
              )
              ?>
            </div>
            <?= formClose() ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?= view("m_subvillage/modal") ?>
<?= view("m_community/modal") ?>
<?= view("m_disaster/modal") ?>
<?= view("modal/choosemap") ?>

<script>
  $(document).ready(function() {
    init();
  });

  function init() {

  }
</script>