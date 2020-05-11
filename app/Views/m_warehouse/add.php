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
      <h1 class="h3 display"><?= lang('Form.masterwarehouse') ?> </h1>
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
                <!-- <a href="<?= baseUrl('mwarehouse') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpen(baseUrl('mwarehouse/addsave')) ?>
            <?= formInput(
              array(
                "id" => "M_Subvillage_Id",
                "name" => "M_Subvillage_Id",
                "value" => $model->M_Subvillage_Id,
                "hidden" => ""
              )
            ) ?>
            <div class="form-group">
              <div class="required">
                <?= formLabel(lang('Form.warehouse')) ?>
                <?= formInput(
                  array(
                    "id" => "Name",
                    "type" => "text",
                    "placeholder" => lang('Form.warehouse'),
                    "class" => "form-control",
                    "name" => "Name",
                    "value" => $model->Name,
                    "required" => ""
                  )
                ) ?>
              </div>
            </div>
            <div class="form-group">
              <?= formLabel(lang('Form.subvillage')) ?>
              <div class="input-group has-success">
                <?= formInput(
                  array(
                    "id" => "subvillage",
                    "type" => "text",
                    "placeholder" => lang('Form.subvillage'),
                    "class" => "form-control custom-readonly clearable",
                    "name" => "subvillage",
                    "value" => $model->get_M_Subvillage()->Name,
                    "readonly" => "",
                    "required" => ""
                  )
                )
                ?>
                <!-- <span class="form-control-feedback text-primary">
                        <i class="material-icons">search</i>
                    </span> -->
                <div class="input-group-append">
                  <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalSubvillage"><i class="fa fa-search"></i></button>
                </div>
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
              <?= formLink(
                lang('Form.cancel'),
                array(
                  "href" => baseUrl('mwarehouse'),
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

<?= view('m_subvillage/modal'); ?>
<script>
  $(document).ready(function() {
    init();
  });

  function init() {

  }
</script>