<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-body">
                <p v-for="user in orderedUsers">
                    <router-link :to="{name:'user_message',params: {id:user.id , direct:user.direct}}" >
                        <img :src="user.avatar" class="img-circle">
                        <div :class="{ 'point' : 1 , 'offline' : user_login.indexOf(user.id) === -1 , 'online' : user_login.indexOf(user.id) !== -1}  "></div>
                    </router-link>
                    <i>{{ user.name }}</i>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data (){
            return {
                users : []
            }
        },
        props:['user_login'],
        mounted(){
            axios.get('user').then(res=>{
                this.users = res.data;
            });

            this.$emit('title' , '用户列表');

        },
        computed: {
            orderedUsers: function () {
                return _.orderBy(this.users, 'updated_at' , 'desc')
            }
        }
    }
</script>

<style lang="sass" rel="stylesheet/sass">
    p
        position: relative
        clear: both
        img
            float: left
            width: 50px
            height: 50px
            margin-bottom: 5px
        i
            line-height: 50px
            padding-left: 15px
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
</style>