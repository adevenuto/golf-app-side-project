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
                    <radio-input-component
                        input_label="Gender:"
                        input_name="gender"
                        bg_color_wave="#444"
                        input_label_color="#999"
                        :input_radio_options="[
                            {'display_name': 'Male', 'required': true},
                            {'display_name': 'Female', 'required': true}
                        ]">
                    </radio-input-component>
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
                    <!-- <input type="submit" value="submit"> -->
                </form>
            </div>

        </div>
    </div>
</template>

<script>
    import TextInputComponent from '../form_elements/TextInputComponent.vue';
    import RadioInputComponent from '../form_elements/RadioInputComponent.vue';
    export default {
        data() {
            return {
                profile_img: null
            }
        },
        components: {TextInputComponent, RadioInputComponent},
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


    @media only screen and (max-width: 767px) {
        .profile-data-form {
            margin: 0 auto;
        }
    }

</style>


