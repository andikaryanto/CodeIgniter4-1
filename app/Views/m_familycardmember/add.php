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
            <h1 class="h3 display"><?= lang('Form.masterfamilycardmember') . " " . ("( {$familycard->FamilyCardNo} )") ?> </h1>
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
                                <!-- <a href="<?= baseUrl('mfamilycardmember') ?>"><i class = "fa fa-table"></i> Data</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?= formOpen(baseUrl('mfamilycardmember/addsave')) ?>
                        <?= formInput(
                            array(
                                "id" => "M_Familycard_Id",
                                "name" => "M_Familycard_Id",
                                "value" => $familycard->Id,
                                "hidden" => ""
                            )
                        )
                        ?>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.name')) ?>
                                        <?= formInput(
                                            array(
                                                "id" => "CompleteName",
                                                "type" => "text",
                                                "placeholder" => lang('Form.name'),
                                                "class" => "form-control",
                                                "name" => "CompleteName",
                                                "value" => $model->CompleteName,
                                                "required" => ""
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel("NIK", array("for" => "NIK")) ?>
                                        <?= formInput(
                                            array(
                                                "id" => "NIK",
                                                "type" => "text",
                                                "placeholder" => lang('Form.name'),
                                                "class" => "form-control",
                                                "name" => "NIK",
                                                "value" => $model->NIK,
                                                "required" => ""
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.gender')) ?>
                                        <?php $detail = "App\Models\M_enumdetails" ?>
                                        <?= formSelect(
                                            $detail::getEnums("Gender"),
                                            "Value",
                                            "EnumName",
                                            array(
                                                "id" => "Gender",
                                                "class" => "selectpicker form-control",
                                                "name" => "Gender"
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.religion')) ?>
                                        <?php $detail = "App\Models\M_enumdetails" ?>
                                        <?= formSelect(
                                            $detail::getEnums("Religion"),
                                            "Value",
                                            "EnumName",
                                            array(
                                                "id" => "Religion",
                                                "class" => "selectpicker form-control",
                                                "name" => "Religion"
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.placeofbirth'), array("for" => "BirthPlace")) ?>
                                        <?= formInput(
                                            array(
                                                "id" => "BirthPlace",
                                                "type" => "text",
                                                "placeholder" => lang('Form.placeofbirth'),
                                                "class" => "form-control",
                                                "name" => "BirthPlace",
                                                "value" => $model->BirthPlace,
                                                "required" => ""
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.dateofbirth'), array("for" => "BirthDate")) ?>
                                        <?= formInput(
                                            array(
                                                "id" => "BirthDate",
                                                "type" => "text",
                                                "placeholder" => lang('Form.dateofbirth'),
                                                "class" => "datepicker form-control",
                                                "name" => "BirthDate",
                                                "value" => $model->BirthDate,
                                                "required" => "",
                                                "autocomplete" => "off"
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <?= formLabel(lang('Form.lasteducation')) ?>
                                    <?= formInput(
                                        array(
                                            "id" => "Education",
                                            "type" => "text",
                                            "placeholder" => lang('Form.lasteducation'),
                                            "class" => "form-control",
                                            "name" => "Education",
                                            "value" => $model->Education
                                        )
                                    ) ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <?= formLabel(lang('Form.job'), array("for" => "Job")) ?>
                                    <?= formInput(
                                        array(
                                            "id" => "Job",
                                            "type" => "text",
                                            "placeholder" => lang('Form.job'),
                                            "class" => "form-control",
                                            "name" => "Job",
                                            "value" => $model->Job
                                        )
                                    ) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.marriagestatus')) ?>
                                        <?php $detail = "App\Models\M_enumdetails" ?>
                                        <?= formSelect(
                                            $detail::getEnums("MarriageStatus"),
                                            "Value",
                                            "EnumName",
                                            array(
                                                "id" => "MarriageStatus",
                                                "class" => "selectpicker form-control",
                                                "name" => "MarriageStatus"
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.relation')) ?>
                                        <?php $detail = "App\Models\M_enumdetails" ?>
                                        <?= formSelect(
                                            $detail::getEnums("FamilyRelation"),
                                            "Value",
                                            "EnumName",
                                            array(
                                                "id" => "Relation",
                                                "class" => "selectpicker form-control",
                                                "name" => "Relation"
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang('Form.citizenship')) ?>
                                        <?php $detail = "App\Models\M_enumdetails" ?>
                                        <?= formSelect(
                                            $detail::getEnums("Citizenship"),
                                            "Value",
                                            "EnumName",
                                            array(
                                                "id" => "Citizenship",
                                                "class" => "selectpicker form-control",
                                                "name" => "Citizenship"
                                            )
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <?= formLabel(lang('Form.description'), array("for" => "Description")) ?>
                                    <?= formTextArea(
                                        $model->Description,
                                        array(
                                            "id" => "Description",
                                            "type" => "text",
                                            "placeholder" => lang('Form.description'),
                                            "class" => "form-control",
                                            "name" => "Description",
                                            "row" => "1"

                                        )
                                    ) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="i-checks">
                                        <?= formInput(
                                            array(
                                                "id" => "IsHeadFamily",
                                                "type" => "checkbox",
                                                "class" => "form-control-custom",
                                                "name" => "IsHeadFamily",
                                                "checked" => " "
                                            )
                                        ) ?>
                                        <?= formLabel(lang('Form.isheadfamily'), array("for" => "IsHeadFamily")) ?>
                                        <?= formInput(
                                            array(
                                                "id" => "IsDisable",
                                                "type" => "checkbox",
                                                "class" => "form-control-custom",
                                                "name" => "IsDisable"
                                            )
                                        ) ?>
                                        <?= formLabel(lang('Form.isdisable'), array("for" => "IsDisable")) ?>
                                    </div>
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
                                        "href" => baseUrl("mfamilycardmember/{$familycard->Id}"),
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
    <?= view("m_village/modal") ?>

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

            $('.selectpicker').selectpicker('refresh');
        }
    </script>