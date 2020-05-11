<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Master</li>
    </ul>
  </div>
</div>
<section>
  <div class="container-fluid">
    <!-- Page Header-->
    <header> 
          <h1 class="h3 display"><?= lang('Form.company')?> </h1>
      </tr>
    </header>
    <div class="row">

      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class = "row">
              <div class="col-6">
                <h4><?= lang('Form.data')?></h4>
              </div>
              <div class="col-6 text-right">
              </div>
            </div>
          </div>
          <div class="card-body">                
          <?= formOpen(baseUrl('mcompany/addsave')) ?>
              <input hidden id = "companyid" name = "Id" value = "<?= $model->Id ?>">
              <div class="form-group">
                <label><?= lang('Form.name')?></label>
                <input id="named" type="text"  class="form-control" name = "CompanyName" value="<?= $model->CompanyName?>" required>
              </div>
             
              <div class="form-group">       
                <label><?= lang('Form.address')?></label>
                <textarea id="address" type="text" class="form-control" name = "Address" ><?= $model->Address?></textarea>
              </div>
              <div class="form-group">
                <label><?= lang('Form.postcode')?></label>
                <input id="postcode" type="text"  class="form-control" name = "PostCode" value="<?= $model->PostCode?>">
              </div>
              <div class = "row">
                <div class="col-sm-4">
                  <div class="form-group">       
                    <label><?= lang('Form.email')?></label>
                    <input id="email" type="email" class="form-control" name = "Email" value = "<?= $model->Email?>" required>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">       
                    <label><?= lang('Form.telephone')?></label>
                    <input id="phone" type="text" class="form-control" name = "Phone" value = "<?= $model->Phone?>" required>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">       
                    <label><?= lang('Form.fax')?></label>
                    <input id="fax" type="text" class="form-control" name = "Fax" value = "<?= $model->Fax?>">
                  </div>
                </div>
              </div>
              
              <div class="form-group">       
                <input type="submit" value="<?= lang('Form.save')?>" class="btn btn-primary">
              </div>
            <?= formClose()?>
        </div>
      </div>
    </div>
  </div>
</section>