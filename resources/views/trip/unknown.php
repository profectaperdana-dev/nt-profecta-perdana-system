<div class="row">
    <hr>
    <label class="fw-bold text-success">Departure</label>
    <div class="form-group col-lg-4">
        <label>Province</label>
        <select name="province" class="form-select province" required>

        </select>

    </div>
    <div class="form-group col-lg-4">
        <label>District</label>
        <select name="city" class="form-select city" required>

        </select>

    </div>
    <div class="form-group col-lg-4">
        <label>Sub-district</label>
        <select name="district" class="form-select district" required>
        </select>
    </div>

</div>
<div class="row">
    <hr>
    <h6>Destination</h6>

    <div class="form-group col-lg-4">
        <label>Province</label>
        <select name="province" class="form-select province_" required>

        </select>

    </div>
    <div class="form-group col-lg-4">
        <label>District</label>
        <select name="city" class="form-select city_" required>

        </select>

    </div>
    <div class="form-group col-lg-4">
        <label>Sub-district</label>
        <select name="district" class="form-select district_" required>
        </select>
    </div>

</div>
{{-- <script>
            mapboxgl.accessToken =
                'pk.eyJ1IjoibWF1bGF5eWFjeWJlciIsImEiOiJja3N5bTU2ZTkxZGMyMnZsZ2V2aTc5enlrIn0.AoQDAKuMyXgRBRptUQ-8Bw';
            var map = new mapboxgl.Map({
                container: 'peta',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [104.78541701074731, -2.946603262626756], // Koordinat pusat peta
                zoom: 12 // Tingkat zoom awal
            });

            var directions = new MapboxDirections({
                accessToken: mapboxgl.accessToken,
                unit: 'metric',
                profile: 'mapbox/driving',
                interactive: true,
                steps: true
            });
            map.on('click', function(e) {
                var lngLat = e.lngLat;
                directions.addWaypoint(lngLat, directions.getWaypoints().length - 1);
            });
        </script> --}}
