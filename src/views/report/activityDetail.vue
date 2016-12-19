<style lang="sass" scoped>
@import './style/main.scss';
</style>
<template lang="html">
    <div class='report-activity-detail'>
        <div class='report-activity-detail'>
            <header class="template-header">
                <span>活动统计详情</span>
                <button class="btn btn-default" v-if="edit" @click.prevent="back()"><i class="fa fa-reply"></i> 返回活动统计详情</button>
            </header>
            <section class='panel panel-default'>
                <header class='panel-heading'>
                    概括
                </header>
                <article class='summarize panel-body flex'>
                    <div class='left'>
                        <h3 class='text-center'>UV</h3>
                        <div class='flex flex-center-h item-4'>
                            <div class='gray-item'>
                                <p>昨日</p>
                                <b>{{total.yesterday_activity_uv}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>今日</p>
                                <b>{{total.today_activity_uv}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>上周</p>
                                <b>{{total.lastweekend_activity_uv}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>本周</p>
                                <b>{{total.thisweekend_activity_uv}}</b>
                            </div>
                        </div>
                    </div>
                    <div class='right'>
                        <h3 class='text-center'>PV</h3>
                        <div class='flex flex-center-h item-4'>
                            <div class='gray-item'>
                                <p>昨日</p>
                                <b>{{total.yesterday_activity_pv}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>今日</p>
                                <b>{{total.today_activity_pv}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>上周</p>
                                <b>{{total.lastweekend_activity_pv}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>本周</p>
                                <b>{{total.thisweekend_activity_pv}}</b>
                            </div>
                        </div>
                    </div>
                </article>
                <article class='summarize panel-body flex'>
                    <div class='left'>
                        <h3 class='text-center'>参与次数</h3>
                        <div class='flex flex-center-h item-4'>
                            <div class='gray-item'>
                                <p>昨日</p>
                                <b>{{total.yesterday_activity_count}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>今日</p>
                                <b>{{total.today_activity_count}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>上周</p>
                                <b>{{total.lastweekend_activity_count}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>本周</p>
                                <b>{{total.thisweekend_activity_count}}</b>
                            </div>
                        </div>
                    </div>
                    <div class='right'>
                        <h3 class='text-center'>参与人次</h3>
                        <div class='flex flex-center-h item-4'>
                            <div class='gray-item'>
                                <p>昨日</p>
                                <b>{{total.yesterday_activity_count}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>今日</p>
                                <b>{{total.today_activity_count}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>上周</p>
                                <b>{{total.lastweekend_activity_count}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>本周</p>
                                <b>{{total.thisweekend_activity_count}}</b>
                            </div>
                        </div>
                    </div>
                </article>
            </section>
            <section class='panel panel-default'>
                <header class='panel-heading flex flex-space-between flex-center-v'>
                    趋势分析
                    <div class='pull-right flex'>
                        <select @change='changeDay'>
                            <option value=7>最近7日</option>
                            <option value=30>最近30日</option>
                        </select>
                        <input type="date" v-model='day_params.startdate'>
                        <span class='time-label'>至</span>
                        <input type="date" v-model='day_params.enddate'>
                    </div>
                </header>
                <div class='panel-body '>
                    <v-line-chart :get-data='getDay' :params='day_params'></v-line-chart>
                </div>
            </section>
            <section class='panel panel-default'>
                <header class='panel-heading flex flex-space-between flex-center-v'>
                    来源分析
                    <div class='pull-right flex'>
                        <select @change='changeOrigin'>
                            <option value='pv'>PV</option>
                            <option value='uv'>UV</option>
                            <option value='play_count_u'>参与人次</option>
                            <option value='play_count'>参与次数</option>
                        </select>
                        <select @change='changeOrigin'>
                            <option value=7>最近7日</option>
                            <option value=30>最近30日</option>
                        </select>
                        <input type="date" v-model='origin_params.startdate'>
                        <span class='time-label'>至</span>
                        <input type="date" v-model='origin_params.enddate'>
                    </div>
                </header>
                <div class='panel-body '>
                    <v-pie-chart :get-data='getOrigin' :params='origin_params'></v-pie-chart>
                </div>
            </section>
        </div>
    </div>
</template>
<script>
import vLineChart from './components/vLineChart.vue';
import vPieChart from './components/vPieChart.vue';
import commonApi from 'libs/commonApi';
export default {
    components: {
        vLineChart,
        vPieChart,
    },
    mixins: [commonApi],
    data() {
        return {
            edit: false,
            activity_id: '',
            default_gap: 7,
            day_params: {},
            origin_params: {},
            total: {},
        }
    },
    ready() {
        this.init();
        this.getTotal();
        // this.getDay();
        // this.getOrigin();
    },
    methods: {
        init() {
            this.edit = this.$route.query.activity_id? true : false;
            this.activity_id = this.$route.query.activity_id;
            this.day_params = {
                enddate: this.dateFormat(new Date()),
                startdate: this.getLastTime(this.default_gap)
            };
            this.origin_params = {
                //pv uv
                type: 'pv',
                enddate: this.dateFormat(new Date()),
                startdate: this.getLastTime(this.default_gap)
            };
        },
        //获取概括
        getTotal() {
            this.requestApi("/report/activity_total/" + this.activity_id, {}, (response) => {
                this.total = response.data;
            })
        },
        getDay(callback, params) {
            this.requestApi("/report/activity_day/" + this.activity_id, {
                startdate: params.startdate,
                enddate: params.enddate,
            }, (response) => {
                if (callback) {
                    callback(response)
                };
            })
        },
        getOrigin(callback, params) {
            this.requestApi("/report/activity_origin/" + this.activity_id, {
                type: params.type,
                startdate: params.startdate,
                enddate: params.enddate,
            }, (response) => {
                if (callback) {
                    callback(response)
                };
            })
        },
        changeDay() {
            if (event.target.value) {
                this.day_params.startdate = this.getLastTime(event.target.value);
            }
        },
        changeOrigin() {
            let value = event.target.value;
            if (value) {
                if (parseInt(value)) {
                    this.origin_params.startdate = this.getLastTime(value);
                } else {
                    this.origin_params.type = value;
                }
            }
        }
    }
}
</script>
