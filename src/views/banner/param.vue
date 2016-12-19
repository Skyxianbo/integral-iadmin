<style lang="sass" scoped>
.btn-search {
    padding: 5px 15px;
}
</style>
<template lang="html">
    <!-- 标题 -->
    <header class="template-header">
        <span>轮播参数</span>
    </header>
    <div class="content-body">
        <form class="form-horizontal">
            <div class="form-group margin-top-20">
                <label class="control-label col-sm-3 col-lg-2">
                    <span>自有Banner数量</span>
                </label>
                <div class="col-sm-2">
                    <input class="input-sm" type="text" v-model="param[0].value">
                    <span class="margin-left-10">页</span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3 col-lg-2">
                    <span>电视台Banner数量</span>
                </label>
                <div class="col-sm-2">
                    <input class="input-sm" type="text" v-model="param[1].value">
                    <span class="margin-left-10">页</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3 col-lg-2 col-lg-offset-2">
                    <button class="btn-search" @click="setParam()">保存修改</button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    data() {
            return {
                param: [{
                    key: 'BANNER_COUNT',
                    value: ''
                }, {
                    key: 'MEDIA_BANNER_COUNT',
                    value: ''
                }]
            }
        },
        ready() {
            this.getParam();
        },
        methods: {
            getParam() {
                this.requestApi('/banner/get_param', {}, (response) => {
                    this.param = response.data;
                })
            },
            setParam() {
                let param = JSON.stringify(this.param);
                this.requestApi('/banner/set_param', {
                    data: param
                }, (response) => {
                    layer.msg("已保存！");
                    this.getParam();
                })
            }
        }
}
</script>
