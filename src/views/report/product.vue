<style lang="sass">
</style>
<template lang="html">
    <v-list title="商品统计" :pages.sync="pages" :search="currentSearch">
        <div slot="list-search">
            <div class="col-sm-2 col-lg-1">
                    <select class="form-control" v-model="currentSearch.type">
                        <option value="">所有类型</option>
                        <option value="1">优惠券(券码)</option>
                        <option value="5">优惠券(链接)</option>
                        <option value="2">实物</option>
                        <option value="3">积分赠送</option>
                    </select>
                </div>
                <div class="col-sm-2 col-lg-1">
                    <select class="form-control" v-model="currentSearch.origin_type">
                        <option value="{{$index}}" v-for="origin_type in origin_types">{{origin_type}}</option>
                    </select>
                </div>
                <div class="col-sm-2 col-lg-1">
                    <select class="form-control" v-model="currentSearch.status">
                        <option value="{{$index}}" v-for="s in status">{{s}}</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input class="form-control" type="text" placeholder="商品标题" v-model="currentSearch.name">
                </div>
        </div>
        <div slot="list-table">
            <table class="table">
            <thead>
                <tr>
                    <th>商品标题</th>
                    <th>商品来源</th>
                    <th>状态</th>
                    <th>商品类型</th>
                    <th>UV</th>
                    <th>PV</th>
                    <th>兑换次数</th>
                    <th>兑换人次</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr class="item" v-for="item in list">
                    <td>
                        <a @click="routerGo(routerName, item.id)">
                            <img :src="item.pic_icon" alt="image">
                            <span class="margin-left-5">{{item.name}}</span>
                        </a>
                    </td>
                    <td>{{item.origin_type_str}}</td>
                    <td>{{item.status_str}}</td>
                    <td>{{item.type_str}}</td>
                    <td>{{item.uv}}</td>
                    <td>{{item.pv}}</td>
                    <td>{{item.used_count}}</td>
                    <td>{{item.used_count_u}}</td>
                    <td>
                        <a @click="routerGo(routerName, item.id)">查看</a>
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
            routerName: 'productDetail',
            pagination: false, 
            origin_types: ["所有来源", "坚果互动", "电视台"],
            status: ["所有状态", "下架", "上架"],
            currentSearch: {
                type: '',
                origin_type: 0,
                status: 0,
                name: ''
            },
            pages: {
                currentPage: 1, 
                perPage: JST.PERPAGE, 
                total: 0 
            }
        }
    },
    ready() {
        this.getList();
    },
    methods: {
        getList(type) {
            type ? this.layerLoad() : '';
            let param = this.currentSearch;
            this.requestApi('/product/get_list', param, (response) => {
                this.list = response.data.list;
                this.pages.total = response.data.count;
                this.pages.currentPage = response.data.p;
            })
        },
        clearCondition() {
            this.currentSearch = {
                type: '',
                origin_type: 0,
                status: 0,
                name: ''
            };
        },
        routerGo(name, id) {
            this.$route.router.go({
                name: name,
                query: {
                    product_id: id
                }
            })
        }
    }
}
</script>
