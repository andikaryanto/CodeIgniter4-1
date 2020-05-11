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
      <h1 class="h3 display"><?= lang('Form.masterdisasterschool') ?> </h1>
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
                <!-- <a href="<?= baseUrl('mdisasterschool') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpenMultipart(baseUrl('mdisasterschool/addsave')) ?>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <div class="i-checks">
                    <?= formInput(
                      array(
                        "id" => "IsSSB",
                        "type" => "checkbox",
                        "class" => "form-control-custom",
                        "name" => "IsSSB"
                      )
                    ) ?>
                    <?= formLabel("SSB ?", array("for" => "IsSSB")) ?>

                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.disasterschool')) ?>
                    <?= formInput(
                      array(
                        "id" => "Name",
                        "type" => "text",
                        "placeholder" => lang('Form.disasterschool'),
                        "class" => "form-control",
                        "name" => "Name",
                        "value" => $model->Name,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.personincharge')) ?>
                    <?= formInput(
                      array(
                        "id" => "PersonInCharge",
                        "type" => "text",
                        "placeholder" => lang('Form.personincharge'),
                        "class" => "form-control",
                        "name" => "PersonInCharge",
                        "value" => $model->PersonInCharge,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.telephone')) ?>
                    <?= formInput(
                      array(
                        "id" => "PhonePerson",
                        "type" => "text",
                        "placeholder" => lang('Form.telephone'),
                        "class" => "form-control",
                        "name" => "PhonePerson",
                        "value" => $model->PhonePerson,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.capacity')) ?>
                    <?= formInput(
                      array(
                        "id" => "Capacity",
                        "type" => "text",
                        "placeholder" => lang('Form.capacity'),
                        "class" => "form-control",
                        "name" => "Capacity",
                        "value" => $model->Capacity,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.malestudent')) ?>
                    <?= formInput(
                      array(
                        "id" => "MaleStudent",
                        "type" => "text",
                        "placeholder" => lang('Form.malestudent'),
                        "class" => "form-control",
                        "name" => "MaleStudent",
                        "value" => $model->MaleStudent,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.femalestudent')) ?>
                    <?= formInput(
                      array(
                        "id" => "FemaleStudent",
                        "type" => "text",
                        "placeholder" => lang('Form.femalestudent'),
                        "class" => "form-control",
                        "name" => "FemaleStudent",
                        "value" => $model->FemaleStudent,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.latitude')) ?>
                    <?= formInput(
                      array(
                        "id" => "Latitude",
                        "type" => "text",
                        "placeholder" => lang('Form.latitude'),
                        "class" => "form-control",
                        "name" => "Latitude",
                        "value" => $model->Latitude,
                        "required" => ""
                      )
                    ) ?>
                    <small class="form-text"><a href="#" onclick="showModalMap('#Latitude', '#Longitude')">Pilih dari map</a></small>
                 
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.longitude')) ?>
                    <?= formInput(
                      array(
                        "id" => "Longitude",
                        "type" => "text",
                        "placeholder" => lang('Form.longitude'),
                        "class" => "form-control",
                        "name" => "Longitude",
                        "value" => $model->Longitude,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.phonessb')) ?>
                    <?= formInput(
                      array(
                        "id" => "Phone",
                        "type" => "text",
                        "placeholder" => lang('Form.phonessb'),
                        "class" => "form-control",
                        "name" => "Phone",
                        "value" => $model->Phone,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-12 col-sm-12">
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
                        "id" => "village",
                        "type" => "text",
                        "placeholder" => lang('Form.subvillage'),
                        "class" => "form-control clearable",
                        "name" => "village",
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
                <div class="col-md-6 col-12 col-sm-12">
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
                <div class="col-md-6 col-12 col-sm-12">
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
              <div class="row">
                <div class="col-md-6 col-12 col-sm-6">
                  <div class="form-group">
                    <?= formLabel(lang('Form.facility'), array("for" => "facility")) ?>
                      <?= formTextArea($model->Facility,
                        array(
                          "id" => "Facility",
                          "type" => "text",
                          "placeholder" => lang('Form.facility'),
                          "class" => "form-control",
                          "name" => "Facility",
                        )
                      ) ?>
                  </div>
                </div>
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
                        "name" => "photo",
                        "required" => ""
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
                    "href" => baseUrl('mdisasterschool'),
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
<?php 
$this->view("m_subvillage/modal");

$this->view("modal/choosemap");
?>
<script>
  $(document).ready(function() {
    init();
  });

  function init() {
    <?php
    if (!is_null($model->IsSSB)) {
      ?>
      $('#IsSSB').prop('checked', true);
    <?php
    }
    ?>
  }
</script>