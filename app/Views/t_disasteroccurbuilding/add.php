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
      <h1 class="h3 display"><?= lang('Form.disasterbuilding') . " ({$disasteroccur->TransNo} ~ {$disasteroccur->get_M_Disaster()->Name})" ?> </h1>
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
                <a href="<?= baseUrl("tdisasteroccurimpact/add/{$disasteroccur->Id}") ?>"><i class="fa fa-plus"></i> Dampak</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpen(baseUrl('tdisasteroccurbuilding/addsave')) ?>
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
            <div class="row">
              <div class="col-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <div class="required">
                    <?= formLabel(lang("Form.disasterimpact")) ?>
                    <?= formInput(
                      array(
                        "id" => "Name",
                        "type" => "text",
                        "placeholder" => lang("Form.disasterimpact"),
                        "class" => "form-control",
                        "name" => "Name",
                        "value" => $model->Name,
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
                  <?= formLabel(lang('Form.familycard'), array("for" => "building")) ?>
                  <div class="input-group has-success">
                    <?= formInput(
                      array(
                        "id" => "M_Familycard_Id",
                        "type" => "text",
                        "hidden" => "",
                        "name" => "M_Familycard_Id",
                        "value" => $model->M_Familycard_Id
                      )
                    )
                    ?>
                    <?php
                    $data = $model->get_M_Familycard();
                    $value = "";
                    if(!is_null($data->Id))
                      $value = $data->FamilyCardNo."~".$data->getHeadFamily();
                    echo formInput(
                      array(
                        "id" => "familycard",
                        "type" => "text",
                        "placeholder" => lang('Form.familycard'),
                        "class" => "form-control clearable",
                        "name" => "familycard",
                        "value" => $value,
                        "readonly" => ""
                      )
                    );
                    ?>
                    <div class="input-group-append">
                      <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalFamilycard"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang("Form.damage")) ?>
                  <?= formInput(
                    array(
                      "id" => "Damage",
                      "type" => "number",
                      "placeholder" => lang("Form.damage"),
                      "class" => "form-control",
                      "name" => "Damage",
                      "value" => $model->Damage
                    )
                  ) ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel("Deskripsi Kerusakan") ?>
                  <?= formTextArea(
                    $model->DamageDescription,
                    array(
                      "id" => "DamageDescription",
                      "type" => "number",
                      "placeholder" => "Deskripsi Kerusakan",
                      "class" => "form-control",
                      "name" => "DamageDescription",
                      "value" => $model->DamageDescription
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
                  "href" => baseUrl("tdisasteroccurbuilding/{$disasteroccur->Id}"),
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
<?= view('m_familycard/modal') ?>

<script>
  $("#btnGroupModal").on("click", function() {
    // <?php
    // $familyid = array();
    // foreach ($disasteroccur->get_list_T_Disasteroccurvictim() as $victim) {
    //   if (!in_array($victim->M_Familycard_Id, $familyid)) {
    //     array_push($familyid, $victim->M_Familycard_Id);
    //   }
    // }

    // $strFamilyid = implode(",", $familyid);
    // ?>
    // changeFamilyCardId('<?= $strFamilyid ?>');
  })

  $(document).ready(function() {
    init();
  });

  function init() {

  }
</script>