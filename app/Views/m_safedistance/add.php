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
      <h1 class="h3 display"><?= lang('Form.mastersafedistance') ?> </h1>
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
                <!-- <a href="<?= baseUrl('msafedistance') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= formOpen(baseUrl('msafedistance/addsave')) ?>
            <div class="form-group">
              <div class="required">
                <?= formLabel(lang('Form.safedistance')) ?>
                <?= formInput(
                  array(
                    "id" => "Distance",
                    "type" => "text",
                    "placeholder" => lang('Form.safedistance'),
                    "class" => "form-control",
                    "name" => "Distance",
                    "value" => $model->Distance,
                    "required" => ""
                  )
                ) ?>
              </div>
            </div>
            <div class="form-group">
              <div class="required">
                <?= formLabel(lang('Form.level')) ?>
                <?= formInput(
                  array(
                    "id" => "StatusLevel",
                    "type" => "text",
                    "placeholder" => lang('Form.level'),
                    "class" => "form-control",
                    "name" => "StatusLevel",
                    "value" => $model->StatusLevel,
                    "required" => ""
                  )
                ) ?>
              </div>
            </div>
            <div class="form-group">
              <div class="required">
                <?= formLabel(lang('Form.recommend')) ?>
                <?= formTextArea($model->Recommend, array(
                  "id" => "Recommend",
                  "placeholder" => lang('Form.recommend'),
                  "type" => "text",
                  "class" => "form-control",
                  "name" => "Recommend",
                  "required" => ""
                )) ?>
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
                  "href" => baseUrl('msafedistance'),
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

<script>
  $(document).ready(function() {
    init();
  });

  function init() {

  }
</script>