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
      <h1 class="h3 display">

<?= lang('Form.masterinfrastructure') ?> </h1>
      </tr>
    </header>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-6">
                <h4><?= lang('Form.map') ?></h4>
              </div>
              <div class="col-6 text-right">
                <!-- <a href="<?= baseUrl('minfrastructure') ?>"><i class = "fa fa-table"></i> Data</a> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <div style="width: 100%; height: 400px;" id='map'></div>
          </div>
          <div class="card-body">
            <?= formOpen(baseUrl('minfrastructure'), array(), "GET") ?>
            <div class="row">
              <div class="col-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <?= formLabel(lang("Form.infrastructurecategory")) ?>
                  <?= formSelect(
                    App\Eloquents\M_infrastructurecategories::findAll(),
                    "Id",
                    "Name",
                    array(
                      "id" => "Category",
                      "class" => "selectpicker form-control",
                      "name" => "Category[]",
                      "multiple" => "",
                      "value" => $input["Category"]
                    )
                  ) ?>
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
                  "href" => baseUrl('mvillage'),
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
  <div class="container-fluid">
    <!-- Page Header-->

    <div class="row">

      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-6">
                <h4><?= lang('Form.data') ?></h4>
              </div>
              <div class="col-6 text-right">
                <a class="link-action" href="<?= baseUrl('minfrastructure/map') ?>"><i class="fa fa-map"></i> <?= lang('Form.map') ?></a>
                <a href="<?= baseUrl('minfrastructure/add') ?>"><i class="fa fa-plus"></i> <?= lang('Form.add') ?></a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="tableGroupUser" style="width: 100%;" class="table table-striped table-no-bordered table-hover dataTable dtr-inline collapsed " role="grid">
                <thead class=" text-primary">
                  <tr role="row">
                    <th># </th>
                    <th><?= lang('Form.name') ?></th>
                    <th><?= lang('Form.address') ?></th>
                    <th><?= lang('Form.personincharge') ?></th>
                    <th><?= lang('Form.telephone') ?></th>
                    <th><?= lang('Form.capacity') ?></th>
                    <th><?= lang('Form.infrastructurecategory') ?></th>
                    <th><?= lang('Form.isactive') ?></th>
                    <th class="disabled-sorting text-right"><?= lang('Form.actions') ?></th>
                  </tr>
                </thead>
                <tfoot class=" text-primary">
                  <tr role="row">
                    <th># </th>
                    <th><?= lang('Form.name') ?></th>
                    <th><?= lang('Form.address') ?></th>
                    <th><?= lang('Form.personincharge') ?></th>
                    <th><?= lang('Form.telephone') ?></th>
                    <th><?= lang('Form.capacity') ?></th>
                    <th><?= lang('Form.infrastructurecategory') ?></th>
                    <th><?= lang('Form.isactive') ?></th>
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

<!-- modal -->
<div id="modalBarrack" tabindex="-1" role="dialog" aria-labelledby="infrastructureModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="infrastructureModalLabel" class="modal-title"><?= lang('Form.picture') ?></h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="card-body">
        <div class="toolbar">
          <!--        Here you can write extra buttons/actions for the toolbar
                                  -->
          <img id="infraImage" src="https://picsum.photos/300/200?image=1061" alt="Image 1061" class="img-fluid" height="100%" width="100%">
        </div>

      </div>
    </div>
  </div>
</div>

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
          "targets": [8]
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
          responsivePriority: 9
        },
        {
          responsivePriority: 2
        }
      ],
      "processing": true,
      "serverSide": true,
      ajax: {
        url: "<?= baseUrl('minfrastructure/getAllData') ?>",
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
            url: "<?= baseUrl('minfrastructure/delete/'); ?>",
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

    table.on('click', '.image', function(e) {
      $tr = $(this).closest('tr');
      var data = table.row($tr).data();
      var id = data[0];
      console.log(id);
      $.ajax({
        type: "POST",
        url: "<?= baseUrl('minfrastructure/getData'); ?>",
        data: {
          id: data[0]
        },
        success: function(data) {
          var model = $.parseJSON(data);
          var dom = document.getElementById('infraImage');
          dom.src = "<?= baseUrl() ?>" + model.PhotoUrl;

          var label = document.getElementById("infrastructureModalLabel");
          label.innerHTML = model.Name;

        }
      });
    });

  }

  function init() {

  }
