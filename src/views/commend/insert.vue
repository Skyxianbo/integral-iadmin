<style lang="sass">
.color-black {
    color: #333
}

.border-black-1 {
    border: 1px solid #333;
}

.item-image {
    width: 80px;
    height: 40px;
    margin: 20px;
}

.content-img {
    margin-left: 0;
    padding-top: 10px;
    border-top: 1px dashed #333;
    border-bottom: none;
}

.padding-left-6 {
    padding-left: 6px;
}
</style>
<template lang="html">
    <header class="template-header">
        <span>{{title}}</span>
        <button class="btn btn-default" v-if="isEdit" @click="back()"><i class="fa fa-reply"></i> 返回推荐列表</button>
    </header>
    <div class="content-body">
        <panel title="Banner类型">
            <div slot="panel-body" class="panel-body">
                <ul class="nav nav-pills" v-if="!isEdit">
                    <li :class="step == 1? 'active': ''"><a @click="stepSwitch(1)">商品</a></li>
                    <li :class="step == 2? 'active': ''"><a @click="stepSwitch(2)">活动</a></li>
                </ul>
                <ul class="nav nav-pills" v-else>
                    <li class="active" v-if="step == 1"><a>商品</a></li>
                    <li class="active" v-if="step == 2"><a>活动</a></li>
                </ul>
            </div>
        </panel>
        <panel :title="step == 1? '选择商品' : '选择活动'">
            <div slot="panel-body" class="panel-body">
                <ul class="nav nav-pills" v-if="!commend.item_id">
                    <li><a @click="openModal()">{{buttonName[step - 1]}}</a></li>
                </ul>
                <div v-if="commend.item_id">
                    <span>已选活动：{{commend.item_name}}</span>
                    <a class="margin-left-10" @click="openModal()">修改</a>
                </div>
            </div>
        </panel>
        <panel title="展示信息">
            <div slot="panel-body" class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>主标题</span>
                        </label>
                        <div class="col-sm-6 col-lg-4">
                            <input class="form-control input-sm" type="text" placeholder="请输入主标题" v-model="commend.name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>副标题</span>
                        </label>
                        <div class="col-sm-6 col-lg-4">
                            <input type="text" class="form-control input-sm" placeholder="请输入副标题" v-model="commend.sub_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>角标</span>
                        </label>
                        <div class="col-sm-6 col-lg-4">
                            <input type="text" class="form-control input-sm" placeholder="请输入角标，2-4字" v-model="commend.script">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>主题图</span>
                        </label>
                        <div class="col-sm-6 padding-left-6">
                            <upload-img :img-src.sync="commend.pic" file-id="img1" upload-id="upload-1" width="400px" height="200px"></upload-img>
                        </div>
                        <div class="col-sm-6 col-sm-offset-2 margin-top-10">
                            <p class="text-red content-img">图片用作首页推荐位置显示，请使用 300x200 尺寸的图片，支持png/jpg格式</p>
                        </div>
                    </div>
                </form>
            </div>
        </panel>
        <button id="btn" class="btn button-primary">{{saveButton}}</button>
        <modal :show.sync="choiceModal" :title="buttonName[step - 1]" :header="false" :footer="false" :width="1000">
            <div slot="modal-body" class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-sm-2" v-if="step == 1">
                            <select class="form-control input-sm" v-model="choice.type">
                                <option value="">所有</option>
                                <option value="1">优惠券(唯一码)</option>
                                <option value="6">优惠券(通用码)</option>
                                <option value="5">优惠券(链接)</option>
                                <option value="2">实物</option>
                                <option value="3">积分赠送</option>
                            </select>
                        </div>
                        <div class="col-sm-2" v-if="step == 2">
                            <select class="form-control input-sm" v-model="choice.type">
                                <option value="{{$index}}" v-for="type in activityType">{{type}}</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control input-sm" placeholder="请输入关键字搜索" v-model="choice.name">
                        </div>
                        <div class="col-sm-1">
                            <a><i class="fa fa-search" @click="getList()"></i></a>
                        </div>
                        <div class="col-sm-2">
                            <a><i class="fa fa-angle-left" @click="turnPage(0)"></i></a>
                            <a><i class="fa fa-angle-right" @click="turnPage(1)"></i></a>
                        </div>
                        <div class="col-sm-1">
                            <a @click="close"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="form-group border-black-1" style="margin: 10px 0px;" v-for="item in list">
                        <div class="col-sm-3">
                            <img :src="item.pic_thumb" alt="image" class="item-image">
                        </div>
                        <div class="col-sm-4">
                            <h4 class="margin-top-30">{{item.name}}</h4>
                        </div>
                        <div class="col-sm-3">
                            <h4 class="margin-top-30">{{item.type_str}}</h4>
                        </div>
                        <div class="col-sm-2 text-right">
                            <button class="btn button-primary margin-top-20" @click.prevent="choiceSave(item)">选择</button>
                        </div>
                    </div>
                </form>
            </div>
        </modal>
    </div>
