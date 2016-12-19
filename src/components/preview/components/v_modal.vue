<style lang='sass' scoped>
@import '../assets/scss/variable.scss';
.v-modal {
    .bg-cover {
        position: fixed;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, .5);
        z-index: 5;
    }
    .content {
        position: fixed;
        left: 50%;
        top: 50%;
        -ms-transform:translate(-50%, -50%);     /* IE 9 */
        -moz-transform:translate(-50%, -50%);    /* Firefox */
        -webkit-transform:translate(-50%, -50%); /* Safari 和 Chrome */
        -o-transform:translate(-50%, -50%);
        z-index: 6
    }
}
</style>
<template>
    <div class='v-modal'>
        <!-- <transition name='fade'> -->
            <div v-show='show' @click='close()' class='bg-cover'>
            </div>
        <!-- </transition> -->
        <div v-show='show' class='content '>
            <slot></slot>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        coverClose: {
            type: Boolean,
            default: true
        },
        show: {
            type: Boolean,
            default: false
        },
        toggleModal: Function
    },
    methods: {
        close() {
            if (this.coverClose && event.target.className == 'bg-cover') {
                this.toggleModal();
            }
        }
    }

};
</script>
