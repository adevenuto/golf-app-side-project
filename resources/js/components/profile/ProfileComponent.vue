<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">{{ authUser.first_name }} {{ authUser.last_name }}</div>
            <div class="col-sm-9">Profile</div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                
            }
        },
        props: ['user'],
        computed: {
            authUser: function() {
                return this.user ? JSON.parse(this.user) : null;
            }
        }
    }
</script>

<style lang="scss" scoped>
    
</style>


