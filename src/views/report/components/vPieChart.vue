<style lang='sass' scoped>
@import '../style/main.scss';
.access-detail {
    ul,
    li {
        padding: 0;
        list-style: none;
    }
    .access-list {
        width: 400px;
        height: 350px;
        padding: 0 50px;
        line-height: 45px;
        overflow-y: scroll;
        border-top: 1px solid $gray;
    }
}
</style>
<template>
    <div class='flex'>
        <div class='flex-item v-pie-chart ' style="width:800px;height:400px;"> </div>
        <div class='access-detail'>
            <h4 class='text-center'>来源明细</h4>
            <ul class='access-list'>
                <li v-for='item in type_list' class='flex flex-space-between'>
                    <span>{{item.name}}</span>
                    <span>{{item.value}}</span>
                </li>
            </ul>
        </div>
    </div>
</template>
<script type="text/javascript">
import echarts from 'echarts';
export default {
    props: {
        getData: Function,
        params: Object
    },
    computed: {
        type_list() {
            if (!this.list.length) {
                return [];
            }
            return this.list.map(item => {
                if (item.value < 1) {
                    item.value = Math.ceil(item.value * 100) + '%'
                }
                return item;
            })
        }
    },
    data() {
        return {
            pie_chart: '',
            chart_data: {},
            option: {},
            list: []
        }
    },
    watch: {
        params: {
            handler() {
                this.getData((response) => {
                    this.chart_data = response.data;
                    this.option = this.getOption(this.chart_data);
                    this.list = this.option.series[0].data;
                    this.setChart(this.option);
                }, this.params)
            },
            deep: true
        }
    },
    methods: {
        setChart(option) {
            // 基于准备好的dom，初始化echarts实例
            this.pie_chart = echarts.init(document.querySelector('.v-pie-chart'));
            // 绘制图表
            this.pie_chart.setOption(option);
        },
        getOption(chart_data) {
            let option = {
                tooltip: {
                    liigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    data: [],
                    bottom: 0
                },
                series: [{
                    name: '访问来源',
                    type: 'pie',
                    radius: '50%',
                    center: ['50%', '50%'],
                    data: [],
                }]
            };
            for (var i = 0; i < chart_data.length; i++) {
                let item = chart_data[i];
                option.legend.data.push(item.name);
                option.series[0].data.push({
                    value: item.count,
                    name: item.name
                })
            }
            return option;
        }
    }
}
</script>
