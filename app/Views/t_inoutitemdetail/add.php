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
            <h1 class="h3 display"><?= lang('Form.transactioninoutitemdetail') . " " ?><a href="<?= baseUrl("tinoutitem/edit/{$inoutitem->Id}") ?>"> <?=("( {$inoutitem->TransNo} )") ?> </a></h1>
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
                                <!-- <a href="<?= baseUrl('tinoutitemdetail') ?>"><i class = "fa fa-table"></i> Data</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?= formOpen(baseUrl('tinoutitemdetail/addsave')) ?>
                        <?= formInput(
                            array(
                                "id" => "T_Inoutitem_Id",
                                "name" => "T_Inoutitem_Id",
                                "value" => $inoutitem->Id,
                                "hidden" => ""
                            )
                        )
                        ?>
                        <div class="row">
                            <div class="col-md-6 col-12 col-sm-6">
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
                                                "required" => "",
                                                "readonly" => ""
                                            )
                                        ) ?>
                                        <div class="input-group-append">
                                            <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalWarehouse"><i class="fa fa-search"></i></button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.qty')) ?>
                                        <?= formInput(
                                            array(
                                                "id" => "Qty",
                                                "type" => "text",
                                                "placeholder" => lang('Form.qty'),
                                                "class" => "form-control money2",
                                                "name" => "Qty",
                                                "value" => $model->Qty,
                                                "required" => ""
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.recipient'), array("for" => "Recipient")) ?>
                                        <?= formInput(
                                            array(
                                                "id" => "Recipient",
                                                "type" => "text",
                                                "placeholder" => lang('Form.recipient'),
                                                "class" => "form-control",
                                                "name" => "Recipient",
                                                "value" => $model->Recipient,
                                                "required" => ""
                                            )
                                        ) ?>
                                    </div>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <?= formInput(
                                        array(
                                            "type" => "submit",
                                            "class" => "btn btn-primary",
                                            "value" => lang('Form.save'),
                                        )
                                    ) ?>
                                    <?= formLink(lang('Form.cancel'), array(
                                        "href" => baseUrl("tinoutitemdetail/{$inoutitem->Id}"),
                                        "value" => lang('Form.cancel'),
                                        "class" => "btn btn-primary",
                                    )) ?>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?= view("m_item/modal") ?>
    <?= view("m_warehouse/modal") ?>

    <script>
        $(document).ready(function() {
            initaddmember();
        });

        function initaddmember() {

            $('select#Gender option[value="<?= $model->Gender ?>"]').attr("selected", true);
            $('select#Religion option[value="<?= $model->Religion ?>"]').attr("selected", true);
            $('select#MarriageStatus option[value="<?= $model->MarriageStatus ?>"]').attr("selected", true);
            $('select#Relation option[value="<?= $model->Relation ?>"]').attr("selected", true);
            $('select#Citizenship option[value="<?= $model->Citizenship ?>"]').attr("selected", true);
            <?php
            if (!is_null($model->IsHeadFamily)) {
                ?>
                $('#IsHeadFamily').prop('checked', true);
            <?php
            }
            ?>

            <?php
            if (!is_null($model->IsDisable)) {
                ?>
                $('#IsDisable').prop('checked', true);
            <?php
            }
            ?>
            $('.selectpicker').selectpicker({
                style: 'btn-primary'
            });
        }
    </script>