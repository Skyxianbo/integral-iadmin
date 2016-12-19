<style lang='sass' scoped>
@import './assets/scss/main.scss';
@import './assets/scss/iconfont/iconfont.css';
.game-preview {
    position: relative;
    width: pxTorem(750);
    height: pxTorem(1334);
    overflow-x:hidden;
    overflow-y:scroll;
    background: white;
    &::-webkit-scrollbar {
        display: none;
    }
}

.body {
    padding: 0 pxTorem(55);
    .introduction {
        padding: pxTorem(50) 0;
        .title {
            padding: pxTorem(30) 0;
        }
    }
}
</style>
<template>
    <div class='game-preview'>
        <header>
            <game v-if='game_type==3' :name="name"></game>
        </header>
        
    </div>
</template>
<script>
import {
    quiz,
    scrap,
    game
} from './components/activities'
import vListItem from './components/v_list_item.vue'
import vDivider from './components/v_divider.vue'
import vSimditor from './components/v_simditor.vue'
import vAlert from './components/v_alert.vue'
export default {

    name: 'game_detail',
    components: {
        vAlert,
        quiz,
        scrap,
        game,
        vListItem,
        vDivider,
        vSimditor
    },

    props: {
        gameDetail: Object,
        gameType: Number,
        show:Boolean,
        name: String
    },
    computed: {
        game_detail() {
            return this.gameDetail;
        },
        game_type() {
            return this.gameType;
        },
    },
    data() {
        return {
            
        }
    },
    watch: {
        game_type(value) {
            this.loadgame(value);
        },
       
    },
    ready() {},
    methods: {
        loadgame(type) {
            if (type == 1) {
                this.game_type = 'scrap';
            } else if (type == 2) {
                this.game_type = 'quiz';
            } else if (type == 3) {
                this.game_type = 'game';
            }
        },
        

    }
};
</script>
