<template>
    <div class="container">
        <LoadingOverlay v-if="fetchingProfileData" />
        <form id="profileForm" @submit.prevent="submit">
            <div class="row">

                <div class="col-sm-6 mb-3">
                    <a href="#" @click="imageInputField">
                        <div id="profile-img-container">
                            
                            <div class="profile-placeholder d-flex justify-content-center align-items-center flex-column rounded">
                                <img v-show="!profileImage" src="images/camera.svg" width="75px" height="75px" alt="camera">
                                <img v-show="profileImage" id="profile_image" ref="profile_image" src="" alt="profile image">
                            </div>
                            <input type="file" 
                                    id="profile_image_input" 
                                    name="profile_image" 
                                    ref="profile_image_input" 
                                    @change="validateImage" 
                                    @input="fieldChange">
                        </div>
                    </a>
                </div>
    

                <div class="col-sm-6">
                    <h1 class="text-sm-left text-center font-weight-bold mb-5">{{authUser.first_name}} {{authUser.last_name}}</h1>
                    <div class="profile-data-form">
                        <div class="input-dynamic_text">
                            <label for="nickname" class="dynamic-label">
                                Nickname:
                                <span v-show="errors.has('nick_name')" class="is-error"> (required)</span>
                            </label>
                            <input id="nickname" 
                                    :class="{ 'is-error': errors.has('nick_name') }"
                                    @input="fieldChange"
                                    name="nick_name" 
                                    v-model="inputs.nickname" 
                                    v-validate="'required'"
                                    type="text">
                        </div>
                        <div class="input-dynamic_radio">
                            <div class="radio-for dynamic-label">
                                Gender:
                                <span v-show="errors.has('gender')" class="is-error"> (required)</span>
                            </div>
                            <div class="d-flex flex-wrap">
                                <label>
                                    <input type="radio" v-validate="'required'" name="gender" value="male" v-model="inputs.gender" @input="fieldChange"> 
                                    <div :class="[{'is-error': errors.has('gender')}, 'radio_indicator']">
                                        <div class="wave"></div>
                                    </div>
                                    <span>Male</span>
                                </label>
                                <label>
                                    <input type="radio" v-validate="'required'" name="gender" value="female" v-model="inputs.gender" @input="fieldChange"> 
                                    <div :class="[{'is-error': errors.has('gender')}, 'radio_indicator']">
                                        <div class="wave"></div>
                                    </div>
                                    <span>Female</span>
                                </label>
                            </div>
                        </div>
                        <div class="input-dynamic_text">
                            <label for="age" class="dynamic-label">
                                Age:
                                <span v-show="errors.has('age')" class="is-error"> (required)</span>
                            </label>
                            <input id ="age" 
                                    :class="[{ 'is-error': errors.has('age') },'num-only']"
                                    @input="fieldChange" 
                                    name="age" 
                                    v-model="inputs.age"
                                    v-validate="'required'" 
                                    type="text" 
                                    maxlength="3">
                        </div>
                        <div class="input-dynamic_text">
                            <label for="citiesAutocomplete" class="dynamic-label">
                                City:
                                <span v-show="errors.has('locality')" class="is-error"> (required)</span>
                            </label>
                            <input id ="citiesAutocomplete" 
                                    name="locality" 
                                    v-validate="'required'"
                                    v-model="inputs.locality"
                                    :class="{ 'is-error': errors.has('locality') }" 
                                    @input="fieldChange"
                                    placeholder="" 
                                    type="text" 
                                    @focus="focusHandler" 
                                    @blur="blurHandler">
                        </div>
                        <!-- Hidden inputs For AutoComplete Components -->
                        <input type="hidden" id="locality" name="locality" disabled="true"/>
                        <input type="hidden" id="administrative_area_level_1" name="administrative_area_level_1" disabled="true"/>
                        <input type="hidden" id="administrative_area_level_2" name="administrative_area_level_2" disabled="true"/>
                        <input type="hidden" id="country" name="country" disabled="true"/>

                        <div class="d-flex">
                            <button class="btn btn-primary" :disabled="!saveActive">
                                <div class="d-flex align-items-center">
                                    <span class="mr-2">Save Profile</span> 
                                    <LoadingSpinner 
                                            v-if="savingData"
                                            borderWidth="2px" 
                                            borderTopColor="#00ce07" 
                                            borderBg="#f3f3f3" 
                                            size="15px"/>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</template>

<script>
    import LoadingOverlay from '../LoadingOverlay.vue';
    import LoadingSpinner from '../LoadingSpinner.vue';
    export default {
        data() {
            return {
                profileImage: false,
                inputs: {
                    nickname: '',
                    gender: '',
                    age: '',
                    locality: ''
                },
                fetchingProfileData: false,
                saveActive: true,
                savingData: false
            }
        },
        components: {LoadingOverlay, LoadingSpinner},
        props: ['user'],
        computed: {
            authUser: function() {
                return  this.user ? JSON.parse(this.user) : null;
            }
        },
        created() {
            if (this.authUser.nick_name) {
                this.inputs.nickname = this.authUser.nick_name;
                this.inputs.gender = this.authUser.gender;
                this.inputs.age = this.authUser.age;
                this.inputs.locality = this.authUser.locality;
                // --------------------
                this.saveActive = false;
            }
        },
        mounted() {
            initCitiesAutocomplete();  
            if (this.authUser.image_path) {
                this.profileImage = true;
                let profileImage = this.$refs.profile_image;
                profileImage.src = `https://teetyme-app.s3.us-east-2.amazonaws.com/${this.authUser.image_path}`;
            }
        },
        methods: {
            slideToggle: function() {
                this.slide_edit = !this.slide_edit;
            },
            submit: function() {
                let form = document.getElementById('profileForm');
                let formData = new FormData(form);

                this.savingData = true;
                this.$validator.validateAll()
                .then((isValidated) => {
                    if (isValidated) {
                        axios.post("/store", formData)
                            .then( res => {
                                this.inputs.locality = res.data.user.locality;
                                this.savingData = false;
                                this.saveActive = false;
                            })
                            .catch( err => {
                                this.savingData = false;
                                this.saveActive = false;
                            });
                    } else {
                        this.savingData = false;
                    }
                })
                
            },
            focusHandler: function(e) {
                e.target.placeholder = 'Start typing / select city from dropdown';
            },
            blurHandler: function(e) {
                e.target.placeholder = '';
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
                let reader = new FileReader();
                reader.onload = function (e) {
                    let profileImage = document.getElementById('profile_image');
                    profileImage.src=`${e.target.result}`;
                    that.profileImage = true;

                }
                reader.readAsDataURL(inputFiles[0]);
            },
            fieldChange: function() {
                this.saveActive = true;
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
            overflow: hidden;
            box-shadow: 0px 1px 8px 0px #999;
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


