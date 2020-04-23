</div>
    <script src="<?= baseUrl('assets/js/popper.min.js'); ?>"></script>
    <script src="<?= baseUrl('assets/js/app.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/bootstrap-select.min.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/bootstrap-datepicker.min.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/moment.min.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/bootstrap-datetimepicker.min.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/bootstrap-datepicker.id.min.js'); ?>"></script>
    <!-- <script src="<?= baseUrl('assets/bootstrapdashboard/js/file/custom-file-input.js'); ?>"></script> -->
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/popper.js/umd/popper.min.js'); ?>"> </script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/js/grasp_mobile_progress_circle-1.0.0.min.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/jquery.cookie/jquery.cookie.js'); ?>"> </script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/chart.js/Chart.min.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/jquery-validation/jquery.validate.min.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/moment.min.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/bootstrap-notify.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/bootbox.min.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/jquery.mask.js'); ?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/jasny-bootstrap.min.js'); ?>"></script>
    <!-- Main File-->
    <script src="<?= baseUrl('assets/bootstrapdashboard/js/front.js'); ?>"></script>
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
    // <?php
  // if (Core\Session::isFlashExist('success_msg')) {
  //   $msg = Core\Session::getFlash('success_msg');
  //   for ($i = 0; $i < count($msg); $i++) {
  //     ?>
  //     setNotification("<?= $msg[$i]; ?>", 2, "bottom", "right");
  // <?php
  //   }
  // }

  // ?>
  // <?php
  // if (Core\Session::isFlashExist('add_warning_msg')) {
  //   $msg = Core\Session::getFlash('add_warning_msg');
  //   for ($i = 0; $i < count($msg); $i++) {
  //     ?>
  //     setNotification("<?= $msg[$i]; ?>", 3, "bottom", "right");
  //   <?php
  //     }
  //   }

  //   if (Core\Session::isFlashExist('edit_warning_msg')) {
  //     $msg = Core\Session::getFlash('edit_warning_msg');
  //     for ($i = 0; $i < count($msg); $i++) {
  //       ?>
  //     setNotification("<?= $msg[$i]; ?>", 3, "bottom", "right");
  // <?php
  //   }
  // }

  // ?>