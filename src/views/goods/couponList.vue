<style lang="sass">
</style>
<template lang="html">
    <!-- 标题 -->
    <div class="content-title">
        <span class="border-left-orange">查看券码</span>
        <!-- 点击按钮触发返回函数 -->
        <button class="btn btn-default margin-left-10" @click.prevent="back()">返回商品列表</button>
    </div>
    <!-- 搜索 -->
    <div class="search-panel">
        <form class="form-horizontal">
            <div class="form-group">
                <div class="col-sm-3">
                    <label>商品名称<span class="margin-left-20">{{productName}}</span></label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <select class="form-control input-sm" v-model="currentSearch.status">
                        <option value="">请选择</option>
                        <option value="{{$index + 1}}" v-for="item in status">{{item}}</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input class="form-control input-sm" type="text" placeholder="请输入券码" v-model="currentSearch.ticket_id">
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
    <!-- 优惠券列表 -->
    <div class="content-body">
        <table class="table margin-top-20">
            <thead>
                <tr>
                    <!-- 点击触发全选函数 -->
                    <th class="text-center">
                        <input type="checkbox" v-model="allChecked" @click="checkedAll()">
                    </th>
                    <th>ID</th>
                    <th>券码</th>
                    <th>密码</th>
                    <th>状态</th>
                    <th>昵称</th>
                    <th>领取时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in ticketList">
                    <!-- 点击触发选择单条函数 -->
                    <td class="text-center">
                        <input type="checkbox" v-model="item.checked" @click="checked($index)">
                    </td>
                    <td>{{item.id}}</td>
                    <td>{{item.ticket_id}}</td>
                    <td>{{item.key}}</td>
                    <td>{{item.status_str}}</td>
                    <td>{{item.nickname}}</td>
                    <td>{{item.used_date}}</td>
                    <td>
                        <!-- 点击触发删除函数 -->
                        <a @click.prevent="deleteTicket(item.id)">删除</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- 底部，包含批量上/下架和分页 -->
    <div class="content-footer">
        <div class="pull-left">
            <span>当前选中 {{count}} 条</span>
            <!-- 点击按钮触发批量删除函数 -->
            <button class="btn btn-search margin-left-5" @click.prevent="deleteChecked()">批量删除</button>
        </div>
        <!-- 引入分页 -->
        <pagination :pagination="pages" :callback="initPagination"></pagination>
    </div>
</template>
<script>
import pagination from '../../components/pagination'; //引入分页组件
export default {
    data() {
            return {
                productId: '', //当前优惠券所属商品的ID
                productName: '', //当前优惠券所属商品的名称
                status: ['未使用', '已使用'], //优惠券状态
                allChecked: false, //优惠券是否全选
                count: 0, //当前被选中记录
                ticketList: { //优惠券列表
                    id: '',
                    ticket_id: '',
                    key: '',
                    status: '',
                    status_str: '',
                    user_id: '',
                    create_time: ''
                },
                currentSearch: { //筛选条件
                    status: '',
                    ticket_id: ''
                },
                pages: {
                    currentPage: 1, //当前页
                    perPage: JST.PERPAGE, //每页显示记录数量
                    total: 0 //总记录数
                },
                pagination: false //用于筛选时初始化当前页
            }
        },
        route: {
            data(transition) {
                //接收路由传递的参数
                if (transition.to.query.id) {
                    this.productId = transition.to.query.id;
                    this.productName = transition.to.query.productName;
                } else {
                    this.productId = '';
                }
            }
        },
        ready() {
            this.getList(); //调用获取列表函数
        },
        methods: {
            //获取列表函数
            getList() {
                this.pages.currentPage = this.pagination ? this.pages.currentPage : 1;
                let param = this.currentSearch;
                this.currentSearch.p = this.pages.currentPage;
                this.currentSearch.r = this.pages.perPage;
                this.requestApi("/product/ticket_list/" + this.productId, param, (response) => {
                    if (response.status == JST.SUCCESS) {
                        this.ticketList = this.initList(response.data.list);
                        this.pages.total = response.data.count;
                        this.pages.currentPage = response.data.p;
                    } else {
                        layer.msg(response.info);
                    }
                })
            },
            //重置筛选条件函数
            clearCondition() {
                this.currentSearch = {
                        status: '',
                        ticket_id: ''
                    },
                    this.getList();
            },
            //删除优惠券
            deleteTicket(id) {
                this.requestApi("/product/delete_ticket/" + id, {}, (response) => {
                    if (response.status == JST.SUCCESS) {
                        layer.msg("该条记录已删除");
                        this.getList();
                    } else {
                        layer.msg(response.info);
                    }
                })
            },
            //删除选中
            deleteChecked() {
                let id = [];
                this.ticketList.map((x) => {
                    x.checked ? id.push(x.id) : '';
                })
                this.requestApi("/product/delete_ticket/" + id, {}, (response) => {
                    if (response.status == JST.SUCCESS) {
                        layer.msg("该条记录已删除");
                        this.getList();
                    } else {
                        layer.msg(response.info);
                    }
                })
            },
            //全选函数
            checkedAll() {
                this.count = 0;
                this.ticketList.map((x) => {
                    x.checked = this.allChecked ? 0 : 1;
                    x.checked == 1 ? this.count++ : '';
                })
            },
            // 选择单条记录函数
            checked(index) {
                this.count = 0;
                this.ticketList[index].checked = !this.ticketList[index].checked;
                let all = 1;
                this.ticketList.map((x) => {
                    all = all && x.checked;
                    x.checked == 1 ? this.count++ : '';
                })
                this.allChecked = all;
            },
            //初始化列表，此处用于给列表中的每个增加'checked'属性
            initList(list) {
                list.map((x) => {
                    x.checked = 0;
                })
                return list;
            },
            //初始化分页函数
            initPagination() {
                this.pagination = true;
                this.getList();
                this.pagination = false;
            },
            //返回函数
            back() {
                history.go(-1);
            }
        },
        components: {
            pagination //引入分页组件
        }
}
</script>
