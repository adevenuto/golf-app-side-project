<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 mb-4">
                <div id="profile-img-container">
                    <div class="profile-placeholder d-flex justify-content-center align-items-center">
                        Profile Image
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <h2 class="text-sm-left text-center font-weight-bold mb-4">{{authUser.first_name}} {{authUser.last_name}}</h2>


                <div class="slide-input-wrap d-flex">
                    <div class="slide-lable d-flex align-items-center">Nick name:</div>
                    <div :class="[{ 'in': slide_edit}, 'slide-input']">
                        <input type="text">
                        <div href="#" @click="slideToggle" class="slide-edit font-weight-bold">Edit</div>
                    </div>
                </div>
                


            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                profile_img: null,
                slide_edit: false
            }
        },
        props: ['user'],
        computed: {
            authUser: function() {
                return this.user ? JSON.parse(this.user) : null;
            }
        },
        methods: {
            slideToggle: function() {
                this.slide_edit = !this.slide_edit;
            }
        }
    }
</script>

<style lang="scss" scoped>
    #profile-img-container {
        width: 100px;
        height: 100px;
        margin: 0 auto;
        .profile-placeholder {
            height: inherit;
            width: inherit;
            border: 2px solid #000;
        }
    }
    .slide-input-wrap {
        overflow: hidden;
        height: 35px;
        .slide-lable {
            position: relative;
            z-index: 10;
            color: #979797;
            height: 35px;
            background: #f8fafc;
        }
        .slide-input {
            transform: translate(-82%);
            transition: all 150ms ease-in-out;
            input {
                border: none;
                height: 35px;
                background: transparent;
                border-bottom: 1px solid #000;
                margin: 0 15px;
                &:focus {
                    outline-width: 0;
                }
            }
            .slide-edit {
                display: inline-block;
                cursor: pointer;
                color: #0086ff;
                height: 35px;
                -webkit-user-select: none;  /* Chrome all / Safari all */
                -moz-user-select: none;     /* Firefox all */
                -ms-user-select: none;      /* IE 10+ */
                user-select: none;
                &:hover {
                    color: #3FA2FB;
                }
            }
        }
        .slide-input.in {
            transform: translate(0);
            .slide-edit {
                color: #3FA2FB;
            }
        }
    }
</style>


