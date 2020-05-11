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
            <h1 class="h3 display"><?= lang('Form.masterfamilycardlivestock') . " " . ("( {$familycard->FamilyCardNo} )") ?> </h1>
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
                                <!-- <a href="<?= baseUrl('mfamilycardlivestock') ?>"><i class = "fa fa-table"></i> Data</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?= formOpen(baseUrl('mfamilycardlivestock/addsave')) ?>
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
                                    <?= formLabel(lang('Form.livestock'), array("for" => "livestock")) ?>
                                    <div class="input-group has-success">
                                        <?= formInput(
                                            array(
                                                "id" => "M_Livestock_Id",
                                                "hidden" => "",
                                                "type" => "text",
                                                "name" => "M_Livestock_Id",
                                                "value" => $model->M_Livestock_Id
                                            )
                                        )
                                        ?>
                                        <?= formInput(
                                            array(
                                                "id" => "livestock",
                                                "type" => "text",
                                                "placeholder" => lang('Form.livestock'),
                                                "class" => "form-control clearable",
                                                "name" => "livestock",
                                                "value" => $model->get_M_Livestock()->Name,
                                                "required" => "",
                                                "readonly" => ""
                                            )
                                        ) ?>
                                        <div class="input-group-append">
                                            <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalLivestock"><i class="fa fa-search"></i></button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="required">
                                        <?= formLabel(lang("Form.qty"), array("for" => "Qty")) ?>
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
                                        "href" => baseUrl("mfamilycardlivestock/{$familycard->Id}"),
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
    <?= view("m_livestock/modal") ?>

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