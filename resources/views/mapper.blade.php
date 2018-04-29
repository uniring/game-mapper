<!DOCTYPE html>
<html>
<head>
    <title>Static Image</title>
    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js"></script>
    <style>
        html, body, .map {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #010101;
        }
    </style>
</head>
<body>
<div id="map" class="map"></div>
<script>
    var imgWidth = 20000;
    var imgHeight = 12000;

    var layer = new ol.layer.Tile({
        source: new ol.source.Zoomify({
            url: '/img/map/',
            size: [imgWidth, imgHeight],
            crossOrigin: 'anonymous'
        })
    });

    var extent = [0, -imgHeight, imgWidth, 0];

    var map = new ol.Map({
        layers: [layer],
        target: 'map',
        view: new ol.View({
            // adjust zoom levels to those provided by the source
            resolutions: layer.getSource().getTileGrid().getResolutions(),
            // constrain the center: center cannot be set outside this extent
            extent: extent
        }),
        controls : ol.control.defaults({
            attribution : false,
        })
    });
    map.getView().fit(extent);

    var control = document.getElementById('zoomifyProtocol');
    control.addEventListener('change', function(event) {
        var value = event.currentTarget.value;
        if (value === 'iip') {
            layer.setSource(new ol.source.Zoomify({
                url: iipUrl,
                size: [imgWidth, imgHeight],
                crossOrigin: 'anonymous'
            }));
        } else if (value === 'zoomify') {
            layer.setSource(new ol.source.Zoomify({
                url: zoomifyUrl,
                size: [imgWidth, imgHeight],
                crossOrigin: 'anonymous'
            }));
        }

    });
</script>
</body>
</html>