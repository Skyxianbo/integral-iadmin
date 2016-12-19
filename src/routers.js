export default function(router) {
    router.map({
        '/login': {
          component: require('./views/login.vue'),
          auth: false
        },
        '/goods/insert': {
          name: 'goodsEdit',
          component: require('./views/goods/insert.vue'),
          auth: true,
          param: true
        },
        '/goods/list': {
          name: 'goodsList',
          component: require('./views/goods/list.vue'),
          auth: true,
          param: true
        },
        '/goods/importCoupon': {
          name: 'importTicket',
          component: require('./views/goods/importCoupon.vue'),
          auth: true,
          param: true
        },
        '/goods/couponList': {
          name: 'couponList',
          component: require('./views/goods/couponList.vue'),
          auth: true,
          param: true
        },
        '/activity/insert': {
          name: 'activityEdit',
          component: require('./views/activity/insert.vue'),
          auth: true,
          param: true
        },
        '/activity/list': {
          name: 'activityList',
          component: require('./views/activity/list.vue'),
          auth: true,
          param: true
        },
        '/activity/participation': {
          name: 'participation',
          component: require('./views/activity/participation.vue'),
          auth: true,
          param: true
        },
        '/activity/insertGame': {
          name: 'insertGame',
          component: require('./views/activity/insertGame.vue'),
          auth: true
        },
        '/activity/gameList': {
          name: 'gameList',
          component: require('./views/activity/gameList.vue'),
          auth: true
        },
        '/order/list': {
          component: require('./views/order/list.vue'),
          auth: true
        },
        '/order/readySend': {
          component: require('./views/order/readySend.vue'),
          auth: true
        },
        '/order/orderDetail': {
          name: 'orderDetail',
          component: require('./views/order/orderDetail.vue'),
          auth: true
        },
        '/order/readyTake': {
          name: 'readyTake',
          component: require('./views/order/readyTake.vue'),
          auth: true
        },
        '/order/overtime': {
          name: 'overtime',
          component: require('./views/order/overtime.vue'),
          auth: true
        },
        '/integral/parameter': {
          component: require('./views/integral/parameter.vue'),
          auth: true
        },
        '/report/access': {
          component: require('./views/report/access.vue'),
          auth: true
        },
        '/report/user': {
          component: require('./views/report/user.vue'),
          auth: true
        },
        '/report/activity': {
          component: require('./views/report/activity.vue'),
          auth: true
        },
        '/report/activityDetail': {
          name: 'activityDetail',
          component: require('./views/report/activityDetail.vue'),
          auth: true
        },
        '/report/product': {
          component: require('./views/report/product.vue'),
          auth: true
        },
        '/report/productDetail': {
          name: 'productDetail',
          component: require('./views/report/productDetail.vue'),
          auth: true
        },
        '/media/insert': {
          name: 'mediaEdit',
          component: require('./views/media/insert.vue'),
          auth: true
        },
        '/media/list': {
          name: 'mediaList',
          component: require('./views/media/list.vue'),
          auth: true
        },
        '/banner/insert': {
          name: 'bannerEdit',
          component: require('./views/banner/insert.vue'),
          auth: true
        },
        '/banner/list': {
          name: 'bannerList',
          component: require('./views/banner/list.vue'),
          auth: true
        },
        '/banner/param': {
          component: require('./views/banner/param.vue'),
          auth: true
        },
        '/commend/insert': {
          name: 'commendEdit',
          component: require('./views/commend/insert.vue'),
          auth: true
        },
        '/commend/list': {
          name: 'commendList',
          component: require('./views/commend/list.vue'),
          auth: true
        },
        '/commend/param': {
          component: require('./views/commend/param.vue'),
          auth: true
        }

  });

}
