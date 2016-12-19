<!--
pagination components  分页控件
==============================================
params:
    pagination{
        currentPage, //当前页
        perPage,     //每页记录数
        total        //总条数
    },
    callback(page)   //跳转回调函数 返回当前页
==============================================
-->
<template>
    <div>
        <nav class="pull-right">
            <ul class="pagination ">
                <li v-if="pagination.currentPage > 1">
                    <a aria-label="Previous" @click.prevent="changePage(1)">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li v-for="num in indexs" :class="{'active': num == pagination.currentPage}">
                    <a @click.prevent="changePage(num)">{{num}}</a>
                </li>
                <li v-if="pagination.currentPage < lastPage">
                    <a  aria-label="Next" @click.prevent="changePage(lastPage)">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li><span><input type="text" class="text-center" v-model="current" @keyup.enter="submit">&nbsp/{{lastPage}}页</span></li>
                <li><a> <span>共{{pagination.total}}条，每页{{pagination.perPage}}条 </span></a></li>
            </ul>
        </nav>
    </div>
</template>
<script>
    export default{
        props: {
            pagination: {
                type: Object,
                required: true
            },
            callback: {
                type: Function,
                required: true
            }
        },
        data(){
            return {
                current: this.pagination.currentPage //为了防止pagination.currentPage与input绑定
            }
        },
        ready(){
        },
        computed: {
            lastPage: function(){
                var last = Math.floor(this.pagination.total / this.pagination.perPage);
                if(this.pagination.total % this.pagination.perPage !== 0){
                    last = last + 1;
                }
                return last;
            },
            indexs: function(){
                var last = this.lastPage;
                var left = 1;
                var right = last;
                var ar = [];
                if(last >= 9){
                    if(this.pagination.currentPage > 4 && this.pagination.currentPage < last - 4){
                            left = this.pagination.currentPage - 4;
                            right = this.pagination.currentPage + 3;
                    }else{
                        if(this.pagination.currentPage <= 4){
                                left = 1;
                                right = 8;
                            }else{
                                right = last;
                                left = last - 7;
                            }
                        }
                }
                while (left <= right){
                    ar.push(left);
                    left ++;
                }
                return ar;
            }
        },
        watch: {
            'pagination.currentPage': function () {
                this.current = this.pagination.currentPage;
                window.scrollTo(0,0);
            }
        },
        methods: {
            //回调父模板跳转函数
            changePage: function (page) {
                if(this.pagination.currentPage != page){
                    this.pagination.currentPage = page;
                    this.current = page;
                    this.callback(page);
                }
            },
            //输入框提交跳转页
            submit: function() {
                if( Math.floor(this.current) == this.current ){ //输入的是整数
                    var page = Math.floor(this.current);
                    if( page === this.pagination.currentPage || page < 1 || page > this.lastPage){
                        return;
                    }
                    this.changePage(page);
                }else{
                    layer.msg("请输入整数");
                }
            }
        }
    }
</script>
<style lang="sass" scoped>
    .pagination input{
        width: 30px;
        height: 20px;
        border:1px solid #ddd;
    }
</style>
