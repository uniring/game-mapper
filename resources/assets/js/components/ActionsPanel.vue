<template>
    <div class="actions-panel">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="btn-group">
                    <button @click="setTool('npc')" class="btn btn-primary btn-sm" v-bind:class="{ active: $parent.selectedTool === 'npc' }">NPC</button>
                    <button @click="setTool('warp')" class="btn btn-primary btn-sm" v-bind:class="{ active: $parent.selectedTool === 'warp' }">Warp</button>
                    <button @click="setTool('enemy')" class="btn btn-primary btn-sm" v-bind:class="{ active: $parent.selectedTool === 'enemy' }">Enemy</button>
                    <button @click="setTool('trigger')" class="btn btn-primary btn-sm" v-bind:class="{ active: $parent.selectedTool === 'trigger' }">Trigger</button>
                </div>
                <button class="btn btn-primary btn-sm">Quest log</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            let self = this;
            document.onkeypress = function (e) {
                e = e || window.event;
                let key = String.fromCharCode(e.keyCode);
                if (key === 'q' || key === 'n') {
                    self.setTool('npc');
                }
                if (key === 'w') {
                    self.setTool('warp');
                }
                if (key === 'e') {
                    self.setTool('enemy');
                }
                if (key === 't') {
                    self.setTool('trigger');
                }
            };
        },
        methods: {
            setTool(tool) {
                this.$parent.selectedTool = tool;
            }
        }
    }
</script>

<style lang="scss">
    .actions-panel {
        position: fixed;
        top: 15px;
        left: 10px;
        z-index: 100;
        padding: 2px 5px;
        .btn-group {
            margin-right: 5px;
        }
    }
</style>
