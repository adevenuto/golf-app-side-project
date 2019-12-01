<template>
    <div class="container">
        <form id="profileForm" @submit.prevent="submit">
            <div class="row">

                <div class="col-sm-6 mb-4">
                    <div id="profile-img-container">
                        <div class="profile-placeholder d-flex justify-content-center align-items-center flex-column">
                            <a href="#" @click="imageInputField">
                                <img v-show="!profileImageSet" src="images/camera.svg" width="75px" height="75px" alt="camera">
                                <img v-show="profileImageSet" id="profile_image" src="" alt="profile image">
                            </a>
                        </div>
                        <input type="file" id="profile_image_input" name="profile_image" ref="profile_image_input" @change="validateImage">
                    </div>
                </div>
            
                <div class="col-sm-6">
                    <h1 class="text-sm-left text-center font-weight-bold mb-4">{{authUser.first_name}} {{authUser.last_name}}</h1>
                    <div class="profile-data-form">
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
                            {'display_name': 'Male', 'required': true, 'value': 'Male'},
                            {'display_name': 'Female', 'required': true, 'value': 'Female'}
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
                        input_id="citiesAutocomplete"
                        input_border_color="#6f6f6f"
                        input_label_color="#999"
                        input_placeholder="Start typing / select from dropdown"
                        input_required="required">
                    </text-input-component>
                    <!-- Hidden Fields For AutoComplete Components -->
                    <input type="hidden" id="locality" name="locality" disabled="true"/>
                    <input type="hidden" id="administrative_area_level_1" name="administrative_area_level_1" disabled="true"/>
                    <input type="hidden" id="administrative_area_level_2" name="administrative_area_level_2" disabled="true"/>
                    <input type="hidden" id="country" name="country" disabled="true"/>

                    <div class="d-flex">
                        <button class="btn btn-primary">Save profile</button>
                    </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</template>

<script>
    import TextInputComponent from '../form_elements/TextInputComponent.vue';
    import RadioInputComponent from '../form_elements/RadioInputComponent.vue';
    export default {
        data() {
            return {
                profileImageSet: false
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
            },
            submit: function() {
                var form = document.getElementById('profileForm');
                var formData = new FormData(form);

                axios.post("/store", formData)
                .then( payload => {
                    
                })
                .catch( err => {
                    
                });
            },
            imageInputField: function(e) {
                this.$refs.profile_image_input.click();
            },
            validateImage: function(e) {
                const that = this;
                let inputFiles = e.target.files;
                if (inputFiles && inputFiles[0]) {
                    let allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    let type = inputFiles[0].type;
                    if (allowedTypes.indexOf(type) !== -1)   {
                        return this.imagePreview(e);
                    } else {
                        alert('please upload an image file.')
                        return false;
                    }
                } 
                return false;   
            },
            imagePreview: function(e) {
                const that = this;
                let inputFiles = e.target.files;
                var reader = new FileReader();
                reader.onload = function (e) {
                    let profileImage = document.getElementById('profile_image');
                    profileImage.src=`${e.target.result}`;
                    that.profileImageSet = true;
                }
                reader.readAsDataURL(inputFiles[0]);
            }
        },
        mounted() {
            initCitiesAutocomplete();  
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
            overflow: hidden;
        }
    }
    .profile-data-form {
        max-width: 300px;
    }
    #profile_image_input {
        display: none;
    }
    #profile_image {
        object-fit: cover;
        height: 150px;
        width: 100%;
    }


    @media only screen and (max-width: 767px) {
        .profile-data-form {
            margin: 0 auto;
        }
    }

</style>


