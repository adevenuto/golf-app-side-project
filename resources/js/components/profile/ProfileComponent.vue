<template>
    <div class="container">
        <div class="row">

            <div class="col-sm-6 mb-4">
                <div id="profile-img-container">
                    <div class="profile-placeholder d-flex justify-content-center align-items-center flex-column">
                        <img src="images/camera.svg" width="75px" height="75px" alt="camera">
                        <a href="#">Profile image</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <h1 class="text-sm-left text-center font-weight-bold mb-4">{{authUser.first_name}} {{authUser.last_name}}</h1>
                <form class="profile-data-form">
                    <text-input-component 
                        input_label="Nickname:" 
                        input_name="nick_name" 
                        input_id="nickname"
                        input_border_color="#6f6f6f"
                        input_label_color="#999"
                        input_required="required">
                    </text-input-component>
                    <div class="input-dynamic_radio">
                        <div class="radio-for">Gender:</div>
                        <div class="d-flex">
                            <div class="radio-inline">
                                <label><input type="radio" name="gender" required> 
                                    <div class="radio_indicator"></div><span>Male</span>
                                </label>
                            </div>
                            <div class="radio-inline">
                                <label><input type="radio" name="gender" required>
                                    <div class="radio_indicator"></div><span>Female</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <text-input-component 
                        input_label="Age:" 
                        input_name="age" 
                        input_id="age"
                        input_border_color="#6f6f6f"
                        input_label_color="#999"
                        input_max_length="3"
                        :input_custom_class="['num-only']"
                        input_required="required">
                    </text-input-component>               
                    <text-input-component 
                        input_label="City:" 
                        input_name="locality" 
                        input_id="city"
                        input_border_color="#6f6f6f"
                        input_label_color="#999"
                        input_required="required">
                    </text-input-component>
                    <input type="submit" value="submit">
                </form>
            </div>

        </div>
    </div>
</template>

<script>
    import TextInputComponent from '../form_elements/TextInputComponent.vue';
    export default {
        data() {
            return {
                profile_img: null
            }
        },
        components: {TextInputComponent},
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
        width: 150px;
        height: 150px;
        margin: 0 auto;
        .profile-placeholder {
            height: inherit;
            width: inherit;
            border: 2px solid #000;
            border-radius: 5px;
        }
    }
    .profile-data-form {
        max-width: 300px;
    }


    .input-dynamic_radio {
        position: relative;
        width: 100%;
        margin-bottom: 20px;
        display: inline-block;
        .radio-for {
            margin-bottom: 4px;
        }
        input[type=radio] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }
        input[type=radio]:checked + .radio_indicator {
            background: #999;
        }
        input[type=radio]:checked + .radio_indicator:after {
            position: absolute;
            content: '';
            height: inherit;
            width: inherit;
            border-radius: inherit;
            background: #000;
            -webkit-animation: radioWave 0.50s;
            -moz-animation: radioWave 0.50s;
            animation: radioWave 0.50s;
            z-index: -1;
        }
        label {
            display: flex;
            align-items: center;
            cursor: pointer;
            span {
                margin: 0 15px 0 5px;
            }
            .radio_indicator {
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 18px;
                width: 18px;
                border: 1px solid #757575;
                border-radius: 50%;
                box-sizing: content-box;
            }
        }
    }
    @keyframes radioWave {
        0% {
            opacity: 0.45;
        }
        100% {
            height: 35px;
            width: 35px;
            opacity: 0;
        }
    }
    


    @media only screen and (max-width: 767px) {
        .profile-data-form {
            margin: 0 auto;
        }
    }

</style>


