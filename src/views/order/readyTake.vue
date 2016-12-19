<style lang="sass" scoped>
</style>
<template lang="html">
    <v-list title="待取货订单" :type="3" :source.sync="source" :count.sync="count" :pages.sync="pages" :search="currentSearch" :list.sync="list">
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
                        <th class="text-center">
                            <input type="checkbox" v-model="allChecked" @click="checkedAll()" v-if="source == 1">
                        </th>
                        <th>订单号</th>
                        <th>订单内容</th>
                        <th>产生时间</th>
                        <th v-if="source == 2">客户</th>
                        <th v-else>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in list">
                        <td class="text-center">
                            <input type="checkbox" v-model="item.checked" @click="checked($index)" v-if="source == 1">
                        </td>
                        <td><a @click="routerGo(item.id)">{{item.orderid}}</a></td>
                        <td>{{item.type == 1 ? item.product_type_str : item.activity_type_str}}</td>
                        <td>{{item.create_time}}</td>
                        <td v-if="source == 2">{{item.media_name}}</td>
                        <td v-else>
                            <a @click="takeProduct(item.id)">取货</a>
                            <a class="margin-left-10" @click="overtime(item.id)">逾期</a>
                        </td>
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
            allChecked: false,
            currentSearch: {
                origin_type: 1,
                orderid: '',
                startdate: '',
                enddate: ''
            },
            pages: {
                currentPage: 1,
                perPage: JST.PERPAGE,
                total: 0
            }
        }
    },
    ready() {},
    methods: {
        getList(type) {
            type ? this.layerLoad() : '';
            let param = this.currentSearch;
            this.requestApi('/order/take_list', param, (response) => {
                this.list = this.initList(response.data.list);
                this.pages.total = response.data.count;
                this.pages.currentPage = response.data.p;
                this.source = param.origin_type;
                this.allChecked = false;
                this.count = 0;
                window.scrollTo(0, 0);
            })
        },
        clearCondition() {
            this.currentSearch = {
                origin_type: 1,
                orderid: '',
                startdate: '',
                enddate: ''
            };
        },
        checked(index) {
            this.count = 0;
            this.list[index].checked = !this.list[index].checked;
            let all = 1;
            this.list.forEach((x) => {
                all = all && x.checked;
                x.checked == 1 ? this.count++ : '';
            })
            this.allChecked = all;
        },
        checkedAll() {
            this.count = 0;
            this.list.forEach((x) => {
                x.checked = this.allChecked ? 0 : 1;
                x.checked == 1 ? this.count++ : '';
            })
        },
        takeProduct(id) {
            if (id) {
                layer.msg(`确认取货吗？`, {
                    time: 0,
                    shade: 0.2,
                    shadeClose: true,
                    btn: ['确定', '取消'],
                    yes: (index) => {
                        layer.close(index);
                        this.requestApi('/order/take/' + id, {}, (response) => {
                            layer.msg(`操作成功，已确认取货1个订单`);
                            this.getList();
                        })
                    }
                });
            } else {
                layer.msg(`确定批量确认取货吗？`, {
                    time: 0,
                    shade: 0.2,
                    shadeClose: true,
                    btn: ['确定', '取消'],
                    yes: (index) => {
                        layer.close(index);
                        let id = [];
                        this.list.forEach((x) => {
                            x.checked ? id.push(x.id) : '';
                        });
                        this.requestApi('/order/take/' + id, {}, (response) => {
                            layer.msg(`操作成功，已确认取货${id.length}个订单`);
                            this.getList();
                        })
                    }
                });
            }
        },
        overtime(id) {
            if (id) {
                layer.msg(`确认逾期吗？`, {
                    time: 0,
                    shade: 0.2,
                    shadeClose: true,
                    btn: ['确定', '取消'],
                    yes: (index) => {
                        layer.close(index);
                        this.requestApi('/order/over/' + id, {}, (response) => {
                            layer.msg(`操作成功，已确认逾期1个订单`);
                            this.getList();
                        })
                    }
                });
            } else {
                layer.msg(`确定批量确认逾期吗？`, {
                    time: 0,
                    shade: 0.2,
                    shadeClose: true,
                    btn: ['确定', '取消'],
                    yes: (index) => {
                        layer.close(index);
                        let id = [];
                        this.list.forEach((x) => {
                            x.checked ? id.push(x.id) : '';
                        });
                        this.requestApi('/order/over/' + id, {}, (response) => {
                            layer.msg(`操作成功，已确认逾期${id.length}个订单`);
                            this.getList();
                        })
                    }
                });
            }
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
