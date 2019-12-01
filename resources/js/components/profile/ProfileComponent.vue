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

                        <div class="input-dynamic_text">
                            <label for="nickname">Nickname:</label>
                            <input id ="nickname" name="nick_name" v-model="fields.nickname" type="text" required>
                        </div>
                        <div class="input-dynamic_radio">
                            <div class="radio-for">Gender:</div>
                            <div class="d-flex flex-wrap">
                                <label>
                                    <input type="radio" name="gender" value="male" v-model="fields.gender"> 
                                    <div class="radio_indicator">
                                        <div class="wave"></div>
                                    </div>
                                    <span>Male</span>
                                </label>
                                <label>
                                    <input type="radio" name="gender" value="female" v-model="fields.gender"> 
                                    <div class="radio_indicator">
                                        <div class="wave"></div>
                                    </div>
                                    <span>Female</span>
                                </label>
                            </div>
                        </div>
                        <div class="input-dynamic_text">
                            <label for="age">Age:</label>
                            <input id ="age" class="num-only" name="age" v-model="fields.age" type="text" maxlength="3" required>
                        </div>
                        <div class="input-dynamic_text">
                            <label for="citiesAutocomplete">City:</label>
                            <input id ="citiesAutocomplete" name="locality" v-model="fields.locality" placeholder="" type="text" maxlength="3" required @focus="focusHandler" @blur="blurHandler">
                        </div>
                        
                        
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
    export default {
        data() {
            return {
                profileImageSet: false,
                fields: {
                    nickname: '',
                    gender: '',
                    age: '',
                    locality: ''
                }
            }
        },
        components: {},
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






    .input-dynamic_text {
        position: relative;
        width: 100%;
        margin-bottom: 25px;
        display: inline-block;
        label {
            position: absolute;
            transition: 130ms cubic-bezier(0.65, 0.26, 0.52, 0.96);
            pointer-events: none;
        }
        input {
            width: inherit;
            padding: 5px;
            border-bottom-width: 2px;
            border-bottom-style: solid;
        }
        .focused {
            transform: translate(-15%, -60%) scale(.7);
        }
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
        input[type=radio]:checked + .radio_indicator
        {
            transform: scale(1.15);
        }
        input[type=radio] + .radio_indicator .wave {
            display: none;
        }
        input[type=radio]:checked + .radio_indicator .wave {
            display: block;
            position: absolute;
            content: '';
            height: inherit;
            width: inherit;
            background: #000;
            border-radius: inherit;
            -webkit-animation: radioWave 200ms;
            -moz-animation: radioWave 200ms;
            animation: radioWave 200ms;
            z-index: -1;
        }
        label {
            display: flex;
            align-items: center;
            cursor: pointer;
            color: #000;
            span {
                margin: 0 15px 0 5px;
            }
            .radio_indicator {
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 13px;
                width: 13px;
                border: 1px solid #6f6f6f;
                border-radius: 50%;
                transform: scale(1);
                transition: all 100ms cubic-bezier(0, 1.06, 0, 1.06);
                box-sizing: content-box;
            }
        }
        .focused {
            transform: translate(-15%, -20%) scale(.7);
            transition: 130ms cubic-bezier(0.65, 0.26, 0.52, 0.96);
        }
    }
    @keyframes radioWave {
        0% {
            height: 13px;
            width: 13px;
            opacity: 0.45;
        }
        100% {
            height: 28px;
            width: 28px;
            opacity: 0;
        }
    }

















    @media only screen and (max-width: 767px) {
        .profile-data-form {
            margin: 0 auto;
        }
    }

</style>


