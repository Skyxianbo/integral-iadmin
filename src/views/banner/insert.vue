<style lang="sass" scoped>
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
        <button class="btn btn-default" v-if="isEdit" @click.prevent="back()"><i class="fa fa-reply"></i> 返回商品列表</button>
    </header>
    <div class="content-body">
        <panel title="Banner类型">
            <div slot="panel-body" class="panel-body">
                <ul class="nav nav-pills" v-if="!isEdit">
                    <li :class="step == 1? 'active': ''"><a @click="stepSwitch(1)">外链</a></li>
                    <li :class="step == 2? 'active': ''"><a @click="stepSwitch(2)">活动</a></li>
                </ul>
                <ul class="nav nav-pills" v-else>
                    <li class="active" v-if="step == 1"><a>外链</a></li>
                    <li class="active" v-if="step == 2"><a>活动</a></li>
                </ul>
            </div>
        </panel>
        <panel title="选择活动" v-if="step == 2">
            <div slot="panel-body" class="panel-body">
                <div v-if="banner.id">
                    <span>已选活动：{{banner.name}}</span>
                    <a class="margin-left-10" @click="openModal(1)">修改</a>
                </div>
                <div v-else>
                    <ul class="nav nav-pills">
                        <li><a @click="openModal(1)">选择活动</a></li>
                    </ul>
                </div>
            </div>
        </panel>
        <panel title="展示信息">
            <div slot="panel-body" class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>Banner名称</span>
                        </label>
                        <div class="col-sm-6 col-lg-4">
                            <input class="form-control" type="text" placeholder="请输入Banner名称" v-model="banner.name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>跳转链接</span>
                        </label>
                        <div class="col-sm-6 col-lg-4">
                            <input type="text" class="form-control" placeholder="请输入跳转链接，如www.baidu.com" v-model="banner.url">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>Banner图片</span>
                        </label>
                        <div class="col-sm-6 padding-left-6">
                            <upload-img :img-src.sync="banner.pic" file-id="img1" upload-id="upload-1" width="400px" height="200px"></upload-img>
                        </div>
                        <div class="col-sm-6 col-sm-offset-2 margin-top-10">
                            <p class="text-red content-img">图片用作首页Banner位置显示，请使用 750x300 尺寸的图片，支持png/jpg格式</p>
                        </div>
                    </div>
                </form>
            </div>
        </panel>
        <button id="btn" class="btn button-primary">{{saveButton}}</button>
    </div>
    <modal :show.sync="activityModal" title="选择活动" :header="false" :footer="false" :width="1000">
        <div slot="modal-body" class="modal-body">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <div class="col-sm-2">
                        <select class="form-control input-sm" v-model="choiceActivity.type">
                            <option value="{{$index}}" v-for="type in activityType">{{type}}</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input-sm" placeholder="请输入活动名称" v-model="choiceActivity.name">
                    </div>
                    <div class="col-sm-1">
                        <a><i class="fa fa-search fa-2x color-black" @click="getActivityList()"></i></a>
                    </div>
                    <div class="col-sm-2">
                        <a><i class="fa fa-angle-left" @click="turnPage(0)"></i></a>
                        <a><i class="fa fa-angle-right" @click="turnPage(1)"></i></a>
                    </div>
                    <div class="col-sm-1">
                        <a @click="close"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="form-group border-black-1" style="margin: 10px 0px;" v-for="item in activityList">
                    <div class="col-sm-3">
                        <img alt="image" class="item-image" :src="item.pic_thumb">
                    </div>
                    <div class="col-sm-4">
                        <h4 class="margin-top-30">{{item.name}}</h4>
                    </div>
                    <div class="col-sm-3">
                        <h4 class="margin-top-30">{{item.type_str}}</h4>
                    </div>
                    <div class="col-sm-2 text-right">
                        <button class="btn button-primary margin-top-20" @click.prevent="activitySave(item)">选择</button>
                    </div>
                </div>
            </form>
        </div>
    </modal>
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
            activityList: [],
            activityItems: [],
            activityName: '',
            bannerId: '',
            title: '',
            saveButton: '',
            step: 1,
            isEdit: false,
            activityModal: false,
            activityType: ["所有类型", "刮刮卡", "有奖问答", "H5小游戏"],
            banner: {
                type: 1,
                id: '',
                url: '',
                pic: '',
                name: ''
            },
            choiceActivity: {
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
                this.bannerId = transition.to.query.id;
                this.title = "Banner编辑";
                this.saveButton = '保存编辑';
            } else {
                this.isEdit = false;
                this.title = "添加Banner";
                this.saveButton = '保存添加';
            }
        }
    },
    ready() {
        var btn = document.getElementById('btn');
        btn.addEventListener('click', this.debounce(this.bannerSave, 300));
        this.getBanner();
        this.getActivityList();
    },
    methods: {
        getBanner() {
            if (this.bannerId) {
                this.requestApi('/banner/get/' + this.bannerId, {}, (response) => {
                    this.banner = response.data;
                    this.step = this.banner.type;
                })
            }
        },
        bannerSave() {
            if (this.isEdit) {
                let param = this.banner;
                param.type = this.step;
                this.requestApi('/banner/update/' + param.id, param, (response) => {
                    layer.msg("已保存编辑", {
                        time: 1000
                    }, () => {
                        this.$route.router.go({
                            name: "bannerList"
                        });
                    });
                })
            } else {
                let param = this.banner;
                param.type = this.step;
                param.status = 1;
                this.requestApi('/banner/insert', param, (response) => {
                    layer.msg("已保存", {
                        time: 1000
                    }, () => {
                        this.$route.router.go({
                            name: "bannerList"
                        });
                    });
                })
            }
        },
        stepSwitch(step) {
            this.step = step;
            this.banner = {
                type: 1,
                id: '',
                url: '',
                pic: '',
                name: ''
            };
            window.scrollTo(0, 0);
        },
        openModal(type) {
            if (type) {
                this.activityModal = true;
            }
        },
        getActivityList() {
            let param = {
                name: this.choiceActivity.name,
                origin_type: 1,
                status: 2,
                type: this.choiceActivity.type,
                p: this.pages.currentPage,
                r: this.pages.perPage
            };
            this.requestApi('/activity/get_list', param, (response) => {
                this.activityList = response.data.list;
                this.pages.total = response.data.total;
            })
        },
        activitySave(item) {
            this.activityModal = false;
            this.banner.id = item.id;
            this.banner.name = item.name;
            this.banner.url = item.url;
            this.banner.pic = item.pic_banner;
        },
        turnPage(type) {
            if (type) {
                if (this.pages.currentPage < this.pages.total) {
                    this.pages.currentPage++;
                    this.getActivityList();
                } else if (this.pages.currentPage == this.pages.total) {
                    layer.msg("已经是最后一页了！");
                    return false;
                } else {
                    return false;
                }
            } else {
                if (this.pages.currentPage > 1) {
                    this.pages.currentPage--;
                    this.getActivityList();
                } else if (this.pages.currentPage == 1) {
                    layer.msg("已经是第一页了！");
                    return false;
                } else {
                    return false;
                }
            }
        },
        close() {
            this.activityModal = false;
            this.choiceActivity = {
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
