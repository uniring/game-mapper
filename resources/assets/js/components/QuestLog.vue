<template>
    <div class="quest-log">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="quest" v-for="quest in quests">
                    {{ quest.name }} <a href="#">Edit</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            var self = this;
        },
        methods: {
        },
        data: function () {
            return {
                quests: [{
                    name: 'Bob the ogre'
                }, {
                    name: 'Justin Beaver\'s flute'
                }, {
                    name: 'Find Eva'
                }]
            }
        }
    }
</script>

<style lang="scss">
    .quest-log {
        position: fixed;
        top: 15px;
        right: 10px;
        width: 200px;
        height: 400px;
        z-index: 100;
        padding: 2px 5px;
    }
    .quest {
        padding: 0 3px;
        a {
            float: right;
        }
    }
</style>
