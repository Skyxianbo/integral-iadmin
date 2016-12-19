<style lang="sass" scoped>
#mask {
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.2);
    position: fixed;
    left: 0;
    top: 0;
    bottom: 0;
    display: none;
    z-index: 999;
}

.table {
    position: relative;
    background-color: white;
}

.z-index-1000 {
    z-index: 1000;
}
</style>
<template lang="html">
    <v-list title="Banner" :source.sync="source" :count.sync="count" :pages.sync="pages" :search="currentSearch" :list.sync="bannerList">
        <div slot="list-search">
            <div class="col-md-2 col-lg-1">
                <select class="form-control" v-model="currentSearch.type">
                    <option value="{{$index}}" v-for="t in type_str">{{t}}</option>
                </select>
            </div>
            <div class="col-md-2 col-lg-1">
                <select class="form-control" v-model="currentSearch.status">
                    <option value="{{$index}}" v-for="s in status_str">{{s}}</option>
                </select>
            </div>
            <div class="col-md-2 col-lg-1">
                <select class="form-control" v-model="currentSearch.origin_type">
                    <option :value="0">所有来源</option>
                    <option :value="1">坚果互动</option>
                    <option :value="2">电视台</option>
                </select>
            </div>
            <div class="col-md-3 col-lg-3">
                <input type="text" class="form-control" placeholder="请输入banner名称" v-model="currentSearch.name">
            </div>
        </div>
        <div slot="list-sortable">
            <div id="mask"></div>
            <div class="col-lg-1 col-lg-offset-3" :class="itemSort? 'z-index-1000': ''" v-if="status == 2 && source == 1">
                <button class="btn button-primary float-right" v-if="!itemSort" @click.prevent="sortItem()" style="width: 110px;">排序</button>
                <button class="button-sort float-right bg-sidebar" v-if="itemSort" @click.prevent="sortItemCancel()">取消</button>
                <button class="button-sort float-right bg-top" v-if="itemSort" @click.prevent="sortItemSave()">确定</button>
            </div>
        </div>
        <div slot="list-table">
            <table class="table" :class="itemSort? 'z-index-1000': ''">
                <thead>
                    <tr>
                        <th class="text-center" v-if="source == 1">
                            <input type="checkbox" v-model="allChecked" @click="checkedAll()" :disabled="itemSort">
                        </th>
                        <th>Banner名称</th>
                        <th>图片</th>
                        <th>跳转链接</th>
                        <th>状态</th>
                        <th>类型</th>
                        <th>来源</th>
                        <th>点击量</th>
                        <th v-if="source == 1">操作</th>
                        <th v-if="status == 2 && source == 1">排序</th>
                    </tr>
                </thead>
                <tbody id="sortableItems">
                    <tr class="sortable" v-for="item in bannerList" track-by="$index" data-value="{{$index}}" :disabled="itemSort">
                        <td class="text-center" v-if="source == 1">
                            <input type="checkbox" v-model="item.checked" @click="checked($index)" :disabled="itemSort">
                        </td>
                        <td>{{item.name}}</td>
                        <td>
                            <img :src="item.pic" alt="image">
                        </td>
                        <td>{{item.url}}</td>
                        <td>{{item.status_str}}</td>
                        <td>{{item.type_str}}</td>
                        <td>{{item.origin_type == 1? '坚果互动' : '电视台'}}</td>
                        <td>{{item.pv}}</td>
                        <td v-if="source == 1">
                            <div v-if="!itemSort">
                                <a @click="changeStatus(0, item)">{{item.status == 2? '下线' : '上线'}}</a>
                                <a @click="routerGo(item.id)">编辑</a>
                            </div>
                            <div v-else>
                                <span>{{item.status == 2? '下线' : '上线'}}</span>
                                <span>编辑</span>
                            </div>
                        </td>
                        <td v-if="status == 2 && source == 1">{{$index + 1}}<i class="fa fa-arrows margin-left-10" v-if="itemSort"></i></td>
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
            bannerList: [],
            source: 1,
            status: 2,
            count: 0,
            itemSort: false,
            allChecked: false,
            type_str: ["所有类型", "外链", "活动"],
            status_str: ["所有状态", "下线", "上线"],
            currentSearch: {
                type: 0,
                status: 2,
                origin_type: 1,
                name: ''
            },
            pages: {
                currentPage: 1,
                perPage: JST.PERPAGE,
                total: 0
            }
        }
    },
    ready() {},
    methods: {
        getList(type) {
            type ? this.layerLoad() : '';
            let param = this.currentSearch;
            this.status = this.currentSearch.status;
            this.requestApi('/banner/get_list', param, (response) => {
                this.bannerList = this.initList(response.data.list);
                this.pages.total = response.data.count;
                this.pages.currentPage = response.data.p;
                this.source = param.origin_type;
                this.count = 0;
                this.allChecked = false;
                window.scrollTo(0, 0);
            })
        },
        clearCondition() {
            this.currentSearch = {
                type: 0,
                status: 2,
                origin_type: 1,
                name: ''
            };
        },
        checkedAll() {
            this.count = 0;
            this.bannerList.forEach((x) => {
                x.checked = this.allChecked ? 0 : 1;
                x.checked == 1 ? this.count++ : '';
            })
        },
        checked(index) {
            let all = 1;
            this.count = 0;
            this.bannerList[index].checked = !this.bannerList[index].checked;
            this.bannerList.forEach((x) => {
                all = all && x.checked;
                x.checked == 1 ? this.count++ : '';
            });
            this.allChecked = all;
        },
        changeStatus(type, item) {
            if (type == 0) {
                let status = item.status == 1 ? 2 : 1;
                layer.msg(`确定${this.status_str[status]}该Banner吗？`, {
                    time: 0,
                    shade: 0.2,
                    shadeClose: true,
                    btn: ['确定', '取消'],
                    yes: (index) => {
                        layer.close(index);
                        this.requestApi('/banner/status/' + item.id, {
                            status: status
                        }, (response) => {
                            layer.msg(`操作成功，已${this.status_str[status]}1个Banner`);
                            this.getList();
                        })
                    }
                });
            } else {
                layer.msg(`确定批量${this.status_str[type]}选中Banner吗？`, {
                    time: 0,
                    shade: 0.2,
                    shadeClose: true,
                    btn: ['确定', '取消'],
                    yes: (index) => {
                        layer.close(index);
                        let id = [];
                        this.bannerList.forEach((x) => {
                            x.checked ? id.push(x.id) : '';
                        });
                        this.requestApi('/banner/status/' + id, {
                            status: type
                        }, (response) => {
                            layer.msg(`操作成功，已${this.status_str[type]}${id.length}个Banner`);
                            this.getList();
                        })
                    }
                });
            }
        },
        sortItem() {
            this.itemSort = true;
            let sortable = document.getElementById("sortableItems");
            this.sortable = Sortable.create(sortable);
            $('#mask').css('display', 'block');
        },
        sortItemSave() {
            this.itemSort = false;
            let result = [],
                param = [];
            $("tr[class=sortable]").each((x) => {
                result.push(this.bannerList[$("tr[class=sortable]").eq(x).attr("data-value")]);
            })
            let index = 1;
            result.forEach((x) => {
                let object = {
                    id: x.id,
                    order_id: index
                };
                param.push(object);
                index++;
            })
            param = JSON.stringify(param);
            this.requestApi('/banner/set_order', {
                data: param
            }, (response) => {
                layer.msg("已重新进行排序");
                $('#mask').css('display', 'none');
                this.getList();
                this.sortable.option("disabled", true);
            })
        },
        sortItemCancel() {
            this.itemSort = false;
            $('#mask').css('display', 'none');
            this.getList(1);
            this.sortable.option("disabled", true);
        },
        routerGo(id) {
            this.$route.router.go({
                name: "bannerEdit",
                query: {
                    id: id
                }
            })
        }
    }
}
</script>
