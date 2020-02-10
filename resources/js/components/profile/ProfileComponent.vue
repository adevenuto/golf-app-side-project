<template>
    <div class="container mx-auto">
        <LoadingOverlay v-if="fetchingProfileData" />
        <form id="profileForm" @submit.prevent="submit">
            <div class="flex flex-col mx-auto    w-11/12 sm:w-10/12 sm:flex-row">
                <div class="w-full sm:w-1/2 mb-4 mr-0 sm:mr-2 sm:mb-0 min-h-56">
                    <div :class="[{'border rounded': !profileImage},'flex justify-center items-center w-56 h-56 mx-auto']">
                        <a href="#" @click="imageInputField">
                            <img v-show="!profileImage" 
                                    src="images/camera.svg" 
                                    width="75" 
                                    height="75" 
                                    alt="camera">
                            
                            <img v-show="profileImage" 
                                    id="profile_image" 
                                    class="object-fit h-56 rounded"
                                    ref="profile_image" 
                                    src="" 
                                    alt="profile image">
                            <input type="file" 
                                    id="profile_image_input" 
                                    name="profile_image"
                                    class="hidden" 
                                    ref="profile_image_input" 
                                    @change="validateImage" 
                                    @input="fieldChange">
                        </a>
                    </div>
                </div>
                <div class="p-5 w-full mr-0 sm:w-1/2 sm:ml-2 bg-gray-100 shadow-md border rounded">
                    <div class="w-full py-2">
                        <label for="nick_name" class="mb-1 sm:mb-0 text-gray-700 font-bold w-full">
                            Name:
                            <span v-show="errors.has('nick_name')" class="is-error"> (required)</span>
                        </label>
                        <input id="nickname" 
                            :class="{ 'is-error': errors.has('nick_name') }"
                            class="border border-gray-500 px-3 font-bold text-base w-full h-10 rounded outline-none focus:outline-none focus:border-blue-800"
                            @input="fieldChange"
                            name="nick_name" 
                            v-model="inputs.nickname" 
                            v-validate="'required'"
                            type="text">
                    </div>
                    <div class="w-full py-2">
                        <div class="mb-1 sm:mb-0 text-gray-700 font-bold w-full">
                            Gender:
                            <span v-show="errors.has('gender')" class="is-error"> (required)</span>
                        </div>
                        <div class="flex flex-row">
                            <label class="mr-3">
                                <input type="radio" v-validate="'required'" name="gender" value="male" v-model="inputs.gender" @input="fieldChange"> 
                                Male
                            </label>
                            <label>
                                <input type="radio" v-validate="'required'" name="gender" value="famale" v-model="inputs.gender" @input="fieldChange"> 
                                Female
                            </label>
                        </div>
                    </div>
                    <div class="w-full py-2">
                        <label for="age" class="mb-1 sm:mb-0 text-gray-700 font-bold w-full">
                            Age:
                            <span v-show="errors.has('age')" class="is-error"> (required)</span>
                        </label>
                        <input id="age" 
                            :class="{ 'is-error': errors.has('age') }"
                            class="border border-gray-500 px-3 font-bold text-base w-full h-10 rounded outline-none focus:outline-none focus:border-blue-800"
                            @input="fieldChange"
                            name="age"
                            maxLength="3" 
                            v-model="inputs.age" 
                            v-validate="'required'"
                            type="text">
                    </div>
                    <div class="w-full py-2">
                        <label for="citiesAutoComplete" class="mb-1 sm:mb-0 text-gray-700 font-bold w-full">
                            City:
                            <span v-show="errors.has('locality')" class="is-error"> (required)</span>
                        </label>
                        <input id="citiesAutoComplete" 
                            :class="{ 'is-error': errors.has('locality') }"
                            class="border border-gray-500 px-3 font-bold text-base w-full h-10 rounded outline-none focus:outline-none focus:border-blue-800"
                            @input="fieldChange"
                            placeholder="Start typing / select city from dropdown" 
                            name="locality" 
                            v-model="inputs.locality" 
                            v-validate="'required'"
                            type="text">
                    </div>
                    <button :class="[{'cursor-not-allowed opacity-75': !saveActive}, 'bg-blue-700 text-white rounded py-2 px-4 mt-5']" :disabled="!saveActive">
                        <div class="flex items-center">
                            <span class="mr-2">Update course info</span> 
                            <LoadingSpinner 
                                    v-if="savingData"
                                    borderWidth="2px" 
                                    borderTopColor="#00ce07" 
                                    borderBg="#f3f3f3" 
                                    size="15px"/>
                        </div>
                    </button>
                    <input type="hidden" id="locality" name="locality" disabled="true"/>
                    <input type="hidden" id="administrative_area_level_1" name="administrative_area_level_1" disabled="true"/>
                    <input type="hidden" id="administrative_area_level_2" name="administrative_area_level_2" disabled="true"/>
                    <input type="hidden" id="country" name="country" disabled="true"/>
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
        watch: {
            'inputs.age': function(val) {
                let x = /^\d*\.?\d*$/.test(val);
                this.inputs.age = x ? val : '';
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
            initCitiesAutoComplete();  
            if (this.authUser.image_path) {
                this.profileImage = true;
                let profileImage = this.$refs.profile_image;
                profileImage.src = `https://teetyme-app.s3.us-east-2.amazonaws.com/${this.authUser.image_path}`;
            }
        },
        methods: {
            submit: function() {
                let form = document.getElementById('profileForm');
                let formData = new FormData(form);

                this.savingData = true;
                this.$validator.validateAll()
                .then((isValidated) => {
                    if (isValidated) {
                        axios.post("/profile/store", formData)
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
            imageInputField: function(e) {
                this.$refs.profile_image_input.click();
            },
            validateImage: function(e) {
                const that = this;
                let inputFiles = e.target.files;
                if (inputFiles && inputFiles[0]) {
                    let allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
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