</script>

<script>
  initmap();
  mapboxgl.accessToken = 'pk.eyJ1IjoiYW5kaWthcnlhbnRvbyIsImEiOiJjanlueGJlb2owdzM0M2RtdG9nN3Y5Mm5kIn0.Ancb01gHGbYcwsDea33KaA';

  var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [110.3515128, -7.7951198],
    zoom: 10
  });

  var marker = new mapboxgl.Marker();
  var geojson = new Array({
    "type": "FeatureCollection"
  });

  var i = 0;
  var feature = new Array();
  <?php foreach ($model as $data) {
    ?>
  var loc = {
    "type": "Feature",
    "properties": {
      "message": "Foo",
      "iconSize": [50, 50],
      "address": "<?= $data->get_M_Subvillage()->get_M_Village()->Name . ", " . $data->get_M_Subvillage()->get_M_Village()->get_M_Subdistrict()->Name . ", " . $data->get_M_Subvillage()->get_M_Village()->get_M_Subdistrict()->get_M_District()->Name ?>",
      "province": "<?= $data->get_M_Subvillage()->get_M_Village()->get_M_Subdistrict()->get_M_District()->get_M_Province()->Name ?>",
      "markerUrl": "<?= baseUrl($data->get_M_Infrastructurecategory()->Icon) ?>",
      "model": <?= json_encode($data) ?>
    },
    "geometry": {
      "type": "Point",
      "coordinates": [
        <?= $data->Longitude ?>,
        <?= $data->Latitude ?>
      ]
    }
  };
  feature.push(loc);
  i++;
  <?php
  }

  ?>
  console.log(geojson);
  //pop properties
  var markerHeight = 50,
    markerRadius = 10,
    linearOffset = 25;
  var popupOffsets = {
    'top': [, 0],
    'top-left': [0, 0],
    'top-right': [0, 0],
    'bottom': [0, -markerHeight],
    'bottom-left': [linearOffset, (markerHeight - markerRadius + linearOffset) * -1],
    'bottom-right': [-linearOffset, (markerHeight - markerRadius + linearOffset) * -1],
    'left': [markerRadius, (markerHeight - markerRadius) * -1],
    'right': [-markerRadius, (markerHeight - markerRadius) * -1]
  };
  //end 

  geojson.features = feature;
  geojson.features.forEach(function(e) {
    // create a DOM element for the e
    var html = "";
    var el = document.createElement('div');
    el.className = 'marker';
    el.style.backgroundImage = 'url(' + e.properties.markerUrl + ')';
    el.style.width = e.properties.iconSize[0] + 'px';
    el.style.height = e.properties.iconSize[1] + 'px';
    //add pop up
    html = "</div><h4><a href='<?= baseUrl("tdisasteroccur") ?>'>" + e.properties.model.Name + "</a></h4></h4>";
    html = html + "<div><?= lang('Form.address') ?> : " + e.properties.address + "</div>"
    html = html + "<div><?= lang('Form.province') ?> : " + e.properties.province + "</div>"
    html = html + "<div><?= lang('Form.telephone') ?> : " + e.properties.model.Phone + "</div>"
    html = html + "<div><?= lang('Form.capacity') ?> : " + e.properties.model.Capacity + "</div>"
    html = html + "<div>Latitude : " + e.properties.model.Latitude + "</div>"
    html = html + "<div>Longitude : " + e.properties.model.Longitude + "</div>"
    var popup = new mapboxgl.Popup({
        offset: popupOffsets
      })
      .setHTML(html);

    // add marker to map
    new mapboxgl.Marker(el)
      .setLngLat(e.geometry.coordinates)
      .setPopup(popup)
      .addTo(map);

    // var popup = new mapboxgl.Popup({
    //         offset: popupOffsets
    //     })
    //     .setLngLat(e.geometry.coordinates)
    //     .setHTML("<h1>Hello World!</h1>")
    //     .setMaxWidth("300px")
    //     .addTo(map);
  });

  function initmap() {
    var element = document.getElementById('Category');

    // Set Values
    <?php if ($input["Category"]) { ?>
    var values = "<?= $input["Category"] ?>";
    for (var i = 0; i < element.options.length; i++) {
      element.options[i].selected = values.indexOf(element.options[i].value) >= 0;
    }
    <?php } ?>

  }
</script>