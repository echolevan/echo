<template>
    <div>
        <div>
            <!--<div class="panel-heading" v-html=" "></div>-->
            <div class="panel-body message_content" id="message_content" :style="{ 'height' : height + 'px' }">

                <div v-for="(message , k) in messages" :class="{'message':1 , 'my_message' : message.from_user_id === user_info.id } ">
                    <div class="avatar">
                        <img :src=" message.from_user_id === user_info.id ? user_info.avatar : message.from_user.avatar" class="img-circle" alt="">
                        <div :class="{ 'point' : 1 , 'offline' : user_login.indexOf(message.from_user_id) === -1 , 'online' : user_login.indexOf(message.from_user_id) !== -1}  "></div>
                    </div>
                    <div class="content">
                        <div  v-html="message.body">

                        </div>
                    </div>
                </div>
            </div>

            <div class="message_tool">
                <Input v-model="message" type="textarea" placeholder="请输入..." @keyup.ctrl.enter.native="reply"></Input>
                <Button type="primary" :loading="loading" long  @click="reply">
                    <span v-if="!loading">发送消息</span>
                    <span v-else>Loading...</span>
                </Button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                messages : [],
                message : '',
                loading:false,
                user:{},
                send_time:0,
                height:400,
                chuo_num:1,
                chuo_sta : true,
            }
        },
        watch:{
            messages(){
                setTimeout(function () {
                    let div = document.getElementById('message_content');
                    div.scrollTop = div.scrollHeight;
                },100);
            },

            '$route': 'init' ,

            chuo_num(){
                if(this.chuo_num === '01' ||this.chuo_num === 15){
                    this.$emit('right' , 5);
                    setTimeout(() => {
                        this.$emit('right' , 0);
                    }, 200);
                }

            }

        },
        props:['user_info','user_login'],
        mounted() {
            //get all messages
            this.init();

            this.chuo();

            Echo.join('message_post.'+this.$route.params.direct)
//                .here((users) => {
//                    for (let i = 0 ; i < users.length ; i++){
//                        this.user_login.push(users[i].id);
//                    }
//                })
//                .joining((user) => {
//                    if((this.user_login).indexOf(user.id) === -1){
//                        this.user_login.push(user.id);
//                    }
//                })
//                .leaving((user) => {
//                    this.user_login.splice((this.user_login).indexOf(user.id),1);
//                })
                .listen('MessagePosted', (e) => {
                    this.messages.push({
                        from_user : e.from,
                        body:e.message.body,
                        created_at:e.message.created_at,
                        direct:e.message.direct,
                        from_user_id:e.message.from_user_id,
                        id:e.message.id,
                        is_read:e.message.is_read,
                        read_at:e.message.read_at,
                        to_user_id:e.message.to_user_id,
                        update_at:e.message.update_at,
                    });
                });
        },
        methods:{
            init(){
                this.$Message.destroy();

                this.height = document.body.scrollHeight - 40 - 129;
                axios.get('message/'+this.$route.params.id+"/"+this.$route.params.direct).then(res=>{
                    this.messages = res.data.messages;
                    this.user = res.data.user;
                    this.$emit('title' , '正在与 ' + this.user.name + ' 聊天');
                });

            },
            reply(){
                this.loading = true;
                axios.put('message/store' , {msg : this.message , id : this.$route.params.id}).then(res=>{
                    this.messages.push(res.data.message);
                    this.message = '';
                    this.loading = false;
                    this.$emit('reply',res.data.message);
                });
            },

            chuo(){
                if(this.chuo_sta === false)
                    return false

                this.chuo_sta = false;
                for (let i = 1 ;  i <= 22 ; i ++ ){
                    if(i === 1)
                        this.chuo_num = "0"+i;
                    else{
                        setTimeout(() => {
                            if(i < 10){
                                this.chuo_num = "0"+i;
                            }
                            else{
                                this.chuo_num = i;
                            }

                            if(i === 22){
                                this.chuo_sta = true;
                            }

                        }, i*50);
                    }

                }

            }
        }
    }
</script>


<style lang="sass" rel="stylesheet/sass">
    .message_content
        overflow: auto
    .message_tool
        width: 100%
        padding: 0 15px 15px
    .message
        width: 100%
        clear: both
        .avatar
            float: left
            margin: 0 5px 5px 0
            position: relative
            img
                width: 35px
                height: 35px
            .point
                width: 8px
                height: 8px
                border-radius: 50%
                position: absolute
                left: 0
                top: 0
            .offline
                background-color: #333
            .online
                background-color: #66ff99
        .content
            font-size: 12px
            max-width: 600px
            float: left
            margin-bottom: 5px
            border-radius: 5px
            div
                padding: 10px
                background-color: #f2f2f2
            .icon
                width: 60px
                position: relative
                top: -10px
    .my_message
        .avatar
            float: right
            margin: 0 0 5px 5px
        .content
            float: right
        .point
            width: 0 !important
            height: 0 !important

    textarea
        margin: 15px 0


</style>