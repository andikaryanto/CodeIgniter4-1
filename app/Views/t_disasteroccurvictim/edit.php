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
      <h1 class="h3 display"><?= lang('Form.disastervictim') . " ({$disasteroccur->TransNo} ~ {$disasteroccur->get_M_Disaster()->Name})" ?> </h1>
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
                <!-- <a href="<?= baseUrl('tdisasteroccurvictim') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpen(baseUrl('tdisasteroccurvictim/editsave')) ?>
            <?= formInput(
              array(
                "id" => "T_Disasteroccur_Id",
                "hidden" => "",
                "type" => "text",
                "name" => "T_Disasteroccur_Id",
                "value" => $disasteroccur->Id
              )
            )
            ?>
            <?= formInput(
              array(
                "id" => "Id",
                "hidden" => "",
                "type" => "text",
                "name" => "Id",
                "value" => $model->Id
              )
            )
            ?>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <?= formLabel(lang('Form.familycard'), array("for" => "familycard")) ?>
                  <div class="input-group has-success">
                    <?= formInput(
                      array(
                        "id" => "M_Familycard_Id",
                        "hidden" => "",
                        "type" => "text",
                        "name" => "M_Familycard_Id",
                        "value" => $model->M_Familycard_Id
                      )
                    )
                    ?>
                    <?= formInput(
                      array(
                        "id" => "familycard",
                        "type" => "text",
                        "placeholder" => lang('Form.familycard'),
                        "class" => "form-control",
                        "name" => "familycard",
                        "value" => $model->get_M_Familycard()->FamilyCardNo,
                        "required" => "",
                        "readonly" => ""
                      )
                    ) ?>
                    <!-- <div class="input-group-append">
                      <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalFamilycard"><i class="fa fa-search"></i></button>
                    </div> -->

                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang('Form.familycardmember'), array("for" => "M_Familycardmember_Id")) ?>
                  <div class="input-group has-success">
                    <?= formInput(
                      array(
                        "id" => "M_Familycardmember_Id",
                        "hidden" => "",
                        "type" => "text",
                        "name" => "M_Familycardmember_Id",
                        "value" => $model->M_Familycardmember_Id
                      )
                    )
                    ?>
                    <?= formInput(
                      array(
                        "id" => "NIK",
                        "hidden" => "",
                        "type" => "text",
                        "name" => "NIK",
                        "value" => $model->NIK
                      )
                    )
                    ?>
                    <?= formInput(
                      array(
                        "id" => "familycardmember",
                        "type" => "text",
                        "placeholder" => lang('Form.familycardmember'),
                        "class" => "form-control clearable",
                        "name" => "familycardmember",
                        "value" => $model->get_M_Familycardmember()->NIK,
                        "readonly" => ""
                      )
                    ) ?>
                    <div class="input-group-append">
                      <button id="btnFamilymember" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalFamilycardmember"><i class="fa fa-search"></i></button>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang("Form.name")) ?>
                  <?= formInput(
                    array(
                      "id" => "Name",
                      "type" => "text",
                      "placeholder" => lang("Form.name"),
                      "class" => "form-control",
                      "name" => "Name",
                      "value" => $model->Name
                    )
                  ) ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.gender')) ?>
                    <?php $detail = "App\Models\M_enumdetails" ?>
                    <?= formSelect(
                      $detail::getEnums("Gender"),
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
              <div class="col-6">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang('Form.religion')) ?>
                    <?php $detail = "App\Models\M_enumdetails" ?>
                    <?= formSelect(
                      $detail::getEnums("Religion"),
                      "Value",
                      "EnumName",
                      array(
                        "id" => "Religion",
                        "class" => "selectpicker form-control",
                        "name" => "Religion"
                      )
                    ) ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <?= formLabel(lang('Form.placeofbirth'), array("for" => "BirthPlace")) ?>
                  <?= formInput(
                    array(
                      "id" => "BirthPlace",
                      "type" => "text",
                      "placeholder" => lang('Form.placeofbirth'),
                      "class" => "form-control",
                      "name" => "BirthPlace",
                      "value" => $model->BirthPlace
                    )
                  ) ?>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <?= formLabel(lang('Form.dateofbirth'), array("for" => "BirthDate")) ?>
                  <?= formInput(
                    array(
                      "id" => "BirthDate",
                      "type" => "text",
                      "placeholder" => lang('Form.dateofbirth'),
                      "class" => "datepicker form-control",
                      "name" => "BirthDate",
                      "value" => $model->BirthDate,
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
              <?= formLink(lang('Form.cancel'), array(
                "href" => baseUrl("tdisasteroccurvictim/{$disasteroccur->Id}"),
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
  <?= $this->view('m_familycardmember/modal')?>
<script>
  $(document).ready(function() {
    initvictimedit();
  });

  $("#btnFamilymember").on("click", (function(e) {
    var familycard = $("#M_Familycard_Id").val();
    if (familycard) {
      changeFamilyCardId(familycard);
    }
  }))

  $('#modalFamilycardmember').on('hidden.bs.modal', function(e) {
    var familycard = $("#M_Familycardmember_Id").val();
    $.ajax({
      url: "<?= baseUrl("mfamilycardmember/getDataById") ?>",
      type: "POST",
      data: {
        id: familycard,
        role: "t_disasteroccur"
      },
      success: function(data) {
        var model = JSON.parse(data);
        $("#Name").val(model.data.CompleteName)
        $("#NIK").val(model.data.NIK)
        $("#BirthDate").val(model.data.BirthDate)
        $("#BirthPlace").val(model.data.BirthPlace)
        $("#Religion").val(model.data.Religion)
        $('select#Gender option[value="' + model.data.Gender + '"]').attr("selected", true);
        $('select#Religion option[value="' + model.data.Religion + '"]').attr("selected", true);
        $('.selectpicker').selectpicker('refresh');
      }
    });
  })

  function initvictimedit() {
    
    $('select#Gender option[value="<?= $model->Gender ? $model->Gender : 1?>"]').attr("selected", true);
    $('select#Religion option[value="<?= $model->Religion ? $model->Religion : 1?>"]').attr("selected", true);
    $('.selectpicker').selectpicker('refresh');
    $('.selectpicker').selectpicker({
      style: 'btn-primary'
    });
  }
</script>