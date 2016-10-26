<style lang="sass" scoped>
.panel-body label {
    font-size: 14px;
    margin-left: 10px;
}

.panel-body>.form-horizontal>.form-group .nav>li>a {
    padding: 2px 10px;
}
</style>
<template lang="html">
    <!-- 标题和返回按钮 -->
    <div class="content-title">
        <span class="border-left-orange">{{title}}</span>
        <!-- 点击触发返回函数 -->
        <button class="btn btn-default margin-left-10" v-if="edit" @click.prevent="back()">返回商品列表</button>
    </div>
    <!-- 选项卡 -->
    <panel title="商品类型">
        <div slot="panel-body" class="panel-body">
            <!-- 点击按钮将改变选项卡至对应的状态 -->
            <ul class="nav nav-pills">
                <li :class="display['step'] == 1? 'active':''"><a id="test1" @click.prevent="stepSwitch(1)" data-toggle="tab">优惠券</a></li>
                <li :class="display['step'] == 2? 'active':''"><a @click.prevent="stepSwitch(2)" data-toggle="tab">实物</a></li>
                <li :class="display['step'] == 3? 'active':''"><a @click.prevent="stepSwitch(3)" data-toggle="tab">积分赠送</a></li>
                <li :class="display['step'] == 4? 'active':''"><a @click.prevent="stepSwitch(4)" data-toggle="tab">谢谢参与</a></li>
            </ul>
        </div>
    </panel>
    <div class="tab-content">
        <div class="tab-pane active">
            <!-- 展示信息模块，主要包含详细说明、使用说明两个富文本编辑器，以及图片上传 -->
            <panel title="展示信息">
                <div slot="panel-body" class="panel-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                <span>商品名称：</span>
                            </label>
                            <div class="col-sm-6">
                                <input class="form-control input-sm" type="text" placeholder="请输入商品名称" v-model="productDetails.name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                <span>市面价值：</span>
                            </label>
                            <div class="col-sm-5">
                                <input class="form-control input-sm" type="text" placeholder="请输入市面价值" v-model="productDetails.price">
                            </div>
                            <div class="col-sm-1">
                                <select class="form-control input-sm">
                                    <option>元</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                <span>详细说明：</span>
                            </label>
                            <div class="col-sm-8">
                                <!-- 富文本编辑器editor -->
                                <textarea id="goodsDetails" placeholder="详细说明" autofocus></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                <span>使用说明：</span>
                            </label>
                            <div class="col-sm-8 simditor-sm">
                                <!-- 富文本编辑器editorUse -->
                                <textarea id="goodsUse" placeholder="使用说明" autofocus></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                <span>商品图片：</span>
                            </label>
                            <div class="col-sm-8">
                                <!-- 图片上传区域选项卡 -->
                                <ul class="nav nav-pills">
                                    <li class="active col-sm-2"><a href="#tab-img1" data-toggle="tab">详情图</a></li>
                                    <li class="col-sm-2"><a href="#tab-img2" data-toggle="tab">缩略图</a></li>
                                    <li class="col-sm-2"><a href="#tab-img3" data-toggle="tab">图标</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2 dashed-line"></div>
                        </div>
                        <div class="form-group">
                            <div class="tab-content">
                                <!-- 图片上传区域 -->
                                <div class="tab-pane active" id="tab-img1">
                                    <div class="col-sm-8 col-sm-offset-2">
                                        <!-- 图片上传 -->
                                        <upload-img :img-src.sync="productDetails.pic_banner" file-id="file1" upload-id="upload-1"></upload-img>
                                    </div>
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <small class="text-muted">建议尺寸：750 x 400像素，JPG大小1M以内，PSD不限，图片非白底，左下角请不要添加文案</small>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-img2">
                                    <div class="col-sm-8 col-sm-offset-2">
                                        <!-- 图片上传 -->
                                        <upload-img :img-src.sync="productDetails.pic_thumb" file-id="file2" upload-id="upload-2"></upload-img>
                                    </div>
                                    <div class="col-sm-12 col-sm-offset-2">
                                        <small class="text-muted">建议尺寸：180 x 140像素，JPG大小40K以内，PSD不限，图片非白底</small>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-img3">
                                    <div class="col-sm-8 col-sm-offset-2">
                                        <!-- 图片上传 -->
                                        <upload-img :img-src.sync="productDetails.pic_icon" file-id="file3" upload-id="upload-3"></upload-img>
                                    </div>
                                    <div class="col-sm-12 col-sm-offset-2">
                                        <small class="text-muted">建议尺寸：100 x 70像素，JPG大小40K以内，PSD不限，列表图需要灰底，色号：f8f8f8</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </panel>
            <!-- 兑换规则模块，含switch模块 -->
            <panel title="兑换规则">
                <div slot="panel-body" class="panel-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                <span>需要积分：</span>
                            </label>
                            <div class="col-sm-6">
                                <input class="form-control input-sm" type="text" placeholder="请输入所需积分" v-model="productDetails.integral">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                <span>用户兑换限制：</span>
                            </label>
                            <div class="col-sm-5">
                                <input class="form-control input-sm" type="text" placeholder="请输入用户兑换限制" v-model="productDetails.limit">
                            </div>
                            <div class="col-sm-1">
                                <select class="form-control input-sm">
                                    <option>永久</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                <span>额外兑换限制：</span>
                            </label>
                            <div class="col-sm-6 padding-top-5">
                                <!-- switch组件 -->
                                <switch-input :callback="limit" :exchange-limit="exchangeLimit"></switch-input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                <span>每日兑换限制：</span>
                            </label>
                            <div class="col-sm-5">
                                <input class="form-control input-sm" type="text" placeholder="请输入每日兑换限制" disabled="{{!exchangeLimit}}" v-model="productDetails.day_limit">
                            </div>
                            <div class="col-sm-1">
                                <select class="form-control input-sm">
                                    <option>次</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                <span>兑换日期限制：</span>
                            </label>
                            <div class="col-sm-2">
                                <input class="form-control input-sm col-sm-2" type="date" disabled="{{!exchangeLimit}}" v-model="productDetails.start_date">
                            </div>
                            <div class="col-sm-1 text-center">
                                <span>至</span>
                            </div>
                            <div class="col-sm-2">
                                <input class="form-control input-sm col-sm-2" type="date" disabled="{{!exchangeLimit}}" v-model="productDetails.end_date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                <span>兑换时间限制：</span>
                            </label>
                            <div class="col-sm-2">
                                <input class="form-control input-sm col-sm-2" type="time" disabled="{{!exchangeLimit}}" v-model="productDetails.start_time">
                            </div>
                            <div class="col-sm-1 text-center">
                                <span>至</span>
                            </div>
                            <div class="col-sm-2">
                                <input class="form-control input-sm col-sm-2" type="time" disabled="{{!exchangeLimit}}" v-model="productDetails.end_time">
                            </div>
                        </div>
                    </form>
                </div>
            </panel>
            <!-- 点击调用新增商品函数 -->
            <button class="btn button-primary" v-if="!edit" @click.prevent="insertProduct()">保存添加</button>
            <!-- 点击调用保存编辑函数 -->
            <button class="btn button-primary" v-if="edit" @click.prevent="editProduct()">保存编辑</button>
        </div>
    </div>
