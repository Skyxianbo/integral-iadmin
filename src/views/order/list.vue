<style lang="sass">
.margin-top-4 {
    margin-top: 4px;
}
</style>
<template lang="html">
    <v-list title="查询订单" :pages.sync="pages" :search="currentSearch" :list.sync="orderList">
        <div slot="list-search">
            <div class="col-sm-2 col-lg-1">
                <select class="form-control" v-model="currentSearch.type">
                    <option value="{{$index}}" v-for="type in orderType">{{type}}</option>
                </select>
            </div>
            <div class="col-sm-2 col-lg-1">
                <select class="form-control" v-model="currentSearch.origin_type">
                    <option :value="0">所有来源</option>
                    <option :value="1">坚果互动</option>
                    <option :value="2">电视台</option>
                </select>
            </div>
            <div class="col-sm-3 col-lg-2">
                <input class="form-control" type="text" placeholder="订单ID" v-model="currentSearch.orderid">
            </div>
            <div class="col-sm-3 col-lg-2">
                <input class="form-control" type="text" placeholder="用户昵称" v-model="currentSearch.nickname">
            </div>
            <div class="col-sm-3">
                <div class="col-sm-5">
                    <input type="date" class="form-control" v-model="currentSearch.startdate">
                </div>
                <div class="col-sm-2 text-center margin-top-4">
                    <span>至</span>
                </div>
                <div class="col-sm-5">
                    <input type="date" class="form-control" v-model="currentSearch.enddate">
                </div>
            </div>
        </div>
        <div slot="list-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>订单ID</th>
                        <th>用户昵称</th>
                        <th>订单类型</th>
                        <th>订单来源</th>
                        <th>订单状态</th>
                        <th>订单内容</th>
                        <th>消耗积分</th>
                        <th>时间</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in orderList">
                        <td><a @click="routerGo(item.id)">{{item.orderid}}</a></td>
                        <td>
                            <img alt="image" :src="item.headimg" style="width: 50px;height: 50px;">
                            <span class="margin-left-5">{{item.nickname}}</span>
                        </td>
                        <td>{{item.type_str}}</td>
                        <td>{{item.origin_type_str}}</td>
                        <td>{{item.status_str}}</td>
                        <td>{{item.type == 1 ? item.product_type_str : item.activity_type_str}}</td>
                        <td>{{parseInt(item.integral)}} 积分</td>
                        <td>{{item.create_time}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </v-list>
</template>
<script>
import vList from '../../components/v_list';
export default {
    components: {
        vList
    },
    data() {
        return {
            orderList: [],
            orderType: ['所有类型', '商品', '活动'],
            currentSearch: {
                type: 0,
                orderid: '',
                startdate: '',
                enddate: '',
                nickname: '',
                origin_type: 1,
                status: 0
            },
            pages: {
                currentPage: 1,
                perPage: JST.PERPAGE,
                total: 0
            }
        }
    },
    ready() {
    },
    methods: {
        getList(type) {
            type ? this.layerLoad() : '';
            let param = this.currentSearch;
            this.requestApi("/order/get_list", param, (response) => {
                this.orderList = response.data.list;
                this.pages.total = response.data.count;
                this.pages.currentPage = response.data.p;
            })
        },
        clearCondition() {
            this.currentSearch = {
                type: 0,
                orderid: '',
                startdate: '',
                enddate: '',
                nickname: '',
                origin_type: 1,
                status: 0
            };
        },
        routerGo(id) {
            this.$route.router.go({
                name: "orderDetail",
                query: {
                    id: id
                }
            })
        }
    }
}
</script>
