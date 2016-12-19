<style lang="sass">
</style>
<template lang="html">
    <v-list title="活动统计" :pages.sync="pages" :search="currentSearch">
        <div slot="list-search">
            <div class="col-sm-2 col-lg-1">
                <select class="form-control" v-model="currentSearch.type">
                    <option value="{{$index}}" v-for="type in types">{{type}}</option>
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
                <input class="form-control" type="text" placeholder="活动标题" v-model="currentSearch.name">
            </div>
        </div>
        <div slot="list-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>活动标题</th>
                        <th>活动来源</th>
                        <th>状态</th>
                        <th>活动类型</th>
                        <th>UV</th>
                        <th>PV</th>
                        <th>参与次数</th>
                        <th>参与人次</th>
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
                        <td>{{item.play_count}}</td>
                        <td>{{item.play_count_u}}</td>
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
            routerName: "activityDetail",
            pagination: false,
            types: ["所有类型", "刮刮卡", "有奖问答"],
            origin_types: ["所有来源", "坚果互动", "电视台"],
            status: ["所有状态", "下线", "上线"],
            currentSearch: {
                type: 0,
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
            this.requestApi('/activity/get_list', param, (response) => {
                this.list = response.data.list;
                this.pages.total = response.data.count;
                this.pages.currentPage = response.data.p;
            })

        },
        clearCondition() {
            this.currentSearch = {
                type: 0,
                origin_type: 0,
                status: 0,
                name: ''
            };
        },
        routerGo(name, id) {
            this.$route.router.go({
                name: name,
                query: {
                    activity_id: id
                }
            })
        }
    }
}
</script>
