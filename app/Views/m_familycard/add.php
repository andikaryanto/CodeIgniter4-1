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
      <h1 class="h3 display"><?= lang('Form.masterfamilycard') ?> </h1>
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
                <!-- <a href="<?= baseUrl('mfamilycard') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpen(baseUrl('mfamilycard/addsave')) ?>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.familycard')) ?>
                    <?= formInput(
                      array(
                        "id" => "FamilyCardNo",
                        "type" => "text",
                        "placeholder" => lang('Form.familycard'),
                        "class" => "form-control",
                        "name" => "FamilyCardNo",
                        "value" => $model->FamilyCardNo,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
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
            </div>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-6">
                <div class="form-group">
                  <?= formLabel("RT", array("for" => "rt")) ?>
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
              <div class="col-md-6 col-12 col-sm-6">
                <div class="form-group">
                  <?= formLabel("RW", array("for" => "rw")) ?>
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
            <div class="form-group">
              <?= formLabel(lang('Form.description')) ?>
              <?= formTextArea($model->Description, array(
                "id" => "Description",
                "placeholder" => lang('Form.description'),
                "type" => "text",
                "class" => "form-control",
                "name" => "Description"
              )) ?>
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
                  "href" => baseUrl('mfamilycard'),
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
<?= view("m_subvillage/modal")?>

<script>
  $(document).ready(function() {
    init();
  });

  function init() {

  }
</script>