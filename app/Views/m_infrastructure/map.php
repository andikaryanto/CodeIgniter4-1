<section>
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="h3 display"><?= lang('Form.infrastructure') ?> </h1>
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
                        <?= formOpen(baseUrl('minfrastructure/map'), array(), "GET") ?>
                        <div class="row">
                            <div class="col-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <?= formLabel(lang("Form.infrastructurecategory")) ?>
                                    <?= formSelect(
                                        $category,
                                        "Id",
                                        "Name",
                                        array(
                                            "id" => "Category",
                                            "class" => "selectpicker form-control",
                                            "name" => "Category[]",
                                            "multiple" => ""
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
                                    "href" => baseUrl('minfrastructure'),
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
    <section>
        <script>
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
                        "category": "<?= $data->get_M_Infrastructurecategory()->Name ?>",
                        "icon": "<?= baseUrl($data->get_M_Infrastructurecategory()->Icon) ?>",
                        "address": "<?= $data->get_M_Subvillage()->Name . ", " . $data->get_M_Subvillage()->get_M_Subdistrict()->Name . ", " . $data->get_M_Subvillage()->get_M_Subdistrict()->get_M_District()->Name ?>",
                        "province": "<?= $data->get_M_Subvillage()->get_M_Subdistrict()->get_M_District()->get_M_Province()->Name ?>",
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
                el.style.backgroundImage = 'url(' + e.properties.icon + ')';
                el.style.width = e.properties.iconSize[0] + 'px';
                el.style.height = e.properties.iconSize[1] + 'px';
                // //add pop up
                html = "</div><h4>" + e.properties.model.Name + "</h4></div>";
                html = html + "<div><?= lang('Form.address') ?> : " + e.properties.address + "</div>"
                html = html + "<div><?= lang('Form.province') ?> : " + e.properties.province + "</div>"
                html = html + "<div><?= lang('Form.personincharge') ?> : " + e.properties.model.PersonInCharge + "</div>"
                html = html + "<div><?= lang('Form.telephone') ?> : " + e.properties.model.Phone + "</div>"
                html = html + "<div><?= lang('Form.capacity') ?> : " + e.properties.model.Capacity + "</div>"
                html = html + "<div><?= lang('Form.infrastructurecategory') ?> : " + e.properties.category + "</div>"
                html = html + "<div>Latitude : " + e.properties.model.Latitude + "</div>"
                html = html + "<div>Longitude : " + e.properties.model.Longitude + "</div>"
                var popup = new mapboxgl.Popup({
                        offset: popupOffsets
                    })
                    .setHTML('<div ><h3>' + html + '</h3></div>');

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
        </script>