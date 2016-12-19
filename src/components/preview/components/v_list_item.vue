<style lang='sass' scoped>
@import '../assets/scss/variable.scss';
.v-list-item {
    display: table;
    width: 100%;
    height: pxTorem(220);
    border-bottom: 1px solid $gray-light;
    background-color: $white;
    .img {
        display: table-cell;
        width: pxTorem(280);
        vertical-align: middle;
        text-align: center;
        img{
            width: pxTorem(180);
            height: pxTorem(140);
        }
    }
    .describe {
        display: table-cell;
        vertical-align: middle;
        span:nth-child(1) {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin-bottom: pxTorem(7);
        }
    }
}
</style>
<template>
    <div class='v-list-item'>
        <div class='img'>
            <img :src='img' />
        </div>
        <div class='describe'>
            <span class='text-huge '>{{title}}</span>
            <span :class='color'>{{titleDupty}}</span>
        </div>
    </div>
</template>
<script>
export default {

    name: 'v-list-item',
    props: {
        title: {
            type: String,
            default: ''
        },
        titleDupty: {
            type: String,
            default: ''
        },
        color: {
            type: String,
            default: 'text-gray'
        },
        img: {
            type: String,
            default: ''
        }
    }
};
</script>
