<!-- modal -->
<div id="modalMaps" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="mapModalLabel" class="modal-title"><?= lang('Form.map') ?></h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div id="mapcontainer" class="card-body">
            </div>
        </div>
    </div>
</div>

<script>
    function showModalMap() {
        $('#modalMaps').modal('show')
    }

    function loadMap(latitude, longitude, icon) {

        var map = document.createElement('div');
        var container = document.getElementById('mapcontainer');
        map.setAttribute('id', "map");
        map.setAttribute('style', 'width: 100%; height: 400px;');
        container.appendChild(map);

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

        var feature = new Array();
        var loc = {
            "type": "Feature",
            "properties": {
                "message": "Foo",
                "iconSize": [50, 50],
                "markerUrl": icon,
            },
            "geometry": {
                "type": "Point",
                "coordinates": [
                    longitude,
                    latitude
                ]
            }
        };
        feature.push(loc);

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
            // html = "</div><h4><a href='<?= baseUrl("tdisasteroccur") ?>'>" + e.properties.model.TransNo + "</a></h4></h4>";
            // html = html + "<div><?= lang('Form.disaster') ?> : " + e.properties.disasterName + "</div>"
            // html = html + "<div><?= lang('Form.date') ?> : " + e.properties.date + "</div>"
            // html = html + "<div><?= lang('Form.address') ?> : " + e.properties.address + "</div>"
            // html = html + "<div><?= lang('Form.province') ?> : " + e.properties.province + "</div>"
            // html = html + "<div>RT : " + e.properties.model.RT + "</div>"
            // html = html + "<div>RW : " + e.properties.model.RW + "</div>"
            // html = html + "<div>Latitude : " + e.properties.model.Latitude + "</div>"
            // html = html + "<div>Longitude : " + e.properties.model.Longitude + "</div>"
            // html = html + "<div>Status : " + e.properties.status + "</div>"
            // var popup = new mapboxgl.Popup({
            //         offset: popupOffsets
            //     })
            //     .setHTML(html);

            // add marker to map
            new mapboxgl.Marker(el)
                .setLngLat(e.geometry.coordinates)
                // .setPopup(popup)
                .addTo(map);
        });
    }

    $('#modalMaps').on('hidden.bs.modal', function(e) {
        $("#map").remove();
    })
</script>