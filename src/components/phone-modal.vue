<template>
    <div role="dialog" v-bind:class="{
    'modal':true,
    'fade':effect === 'fade',
    'zoom':effect === 'zoom'
    }">
        <div v-bind:class="{'modal-dialog':true,'modal-lg':large,'modal-sm':small}" role="document" style="width: 432px;height: 0;">
            <div class="modal-content">
                <div class="modal-body">
                    <slot name="modal-body">
                    </slot>
                </div>
            </div>
            <img class="closeButton" src="../assets/images/close.png" alt="X" @click="close()">
        </div>
    </div>
</template>
<script>
import getScrollBarWidth from '../libs/utils/getScrollBarWidth.js'
import EventListener from '../libs/utils/EventListener.js'
import coerceBoolean from '../libs/utils/coerceBoolean.js'
export default {
    props: {
        show: {
            require: true,
            type: Boolean,
            coerce: coerceBoolean,
            twoWay: true
        },
        effect: {
            type: String,
            default: null
        },
        backdrop: {
            type: Boolean,
            coerce: coerceBoolean,
            default: true
        },
        large: {
            type: Boolean,
            coerce: coerceBoolean,
            default: false
        },
        small: {
            type: Boolean,
            coerce: coerceBoolean,
            default: false
        }
    },
    ready() {
        this.$watch('show', (val) => {
            const el = this.$el
            const body = document.body
            const scrollBarWidth = getScrollBarWidth()
            if (val) {
                el.querySelector('.modal-content').focus()
                el.style.display = 'block'
                setTimeout(() => el.classList.add('in'), 0)
                body.classList.add('modal-open')
                if (scrollBarWidth !== 0) {
                    body.style.paddingRight = scrollBarWidth + 'px'
                }
            } else {
                if (this._blurModalContentEvent) this._blurModalContentEvent.remove()
                el.classList.remove('in')
                setTimeout(() => {
                    el.style.display = 'none'
                    body.classList.remove('modal-open')
                    body.style.paddingRight = '0'
                }, 300)
            }
        }, {
            immediate: true
        })
    },
    methods: {
        close() {
            this.show = false
        }
    }
}
</script>
<style lang="sass" scoped>
.modal {
    transition: all 0.3s ease;
}

.modal.in {
    background-color: rgba(0, 0, 0, 0.5);
}

.modal.zoom .modal-dialog {
    -webkit-transform: scale(0.1);
    -moz-transform: scale(0.1);
    -ms-transform: scale(0.1);
    transform: scale(0.1);
    top: 300px;
    opacity: 0;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    transition: all 0.3s;
}

.modal.zoom.in .modal-dialog {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1);
    -webkit-transform: translate3d(0, -300px, 0);
    transform: translate3d(0, -300px, 0);
    opacity: 1;
}

.modal-content {
    border: 0;
    box-shadow: inherit;
    transform: scale(0.8);
    background-image: url('../assets/images/phoneModal.png');
    background-color: transparent;
}

.modal-body {
    padding-left: 31px;
    padding-top: 119px;
    height: 920px;
}

.closeButton {
    position: absolute;
    margin-top: -165px;
    margin-left: 410px;
    width: 30px;
    color: rgb(52, 56, 60);
    cursor: pointer;
    opacity: .5;
    &:hover {
        opacity: 1;
    }
}
@media (min-width: 768px) {
    .modal-dialog {
        margin: 30px auto;
    }
}
</style>
