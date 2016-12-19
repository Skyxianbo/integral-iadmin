<style lang="sass" scoped>
@import './style/main.scss';
</style>
<template lang="html">
    <div class='report-product-detail'>
        <div class='report-product-detail'>
            <header class="template-header">
                <span>商品统计详情</span>
                <button class="btn btn-default" v-if="edit" @click.prevent="back()"><i class="fa fa-reply"></i> 返回商品统计详情</button>
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
                                <b>{{total.yesterday_product_uv}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>今日</p>
                                <b>{{total.today_product_uv}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>上周</p>
                                <b>{{total.lastweekend_product_uv}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>本周</p>
                                <b>{{total.thisweekend_product_uv}}</b>
                            </div>
                        </div>
                    </div>
                    <div class='right'>
                        <h3 class='text-center'>PV</h3>
                        <div class='flex flex-center-h item-4'>
                            <div class='gray-item'>
                                <p>昨日</p>
                                <b>{{total.yesterday_product_pv}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>今日</p>
                                <b>{{total.today_product_pv}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>上周</p>
                                <b>{{total.lastweekend_product_pv}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>本周</p>
                                <b>{{total.thisweekend_product_pv}}</b>
                            </div>
                        </div>
                    </div>
                </article>
                <article class='summarize panel-body flex'>
                    <div class='left'>
                        <h3 class='text-center'>兑换次数</h3>
                        <div class='flex flex-center-h item-4'>
                            <div class='gray-item'>
                                <p>昨日</p>
                                <b>{{total.yesterday_product_count}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>今日</p>
                                <b>{{total.today_product_count}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>上周</p>
                                <b>{{total.lastweekend_product_count}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>本周</p>
                                <b>{{total.thisweekend_product_count}}</b>
                            </div>
                        </div>
                    </div>
                    <div class='right'>
                        <h3 class='text-center'>兑换人次</h3>
                        <div class='flex flex-center-h item-4'>
                            <div class='gray-item'>
                                <p>昨日</p>
                                <b>{{total.yesterday_product_count}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>今日</p>
                                <b>{{total.today_product_count}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>上周</p>
                                <b>{{total.lastweekend_product_count}}</b>
                            </div>
                            <div class='gray-item'>
                                <p>本周</p>
                                <b>{{total.thisweekend_product_count}}</b>
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
                            <option value='play_count_u'>兑换人次</option>
                            <option value='play_count'>兑换次数</option>
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
            product_id: '',
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
            this.edit = this.$route.query.product_id ? true : false;
            this.product_id = this.$route.query.product_id;
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
        getTotal() {
            this.requestApi("/report/product_total/" + this.product_id, {}, (response) => {
                this.total = response.data;
            })
        },
        getDay(callback, params) {
            this.requestApi("/report/product_day/" + this.product_id, {
                startdate: params.startdate,
                enddate: params.enddate,
            }, (response) => {
                if (callback) {
                    callback(response)
                };
            })
        },
        getOrigin(callback, params) {
            this.requestApi("/report/product_origin/" + this.product_id, {
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
