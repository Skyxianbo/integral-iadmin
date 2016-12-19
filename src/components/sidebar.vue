<style lang="sass">
@import '../assets/css/variables.scss';
/* =================== sidebar ==================== */
.sidebar {
    position: fixed;
    top: $top-height;
    left: 0;
    bottom: 0;
    z-index: 500;
    width: $sidebar-width;
    font-size: $font-size-sidebar;
    font-weight: normal;
    background: $sidebar-bg;
    transition:0.3s;
}

.sidebar-panel {
    margin: 0px ;
    padding:0px;
    border: none;
    background: none;
}
.sidebar-panel li a {
    position: relative;
    display: block;
    padding: 13px 20px 13px 52px;
    height: 50px;
    /*font-weight: 600;*/
}
.sidebar-panel li i {
    position: absolute;
    display: block;
    left: 19px;
    top: 14px;
    padding-top: 1px;
    border-radius: 3px;
    height: 24px;
    width: 24px;
    font-size: 18px;
    text-align: center;
}
.sidebar-panel li a,
.sidebar-panel li i {
    color: $white;
}
.sidebar-panel li a:hover,
.sidebar-panel li a:focus {
    background: $sidebar-bg-hover;
}

.sidebar-panel li a.active {
    background: $sidebar-bg-active;
}
.sidebar.collapsed {
    width: 60px;
    overflow: hidden;
}
.sidebar-panel .hidden-collapsed {
    display: inline-block;
    width: 100px;
    height: 50px;
    overflow: hidden;
    transition: 0.3s;
}
.sidebar.collapsed .hidden-collapsed {
    display: none;
    transition: 0.3s;
}
.sidebar-collapse-button {
    height:  40px;
    line-height: 40px;
    cursor: pointer;
    color: rgba(255,255,255,0.8);
    text-align: center;
    background-color: rgb(77,101,120);
}
.sidebar-collapse-button span {
    margin-top: 5px;
    font-size: 14px;
    border-radius: 3px;
    transition:0.3s;
}

/* =================== sidebar-sub ==================== */
.sidebar-sub {
    position: fixed;
    top: $top-height;
    left: $sidebar-width;
    z-index: 500;
    bottom: 0;
    width: $sidebar-width;
    background: $subbar-bg ;
    font-size: 13px;
    font-weight: normal;
    transition:0.3s;
}
.sidebar-sub-panel {
    margin: 0px ;
    padding: 0px;
    background: none;
    border: none;
}
.sidebar-title {
    padding: 0px 0px 0px 30px;
    color: $gray-dark;
    font-size: 14px;
    line-height: 40px;
    height: 40px;
    font-weight: 600;
}
.sidebar-sub-panel li a {
    position: relative;
    display: block;
    padding: 13px 0px 13px 30px;
    height: 50px;
    /*font-weight: 600;*/
}
.sidebar-sub-panel li a{
    color: $gray;
}
.sidebar-sub-panel li a:hover,
.sidebar-sub-panel li a:focus
{
    background: $subbar-bg-hover;
}
.sidebar-sub-panel li a.active{
    background: $white;
}

</style>

<template>

<div v-if="sidebar">
    <!--start sidebar1 -->
    <div class="sidebar clearfix">
        <ul class="sidebar-panel  nav">
            <li class="sidebar-collapse-button" @click="setSideBarSize"><span class="fa fa-bars"></span></li>
            <li v-for="item in menuList">
                <a v-link="{ path:item.url}" class="{{item.active}}" data-toggle="tooltip" data-container="body" data-placement="right" title="{{item.name}}">
                    <i class="{{item.icon}}"></i>
                    <span class="hidden-collapsed">{{item.name}}</span>
                </a>
            </li>
        </ul>
    </div>
    <!--end sidebar1 -->

    <!--start sidebar2 -->
    <div class="sidebar-sub clearfix">
        <ul class="sidebar-sub-panel nav">
            <li class="sidebar-title">{{ menuName }}</li>
            <li v-for="item in subMenuList">
                <a v-link="{ path:item.url} " title="{{item.name}}" :class="{'active':($index == 0 && item.url.indexOf($route.path)>-1) || item.url == $route.path}">
                    <span class="hidden-collapsed">{{item.name}}</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- end sidebar2 -->
</div>

</template>

