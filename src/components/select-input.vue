<style lang="sass">
.combo-select {
  position: relative;
  max-width: 400px;
  margin-bottom: 15px;
  font: 100% Helvetica, Arial, Sans-serif;
  border: 1px #ccc solid;
  border-radius: 3px;
}

/** Input field **/
.combo-input {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  margin: 0;
  text-overflow: ellipsis;
  white-space: nowrap;
  border: none;
  width: 100%;
  box-sizing: border-box;
  padding: 12px;
  padding-right: 60px;
  border-radius: 3px;
}
.combo-input:focus { outline: none; }

/** Option item **/
.option-item {
  cursor: pointer;
  border-bottom: 1px #e3e3e3 solid;
}
.option-item:hover {
  background-color: #006eab;
  color: #fff;
}
.option-item:last-child { border-bottom: none; }

/** Dropdown **/
.combo-dropdown {
  position: absolute;
  z-index: 1;
  top: 100%;
  left: 0;
  min-width: 100%;
  max-width: 300px;
  max-height: 300px;
  margin: 0;
  padding: 0;
  display: none;
  overflow-y: auto;
  background: #fff;
  border: 1px solid #999999;
  border-radius: 0;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
  box-sizing: border-box;
}
.combo-dropdown li {
  list-style: none;
  padding: 8px 1em;
  margin: 0;
}


</style>
<template lang="html">
<div>
    <slot name="select-input">
        <div class="combo-select">
            <input class="combo-input input-sm" type="text" placeholder="请选择" @focus="onfocus()" v-model="inputValue">
            <ul class="combo-dropdown">
                <li class="option-item" data-index="1" track-by="$index" v-for="item in options | filterBy inputValue in 'name'" @click="setValue(item)">{{item.name}}</li>
            </ul>
        </div>
    </slot>
</div>
</template>
<script>
export default {
    props: {
        options: {
            type: Array,
            default: []
        },
        returnValue: {
            default: ''
        },
        inputValue: {
            type: String,
            default: ''
        },
        currentProduct: {
          type: Object,
          default: {}
        }
    },
    data() {
        return {
            show: true
        }
    },
    ready() {
    },
    methods: {
        onfocus() {
            $(".combo-dropdown").css("display", "block");
        },
        setValue(item) {
            this.currentProduct = item;
            this.inputValue = item.name;
            this.returnValue = item.id;
            $(".combo-dropdown").css("display", "none");
        }
    }
}
</script>