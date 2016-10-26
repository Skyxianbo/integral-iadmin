<style lang="sass">
</style>
<template lang="html">
<!-- 标题 -->
<div class="content-title">
    <span class="border-left-orange">参数设置</span>
</div>
<!-- 参数设置模块 -->
<form class="margin-top-20">
	<div class="form-group">
		<div class="col-sm-12">
            <label class="col-md-2 col-sm-12 control-label ">签到获得积分：</label>
            <div class="col-md-3 col-sm-12 row">
                <input class="form-control input-sm" type="text" v-model="data[0].value">
            </div>
        </div>
		<div class="col-sm-12 margin-top-20">
            <label class="col-md-2 col-sm-12 control-label ">分享获得积分：</label>
            <div class="col-md-3 col-sm-12 row">
                <input class="form-control input-sm" type="text" v-model="data[1].value">
            </div>
        </div>
        <div class="col-sm-12 margin-top-20">
            <!-- 点击调用保存修改函数 -->
        	<button class="btn button-primary margin-left-15" @click.prevent="setParam()">保存修改</button>
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
            }],
        }
    },
    ready() {
        this.getParam();    //调用获取参数函数
    },
    methods: {
        // 获取参数函数
        getParam() {
            this.requestApi("/system/get_integral_param", {}, (response) => {
                response.status == JST.SUCCESS ? this.data = response.data : layer.msg(response.info);
            })
        },
        // 设置参数函数
        setParam() {
            let jsonData = JSON.stringify(this.data);
            if (this.data[0].value && this.data[1].value) {
                this.requestApi("/system/set_integral_param", {data: jsonData}, (response) => {
                    if (response.status == JST.SUCCESS) {
                        layer.msg("已保存！");
                        this.getParam();
                    }else {
                        layer.msg(response.info);
                    }
                });
            }else {
                layer.msg("缺少必要的参数");
            }
        },
    }
}
</script>