module.exports = {
    methods: {
        //获取数据
        requestApi(url, param, callback) {
            let user = JSON.parse(sessionStorage.getItem("NUT_USER"));
            let token_key = "",
                token_secret = "";
            if (user) {
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
                    if (response.status !== JST.SUCCESS) {
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

        //时间格式化
        dateFormat(date) {
            let y = date.getFullYear(),
                m = date.getMonth() + 1,
                d = date.getDate();
            m = m < 10 ? '0' + m : m;
            d = d < 10 ? ('0' + d) : d;
            return y + '-' + m + '-' + d;
        },

        //时间筛选公共方法
        getLastTime(days) {
            if (!days) days = 0;
            let date = new Date();
            date.setDate(date.getDate() - days);
            return this.dateFormat(date);
        },

        formatDate(t) {
            let res = '',
                seconds = Math.floor((t / 1000) % 60),
                minutes = Math.floor((t / 1000 / 60) % 60),
                hours = Math.floor((t / (1000 * 60 * 60)) % 24),
                days = Math.floor(t / (1000 * 60 * 60 * 24));
            res = days + '天 ' + hours + '时 ' + minutes + '分 ' + seconds + '秒 '
            return res;
        },

        layerLoad() {
            layer.load(2);
            window.setTimeout(function() {
                layer.closeAll('loading');
            }, 1000);
        },

        //将宽度超过屏幕尺寸的图片宽度设为100%
        resizeImg(content) {
            content = content.replace(/([a-z]+)="[\s\S]+?"/ig, function(a, b, c, d) {
                if (b === 'height') {
                    return '';
                } else if (b === 'width') {
                    return 'style="width:100%"';
                }
                return a;
            });
            return content;
        },
        resizeFontSize(str) {
            str = str.replace(/x-large/g, '1.5em');
            str = str.replace(/large/g, '1.25em');
            str = str.replace(/medium/g, '1em');
            str = str.replace(/small/g, '0.75em');
            str = str.replace(/x-small/g, '0.5em');
            return str;
        },
        clone(obj) {
            var o;
            if (typeof obj == "object") {
                if (obj === null) {
                    o = null;
                } else {
                    if (obj instanceof Array) {
                        o = [];
                        for (var i = 0, len = obj.length; i < len; i++) {
                            o.push(this.clone(obj[i]));
                        }
                    } else {
                        o = {};
                        for (var j in obj) {
                            o[j] = this.clone(obj[j]);
                        }
                    }
                }
            } else {
                o = obj;
            }
            return o;
        },

        //初始化列表，此处用于给列表中的每个增加'checked'属性
        initList(list) {
            list.forEach((x) => {
                x.checked = 0;
            })
            return list;
        },

        back() {
            history.go(-1);
        }
    }
}
