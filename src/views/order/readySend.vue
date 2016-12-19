<style lang="sass" scoped>
</style>
<template lang="html">
    <v-list title="待发货订单" :pages.sync="pages" :search="currentSearch" :list.sync="unsendList">
        <div slot="list-search">
            <div class="col-sm-2 col-lg-1">
                <select class="form-control" v-model="currentSearch.origin_type">
                    <option :value="0">所有来源</option>
                    <option :value="1">坚果互动</option>
                    <option :value="2">电视台</option>
                </select>
            </div>
            <div class="col-sm-3">
                <input class="form-control" type="text" placeholder="订单ID" v-model="currentSearch.orderid">
            </div>
        </div>
        <div slot="list-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>订单号</th>
                        <th>订单内容</th>
                        <th>收货人</th>
                        <th>手机号码</th>
                        <th>详细地址</th>
                        <th v-if="source == 2">客户</th>
                        <th v-if="source == 1">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in unsendList">
                        <td>
                            <a @click="routerGo(item.id)">{{item.orderid}}</a>
                        </td>
                        <td>{{item.type == 1 ? item.product_type_str : item.activity_type_str}}</td>
                        <td>{{item.contact}}</td>
                        <td>{{item.phone}}</td>
                        <td>{{item.address}}</td>
                        <td v-if="source == 2">{{item.media_name}}</td>
                        <td v-if="source == 1"><a @click="deliver(0, item.id)">发货</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </v-list>
    <modal :show.sync="modalShow" :header="false" :footer="false" :width="500">
        <div slot="modal-body" class="modal-body">
            <h3 class="text-center">发货</h3>
            <div class="margin-top-20 row">
                <label class="col-sm-3 text-right">快递公司：</label>
                <select class="input-sm col-sm-7" v-model="express_company_code">
                    <option value="" selected="true">请选择</option>
                    <option value="{{item.code}}" v-for="item in expressList">{{item.name}}</option>
                </select>
            </div>
            <div class="margin-top-20 row">
                <label class="col-sm-3 text-right">运单号：</label>
                <input type="text" class="input-sm col-sm-7" placeholder="请输入运单号" v-model="express_id">
            </div>
            <div class="text-center margin-bottom-30">
                <button class="btn button-default margin-top-20" @click="deliver(1)">取消</button>
                <button class="btn button-primary margin-top-20 margin-left-20" @click="deliver(2)">确认</button>
            </div>
        </div>
    </modal>
</template>
<script>
import vList from '../../components/v_list';
import modal from '../../components/modal';
export default {
    components: {
        vList,
        modal
    },
    data() {
        return {
            unsendList: [],
            expressList: [],
            currentOrder_id: '',
            express_id: '',
            express_company_code: '',
            source: 1,
            modalShow: false,
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
    ready() {},
    methods: {
        getList(type) {
            type ? this.layerLoad() : '';
            let param = this.currentSearch;
            this.requestApi('/order/unsend_list', param, (response) => {
                this.unsendList = response.data.list;
                this.pages.total = response.data.count;
                this.pages.currentPage = response.data.p;
                this.source = param.origin_type;
            })
        },
        getExpressList() {
            this.requestApi('/order/express_list', {}, (response) => {
                this.expressList = response.data;
            })
        },
        clearCondition() {
            this.currentSearch = {
                origin_type: 1,
                orderid: ''
            };
            this.getList(1);
        },
        deliver(status, id) {
                if (status == 0) {
                    this.modalShow = true;
                    this.currentOrder_id = id;
                    this.getExpressList();
                } else if (status == 1) {
                    this.modalShow = false;
                    this.currentOrder_id = '';
                } else {
                    let param = {
                        express_id: this.express_id,
                        express_company_code: this.express_company_code
                    }
                    this.requestApi('/order/send/' + this.currentOrder_id, param, (response) => {
                        layer.msg("已发货");
                        this.getList();
                    })
                    this.modalShow = false;
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
