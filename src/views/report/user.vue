<style lang="sass" scoped>
@import './style/main.scss';
.report-user{
    .left {
        border-right: 1px solid $gray;
        width: 60%;
    }
    .right {
        width: 40%;
    }
}
</style>
<template lang="html">
    <div class='report-user'>
        <header class="template-header">
            <span>用户统计</span>
        </header>
        <section class='panel panel-default'>
            <header class='panel-heading flex flex-space-between flex-center-v'>
                概括
            </header>
            <article class='summarize panel-body flex'>
                <div class='left flex flex-column '>
                    <div class=' flex-item '>
                        <h3 class='text-center'>新增</h3>
                        <div class='flex  flex-center-h item-4'>
                            <div class=' gray-item'>
                                <p>昨日</p>
                                <b>{{total.yesterday_user_add}}</b>
                            </div>
                            <div class=' gray-item'>
                                <p>今日</p>
                                <b>{{total.today_user_add}}</b>
                            </div>
                            <div class=' gray-item'>
                                <p>上周</p>
                                <b>{{total.lastweekend_user_add}}</b>
                            </div>
                            <div class=' gray-item'>
                                <p>本周</p>
                                <b>{{total.thisweekend_user_add}}</b>
                            </div>
                        </div>
                    </div>
                    <div class=' flex-item '>
                        <h3 class='text-center'>活跃</h3>
                        <div class='flex flex-center-h item-4'>
                            <div class=' gray-item'>
                                <p>昨日</p>
                                <b>{{total.yesterday_user_act}}</b>
                            </div>
                            <div class=' gray-item'>
                                <p>今日</p>
                                <b>{{total.today_user_act}}</b>
                            </div>
                            <div class=' gray-item'>
                                <p>上周</p>
                                <b>{{total.lastweekend_user_act}}</b>
                            </div>
                            <div class=' gray-item'>
                                <p>本周</p>
                                <b>{{total.thisweekend_user_act}}</b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='right flex flex-column '>
                    <div class=' flex-item '>
                        <h3 class='text-center'>留存</h3>
                        <div class='flex flex-center-h item-2'>
                            <div class=' gray-item'>
                                <p>次日留存</p>
                                <b>{{getPercent(total.yesterday_user_stand)}}</b>
                            </div>
                            <div class=' gray-item'>
                                <p>7日留存</p>
                                <b>{{getPercent(total.lastweekend_user_stand)}}</b>
                            </div>
                        </div>
                    </div>
                    <div class=' flex-item '>
                        <h3 class='text-center'>签到</h3>
                        <div class='flex flex-center-h item-2'>
                            <div class=' gray-item'>
                                <p>昨日签到率</p>
                                <b>{{getPercent(total.yesterday_user_sign)}}</b>
                            </div>
                            <div class=' gray-item'>
                                <p>7日签到率</p>
                                <b>{{getPercent(total.lastweekend_user_sign)}}</b>
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
                        <option value='new'>新增</option>
                        <option value='active'>活跃</option>
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
</template>
<script>
import vLineChart from './components/vLineChart.vue';
import vPieChart from './components/vPieChart.vue';
import commonApi from 'libs/commonApi.js';
export default {
    components: {
        vLineChart,
        vPieChart,
    },
    mixins: [commonApi],
    data() {
        return {
            default_gap: 7,
            day_params: {},
            origin_params: {},
            total: {},
        }
    },
    ready() {
        this.init();
        this.getTotal();
    },

    methods: {
        init() {
            this.day_params = {
                enddate: this.dateFormat(new Date()),
                startdate: this.getLastTime(this.default_gap)
            };
            this.origin_params = {
                //pv uv
                type: 'new',
                enddate: this.dateFormat(new Date()),
                startdate: this.getLastTime(this.default_gap)
            };
        },
        getTotal() {
            this.requestApi("/report/user_total", {}, (response) => {
                this.total = response.data;
            })
        },
        getDay(callback, params) {
            this.requestApi("/report/user_day", {
                startdate: params.startdate,
                enddate: params.enddate,
            }, (response) => {
                if (callback) {
                    callback(response)
                };
            })
        },
        getOrigin(callback, params) {
            this.requestApi("/report/user_origin", {
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
        },
        getPercent(value) {
            return (value * 100).toFixed(2) + '%';
        }
    }
}
</script>
