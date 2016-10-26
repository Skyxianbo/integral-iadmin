<style lang="sass">
.table-footer button {
    padding: 0 5px;
    font-size: 12px;
    border-radius: 5px;
}
</style>
<template lang="html">
    <!-- 标题 -->
    <div class="content-title">
        <span class="border-left-orange">查询商品</span>
    </div>
    <!-- 搜索框 -->
    <div class="search-panel padding-top-15">
        <form class="form-horizontal">
            <div class="form-group">
                <div class="col-sm-2">
                    <select class="form-control input-sm" v-model="currentSearch.type">
                        <option value="">活动类型</option>
                        <option value="{{$index + 1}}" v-for="type in activityType">{{type}}</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select class="form-control input-sm" v-model="currentSearch.status">
                        <option value="{{$index + 1}}" v-for="status in activityStatus">{{status}}</option>
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
    <div class="content-body">
        <table class="table">
            <thead>
                <tr>
                    <!-- 点击触发全选函数 -->
                    <th class="text-center">
                        <input type="checkbox" v-model="allChecked" @click="checkedAll()">
                    </th>
                    <th>活动标题</th>
                    <th>状态</th>
                    <th>活动类型</th>
                    <th>参与记录</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr class="item" v-for="item in activityList">
                    <!-- 点击触发选中单条函数 -->
                    <td class="text-center">
                        <input type="checkbox" v-model="item.checked" @click="checked($index)">
                    </td>
                    <td>
                        <!-- 点击跳转至编辑页面并传送当前活动ID -->
                        <a @click.prevent="passParam(routeName[1], item.id)">
                            <img alt="image" :src="item.pic_icon" style="width: 100px;">
                            <span class="margin-left-5">{{item.name}}</span>
                        </a>
                    </td>
                    <td>{{item.status_str}}</td>
                    <td>{{item.type_str}}</td>
                    <!-- 点击跳转至参与记录页面并传递当前活动名称 -->
                    <td>
                        <a @click.prevent="passParam(routeName[0], item.id, item.name)">{{item.play_count}}</a>
                    </td>
                    <td>
                        <!-- 点击触发上/下架函数，更改上/下架状态 -->
                        <a @click.prevent="changeStatus(item)">{{item.operation}}</a>
                        <!-- 点击跳转至编辑页面并传送当前活动ID -->
                        <a @click.prevent="passParam(routeName[1], item.id)">编辑</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- 底部，包含批量上/下架以及分页 -->
    <div class="content-footer">
        <div class="pull-left">
            <span>当前选中 {{count}} 条</span>
            <!-- 点击触发批量上架函数 -->
            <button class="btn btn-search margin-left-5" @click.prevent="batchPut(2, activityStatus[1])">批量上架</button>
            <!-- 点击触发批量下架函数 -->
            <button class="btn btn-search margin-left-5" @click.prevent="batchPut(1, activityStatus[0])">批量下架</button>
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
                activityList: { //活动列表
                    operation: ''
                },
                currentSearch: { //筛选条件
                    type: '',
                    status: 2,
                    name: ''
                },
                allChecked: false, //是否全选
                activityType: ['刮刮卡', '有奖问答'], //活动类型
                activityStatus: ['已关闭', '进行中'], //活动状态
                routeName: ['participation', 'activityEdit'], //路由名称
                pages: {
                    currentPage: 1, //当前页
                    perPage: JST.PERPAGE, //每页显示记录数量
                    total: 0 //总记录数
                },
                count: 0, //当前被选中数量
                pagination: false //用于筛选时初始化当前页
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
                this.requestApi("/activity/get_list", param, (response) => {
                    if (response.status == JST.SUCCESS) {
                        this.activityList = this.initList(response.data.list);
                        this.pages.total = response.data.count;
                        this.pages.currentPage = response.data.p;
                        for (var item in this.activityList) {
                            if (this.activityList[item].status == 1) {
                                this.activityList[item].operation = "上架";
                            } else {
                                this.activityList[item].operation = "下架";
                            }
                        }
                    }
                })
            },
            // 重置函数
            clearCondition() {
                this.currentSearch = {
                        type: '',
                        status: 2,
                        name: ''
                    },
                    this.getList();
            },
            // 初始化列表函数，为列表添加checked属性
            initList(list) {
                for (var i = 0, l = list.length; i < l; i++) {
                    list[i].checked = 0;
                }
                return list;
            },
            // 上/下架函数，更改当前记录状态
            changeStatus(item) {
                var status = '';
                let status_str = '';
                if (item.status == 1) {
                    status = 2;
                    status_str = '上架';
                } else {
                    status = 1;
                    status_str = '下架';
                }
                this.requestApi("/activity/status/" + item.id, {
                    status: status
                }, (response) => {
                    if (response.status == JST.SUCCESS) {
                        layer.msg(`已${status_str}`);
                        this.getList();
                    }
                })
            },
            // 选中当前记录函数
            checked(index) {
                this.count = 0;
                this.activityList[index].checked = !this.activityList[index].checked;
                let all = 1;
                for (var i = 0, l = this.activityList.length; i < l; i++) {
                    all = all && this.activityList[i].checked;
                    if (this.activityList[i].checked == 1) {
                        this.count++;
                    }
                }
                this.allChecked = all;
            },
            // 全选函数
            checkedAll() {
                this.count = 0;
                this.activityList.map((x) => {
                    x.checked = this.allChecked ? 0 : 1;
                    if (x.checked == 1) {
                        this.count++;
                    }
                })
            },
            // 批量上/下架函数
            batchPut(status, status_str) {
                let id = [];
                for (let i = 0, l = this.activityList.length; i < l; i++) {
                    if (this.activityList[i].checked) {
                        id.push(this.activityList[i].id);
                    }
                }
                this.requestApi("/activity/status/" + id, {
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
            // 路由跳转函数
            passParam(name, id, activityName) {
                this.$route.router.go({
                    name: name,
                    query: {
                        id: id,
                        activityName: activityName
                    }
                })
            },
            // 初始化分页函数
            initPagination() {
                this.pagination = true;
                this.getList();
                this.pagination = false;
            }
        },
        components: {
            pagination //引入分页组件
        }
}
</script>
