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
      <h1 class="h3 display"><?= lang('Form.masterearlywarning') ?> </h1>
      </tr>
    </header>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-6">
                <h4><?= lang('Form.edit') ?></h4>
              </div>
              <div class="col-6 text-right">
                <!-- <a href="<?= baseUrl('mearlywarning') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpen(baseUrl('mearlywarning/editsave')) ?>
            <?= formInput(
              array(
                "id" => "Id",
                "name" => "Id",
                "value" => $model->Id,
                "hidden" => ""
              )
            ) ?>
            <div class="form-group">
              <?= formLabel(lang("Form.date")) ?>
              <?= formInput(
                array(
                  "id" => "Date",
                  "type" => "text",
                  "placeholder" => lang("Form.date"),
                  "class" => "date form-control",
                  "name" => "Date",
                  "value" => $model->Date,
                  "autocomplete" => "off"
                )
              ) ?>
            </div>
            <div class="form-group">
              <?= formLabel(lang("Form.endtime")) ?>
              <?= formInput(
                array(
                  "id" => "TimeEnd",
                  "type" => "text",
                  "placeholder" => lang("Form.endtime"),
                  "class" => "time form-control",
                  "name" => "TimeEnd",
                  "value" => $model->TimeEnd
                )
              ) ?>
            </div>
            <div class="form-group">
              <div class="required">
                <?= formLabel(lang('Form.status')) ?>
                <?php $detail = "App\Models\M_enumdetails" ?>
                <?= formSelect(
                  $detail::getEnums("WarningType"),
                  "Value",
                  "EnumName",
                  array(
                    "id" => "TypeWarning",
                    "class" => "selectpicker form-control",
                    "name" => "TypeWarning"
                  )
                ) ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-12 col-sm-12">
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
            </div>
            <div class="form-group">
              <?= formLabel(lang('Form.description')) ?>
              <?= formTextArea($model->Description, array(
                "id" => "Description",
                "placeholder" => lang('Form.description'),
                "type" => "text",
                "class" => "summernote",
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
              <?= formLink(lang('Form.cancel'), array(
                "href" => baseUrl('mearlywarning'),
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
<script>
  $(document).ready(function() {
    init();
  });

  function init() {
    
    $('select#TypeWarning option[value="<?= $model->TypeWarning ? $model->TypeWarning : 1 ?>"]').attr("selected", true);
    $('.selectpicker').selectpicker('refresh');
  
  }
</script>