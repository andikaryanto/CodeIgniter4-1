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
      <h1 class="h3 display"><?= lang('Form.mastersubvillage') ?> </h1>
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
                <!-- <a href="<?= baseUrl('msubvillage') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpen(baseUrl('msubvillage/editsave')) ?>
            <?= formInput(
              array(
                "id" => "M_Village_Id",
                "name" => "M_Village_Id",
                "value" => $model->M_Village_Id,
                "hidden" => ""
              )
            ) ?><?= formInput(
              array(
                "id" => "Id",
                "name" => "Id",
                "value" => $model->Id,
                "hidden" => ""
              )
            ) ?>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <div class="i-checks">
                    <?= formInput(
                      array(
                        "id" => "IsDestana",
                        "type" => "checkbox",
                        "class" => "form-control-custom",
                        "name" => "IsDestana"
                      )
                    ) ?>
                    <?= formLabel("Destana", array("for" => "IsDestana")) ?>

                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="required">
                <?= formLabel(lang('Form.subvillage')) ?>
                <?= formInput(
                  array(
                    "id" => "Name",
                    "type" => "text",
                    "placeholder" => lang('Form.subvillage'),
                    "class" => "form-control",
                    "name" => "Name",
                    "value" => $model->Name,
                    "required" => ""
                  )
                ) ?>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang("Form.leader")) ?>
                  <?= formInput(
                    array(
                      "id" => "Leader",
                      "type" => "text",
                      "placeholder" => lang("Form.leader"),
                      "class" => "form-control",
                      "name" => "Leader",
                      "value" => $model->Leader
                    )
                  ) ?>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang("Form.telephone")) ?>
                  <?= formInput(
                    array(
                      "id" => "Phone",
                      "type" => "text",
                      "placeholder" => lang("Form.telephone"),
                      "class" => "form-control",
                      "name" => "Phone",
                      "value" => $model->Phone
                    )
                  ) ?>
                </div>
              </div>
            </div>
            <div class="row">

              <div class="col-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.village')) ?>
                    <div class="input-group has-success">
                      <?= formInput(
                        array(
                          "id" => "village",
                          "type" => "text",
                          "placeholder" => lang('Form.village'),
                          "class" => "form-control custom-readonly clearable",
                          "name" => "village",
                          "value" => $model->get_M_Village()->Name,
                          "readonly" => "",
                          "required" => ""
                        )
                      )
                      ?>
                      <!-- <span class="form-control-feedback text-primary">
                        <i class="material-icons">search</i>
                    </span> -->
                      <div class="input-group-append">
                        <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalVillage"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- <div class="col-12 col-sm-6 col-md-6">
                <?= formLabel(lang("Form.distancefrommerapi")) ?>
                <?= formInput(
                  array(
                    "id" => "FromMerapi",
                    "type" => "text",
                    "placeholder" => lang('Form.distancefrommerapi'),
                    "class" => "form-control",
                    "name" => "FromMerapi",
                    "value" => $model->FromMerapi,
                    "required" => ""
                  )
                ) ?>
              </div> -->
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
            <div class="row">
              <div class="col-12 col-sm-6 col-md-6">
                <div class="form-group">
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
              <div class="col-12 col-sm-6 col-md-6">
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
                "href" => baseUrl('msubvillage'),
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

<?= view('m_village/modal'); ?>
<?= view('modal/choosemap'); ?>
<script>
  $(document).ready(function() {
    init();
  });

  function init() {
    <?php
    if (!is_null($model->IsDestana)) {
      ?>
      $('#IsDestana').prop('checked', true);
    <?php
    }
    ?>
    $('select#KRB option[value="<?= $model->KRB ? $model->KRB : 1 ?>"]').attr("selected", true);
    $('.selectpicker').selectpicker('refresh');
  }
</script>