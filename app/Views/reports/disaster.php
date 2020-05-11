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
            <h1 class="h3 display"><?= lang('Form.report') . " " . lang("Form.disaster") ?> </h1>
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
                                <!-- <a href="<?= baseUrl('mvolunteer') ?>"><i class = "fa fa-table"></i> Data</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?= formOpen(baseUrl('report/disaster/print')) ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.type')) ?>
                                        <?php $detail = "App\Models\M_enumdetails" ?>
                                        <?= formSelect(
                                            $detail::getEnums("ReportType"),
                                            "Value",
                                            "EnumName",
                                            array(
                                                "id" => "Type",
                                                "class" => "selectpicker form-control",
                                                "name" => "Type"
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12 col-sm-6">
                                <div class="form-group">
                                    <?= formLabel(lang('Form.disaster')) ?>
                                    <?php $detail = "App\Models\M_disasters" ?>
                                    <?= formSelect(
                                        $detail::getAll(),
                                        "Id",
                                        "Name",
                                        array(
                                            "id" => "Disaster",
                                            "class" => "selectpicker form-control",
                                            "name" => "Disaster[]",
                                            "multiple" => "",
                                        )
                                    ) ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 col-sm-6">
                                <div class="form-group">
                                    <?= formLabel(lang('Form.status')) ?>
                                    <?php $detail = "App\Models\M_enumdetails" ?>
                                    <?= formSelect(
                                        $detail::getEnums("DisasterOccurStatus"),
                                        "Value",
                                        "EnumName",
                                        array(
                                            "id" => "Status",
                                            "class" => "selectpicker form-control",
                                            "name" => "Status[]",
                                            "multiple" => "",
                                        )
                                    ) ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <?= formLabel(lang('Form.village'), array("for" => "Village")) ?>
                                    <div class="input-group has-success">
                                        <?= formInput(
                                            array(
                                                "id" => "M_Village_Id",
                                                "hidden" => "",
                                                "type" => "text",
                                                "name" => "M_Village_Id"
                                            )
                                        )
                                        ?>
                                        <?= formInput(
                                            array(
                                                "id" => "village",
                                                "type" => "text",
                                                "placeholder" => lang('Form.village'),
                                                "class" => "form-control clearable",
                                                "name" => "village",
                                                "readonly" => ""
                                            )
                                        ) ?>
                                        <div class="input-group-append">
                                            <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalVillage"><i class="fa fa-search"></i></button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.datefrom')) ?>
                                        <?= formInput(
                                            array(
                                                "id" => "DateFrom",
                                                "type" => "text",
                                                "placeholder" => lang('Form.datefrom'),
                                                "class" => "datepicker form-control",
                                                "autocomplete" => "off",
                                                "name" => "DateFrom",
                                                "required" => ""
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.dateto')) ?>
                                        <?= formInput(
                                            array(
                                                "id" => "DateTo",
                                                "type" => "text",
                                                "placeholder" => lang('Form.dateto'),
                                                "class" => "datepicker form-control",
                                                "autocomplete" => "off",
                                                "name" => "DateTo",
                                                "required" => ""
                                            )
                                        ) ?>
                                    </div>
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
                                    "href" => baseUrl('mvolunteer'),
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
<?php $this->view("m_disaster/modal") ?>
<?php $this->view("m_village/modal") ?>
<script>
    $(document).ready(function() {
        initaddvolunteer();
    });

    function initaddvolunteer() {
        // $('select#Gender option[value="<?= $model->Gender ?>"]').attr("selected", true);

        $('.selectpicker').selectpicker({
            style: 'btn-primary'
        });
    }
</script>