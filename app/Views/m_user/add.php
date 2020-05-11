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
      <h1 class="h3 display"><?= lang('Form.master_user') ?> </h1>
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
                <!-- <a href="<?= baseUrl('muser') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <form method="post" action="<?= baseUrl('muser/addsave'); ?>">
              <?= formInput(
                array(
                  "id" => "M_Groupuser_Id",
                  "name" => "M_Groupuser_Id",
                  "value" => $model->M_Groupuser_Id,
                  "hidden" => ""
                )
              ) ?>
              <div class="form-group bmd-form-group">
                <div class="required">
                  <label class=""><?= lang('Form.name') ?></label>
                  <?= formInput(
                    array(
                      "id" => "Username",
                      "type" => "text",
                      "placeholder" => lang('Form.name'),
                      "class" => "form-control",
                      "name" => "Username",
                      "value" => $model->Username,
                      "required" => ""
                    )
                  ) ?>
                </div>
              </div>
              <div class="form-group">
                <div class="required">
                  <label><?= lang('Form.group_user') ?></label>
                  <div class="input-group has-success">

                    <?= formInput(
                    array(
                      "id" => "groupname",
                      "type" => "text",
                      "placeholder" => lang('Form.group_user'),
                      "class" => "form-control custom-readonly clearable",
                      "name" => "groupname",
                      "value" => $model->get_M_Groupuser()->GroupName,
                      "readonly" => ""
                    )
                  )
                  ?>
                    <!-- <span class="form-control-feedback text-primary">
                        <i class="material-icons">search</i>
                    </span> -->
                    <div class="input-group-append">
                      <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalGroupUser"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="required">
                  <label><?= lang('Form.password') ?></label>
                  <?= formInput(
                    array(
                      "id" => "Password",
                      "type" => "text",
                      "placeholder" => lang('Form.password'),
                      "class" => "form-control",
                      "name" => "Password",
                      "value" => $model->Password,
                      "required" => ""
                    )
                  ) ?>

                </div>
              </div>
              <div class="form-group">
                <input type="submit" value="<?= lang('Form.save') ?>" class="btn btn-primary">
                <a href="<?= baseUrl('muser') ?>" value="<?= lang('Form.cancel') ?>" class="btn btn-primary"><?= lang('Form.cancel') ?></a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<?= view('m_groupuser/modal'); ?>

<script type="text/javascript">
  $(document).ready(function() {
    init();
  });

  function init() {

  }
</script>