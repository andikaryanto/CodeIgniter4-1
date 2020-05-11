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
      <h1 class="h3 display"><?= lang('Form.mastercommunity') ?> </h1>
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
                <!-- <a href="<?= baseUrl('mcommunity') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpenMultipart(baseUrl('mcommunity/addsave')) ?>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.community')) ?>
                    <?= formInput(
                      array(
                        "id" => "Name",
                        "type" => "text",
                        "placeholder" => lang('Form.community'),
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
                  <?= formLabel(lang('Form.serviceperiod')) ?>
                  <?= formInput(
                    array(
                      "id" => "ServicePeriod",
                      "type" => "text",
                      "placeholder" => lang('Form.serviceperiod'),
                      "class" => "form-control",
                      "name" => "ServicePeriod",
                      "value" => $model->ServicePeriod
                    )
                  ) ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel(lang('Form.numberofadmin')) ?>
                  <?= formInput(
                    array(
                      "id" => "NumberOfAdmin",
                      "type" => "number",
                      "placeholder" => lang('Form.numberofadmin'),
                      "class" => "form-control",
                      "name" => "NumberOfAdmin",
                      "value" => $model->NumberOfAdmin
                    )
                  ) ?>
                </div>
              </div>
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel(lang('Form.numberofmember')) ?>
                  <?= formInput(
                    array(
                      "id" => "NumberOfMember",
                      "type" => "number",
                      "placeholder" => lang('Form.numberofmember'),
                      "class" => "form-control",
                      "name" => "NumberOfMember",
                      "value" => $model->NumberOfMember
                    )
                  ) ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel('ADART') ?>
                  <?= formInput(
                    array(
                      "id" => "Adart",
                      "type" => "text",
                      "placeholder" => "ADART",
                      "class" => "form-control",
                      "name" => "Adart",
                      "value" => $model->Adart
                    )
                  ) ?>
                </div>
              </div>
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel(lang('Form.endservice')) ?>
                  <?= formInput(
                    array(
                      "id" => "EndService",
                      "type" => "text",
                      "placeholder" => lang('Form.endservice'),
                      "class" => "datepicker form-control",
                      "name" => "EndService",
                      "value" => $model->EndService
                    )
                  ) ?>
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
              </div>
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel(lang('Form.alternatephone')) ?>
                  <?= formInput(
                    array(
                      "id" => "AlternatePhone",
                      "type" => "text",
                      "placeholder" => lang('Form.alternatephone'),
                      "class" => "form-control",
                      "name" => "AlternatePhone",
                      "value" => $model->AlternatePhone
                    )
                  ) ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel(lang('Form.routinmeeting')) ?>
                  <?= formInput(
                    array(
                      "id" => "RoutinMeeting",
                      "type" => "text",
                      "placeholder" => lang('Form.routinmeeting'),
                      "class" => "form-control",
                      "name" => "RoutinMeeting",
                      "value" => $model->RoutinMeeting
                    )
                  ) ?>
                </div>
              </div>
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel(lang('Form.foundon')) ?>
                  <?= formInput(
                    array(
                      "id" => "FoundOn",
                      "type" => "text",
                      "placeholder" => lang('Form.foundon'),
                      "class" => "datepicker form-control",
                      "name" => "FoundOn",
                      "value" => $model->FoundOn
                    )
                  ) ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel(lang('Form.signedplaceman')) ?>
                  <?= formInput(
                    array(
                      "id" => "SignedPlaceman",
                      "type" => "text",
                      "placeholder" => lang('Form.signedplaceman'),
                      "class" => "form-control",
                      "name" => "SignedPlaceman",
                      "value" => $model->SignedPlaceman,
                      "required" => ""
                    )
                  ) ?>
                </div>
              </div>
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel("Free Rx") ?>
                  <?= formInput(
                    array(
                      "id" => "FreeRx",
                      "type" => "text",
                      "placeholder" => "Free Rx",
                      "class" => "form-control",
                      "name" => "FreeRx",
                      "value" => $model->FreeRx,
                      "required" => ""
                    )
                  ) ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel("Free Tx") ?>
                  <?= formInput(
                    array(
                      "id" => "FreeTx",
                      "type" => "text",
                      "placeholder" => "Free Tx",
                      "class" => "form-control",
                      "name" => "FreeTx",
                      "value" => $model->FreeTx,
                      "required" => ""
                    )
                  ) ?>
                </div>
              </div>
              <div class="col-md-6 col-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel("Tone") ?>
                  <?= formInput(
                    array(
                      "id" => "Tone",
                      "type" => "text",
                      "placeholder" => "Tone",
                      "class" => "form-control",
                      "name" => "Tone",
                      "value" => $model->Tone,
                      "required" => ""
                    )
                  ) ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-12 col-sm-12">
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
                  <?= formLabel(lang('Form.ownedequipment'), array("for" => "OwnedEquipment")) ?>
                  <?= formTextArea(
                    $model->OwnedEquipment,
                    array(
                      "id" => "OwnedEquipment",
                      "type" => "text",
                      "placeholder" => lang('Form.facility'),
                      "class" => "form-control",
                      "name" => "OwnedEquipment",
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
                  "href" => baseUrl('mcommunity'),
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
?>
<script>
  $(document).ready(function() {
    init();
  });

  function init() {

  }
</script>