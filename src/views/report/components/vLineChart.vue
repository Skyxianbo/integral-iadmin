<style lang='sass' scoped>
</style>
<template>
    <div class='v-line-chart' :style="line_style">
    </div>
</template>
<script type="text/javascript">
import echarts from 'echarts';
export default {
    props: {
        getData: Function,
        params: Object
    },

    data() {
        return {
            line_chart: '',
            chart_data: {},
            option: {},
            line_style: {
                width: '100%',
                height: '400px'
            }
        }
    },
    watch: {
        params: {
            handler() {
                this.getData((response) => {
                    this.chart_data = response.data;
                    this.option = this.getOption(this.chart_data);
                    this.setChart(this.option);
                }, this.params)
            },
            deep: true
        }
    },
    methods: {
        setChart(option) {
            // 基于准备好的dom，初始化echarts实例
            this.line_chart = echarts.init(document.querySelector('.v-line-chart'));
            // 绘制图表
            this.line_chart.setOption(option);
        },
        getOption(chart_data) {
            let option = {

                // title: {
                //     text: '堆叠区域图'
                // },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: [],
                    bottom: 0
                },
                xAxis: [{
                    type: 'category',
                    data: []
                }],
                yAxis: [{
                    type: 'value'
                }],
                series: []
            };
            Object.keys(chart_data).forEach((key,index) => {
                let name=key;
                if(key=='act'){
                    name='活跃';
                }else if(key=='add'){
                    name='新增';
                }
                option.legend.data.push(name);
                option.series.push({
                    name: name,
                    type: 'line',
                    data: []
                });
                Object.keys(chart_data[key]).forEach(date => {
                    option.xAxis[0].data.push(date);
                    option.series[index].data.push(chart_data[key][date]);
                })

            })

            return option;
        }
    }
}
</script>
