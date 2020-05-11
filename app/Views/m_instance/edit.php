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
      <h1 class="h3 display"><?= lang('Form.master_instance') ?> </h1>
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
                <!-- <a href="<?= baseUrl('minstance') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpen(baseUrl('minstance/editsave')) ?>
            <?= formInput(
              array(
                "id" => "Id",
                "name" => "Id",
                "value" => $model->Id,
                "hidden" => ""
              )
            ) ?>
            <div class="form-group">
              <div class="required">
                <?= formLabel(lang('Form.instance')) ?>
                <?= formInput(
                  array(
                    "id" => "Name",
                    "type" => "text",
                    "placeholder" => lang('Form.instance'),
                    "class" => "form-control",
                    "name" => "Name",
                    "value" => $model->Name,
                    "required" => ""
                  )
                ) ?>
              </div>
            </div>
            <div class="form-group">
              <div class="required">
                <?= formLabel(lang('Form.telephone')) ?>
                <?= formInput(
                  array(
                    "id" => "Phone",
                    "type" => "text",
                    "placeholder" => lang('Form.telephone'),
                    "class" => "form-control",
                    "name" => "Phone",
                    "value" => $model->Phone,
                    "required" => ""
                  )
                ) ?>
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
                  <small class="form-text"><a href="#" onclick="showModalMap('#Latitude', '#Longitude')">Pilih dari map</a></small>
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
            <div class="form-group">
              <div class="required">
                <?= formLabel(lang('Form.address')) ?>
                <?= formTextArea($model->Address, array(
                  "id" => "Address",
                  "placeholder" => lang('Form.address'),
                  "type" => "text",
                  "class" => "form-control",
                  "name" => "Address"
                )) ?>
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
              <?= formLink(lang('Form.cancel'), array(
                "href" => baseUrl('minstance'),
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

<?= view("modal/choosemap") ?>
<script>
  $(document).ready(function() {
    init();
  });

  function init() {

  }
</script>