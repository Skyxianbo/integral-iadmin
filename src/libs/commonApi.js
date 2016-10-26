module.exports = {
    methods: {
        //获取数据
        requestApi(url, param,callback) {
            let user = JSON.parse(sessionStorage.getItem("user"));
            let token_key = "",token_secret = "";
            if(user) {
                token_key = user.token_key;
                token_secret = user.token_secret;
            }
            $.ajax({
                type: "post",
                url: JST.HOST + url,
                headers: {
                    "Token-Key": token_key,
                    'Token-Secret': token_secret
                },
                data: param,
                success: (response) => {
                    if(response.status !== JST.SUCCESS){
                        layer.msg(response.info);
                        return false;
                    }
                    callback(response);
                },
                error: (response) => {
                    layer.msg("与服务器失去连接")
                }
            });
        },
        //获取商品列表
        getGoodsList(param,callback){
          this.requestApi("/admin/goods",param,callback);
        },
        //获取分类列表
        getCategories(callback) {
            this.requestApi("/admin/category",{},callback);
        },
        //获取供应商列表
        getSuppliers(callback) {
          this.requestApi("/admin/supplier/user/all",{},callback);
        },
        //获取商品详情
        getGoodsDetail(id,callback) {
          this.requestApi("/admin/goods/get/"+id,{},callback);
        },


        //时间格式化
        dateFormat(date){
            let y = date.getFullYear(), 
            m = date.getMonth() + 1,
            d = date.getDate();
            m = m < 10 ? '0' + m : m;
            d = d < 10 ? ('0' + d) : d;  
            return y + '-' + m + '-' + d; 
        },

        //时间筛选公共方法
        getLastTime(days){
            if(!days) days = 0;
            let date = new Date();
            date.setDate(date.getDate() - days);
            return this.dateFormat(date);
        }

    }
}
