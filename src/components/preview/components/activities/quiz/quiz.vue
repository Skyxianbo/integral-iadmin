<style lang='sass' scoped>
@import '../../../assets/scss/main.scss';
.v-quiz {
    padding: pxTorem(14) pxTorem(64) pxTorem(36) pxTorem(64);
    background-color: rgb(243,243,243);
}

.head {
    img {
        width: pxTorem(493);
        height: pxTorem(193);
    }
}

.panel {
    margin-top: pxTorem(10);
    border-radius: pxTorem(20);
    box-shadow: pxTorem(5) pxTorem(5) pxTorem(5) rgba(0, 0, 0, .1);
    .panel-head {
        line-height: pxTorem(72);
        background-color: $red;
        border-top-left-radius: pxTorem(20);
        border-top-right-radius: pxTorem(20);
    }
    .panel-content {
        padding: pxTorem(35) pxTorem(55) pxTorem(50) pxTorem(50);
        .quiz {
            margin-bottom: pxTorem(35);
        }
        .answers {
            font-size: pxTorem(30);
            margin-bottom: pxTorem(50);
            input[type='radio'] {
                display: none;
            }
            label {
                display: block;
                padding: pxTorem(18) 0;
            }
            label:before {
                content: "";
                display: inline-block;
                width: pxTorem(25);
                height: pxTorem(25);
                margin-right: pxTorem(25);
                border: pxTorem(3) solid $gray;
                border-radius: 50%;
                transform: translateY(pxTorem(3));
            }
            input[type="radio"]:checked + label:before {
                background: $gray;
            }
        }
        .submit {
            width: pxTorem(350);
            font-size: pxTorem(30);
        }
    }
}
</style>
<template>
    <div class='v-quiz '>
        <div class='head text-center'>
            <img src='./images/quiz.png' alt="">
        </div>
        <div v-for='($index,item) in questions' class='body'>
            <div v-if='current_number==$index' class='panel bg-white text-huge '>
                <div class='panel-head text-center text-white'>
                    第{{$index+1}}题
                </div>
                <div class='panel-content '>
                    <div class='quiz '>
                        {{item.question}}
                    </div>
                    <div class='answers text-gray '>
                        <div class='answer ' v-for='answer in item.answers'>
                            <input type='radio' :id='answer.id' :value='answer.id' v-model='answer_id'>
                            <label :for='answer.id'>{{answer.option}}</label>
                        </div>
                    </div>
                    <div class='text-center'>
                        <button class='btn btn-red btn-large submit ' @click='submitAnswer()'>提交答案</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'quiz',
    props: {
      questions:Array
    },
    data() {
        return {
            current_number: 0, //当前题目号 0开始
            // integral_enough: false, //判断是否有足够积分进行活动
            answer_id: 0, //判断是否有选择题目
            is_right: false, //判断回答是否正确
        };
    },
    methods: {
        //提交答案
        submitAnswer() {
            let alert = {
                    msg: '',
                    btn_text: '',
                }
                //no answer
            if (this.answer_id == 0) {
                alert.msg = '请选择答案';
                alert.btn_text = '关闭';
            } else {
                this.questions[0].answers.forEach(item => {
                        if (item.id == this.answer_id) {
                            this.is_right = item.isanswer;
                            return;
                        }
                    })
                    //right
                if (this.is_right) {
                    alert.msg = this.$parent.getAword();
                    alert.type='correct';
                    alert.btn_text = '查看';
                } else {
                    //wrong
                    alert.msg = '回答错误';
                    alert.type='error';
                    alert.btn_text = '关闭';
                }
            }

            this.$parent.toggleAlert(alert.msg,alert.btn_text,alert.type);
        }
    }
}
</script>
