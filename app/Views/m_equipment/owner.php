<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4><?= lang('Form.owner') ?></h4>
                        </div>
                        <div class="col-6 text-right">
                            <!-- <a href="<?= baseUrl('mequipment') ?>"><i class = "fa fa-table"></i> Data</a> -->
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?= formOpen(baseUrl('mequipment/saveOwner')) ?>
                    <?= formInput(
                        array(
                            "id" => "idequipments",
                            "name" => "idequipments",
                            "value" => $model->Id,
                            "hidden" => ""
                        )
                    ) .

                        formInput(
                            array(
                                "id" => "id",
                                "name" => "id",
                                "value" => $equipmentownwer->Id,
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
                                            "id" => "ownername",
                                            "type" => "text",
                                            "placeholder" => lang('Form.owner'),
                                            "class" => "form-control",
                                            "name" => "ownername",
                                            "value" => $equipmentownwer->OwnerName,
                                            "required" => ""
                                        )
                                    ) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="required">
                                    <?= formLabel(lang('Form.village'), array("for" => "village")) ?>
                                    <div class="input-group has-success">
                                        <?= formInput(
                                            array(
                                                "id" => "villageid",
                                                "hidden" => "",
                                                "type" => "text",
                                                "value" => $equipmentownwer->M_Village_Id,
                                                "name" => "villageid"
                                            )
                                        )
                                        ?>
                                        <?= formInput(
                                            array(
                                                "id" => "village",
                                                "type" => "text",
                                                "placeholder" => lang('Form.village'),
                                                "class" => "form-control",
                                                "name" => "village",
                                                "value" => $equipmentownwer->get_M_Village()->Name,
                                                "required" => "",
                                                "disabled" => ""
                                            )
                                        ) ?>
                                        <div class="input-group-append">
                                            <button id="btnGroupModal" data-toggle="modal" type="button" class="btn btn-primary" data-target="#modalVillage"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
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
                                            "id" => "damagedqty",
                                            "type" => "number",
                                            "placeholder" => lang('Form.damagedqty'),
                                            "class" => "form-control",
                                            "name" => "damagedqty",
                                            "value" => $equipmentownwer->DamagedQty,
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
                                            "id" => "goodqty",
                                            "type" => "number",
                                            "placeholder" => lang('Form.goodqty'),
                                            "class" => "form-control",
                                            "name" => "goodqty",
                                            "value" => $equipmentownwer->GoodQty,
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
                                            "id" => "telephone",
                                            "type" => "text",
                                            "placeholder" => lang('Form.telephone'),
                                            "class" => "form-control",
                                            "name" => "telephone",
                                            "value" => $equipmentownwer->Phone,
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
                                <?= formTextArea($equipmentownwer->Address, array(
                                    "id" => "address",
                                    "placeholder" => lang('Form.address'),
                                    "type" => "text",
                                    "class" => "form-control",
                                    "name" => "address"
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
                                    "href" => baseUrl('mequipment'),
                                    "value" => lang('Form.cancel'),
                                    "class" => "btn btn-primary",
                                )) ?>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableOwner" style="width: 100%;" class="table table-striped table-no-bordered table-hover dataTable dtr-inline collapsed " role="grid">
                            <thead class=" text-primary">
                                <tr role="row">
                                    <th># </th>
                                    <th><?= lang('Form.owner') ?></th>
                                    <th><?= lang('Form.address') ?></th>
                                    <th><?= lang('Form.goodqty') ?></th>
                                    <th><?= lang('Form.damagedqty') ?></th>
                                    <th><?= lang('Form.telephone') ?></th>
                                    <th class="disabled-sorting text-right"><?= lang('Form.actions') ?></th>
                                </tr>
                            </thead>
                            <tfoot class=" text-primary">
                                <tr role="row">
                                    <th># </th>
                                    <th><?= lang('Form.owner') ?></th>
                                    <th><?= lang('Form.address') ?></th>
                                    <th><?= lang('Form.goodqty') ?></th>
                                    <th><?= lang('Form.damagedqty') ?></th>
                                    <th><?= lang('Form.telephone') ?></th>
                                    <th class="disabled-sorting text-right"><?= lang('Form.actions') ?></th>
                                </tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->view("m_village/modal") ?>

<script>
    $(document).ready(function() {

        dataTable();
    });

    function dataTable() {
        var table = $('#tableOwner').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"]
            ],
            "order": [
                [2, "desc"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                "search": "<?= lang('Form.search') ?>" + " : "
            },
            "columnDefs": [{
                    targets: 'disabled-sorting',
                    orderable: false
                },
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "className": "td-actions text-right",
                    "targets": [6]
                }
            ],
            columns: [{
                    responsivePriority: 1
                },
                {
                    responsivePriority: 3
                },
                {
                    responsivePriority: 4
                },
                {
                    responsivePriority: 5
                },
                {
                    responsivePriority: 6
                },
                {
                    responsivePriority: 7
                },
                {
                    responsivePriority: 2
                }
            ],
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "<?= baseUrl("mequipment/getOwner/{$model->Id}") ?>",
                dataSrc: 'data'
            },
            stateSave: true
        });

        // Delete a record
        table.on('click', '.delete', function(e) {
            $tr = $(this).closest('tr');
            var data = table.row($tr).data();
            var id = data[0] + "~a";
            var name = document.getElementById(id).innerHTML;
            console.log(name);
            deleteData(name, function(result) {
                if (result == true) {

                    $.ajax({
                        type: "POST",
                        url: "<?= baseUrl('mequipment/deleteOwner/'); ?>",
                        data: {
                            id: data[0]
                        },
                        success: function(data) {
                            console.log(data);
                            var status = $.parseJSON(data);
                            if (status['isforbidden']) {
                                window.location = "<?= baseUrl('Forbidden'); ?>";
                            } else {
                                if (!status['status']) {
                                    for (var i = 0; i < status['msg'].length; i++) {
                                        var message = status['msg'][i];
                                        setNotification(message, 3, "bottom", "right");
                                    }
                                } else {
                                    for (var i = 0; i < status['msg'].length; i++) {
                                        var message = status['msg'][i];
                                        setNotification(message, 2, "bottom", "right");
                                    }
                                    table.row($tr).remove().draw();
                                    e.preventDefault();
                                }
                            }
                        }
                    });
                }
            });
        });
        table.on('click', '.editowner', function(e) {

            $tr = $(this).closest('tr');
            var data = table.row($tr).data();
            var id = data[0];
            $.ajax({
                type: "POST",
                url: "<?= baseUrl("mequipment/editOwner") ?>",
                data: {
                    id: data[0]
                },
                success: function(data) {
                    
                }
            });
        })

    }
</script>