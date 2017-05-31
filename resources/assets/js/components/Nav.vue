<template>
    <div>

        <div class="nav header">
            <div class="go_back">
                <router-link to="/list">
                    <Icon type="arrow-left-c"></Icon>
                </router-link>
            </div>
            <span class="title" v-html="title"></span>

        </div>

    </div>
</template>

<script>
    export default {
        data () {
            return {

            }
        },
        props:['title']
    }
</script>

<style lang="sass" rel="stylesheet/sass">
    .nav.header
        width: 100%
        height: 40px
        background: #3399ff
        text-align: center
        line-height: 40px
        .go_back
            position: absolute
            float: left
            padding: 0 15px
            i
                font-size: 20px
                position: relative
                top: 3px
                color: #fff
        .title
            font-size: 16px
            color: #fff

</style>