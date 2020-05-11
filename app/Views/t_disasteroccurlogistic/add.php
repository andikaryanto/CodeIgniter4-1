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
      <h1 class="h3 display">

        <?= lang('Form.disasterlogistic') . " ({$disasteroccur->TransNo} ~ {$disasteroccur->get_M_Disaster()->Name})" ?> </h1>
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
                <!-- <a href="<?= baseUrl('tdisasteroccurlogistic') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpen(baseUrl('tdisasteroccurlogistic/addsave')) ?>
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
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang('Form.item'), array("for" => "M_Item_Id")) ?>
                  <div class="input-group has-success">
                    <?= formInput(
                      array(
                        "id" => "M_Item_Id",
                        "hidden" => "",
                        "type" => "text",
                        "name" => "M_Item_Id",
                        "value" => $model->M_Item_Id
                      )
                    )
                    ?>
                    <?= formInput(
                      array(
                        "id" => "item",
                        "type" => "text",
                        "placeholder" => lang('Form.item'),
                        "class" => "form-control clearable",
                        "name" => "item",
                        "value" => $model->get_M_Item()->Name,
                        "required" => "",
                        "readonly" => ""
                      )
                    ) ?>
                    <div class="input-group-append">
                      <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalItem"><i class="fa fa-search"></i></button>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang('Form.warehouse'), array("for" => "M_Warehouse_Id")) ?>
                  <div class="input-group has-success">
                    <?= formInput(
                      array(
                        "id" => "M_Warehouse_Id",
                        "hidden" => "",
                        "type" => "text",
                        "name" => "M_Warehouse_Id",
                        "value" => $model->M_Warehouse_Id
                      )
                    )
                    ?>
                    <?= formInput(
                      array(
                        "id" => "warehouse",
                        "type" => "text",
                        "placeholder" => lang('Form.warehouse'),
                        "class" => "form-control clearable",
                        "name" => "warehouse",
                        "value" => $model->get_M_Warehouse()->Name,
                        "readonly" => ""
                      )
                    ) ?>
                    <div class="input-group-append">
                      <button id="btnItem" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalWarehouse"><i class="fa fa-search"></i></button>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang("Form.qty")) ?>
                  <?= formInput(
                    array(
                      "id" => "Qty",
                      "type" => "text",
                      "placeholder" => lang("Form.qty"),
                      "class" => "form-control money2",
                      "name" => "Qty",
                      "value" => $model->Qty
                    )
                  ) ?>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6">
                <div class="form-group">
                  <?= formLabel(lang("Form.recipient")) ?>
                  <?= formInput(
                    array(
                      "id" => "Recipient",
                      "type" => "text",
                      "placeholder" => lang("Form.recipient"),
                      "class" => "form-control",
                      "name" => "Recipient",
                      "value" => $model->Recipient
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
                "href" => baseUrl("tdisasteroccurlogistic/{$disasteroccur->Id}"),
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
<?= view('m_item/modal') ?>
<?php
$this->view('m_warehouse/modal')
?>

<script>
  $(document).ready(function() {
    initlogisticadd();
  });

  

  function initlogisticadd() {
    $('.selectpicker').selectpicker({
      style: 'btn-primary'
    });
  }
</script>