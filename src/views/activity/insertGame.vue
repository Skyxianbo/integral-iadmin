<style lang="sass">
.image-p {
    margin-left: -10px;
    padding-top: 7px;
}
</style>
<template lang="html">
    <header class="template-header">
        <span>{{title}}</span>
        <button class="btn btn-default" v-if="isEdit" @click.prevent="back()"><i class="fa fa-reply"></i>返回商品列表</button>
    </header>
    <panel title="参数设置">
        <div slot='panel-body' class="panel-body">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="control-label col-sm-2">
                        <span>小游戏名称</span>
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" placeholder="请输入小游戏名称" v-model="game.name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">
                        <span>资源路径</span>
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" placeholder="请输入资源路径" v-model="game.url">
                    </div>
                </div>
                <div>
                    <label class="control-label col-sm-2">
                        <span>缩略图</span>
                    </label>
                    <div class="col-sm-8">
                        <p class="text-red image-p">建议尺寸：180 x 140像素，JPG大小40K以内，PSD不限，图片非白底</p>
                        <div class="row dashed-line"></div>
                        <div class="row">
                            <upload-img :img-src.sync="game.pic" file-id="file" upload-id="pic" width="180px" height="140px"></upload-img>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </panel>
    <button id="btn" class="btn-search" v-if="!isEdit">保存</button>
    <button class="btn-search" @click.prevent="editGame" v-else>保存</button>
</template>
<script>
import panel from '../../components/panel.vue';
import uploadImg from '../../components/upload-img.vue';
export default {
    components: {
        panel,
        uploadImg
    },
    data() {
        return {
            game: {},
            title: '',
            gameId: '',
            isEdit: false
        }
    },
    route: {
        data(transition) {
            if (transition.to.query.id) {
                this.gameId = transition.to.query.id;
                this.title = '编辑小游戏';
                this.isEdit = true;
            } else {
                this.gameId = ''
                this.title = '添加小游戏';
                this.isEdit = false;
            }
        }
    },
    ready() {
        var btn = document.getElementById('btn');
        btn.addEventListener('click', this.debounce(this.insertGame, 300))
        this.getGame();
    },
    methods: {
        insertGame() {
            this.game.status = 1;
            this.requestApi('/game/insert', this.game, (response) => {
                layer.msg('已保存，请前往小游戏列表上架！', {
                    time: 1000
                }, () => {
                    this.$route.router.go({
                        name: 'gameList'
                    });
                })
            })
        },
        editGame() {
            this.requestApi('/game/update/' + this.gameId, this.game, (response) => {
                layer.msg('已保存编辑', {
                    time: 1000
                }, () => {
                    this.$route.router.go({
                        name: 'gameList'
                    });
                })
            })
        },
        getGame() {
            if (this.isEdit) {
                this.requestApi('/game/get/' + this.gameId, {}, (response) => {
                    this.game = response.data;
                })
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
