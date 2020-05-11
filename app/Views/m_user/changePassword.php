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
          <h1 class="h3 display"><?= lang('ui_master_user')?> </h1>
      </tr>
    </header>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class = "row">
              <div class="col-6">
                <h4><?= lang('ui_data')?></h4>
              </div>
              <div class="col-6 text-right">
                <!-- <a href="<?= baseUrl('muser')?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">  
                 
            <?= formOpen(baseUrl('saveChangePassword'))?>
              <div class="form-group">
                <label><?= lang('ui_oldpassword')?></label>
                <input id="oldpassword" type="password" class="form-control" name = "oldpassword" value="<?= $model['oldpassword']?>" required>
              </div>
              <div class="form-group">
                <label><?= lang('ui_newpassword')?></label>
                <input id="newpassword" type="password" class="form-control" name = "newpassword" value="<?= $model['newpassword']?>" required>
              </div>
              <div class="form-group">
                <label><?= lang('ui_confirmpassword')?></label>
                <input id="confirmpassword" type="password" class="form-control" name = "confirmpassword" value="<?= $model['confirmpassword']?>" required>
              </div>
              <div class="form-group">       
                <input type="submit" value="<?= lang('ui_save')?>" class="btn btn-primary">
                <a href="<?= baseUrl()?>" value="Index" class="btn btn-primary"><?= lang('ui_home')?></a>
              </div>
            <?= formClose() ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script type = "text/javascript">
$(document).ready(function() {    
    //init();
  });
  
</script>