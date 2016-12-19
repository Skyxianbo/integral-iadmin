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
    <v-list title="推荐管理" :source.sync="source" :count.sync="count" :search="currentSearch" :list.sync="commendList">
        <div slot="list-search">
            <div class="col-sm-2 col-lg-1">
                <select class="form-control" v-model="currentSearch.type">
                    <option value="{{$index}}" v-for="t in type_str">{{t}}</option>
                </select>
            </div>
            <div class="col-sm-2 col-lg-1">
                <select class="form-control" v-model="currentSearch.status">
                    <option value="{{$index}}" v-for="s in status_str">{{s}}</option>
                </select>
            </div>
            <div class="col-sm-2 col-lg-1">
                <select class="form-control" v-model="currentSearch.origin_type">
                    <option :value="0">所有来源</option>
                    <option :value="1">坚果互动</option>
                    <option :value="2">电视台</option>
                </select>
            </div>
            <div class="col-sm-4 col-lg-3">
                <input type="text" class="form-control" placeholder="请输入推荐名称关键字" v-model="currentSearch.name">
            </div>
        </div>
        <div slot="list-sortable">
            <div id="mask"></div>
            <div class="col-lg-1 col-lg-offset-3" :class="itemSort? 'z-index-1000': ''" v-if="status == 2 && source == 1" style="z-index: 1000;">
                <button class="btn button-primary float-right" v-if="!itemSort" @click.prevent="sortItem()" style="width: 110px;">排序</button>
                <button class="button-sort float-right bg-sidebar" v-if="itemSort" @click.prevent="sortItemCancel()">取消</button>
                <button class="button-sort float-right bg-top" v-if="itemSort" @click.prevent="sortItemSave()">确定</button>
            </div>
        </div>
        <div slot="list-table">
            <table class="table" :class="itemSort? 'z-index-1000': ''">
                <thead>
                    <tr>
                        <th class="text-center">
                            <input type="checkbox" v-model="allChecked" @click="checkedAll()" :disabled="itemSort">
                        </th>
                        <th>推荐名称</th>
                        <th>图片</th>
                        <th>标签</th>
                        <th>形式</th>
                        <th>来源</th>
                        <th>类型</th>
                        <th>点击量</th>
                        <th v-if="source == 1">操作</th>
                        <th v-if="status == 2 && source == 1">排序</th>
                    </tr>
                </thead>
                <tbody id="sortableItems">
                    <tr class="sortable" v-for="item in commendList" data-value="{{$index}}">
                        <td class="text-center">
                            <input type="checkbox" v-model="item.checked" @click="checked($index)" :disabled="itemSort">
                        </td>
                        <td>{{item.name}}</td>
                        <td>
                            <img :src="item.pic" alt="image">
                        </td>
                        <td>{{item.script}}</td>
                        <td>{{item.item_type_str}}</td>
                        <td>{{item.origin_type == 1? '坚果互动' : '电视台'}}</td>
                        <td>{{item.type_str}}</td>
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
            commendList: [],
            source: 1,
            count: 0,
            status: 2,
            itemSort: false,
            allChecked: false,
            type_str: ["所有类型", "商品", "活动"],
            status_str: ["所有状态", "下线", "上线"],
            currentSearch: {
                type: 0,
                status: 2,
                origin_type: 1,
                name: ''
            }
        }
    },
    ready() {

    },
    methods: {
        getList(type) {
            type ? this.layerLoad() : '';
            let param = this.currentSearch;
            this.status = this.currentSearch.status;
            this.requestApi('/commend/get_list', param, (response) => {
                this.commendList = this.initList(response.data.list);
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
            this.commendList.forEach((x) => {
                x.checked = this.allChecked ? 0 : 1;
                x.checked == 1 ? this.count++ : '';
            })
        },
        checked(index) {
            this.count = 0;
            this.commendList[index].checked = !this.commendList[index].checked;
            let all = 1;
            this.commendList.forEach((x) => {
                all = all && x.checked;
                x.checked == 1 ? this.count++ : '';
            })
            this.allChecked = all;
        },
        changeStatus(type, item) {
            if (type == 0) {
                let status = item.status == 1 ? 2 : 1;
                layer.msg(`确定${this.status_str[status]}该推荐位吗？`, {
                    time: 0,
                    shade: 0.2,
                    shadeClose: true,
                    btn: ['确定', '取消'],
                    yes: (index) => {
                        layer.close(index);
                        this.requestApi('/commend/status/' + item.id, {
                            status: status
                        }, (response) => {
                            layer.msg(`操作成功，已${this.status_str[status]}1个推荐位`);
                            this.getList();
                        })
                    }
                });
            } else {
                layer.msg(`确定批量${this.status_str[type]}选中推荐位吗？`, {
                    time: 0,
                    shade: 0.2,
                    shadeClose: true,
                    btn: ['确定', '取消'],
                    yes: (index) => {
                        layer.close(index);
                        let id = [];
                        this.commendList.forEach((x) => {
                            x.checked ? id.push(x.id) : '';
                        });
                        this.requestApi('/commend/status/' + id, {
                            status: type
                        }, (response) => {
                            layer.msg(`操作成功，已${this.status_str[type]}${id.length}个推荐位`);
                            this.getList();
                        })
                    }
                });
            }
        },
        sortItem() {
            this.itemSort = true;
            var el = document.getElementById("sortableItems");
            this.sortable = Sortable.create(el);
            $('#mask').css('display', 'block');
        },
        sortItemSave() {
            this.itemSort = false;
            let result = [],
                param = [];
            $("tr[class=sortable]").each((x) => {
                result.push(this.commendList[$("tr[class=sortable]").eq(x).attr("data-value")]);
            });
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
            this.requestApi('/commend/set_order', {
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
                name: "commendEdit",
                query: {
                    id: id
                }
            })
        }
    }
}
</script>
