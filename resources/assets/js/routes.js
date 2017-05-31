import user_list from './components/List.vue'
import user_message from './components/Message.vue'

export default [


    { path: '/' ,  redirect: '/list' },


    { path: '/list' , name : 'user_list' , component: user_list },

    { path: '/user_message/:id/:direct' , name : 'user_message' , component: user_message },

]