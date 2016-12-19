<style lang="sass">
.timeline {
    li {
        height: 100px;
        list-style: none;
        .timeline-time {
            width: 150px;
            text-align: center;
        }
        .timeline-node {
            position: relative;
            display: inline-block;
            width: 10px;
            height: 10px;
            background: black;
            color: #fff;
            border-radius: 100%;
            z-index: 2;
            text-align: center;
        }
        .timeline-content {
            margin-left: 5px;
        }
        &:first-child {
            color: red;
            .timeline-node {
                background: red;
            }
            &::after {
                background: red;
            }
        }
        &:last-child {
            height: 100px;
        }
        &:last-child::after {
            height: 0;
        }
        &::after {
            position: relative;
            left: 158px;
            top: -7px;
            display: block;
            content: ' ';
            width: 1px;
            height: 95%;
            background: black;
            z-index: 1;
        }
        div {
            display: inline-block;
        }
    }
}
</style>
<template lang="html">
    <header class="template-header">
        <span>订单详情</span>
        <button class="btn btn-default" @click.prevent="back()"><i class="fa fa-reply"></i> 返回订单列表</button>
    </header>
    <div class="content-body">
        <panel title="基本信息">
            <div slot="panel-body" class="panel-body">
                <ul class="nav">
                    <li>订单号：{{detail.orderid}}</li>
                    <li>用户昵称：{{detail.nickname}}</li>
                    <li>订单类型：{{orderType}}</li>
                    <li>订单内容：{{detail.product}}</li>
                    <li>订单来源：{{detail.origin_type_str}}</li>
                    <li>消耗积分：{{detail.integral}}</li>
                </ul>
            </div>
        </panel>
        <panel title="订单流程">
            <div slot="panel-body" class="panel-body order-timeline">
                <div v-if="detail.send_type == 1">
                    <ul class="timeline" v-if="detail.product_type == 2">
                        <li class="timeline" v-for="item in traceList">
                            <div class="timeline-time">{{item.AcceptTime}}</div>
                            <div class="timeline-node"></div>
                            <div class="timeline-content">{{item.AcceptStation}}</div>
                        </li>
                        <li v-if="detail.express_time">
                            <div class="timeline-time">{{detail.express_time}}</div>
                            <div class="timeline-node"></div>
                            <div class="timeline-content">已发货，运单号：{{detail.express_id}}</div>
                        </li>
                        <li v-if="detail.address_time">
                            <div class="timeline-time">{{detail.address_time}}</div>
                            <div class="timeline-node"></div>
                            <div class="timeline-content">确认收货地址：{{detail.address}}</div>
                        </li>
                        <li v-else>
                            <div class="timeline-time">{{detail.create_time}}</div>
                            <div class="timeline-node"></div>
                            <div class="timeline-content">等待用户确认收货地址</div>
                        </li>
                        <li>
                            <div class="timeline-time">{{detail.create_time}}</div>
                            <div class="timeline-node"></div>
                            <div class="timeline-content">创建订单，消耗{{detail.integral}}积分</div>
                        </li>
                    </ul>
                    <ul class="timeline" v-else>
                        <li>
                            <div class="timeline-time">{{detail.create_time}}</div>
                            <div class="timeline-node"></div>
                            <div class="timeline-content" v-if="detail.type == 1">券码已发放。</div>
                            <div class="timeline-content" v-else>获得奖品：{{detail.product}}</div>
                        </li>
                        <li>
                            <div class="timeline-time">{{detail.create_time}}</div>
                            <div class="timeline-node"></div>
                            <div class="timeline-content">创建订单，消耗{{detail.integral}}积分</div>
                        </li>
                    </ul>
                </div>
                <div v-else>
                    <ul class="timeline">
                        <li v-if="detail.status == 4">
                            <div class="timeline-time">{{detail.close_time}}</div>
                            <div class="timeline-node"></div>
                            <div class="timeline-content">订单已逾期</div>
                        </li>
                        <li v-if="detail.status == 3">
                            <div class="timeline-time">{{detail.take_time}}</div>
                            <div class="timeline-node"></div>
                            <div class="timeline-content">客户已取货</div>
                        </li>
                        <li>
                            <div class="timeline-time">{{detail.create_time}}</div>
                            <div class="timeline-node"></div>
                            <div class="timeline-content">等待客户取货</div>
                        </li>
                        <li>
                            <div class="timeline-time">{{detail.create_time}}</div>
                            <div class="timeline-node"></div>
                            <div class="timeline-content">创建订单，消耗{{detail.integral}}积分</div>
                        </li>
                    </ul>
                </div>
            </div>
        </panel>
    </div>
</template>
<script>
import panel from '../../components/panel.vue'; 
export default {
    components: {
        panel
    },
    data() {
        return {
            id: '',
            orderType: '',
            detail: {},
            traceList: []
        }
    },
    route: {
        data(transition) {
            if (transition.to.query.id) {
                this.id = transition.to.query.id;
            }
        }
    },
    computed: {
        orderType: function() {
            if (this.detail.type == 1) {
                return this.detail.type_str + ' — ' + this.detail.product_type_str;
            } else {
                return this.detail.type_str + ' — ' + this.detail.activity_type_str;
            }
        }
    },
    ready() {
        this.getDetail();
    },
    methods: {
        getDetail() {
            this.requestApi('/order/get/' + this.id, {}, (response) => {
                this.detail = response.data;
                this.detail.product_type == 2 && this.detail.send_type == 1 && this.detail.status > 2 ? this.getTraceList() : '';
            })
        },
        getTraceList() {
            this.requestApi('/order/get_trace/' + this.id, {}, (response) => {
                this.traceList = response.data.reverse();
            })
        }
    }
}
</script>