</template>
<script>
import panel from '../../components/panel.vue'; 
import modal from '../../components/modal.vue'; 
import uploadImg from '../../components/upload-img.vue'; 
export default {
    components: {
        panel,
        modal,
        uploadImg
    },
    data() {
        return {

            list: [],
            activityItems: [],
            commendId: '',
            title: '',
            saveButton: '',
            step: 1,
            isEdit: false,
            choiceModal: false,
            activityType: ["所有类型", "刮刮卡", "有奖问答", "H5小游戏"],
            buttonName: ["选择商品", "选择活动"],
            commend: {
                type: 1,
                name: '',
                sub_name: '',
                script: '',
                pic: '',
                item_id: '',
                item_type: '',
                item_name: ''
            },
            choice: {
                type: 0,
                name: ''
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
            if (transition.to.query.id) {
                this.isEdit = true;
                this.commendId = transition.to.query.id;
                this.title = "编辑推荐";
                this.saveButton = '保存编辑';
            } else {
                this.isEdit = false;
                this.title = "添加推荐";
                this.saveButton = '保存添加';
            }
        }
    },
    ready() {
        var btn = document.getElementById('btn');
        btn.addEventListener('click', this.debounce(this.commendSave, 300))
        this.getCommend();
        this.isEdit ? '' : this.getList();
    },
    methods: {
        getCommend() {
            if (this.isEdit) {
                this.requestApi('/commend/get/' + this.commendId, {}, (response) => {
                    this.commend = response.data;
                    this.step = this.commend.type;
                    this.getList();
                })
            }
        },
        commendSave() {
            let param = this.commend;
            param.type = this.step;
            let url = '';
            if (this.isEdit) {
                url = '/commend/update/' + param.id;
            } else {
                url = '/commend/insert';
                param.status = 1;
            }
            this.requestApi(url, param, (response) => {
                layer.msg("已保存", {
                    time: 1000
                }, () => {
                    this.$route.router.go({
                        name: "commendList"
                    });
                });
            })
        },
        getList() {
            let param = {
                name: this.choice.name,
                origin_type: 1,
                status: 2,
                type: this.choice.type,
                p: this.pages.currentPage,
                r: this.pages.perPage
            };
            let url = this.step == 1 ? '/product/get_list' : '/activity/get_list';
            this.requestApi(url, param, (response) => {
                this.list = response.data.list;
                this.pages.total = response.data.total;
            })
        },
        stepSwitch(step) {
            this.step = step;
            window.scrollTo(0, 0);
            this.choice = {
                type: 0,
                name: ''
            };
            this.commend = {
                type: 1,
                name: '',
                sub_name: '',
                script: '',
                pic: '',
                item_id: '',
                item_type: '',
                item_name: ''
            };
            this.getList();
        },
        openModal() {
            this.choiceModal = true;
            this.pages.currentPage = 1;
        },
        choiceSave(item) {
            this.choiceModal = false;
            this.commend.item_id = item.id;
            this.commend.item_name = item.name;
            this.commend.item_type = item.type;
            this.commend.pic = item.pic_thumb;
        },
        turnPage(type) {
            if (type) {
                if (this.pages.currentPage < this.pages.total) {
                    this.pages.currentPage++;
                    this.getList();
                } else if (this.pages.currentPage == this.pages.total) {
                    layer.msg("已经是最后一页了！");
                    return false;
                } else {
                    return false;
                }
            } else {
                if (this.pages.currentPage > 1) {
                    this.pages.currentPage--;
                    this.getList();
                } else if (this.pages.currentPage == 1) {
                    layer.msg("已经是第一页了！");
                    return false;
                } else {
                    return false;
                }
            }
        },
        close() {
            this.choiceModal = false;
            this.choice = {
                type: 0,
                name: ''
            }
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
