<style lang="sass" scoped>
@import './style/main.scss';
</style>
<template lang="html">
    <div class='report-activity-detail'>
        <!-- 标题 -->
        <div class="content-title">
            <span class="border-left-orange">活动统计详情</span>
        </div>
        <section class='panel panel-default'>
            <header class='panel-heading'>
                概括
            </header>
            <article class='summarize panel-body flex'>
                <slot></slot>
            </article>
            <article class='summarize panel-body flex'>
                <div class='left'>
                    <h3 class='text-center'>参与次数</h3>
                    <div class='flex flex-center-h'>
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
                    <div class='flex flex-center-h'>
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
                        <option value=''>时限</option>
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
                        <slot name='type'></slot>
                    </select>
                    <select @change='changeOrigin'>
                        <slot name='date'></slot>
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
import vLineChart from './vLineChart.vue';
import vPieChart from './vPieChart.vue';
import commonApi from 'libs/commonApi';
export default {
    components: {
        vLineChart,
        vPieChart,
    },
    mixins: [commonApi],
    props:{
        url_list:Object
    },
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
        // this.getDay();
        // this.getOrigin();
    },
    methods: {
        init() {
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
            this.requestApi(this.url_list.get_total, {}, (response) => {
                this.total = response.data;
            })
        },
        getDay(callback, params) {
            this.requestApi(this.url_list.get_day, {
                startdate: params.startdate,
                enddate: params.enddate,
            }, (response) => {
                if (callback) {
                    callback(response)
                };
            })
        },
        getOrigin(callback, params) {
            this.requestApi(this.url_list.get_origin, {
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
