<style lang="sass">

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
import Vue from 'vue';
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
                name: "订单",
                url: "/order/list",
                icon: "fa fa-pencil-square-o",
                active: ""
            }, {
                name: "积分",
                url: "/integral/parameter",
                icon: "fa fa-line-chart",
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
            }];
            this.allSubMenu["order"] = [{
                name: "查询订单",
                url: "/order/list",
                active: ""
            }];
            this.allSubMenu["integral"] = [{
                name: "参数设置",
                url: "/integral/parameter",
                active: ""
            }];
            //子菜单
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