<script>
export default {
    data() {
            return {
                path: "",
                subPath: "",
                menuList: [],
                subMenuList: [],
                allSubMenu: [],
                menuName: '',
            }
        },
        props:{
            sidebar: {
                type: Boolean,
            }
        },
        ready() {
            //监听路由事件，改变当前菜单状态
            let self = this;
            this.$route.router.afterEach(function(transition) {
                var paths = transition.to.path.split('/');
                if (paths[1]) {
                    self.path = paths[1];
                    if (paths[2]) {
                        self.subPath = paths[2];
                    }
                } else {
                    self.path = 'home';
                    self.subPath = 'message';
                }
                //根据路径设置菜单活动状态
                for (var item in self.menuList) {
                    if (self.menuList[item].url.split('/')[1] == self.path) {
                        self.menuList[item].active = "active";
                        self.menuName = self.menuList[item].name;
                    } else {
                        self.menuList[item].active = "";
                    }
                }
                //生成子菜单 设置活动状态
                self.subMenuList = self.allSubMenu[self.path];
            });
        },
        created() {
            this.menuList = [{
                name: "商品",
                url: "/goods/list",
                icon: "fa fa-tag",
                active: ""
            }, {
                name: "活动",
                url: "/activity/list",
                icon: "fa fa-cube",
                active: ""
            }, {
                name: "Banner",
                url: "/banner/list",
                icon: "fa fa-laptop",
                active: ""
            }, {
                name: "推荐",
                url: "/commend/list",
                icon: "fa fa-thumbs-up",
                active: ""
            }, {
                name: "客户",
                url: "/media/list",
                icon: "fa fa-user",
                active: ""
            }, {
                name: "订单",
                url: "/order/list",
                icon: "fa fa-pencil-square-o",
                active: ""
            }, {
                name: "统计",
                url: "/report/access",
                icon: "fa fa-line-chart",
                active: ""
            }, {
                name: "积分",
                url: "/integral/parameter",
                icon: "fa fa-database",
                active: ""
            }];
            //子菜单
            this.allSubMenu["goods"] = [{
                name: "查询商品",
                url: "/goods/list",
                active: ""
            }, {
                name: "添加商品",
                url: "/goods/insert",
                active: ""
            }];
            this.allSubMenu["activity"] = [{
                name: "查询活动",
                url: "/activity/list",
                active: ""
            }, {
                name: "添加活动",
                url: "/activity/insert",
                active: ""
            }, {
                name: "小游戏列表",
                url: '/activity/gameList',
                active: ''
            }, {
                name: "添加小游戏",
                url: '/activity/insertGame',
                active: ''
            }];
            this.allSubMenu["banner"] = [{
                name: "查询Banner",
                url: "/banner/list",
                active: ""
            }, {
                name: "添加Banner",
                url: "/banner/insert",
                active: ""
            }, {
                name: "Banner参数",
                url: "/banner/param",
                active: ""
            }];
            this.allSubMenu["commend"] = [{
                name: "查询推荐",
                url: "/commend/list",
                active: ""
            }, {
                name: "添加推荐",
                url: "/commend/insert",
                active: ""
            }, {
                name: "添加参数",
                url: "/commend/param",
                active: ""
            }];
            this.allSubMenu["media"] = [{
                name: "查询客户",
                url: "/media/list",
                active: ""
            }, {
                name: "添加客户",
                url: "/media/insert",
                active: ""
            }];
            this.allSubMenu["order"] = [{
                name: "查询订单",
                url: "/order/list",
                active: ""
            }, {
                name: "待发货订单",
                url: "/order/readySend",
                active: ""
            }, {
                name: "待取货订单",
                url: "/order/readyTake",
                active: ""
            }, {
                name: "逾期订单", 
                url: "/order/overtime",
                active: ""
            }];
            this.allSubMenu["report"] = [{
                name: "访问量统计",
                url: "/report/access",
                active: ""
            }, {
                name: "用户统计",
                url: "/report/user",
                active: ""
            }, {
                name: "活动统计",
                url: "/report/activity",
                active: ""
            }, {
                name: "商品统计",
                url: "/report/product",
                active: ""
            }];
            this.allSubMenu["integral"] = [{
                name: "参数设置",
                url: "/integral/parameter",
                active: ""
            }];
        },
        methods: {
            //展开或收缩菜单栏
            setSideBarSize() {
                if ($('.sidebar').hasClass('collapsed')) {
                    $('.sidebar').removeClass('collapsed');
                    $('.sidebar-sub').css({
                        'left': '120px'
                    });
                    $('.content').css({
                        'margin-left': '240px'
                    });
                } else {
                    $('.sidebar').addClass('collapsed');
                    $('.sidebar-sub').css({
                        'left': '60px'
                    });
                    $('.content').css({
                        'margin-left': '180px'
                    });
                }
            }
        }
}

</script>
