<style lang="sass" scoped>
.account-container{
    position: absolute;
    top: 50%;
    left: 50%;
    margin-left: -250px;
    margin-top: -142px;
    width: 500px;
    border: 1px solid #bbb;
    .account-title {
        border-bottom: 1px solid #e3e3e3;
        h4 {
            margin: 1rem 2rem 1rem;
        }
    }
    .account-body {
        margin: 2rem auto;
        .btn-primary {
            width: 100%;
        }
        .checkbox {
            padding-top: 4px;
            label {
                font-size: 12px;
            }
        }
    }
}
</style>
<template lang="html">
<div class="account-container" id="login">
    <div class="account-title">
        <h4>登录</h4>
    </div>
    <div class="account-body">
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="col-sm-3 control-label">
                    <span>用户名：</span>
                </label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" v-model="param.username" @keyup.enter="submit()">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="col-sm-3 control-label">
                    <span>登录密码：</span>
                </label>
                <div class="col-sm-6">
                    <input class="form-control" type="password" v-model="param.password" @keyup.enter="submit()">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4"></div>
                <div class="col-sm-6">
                    <a class="btn btn-primary" @click="submit()">登录</a>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-8"></div>
                <div class="col-sm-2" style="text-align: right">
                    <a><h6>忘记密码?</h6></a>
                </div>
            </div>
        </form>
    </div>
</div>
</template>
<script>
import commonApi from '../libs/commonApi';
export default {
    data() {
        return {
            param:{
                "username":"",
                "password":"",
                "ip": ""
            }
        }
    },
    mixins: [commonApi],
    ready() {
    },
    methods: {
        submit() {
            let param = this.param;
            this.requestApi("/admin/login",param,(response) => {
                let result = response.status;
                    if (result == "10000"){
                        var arr = response.data;
                        sessionStorage.setItem('userId',JSON.stringify(arr.id));
                        sessionStorage.setItem('user',JSON.stringify(arr));
                        this.$root.$dispatch('logined',arr);
                    }else {
                        layer.msg("用户名或密码错误");
                    }
            })
        }
    },
    components: {
        commonApi
    }
}
</script>