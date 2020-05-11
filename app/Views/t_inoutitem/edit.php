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
      <h1 class="h3 display"><?= lang('Form.transactioninoutitem') ?> </h1>
      </tr>
    </header>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-6">
                <h4><?= lang('Form.edit') ?></h4>
              </div><div class="col-6 text-right">
                <a title = "Buat baru dari data ini" class = "link-action" href="<?= baseUrl("tinoutitem/copy/{$model->Id}") ?>"><i class="fa fa-copy"></i> <?= lang('Form.copy') ?></a>
                <a href="<?= baseUrl("tinoutitemdetail/{$model->Id}") ?>"><i class="fa fa-plus"></i> <?= lang('Form.item') ?></a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpen(baseUrl('tinoutitem/editsave')) ?>
            <?= formInput(
              array(
                "id" => "Id",
                "name" => "Id",
                "value" => $model->Id,
                "hidden" => ""
              )
            ) ?>
            <div class = "row">
              <div class = "col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.number')) ?>
                    <?= formInput(
                      array(
                        "id" => "TransNo",
                        "type" => "text",
                        "placeholder" => "[ Automatic ]",
                        "class" => "form-control",
                        "name" => "TransNo",
                        "value" => $model->TransNo,
                        "disabled" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.status')) ?>
                    <?= formSelect(
                      $model->getEnumStatus(),
                      "Value",
                      "EnumName",
                      array(
                        "id" => "Status",
                        "class" => "selectpicker form-control",
                        "name" => "Status"
                      )
                    ) ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <?= formLabel(lang('Form.disaster'), array("for" => "disaster")) ?>
                  <div class="input-group has-success">
                    <?= formInput(
                      array(
                        "id" => "T_Disasteroccur_Id",
                        "hidden" => "",
                        "type" => "text",
                        "name" => "T_Disasteroccur_Id",
                        "value" => $model->T_Disasteroccur_Id
                      )
                    )
                    ?>
                    <?= formInput(
                      array(
                        "id" => "disasteroccur",
                        "type" => "text",
                        "placeholder" => lang('Form.disasteroccur'),
                        "class" => "form-control clearable",
                        "name" => "disasteroccur",
                        "value" => $model->get_T_Disasteroccur()->TransNo,
                        "required" => "",
                        "readonly" => ""
                      )
                    ) ?>
                    <div class="input-group-append">
                      <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalDisasteroccur"><i class="fa fa-search"></i></button>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <?= formLabel(lang("Form.date")) ?>
              <?= formInput(
                array(
                  "id" => "Date",
                  "type" => "text",
                  "placeholder" => lang("Form.date"),
                  "class" => "datepicker form-control",
                  "name" => "Date",
                  "value" => $model->Date,
                  "autocomplete" => "off"
                )
              ) ?>
            </div>
            <div class="form-group">
              <div class="required">
                <?= formLabel(lang('Form.type')) ?>
                <?php $detail = "App\Models\M_enumdetails" ?>
                <?= formSelect(
                  $detail::getEnums("InOutItemType"),
                  "Value",
                  "EnumName",
                  array(
                    "id" => "TransType",
                    "class" => "selectpicker form-control",
                    "name" => "TransType"
                  )
                ) ?>
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
              <?= formLink(lang('Form.cancel'), array(
                "href" => baseUrl('tinoutitem'),
                "value" => lang('Form.cancel'),
                "class" => "btn btn-primary",
              )) ?>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?= view('t_disasteroccur/modal')?>
<script>
  $(document).ready(function() {
    initedit();
  });

  function initedit() {
    $('select#TransType option[value="<?= $model->TransType ? $model->TransType : 1?>"]').attr("selected", true);
    $('select#Status option[value="<?= $model->Status ? $model->Status : 1 ?>"]').attr("selected", true);
    $('.selectpicker').selectpicker('refresh');
  }
</script>