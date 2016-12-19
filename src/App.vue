<template>
    <div id="app">
        <c-header :header.sync="header" :user.sync="user"></c-header>
        <c-sidebar :sidebar.sync="sidebar"></c-sidebar>
        <div class="content">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import cHeader from './components/header';
    import cSidebar from './components/sidebar';
    export default {
        components: {
            cHeader,
            cSidebar
        },
        data(){
            return {
              routePath: this.$route.path,
              header: true,
              sidebar: true,
              user: {}
            }
        },
        ready() {
            var a = JSON.parse(sessionStorage.getItem("NUT_USER"));
            if(a) {
                this.header = true;
                this.sidebar = true;
            }else{
                this.header = false;
                this.sidebar = false;
                this.$route.router.go('/login');
            }
        },
        events:{
            'logined':function(res){
                if(res){
                    this.header =  true;
                    this.sidebar = true;
                    JST.ISLOGIN = 0;
                    this.user = JSON.parse(sessionStorage.getItem("NUT_USER"));
                    this.$route.router.go('/goods/list');
                }
            },
            'logout':function(res){
                if(res){
                    setTimeout(() => {
                        this.header = false;
                        this.sidebar = false;
                        this.$route.router.go('/login');
                    }, 300)
                }
            }
        }
    }
</script>
<style lang="sass">
@import "./assets/css/style.scss";

</style>