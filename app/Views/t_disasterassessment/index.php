<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Master</li>
    </ul>
  </div>
</div>
<section>
  <div class="container-fluid">
    <!-- Page Header-->
    <header>
      <h1 class="h3 display"><?= lang('Form.disasterassessment') ?> </h1>
      </tr>
    </header>
    <div class="row">

      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-6">
                <h4><?= lang('Form.data') ?></h4>
              </div>
              <div class="col-6 text-right">
                <a href="<?= baseUrl('tdisasterassessment/add') ?>"><i class="fa fa-plus"></i> <?= lang('Form.add') ?></a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="tableGroupUser" style="width: 100%;" class="table table-striped table-no-bordered table-hover dataTable dtr-inline collapsed " role="grid">
                <thead class=" text-primary">
                  <tr role="row">
                    <th># </th>
                    <th><?= lang('Form.number') ?></th>
                    <th><?= lang('Form.reportername') ?></th>
                    <th><?= lang('Form.telephone') ?></th>
                    <th><?= lang('Form.subvillage') ?></th>
                    <th><?= lang('Form.disaster') ?></th>
                    <th><?= lang('Form.date') ?></th>
                    <th class="disabled-sorting text-right"><?= lang('Form.actions') ?></th>
                  </tr>
                </thead>
                <tfoot class=" text-primary">
                  <tr role="row">
                    <th># </th>
                    <th><?= lang('Form.number') ?></th>
                    <th><?= lang('Form.reportername') ?></th>
                    <th><?= lang('Form.telephone') ?></th>
                    <th><?= lang('Form.subvillage') ?></th>
                    <th><?= lang('Form.disaster') ?></th>
                    <th><?= lang('Form.date') ?></th>
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
</section>
<?= view("modal/image") ?>
<?= view("modal/video") ?>
<?= view("modal/map") ?>

<script>
  $(document).ready(function() {

    init();
    dataTable();
  });

  function dataTable() {
    var table = $('#tableGroupUser').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [
        [5, 10, 15, 20, -1],
        [5, 10, 15, 20, "All"]
      ],
      "order": [
        [7, "desc"]
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
          "targets": [7]
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
          responsivePriority: 8
        },
        {
          responsivePriority: 2
        }
      ],
      "processing": true,
      "serverSide": true,
      ajax: {
        url: "<?= baseUrl('tdisasterassessment/getAllData') ?>",
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
            url: "<?= baseUrl('tdisasterassessment/delete/'); ?>",
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

    table.on('click', '.picture', function(e) {
      $tr = $(this).closest('tr');
      var data = table.row($tr).data();
      $.ajax({
        type: "POST",
        url: "<?= baseUrl('tdisasterassessment/getDataById'); ?>",
        data: {
          id: data[0]
        },
        success: function(data) {
          var model = $.parseJSON(data);
          var dom = document.getElementById('modalImg');
          dom.src = model.model.PhotoUrl;
          var label = document.getElementById("imagesModalLabel");
          label.innerHTML = model.model.TransNo;

        }
      });
      showModalImage();
    });


    table.on('click', '.video', function(e) {
      $tr = $(this).closest('tr');
      var data = table.row($tr).data();
      $.ajax({
        type: "POST",
        url: "<?= baseUrl('tdisasterassessment/getDataById'); ?>",
        data: {
          id: data[0]
        },
        success: function(data) {
        var model = $.parseJSON(data);
        var label = document.getElementById("videosModalLabel");
        label.innerHTML = model.model.TransNo;
        setModalVideoUrl(model, true);
        }
      });
      showModalVideo();
    });

    table.on('click', '.maps', function(e) {
      $tr = $(this).closest('tr');
      var data = table.row($tr).data();
      $.ajax({
        type: "POST",
        url: "<?= baseUrl('tdisasterassessment/getDataById'); ?>",
        data: {
          id: data[0]
        },
        success: function(data) {
        var model = $.parseJSON(data);
        var label = document.getElementById("mapModalLabel");
        label.innerHTML = model.model.TransNo;
        loadMap(model.model.Latitude, model.model.Longitude, model.model.Disaster.Icon);
        }
      });
      showModalMap();
    });

  }


  function init() {

  }
</script>