<style lang="sass" scoped>
.panel-body label {
    font-size: 14px;
    margin-left: 10px;
}

.panel-body>.form-horizontal>.form-group .nav>li>a {
    padding: 2px 10px;
}

.panel-body>.nav>li>a {
    height: 40px;
}

.line-height-14 {
    line-height: 14px;
}

.line-height-30 {
    line-height: 30px;
}
</style>
<template lang="html">
    <header class="template-header">
        <span>{{title}}</span>
        <button class="btn btn-default" v-if="edit" @click.prevent="back()"><i class="fa fa-reply"></i> 返回商品列表</button>
    </header>
    <panel title="商品类型">
        <div slot="panel-body" class="panel-body">
            <ul class="nav nav-pills" v-if="!edit">
                <li :class="step == 1? 'active':''"><a class="line-height-14" @click="stepSwitch(1)">优惠券<br>(唯一码)</a></li>
                <li :class="step == 6? 'active':''"><a class="line-height-14" @click="stepSwitch(6)">优惠券<br>(通用码)</a></li>
                <li :class="step == 5? 'active':''"><a class="line-height-14" @click="stepSwitch(5)">优惠券<br>(链接)</a></li>
                <li :class="step == 2? 'active':''"><a class="line-height-30" @click="stepSwitch(2)">实物</a></li>
                <li :class="step == 3? 'active':''"><a class="line-height-30" @click="stepSwitch(3)">积分赠送</a></li>
            </ul>
            <ul class="nav nav-pills" v-else>
                <li class="active" v-if="step == 1"><a class="line-height-14">优惠券<br>(唯一码)</a></li>
                <li class="active" v-if="step == 6"><a class="line-height-14">优惠券<br>(通用码)</a></li>
                <li class="active" v-if="step == 5"><a class="line-height-14">优惠券<br>(链接)</a></li>
                <li class="active" v-if="step == 2"><a class="line-height-30">实物</a></li>
                <li class="active" v-if="step == 3"><a class="line-height-30">积分赠送</a></li>
            </ul>
        </div>
    </panel>
    <div class="tab-content">
        <panel title="展示信息">
            <div slot="panel-body" class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>商品名称</span>
                        </label>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" placeholder="商品名称，用作后台显示及商品列表显示" v-model="productDetails.name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>显示名称</span>
                        </label>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" placeholder="显示名称，用做首页显示用" v-model="productDetails.name_show">
                        </div>
                    </div>
                    <div class="form-group" v-if="step == 6">
                        <label class="control-label col-sm-2">
                            <span>通用码</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" placeholder="填入通用码" v-model="productDetails.ticket_id">
                        </div>
                    </div>
                    <div class="form-group" v-if="step == 6 || step == 2">
                        <label class="control-label col-sm-2">
                            <span>库存数量</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" placeholder="填入库存数量，整数格式" v-model="productDetails.stocks">
                        </div>
                    </div>
                    <div class="form-group" v-if="step == 5">
                        <label class="control-label col-sm-2">
                            <span>跳转链接</span>
                        </label>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" placeholder="请输入完整跳转链接，比如http://www.taobao.com/coupon?bagId=123&from=nuthd" v-model="productDetails.url">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>市面价值</span>
                        </label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" placeholder="该商品的市场价格或原价，仅作展示" v-model="productDetails.price">
                        </div>
                        <div class="col-sm-1">
                            <select class="form-control" v-model="productDetails.price_unit">
                                <option value="元">元</option>
                                <option value="积分">积分</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>图文详情</span>
                        </label>
                        <div class="col-sm-8">
                            <textarea id="goodsDetails" placeholder="详细说明" autofocus></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>使用说明</span>
                        </label>
                        <div class="col-sm-8 simditor-sm">
                            <textarea id="goodsUse" placeholder="使用说明" autofocus></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" style="padding-top: 3px;">
                            <span>商品图片</span>
                        </label>
                        <div class="col-sm-8">
                            <ul class="nav nav-pills">
                                <li class="active" style="margin-left: 0;"><a href="#tab-img1" data-toggle="tab">详情图</a></li>
                                <li><a href="#tab-img2" data-toggle="tab">缩略图</a></li>
                                <li><a href="#tab-img3" data-toggle="tab">图标</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-img1">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <p class="text-red content-img">建议尺寸：750 x 400像素，JPG大小1M以内，PSD不限，图片非白底，左下角请不要添加文案</p>
                                </div>
                                <div class="col-sm-8 col-sm-offset-2">
                                    <upload-img :img-src.sync="productDetails.pic_banner" file-id="file1" upload-id="upload-1"></upload-img>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-img2">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <p class="text-red content-img">建议尺寸：300 x 200像素，JPG大小40K以内，PSD不限，图片非白底</p>
                                </div>
                                <div class="col-sm-8 col-sm-offset-2">
                                    <upload-img :img-src.sync="productDetails.pic_thumb" file-id="file2" upload-id="upload-2"></upload-img>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-img3">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <p class="text-red content-img">建议尺寸：100 x 70像素，JPG大小40K以内，PSD不限，列表图需要灰底，色号：f8f8f8</p>
                                </div>
                                <div class="col-sm-8 col-sm-offset-2">
                                    <upload-img :img-src.sync="productDetails.pic_icon" file-id="file3" upload-id="upload-3"></upload-img>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </panel>
        <panel title="兑换规则">
            <div slot="panel-body" class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>需要积分</span>
                        </label>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" placeholder="请输入所需积分" v-model="productDetails.integral">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>用户累计兑换限制</span>
                        </label>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" placeholder="每个用户累计最多可兑换的次数，0则无限制" v-model="productDetails.limit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>用户每日兑换限制</span>
                        </label>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" placeholder="每个用户每日最多可兑换的次数，0则无限制" v-model="productDetails.day_limit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>额外兑换限制</span>
                        </label>
                        <div class="col-sm-6 padding-top-9">
                            <switch-input :callback="limit" :exchange-limit="exchangeLimit"></switch-input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>每日限制额度</span>
                        </label>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" placeholder="每天最多可被兑换次数，0则无限制" disabled="{{!exchangeLimit}}" v-model="productDetails.day_all_limit">
                            <p class="text-red margin-top-10">您是否希望每天限额发放此兑换项</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>兑换日期限制</span>
                        </label>
                        <div class="col-sm-5 padding-left-0">
                            <div class="col-sm-5">
                                <input class="form-control" type="date" disabled="{{!exchangeLimit}}" v-model="productDetails.start_date">
                            </div>
                            <div class="col-sm-1 text-center padding-top-7">
                                <span>至</span>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="date" disabled="{{!exchangeLimit}}" v-model="productDetails.end_date">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>兑换时间限制</span>
                        </label>
                        <div class="col-sm-5 padding-left-0">
                            <div class="col-sm-5">
                                <input class="form-control" type="time" disabled="{{!exchangeLimit}}" v-model="productDetails.start_time">
                            </div>
                            <div class="col-sm-1 text-center padding-top-7">
                                <span>至</span>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="time" disabled="{{!exchangeLimit}}" v-model="productDetails.end_time">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </panel>
        <panel title="发货/取货设置" v-if="step == 2">
            <div slot="panel-body" class="panel-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>发货设置</span>
                        </label>
                        <div class="col-sm-9">
                            <label class="radio-inline col-lg-1 col-sm-2">
                                <input type="radio" name="inlineRadioOptions" id="radio1" value=1 v-model="productDetails.send_type">发货
                            </label>
                            <label class="radio-inline col-lg-1 col-sm-2">
                                <input type="radio" name="inlineRadioOptions" id="radio2" value=2 v-model="productDetails.send_type">取货
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>取货地址</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" placeholder="请输入取货地址" v-model="productDetails.take_address" :disabled="productDetails.send_type == 1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>取货时限</span>
                        </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder="请输入取货时限" v-model="productDetails.over_time" :disabled="productDetails.send_type == 1">
                        </div>
                        <div class="col-sm-1">
                            <select class="form-control" :disabled="productDetails.send_type == 1">
                                <option>天</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </panel>
        <panel title="其他">
            <div slot="panel-body" class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>开放资源</span>
                        </label>
                        <div class="col-sm-9">
                            <label class="radio-inline col-sm-1">
                                <input type="radio" name="inlineRadioOptions" id="inlineRadio1" v-model="productDetails.open_flag" value=1>是
                            </label>
                            <label class="radio-inline col-sm-1">
                                <input type="radio" name="inlineRadioOptions" id="inlineRadio2" v-model="productDetails.open_flag" value=2>否
                            </label>
                        </div>
                        <div class="col-sm-10 col-sm-offset-2 margin-top-10">
                            <span class="text-red padding-left-15">设置为开放资源之后，客户将可以使用此资源</span>
                        </div>
                    </div>
                </form>
            </div>
        </panel>
    </div>
    <footer>
        <button id="btn" class="btn button-primary" v-if="!edit">{{step == 1? '保存并导入券码' : '保存'}}</button>
        <button class="btn button-primary" v-if="edit" @click.prevent="editProduct()">保存编辑</button>
        <button class="btn button-primary" @click.prevent="preview()">预览</button>
    </footer>
    <phone-modal :show.sync="show">
        <div slot="modal-body">
            <product-preview :product-detail="productDetails"></product-preview>
        </div>
    </phone-modal>
