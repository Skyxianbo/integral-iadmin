<style lang='sass' scoped>
iframe {
    width: 99%;
    height: 660px;
    padding: 0;
    margin: 0;
}
</style>
<template>
    <div class='game'>
        <iframe src='/src/components/preview/components/activities/game/game_1.html' v-if="name == '开心消消乐'">
        </iframe>
        <iframe src='/src/components/preview/components/activities/game/game_2.html' v-if="name == '棍子忍者'">
        </iframe>
        <iframe src='/src/components/preview/components/activities/game/game_3.html' v-if="name == '逝去的青春'">
        </iframe>
    </div>
</template>
<script>
export default {
    props: {
      name: String
    },
    data() {
        return {
        }
    },
    ready() {

    },
    methods: {
    }
}
</script>
