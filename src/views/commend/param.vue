<style lang="sass">
</style>
<template lang="html">
    <header class="template-header">
        <span>参数设置</span>
    </header>
    <form class="form-horizontal margin-top-20">
        <div class="form-group">
            <div class="col-sm-12">
                <label class="col-sm-2 col-sm-12 control-label ">自有推荐数量</label>
                <div class="col-sm-3 col-sm-12 row">
                    <input class="input-sm" type="text" v-model="data[0].value">
                </div>
            </div>
            <div class="col-sm-12 margin-top-20">
                <label class="col-sm-2 col-sm-12 control-label ">自动加载商品比例</label>
                <div class="col-sm-3 col-sm-12 row">
                    <input class="input-sm" type="text" v-model="data[1].value">
                </div>
            </div>
            <div class="col-sm-12 margin-top-20">
                <label class="col-sm-2 col-sm-12 control-label ">自动加载活动比例</label>
                <div class="col-sm-3 col-sm-12 row">
                    <input class="input-sm" type="text" v-model="data[2].value">
                </div>
            </div>
            <div class="col-sm-12 margin-top-20">
                <label class="col-sm-2 col-sm-12 control-label">电视台推荐数量</label>
                <div class="col-sm-3 col-sm-12 row">
                    <input type="text" class="input-sm" v-model="data[3].value">
                </div>
            </div>
            <div class="col-sm-2 col-sm-offset-2 margin-top-20">
                <button class="btn button-primary" @click.prevent="setParam()">保存修改</button>
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
                }, {
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
                this.requestApi('/commend/get_param', {}, (response) => {
                    this.data = response.data;
                })
            },
            setParam() {
                let jsonData = JSON.stringify(this.data);
                let all = 1;
                this.data.forEach((x) => {
                    all = all && x.value;
                })
                if (all) {
                    this.requestApi('/commend/set_param', {
                        data: jsonData
                    }, (response) => {
                        layer.msg("已保存！");
                        this.getParam;
                    })
                } else {
                    layer.msg("缺少必要的参数");
                }

            }
        }
}
</script>
