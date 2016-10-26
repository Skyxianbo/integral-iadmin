<style lang="sass">
</style>
<template lang="html">
    <!-- 标题 -->
    <div class="content-title">
        <span class="border-left-orange">活动参与情况</span>
        <!-- 点击触发返回函数 -->
        <button class="btn btn-default margin-left-10" @click.prevent="back()">返回活动列表</button>
    </div>
    <!-- 搜索框 -->
    <div class="search-panel">
        <form class="form-horizontal">
            <div class="form-group">
                <div class="col-sm-3">
                    <label>
                        活动标题
                        <span class="margin-left-20">{{activityName}}</span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <input class="form-control input-sm" type="date" v-model="currentSearch.start_date">
                </div>
                <div class="col-sm-1 text-center">
                    <span>至</span>
                </div>
                <div class="col-sm-2">
                    <input class="form-control input-sm" type="date" v-model="currentSearch.end_date">
                </div>
                <div class="col-sm-2">
                    <select class="form-control input-sm" v-model="currentSearch.is_win">
                        <option value="">中奖情况</option>
                        <option value="{{$index + 1}}" v-for="type in status">{{type}}</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <!-- 点击触发筛选函数 -->
                    <button class="btn btn-search" @click.prevent="getList()">筛选</button>
                    <!-- 点击触发重置函数 -->
                    <button class="btn btn-search" @click.prevent="clearCondition()">重置</button>
                </div>
            </div>
        </form>
    </div>
    <div class="content-body">
        <table class="table margin-top-20">
            <thead>
                <tr>
                    <th>订单ID</th>
                    <th>昵称</th>
                    <th>参与时间</th>
                    <th>奖品</th>
                    <th>状态</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in participationList">
                    <td>{{item.id}}</td>
                    <td>
                        <img alt="image" :src="item.headimg" style="width: 50px;height: 50px;">
                        <span class="margin-left-5">{{item.nickname}}</span>
                    </td>
                    <td>{{item.create_time}}</td>
                    <td>{{item.product_name}}</td>
                    <td>{{item.is_win_str}}</td>
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
                participationList: [], //参与情况列表
                activityId: '', //接收路由传入的活动ID
                activityName: '', //接收路由传入的活动名称
                currentSearch: { //筛选条件
                    start_date: '',
                    end_date: '',
                    is_win: ''
                },
                pages: {
                    currentPage: 1, //当前页
                    perPage: JST.PERPAGE, //每页显示记录数量
                    total: 0 //总记录数
                },
                status: ["中奖", "未中奖"],
                pagination: false //用于筛选时初始化当前页
            }
        },
        route: {
            data(transition) {
                // 接收路由传递的参数
                if (transition.to.query.id) {
                    this.activityId = transition.to.query.id;
                    this.activityName = transition.to.query.activityName;
                } else {
                    this.activityId = '';
                    this.activityName = '';
                }
            }
        },
        ready() {
            this.getList(); //获取列表
        },
        methods: {
            // 获取列表函数
            getList() {
                this.pages.currentPage = this.pagination ? this.pages.currentPage : 1;
                this.currentSearch.p = this.pages.currentPage;
                this.currentSearch.r = this.pages.perPage;
                this.requestApi("/activity/play_list/" + this.activityId, this.currentSearch, (response) => {
                    if (response.status == JST.SUCCESS) {
                        this.participationList = response.data.list;
                        this.pages.total = response.data.count;
                        this.pages.currentPage = response.data.p;
                    } else {
                        layer.msg(response.info);
                    }
                })
            },
            // 初始化分页函数
            initPagination() {
                this.pagination = true;
                this.getList();
                this.pagination = false;
            },
            // 重置函数
            clearCondition() {
                this.currentSearch = {
                    start_date: '',
                    end_date: '',
                    is_win: ''
                };
                this.getList();
            },
            // 返回函数
            back() {
                history.go(-1);
            }
        },
        components: {
            pagination
        }
}
</script>
