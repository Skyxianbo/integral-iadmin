<style lang='sass' scoped>
@import './assets/scss/main.scss';
.product_detail {
    position: relative;
    width: pxTorem(746);
    height: pxTorem(1332);
    border: 1px solid #666;
    background: white;
    /*border-bottom: 0;*/
    margin: -3px -1px;
}

.header {
    height: pxTorem(400);
    position: relative;
    img {
        width: 100%;
        height: 100%;
    }
    .cover {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: pxTorem(100);
        line-height: pxTorem(100);
        padding-left: pxTorem(55);
        background: rgba(0, 0, 0, .5);
    }
}

.fill {
    height: pxTorem(150);
}

.main {
    height: pxTorem(930);
    overflow: scroll;
    padding: 0 pxTorem(50);
    &::-webkit-scrollbar{
        display:none;
    }
    .introduction {
        margin-top: pxTorem(50);
        .title {
            padding: pxTorem(30) 0;
        }
    }
}

.footer {
    height: pxTorem(100);
    line-height: pxTorem(100);
    padding-left: pxTorem(55);
    border-bottom: 1px solid  $gray-light;
    .exchange {
        padding: 0;
        width: pxTorem(180);
        height: pxTorem(101);
        line-height: pxTorem(101);
        margin-top: pxTorem(-1);
        font-size: pxTorem(30);
        text-indent: pxTorem(12);
        letter-spacing: pxTorem(12);
        border: 0;
        border-radius: 0;
    }
    .btn-disable {
        color: $white;
        background-color: #838385;
        letter-spacing: 0;
        text-indent: pxTorem(0);
    }
}

.modal-content {
    width: pxTorem(600);
    border-radius: pxTorem(10);
    overflow: hidden;
    text-align: center;
    padding: pxTorem(20);
    background-color: $white;
    border-radius: pxTorem(10);
    .msg {
        padding: pxTorem(40) 0;
        margin: auto;
        font-size: pxTorem(32);
        text-align: center;
        width: pxTorem(400);
    }
    .pic {
        width: pxTorem(300);
        height: pxTorem(210);
    }
    .btn {
        width: pxTorem(300);
        height: pxTorem(78);
        margin: 0 auto;
        margin-bottom: pxTorem(30);
        line-height: pxTorem(78);
        font-size: pxTorem(30);
    }
}
</style>
<template>
    <div class='product_detail'>
        <header class='header '>
            <img :src='product_detail.pic_banner' />
            <div class='cover text-white '>
                <p class='text-huge text-ellipsis'>{{product_detail.name}}</p>
            </div>
        </header>
        <article class='main '>
            <div class='introduction'>
                <v-simditor>
                    <template v-if='product_detail.content'>
                        <v-divider text='详细说明'></v-divider>
                        <div v-html='product_detail.content'></div>
                    </template>
                    <template v-if='product_detail.content_use'>
                        <v-divider text='使用说明'></v-divider>
                        <div v-html='product_detail.content_use'></div>
                    </template>
                </v-simditor>
            </div>
            <div class='fill'></div>
        </article>
        <v-sticky>
            <footer class='footer '>
                <div class='text-large pull-left'>
                    单价：<span class='text-red'>{{parseInt(product_detail.integral)||0}}</span>积分
                </div>
                <button class='exchange btn-red pull-right'>兑换</button>
            </footer>
        </v-sticky>
    </div>
</template>
<script>
import vSticky from './components/v_sticky.vue'
import vDivider from './components/v_divider.vue'
import vSimditor from './components/v_simditor.vue'
export default {

    name: 'product_detail',
    components: {
        vSticky,
        vSimditor,
        vDivider
    },
    props:{
      productDetail:Object
    },
    computed:{
        product_detail(){
            return this.productDetail;
        }
    },
    data(){
        return{
          product_detail:{}
        }
    }
};
</script>
