<template>
    <div id="top" class="clearfix">
        <div class="applogo">
            <img src="./../assets/images/logo.png" />
            <span class="appname">坚果互动 · 运营后台</span>
        </div>
        <ul class="top-right nav" v-if="header">
            <li>
                <a>
                    {{date[0]}}年{{date[1]}}月{{date[2]}}日 {{date[3]}}
                    <br>
                    <span>当前用户：{{user.username ? user.username : username}} <button class="btn-header margin-left-10" @click.prevent="logout">退出</button></span>
                </a>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    props: {
        header: {
            type: Boolean,
            default: false
        },
        user: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            username: '',
            date: [],
            week: ['日', '一', '二', '三', '四', '五', '六'],
        }
    },
    ready() {
        let a = JSON.parse(sessionStorage.getItem("NUT_USER"));
        this.username = a ? a.username : '';
        this.getDate();
    },
    methods: {
        getDate() {
            var now = new Date();
            var myDate = now.toLocaleDateString();
            this.date = myDate.split('/');
            this.date[3] = '星期' + this.week[now.getDay()];
        },
        logout() {
            sessionStorage.removeItem("NUT_USER");
            this.$root.$dispatch('logout', true);
        }
    }
};
</script>
<style lang="sass">
@import '../assets/css/variables.scss';
#top {
    position: fixed;
    z-index: 900;
    left: 0;
    top: 0;
    width: 100%;
    height: $top-height;
    background: $top-bg;
    color: $white;
}

.applogo {
    padding: 0;
    margin: 0;
    float: left;
    height: $top-height;
    text-align: left;
}

.applogo img {
    margin-left: 10px;
    margin-right: 10px;
    margin-top: -5px;
    height: 28px;
}

.applogo .appname {
    font-size: 18px;
    line-height: $top-height;
}

.top-right {
    float: right;
}

.top-right > li {
    float: left;
    background: $top-bg;
}

.top-right > li > a {
    cursor: default;
    font-size: 14px;
    line-height: 20px;
}

.top-right > li > a > i {
    font-size: 18px;
    line-height: 18px;
}

.top-right > li > a {
    color: $white;
}

.top-right > li > a:hover,
.top-right > li > a:focus {
    background-color: $top-bg;
}

.top-right .open .dropdown-toggle {
    background-color: $top-bg-hover !important;
}

.btn-header {
    color: black;
    background-color: white;
    border-radius: 5px;
    padding: 0px 15px;
    outline: none;
    line-height: normal;
    border: none;
}

.btn-header:hover {
    background-color: #007ead;
}

.btn-header:active {
    position: relative;
    top: 1px;
    background-color: #007ead;
}
</style>
