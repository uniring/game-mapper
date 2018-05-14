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
            let self = this;

            let layer = new ol.layer.Tile({
                source: new ol.source.Zoomify({
                    url: '/img/map/',
                    size: [
                        self.imgWidth,
                        self.imgHeight
                    ],
                    crossOrigin: 'anonymous'
                })
            });

            let extent = [0, -self.imgHeight, self.imgWidth, 0];

            self.map = new ol.Map({
                layers: [layer],
                target: 'map',
                view: new ol.View({
                    resolutions: layer.getSource().getTileGrid().getResolutions(),
                    extent: extent
                }),
                controls: ol.control.defaults({
                    attribution: false,
                    zoom: false
                })
            });
            self.map.getView().fit(extent);
            self.map.getView().on('change:resolution', function () {
                let zoom = self.map.getView().getZoom();
                self.iconScale = 0.35;
                if (zoom > 4) {
                    self.iconScale = 0.5;
                }
                if (zoom > 5) {
                    self.iconScale = 0.75;
                }
                if (zoom > 6) {
                    self.iconScale = 1;
                }
                if (self.lastIconScale !== self.iconScale) {
                    for (var i in self.icons) {
                        if (typeof self.icons[i].setScale == 'function') {
                            self.icons[i].setScale(self.iconScale);
                        }
                    }
                }
                self.lastIconScale = self.iconScale;
            });

            self.map.on('pointermove', function (e) {
                if (e.dragging) {
                    $(self.popupEl).popover('destroy');
                    return;
                }
                let feature = self.map.forEachFeatureAtPixel(e.pixel, function (feature) {
                    return feature;
                });
                if (feature) {
                    if (!self.showingTooltip) {
                        self.map.getTargetElement().style.cursor = 'pointer';
                        let coordinates = feature.getGeometry().getCoordinates();
                        self.popup.setPosition(coordinates);
                        $(self.popupEl).popover({
                            'placement': 'top',
                            'html': true,
                            'content': feature.get('name'),
                            'container': self.map.getTargetElement()
                        });
                        $(self.popupEl).popover('show');
                        self.showingTooltip = true;
                    }
                } else {
                    self.map.getTargetElement().style.cursor = '';
                    $(self.popupEl).popover('hide');
                    self.showingTooltip = false;
                }
            });

            self.map.addOverlay(self.popup);

            self.map.on('click', function (evt) {
                let feature = self.map.forEachFeatureAtPixel(evt.pixel, function (feature) {
                    return feature;
                });
                if (!feature) {
                    if (self.icons[self.selectedTool]) {
                        self.addIcon(evt.coordinate);
                        self.selectedTool = 'none';
                    }
                }
            });
        },
        methods: {
            addIcon(coordinates) {
                let self = this;
                let name = prompt('Enter a name');

                let iconFeature = new ol.Feature({
                    geometry: new ol.geom.Point(coordinates),
                    name: name
                });

                let iconStyle = new ol.style.Style({
                    image: self.icons[self.selectedTool],
                });

                let vectorSource = new ol.source.Vector({
                    features: [iconFeature]
                });

                let vectorLayer = new ol.layer.Vector({
                    updateWhileInteracting: true,
                    source: vectorSource,
                    style: iconStyle
                });
                self.map.addLayer(vectorLayer);
                self.map.render();

                axios.post('/api/point', {
                    name: name,
                    map_x: coordinates[0],
                    map_y: coordinates[1],
                    type: self.selectedTool
                });
            }
        },
        data: function () {
            return {
                selectedTool: 'none',
                map: null,
                imgWidth: 20000,
                imgHeight: 12000,
                iconScale: 0.35,
                lastIconScale: 0,
                showingTooltip: false,
                icons: {
                    warp: new ol.style.Icon({
                        anchor: [0.5, 1],
                        anchorXUnits: 'fraction',
                        anchorYUnits: 'fraction',
                        src: '/img/icons/warp.png',
                        scale: this.iconScale
                    }),
                    npc: new ol.style.Icon({
                        anchor: [0.5, 1],
                        anchorXUnits: 'fraction',
                        anchorYUnits: 'fraction',
                        src: '/img/icons/npc.png',
                        scale: this.iconScale
                    }),
                    enemy: new ol.style.Icon({
                        anchor: [0.5, 1],
                        anchorXUnits: 'fraction',
                        anchorYUnits: 'fraction',
                        src: '/img/icons/enemy.png',
                        scale: this.iconScale
                    })
                },
                popupEl: document.getElementById('popup'),
                popup: new ol.Overlay({
                    element: this.popupEl,
                    positioning: 'bottom-center',
                    stopEvent: false,
                    offset: [0, -15]
                })
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