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
            <h1 class="h3 display"><?= lang('Form.masterequipmentowner') . " " . ("( {$equipment->Name} )") ?> </h1>
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
                                <!-- <a href="<?= baseUrl('mequipmentowner') ?>"><i class = "fa fa-table"></i> Data</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?= formOpen(baseUrl('mequipmentowner/editsave')) ?>
                        <?= formInput(
                            array(
                                "id" => "M_Equipment_Id",
                                "name" => "M_Equipment_Id",
                                "value" => $equipment->Id,
                                "hidden" => ""
                            )
                        ) .

                            formInput(
                                array(
                                    "id" => "Id",
                                    "name" => "Id",
                                    "value" => $model->Id,
                                    "hidden" => ""
                                )
                            )
                        ?>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.owner')) ?>
                                        <?= formInput(
                                            array(
                                                "id" => "OwnerName",
                                                "type" => "text",
                                                "placeholder" => lang('Form.owner'),
                                                "class" => "form-control",
                                                "name" => "OwnerName",
                                                "value" => $model->OwnerName,
                                                "required" => ""
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.subvillage'), array("for" => "subvillage")) ?>
                                        <div class="input-group has-success">
                                            <?= formInput(
                                                array(
                                                    "id" => "M_Subvillage_Id",
                                                    "hidden" => "",
                                                    "type" => "text",
                                                    "value" => $model->M_Subvillage_Id,
                                                    "name" => "M_Subvillage_Id"
                                                )
                                            )
                                            ?>
                                            <?= formInput(
                                                array(
                                                    "id" => "subvillage",
                                                    "type" => "text",
                                                    "placeholder" => lang('Form.subvillage'),
                                                    "class" => "form-control clearable",
                                                    "name" => "subvillage",
                                                    "value" => $model->get_M_Subvillage()->Name,
                                                    "required" => "",
                                                    "readonly" => ""
                                                )
                                            ) ?>
                                            <div class="input-group-append">
                                                <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalSubvillage"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <?= formLabel(lang("Form.latitude")) ?>
                                    <?= formInput(
                                        array(
                                            "id" => "Latitude",
                                            "type" => "text",
                                            "placeholder" => lang("Form.latitude"),
                                            "class" => "form-control",
                                            "name" => "Latitude",
                                            "value" => $model->Latitude
                                        )
                                    ) ?>
                                    <small class="form-text"><a href="#" onclick="showModalMap('#Latitude', '#Longitude')">Pilih dari map</a></small>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <?= formLabel(lang("Form.longitude")) ?>
                                    <?= formInput(
                                        array(
                                            "id" => "Longitude",
                                            "type" => "text",
                                            "placeholder" => lang("Form.longitude"),
                                            "class" => "form-control",
                                            "name" => "Longitude",
                                            "value" => $model->Longitude
                                        )
                                    ) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.damagedqty')) ?>
                                        <?= formInput(
                                            array(
                                                "id" => "DamagedQty",
                                                "type" => "number",
                                                "placeholder" => lang('Form.damagedqty'),
                                                "class" => "form-control",
                                                "name" => "DamagedQty",
                                                "value" => $model->DamagedQty,
                                                "required" => ""
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.goodqty')) ?>
                                        <?= formInput(
                                            array(
                                                "id" => "GoodQty",
                                                "type" => "number",
                                                "placeholder" => lang('Form.goodqty'),
                                                "class" => "form-control",
                                                "name" => "GoodQty",
                                                "value" => $model->GoodQty,
                                                "required" => ""
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.telephone')) ?>
                                        <?= formInput(
                                            array(
                                                "id" => "Phone",
                                                "type" => "text",
                                                "placeholder" => lang('Form.telephone'),
                                                "class" => "form-control",
                                                "name" => "Phone",
                                                "value" => $model->Phone,
                                                "required" => ""
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <?= formLabel(lang('Form.address')) ?>
                                    <?= formTextArea($model->Address, array(
                                        "id" => "Address",
                                        "placeholder" => lang('Form.address'),
                                        "type" => "text",
                                        "class" => "form-control",
                                        "name" => "Address"
                                    )) ?>
                                </div>
                            </div>
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
                                        "href" => baseUrl("mequipmentowner/$equipment->Id"),
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
    <?= view("m_subvillage/modal") ?>
    <?= view("modal/choosemap") ?>