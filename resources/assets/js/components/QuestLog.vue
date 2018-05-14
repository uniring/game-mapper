<template>
    <div class="quest-log">
        <div class="panel panel-default">
            <div class="panel-body">
                <h5>Quests</h5>
                <div class="quest-list">
                    <div class="quest" v-for="quest in quests">
                        {{ quest.name }} <a href="#">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            var self = this;
            self.loadQuests();
        },
        methods: {
            loadQuests: function() {
                fetch('/api/quest')
                    .then(quests => quests.json())
                    .then(quests => {
                        this.quests = quests;
                    });
            }
        },
        data: function () {
            return {
                quests: []
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
    .quest-list {
        max-height: 80%;
        overflow-y: scroll;
    }
    .quest {
        padding: 0 3px;
        a {
            float: right;
        }
    }
</style>
