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
      <h1 class="h3 display"><?= lang('Form.disasterimpact') . " ({$disasterassessment->get_T_Disasterreport()->ReportNo} ~ {$disasterassessment->get_M_Disaster()->Name})" ?> </h1>
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
                <!-- <a href="<?= baseUrl('tdisasterassessmentimpact') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpen(baseUrl('tdisasterassessmentimpact/addsave')) ?>
            <?= formInput(
              array(
                "id" => "T_Disasterassessment_Id",
                "hidden" => "",
                "type" => "text",
                "name" => "T_Disasterassessment_Id",
                "value" => $disasterassessment->Id
              )
            )
            ?>
            <div class="row">

              <div class="col-md-6 col-12 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang('Form.impact'), array("for" => "impact")) ?>
                  <div class="input-group has-success">
                    <?= formInput(
                      array(
                        "id" => "M_Impact_Id",
                        "hidden" => "",
                        "type" => "text",
                        "name" => "M_Impact_Id",
                        "value" => $model->M_Impact_Id
                      )
                    )
                    ?>
                    <?= formInput(
                      array(
                        "id" => "impact",
                        "type" => "text",
                        "placeholder" => lang('Form.impact'),
                        "class" => "form-control clearable",
                        "name" => "impact",
                        "value" => $model->get_M_Impact()->Name,
                        "required" => "",
                        "readonly" => ""
                      )
                    ) ?>
                    <div class="input-group-append">
                      <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalImpact"><i class="fa fa-search"></i></button>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang("Form.qty")) ?>
                  <?= formInput(
                    array(
                      "id" => "Quantity",
                      "type" => "number",
                      "placeholder" => lang("Form.qty"),
                      "class" => "form-control",
                      "name" => "Quantity",
                      "value" => $model->Quantity
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
                  "href" => baseUrl("tdisasterassessmentimpact/{$disasterassessment->Id}"),
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
<?= view('m_impact/modal') ?>

<script>
  $(document).ready(function() {
    init();
  });

  function init() {

  }
</script>