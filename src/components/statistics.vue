<style lang="sass">

@import "../assets/css/variables.scss";
.statistics {
    .statistics-header {
        display:flex;
        align-items:center;
        justify-content: space-between;
        height: 50px;
        padding: 0 15px;
        background: $bg-color;
        border-bottom: 1px solid $gray-lighter;
        font-size: $font-size-lg;

        .title {
            border-left: 3px solid $orange;
            padding-left: 10px;
        }
        .header-main{
          display:flex;
          align-items:center;
          >*{
            margin-left:5px;
          }
        }
    }
}

</style>

<template lang="html">

<div class="statistics margin-top-20">
    <div class="statistics-header">
        <b class="title">
               {{title||"标题"}}
            </b>
        <slot name="header-main">
        </slot>
    </div>
    <slot name="statistics-content">
    </slot>

</div>

</template>

<script>

export default {
    props: ["title"]
}

</script>
