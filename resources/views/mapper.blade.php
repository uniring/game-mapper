<!DOCTYPE html>
<html>
<head>
    <title>Game Mapper</title>

    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <script src="https://openlayers.org/en/v4.6.5/build/ol.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
        html, body, .map {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #010101;
            position: relative;
        }
        ActionsPanel {
            position: fixed;
            bottom: 15px;
            left: 10px;
            width: 600px;
            z-index: 100;
            padding: 2px 5px;
        }
        ActionsPanel .panel {
            margin: 0;
            background-color: rgba(51, 82, 118, 0.7);
            color: white;
        }
        ActionsPanel .btn-group {
            margin-right: 5px;
        }
    </style>
</head>
<body>
<div id="map" class="map">
    <div id="popup"></div>
    <ActionsPanel></ActionsPanel>
</div>
<script>
    // FUNCTIONS
    function addIcon(map, icon, coordinates)
    {
        var iconFeature = new ol.Feature({
            geometry: new ol.geom.Point(coordinates),
            name: 'Bob the ogre'
        });

        var iconStyle = new ol.style.Style({
            image: icon,
        });

        var vectorSource = new ol.source.Vector({
            features: [iconFeature]
        });

        var vectorLayer = new ol.layer.Vector({
            updateWhileInteracting: true,
            source: vectorSource,
            style: iconStyle
        });
        map.addLayer(vectorLayer);
        map.render();
    }
</script>
<script>
    // Initialize map
    var imgWidth = 20000;
    var imgHeight = 12000;
    var icons = {};
    var iconScale = 0.35;
    var lastIconScale = 0;
    var selectedTool = 'none';

    // Icon definitions
    icons = {
        warp: new ol.style.Icon({
            anchor: [0.5, 1],
            anchorXUnits: 'fraction',
            anchorYUnits: 'fraction',
            src: '/img/icons/warp.png',
            scale: iconScale
        }),
        npc: new ol.style.Icon({
            anchor: [0.5, 1],
            anchorXUnits: 'fraction',
            anchorYUnits: 'fraction',
            src: '/img/icons/npc.png',
            scale: iconScale
        }),
        enemy: new ol.style.Icon({
            anchor: [0.5, 1],
            anchorXUnits: 'fraction',
            anchorYUnits: 'fraction',
            src: '/img/icons/enemy.png',
            scale: iconScale
        })
    };

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
            resolutions: layer.getSource().getTileGrid().getResolutions(),
            extent: extent
        }),
        controls : ol.control.defaults({
            attribution : false,
        })
    });
    map.getView().fit(extent);
    map.getView().on('change:resolution', function () {
        var zoom = map.getView().getZoom();
        iconScale = 0.35;
        if (zoom > 4) {
            iconScale = 0.5;
        }
        if (zoom > 5) {
            iconScale = 0.75;
        }
        if (zoom > 6) {
            iconScale = 1;
        }
        if (lastIconScale !== iconScale) {
            for (var i in icons) {
                if (typeof icons[i].setScale == 'function') {
                    icons[i].setScale(iconScale);
                }
            }
        }
        lastIconScale = iconScale;
    });

    map.on('singleclick', function (evt) {

    });

    map.on('pointermove', function(e) {
        if (e.dragging) {
            $(element).popover('destroy');
            return;
        }
        var pixel = map.getEventPixel(e.originalEvent);
        var hit = map.hasFeatureAtPixel(pixel);
        map.getTargetElement().style.cursor = hit ? 'pointer' : '';
    });

    // Popup

    var element = document.getElementById('popup');
    var popup = new ol.Overlay({
        element: element,
        positioning: 'bottom-center',
        stopEvent: false,
        offset: [0, -15]
    });
    map.addOverlay(popup);

    map.on('click', function(evt) {
        var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature) {
            return feature;
        });
        if (feature) {
            var coordinates = feature.getGeometry().getCoordinates();
            popup.setPosition(coordinates);
            $(element).popover({
                'placement': 'top',
                'html': true,
                'content': feature.get('name'),
                'container': map.getTargetElement()
            });
            $(element).popover('show');
        } else {
            $(element).popover('destroy');

            if (icons[selectedTool]) {
                addIcon(map, icons[selectedTool], evt.coordinate);
                selectedTool = 'none';
            }
        }
    });

    document.onkeypress = function (e) {
        e = e || window.event;
        if (e.keyCode == 78) {
            selectedTool = 'npc';
        }
        if (e.keyCode == 87) {
            selectedTool = 'warp';
        }
        if (e.keyCode == 69) {
            selectedTool = 'enemy';
        }
        if (e.keyCode == 84) {
            selectedTool = 'trigger';
        }
    };

    // Testing markers

    for (var x=0; x < 400; x++) {
        addIcon(map, icons.npc, [Math.random()* 20000, Math.random() * -12000]);
    }
</script>
</body>
<script src="{{asset('js/app.js')}}" ></script>
</html>
