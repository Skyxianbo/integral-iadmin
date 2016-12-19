<style lang="sass">
.btn-search {
    padding: 5px 15px;
}
</style>
<template lang="html">
    <header class="template-header">
        <span>参数设置</span>
    </header>
    <form class="form-horizontal margin-top-20">
        <div class="form-group">
            <div class="col-sm-12">
                <label class="col-md-2 col-sm-12 control-label ">签到获得积分：</label>
                <div class="col-md-3 col-sm-12 row">
                    <input type="text" v-model="data[0].value">
                </div>
            </div>
            <div class="col-sm-12 margin-top-20">
                <label class="col-md-2 col-sm-12 control-label ">分享获得积分：</label>
                <div class="col-md-3 col-sm-12 row">
                    <input type="text" v-model="data[1].value">
                </div>
            </div>
            <div class="col-sm-2 col-sm-offset-2 margin-top-20">
                <button class="btn-search" @click.prevent="setParam()">保存修改</button>
            </div>
        </div>
    </form>
</template>
<script>
export default {
    data() {
            return {
                data: [{
                    name: '',
                    value: ''
                }, {
                    name: '',
                    value: ''
                }]
            }
        },
        ready() {
            this.getParam(); 
        },
        methods: {
            getParam() {
                this.requestApi("/system/get_integral_param", {}, (response) => {
                    this.data = response.data;
                })
            },
            setParam() {
                let jsonData = JSON.stringify(this.data);
                if (this.data[0].value && this.data[1].value) {
                    this.requestApi("/system/set_integral_param", {
                        data: jsonData
                    }, (response) => {
                        layer.msg("已保存！");
                        this.getParam();
                    });
                } else {
                    layer.msg("缺少必要的参数");
                }
            },
        }
}
</script>