</template>
<script>
import panel from '../../components/panel'; //引入panel组件
import uploadImg from '../../components/upload-img'; //引入图片上传组件
import commonApi from '../../libs/commonApi'; //引入封装好的ajax等函数
import switchInput from '../../components/switch-input'; //引入switch组件
export default {
    data() {
            return {
                productDetails: {}, //商品详情属性
                imgSrc: [, , ], //图片地址
                editor: {}, //富文本编辑器editor
                editorUse: {}, //富文本编辑器editorUse
                title: '', //标题
                productId: '', //接收从其他页面传进来的商品ID
                edit: false, //设置edit modal初始状态为隐藏
                exchangeLimit: false, //设置switch初始状态为false
                edited: false, //用于表示当前页面是否从编辑状态转入新增状态，当该参数为true时，清空富文本编辑器的值
                display: { //表示当前选项卡所处状态
                    step: 1
                }
            }
        },
        route: {
            data(transition) {
                //发生路由跳转时执行的代码
                this.clearCondition();
                if (transition.to.query.id) {
                    this.title = "编辑商品";
                    this.edit = true;
                    this.edited = true;
                    this.productId = transition.to.query.id;
                } else {
                    this.title = "添加商品";
                    this.edit = false;
                    this.productId = '';
                    //当edited为true时清空富文本编辑器的值
                    this.edited ? this.editor.setValue('') && this.editorUse.setValue('') : '';
                }
            }
        },
        ready() {
            this.initEditor(); //初始化富文本编辑器
            this.getProduct(); //获取商品信息
        },
        methods: {
            //初始化富文本编辑器函数
            initEditor() {
                this.editor = new Simditor({
                    textarea: $('#goodsDetails'),
                    placeholder: '',
                    params: {},
                    upload: true,
                    tabIndent: true,
                    toolbar: [
                        'title', 'bold', 'italic', 'underline', 'strikethrough', 'fontScale', 'color', 'ol', 'ul', 'blockquote', 'code', 'table', 'link', 'image', 'hr', 'alignment'
                    ],
                    toolbarFloat: true,
                    toolbarFloatOffset: 0,
                    pasteImage: true,
                    upload: {
                        url: 'http://integral.api.justtong.com/product/uploadimg',
                        params: null,
                        fileKey: 'upload_file',
                        connectionCount: 3
                    }
                });
                this.editorUse = new Simditor({
                    textarea: $('#goodsUse'),
                    placeholder: '',
                    params: {},
                    upload: true,
                    tabIndent: true,
                    toolbar: [
                        'title', 'bold', 'italic', 'underline', 'strikethrough', 'fontScale', 'color', 'ol', 'ul', 'blockquote', 'code', 'table', 'link', 'image', 'hr', 'alignment'
                    ],
                    toolbarFloat: true,
                    toolbarFloatOffset: 0,
                    pasteImage: true,
                    upload: {
                        url: 'http://integral.api.justtong.com/product/uploadimg',
                        params: null,
                        fileKey: 'upload_file',
                        connectionCount: 3,
                        leaveConfirm: '正在上传，确定要取消上传文件吗？'
                    }
                })
            },
            //新增商品函数
            insertProduct() {
                let param = this.productDetails;
                param.type = this.display.step;
                param.status = 1;
                param.content = this.editor.getValue();
                param.content_use = this.editorUse.getValue();
                param.content = this.resizeImg(param.content);
                param.content_use = this.resizeImg(param.content_use);
                this.requestApi("/product/insert", param, (response) => {
                    if (response.status == JST.SUCCESS) {
                        layer.msg("已保存，请前往添加券码", {
                            time: 1000
                        }, () => {
                            this.$route.router.go({
                                name: "goodsList"
                            });
                        });
                    } else {
                        layer.msg(response.info);
                    }
                })
            },
            //编辑商品函数
            editProduct() {
                let param = this.productDetails;
                param.content = this.editor.getValue();
                param.content_use = this.editorUse.getValue();
                param.content = this.resizeImg(param.content);
                param.content_use = this.resizeImg(param.content_use);
                this.requestApi("/product/update/" + this.productId, param, (response) => {
                    if (response.status == JST.SUCCESS) {
                        layer.msg("已保存", {
                            time: 1000
                        }, () => {
                            this.$route.router.go({
                                name: "goodsList"
                            });
                        });
                    } else {
                        layer.msg(response.info);
                    }
                })
            },
            //编辑时获取商品信息
            getProduct() {
                //设置富文本编辑器工具栏距顶部距离为50px
                $(".simditor-toolbar").css("top", "50px");
                // 当插入内容超出富文本编辑器限制宽度时隐藏内容并可进行水平滚动
                $(".simditor-body").css("overflow-x", "auto");
                if (this.productId) {
                    this.requestApi("/product/get/" + this.productId, {}, (response) => {
                        if (response.status == JST.SUCCESS) {
                            this.productDetails = response.data;
                            this.editor.setValue(this.productDetails.content);
                            this.editorUse.setValue(this.productDetails.content_use);
                            let start_date = response.data.start_date,
                                end_date = response.data.end_date;
                            this.productDetails.start_date = (start_date && start_date.split(' ')[0] != "0000-00-00") ? response.data.start_date.split(' ')[0] : "";
                            this.productDetails.end_date = (end_date && end_date.split(' ')[0] != "0000-00-00") ? response.data.end_date.split(' ')[0] : "";
                            let data = this.productDetails;
                            this.exchangeLimit = (data.day_limit || data.start_date || data.end_date || data.start_time || data.end_time) ? true : false;
                        } else {
                            layer.msg(response.info);
                        }
                    })
                }
            },
            //重置函数
            clearCondition() {
                this.productDetails = {
                        name: '',
                        type: '',
                        price: '',
                        integral: '',
                        content: '',
                        status: '',
                        limit: '',
                        day_limit: '',
                        start_date: '',
                        end_date: '',
                        start_time: '',
                        end_time: ''
                    },
                    this.exchangeLimit = false;
            },
            //更改switch状态函数
            limit() {
                this.exchangeLimit = !this.exchangeLimit;
            },
            //更改选项卡状态函数
            stepSwitch(step) {
                this.display.step = step;
                window.scrollTo(0, 0);
            },
            //返回函数
            back() {
                history.go(-1);
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
            }
        },
        components: {
            panel, //引入panel组件
            uploadImg, //引入uploadImg组件
            commonApi, //引入commonApi组件
            switchInput //引入switchInput组件
        },
        mixins: [commonApi] //拓展commonApi
}
</script>
