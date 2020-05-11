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
            <h1 class="h3 display"><?= lang('Form.report') . " " . lang("Form.population") ?> </h1>
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
                        <?= formOpen(baseUrl('report/population/print'), array("target" => "_blank")) ?>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <?= formLabel(lang('Form.subvillage'), array("for" => "Subvillage")) ?>
                                    <div class="input-group has-success">
                                        <?= formInput(
                                            array(
                                                "id" => "M_Subvillage_Id",
                                                "hidden" => "",
                                                "type" => "text",
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
<?php $this->view("m_subvillage/modal") ?>
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