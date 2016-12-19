<style lang="sass">
</style>
<template lang="html">
    <header class="template-header">
        <span>{{title}}</span>
        <button class="btn btn-default" v-if="isEdit" @click.prevent="back()"><i class="fa fa-reply"></i> 返回客户列表</button>
    </header>
    <div class="content-body">
        <panel title="客户信息">
            <div slot="panel-body">
                <form class="form-horizontal margin-top-20">
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>电视台名称</span>
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" placeholder="请输入电视台名称" v-model="media.name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>账号</span>
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" placeholder="请输入电视台管理后台账号" v-model="media.accounts">
                        </div>
                    </div>
                    <div class="form-group" v-if="!isEdit">
                        <label class="control-label col-sm-2">
                            <span>密码</span>
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" value="123456" disabled="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>电话号码</span>
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" placeholder="绑定客户电话号码，用于找回密码" v-model="media.phone">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            <span>地域</span>
                        </label>
                        <div class="col-sm-2">
                            <select class="form-control" v-model="media.provinceid" @change="getCityList()">
                                <option value="">省份</option>
                                <option value="{{p.provinceid}}" v-for="p in provinceList">{{p.province}}</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" v-model="media.cityid">
                                <option value="">市</option>
                                <option value="{{c.cityid}}" v-for="c in cityList">{{c.city}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button id="btn" class="btn button-primary">保存</button>
                        </div>
                    </div>
                </form>
            </div>
        </panel>
    </div>
</template>
<script>
import panel from '../../components/panel.vue'; 
export default {
    components: {
        panel
    },
    data() {
        return {
            title: '',
            mediaId: '',
            provinceList: [],
            cityList: [],
            isEdit: false,            
            media: {
                province: '',
                provinceid: '',
                city: '',
                cityid: '',
                passwd: ''
            }
        }
    },
    route: {
        data(transition) {
            if (transition.to.query.id) {
                this.mediaId = transition.to.query.id;
                this.isEdit = true;
                this.title = '编辑客户';
            } else {
                this.isEdit = false;
                this.media = {
                    provinceid: '',
                    cityid: ''
                };
                this.title = '添加客户';
            }
        }
    },
    ready() {
        var btn = document.getElementById('btn');
        btn.addEventListener('click', this.debounce(this.save, 300))
        this.getMedia();
        this.getProvinceList();
    },
    methods: {
        getMedia() {
            if (this.mediaId) {
                this.requestApi('/media/get/' + this.mediaId, {}, (response) => {
                    this.media = response.data;
                    this.getCityList();
                })
            }
        },
        getProvinceList() {
            this.requestApi('/system/province_list', {}, (response) => {
                this.provinceList = response.data;
            })
        },
        getCityList() {
            this.requestApi('/system/city_list/' + this.media.provinceid, {}, (response) => {
                this.cityList = response.data;
            })
        },
        save() {
            let url = this.isEdit ? ('/media/update/' + this.mediaId) : '/media/insert';
            this.provinceList.forEach((x) => {
                if (x.provinceid == this.media.provinceid) {
                    this.media.province = x.province;
                }
            });
            this.cityList.forEach((x) => {
                if (x.cityid == this.media.cityid) {
                    this.media.city = x.city;
                }
            });
            this.requestApi(url, this.media, (response) => {
                layer.msg("已保存", {
                    time: 1000
                }, () => {
                    this.$route.router.go({
                        name: "mediaList"
                    })
                });
            })
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
