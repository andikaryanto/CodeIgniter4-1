<section>
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="h3 display"><?= lang('Form.userlocation') ?> </h1>
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
                    <!-- <div class="card-body">
                        <?= formOpen(baseUrl('welcome'), array(), "GET") ?>
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
                                    <?php $enum = "App\Models\M_enumdetails" ?>
                                    <?= formSelect(
                                        $enum::getEnums("DisasterOccurStatus"),
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
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <section>

        <script>
            // init();
            mapboxgl.accessToken = 'pk.eyJ1IjoiYW5kaWthcnlhbnRvbyIsImEiOiJjanlueGJlb2owdzM0M2RtdG9nN3Y5Mm5kIn0.Ancb01gHGbYcwsDea33KaA';

            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [110.3515128, -7.7951198],
                zoom: 10
            });

            // var url = 'https://wanderdrone.appspot.com/';
            // var data = {"geometry":{"type":"Point","coordinates":[110.5778183,-7.6750727]},"type":"Feature","properties":[]};
            var url = '<?= baseUrl('api/user/userlocation') ?>'
            map.on('load', function() {
                var datas;
                var interval = window.setInterval(function() {
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(result) {
                            datas = result;

                            result.Result.forEach(function(item, index) {
                                var mapLayer = map.getLayer(item.Id);
                                if (mapLayer == undefined) {
                                    // map.removeLayer(item.Id);
                                    // map.removeSource(item.Id);
                                    map.addSource(item.Id, {
                                        type: 'geojson',
                                        data: item.Data
                                    });
                                    map.addLayer({
                                        "id": item.Id,
                                        "type": "symbol",
                                        "source": item.Id,
                                        "layout": {
                                            "icon-image": "rocket-15"
                                        }
                                    });
                                }
                                map.getSource(item.Id).setData(item.Data);
                                map.on('click', item.Id, function(e) {
                                var coordinates = e.features[0].geometry.coordinates.slice();
                                var description = e.features[0].properties.description;

                                // Ensure that if the map is zoomed out such that multiple
                                // copies of the feature are visible, the popup appears
                                // over the copy being pointed to.
                                // while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                                //     coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                                // }

                                new mapboxgl.Popup()
                                    .setLngLat(coordinates)
                                    .setHTML(description)
                                    .addTo(map);
                            });
                            })
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            clearInterval(interval);
                            console.error(errorThrown);
                            setNotification(XMLHttpRequest.responseJSON.Message, 4);
                        }
                    })


                }, 2000);


            });


            function init() {


            }
        </script>