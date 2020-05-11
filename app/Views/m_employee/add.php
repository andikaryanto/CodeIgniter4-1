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
      <h1 class="h3 display"><?= lang('Form.masteremployee') ?> </h1>
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
                <!-- <a href="<?= baseUrl('memployee') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpen(baseUrl('memployee/addsave')) ?>
            <div class="row">
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.employee')) ?>
                    <?= formInput(
                      array(
                        "id" => "Name",
                        "type" => "text",
                        "placeholder" => lang('Form.employee'),
                        "class" => "form-control",
                        "name" => "Name",
                        "value" => $model->Name,
                        "required" => ""
                      )
                    ) ?>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6">
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
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel("NIP") ?>
                  <?= formInput(
                    array(
                      "id" => "NIP",
                      "type" => "text",
                      "placeholder" => "NIP",
                      "class" => "form-control",
                      "name" => "NIP",
                      "value" => $model->NIP
                    )
                  ) ?>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.occupation')) ?>
                    <div class="input-group has-success">
                      <?= formInput(
                        array(
                          "id" => "M_Occupation_Id",
                          "hidden" => "",
                          "type" => "text",
                          "name" => "M_Occupation_Id",
                          "value" => $model->M_Occupation_Id
                        )
                      )
                      ?>
                      <?= formInput(
                        array(
                          "id" => "occupation",
                          "type" => "text",
                          "placeholder" => lang('Form.occupation'),
                          "class" => "form-control custom-readonly clearable",
                          "name" => "occupation",
                          "value" => $model->get_M_Occupation()->Name,
                          "readonly" => "",
                          "required" => ""
                        )
                      )
                      ?>
                      <div class="input-group-append">
                        <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalOccupation"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.department')) ?>
                    <?php $detail = "App\Models\M_enumdetails" ?>
                    <?= formSelect(
                      $detail::getEnums("EmployeeDepartment"),
                      "Value",
                      "EnumName",
                      array(
                        "id" => "EmployeeDepartment",
                        "class" => "selectpicker form-control",
                        "name" => "EmployeeDepartment"
                      )
                    ) ?>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.status')) ?>
                    <?php $detail = "App\Models\M_enumdetails" ?>
                    <?= formSelect(
                      $detail::getEnums("EmployeeStatus"),
                      "Value",
                      "EnumName",
                      array(
                        "id" => "EmployeeStatus",
                        "class" => "selectpicker form-control",
                        "name" => "EmployeeStatus"
                      )
                    ) ?>
                  </div>
                </div>
              </div>
            </div>
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
                  "href" => baseUrl('memployee'),
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

<?= view("m_occupation/modal") ?>

<script>
  $(document).ready(function() {
    init();
  });

  function init() {

    $('select#EmployeeDepartment option[value="<?= $model->EmployeeDepartment ? $model->EmployeeDepartment : 1 ?>"]').attr("selected", true);
    $('select#EmployeeStatus option[value="<?= $model->EmployeeStatus ? $model->EmployeeStatus : 1 ?>"]').attr("selected", true);
    $('.selectpicker').selectpicker('refresh');
  }
</script>