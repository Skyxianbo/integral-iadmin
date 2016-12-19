<style lang='sass' scoped>
@import '../assets/scss/variable.scss';
.v-divider {
    padding:0 pxTorem(20);
    position: relative;
    height: 1rem;
    .text {
        position: absolute;
        left: 50%;
        top: 50%;
        /*transform: translate(-50%, -50%);*/
        /*transform:rotate(7deg);*/
        -ms-transform:translate(-50%, -50%);     /* IE 9 */
        -moz-transform:translate(-50%, -50%);    /* Firefox */
        -webkit-transform:translate(-50%, -50%); /* Safari 和 Chrome */
        -o-transform:translate(-50%, -50%);
        background: $white;
        padding: 0 pxTorem(30);
        font-size: pxTorem(30);
        color: $black;
    }
    .line {
        position: absolute;
        width: 100%;
        top: 50%;
    }
    .line.solid {
        border-bottom: 1px solid $gray-light;
    }
    .line.dashed {
        border-bottom: 1px dashed $gray-light;
    }
    span {
        font-size: 100%;
        font-family: 'Microsoft Yahei'
    }
}
</style>
<template>
    <div class='v-divider '>
        <div :class='["line", type]'></div>
        <span class='text'> {{text}} </span>
    </div>
</template>
<script>
export default {
    props: {
        text: {
            type: String,
            default: '内容'
        },
        type: {
            type: String,
            default: 'solid'
        }
    }
}
</script>
