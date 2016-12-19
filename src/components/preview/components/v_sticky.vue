<style lang='sass' scoped>
@import '../assets/scss/variable.scss';
.v-sticky {
    position:absolute;
    bottom: 0;
    left: 0;
    right: 0;
    border-top: 1px solid $gray-light;
}
</style>
<template>
    <div class='v-sticky bg-white'>
        <slot></slot>
    </div>
</template>
<script>
export default {

    name: 'v-sticky',

    data() {
        return {

        };
    }
};
</script>
