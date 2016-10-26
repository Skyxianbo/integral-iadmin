<style lang="sass" scoped>
.btn-search {
    color: #333;
    border: 1px solid #333;
    background-color: white;
}
</style>
<template lang="html">
    <!-- 标题 -->
    <div class="content-title">
        <span class="border-left-orange">导入券码</span>
        <!-- 点击调用返回函数 -->
        <button class="btn btn-default margin-left-10" @click.prevent="back()">返回商品列表</button>
    </div>
    <!-- 导入券码模块 -->
    <div class="content-body">
        <form class="form-horizontal" role="form" id="submitFile">
            <div class="form-group">
                <div class="col-sm-6">
                    <label class="col-sm-3">商品名称</label>
                    <label class="col-sm-9">{{productName}}</label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <label class="col-sm-2">导入券码</label>
                    <div class="col-sm-4">
                        <input class="file" type="file" name="file" id="submitFile">
                    </div>
                    <div class="col-sm-4">
                        <span>模板文件下载</span>
                        <!-- 点击下载模板文件 -->
                        <a class="margin-left-10" href="http://static.justtong.com/uploads/files/test.xls" download>test.xls</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- 点击触发导入券码函数 -->
        <button class="btn button-primary margin-left-10" @click.prevent="importTicket()">导入券码</button>
    </div>
</template>
<script>
export default {
    data() {
            return {
                ticketId: '', //优惠券ID
                productId: '', //优惠券所属的商品ID
                productName: '' //优惠券所属的商品名称
            }
        },
        route: {
            //通过路由获取由list页面传过来的参数，此处包括商品ID和商品名称两个参数
            data(transition) {
                if (transition.to.query.id) {
                    this.productId = transition.to.query.id;
                    this.productName = transition.to.query.productName;
                } else {
                    this.productId = '';
                }
            }
        },
        create() {},
        methods: {
            //导入券码按钮点击后触发的导入券码函数，此处接口上传内容为text文件
            importTicket() {
                let user = JSON.parse(sessionStorage.getItem("user"));
                let token_key = "",
                    token_secret = "";
                if (user) {
                    token_key = user.token_key;
                    token_secret = user.token_secret;
                }
                $("#submitFile").ajaxSubmit({
                    type: 'post', // 提交方式 get/post
                    url: JST.HOST + '/product/import_ticket/' + this.productId, // 需要提交的 url
                    async: false,
                    headers: {
                        "Token-Key": token_key,
                        'Token-Secret': token_secret
                    },
                    success: (response) => { // response 保存提交后返回的数据，一般为 json 数据
                        if (response.status == JST.SUCCESS) {
                            layer.msg("已成功导入", {
                                time: 1000,
                            }, () => {
                                this.$route.router.go({
                                    name: "goodsList"
                                });
                            });
                        } else {
                            layer.msg(response.info);
                        }
                    }
                });
            },
            //返回函数
            back() {
                history.go(-1);
            }
        }
}
</script>
