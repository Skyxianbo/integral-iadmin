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
    <!-- 标题 -->
    <div class="content-title">
        <span class="border-left-orange">{{title}}</span>
        <!-- 点击触发返回函数 -->
        <button class="btn btn-default margin-left-10" v-if="edit" @click.prevent="back()">返回商品列表</button>
    </div>
    <panel title="商品类型">
        <div slot="panel-body" class="panel-body">
            <!-- 点击更改选项卡状态 -->
            <ul class="nav nav-pills">
                <li :class="display['step']==1? 'active':''"><a @click.prevent="stepSwitch(1)" data-toggle="tab">刮刮卡</a></li>
                <li :class="display['step']==2? 'active':''"><a @click.prevent="stepSwitch(2)" data-toggle="tab">有奖问答</a></li>
            </ul>
        </div>
    </panel>
    <!-- 页面主要内容 -->
    <div class="content-body">
        <!-- 活动配置模块 -->
        <panel title="活动配置">
            <div slot="panel-body" class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>活动标题：</span>
                        </label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" placeholder="请输入活动标题" v-model="activityDetails.name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>活动说明：</span>
                        </label>
                        <div class="col-sm-8">
                            <textarea id="activity" placeholder="活动说明" autofocus></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>概率说明：</span>
                        </label>
                        <div class="col-sm-8 simditor-sm">
                            <textarea id="probability" placeholder="概率说明" autofocus></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>活动图片：</span>
                        </label>
                        <div class="col-sm-8">
                            <!-- 图片上传区域选项卡 -->
                            <ul class="nav nav-pills">
                                <li class="active col-sm-2"><a href="#tab-img1" data-toggle="tab">活动主题图</a></li>
                                <li class="col-sm-2"><a href="#tab-img2" data-toggle="tab">首页Banner</a></li>
                                <li class="col-sm-2"><a href="#tab-img3" data-toggle="tab">缩略图</a></li>
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
                                    <!-- 图片上传组件 -->
                                    <upload-img :img-src.sync="activityDetails.pic_icon" file-id="file1" upload-id="pic1"></upload-img>
                                </div>
                                <div class="col-sm-10 col-sm-offset-2">
                                    <small class="text-muted">建议尺寸：750 x 400像素，JPG大小1M以内，PSD不限，图片非白底，左下角请不要添加文案</small>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-img2">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <!-- 图片上传组件 -->
                                    <upload-img :img-src.sync="activityDetails.pic_banner" file-id="file2" upload-id="pic2"></upload-img>
                                </div>
                                <div class="col-sm-10 col-sm-offset-2">
                                    <small class="text-muted">建议尺寸：750 x 400像素，JPG大小1M以内，PSD不限，图片非白底，左下角请不要添加文案</small>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-img3">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <!-- 图片上传组件 -->
                                    <upload-img :img-src.sync="activityDetails.pic_thumb" file-id="file3" upload-id="pic3"></upload-img>
                                </div>
                                <div class="col-sm-12 col-sm-offset-2">
                                    <small class="text-muted">建议尺寸：180 x 140像素，JPG大小40K以内，PSD不限，图片非白底</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </panel>
        <!-- 配置规则模块 -->
        <panel title="配置规则">
            <div slot="panel-body" class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>消耗积分：</span>
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" placeholder="请输入所需积分" v-model="activityDetails.integral">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>用户永久参与次数：</span>
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" placeholder="请输入用户永久参与次数" v-model="activityDetails.limit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>免费永久参与次数：</span>
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" placeholder="请输入免费永久参与次数" v-model="activityDetails.free">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>用户每天参与次数：</span>
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" placeholder="请输入用户每天参与次数" v-model="activityDetails.day_limit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>免费每天参与次数：</span>
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" placeholder="请输入每天免费参与次数" v-model="activityDetails.day_free">
                        </div>
                    </div>
                </form>
            </div>
        </panel>
        <div class="tab-content">
            <div class="tab-pane" :class="display['step']==1? 'active':''">
            </div>
            <div class="tab-pane" :class="display['step']==2? 'active':''">
                <!-- 问题配置模块 -->
                <panel title="问题配置">
                    <div slot="panel-body" class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-sm-2">
                                    <span>问题标题：</span>
                                </label>
                                <div class="col-sm-8">
                                    <textarea cols="80" v-model="questions.question"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">
                                    <span>问题选项：</span>
                                </label>
                                <div class="col-sm-8">
                                    <table class="table margin-top-20">
                                        <thead>
                                            <tr>
                                                <th>排序</th>
                                                <th>选项标题</th>
                                                <th>正确选项</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in activityOption">
                                                <td>{{item.optionid}}</td>
                                                <td>{{item.option}}</td>
                                                <td>
                                                    <input type="checkbox" v-model="item.isanswer">
                                                </td>
                                                <td>
                                                    <!-- 点击触发问题编辑函数 -->
                                                    <a @click.prevent="editOptionModal($index)">编辑</a>
                                                    <!-- 点击触发问题删除函数 -->
                                                    <a @click.prevent="deleteOption($index)">删除</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <!-- 点击触发添加问题答案选项函数 -->
                                                    <button class="btn button-default" @click.prevent="addOptionModal()">添加选项</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </panel>
            </div>
        </div>
        <!-- 奖品配置模块 -->
        <panel title="奖品配置">
            <div slot="panel-body" class="panel-body">
                <table class="table margin-top-20">
                    <thead>
                        <tr>
                            <th>排序</th>
                            <th>图片</th>
                            <th>奖项</th>
                            <th>中奖概率</th>
                            <th>中奖限制</th>
                            <th>保底人数</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in activityItems" track-by="$index">
                            <td>{{$index + 1}}</td>
                            <td>
                                <img :src="item.pic" alt="image" style="width: 45px;">
                            </td>
                            <td>{{itemType[item.type - 1]}}</td>
                            <td>{{item.prob}}</td>
                            <td>{{item.limit}}</td>
                            <td>{{item.least}}</td>
                            <td>
                                <!-- 点击触发奖品编辑函数 -->
                                <a @click.prevent="editItemModal($index)">编辑</a>
                                <!-- 点击触发奖品删除函数 -->
                                <a @click.prevent="deleteItem($index)">删除</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- 点击触发添加奖品函数 -->
                <button class="btn button-default" @click.prevent="addItemModal()">添加奖品</button>
            </div>
        </panel>
        <!-- 点击触发保存添加函数 -->
        <button class="btn button-primary" v-if="!activityId" @click.prevent="insertActivity()">保存添加</button>
        <!-- 点击触发保存编辑函数 -->
        <button class="btn button-primary" v-if="activityId" @click.prevent="editActivity()">保存编辑</button>
    </div>
    <!-- 增加奖品模态框 -->
    <modal :show.sync="addItem" :title="itemTitle" cancel-text="取消" ok-text="保存" width="750px" :callback="itemIsEdit == 1 ? editItemSave : addItemSave">
        <div slot="modal-body" class="modal-body">
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <span>选择奖品：</span>
                    </label>
                    <div class="col-sm-3">
                        <!-- 点击获取对应种类奖品列表 -->
                        <select class="form-control input-sm" v-model="item.type" @change="getProductList(item.type)">
                            <option value="{{$index + 1}}" v-for="type in itemType">{{type}}</option>
                        </select>
                    </div>
                    <div class="col-sm-5" v-if="item.type">
                        <!-- 引入select-input组件 -->
                        <select-input :return-value.sync="item.product_id" :input-value.sync="item.name" :options="productList" :current-product.sync="currentProduct"></select-input>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <span>奖品信息：</span>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control input-sm" type="text" placeholder="展示奖品信息文案" v-model="item.desc">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <span>中奖概率：</span>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control input-sm" type="text" placeholder="中奖几率最大为1" v-model="item.prob">
                    </div>
                </div>
                <!-- <div class="form-group" v-if="!(item.type == 3)">
                <label class="col-sm-3 control-label">
                    <span>中奖限制：</span>
                </label>
                <div class="col-sm-6">
                    <input class="form-control input-sm" type="text" placeholder="每个用户最多能抽中该奖品的限制，不填则为无限制" v-model="item.limit">
                </div>
                <div class="col-sm-2">
                    <select class="form-control input-sm">
                        <option>次</option>
                    </select>
                </div>
            </div>
            <div class="form-group" v-if="!(item.type == 3)">
                <label class="col-sm-3 control-label">
                    <span>保底人数：</span>
                </label>
                <div class="col-sm-6">
                    <input class="form-control input-sm" type="text" placeholder="参与人数达到保底人数之后才会产生该选项，不填为无限制" v-model="item.least">
                </div>
                <div class="col-sm-2">
                    <select class="form-control input-sm">
                        <option>位</option>
                    </select>
                </div>
            </div> -->
            </form>
        </div>
    </modal>
    <!-- 添加问题选项模态框 -->
    <modal :show.sync="addOption" :title="optionTitle" cancel-text="取消" ok-text="确认" :callback="optionIsEdit == 1 ? editOptionSave : addOptionSave">
        <div slot="modal-body" class="modal-body">
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-3">
                        <span>选项标题：</span>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control input-sm" type="text" placeholder="请输入选项标题" v-model="option.option">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">
                        <span>答案选项：</span>
                    </label>
                    <div class="col-sm-3">
                        <select class="form-control input-sm" v-model="option.optionid">
                            <option value="{{option}}" v-for="option in optionList">{{option}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">
                        <span>是否正确选项：</span>
                    </label>
                    <div class="col-sm-3">
                        <select class="form-control input-sm" v-model="option.isanswer">
                            <option value="1">是</option>
                            <option value="0">否</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </modal>
</template>
<script>
import panel from '../../components/panel'; //引入panel
import modal from '../../components/modal'; //引入modal
import uploadImg from '../../components/upload-img'; //引入图片上传
import selectInput from '../../components/select-input'; //引入select和input结合框
export default {
    data() {
            return {
                activityDetails: {}, //活动详情属性
                activityItems: [], //活动奖项列表
                activityOption: [], //活动问题选项列表
                questions: {}, //活动问题
                item: {}, //当前奖项
                currentProduct: {}, //奖品选项中，当前商品
                display: { //表示当前选项卡所处状态
                    step: 1
                },
                currentStep: '', //当前活动类型
                option: { //问题选项
                    id: '',
                    activity_question_id: '',
                    optionid: '',
                    option: '',
                    isanswer: ''
                },
                title: '', //标题
                itemTitle: '', //奖项标题
                optionTitle: '', //问题选项标题
                activityId: '', //活动ID
                currentItem: '', //当前奖项
                currentOption: '', //当前问题选项
                editor: {}, //活动说明富文本编辑器
                editorProb: {}, //概率说明富文本编辑器
                edit: false, //表示当前页面处于增加/编辑状态，true为编辑，false为增加
                edited: false, //表示当前页面是否由编辑状态转入增加状态
                exchangeLimit: false, //switch-input状态
                addItem: false, //增加奖项模态框控制
                addOption: false, //增加问题选项模态框控制
                itemIsEdit: false, //表示当前奖项是否处于编辑状态
                optionIsEdit: false, //表示当前问题选项是否处于编辑状态
                itemType: ["优惠券", "实物", "积分赠送", "谢谢参与"], //奖项类型
                optionList: ["A", "B", "C", "D", "E", "F"], //选项类型列表
                productList: [] //奖项对应类型商品列表
            }
        },
        route: {
            data(transition) {
                // 路由跳转时执行代码
                if (transition.to.query.id) {
                    this.title = "编辑活动";
                    this.edit = true;
                    this.edited = true;
                    this.activityId = transition.to.query.id;
                } else {
                    this.title = "添加活动";
                    this.edit = false;
                    this.activityId = '';
                    this.clearCondition();
                    this.edited ? this.editor.setValue('') && this.editorProb.setValue('') : '';
                }
            }
        },
        ready() {
            this.initEditor(); //调用初始化富文本编辑器函数
            this.getActivity(); //调用获取活动函数
        },
        methods: {
            // 初始化富文本编辑器函数
            initEditor() {
                this.editor = new Simditor({
                    textarea: $('#activity'),
                    placeholder: '',
                    params: {},
                    upload: true,
                    tabIndent: true,
                    toolbar: [
                        'title', 'bold', 'italic', 'underline', 'strikethrough', 'fontScale', 'color', 'ol', 'ul', 'blockquote', 'code', 'table', 'link', 'image', 'hr', 'indent', 'outdent', 'alignment'
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
                });
                this.editorProb = new Simditor({
                    textarea: $('#probability'),
                    placeholder: '',
                    params: {},
                    upload: true,
                    tabIndent: true,
                    toolbar: [
                        'title', 'bold', 'italic', 'underline', 'strikethrough', 'fontScale', 'color', 'ol', 'ul', 'blockquote', 'code', 'table', 'link', 'image', 'hr', 'indent', 'outdent', 'alignment'
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
                });
            },
            // 增加活动函数
            insertActivity() {
                let sum = 0;
                this.activityItems.map((x) => {
                    sum = sum + (x.prob - 0);
                })
                if (sum != 1) {
                    layer.msg("所有奖项的中奖概率和不为1！");
                    return false;
                }
                let param = this.activityDetails;
                param.questions = [];
                param.type = this.display.step;
                param.status = 1;
                param.content = this.editor.getValue();
                param.content_prob = this.editorProb.getValue();
                param.items = JSON.stringify(this.activityItems);
                this.questions.answers = this.activityOption;
                param.questions.push(this.questions);
                param.questions = JSON.stringify(param.questions);
                param.content = this.resizeImg(param.content);
                param.content_prob = this.resizeImg(param.content_prob);
                this.requestApi("/activity/insert", param, (response) => {
                    if (response.status == JST.SUCCESS) {
                        layer.msg("已保存，请前往查询活动页面上架");
                        this.$route.router.go({
                            name: "activityList"
                        });
                    } else {
                        layer.msg(response.info);
                    }
                })
            },
            // 重置函数
            clearCondition() {
                this.activityDetails = {};
                this.activityItems = [];
                this.questions = [];
                this.activityOption = [];
            },
            // 编辑状态时获取活动函数
            getActivity() {
                $(".simditor-toolbar").css("top", "50px");
                $(".simditor-body").css("overflow-x", "auto");
                if (this.activityId) {
                    this.requestApi("/activity/get/" + this.activityId, {}, (response) => {
                        if (response.status == JST.SUCCESS) {
                            this.activityDetails = response.data;
                            this.activityItems = response.data.items;
                            this.questions = response.data.questions ? response.data.questions[0] : [];
                            this.activityOption = this.questions.answers ? this.questions.answers : [];
                            this.editor.setValue(this.activityDetails.content);
                            this.editorProb.setValue(this.activityDetails.content_prob);
                            this.display.step = response.data.type;
                            this.currentStep = response.data.type;
                        } else {
                            layer.msg(response.info);
                        }
                    })
                }
            },
            // 编辑活动函数
            editActivity() {
                if (this.display.step != this.currentStep) {
                    layer.msg("编辑时不允许修改活动类型！");
                    return false;
                }
                let sum = 0;
                this.activityItems.map((x) => {
                    sum = sum + (x.prob - 0) * 1000000;
                })
                if (sum != 1000000) {
                    layer.msg("所有奖项的中奖概率和不为1！");
                    return false;
                }
                let param = this.activityDetails;
                param.type = this.display.step;
                param.status = 1;
                param.content = this.editor.getValue();
                param.content_prob = this.editorProb.getValue();
                param.items = JSON.stringify(this.activityItems);
                this.questions.answers = this.activityOption;
                this.display.step == 2 ? param.questions[0] = this.questions : param.questions = [];
                param.questions = JSON.stringify(param.questions);
                param.content = this.resizeImg(param.content);
                param.content_prob = this.resizeImg(param.content_prob);
                this.requestApi("/activity/update/" + this.activityId, param, (response) => {
                    if (response.status == JST.SUCCESS) {
                        layer.msg("已保存编辑");
                        this.$route.router.go({
                            name: "activityList"
                        });
                    } else {
                        layer.msg(response.info);
                    }
                })
            },
            // 更改switch-input状态函数
            limit() {
                this.exchangeLimit = !this.exchangeLimit;
            },
            // 增加奖项模态框函数
            addItemModal() {
                this.itemIsEdit = false;
                this.addItem = true;
                this.itemTitle = "添加奖品";
                this.item = {};
            },
            // 增加奖项保存函数
            addItemSave() {
                this.item.stocks = this.currentProduct.stocks;
                this.item.pic = this.currentProduct.pic_thumb;
                this.item.limit = '0';
                this.item.least = '0';
                this.activityItems.push(this.item);
                this.addItem = false;
            },
            // 编辑奖项模态框函数
            editItemModal(index) {
                this.addItem = true;
                this.itemTitle = "编辑奖品";
                this.itemIsEdit = true;
                this.item = this.clone(this.activityItems[index]);
                this.currentItem = index;
                this.currentProduct = this.item;
            },
            // 编辑奖项保存函数
            editItemSave() {
                if (this.item.id != this.currentProduct.id) {
                    this.item.stocks = this.currentProduct.stocks;
                    this.item.pic = this.currentProduct.pic_thumb;
                }
                let index = this.currentItem;
                this.activityItems.$set(index, this.item);
                this.addItem = false;
                this.item = {};
            },
            // 删除奖项函数
            deleteItem(index) {
                this.activityItems.splice(index, 1);
                layer.msg("已删除");
            },
            // 获取奖品对应类型列表
            getProductList(type) {
                let param = {
                    type: type,
                    status: '',
                    name: ''
                }
                this.requestApi("/product/get_list", param, (response) => {
                    if (response.status == JST.SUCCESS) {
                        this.productList = response.data.list;
                    } else {
                        layer.msg(response.info);
                    }
                })
            },
            // 增加问题选项模态框函数
            addOptionModal() {
                this.addOption = true;
                this.optionIsEdit = false;
                this.optionTitle = "添加问题选项";
            },
            // 增加问题选项保存函数
            addOptionSave() {
                if (this.option.optionid && this.option.option && this.option.isanswer) {
                    this.option.activity_question_id = this.questions.id;
                    this.activityOption.push(this.option)
                    this.addOption = false;
                    this.option.isanswer = this.option.isanswer == "1" ? true : false;
                    this.option = {};
                } else {
                    layer.msg("缺少必要的参数");
                }
            },
            // 编辑问题选项模态框函数
            editOptionModal(index) {
                this.addOption = true;
                this.optionTitle = "编辑问题选项";
                this.optionIsEdit = true;
                this.option = this.clone(this.activityOption[index]);
                this.currentOption = index;
            },
            // 编辑问题选项保存函数
            editOptionSave() {
                let index = this.currentOption;
                this.activityOption.$set(index, this.option);
                this.addOption = false;
                this.option = {};
            },
            // 删除问题选项函数
            deleteOption(index) {
                this.activityOption.splice(index, 1);
                layer.msg("已删除");
            },
            // 选项卡状态改变函数
            stepSwitch(step) {
                this.display.step = step;
                window.scrollTo(0, 0);
            },
            // 返回函数
            back() {
                history.go(-1);
            },
            // 深度克隆函数
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
            modal, //引入模态框组件
            uploadImg, //引入上传图片组件
            selectInput //select-input组件
        }
}
</script>
