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
          <h1 class="h3 display"><?= lang('Form.master_groupuser')?> </h1>
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
                <a href="<?= baseUrl('mgroupuser')?>"><i class = "fa fa-table"></i> Data</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content tab-space">
                <div class = "tab-pane active show" id = "formrole">
                    <div class="table-responsive">
                        <table id = "tblRole" class="table table-striped table-hover">
                            <thead class ="text-primary">
                                <tr>
                                <th><?= lang('Form.module')?></th>
                                <th>Alias</th>
                                <th><?= lang('Form.read')?></th>
                                <th><?= lang('Form.write')?></th>
                                <th><?= lang('Form.delete')?></th>
                                <th><?= lang('Form.print')?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($model->view_m_accessrole() as $value)
                                    {
                                ?>
                                <tr>
                                    <td id = "td<?= $i ?>formid" hidden = "true"><?= $value->M_Form_Id?></td>
                                    <?php if($value->Header == 0) { ?>
                                        <td id = "td<?= $i ?>aliasname"><?= $value->AliasName?></td>
                                    <?php } else {?>
                                        <td><h5 style = "font-weight: 500;"><?= $value->AliasName?></h5></td>
                                    <?php }?>
                                    <td id = "td<?= $i ?>localname"><?= $value->LocalName?></td>
                                    <td id = "td<?= $i ?>tdread">
                                        <div class = "form-check">
                                            <label class="form-check-label">
                                                <?php if($value->Header ==0) { ?>
                                                    <input class = "form-check-input" id = "td<?= $i ?>read" type="checkbox" value = "td~<?= $i ?>~read" <?php if($value->Readd == 1)
                                                                            {
                                                                        ?>
                                                                            checked=""
                                                                        <?php
                                                                            }
                                                                        ?>>
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                <?php } ?>
                                            </label>
                                        </div>
                                    </td>
                                    <td id = "td<?= $i ?>tdwrite">
                                        <div class = "form-check">
                                            <label class="form-check-label">
                                                <?php if($value->Header ==0) { ?>
                                                    <input class = "form-check-input" id = "td<?= $i ?>write" type="checkbox" value = "td~<?= $i ?>~write"<?php if($value->Writee == 1)
                                                                            {
                                                                        ?>
                                                                            checked=""
                                                                        <?php
                                                                            }
                                                                        ?>>
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                <?php } ?>
                                            </label>
                                        </div>
                                    </td>
                                    <td id = "td<?= $i ?>tddelete">                                  
                                        <div class = "form-check">
                                            <label class="form-check-label">
                                                <?php if($value->Header ==0) { ?>
                                                    <input class = "form-check-input" id = "td<?= $i ?>delete" type="checkbox" value = "td~<?= $i ?>~delete" <?php if($value->Deletee == 1)
                                                                            {
                                                                        ?>
                                                                            checked=""
                                                                        <?php
                                                                            }
                                                                        ?>>
                                                    
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                <?php } ?>
                                            </label>
                                        </div>
                                    </td>
                                    <td id = "td<?= $i ?>tdprint">                                 
                                        <div class = "form-check">
                                            <label class="form-check-label">
                                                <?php if($value->Header ==0) { ?>
                                                    <input class = "form-check-input" id ="td<?= $i ?>print" type="checkbox" value = "td~<?= $i ?>~print"<?php if($value->Printt == 1)
                                                                            {
                                                                        ?>
                                                                            checked=""
                                                                        <?php
                                                                            }
                                                                        ?>>
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                <?php } ?>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    
                                    $i++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<script>
    $("#searchbutton").on("click",function() {
        var search = $("#search").val();
        //window.location =" <?= baseUrl('m_groupuser');?>?search="+search;
    });

    $("#btnSave").on("click",function() {
        var oTable = document.getElementById('tblRole');
        var i;
        var rowLength = oTable.rows.length;
        for (i = 1; i < rowLength; i++) {
        $.ajax({
            type:"POST",
            url:"<?= baseUrl('M_groupuser/saverole')?>",
            data:{
                groupid: <?= $model->Id?>,
                formid : document.getElementById("td"+i+"formid").innerHTML,
                read : $("#td"+i+"read").is(":checked") == true ? 1 : 0,
                write : $("#td"+i+"write").is(":checked") == true ? 1 : 0,
                delete : $("#td"+i+"delete").is(":checked") == true ? 1 : 0,
                print : $("#td"+i+"print").is(":checked") == true ? 1 : 0
                },
            success:function(data){
            }
        });
        
        }
    });

    $(":checkbox").on("change", function(e) {
        
        var numbid = this.value.split("~")[1];
        var formid = document.getElementById("td"+numbid+"formid").innerHTML;
        // console.log(numbid);
        $.ajax({
            type:"POST",
            url:"<?= baseUrl('mgroupuser/saverole')?>",
            data:{
                groupid: <?= $model->Id?>,
                formid : formid,
                read : $("#td"+numbid+"read").is(":checked") == true ? 1 : 0,
                write : $("#td"+numbid+"write").is(":checked") == true ? 1 : 0,
                delete : $("#td"+numbid+"delete").is(":checked") == true ? 1 : 0,
                print : $("#td"+numbid+"print").is(":checked") == true ? 1 : 0
                },
            success:function(data){
                console.log(data);
            }
        });
    });
</script>
      