<style lang="sass" scoped>
.btn-search {
    color: #333;
    border: 1px solid #333;
    background-color: white;
}
</style>
<template lang="html">
    <header class="template-header">
        <span>导入券码</span>
        <button class="btn btn-default" @click.prevent="back()"><i class="fa fa-reply"></i> 返回商品列表</button>
    </header>
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
                        <a class="margin-left-10" href="http://static.justtong.com/uploads/files/test.xls" download>test.xls</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <footer>
        <button class="btn button-primary" @click.prevent="importTicket()">导入券码</button>
    </footer>
</template>
<script>
export default {
    data() {
            return {
                ticketId: '',
                productId: '',
                productName: ''
            }
        },
        route: {
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
            importTicket() {
                let user = JSON.parse(sessionStorage.getItem("NUT_USER"));
                let token_key = "",
                    token_secret = "";
                if (user) {
                    token_key = user.token_key;
                    token_secret = user.token_secret;
                }
                $("#submitFile").ajaxSubmit({
                    type: 'post',
                    url: JST.HOST + '/product/import_ticket/' + this.productId,
                    async: false,
                    headers: {
                        "Token-Key": token_key,
                        'Token-Secret': token_secret
                    },
                    success: (response) => {
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
                    },
                    error: (response) => {
                        layer.msg('与服务器失去连接');
                    }
                });
            }
        }
}
</script>
