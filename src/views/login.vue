<style lang="sass" scoped>
.account-container {
    position: absolute;
    top: 50%;
    left: 50%;
    margin-left: -250px;
    margin-top: -142px;
    width: 500px;
    border: 1px solid #bbb;
    .account-title h2 {
        text-align: center;
        margin: 2rem;
    }
    .account-body {
        margin: 3rem auto;
        .btn-search {
            width: 100%;
            padding: 5px;
        }
    }
}
</style>
<template lang="html">
    <div class="account-container">
        <div class="account-title">
            <h2>登录</h2>
        </div>
        <div class="account-body">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-3 col-sm-offset-1 control-label">
                        <span>用户名：</span>
                    </label>
                    <div class="col-sm-6">
                        <input class="form-control" type="text" v-model="param.username">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-sm-offset-1 control-label">
                        <span>登录密码：</span>
                    </label>
                    <div class="col-sm-6">
                        <input class="form-control" type="password" v-model="param.password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-4">
                        <button class="btn-search" @click.prevent="submit()">登录</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    data() {
            return {
                param: {
                    "username": "",
                    "password": "",
                    "ip": ""
                }
            }
        },
        ready() {},
        methods: {
            submit() {
                this.requestApi("/admin/login", this.param, (response) => {
                    var arr = response.data;
                    sessionStorage.setItem('NUT_USER', JSON.stringify(arr));
                    this.$root.$dispatch('logined', true);
                })
            }
        }
}
</script>
