<style lang="sass">
</style>
<template lang="html">
    <v-list title="活动参与情况" :list-title="true" :go-back="true" :pages.sync="pages" :search="currentSearch">
        <div slot="list-title">
            <div class="col-sm-3 col-lg-2">
                <label>
                    活动来源
                    <span class="margin-left-20">{{media_name || '坚果互动'}}</span>
                </label>
            </div>
            <div class="col-sm-3 col-lg-2">
                <label>
                    活动标题
                    <span class="margin-left-20">{{activityName}}</span>
                </label>
            </div>
        </div>
        <div slot="list-search">
            <div class="col-sm-3 padding-left-0">
                <div class="col-sm-5">
                    <input type="date" class="form-control" v-model="currentSearch.start_date">
                </div>
                <div class="col-sm-2 text-center margin-top-4">
                    <span>至</span>
                </div>
                <div class="col-sm-5">
                    <input type="date" class="form-control" v-model="currentSearch.end_date">
                </div>
            </div>
            <div class="col-sm-2 col-lg-1">
                <select class="form-control" v-model="currentSearch.is_win">
                    <option value="{{$index}}" v-for="type in status">{{type}}</option>
                </select>
            </div>
        </div>
        <div slot="list-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>订单ID</th>
                        <th>用户昵称</th>
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
            participationList: [],
            activityId: '',
            activityName: '',
            media_name: '',
            status: ["中奖情况", "中奖", "未中奖"],
            currentSearch: {
                start_date: '',
                end_date: '',
                is_win: 0
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
                this.activityId = transition.to.query.id;
                this.activityName = transition.to.query.activityName;
                this.media_name = transition.to.query.media_name;
            }
        }
    },
    ready() {

    },
    methods: {
        getList(type) {
            type ? this.layerLoad() : '';
            this.requestApi("/activity/play_list/" + this.activityId, this.currentSearch, (response) => {
                this.participationList = response.data.list;
                this.pages.total = response.data.count;
                this.pages.currentPage = response.data.p;
            })
        },
        clearCondition() {
            this.currentSearch = {
                start_date: '',
                end_date: '',
                is_win: 0
            };
        }
    }
}
</script>