<script>
    // Add your Mapbox access token
    mapboxgl.accessToken =
        'pk.eyJ1IjoibWF1bGF5eWFjeWJlciIsImEiOiJja3N5bTU2ZTkxZGMyMnZsZ2V2aTc5enlrIn0.AoQDAKuMyXgRBRptUQ-8Bw';
    const map = new mapboxgl.Map({
        container: 'map', // Specify the container ID
        style: 'mapbox://styles/mapbox/streets-v12', // Specify which map style to use
        center: [104.78541701074731, -2.946603262626756], // Specify the starting position
        zoom: 12 // Specify the starting zoom
    });
    const coordinatesGeocoder = function(query) {
        // Match anything which looks like
        // decimal degrees coordinate pair.
        const matches = query.match(
            /^[ ]*(?:Lat: )?(-?\d+\.?\d*)[, ]+(?:Lng: )?(-?\d+\.?\d*)[ ]*$/i
        );
        if (!matches) {
            return null;
        }

        function coordinateFeature(lng, lat) {
            return {
                center: [lng, lat],
                geometry: {
                    type: 'Point',
                    coordinates: [lng, lat]
                },
                place_name: 'Lat: ' + lat + ' Lng: ' + lng,
                place_type: ['coordinate'],
                properties: {},
                type: 'Feature'
            };
        }

        const coord1 = Number(matches[1]);
        const coord2 = Number(matches[2]);
        const geocodes = [];

        if (coord1 < -90 || coord1 > 90) {
            // must be lng, lat
            geocodes.push(coordinateFeature(coord1, coord2));
        }

        if (coord2 < -90 || coord2 > 90) {
            // must be lat, lng
            geocodes.push(coordinateFeature(coord2, coord1));
        }

        if (geocodes.length === 0) {
            // else could be either lng, lat or lat, lng
            geocodes.push(coordinateFeature(coord1, coord2));
            geocodes.push(coordinateFeature(coord2, coord1));
        }

        return geocodes;
    };

    // Add the control to the map.
    map.addControl(
        new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            localGeocoder: coordinatesGeocoder,
            zoom: 4,
            // placeholder: 'Try: -40, 170',
            mapboxgl: mapboxgl,
            reverseGeocode: true
        })
    );
    const draw = new MapboxDraw({
        // Instead of showing all the draw tools, show only the line string and delete tools
        displayControlsDefault: false,
        controls: {
            line_string: true,
            trash: true
        },
        // Set the draw mode to draw LineStrings by default
        defaultMode: 'draw_line_string',
        styles: [
            // Set the line style for the user-input coordinates
            {
                'id': 'gl-draw-line',
                'type': 'line',
                'filter': [
                    'all',
                    ['==', '$type', 'LineString'],
                    ['!=', 'mode', 'static']
                ],
                'layout': {
                    'line-cap': 'round',
                    'line-join': 'round'
                },
                'paint': {
                    'line-color': '#438EE4',
                    'line-dasharray': [0.2, 2],
                    'line-width': 2,
                    'line-opacity': 0.7
                }
            },
            // Style the vertex point halos
            {
                'id': 'gl-draw-polygon-and-line-vertex-halo-active',
                'type': 'circle',
                'filter': [
                    'all',
                    ['==', 'meta', 'vertex'],
                    ['==', '$type', 'Point'],
                    ['!=', 'mode', 'static']
                ],
                'paint': {
                    'circle-radius': 12,
                    'circle-color': '#FFF'
                }
            },
            // Style the vertex points
            {
                'id': 'gl-draw-polygon-and-line-vertex-active',
                'type': 'circle',
                'filter': [
                    'all',
                    ['==', 'meta', 'vertex'],
                    ['==', '$type', 'Point'],
                    ['!=', 'mode', 'static']
                ],
                'paint': {
                    'circle-radius': 8,
                    'circle-color': '#438EE4'
                }
            }
        ]
    });

    // Add the draw tool to the map
    map.addControl(draw);

    // Add create, update, or delete actions
    map.on('draw.create', updateRoute);
    map.on('draw.update', updateRoute);
    map.on('draw.delete', removeRoute);

    // Use the coordinates you just drew to make the Map Matching API request
    function updateRoute() {
        removeRoute(); // Overwrite any existing layers

        const profile = 'driving'; // Set the profile

        // Get the coordinates
        const data = draw.getAll();
        const lastFeature = data.features.length - 1;
        const coords = data.features[lastFeature].geometry.coordinates;
        // Format the coordinates
        const newCoords = coords.join(';');
        // Set the radius for each coordinate pair to 25 meters
        const radius = coords.map(() => 999);
        getMatch(newCoords, radius, profile);
    }

    // Make a Map Matching request
    async function getMatch(coordinates, radius, profile) {
        // Separate the radiuses with semicolons
        const radiuses = radius.join(';');
        // Create the query
        const query = await fetch(
            `https://api.mapbox.com/matching/v5/mapbox/${profile}/${coordinates}?geometries=geojson&radiuses=${radiuses}&steps=true&access_token=${mapboxgl.accessToken}`, {
                method: 'GET'
            }
        );
        const response = await query.json();
        // Handle errors
        if (response.code !== 'Ok') {
            alert(
                `${response.code} - ${response.message}.\n\nFor more information: https://docs.mapbox.com/api/navigation/map-matching/#map-matching-api-errors`
            );
            return;
        }
        const coords = response.matchings[0].geometry;
        // Draw the route on the map
        addRoute(coords);
        getInstructions(response.matchings[0]);
    }

    function getInstructions(data) {
        // Target the sidebar to add the instructions
        const directions = document.getElementById('directions');
        let tripDirections = '';
        // Output the instructions for each step of each leg in the response object
        for (const leg of data.legs) {
            const steps = leg.steps;
            for (const step of steps) {
                tripDirections += `<li>${step.maneuver.instruction}</li>`;
            }
        }

        directions.innerHTML = `<p><strong>Trip duration: ${Math.floor(
            data.duration / 60
            )} min. ${data.distance / 1000} Km</strong></p><ol>${tripDirections}</ol>`;
    }

    // Draw the Map Matching route as a new layer on the map
    function addRoute(coords) {
        // If a route is already loaded, remove it
        if (map.getSource('route')) {
            map.removeLayer('route');
            map.removeSource('route');
        } else {
            map.addLayer({
                'id': 'route',
                'type': 'line',
                'source': {
                    'type': 'geojson',
                    'data': {
                        'type': 'Feature',
                        'properties': {},
                        'geometry': coords
                    }
                },
                'layout': {
                    'line-join': 'round',
                    'line-cap': 'round'
                },
                'paint': {
                    'line-color': '#03AA46',
                    'line-width': 8,
                    'line-opacity': 0.8
                }
            });
        }
    }

    // If the user clicks the delete draw button, remove the layer if it exists
    function removeRoute() {
        if (!map.getSource('route')) return;
        map.removeLayer('route');
        map.removeSource('route');
    }

    @foreach($customer as $location)
    @php
    $lang = null;
    $lat = null;
    if ($location - > coordinate != null && $location - > coordinate != '') {
        $coordinate = explode(',', $location - > coordinate);
        if (count($coordinate) >= 2) {
            $lang = $coordinate[0];
            $lat = $coordinate[1];
        }
    }
    @endphp


    var markerElement = document.createElement('div');
    markerElement.className = 'marker';
    var html =
        `
                    <table style="font-size:8pt;padding:1px;width:100%">
                            <tr>
                                <th>Code </th>
                                <th>:</th>
                                <th>{{ $location->code_cust }}</th>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <th>:</th>
                                <th>{{ $location->name_cust }}</th>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <th>:</th>
                                <th>{{ $location->phone_cust }}</th>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <th>:</th>
                                <th>{{ $location->address_cust . ', ' . $location->district . ', ' . $location->city . ', ' . $location->province }}</th>
                            </tr>
                            <tr>
                                <th>Label</th>
                                <th>:</th>
                                <th>{{ $location->label }}</th>
                            </tr>
                    </table>
                `;
    var popup = new mapboxgl.Popup({
        className: 'custom-popup'
    }).setHTML(html);
    var lang = {
        !!json_encode($lang) !!
    };
    var lat = {
        !!json_encode($lat) !!
    };
    var marker = new mapboxgl.Marker(markerElement)
        .setLngLat([lat, lang])
        .setPopup(popup)
        .addTo(map);
    // markers.push(marker); // Tambahkan marker ke dalam array markers
    @endforeach
</script>