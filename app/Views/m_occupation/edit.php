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
          <h1 class="h3 display"><?= lang('Form.masteroccupation')?> </h1>
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
                <!-- <a href="<?= baseUrl('moccupation')?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">                
            <?= formOpen(baseUrl('moccupation/editsave'))?>
                <?= formInput(
                    array("id" => "Id",
                          "name" => "Id",
                          "value" => $model->Id,
                          "hidden" => ""
                    )
                )?>
              <div class="form-group">
                <div class = "required">
                  <?= formLabel(lang('Form.occupation'))?>
                  <?= formInput(
                        array("id" => "Name",
                              "type" => "text",
                              "placeholder" => lang('Form.occupation'),
                              "class" => "form-control",
                              "name" => "Name",
                              "value" => $model->Name,
                              "required" => ""
                        )
                  )?>
                </div>
              </div>
              <div class="form-group">       
                <?= formLabel(lang('Form.description'))?>
                <?= formTextArea($model->Description, array(
                      "id" => "Description",
                      "placeholder" => lang('Form.description'),
                      "type" => "text",
                      "class" => "form-control",
                      "name" => "Description"
                ))?>
              </div>
              <div class="form-group">       
                <?= formInput(
                      array("type" => "submit",
                            "class" => "btn btn-primary",
                            "value" => lang('Form.save'),
                      )
                )?>
                <?= formLink( lang('Form.cancel'), array(
                  "href" => baseUrl('moccupation'),
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