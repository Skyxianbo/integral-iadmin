<style>
</style>
<template>
    <header class="template-header">
        <slot name="list-header">
            <span>{{title}}</span>
            <button class="btn btn-default" @click.prevent="back()" v-if="goBack"><i class="fa fa-reply"></i> 返回商品列表</button>
        </slot>
    </header>
    <div class="search-form">
        <form class="form-horizontal">
            <div class="form-group" v-if="listTitle">
                <slot name="list-title">
                </slot>
            </div>
            <div class="form-group">
                <slot name="list-search"></slot>
                <div class="col-sm-2">
                    <button class="btn-search" @click.prevent="getList(1)">筛选</button>
                    <button class="btn-search" @click.prevent="clearCondition()">重置</button>
                </div>
                <slot name="list-sortable"></slot>
            </div>
        </form>
    </div>
    <div>
        <slot name="list-table"></slot>
    </div>
    <footer>
        <slot name="list-footer">
            <div class="pull-left" v-if="source == 1">
                <span>当前选中 {{count}} 条</span>
                <button class="btn btn-search" @click.prevent="changeStatus(2)" disabled="{{disabled}}">批量{{buttonName[0]}}</button>
                <button class="btn btn-search" @click.prevent="changeStatus(1)" disabled="{{disabled}}">批量{{buttonName[1]}}</button>
            </div>
            <pagination :pagination="pages" :callback="initPagination" v-if="pages"></pagination>
        </slot>
    </footer>
</template>
<script>
import pagination from './pagination';
export default {
    components: {
        pagination
    },
    props: {
        title: {
            type: String,
            default: ''
        },
        source: {
            type: Number,
            default: 0
        },
        count: {
            type: Number,
            default: 0
        },
        search: {
            type: Object,
            default () {}
        },
        pages: {
            type: Object,
            default () {}
        },
        goBack: {
            type: Boolean,
            default: false
        },
        list: {
            type: Array,
            default () {}
        },
        listTitle: {
            type: Boolean,
            default: false
        },
        type: {
            type: Number,
            default: 0
        }
    },
    computed: {
        disabled: function() {
            let result = this.list.some((x) => {
                return x.checked;
            });
            return !result;
        },
        buttonName: function() {
            if (this.type == 1) {
                return ['上架', '下架'];
            } else if (this.type == 2) {
                return ['启用', '停用'];
            } else if (this.type == 3) {
                return ['确认取货', '确认逾期'];
            } else {
                return ['上线', '下线'];
            }
        }
    },
    data() {
        return {
            pagination: false
        }
    },
    ready() {
        this.getList();
    },
    methods: {
        changeStatus(type) {
            if (this.type == 3 && type == 2) {
                this.$parent.takeProduct();
            } else if (this.type == 3 && type == 1) {
                this.$parent.overtime();
            } else {
                this.$parent.changeStatus(type);
            }
        },
        initPagination() {
            this.$parent.initPagination();
        },
        getList(type) {
            if (this.pages) {
                this.pages.currentPage = this.pagination ? this.pages.currentPage : 1;
                this.search.p = this.pages.currentPage;
                this.search.r = this.pages.perPage;
            }
            this.$parent.getList(type);
        },
        clearCondition() {
            this.$parent.clearCondition();
            this.getList(1);
        },
        initPagination() {
            this.pagination = true;
            this.getList(1);
            this.pagination = false;
        }
    }
}
</script>
