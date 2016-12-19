<style lang='sass' scoped>
@import '../assets/scss/main.scss';
.v-alert .v-modal {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    border-radius: pxTorem(10);
    
    z-index: 11;
    .modal-content {
        width: pxTorem(500);
        padding-top: pxTorem(30);
        border-radius: pxTorem(10);
        .icon {
            width: pxTorem(60);
            height: pxTorem(60);
            font-size: pxTorem(40);
        }
        .msg {
            font-size: pxTorem(32);
            line-height: pxTorem(130);
        }
        .btn {
            padding: 0;
            margin-bottom: pxTorem(40);
            letter-spacing: pxTorem(10);
            text-indent: pxTorem(10);
            width: pxTorem(200);
        }
    }
}

// .v-alert .bg-cover {
//     position: absolute;
//     left: 0;
//     top: 0;
//     width:100%;
//     background: rgba(0, 0, 0, .5);
//     z-index: 10;
// }
</style>
<template>
    <section class='v-alert'>
        <div class='bg-cover' :style='bg_style'></div>
        <div class='v-modal bg-white'>
            <div class='modal-content text-center text-large'>
                <i :class='["icon","text-red","iconfont","text-bold",icon_class]'></i>
                <p class='msg'>{{msg}}</p>
                <button class='btn btn-red btn-large' @click='toggleAlert'>{{btnText}}</button>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    props: {
        type: {
            type: String,
            default: 'suprise'
        },
        msg: String,
        btnText: {
            type: String,
            default: '关闭'
        },
        offsetHeight:0
    },
    computed: {
        //get right icon-class from props's type
        icon_class() {
            if (this.type == 'suprise') {
                return 'icon-warn';
            } else if (this.type == 'correct') {
                return 'icon-correct-circle-hollow';
            } else if (this.type == 'error') {
                return 'icon-error-circle';
            }
        },
        bg_style(){
          return{
                position:'absolute',
                left: 0,
                top: 0,
                width:'100%',
                height:this.$parent.offsetHeight+'px',
                background:'rgba(0, 0, 0, .5)',
                zIndex: 10,
          }
        }

    },
    methods:{
        toggleAlert(){
            this.$parent.toggleAlert();
        }
    }
}
</script>
