    <template>
    <div v-if="header" id="top" class="clearfix">
        <div class="applogo">
            <img src="./../assets/images/logo.png" />
            <span class="appname">积分商城 · 管理后台</span>
        </div>
        <ul class="top-right nav">
            <li>
                <a>
                    {{date[0]}}年{{date[1]}}月{{date[2]}}日 {{date[3]}}
                </a>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i>
                    <span>{{user.username ? user.username : username}}</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a @click="logout">退出</a>
                    </li>
                </ul>
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
                week: ['日','一','二','三','四','五','六'],
            }
        },
        ready(){
            let a = JSON.parse(sessionStorage.getItem("user"));
            this.username = a ? a.username : '';
            this.getDate();
        },
        methods: {
            getDate() {
                var now = new Date();
                var myDate = now.toLocaleDateString();
                this.date = myDate.split('/');
                this.date[3] ='星期' + this.week[now.getDay()];
            },
            logout() {
                sessionStorage.removeItem("user");
                sessionStorage.removeItem("userId");
                this.$root.$dispatch('logout',true);
            }
        }
    };
</script>
<style lang="sass">
    
</style>
