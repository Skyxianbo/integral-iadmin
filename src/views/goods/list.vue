<style lang="sass">
.table>tbody>tr>td {
    vertical-align: middle;
}
</style>
<template lang="html">
    <!-- 标题 -->
    <div class="content-title">
        <span class="border-left-orange">查询商品</span>
    </div>
    <!-- 搜索 -->
    <div class="search-panel padding-top-15">
        <form class="form-horizontal">
            <div class="form-group">
                <div class="col-sm-2">
                    <select class="form-control input-sm" v-model="currentSearch.type">
                        <option value="">商品类型</option>
                        <option value="{{$index + 1}}" v-for="type in goodsType">{{type}}</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select class="form-control input-sm" v-model="currentSearch.status">
                        <option value="">请选择</option>
                        <option value="{{$index + 1}}" v-for="status in goodsStatus">{{status}}</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <input class="form-control input-sm" type="text" placeholder="商品标题" v-model="currentSearch.name">
                </div>
                <div class="col-sm-2">
                    <!-- 点击触发筛选函数 -->
                    <button class="btn btn-search" @click.prevent="getList()">筛选</button>
                    <!-- 点击触发重置函数 -->
                    <button class="btn btn-search" @click.prevent="clearCondition()">重置</button>
                </div>
            </div>
        </form>
    </div>
    <!-- 商品列表 -->
    <div class="content-body">
        <table class="table">
            <thead>
                <tr>
                    <!-- 点击触发全选函数 -->
                    <th class="text-center">
                        <input type="checkbox" v-model="allChecked" @click="checkedAll()">
                    </th>
                    <th>商品标题</th>
                    <th>商品类型</th>
                    <th>状态</th>
                    <th>兑换积分</th>
                    <th>库存</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr class="item" v-for="item in productList">
                    <!-- 点击触发选中单条函数 -->
                    <td class="text-center">
                        <input type="checkbox" v-model="item.checked" @click="checked($index)">
                    </td>
                    <td>
                        <a @click.prevent="passParam(routeName[2], item.id)">
                            <img alt="image" :src="item.pic_icon" style="width: 100px;">
                            <span class="margin-left-5">{{item.name}}</span>
                        </a>
                    </td>
                    <td>{{item.type_str}}</td>
                    <td>{{item.status_str}}</td>
                    <td>{{item.integral}}</td>
                    <td>
                        <a @click.prevent="passParam(routeName[0], item.id, item.name)">{{item.stocks}}</a>
                        <a @click.prevent="passParam(routeName[1], item.id, item.name)">导入</a>
                    </td>
                    <td>
                        <a @click.prevent="changeStatus(item)">{{item.operation}}</a>
                        <a @click.prevent="passParam(routeName[2], item.id)">编辑</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- 底部，包含批量上/下架和分页 -->
    <div class="content-footer">
        <div class="pull-left">
            <span>当前选中 {{count}} 条</span>
            <!-- 点击触发批量上架函数 -->
            <button class="btn btn-search margin-left-5" @click.prevent="batchPut(2, goodsStatus[1])">批量上架</button>
            <!-- 点击触发批量下架函数 -->
            <button class="btn btn-search margin-left-5" @click.prevent="batchPut(1, goodsStatus[0])">批量下架</button>
        </div>
        <!-- 引入分页 -->
        <pagination :pagination="pages" :callback="initPagination"></pagination>
    </div>
</template>
<script>
import pagination from '../../components/pagination'; //引入分页组件
import commonApi from '../../libs/commonApi'; //引入封装好的ajax等函数
export default {
    data() {
            return {
                productList: [], //商品列表
                currentSearch: { //筛选条件
                    type: '',
                    status: 2,
                    name: ''
                },
                allChecked: false, //商品是否全选
                goodsType: ['优惠券', '实物', '积分赠送', '谢谢参与'], //商品类型
                goodsStatus: ['下架', '上架'], //商品状态
                routeName: ['couponList', 'importTicket', 'goodsEdit'], //进行路由跳转时的目标路由名称
                pages: {
                    currentPage: 1, //当前页
                    perPage: JST.PERPAGE, //每页显示记录数量
                    total: 0 //总记录数
                },
                count: 0, //当前被选中商品数量
                pagination: false //用于筛选时初始化当前页
            }
        },
        ready() {
            this.getList(); //调用获取列表函数
        },
        methods: {
            //获取商品列表函数
            getList() {
                this.pages.currentPage = this.pagination ? this.pages.currentPage : 1;
                let param = this.currentSearch;
                this.currentSearch.p = this.pages.currentPage;
                this.currentSearch.r = this.pages.perPage;
                this.requestApi("/product/get_list", param, (response) => {
                    if (response.status == JST.SUCCESS) {
                        this.productList = this.initList(response.data.list);
                        this.pages.total = response.data.count;
                        this.pages.currentPage = response.data.p;
                        this.productList.map((x) => {
                            x.operation = x.status_str == "上架" ? "下架" : "上架";
                        })
                    }
                })
            },
            //重置筛选条件函数
            clearCondition() {
                this.currentSearch = {
                        type: '',
                        status: 2,
                        name: ''
                    },
                    this.getList();
            },
            //初始化列表，此处用于给列表中的每个增加'checked'属性
            initList(list) {
                list.map((x) => {
                    x.checked = 0;
                })
                return list;
            },
            //上/下架商品
            changeStatus(item) {
                let status = '',
                    status_str = '';
                item.status == 1 ? ((status = 2) && (status_str = '上架')) : ((status = 1) && (status_str = '下架'));
                this.requestApi("/product/status/" + item.id, {
                    status: status
                }, (response) => {
                    if (response.status == JST.SUCCESS) {
                        layer.msg(`已${status_str}`);
                        this.getList();
                    }
                })
            },
            //选中商品
            checked(index) {
                this.count = 0;
                this.productList[index].checked = !this.productList[index].checked;
                let all = 1;
                this.productList.map((x) => {
                    all = all && x.checked;
                    x.checked == 1 ? this.count++ : '';
                })
                this.allChecked = all;
            },
            //全选商品
            checkedAll() {
                this.count = 0;
                this.productList.map((x) => {
                    x.checked = this.allChecked ? 0 : 1;
                    x.checked == 1 ? this.count++ : '';
                })
            },
            //批量上/下架商品
            batchPut(status, status_str) {
                let id = [];
                this.productList.map((x) => {
                    x.checked ? id.push(x.id) : '';
                })
                this.requestApi("/product/status/" + id, {
                    status: status
                }, (response) => {
                    if (response.status == JST.SUCCESS) {
                        layer.msg("已批量" + status_str);
                        this.getList();
                        this.allChecked = false;
                        window.scrollTo(0, 0);
                    }
                })
            },
            //路由跳转并传递参数
            passParam(name, id, productName) {
                this.$route.router.go({
                    name: name,
                    query: {
                        id: id,
                        productName: productName
                    }
                })
            },
            //初始化分页
            initPagination() {
                this.pagination = true;
                this.getList();
                this.pagination = false;
            }
        },
        components: {
            pagination,
            commonApi
        },
        mixins: [commonApi]
}
</script>
