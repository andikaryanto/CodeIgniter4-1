<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Master       </li>
    </ul>
  </div>
</div>
<section>
  <div class="container-fluid">
    <!-- Page Header-->
    <header> 
          <h1 class="h3 display"><?= lang('Form.volunteer')?> </h1>
      </tr>
    </header>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class = "row">
              <div class="col-6">
                <h4><?= lang('Form.edit')?></h4>
              </div>
              <div class="col-6 text-right">
                <!-- <a href="<?= baseUrl('mvolunteer')?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">                
            <?= formOpen(baseUrl('mvolunteer/editsave'))?>
                <?= formInput(
                    array("id" => "Id",
                          "name" => "Id",
                          "value" => $model->Id,
                          "hidden" => ""
                    )
                )?>
              <div class="row">
              <div class="col-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.volunteer')) ?>
                    <?= formInput(
                      array(
                        "id" => "Name",
                        "type" => "text",
                        "placeholder" => lang('Form.volunteer'),
                        "class" => "form-control",
                        "name" => "Name",
                        "value" => $model->Name,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel("NRR") ?>
                    <?= formInput(
                      array(
                        "id" => "NRR",
                        "type" => "text",
                        "placeholder" => "NRR",
                        "class" => "form-control",
                        "name" => "NRR",
                        "value" => $model->NRR,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel("NIK") ?>
                    <?= formInput(
                      array(
                        "id" => "NIK",
                        "type" => "text",
                        "placeholder" => "NIK",
                        "class" => "form-control",
                        "name" => "NIK",
                        "value" => $model->NIK,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.gender')) ?>
                    <?php $enums = "App\Models\M_enumdetails"; ?>
                    <?=
                      formSelect(
                        $enums::getEnums("Gender"),
                        "Value",
                        "EnumName",
                        array(
                          "id" => "Gender",
                          "class" => "selectpicker form-control",
                          "name" => "Gender"
                        )
                      ) ?>
                  </div>
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
                        "class" => "form-control",
                        "name" => "subvillage",
                        "value" => $model->get_M_Subvillage()->Name,
                        "required" => "",
                        "disabled" => ""
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
              <div class="col-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.placeofbirth')) ?>
                    <?= formInput(
                      array(
                        "id" => "BirthPlace",
                        "type" => "text",
                        "placeholder" => lang('Form.placeofbirth'),
                        "class" => "form-control",
                        "name" => "BirthPlace",
                        "value" => $model->BirthPlace,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.dateofbirth')) ?>
                    <?= formInput(
                      array(
                        "id" => "BirthDate",
                        "type" => "text",
                        "placeholder" => lang('Form.dateofbirth'),
                        "class" => "datepicker form-control",
                        "name" => "BirthDate",
                        "value" => $model->BirthDate,
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
                  <?= formLabel(lang('Form.capability'), array("for" => "Capability")) ?>
                  <div class="input-group has-success">
                    <?= formInput(
                      array(
                        "id" => "M_Capability_Id",
                        "hidden" => "",
                        "type" => "text",
                        "name" => "M_Capability_Id",
                        "value" => $model->M_Capability_Id
                      )
                    )
                    ?>
                    <?= formInput(
                      array(
                        "id" => "capability",
                        "type" => "text",
                        "placeholder" => lang('Form.capability'),
                        "class" => "form-control",
                        "name" => "capability",
                        "value" => $model->get_M_Capability()->Name,
                        "required" => "",
                        "disabled" => ""
                      )
                    ) ?>
                    <div class="input-group-append">
                      <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalCapability"><i class="fa fa-search"></i></button>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-md-6 col-12 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang('Form.community'), array("for" => "Community")) ?>
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
                        "class" => "form-control",
                        "name" => "community",
                        "value" => $model->get_M_Community()->Name,
                        "required" => "",
                        "disabled" => ""
                      )
                    ) ?>
                    <div class="input-group-append">
                      <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalCommunity"><i class="fa fa-search"></i></button>
                    </div>

                  </div>
                </div>
              </div>
            </div>
              <div class="form-group">       
                <?= formInput(
                      array("type" => "submit",
                            "class" => "btn btn-primary",
                            "value" => lang('Form.save'),
                      )
                )?>
                <?= formLink( lang('Form.cancel'), array(
                  "href" => baseUrl('mvolunteer'),
                  "value" => lang('Form.cancel'),
                  "class" => "btn btn-primary",
                ))?>
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

        function init(){
      
        }
      </script>