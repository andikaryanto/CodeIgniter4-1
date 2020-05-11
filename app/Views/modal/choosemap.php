<!-- modal -->
<div id="modalMaps" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="mapModalLabel" class="modal-title"><?= lang('Form.map') ?></h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="card-body">
                <div style="height: 400px;" id='map'></div>
            </div>
        </div>
    </div>
</div>

<script>

    var isMapLoaded = false;
    var map;

    $(document).ready(function() {
        map();
    });

    function showModalMap(latitude = null, longitude = null) {
        marker(latitude, longitude);
        $('#modalMaps').modal('show');
    }

    function map(){
        mapboxgl.accessToken = 'pk.eyJ1IjoiYW5kaWthcnlhbnRvbyIsImEiOiJjanlueGJlb2owdzM0M2RtdG9nN3Y5Mm5kIn0.Ancb01gHGbYcwsDea33KaA';

        map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [110.3515128, -7.7951198],
            zoom: 10
        });
        isMapLoaded = true;
    }

    function marker(latitude = null, longitude = null) {

        // var map = document.createElement('div');
        // var container = document.getElementById('mapcontainer');
        // map.setAttribute('id', "map");
        // map.setAttribute('style', 'width: 100%; height: 400px;');
        // container.appendChild(map);

        

        var el = document.createElement('div');
        el.className = 'marker';

        var marker = new mapboxgl.Marker(el)
        map.on('click', function(e){
            if (typeof circleMarker !== "undefined" ){ 
                map.removeLayer(circleMarker);         
            }
            console.log(e.lngLat)
  //add marker
            marker.remove();
            marker.setLngLat(e.lngLat)
            // .setPopup(popup)
            .addTo(map);
            
            $(latitude).val(e.lngLat.lat);
            $(longitude).val(e.lngLat.lng);
            
        });
    }

    $('#modalMaps').on('hidden.bs.modal', function(e) {
    })

    $('#modalMaps').on('shown.bs.modal', function(e) {
        map.resize();
    })
</script>