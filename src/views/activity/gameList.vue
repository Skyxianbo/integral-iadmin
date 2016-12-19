<style lang="sass">
</style>
<template lang="html">
    <v-list title="小游戏列表" :source="1" :count.sync="count" :pages.sync="pages" :search="currentSearch" :list.sync="list">
        <div slot="list-search">
            <div class="col-sm-2 col-lg-1">
                <select class="form-control" v-model="currentSearch.status">
                    <option value="{{$index}}" v-for="s in status">{{s}}</option>
                </select>
            </div>
            <div class="col-sm-4 col-lg-3">
                <input type="text" class="form-control" placeholder="小游戏名称" v-model="currentSearch.name">
            </div>
        </div>
        <div slot="list-table">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 52px;">
                            <input type="checkbox" v-model="allChecked" @click="checkAll()">
                        </th>
                        <th>小游戏名称</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="item" v-for="item in list">
                        <td class="text-center">
                            <input type="checkbox" v-model="item.checked" @click="checked($index)">
                        </td>
                        <td>
                            <a @click="routerGo(routerName, item.id)">
                                <img :src="item.pic" alt="image" style="width: 90px;height: 70px;">
                                <span class="margin-left-10">{{item.name}}</span>
                            </a>
                        </td>
                        <td>{{item.status_str}}</td>
                        <td>
                            <a @click="changeStatus(0, item)">{{item.status == 1? '上线' : '下线'}}</a>
                            <a class="margin-left-10" @click="routerGo(routerName, item.id)">编辑</a>
                            <a class="margin-left-10" @click="preview(item.name)">预览</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </v-list>
    <phone-modal :show.sync="show">
        <div slot="modal-body">
            <game-preview :game-type.sync="type" :game-detail="gameDetail" :name="gameName" :show="show"></game-preview>
        </div>
    </phone-modal>
</template>
<script>
import vList from '../../components/v_list';
import phoneModal from '../../components/phone-modal';
import gamePreview from '../../components/preview/game_preview.vue';
export default {
    components: {
        vList,
        phoneModal,
        gamePreview
    },
    data() {
        return {
            list: [],
            gameDetail: {},
            gameName: '',
            routerName: 'insertGame',
            type: 0,
            count: 0,
            show: false,
            allChecked: false,
            status: ['所有状态', '下线', '上线'],
            currentSearch: {
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
    watch: {
        show(value) {
            if (!value) {
                this.type = 0;
            }
        }
    },
    methods: {
        getList(type) {
            type ? this.layerLoad() : '';
            this.requestApi('/game/get_list', this.currentSearch, (response) => {
                this.list = this.initList(response.data.list);
                this.pages.total = response.data.count;
                this.pages.currentPage = response.data.p;
                this.count = 0;
                this.allChecked = false;
                window.scrollTo(0, 0);
            })
        },
        clearCondition() {
            this.currentSearch = {
                status: 2,
                name: ''
            };
        },
        checkAll() {
            this.count = 0;
            this.list.forEach((x) => {
                x.checked = this.allChecked ? 0 : 1;
                x.checked == 1 ? this.count++ : '';
            })
        },
        checked(index) {
            let all = 1;
            this.count = 0;
            this.list[index].checked = !this.list[index].checked;
            this.list.forEach((x) => {
                all = all && x.checked;
                x.checked == 1 ? this.count++ : '';
            });
            this.allChecked = all;
        },
        changeStatus(type, item) {
            if (type == 0) {
                let status = item.status == 1 ? 2 : 1;
                layer.msg(`确定${this.status[status]}该小游戏吗？`, {
                    time: 0,
                    shade: 0.2,
                    shadeClose: true,
                    btn: ['确定', '取消'],
                    yes: (index) => {
                        layer.close(index);
                        this.requestApi('/game/status/' + item.id, {
                            status: status
                        }, (response) => {
                            layer.msg(`操作成功，已${this.status[status]}1个小游戏`);
                            this.getList()
                        })
                    }
                });
            } else {
                layer.msg(`确定批量${this.status[type]}选中小游戏吗？`, {
                    time: 0,
                    shade: 0.2,
                    shadeClose: true,
                    btn: ['确定', '取消'],
                    yes: (index) => {
                        layer.close(index);
                        let id = [];
                        this.list.forEach((x) => {
                            x.checked ? id.push(x.id) : '';
                        });
                        this.requestApi('/game/status/' + id, {
                            status: type
                        }, (response) => {
                            layer.msg(`操作成功，已${this.status[type]}${id.length}个小游戏`);
                            this.getList();
                        })
                    }
                });
            }
        },
        routerGo(name, id) {
            this.$route.router.go({
                name: name,
                query: {
                    id: id
                }
            })
        },
        preview(name) {
            this.gameName = name;
            this.gameDetail = {};
            this.type = 3;
            this.show = true;
        }
    }
}
</script>
