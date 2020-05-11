      <!-- Counts Section -->

      <section class="dashboard-counts section-padding">
        <div class="container-fluid">
          <!-- <header>
            <h1 class="h3 display">Data Bencana Tahun Ini </h1>
            </tr>
          </header> -->
          <div class="row">
            <!-- Count item widget-->

            <?php foreach ($datacurrentyear as $datayear) : ?>
              <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                  <div class="icon"><i class="icon-padnote"></i></div>
                  <div class="name"><strong class="text-uppercase"><?= $datayear->Name?></strong>
                  <span>Tahun <?= get_formated_date(null, "Y")?></span>
                    <div class="count-number"><?= $datayear->Jumlah?></div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
      <!-- Header Section-->
      <section>
        <div class="container-fluid">
          <!-- Page Header-->
          <header>
            <h1 class="h3 display"><?= lang('Form.disasterreport') ?> </h1>
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
                      <!-- <a href="<?= baseUrl('tdisasteroccur') ?>"><i class = "fa fa-table"></i> Data</a> -->
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div style="width: 100%; height: 400px;" id='map'></div>
                </div>
                <div class="card-body">
                  <?= formOpen(baseUrl('home'), array(), "GET") ?>
                  <div class="row">
                    <div class="col-12 col-md-6 col-sm-6">
                      <div class="form-group">
                        <?= formLabel(lang("Form.disaster")) ?>
                        <?= formSelect(
                          $disaster,
                          "Id",
                          "Name",
                          array(
                            "id" => "Disaster",
                            "class" => "selectpicker form-control",
                            "name" => "Disaster[]",
                            "multiple" => "",
                            "value" => $input["Disaster"]
                          )
                        ) ?>
                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-sm-6">
                      <div class="form-group">
                        <?= formLabel(lang("Form.status")) ?>
                        <?php $enum = "App\Eloquents\M_enumdetails" ?>
                        <?= formSelect(
                          $enum::findEnums("DisasterOccurStatus"),
                          "Value",
                          "EnumName",
                          array(
                            "id" => "Status",
                            "class" => "selectpicker form-control",
                            "name" => "Status[]",
                            "multiple" => "",
                            "value" => $input["Status"]
                          )
                        ) ?>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-md-6 col-sm-6">
                      <div class="form-group">
                        <?= formLabel(lang("Form.datefrom")) ?>
                        <?= formInput(
                          array(
                            "id" => "DateFrom",
                            "type" => "text",
                            "placeholder" => lang("Form.datefrom"),
                            "class" => "datepicker form-control",
                            "name" => "DateFrom",
                            "value" => $input["DateFrom"]
                          )
                        ) ?>
                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-sm-6">
                      <div class="form-group">
                        <?= formLabel(lang("Form.dateto")) ?>
                        <?= formInput(
                          array(
                            "id" => "DateTo",
                            "type" => "text",
                            "placeholder" => lang("Form.dateto"),
                            "class" => "datepicker form-control",
                            "name" => "DateTo",
                            "value" => $input["DateTo"]
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


      </section>
      <script>
        init();
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
              "date": "<?= get_formated_date($data->DateOccur, "d-m-Y H:i") ?>",
              "address": "<?= $data->get_M_Subvillage()->Name . ", " . $data->get_M_Subvillage()->get_M_Village()->Name . ", " . $data->get_M_Subvillage()->get_M_Village()->get_M_Subdistrict()->Name . ", " . $data->get_M_Subvillage()->get_M_Village()->get_M_Subdistrict()->get_M_District()->Name ?>",
              "province": "<?= $data->get_M_Subvillage()->get_M_Village()->get_M_Subdistrict()->get_M_District()->get_M_Province()->Name ?>",
              "markerUrl": "<?= baseUrl($data->get_M_Disaster()->Icon) ?>",
              "disasterName": "<?= $data->get_M_Disaster()->Name ?>",
              "status": "<?php $detail = "App\Models\M_enumdetails";
                            echo $detail::getEnumName("DisasterOccurStatus", $data->Status) ?>",
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
          html = "</div><h4><a href='<?= baseUrl("tdisasteroccur") ?>'>" + e.properties.model.TransNo + "</a></h4></h4>";
          html = html + "<div><?= lang('Form.disaster') ?> : " + e.properties.disasterName + "</div>"
          html = html + "<div><?= lang('Form.date') ?> : " + e.properties.date + "</div>"
          html = html + "<div><?= lang('Form.address') ?> : " + e.properties.address + "</div>"
          html = html + "<div><?= lang('Form.province') ?> : " + e.properties.province + "</div>"
          html = html + "<div>RT : " + e.properties.model.RT + "</div>"
          html = html + "<div>RW : " + e.properties.model.RW + "</div>"
          html = html + "<div>Latitude : " + e.properties.model.Latitude + "</div>"
          html = html + "<div>Longitude : " + e.properties.model.Longitude + "</div>"
          html = html + "<div>Status : " + e.properties.status + "</div>"
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

        function init() {
          var element = document.getElementById('Disaster');
          var status = document.getElementById('Status');

          // Set Values
          <?php if ($input["Disaster"]) { ?>
            var values = "<?= $input["Disaster"] ?>";
            for (var i = 0; i < element.options.length; i++) {
              element.options[i].selected = values.indexOf(element.options[i].value) >= 0;
            }
          <?php } ?>

          <?php if ($input["Status"]) { ?>
            var values = "<?= $input["Status"] ?>";
            for (var i = 0; i < status.options.length; i++) {
              status.options[i].selected = values.indexOf(status.options[i].value) >= 0;
            }
          <?php } ?>

        }
      </script>