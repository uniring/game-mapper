<template>
    <div id="map" class="map">
        <div id="popup"></div>
        <actions-panel></actions-panel>
        <quest-log></quest-log>
    </div>
</template>

<script>
    export default {
        components: {
            'actions-panel': require('./ActionsPanel.vue'),
            'quest-log': require('./QuestLog.vue')
        },
        mounted() {
            // Initialize map
            var self = this;
            var imgWidth = 20000;
            var imgHeight = 12000;
            var icons = {};
            var iconScale = 0.35;
            var lastIconScale = 0;
            var showingTooltip = false;

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
                    zoom: false
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
                var feature = map.forEachFeatureAtPixel(e.pixel, function(feature) {
                    return feature;
                });
                if (feature) {
                    if (!showingTooltip) {
                        map.getTargetElement().style.cursor = 'pointer';
                        var coordinates = feature.getGeometry().getCoordinates();
                        popup.setPosition(coordinates);
                        $(element).popover({
                            'placement': 'top',
                            'html': true,
                            'content': feature.get('name'),
                            'container': map.getTargetElement()
                        });
                        $(element).popover('show');
                        showingTooltip = true;
                    }
                } else {
                    map.getTargetElement().style.cursor = '';
                    $(element).popover('hide');
                    showingTooltip = false;
                }
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
                if (!feature) {
                    if (icons[self.selectedTool]) {
                        addIcon(map, icons[self.selectedTool], evt.coordinate);
                        self.selectedTool = 'none';
                    }
                }
            });
        },
        methods: {
            setTool(tool) {
                alert(tool);
            }
        },
        data: function () {
            return {
                selectedTool: 'none'
            }
        }
    }
</script>

<style>
    .map {
        width: 100%;
        height: 100%;
    }
</style>