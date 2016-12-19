<style lang='sass' scoped>
@import './assets/scss/main.scss';
@import './assets/scss/iconfont/iconfont.css';        
.activity-preview {
    position: relative;
    width: pxTorem(750);
    height: pxTorem(1334);
    border: 1px solid $gray-light;
    overflow: scroll;
    background: white;
    &::-webkit-scrollbar {
        display: none;
    }
}

.body {
    // height: pxTorem(467);
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
    <div class='activity-preview'>
        <header>
            <!-- <component :is='activity_type' :questions=''></component> -->
            <scrap v-if='activity_type==1'></scrap>
            <quiz v-if='activity_type==2' :questions='activity_detail.questions'></quiz>
            <game v-if='activity_type==3' :name="activity_detail.game_name"></game>
        </header>
        <section class='body'>
            <div class='introduction'>
                <!-- <div class="">
                  <i class='icon iconfont icon-correct-circle-hollow'></i>
                  <i class='icon iconfont icon-user'></i>
                  <i class='icon iconfont icon-order'></i>
                  <i class='icon iconfont icon-car'></i>
                  <i class='icon iconfont icon-message'></i>
              </div> -->
                <v-simditor>
                    <template v-if='activity_detail.content'>
                        <v-divider text='详细说明'></v-divider>
                        <section v-html='activity_detail.content'></section>
                    </template>
                    <template v-if='activity_detail.content_prob'>
                        <v-divider text='概率说明'></v-divider>
                        <section v-html='activity_detail.content_prob'></section>
                    </template>
                </v-simditor>
            </div>
            <v-divider text='奖品列表'></v-divider>
        </section>
        <div class='aword-list'>
            <v-list-item v-for='item in activity_detail.items' :title='item.name' :title-dupty='item.desc' :img='item.pic'></v-list-item>
        </div>
        <v-alert v-if='alert.show&&$parent.show' :msg='alert.msg' :btn-text='alert.btn_text' :type='alert.type'></v-alert>
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

    name: 'activity_detail',
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
        activityDetail: Object,
        activityType: Number,
        show:Boolean
    },
    computed: {
        activity_detail() {
            return this.activityDetail;
        },
        activity_type() {
            return this.activityType;
        },
    },
    data() {
        return {
            offsetHeight: 0,
            alert: {
                show: false,
                msg: 'hello world',
                btn_text: '查看'
            }
        }
    },
    watch: {
        activity_type(value) {
            this.loadActivity(value);
        },
        show(value){
           if(!value){
            this.alert.show=false;
           }
        }
    },
    ready() {},
    methods: {
        loadActivity(type) {
            if (type == 1) {
                this.activity_type = 'scrap';
            } else if (type == 2) {
                this.activity_type = 'quiz';
            } else if (type == 3) {
                this.activity_type = 'game';
            }
        },
        toggleAlert(msg, btn_text, type) {
            this.offsetHeight = this.getOffsetHeight();
            this.alert.show = !this.alert.show;
            this.alert.msg = msg || '谢谢参与';
            this.alert.btn_text = btn_text || '关闭';
            if (type) {
                this.alert.type = type;
            }
        },
        getOffsetHeight() {
            let header = this.$el.querySelector('header');
            let body = this.$el.querySelector('section.body');
            let aword_list = this.$el.querySelector('.aword-list');
            return header.offsetHeight + body.offsetHeight + aword_list.offsetHeight;
        },
        getAword() {
            let items = this.activity_detail.items;
            let num = Math.floor(Math.random() * items.length);
            return items[num].name;
        }


    }
};
</script>