</template>
<script>
import panel from '../../components/panel';
import uploadImg from '../../components/upload-img';
import switchInput from '../../components/switch-input';
import phoneModal from '../../components/phone-modal';
import productPreview from '../../components/preview/product_preview';
export default {
    components: {
        panel,
        uploadImg,
        switchInput,
        phoneModal,
        productPreview
    },
    data() {
        return {
            productDetails: {},
            editor: {},
            editorUse: {},
            step: '',
            title: '',
            productId: '',
            show: false,
            edit: false,
            exchangeLimit: false,
            edited: false
        }
    },
    route: {
        data(transition) {
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
                this.step = 1;
                this.edited ? this.editor.setValue('') && this.editorUse.setValue('') : '';
            }
        }
    },
    ready() {
        var btn = document.getElementById('btn');
        btn.addEventListener('click', this.debounce(this.insertProduct, 300))
        this.initEditor();
        this.getProduct();
    },
    methods: {
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
                    url: JST.HOST + '/product/uploadimg',
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
                    url: JST.HOST + '/product/uploadimg',
                    params: null,
                    fileKey: 'upload_file',
                    connectionCount: 3,
                    leaveConfirm: '正在上传，确定要取消上传文件吗？'
                }
            })
        },
        insertProduct() {
            let param = this.productDetails;
            param.type = this.step;
            param.content = this.resizeImg(this.resizeFontSize(this.editor.getValue()));
            param.content_use = this.resizeImg(this.resizeFontSize(this.editorUse.getValue()));
            this.requestApi("/product/insert", param, (response) => {
                let info = this.step == 1 ? "已保存，请前往添加券码" : "已保存";
                layer.msg(info, {
                    time: 1000
                }, () => {
                    this.$route.router.go({
                        name: "goodsList"
                    });
                });
            })
        },
        editProduct() {
            let param = this.productDetails;
            param.type = this.step;
            param.content = this.resizeImg(this.resizeFontSize(this.editor.getValue()));
            param.content_use = this.resizeImg(this.resizeFontSize(this.editorUse.getValue()));
            this.requestApi("/product/update/" + this.productId, param, (response) => {
                layer.msg("已保存", {
                    time: 1000
                }, () => {
                    this.$route.router.go({
                        name: "goodsList"
                    });
                });
            })
        },
        getProduct() {
            $(".simditor-toolbar").css("top", "50px");
            $(".simditor-body").css("overflow-x", "auto");
            if (this.productId) {
                this.requestApi("/product/get/" + this.productId, {}, (response) => {
                    this.step = response.data.type;
                    this.productDetails = response.data;
                    this.editor.setValue(this.productDetails.content);
                    this.editorUse.setValue(this.productDetails.content_use);
                    this.productDetails.start_date = response.data.start_date ? response.data.start_date.split(' ')[0] : '';
                    this.productDetails.end_date = response.data.end_date ? response.data.end_date.split(' ')[0]: '';
                    let data = this.productDetails;
                    this.exchangeLimit = (data.day_all_limit || data.start_date || data.end_date || data.start_time || data.end_time) ? true : false;
                })
            } else {
                this.step = 1;
            }
        },
        clearCondition() {
            this.productDetails = {
                name: '',
                type: '',
                price: '',
                price_unit: '元',
                integral: '',
                content: '',
                content_use: '',
                status: 1,
                name_show: '',
                url: '',
                send_type: 1,
                open_flag: 2
            };
            this.exchangeLimit = false;
        },
        limit() {
            this.exchangeLimit = !this.exchangeLimit;
        },
        stepSwitch(step) {
            this.step = step;
            window.scrollTo(0, 0);
        },
        preview() {
            this.productDetails.content = this.resizeImg(this.resizeFontSize(this.editor.getValue()));
            this.productDetails.content_use = this.resizeImg(this.resizeFontSize(this.editorUse.getValue()));
            this.show = true;
        },
        debounce(callback, delay) {
            var timer = null;
            return function() {
                clearTimeout(timer);
                timer = setTimeout(function() {
                    callback();
                }, delay)
            }
        }
    }
}
</script>
