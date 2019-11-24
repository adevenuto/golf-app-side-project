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


                <div class="form-group form-inline">
                    <label class="mr-4">Nick name:</label>
                    <input type="text">
                </div>

                <div class="form-group form-inline">
                    <label class="mr-4">Gender:</label>

                    <input id="male" type="radio" name="gender">
                    <label class="radio-inline mr-3" for="male">Male</label>

                    <input id="female" type="radio" name="gender">
                    <label class="radio-inline" for="female">Female</label>
                </div>

                <div class="form-group form-inline">
                    <label class="mr-4">Age:</label>
                    <input class="num-only" type="text" maxlength="3">
                </div>

                <div class="form-group form-inline">
                    <label class="mr-4">City:</label>
                    <input type="text">
                </div>
                


            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                profile_img: null
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
    input[type=radio] {display: none;}
    input[type=radio] + label {
        cursor: pointer;
        padding: 0 5px;
        background: #fff;
        border: 1px solid #999;
    }
    input[type=radio]:checked + label {
        background: #a2a2a2;
    }
</style>


