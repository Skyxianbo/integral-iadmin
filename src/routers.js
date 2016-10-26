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
        '/order/list': {
          component: require('./views/order/list.vue'),
          auth: true
        },
        '/integral/parameter': {
          component: require('./views/integral/parameter.vue'),
          auth: true
        },

  });

}
