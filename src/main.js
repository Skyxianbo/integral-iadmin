import Vue from 'vue';
import App from './App';
import VueRouter from 'vue-router';
import configRouter from './routers';
import layer from './libs/layer/layer.js'; //弹出层 alert confirm message loading tips dialog iframe
import commonApi from './libs/commonApi';
Vue.mixin(commonApi);
layer.config({
	path: './src/libs/layer/' //配置layer资源文件路径
});

Vue.use(VueRouter);
const router = new VueRouter();

window.JST = window.JST || {}; //聚视通全局变量
JST.HOST = 'http://integral.api.justtong.com';  //服务端域名
JST.SUCCESS = 10000;    //服务端返回成功状态码
JST.PERPAGE = 20;      //分页查询时每页条数
JST.ISLOGIN = 0;

//验证是否需要登录
router.beforeEach((transition) => {
     if (transition.to.auth) {
        if (sessionStorage.NUT_USER) {
            transition.next();
        } else {
            transition.redirect('/login');
        }
    } else{  transition.next();}
});
//切换路由后滚动条回到顶部
router.afterEach((transition) => {
	 window.scrollTo(0,0);
});

configRouter(router);
router.start(Vue.extend(App), '#app');
