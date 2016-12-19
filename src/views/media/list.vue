<style lang="sass">
.table>thead>tr>th {
    vertical-align: middle;
}

.table>tbody>tr>td {
    vertical-align: middle;
}
</style>
<template lang="html">
    <v-list title="查询客户" :type="2" :source="1" :count.sync="count" :pages.sync="pages" :search="currentSearch" :list.sync="mediaList">
        <div slot="list-search">
            <div class="col-sm-2 col-lg-1">
                <select id="province" class="form-control" v-model="currentSearch.provinceid" @change="getCityList()">
                    <option value="">省份</option>
                    <option value="{{p.provinceid}}" v-for="p in provinceList">{{p.province}}</option>
                </select>
            </div>
            <div class="col-sm-2 col-lg-1">
                <select id="city" class="form-control" v-model="currentSearch.cityid">
                    <option value="">市</option>
                    <option value="{{c.cityid}}" v-for="c in cityList">{{c.city}}</option>
                </select>
            </div>
            <div class="col-sm-2 col-lg-1">
                <select class="form-control" v-model="currentSearch.status">
                    <option value="{{$index}}" v-for="s in status">{{s}}</option>
                </select>
            </div>
            <div class="col-sm-4 col-lg-3">
                <input class="form-control" type="text" placeholder="请输入电视台名称" v-model="currentSearch.name">
            </div>
        </div>
        <div slot="list-table">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">
                            <input type="checkbox" v-model="allChecked" @click="checkedAll()">
                        </th>
                        <th>电视台名称</th>
                        <th>账号</th>
                        <th>参数</th>
                        <th>电话</th>
                        <th>省份</th>
                        <th>市</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="item" v-for="item in mediaList">
                        <td class="text-center">
                            <input type="checkbox" v-model="item.checked" @click="checked($index)">
                        </td>
                        <td>{{item.name}}</td>
                        <td>{{item.accounts}}</td>
                        <td>{{item.media_id}}</td>
                        <td>{{item.phone}}</td>
                        <td>{{item.province}}</td>
                        <td>{{item.city}}</td>
                        <td>
                            <a @click="changeStatus(0, item)">{{item.status == 2? '停用' : '启用'}}</a>
                            <a @click="routerGo(item.id)" class="margin-left-10">编辑</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </v-list>
</template>
<script>
import vList from '../../components/v_list';
export default {
    components: {
        vList
    },
    data() {
        return {
            mediaList: [],
            provinceList: [],
            cityList: [],
            count: 0,
            allChecked: false,
            status: ["状态", "停用", "启用"],
            currentSearch: {
                provinceid: '',
                cityid: '',
                status: 2,
                name: ''
            },
            pages: {
                currentPage: 1,
                perPage: JST.PERPAGE,
                total: 0
            }
        }
    },
    ready() {
        this.getProvinceList();
    },
    methods: {
        getList(type) {
            type ? this.layerLoad() : '';
            let param = this.currentSearch;
            this.requestApi('/media/get_list', param, (response) => {
                this.mediaList = this.initList(response.data.list);
                this.pages.total = response.data.count;
                this.pages.currentPage = response.data.p;
                this.allChecked = false;
                window.scrollTo(0, 0);
            })
        },
        getProvinceList() {
            this.requestApi('/system/province_list', {}, (response) => {
                this.provinceList = response.data;
            });
        },
        getCityList() {
            this.requestApi('/system/city_list/' + this.currentSearch.provinceid, {}, (response) => {
                this.cityList = response.data;
            });

        },
        clearCondition() {
            this.currentSearch = {
                provinceid: '',
                cityid: '',
                status: 2,
                name: ''
            };
        },
        changeStatus(type, item) {
            if (type == 0) {
                let status = item.status == 1 ? 2 : 1;
                layer.msg(`确定${this.status[status]}该客户账号吗？`, {
                    time: 0,
                    shade: 0.2,
                    shadeClose: true,
                    btn: ['确定', '取消'],
                    yes: (index) => {
                        layer.close(index);
                        this.requestApi('/media/status/' + item.id, {
                            status: status
                        }, (response) => {
                            layer.msg(`操作成功，已${this.status[status]}1个客户账号`);
                            this.getList();
                        })
                    }
                });
            } else {
                layer.msg(`确定批量${this.status[type]}选中客户账号吗？`, {
                    time: 0,
                    shade: 0.2,
                    shadeClose: true,
                    btn: ['确定', '取消'],
                    yes: (index) => {
                        layer.close(index);
                        let id = [];
                        this.mediaList.forEach((x) => {
                            x.checked ? id.push(x.id) : '';
                        });
                        this.requestApi('/media/status/' + id, {
                            status: type
                        }, (response) => {
                            layer.msg(`操作成功，已${this.status[type]}${id.length}个客户账号`);
                            this.getList();
                        })
                    }
                });
            }
        },
        checked(index) {
            this.count = 0;
            this.mediaList[index].checked = !this.mediaList[index].checked;
            let all = 1;
            this.mediaList.forEach((x) => {
                all = all && x.checked;
                x.checked == 1 ? this.count++ : '';
            });
            this.allChecked = all;
        },
        checkedAll() {
            this.count = 0;
            this.mediaList.forEach((x) => {
                x.checked = this.allChecked ? 0 : 1;
                x.checked == 1 ? this.count++ : '';
            })
        },
        routerGo(id) {
            this.$route.router.go({
                name: 'mediaEdit',
                query: {
                    id: id
                }
            })
        }
    }
}
</script>
