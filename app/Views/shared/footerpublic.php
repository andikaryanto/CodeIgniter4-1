</div>
    <script src="<?= base_url('assets/js/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/app.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/bootstrap-select.min.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/bootstrap-datepicker.min.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/moment.min.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/bootstrap-datetimepicker.min.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/bootstrap-datepicker.id.min.js'); ?>"></script>
    <!-- <script src="<?= base_url('assets/bootstrapdashboard/js/file/custom-file-input.js'); ?>"></script> -->
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/popper.js/umd/popper.min.js'); ?>"> </script>
    <script src="<?= base_url('assets/bootstrapdashboard/js/grasp_mobile_progress_circle-1.0.0.min.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/jquery.cookie/jquery.cookie.js'); ?>"> </script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/chart.js/Chart.min.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/jquery-validation/jquery.validate.min.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/moment.min.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/bootstrap-notify.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/bootbox.min.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/jquery.mask.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/jasny-bootstrap.min.js'); ?>"></script>
    <!-- Main File-->
    <script src="<?= base_url('assets/bootstrapdashboard/js/front.js'); ?>"></script>
    <script>
        $('.datetimepicker').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: 'fa fa-angle-double-left',
                next: 'fa fa-angle-double-right',
            },
            format: 'DD-MM-YYYY HH:mm'
        });

        $('.datepicker').datepicker({
            language: 'id',
            format: "dd-M-yyyy"
        });

        // $(function () {
        //   $('[data-toggle="popover"]').popover()
        // });

        $('.popover-dismiss').popover({
            trigger: 'focus'
        })


        $('.yearperiod').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
    </script>
    