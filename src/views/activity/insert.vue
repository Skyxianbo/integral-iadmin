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
    padding: 8px 15px;
}

.button-default {
    width: auto;
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
                <li :class="step == 1? 'active':''"><a @click="stepSwitch(1)">刮刮卡</a></li>
                <li :class="step == 2? 'active':''"><a @click="stepSwitch(2)">有奖问答</a></li>
                <li :class="step == 3? 'active':''"><a @click="stepSwitch(3)">H5小游戏</a></li>
            </ul>
            <ul class="nav nav-pills" v-else>
                <li class="active" v-if="step == 1"><a>刮刮卡</a></li>
                <li class="active" v-if="step == 2"><a>有奖问答</a></li>
                <li class="active" v-if="step == 3"><a>H5小游戏</a></li>
            </ul>
        </div>
    </panel>
    <div class="content-body">
        <panel title="游戏选择" v-if="step == 3">
            <div slot="panel-body" class="panel-body">
                <div v-if="activityDetails.game_id">
                    <span>已选活动：{{activityDetails.game_name}}</span>
                    <a class="margin-left-10" @click="openGameModal()">修改</a>
                </div>
                <div v-else>
                    <ul class="nav nav-pills" v-if="!activityDetails.game_id">
                        <li><a @click="openGameModal()">选择游戏</a></li>
                    </ul>
                </div>
            </div>
        </panel>
        <panel title="活动配置">
            <div slot="panel-body" class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>活动标题</span>
                        </label>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" placeholder="请输入活动标题" v-model="activityDetails.name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>副标题</span>
                        </label>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" placeholder="请输入活动副标题" v-model="activityDetails.desc">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>活动说明</span>
                        </label>
                        <div class="col-sm-8">
                            <textarea id="activity" placeholder="活动说明" autofocus></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>概率说明</span>
                        </label>
                        <div class="col-sm-8 simditor-sm">
                            <textarea id="probability" placeholder="概率说明" autofocus></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" style="padding-top: 3px;">
                            <span>活动图片</span>
                        </label>
                        <div class="col-sm-8">
                            <ul class="nav nav-pills">
                                <li class="active" style="margin-left: 0;"><a href="#tab-img1" data-toggle="tab">活动主题图</a></li>
                                <li><a href="#tab-img2" data-toggle="tab">首页Banner</a></li>
                                <li><a href="#tab-img3" data-toggle="tab">缩略图</a></li>
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
                                    <upload-img :img-src.sync="activityDetails.pic_icon" file-id="file1" upload-id="pic1"></upload-img>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-img2">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <p class="text-red content-img">建议尺寸：750 x 400像素，JPG大小1M以内，PSD不限，图片非白底，左下角请不要添加文案</p>
                                </div>
                                <div class="col-sm-8 col-sm-offset-2">
                                    <upload-img :img-src.sync="activityDetails.pic_banner" file-id="file2" upload-id="pic2"></upload-img>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-img3">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <p class="text-red content-img">建议尺寸：300 x 200像素，JPG大小40K以内，PSD不限，图片非白底，左下角请不要添加文案</p>
                                </div>
                                <div class="col-sm-8 col-sm-offset-2">
                                    <upload-img :img-src.sync="activityDetails.pic_thumb" file-id="file3" upload-id="pic3"></upload-img>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </panel>
        <panel title="配置规则">
            <div slot="panel-body" class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>消耗积分</span>
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" placeholder="用户参与活动需要消耗的积分，可以为0，不填则默认为0" v-model="activityDetails.integral">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>用户累计参与次数</span>
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" placeholder="累计参与活动次数限制，0则不限制" v-model="activityDetails.limit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>用户每天参与限制</span>
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" placeholder="每天参与活动次数限制，0则不限制" v-model="activityDetails.day_limit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>用户累计免费次数</span>
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" placeholder="累计免费参与活动次数限制，0则不限制" v-model="activityDetails.free">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>用户每天免费次数</span>
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" placeholder="每天免费参与活动次数限制，0则不限制" v-model="activityDetails.day_free">
                        </div>
                    </div>
                </form>
            </div>
        </panel>
        <div class="tab-content">
            <div class="tab-pane" :class="step==1? 'active':''">
            </div>
            <div class="tab-pane" :class="step==2? 'active':''">
                <panel title="问题配置">
                    <div slot="panel-body" class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-sm-2">
                                    <span>问题标题</span>
                                </label>
                                <div class="col-sm-8">
                                    <textarea cols="80" v-model="questions.question"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">
                                    <span>问题选项</span>
                                </label>
                                <div class="col-sm-8">
                                    <table class="table">
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
                                                    <a @click.prevent="editOptionModal($index)">编辑</a>
                                                    <a @click.prevent="deleteOption($index)">删除</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
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
        <panel title="奖品配置">
            <div slot="panel-body" class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>图片</th>
                            <th>奖项</th>
                            <th>中奖概率</th>
                            <th>中奖限制</th>
                            <th>保底人数</th>
                            <th>剩余奖品数</th>
                            <th>是否显示</th>
                            <th>操作</th>
                            <th>排序</th>
                        </tr>
                    </thead>
                    <tbody id="sortableItems">
                        <tr v-for="item in activityItems" track-by="$index" data-value="{{$index}}" class="sortable">
                            <td>
                                <img :src="item.pic" alt="image" style="width: 45px;">
                            </td>
                            <td>{{itemType[item.type - 1]}}——{{item.name}}</td>
                            <td>{{item.prob}}</td>
                            <td>{{item.limit}}</td>
                            <td>{{item.least}}</td>
                            <td>{{item.stocks}}</td>
                            <td>{{item.is_visible == 1? '是' : '否'}}</td>
                            <td>
                                <a @click.prevent="editItemModal($index)">编辑</a>
                                <a @click.prevent="deleteItem($index)">删除</a>
                            </td>
                            <td>{{$index + 1}}<i class="fa fa-arrows margin-left-10" v-if="itemSort"></i></td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn button-default" @click.prevent="addItemModal(0)">添加坚果互动奖品</button>
                <button class="btn button-default margin-left-10" @click.prevent="addItemModal(1)">添加电视台奖品</button>
                <button class="btn button-primary float-right" v-if="!itemSort" @click.prevent="sortItem()" style="width: 110px;">排序</button>
                <button class="btn button-sort float-right bg-sidebar" v-if="itemSort" @click.prevent="sortItemCancel()">取消</button>
                <button class="btn button-sort float-right bg-top" v-if="itemSort" @click.prevent="sortItemSave()">确定</button>
            </div>
        </panel>
        <button id="btn" class="btn button-primary" v-if="!activityId">保存添加</button>
        <button class="btn button-primary" v-if="activityId" @click.prevent="editActivity()">保存编辑</button>
        <button class="btn button-primary margin-left-5" @click.prevent="preview()">预览</button>
    </div>
    <modal :show.sync="addItem" :title="itemTitle" cancel-text="取消" ok-text="保存" width="750px" :callback="itemIsEdit == 1 ? editItemSave : addItemSave">
        <div slot="modal-body" class="modal-body">
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <span>选择奖品</span>
                    </label>
                    <div class="col-sm-3">
                        <select class="form-control" v-model="item.type" @change="getProductList(item.type)">
                            <option value="">所有类型</option>
                            <option value="1">优惠券(唯一码)</option>
                            <option value="6">优惠券(通用码)</option>
                            <option value="5">优惠券(链接)</option>
                            <option value="2">实物</option>
                            <option value="3">积分赠送</option>
                            <option value="4">谢谢参与</option>
                        </select>
                    </div>
                    <div class="col-sm-5" v-if="item.type">
                        <select-input :return-value.sync="item.product_id" :input-value.sync="item.name" :options="productList" :current-product.sync="currentProduct"></select-input>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <span>奖品信息</span>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" placeholder="展示奖品信息文案" v-model="item.desc">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <span>中奖概率</span>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" placeholder="中奖几率最大为1" v-model="item.prob">
                    </div>
                </div>
                <div class="form-group" v-if="!(item.type == 3)">
                    <label class="col-sm-3 control-label">
                        <span>中奖限制</span>
                    </label>
                    <div class="col-sm-6">
                        <input class="form-control" type="text" placeholder="每个用户最多能抽中该奖品的限制，不填则为无限制" v-model="item.limit">
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control">
                            <option>次</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" v-if="!(item.type == 3)">
                    <label class="col-sm-3 control-label">
                        <span>保底人数</span>
                    </label>
                    <div class="col-sm-6">
                        <input class="form-control" type="text" placeholder="参与人数达到保底人数之后才会产生该选项，不填为无限制" v-model="item.least">
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control">
                            <option>位</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">
                        <span>是否显示</span>
                    </label>
                    <div class="col-sm-6">
                        <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio1" v-model="item.is_visible" value=1 checked="item.is_visible">是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio2" v-model="item.is_visible" value=0 checked="item.is_visible">否
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </modal>
    <modal :show.sync="addOption" :title="optionTitle" cancel-text="取消" ok-text="确认" :callback="optionIsEdit == 1 ? editOptionSave : addOptionSave">
        <div slot="modal-body" class="modal-body">
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-3">
                        <span>选项标题</span>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" placeholder="请输入选项标题" v-model="option.option">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">
                        <span>答案选项</span>
                    </label>
                    <div class="col-sm-3">
                        <select class="form-control" v-model="option.optionid">
                            <option value="{{option}}" v-for="option in optionList">{{option}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">
                        <span>是否正确选项</span>
                    </label>
                    <div class="col-sm-3">
                        <select class="form-control" v-model="option.isanswer">
                            <option value="1">是</option>
                            <option value="0">否</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </modal>
    <modal :show.sync="gameModal" title="选择活动" :header="false" :footer="false" :width="1000">
        <div slot="modal-body" class="modal-body">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="请输入关键字搜索" v-model="gameName">
                    </div>
                    <div class="col-sm-1">
                        <a><i class="fa fa-search" @click="getGameList()"></i></a>
                    </div>
                    <div class="col-sm-2">
                        <a><i class="fa fa-angle-left" @click="turnPage(0)"></i></a>
                        <a><i class="fa fa-angle-right" @click="turnPage(1)"></i></a>
                    </div>
                    <div class="col-sm-1">
                        <a @click="close"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="form-group border-black-1" style="margin: 10px 0;" v-for="item in gameList">
                    <div class="col-sm-3">
                        <img :src="item.pic" alt="image" class="item-image">
                    </div>
                    <div class="col-sm-5">
                        <h4 class="margin-top-30">{{item.name}}</h4>
                    </div>
                    <div class="col-sm-4 text-right margin-top-20">
                        <button class="btn button-primary" @click.prevent="gameSave(item.id, item.name)">选择</button>
                        <button class="btn button-primary" @click.prevent="gamePreview(item.name)">预览</button>
                    </div>
                </div>
            </form>
        </div>
    </modal>
    <phone-modal :show.sync="show">
        <div slot="modal-body">
            <activity-preview :activity-type.sync="type" :activity-detail="activityDetail" :show="show"></activity-preview>
        </div>
    </phone-modal>
    <phone-modal :show.sync="gameShow">
        <div slot="modal-body">
            <game-preview :game-type.sync="gameType" :game-detail="gameDetail" :name="gameName" :show="gameShow"></game-preview>
        </div>
    </phone-modal>
</template>
<script>
import panel from '../../components/panel';
import modal from '../../components/modal';
import uploadImg from '../../components/upload-img';
import selectInput from '../../components/select-input';
import phoneModal from '../../components/phone-modal.vue';
import activityPreview from '../../components/preview/activity_preview.vue';
import gamePreview from '../../components/preview/game_preview';
export default {
    components: {
        panel,
        modal,
        uploadImg,
        selectInput,
        phoneModal,
        activityPreview,
        gamePreview
    },
    data() {
        return {
            activityItems: [],
            activityOption: [],
            productList: [],
            gameList: [],
            editor: {},
            editorProb: {},
            sortable: {},
            questions: {},
            currentProduct: {},
            gameDetail: {},
            activityDetail: {},
            activityDetails: {},
            currentStep: '',
            title: '',
            itemTitle: '',
            optionTitle: '',
            activityId: '',
            currentItem: '',
            currentOption: '',
            gameName: '',
            type: 0,
            gameType: 0,
            step: 1,
            show: false,
            gameShow: false,
            edit: false,
            edited: false,
            exchangeLimit: false,
            addItem: false,
            addOption: false,
            itemIsEdit: false,
            itemForStation: false,
            itemSort: false,
            optionIsEdit: false,
            gameModal: false,
            itemType: ['优惠券(唯一码)', '实物', '积分赠送', '谢谢参与', '优惠券(链接)', '优惠券(通用码)'],
            optionList: ["A", "B", "C", "D", "E", "F"],
            item: {
                type: '',
                name: ''
            },
            option: {
                id: '',
                activity_question_id: '',
                optionid: '',
                option: '',
                isanswer: ''
            },
            pages: {
                currentPage: 1,
                perPage: 5,
                total: 0
            }
        }
    },
    route: {
        data(transition) {
            this.clearCondition();
            if (transition.to.query.id) {
                this.title = "编辑活动";
                this.edit = true;
                this.edited = true;
                this.activityId = transition.to.query.id;
            } else {
                this.title = "添加活动";
                this.edit = false;
                this.activityId = '';
                this.edited ? this.editor.setValue('') && this.editorProb.setValue('') : '';
            }
        }
    },
    watch: {
        show(value) {
            if (!value) {
                this.type = 0;
            }
        },
        gameShow(value) {
            if (!value) {
                this.gameType = 0;
            }
        }
    },
    ready() {
        var btn = document.getElementById('btn');
        btn.addEventListener('click', this.debounce(this.insertActivity, 300))
        this.initEditor();
        this.getActivity();
    },
    methods: {
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
                    url: JST.HOST + '/product/uploadimg',
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
                    url: JST.HOST + '/product/uploadimg',
                    params: null,
                    fileKey: 'upload_file',
                    connectionCount: 3,
                    leaveConfirm: '正在上传，确定要取消上传文件吗？'
                }
            });
        },
        insertActivity() {
            let sum = 0;
            this.activityItems.forEach((x) => {
                sum = sum + (x.prob - 0) * 1000000;
            })
            if (sum != 1000000) {
                layer.msg("所有奖项的中奖概率和不为1！");
                return false;
            };
            let param = this.activityDetails;
            param.questions = [];
            param.type = this.step;
            param.items = JSON.stringify(this.activityItems);
            this.questions.answers = this.activityOption;
            if (this.step == 2) {
                param.questions.push(this.questions);
                param.questions = JSON.stringify(param.questions);
            };
            param.content = this.resizeImg(this.resizeFontSize(this.editor.getValue()));
            param.content_prob = this.resizeImg(this.resizeFontSize(this.editorProb.getValue()));
            this.requestApi("/activity/insert", param, (response) => {
                layer.msg("已保存，请前往查询活动页面上架", {
                    time: 1000
                }, () => {
                    this.$route.router.go({
                        name: "activityList"
                    });
                });
            })
        },
        clearCondition() {
            this.activityDetails = {
                name: '',
                type: '',
                content: '',
                content_prob: '',
                integral: '',
                limit: '',
                day_limit: '',
                free: '',
                day_free: '',
                game_id: '',
                game_name: '',
                url: '',
                status: 1
            };
            this.item.name = {
                type: '',
                name: ''
            };
            this.activityItems = [];
            this.questions = {};
            this.activityOption = [];
        },
        getActivity() {
            $(".simditor-toolbar").css("top", "50px");
            $(".simditor-body").css("overflow-x", "auto");
            if (this.activityId) {
                this.requestApi("/activity/get/" + this.activityId, {}, (response) => {
                    this.activityDetails = response.data;
                    this.activityItems = response.data.items ? response.data.items : [];
                    this.questions = response.data.questions ? response.data.questions[0] : {};
                    this.activityOption = this.questions.answers ? this.questions.answers : [];
                    this.editor.setValue(this.activityDetails.content);
                    this.editorProb.setValue(this.activityDetails.content_prob);
                    this.step = response.data.type;
                    this.currentStep = response.data.type;
                    this.step == 3 ? this.getGameList() : '';
                })
            }
        },
        editActivity() {
            if (this.step != this.currentStep) {
                layer.msg("编辑时不允许修改活动类型！");
                return false;
            }
            let sum = 0;
            this.activityItems.forEach((x) => {
                sum = sum + (x.prob - 0) * 1000000;
            })
            if (sum != 1000000) {
                layer.msg("所有奖项的中奖概率和不为1！");
                return false;
            }
            let param = this.activityDetails;
            param.questions = [];
            param.type = this.step;
            param.items = JSON.stringify(this.activityItems);
            this.questions.answers = this.activityOption;
            if (this.step == 2) {
                param.questions.push(this.questions);
                param.questions = JSON.stringify(param.questions);
            };
            param.content = this.resizeImg(this.resizeFontSize(this.editor.getValue()));
            param.content_prob = this.resizeImg(this.resizeFontSize(this.editorProb.getValue()));
            this.requestApi("/activity/update/" + this.activityId, param, (response) => {
                layer.msg("已保存编辑", {
                    time: 1000
                }, () => {
                    this.$route.router.go({
                        name: "activityList"
                    });
                });
            })
        },
        limit() {
            this.exchangeLimit = !this.exchangeLimit;
        },
        addItemModal(type) {
            this.itemForStation = type ? true : false;
            this.itemIsEdit = false;
            this.addItem = true;
            this.itemTitle = "添加奖品";
            this.item = {
                type: '',
                name: '',
                is_visible: 1
            };
        },
        addItemSave() {
            if (!this.item.name) {
                layer.msg('请选择奖品');
                return false;
            } else if (!this.item.prob) {
                layer.msg('请输入中奖概率');
                return false;
            };
            this.item.stocks = this.currentProduct.stocks;
            this.item.pic = this.currentProduct.pic_thumb;
            this.item.limit = '0';
            this.item.least = '0';
            this.activityItems.push(this.item);
            this.addItem = false;
        },
        editItemModal(index) {
            this.addItem = true;
            this.itemTitle = "编辑奖品";
            this.itemIsEdit = true;
            this.item = this.clone(this.activityItems[index]);
            this.currentItem = index;
            this.currentProduct = this.item;
        },
        editItemSave() {
            if (!this.item.name) {
                layer.msg('请选择奖品');
                return false;
            } else if (!this.item.prob) {
                layer.msg('请输入中奖概率');
                return false;
            };
            if (this.item.id != this.currentProduct.id) {
                this.item.stocks = this.currentProduct.stocks;
                this.item.pic = this.currentProduct.pic_thumb;
            }
            let index = this.currentItem;
            this.activityItems.$set(index, this.item);
            console.log(this.activityItems);
            this.addItem = false;
            this.item = {};
        },
        deleteItem(index) {
            this.activityItems.splice(index, 1);
            layer.msg("已删除");
        },
        sortItem() {
            this.itemSort = true;
            var el = document.getElementById("sortableItems");
            this.sortable = Sortable.create(el);
        },
        sortItemSave() {
            let result = [];
            this.itemSort = false;
            $("tr[class=sortable]").each((x) => {
                result.push(this.activityItems[$("tr[class=sortable]").eq(x).attr("data-value")]);
            })
            this.activityItems = result;
            this.sortable.option("disabled", true);
            layer.msg("已重新进行排序");
        },
        sortItemCancel() {
            let result = [];
            this.itemSort = false;
            this.activityItems.forEach((x) => {
                result.push(x);
            })
            this.activityItems = result;
            this.sortable.option("disabled", true);
        },
        getProductList(type) {
            let param = {
                type: type,
                status: '',
                name: '',
                origin_type: this.itemForStation ? 2 : 1,
                r: 9999
            };
            this.item.name = '';
            this.requestApi("/product/get_list", param, (response) => {
                this.productList = response.data.list;
            })
        },
        addOptionModal() {
            this.addOption = true;
            this.optionIsEdit = false;
            this.optionTitle = "添加问题选项";
        },
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
        editOptionModal(index) {
            this.addOption = true;
            this.optionTitle = "编辑问题选项";
            this.optionIsEdit = true;
            this.option = this.clone(this.activityOption[index]);
            this.currentOption = index;
        },
        editOptionSave() {
            let index = this.currentOption;
            this.activityOption.$set(index, this.option);
            this.addOption = false;
            this.option = {};
        },
        deleteOption(index) {
            this.activityOption.splice(index, 1);
            layer.msg("已删除");
        },
        stepSwitch(step) {
            if (step == 3) {
                this.getGameList();
            }
            this.step = step;
            window.scrollTo(0, 0);
        },
        openGameModal() {
            this.gameModal = true;
        },
        getGameList() {
            let param = {
                status: 2,
                name: this.gameName,
                p: this.pages.currentPage,
                r: this.pages.perPage
            }
            this.requestApi('/game/get_list', param, (response) => {
                this.gameList = response.data.list;
                this.pages.total = response.data.total;
            })
        },
        gameSave(id, name) {
            this.gameModal = false;
            this.activityDetails.game_id = id;
            this.activityDetails.game_name = name;
        },
        turnPage(type) {
            if (type) {
                if (this.pages.currentPage < this.pages.total) {
                    this.pages.currentPage++;
                    this.getGameList();
                } else if (this.pages.currentPage == this.pages.total) {
                    layer.msg("已经是最后一页了！");
                    return false;
                } else {
                    return false;
                }
            } else {
                if (this.pages.currentPage > 1) {
                    this.pages.currentPage--;
                    this.getGameList();
                } else if (this.pages.currentPage == 1) {
                    layer.msg("已经是第一页了！");
                    return false;
                } else {
                    return false;
                }
            }
        },
        close() {
            this.gameModal = false;
            this.gameName = '';
        },
        preview() {
            let questions = [];
            questions.push(this.questions);
            this.type = this.step;
            this.activityDetail = {
                questions: questions,
                content: this.resizeImg(this.editor.getValue()),
                content_prob: this.resizeImg(this.editorProb.getValue()),
                items: this.activityItems
            };
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
        },
        gamePreview(name) {
            this.gameDetail = {};
            this.gameType = 3;
            this.gameName = name;
            this.gameShow = true;
        }
    }
}
</script>
