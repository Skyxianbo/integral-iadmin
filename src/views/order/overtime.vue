<style lang="sass" scoped>
</style>
<template lang="html">
    <v-list title="逾期订单" :pages.sync="pages" :search="currentSearch" :list.sync="list">
        <div slot="list-search">
            <div class="col-sm-2 col-lg-1">
                <select class="form-control" v-model="currentSearch.origin_type">
                    <option :value="0">所有来源</option>
                    <option :value="1">坚果互动</option>
                    <option :value="2">电视台</option>
                </select>
            </div>
            <div class="col-sm-4 col-lg-3">
                <input type="text" class="form-control" placeholder="订单编号" v-model="currentSearch.orderid">
            </div>
        </div>
        <div slot="list-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>订单号</th>
                        <th>订单内容</th>
                        <th>订单创建</th>
                        <th>操作逾期</th>
                        <th>状态</th>
                        <th v-if="source == 2">客户</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in list">
                        <td><a @click="routerGo(item.id)">{{item.orderid}}</a></td>
                        <td>{{item.type == 1 ? item.product_type_str : item.activity_type_str}}</td>
                        <td>{{item.create_time}}</td>
                        <td>{{item.close_time}}</td>
                        <td>{{item.status_str}}</td>
                        <td v-if="source == 2">{{item.media_name}}</td>
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
            list: [],
            source: 1,
            count: 0,
            currentSearch: {
                origin_type: 1,
                orderid: ''
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
            this.requestApi('/order/over_list', param, (response) => {
                this.list = response.data.list;
                this.pages.total = response.data.count;
                this.pages.currentPage = response.data.p;
                this.source = param.origin_type;
            })
        },
        clearCondition() {
            this.currentSearch = {
                origin_type: 1,
                orderid: ''
            };
        },
        routerGo(id) {
            this.$route.router.go({
                name: 'orderDetail',
                query: {
                    id: id
                }
            })
        }
    }
}
</script>
