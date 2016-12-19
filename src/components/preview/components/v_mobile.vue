<style lang='sass'>
@import '../assets/scss/main.scss';
.v-mobile {
    position: relative;
    width: pxTorem(750);
    height: pxTorem(1334);
    border: 1px solid $gray-light;
}
</style>
<template>
    <div class='v-mobile'>
        <slot></slot>
    </div>
</template>
