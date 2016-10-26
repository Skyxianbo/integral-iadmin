<style lang="sass">
</style>
<template lang="html">
    <!-- 标题 -->
    <div class="content-title">
        <span class="border-left-orange">查询订单</span>
    </div>
    <!-- 搜索框开始 -->
    <div class="search-panel padding-top-15">
        <form class="form-horizontal">
            <div class="form-group">
                <div class="col-sm-2">
                    <select class="form-control input-sm" v-model="currentSearch.type">
                        <option value="">订单类型</option>
                        <option value="{{$index + 1}}" v-for="type in orderType">{{type}}</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input class="form-control input-sm" type="text" placeholder="订单ID" v-model="currentSearch.orderid">
                </div>
                <div class="col-sm-3">
                    <input class="form-control input-sm" type="text" placeholder="用户昵称" v-model="currentSearch.nickname">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <input class="form-control input-sm" type="date" v-model="currentSearch.startdate">
                </div>
                <div class="col-sm-1 text-center">
                    <span>至</span>
                </div>
                <div class="col-sm-2">
                    <input class="form-control input-sm" type="date" v-model="currentSearch.enddate">
                </div>
                <div class="col-sm-3 text-right">
                    <!-- 点击时触发获取列表函数 -->
                    <button class="btn btn-search" @click.prevent="getList()">筛选</button>
                    <!-- 点击时触发重置函数 -->
                    <button class="btn btn-search margin-left-20" @click.prevent="clearCondition()">重置</button>
                </div>
            </div>
        </form>
    </div>
    <!-- 列表table -->
    <div class="content-body">
        <table class="table margin-top-20">
            <thead>
                <tr>
                    <th>订单ID</th>
                    <th>用户昵称</th>
                    <th>订单类型</th>
                    <th>订单内容</th>
                    <th>消耗积分</th>
                    <th>时间</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in orderList">
                    <td>{{item.orderid}}</td>
                    <td>
                        <img alt="image" :src="item.headimg" style="width: 50px;height: 50px;">
                        <span class="margin-left-5">{{item.nickname}}</span>
                    </td>
                    <td>{{item.type_str}}</td>
                    <td>{{item.type == 1 ? item.product_type_str : item.activity_type_str}}</td>
                    <td>{{item.integral}}</td>
                    <td>{{item.date}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- 引入分页 -->
    <pagination :pagination="pages" :callback="initPagination"></pagination>
</template>
<script>
import pagination from '../../components/pagination'; //引入分页组件
export default {
    data() {
            return {
                orderList: [], //订单列表
                currentSearch: { //筛选条件
                    type: '',
                    orderid: '',
                    username: '',
                    startdate: '',
                    enddate: ''
                },
                orderType: ['商品', '活动'], //订单类型
                pagination: false, //用于筛选时初始化当前页
                pages: {
                    currentPage: 1, //当前页
                    perPage: JST.PERPAGE, //每页显示记录数量
                    total: 0 //总记录数
                }
            }
        },
        ready() {
            this.getList(); //调用获取列表函数
        },
        methods: {
            // 获取列表函数
            getList() {
                this.pages.currentPage = this.pagination ? this.pages.currentPage : 1;
                let param = this.currentSearch;
                this.currentSearch.p = this.pages.currentPage;
                this.currentSearch.r = this.pages.perPage;
                this.requestApi("/order/get_list", param, (response) => {
                    if (response.status == JST.SUCCESS) {
                        this.orderList = response.data.list;
                        this.pages.total = response.data.count;
                        this.pages.currentPage = response.data.p;
                    } else {
                        layer.msg(response.info);
                    }
                })
            },
            // 重置函数
            clearCondition() {
                this.currentSearch = {
                    type: '',
                    orderid: '',
                    username: '',
                    startdate: '',
                    enddate: ''
                };
                this.getList();
            },
            // 分页初始化
            initPagination() {
                this.pagination = true;
                this.getList();
                this.pagination = false;
            }
        },
        components: {
            pagination  //引入分页组件
        }
}
</script>
