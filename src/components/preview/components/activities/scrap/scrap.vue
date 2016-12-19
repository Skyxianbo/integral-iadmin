<style lang='sass' scoped>
@import '../../../assets/scss/main.scss';
.v-scrap {
    position: relative;
    height: pxTorem(600);
    background: url('./images/scrap.png') no-repeat;
    background-size: 100%;
}

#lotteryContainer {
    position: absolute;
    overflow: hidden;
    width: pxTorem(500);
    height: pxTorem(200);
    left: pxTorem(138);
    top: pxTorem(310);
    background: $gray-light;
}

#start {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    padding: 0;
    width: pxTorem(180);
    height: pxTorem(68);
    line-height: pxTorem(68);
    font-size: pxTorem(30);
    text-indent: pxTorem(12);
    letter-spacing: pxTorem(12);
}
</style>
<template>
    <div class='v-scrap '>
        <div id='lotteryContainer'>
            <button class='btn btn-red' id='start' @click='startActivity'>开始</button>
        </div>
    </div>
</template>
<script>
import Lottery from './libs/lottery.js'
export default {
    name: 'scrap',
    data() {
        return {
            modal: false, //控制弹窗状态
            draw_percent: 0, //画布涂抹面积 大于一定值时触发弹窗
            lottery: '', //画布实例
            activity_start: false, //判断活动状态 1.超出活动次数 2.更新积分失败
            is_win: false, //判断是否中奖
            activity_end: false, //判断活动是否结束
            order_detail_id: '', //活动结束跳转id
            alert:{
                msg:'',
                btn_text:''
            }
        };
    },
    watch: {
        draw_percent(value) {
            if (value > 40 && !this.activity_end&&(this.alert.msg||this.alert.btn_text)) {
                this.activity_end = true;
                this.$parent.toggleAlert(this.alert.msg,this.alert.btn_text);
            }
        }
    },
    methods: {
        //开始活动
        startActivity() {
            if(Math.random()>0.8){
                this.setLottery('谢谢参与');
            }else{
                let msg=this.$parent.getAword();
                this.setLottery(msg);
                this.alert={
                    msg,
                    btn_text:'查看'
                }
            }
        },
        //设置画布
        setLottery(str) {
            this.lottery = new Lottery('lotteryContainer', '#ddd', 'color', this.pxTorem(500), this.pxTorem(200), (draw_percent) => {

                this.draw_percent = draw_percent;
            });
            this.lottery.init(str, 'text');
        },
        pxTorem(value) {
            return value / 2;
        },
    },
};
</script>
