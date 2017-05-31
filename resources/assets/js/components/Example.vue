<template>
    <div>
       <div class="all_content" :style="{ 'margin-right' : right + 'px'  }">
           <v-nav :title="title"></v-nav>
           <router-view :user_login="user_login" :user_info="user_info" v-on:reply="send_msg" v-on:title="change_title" v-on:right="change_right"></router-view>
       </div>
    </div>
</template>

<script>
    import Nav from '../components/Nav.vue'
    export default {
        data (){
            return {
                user_login : [],
                user_info : {},
                title:'',
                right:0
            }
        },
        mounted(){
            axios.get('user_info').then(res=>{
                this.user_info = res.data;
            });

            Echo.join('user_login')
                .here((users) => {
                    for (let i = 0 ; i < users.length ; i++){
                        this.user_login.push(users[i].id);
                    }
                })
                .joining((user) => {
                    if((this.user_login).indexOf(user.id) === -1){
                        this.user_login.push(user.id);
                    }
                })
                .leaving((user) => {
                    this.user_login.splice((this.user_login).indexOf(user.id),1);
                })
                .listen('UserLogin', (e) => {
                    if(e.message.to_user_id !== this.user_info.id)
                        return false;

                    if(this.$route.params.direct && parseInt(this.$route.params.direct) === parseInt(e.message.direct))
                        return false;

                    this.$Message.info('' +
                        '<a href="#/user_message/'+ e.message.from_user_id +'/'+ e.message.direct +'"><div class="title_message">' +
                        '<div class="avatar">' +
                        '<img src=" '+ e.message.from_user.avatar +' " alt="" class="img-circle">' +
                        '</div> <div class="content">' + e.message.body + '</div></div></a>', 5);
                });
        },
        methods:{
            send_msg(e){
                axios.put('message/notify',{message:e}).then(res=>{
                });
            },
            change_title(title){
                this.title = title;
            },
            change_right(right){
                this.right = right;
            }
        },

        components:{
            'v-nav' : Nav
        }
    }
</script>

<style lang="sass" rel="stylesheet/sass">
    .title_message
        position: relative
        top: -17px
        left: -5px
        width: 300px
        height: 15px
        .avatar
            float: left
        img
            width: 30px
            height: 30px
        .content
            float: left
            width: 270px
            height: 30px
            line-height: 30px
            padding: 0 5px
            overflow: hidden
            text-overflow: ellipsis
            color: #555
            white-space: nowrap
    .all_content
        transition-property: all
        transition-timing-function: ease
        transition-delay: .0s
        transition-duration: 0.2s
</style>