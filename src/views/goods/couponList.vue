<style lang="sass">
</style>
<template lang="html">
    <v-list title="查看券码" :search="currentSearch">
        <div slot="list-title">
            <div class="col-sm-3">
                <label>商品名称<span class="margin-left-20">{{productName}}</span></label>
            </div>
        </div>
        <div slot="list-search">
            <div class="col-sm-3">
                <input class="form-control" type="text" placeholder="请输入券码" v-model="currentSearch.ticket_id">
            </div>
        </div>
        <div slot="list-table">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">
                            <input type="checkbox" v-model="allChecked" @click="checkedAll()">
                        </th>
                        <th>ID</th>
                        <th>券码</th>
                        <th>密码</th>
                        <th>状态</th>
                        <th>用户ID</th>
                        <th>领取时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in ticketList">
                        <td class="text-center">
                            <input type="checkbox" v-model="item.checked" @click="checked($index)">
                        </td>
                        <td>{{item.id}}</td>
                        <td>{{item.ticket_id}}</td>
                        <td>{{item.key}}</td>
                        <td>{{item.status_str}}</td>
                        <td>{{item.user_id}}</td>
                        <td>{{item.used_date}}</td>
                        <td>
                            <a @click.prevent="deleteTicket(0, item.id)">删除</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div slot="list-footer">
            <div class="pull-left">
                <span>当前选中 {{count}} 条</span>
                <button class="btn btn-search" @click.prevent="deleteTicket(1)" disabled="{{disabled}}">批量删除</button>
            </div>
            <pagination :pagination="pages" :callback="initPagination"></pagination>
        </div>
    </v-list>
</template>
<script>
import vList from '../../components/v_list';
import pagination from '../../components/pagination';
export default {
    components: {
        vList,
        pagination
    },
    computed: {
        disabled: function() {
            let result = this.ticketList.some((x) => {
                return x.checked;
            });
            return !result;
        }
    },
    data() {
        return {
            productId: '',
            productName: '',
            ticketList: [],
            count: 0,
            allChecked: false,
            pagination: false,
            currentSearch: {
                status: '',
                ticket_id: ''
            },
            pages: {
                currentPage: 1,
                perPage: JST.PERPAGE,
                total: 0
            }
        }
    },
    route: {
        data(transition) {
            if (transition.to.query.id) {
                this.productId = transition.to.query.id;
                this.productName = transition.to.query.productName;
            } else {
                this.productId = '';
            }
        }
    },
    ready() {},
    methods: {
        getList(type) {
            type ? this.layerLoad() : '';
            this.pages.currentPage = this.pagination ? this.pages.currentPage : 1;
            this.currentSearch.p = this.pages.currentPage;
            this.currentSearch.r = this.pages.perPage;
            let param = this.currentSearch;
            this.requestApi("/product/ticket_list/" + this.productId, param, (response) => {
                this.ticketList = this.initList(response.data.list);
                this.pages.total = response.data.count;
                this.pages.currentPage = response.data.p;
                this.count = 0;
                this.allChecked = false;
            })
        },
        clearCondition() {
            this.currentSearch = {
                status: '',
                ticket_id: ''
            };
        },
        deleteTicket(type, id) {
            let ids = [],
                str = '';
            if (type == 0) {
                ids.push(id);
                str = '确定删除该优惠券吗？';
            } else {
                this.ticketList.forEach((x) => {
                    x.checked ? ids.push(x.id) : '';
                });
                str = '确定批量删除选中优惠券吗？';
            };
            layer.msg(str, {
                time: 0,
                shade: 0.2,
                shadeClose: true,
                btn: ['确定', '取消'],
                yes: (index) => {
                    layer.close(index);
                    this.requestApi("/product/delete_ticket/" + ids, {}, (response) => {
                        layer.msg(`操作成功，已删除${ids.length}条优惠券`);
                        this.getList();
                    })
                }
            });
        },
        checkedAll() {
            this.count = 0;
            this.ticketList.forEach((x) => {
                x.checked = this.allChecked ? 0 : 1;
                x.checked == 1 ? this.count++ : '';
            })
        },
        checked(index) {
            this.count = 0;
            this.ticketList[index].checked = !this.ticketList[index].checked;
            let all = 1;
            this.ticketList.forEach((x) => {
                all = all && x.checked;
                x.checked == 1 ? this.count++ : '';
            })
            this.allChecked = all;
        },
        initPagination() {
            this.pagination = true;
            this.getList(1);
            this.pagination = false;
        }
    }
}
</script>
