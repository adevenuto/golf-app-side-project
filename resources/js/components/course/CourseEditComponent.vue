<template>
    <div class="container">
        <form id="courseEditForm" @submit.prevent="submit">
            <div class="row">
                <div class="col-sm-12 my-2">
                    <h3>Edit basic course information below:</h3>
                    <hr>
                </div>
                <div class="col-sm-6 mb-4">
                    <a href="#" @click="imageInputField">
                        <div id="course-img-container">
                            <div class="course-placeholder d-flex justify-content-center align-items-center flex-column rounded">
                                <img v-show="!courseImage" src="/images/camera.svg" width="75px" height="75px" alt="camera">
                                <img v-show="courseImage" id="course_image" ref="course_image" src="" alt="course image">
                            </div>
                            <input type="file" 
                                    id="course_image_input" 
                                    name="course_image" 
                                    ref="course_image_input" 
                                    @change="validateImage" 
                                    @input="fieldChange">
                        </div>
                    </a>
                </div>
                <div class="col-sm-6">
                    <div class="col-sm-12">
                        <div class="input-text">
                            <label for="course_name" class="dynamic-label">
                                Name:
                                <span v-show="errors.has('course_edit_form.course_name')" class="is-error"> (required)</span>
                            </label>
                            <input id="course_name" 
                                    :class="{ 'is-error': errors.has('course_edit_form.course_name') }"
                                    data-vv-scope="course_edit_form"
                                    v-validate="'required'"
                                    name="course_name" 
                                    v-model="inputs.course_name"
                                    @input="fieldChange" 
                                    type="text">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="input-text">
                            <label for="addressesAutoComplete" class="dynamic-label">
                                Address:
                                <span v-show="errors.has('course_edit_form.course_address')" class="is-error"> (required)</span>
                            </label>
                            <input id="addressesAutoComplete"
                                    :class="{ 'is-error': errors.has('course_edit_form.course_address') }"
                                    data-vv-scope="course_edit_form"
                                    v-validate="'required'"
                                    name="course_address"  
                                    v-model="inputs.course_address"
                                    @input="fieldChange"
                                    placeholder="Start typing / select address from dropdown"
                                    type="text">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="input-text">
                            <label for="course_phone" class="dynamic-label">
                                Phone:
                                <span v-show="errors.has('course_edit_form.course_phone')" class="is-error"> (required)</span>
                            </label>
                            <input id="course_phone" 
                                    :class="{ 'is-error': errors.has('course_edit_form.course_phone') }"
                                    data-vv-scope="course_edit_form"
                                    v-validate="'required'"
                                    name="course_phone"
                                    v-model="inputs.course_phone"
                                    @input="fieldChange"
                                    type="text">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button class="btn btn-primary" :disabled="!saveActive">
                            <div class="d-flex align-items-center">
                                <span class="mr-2">Update course info</span> 
                                <LoadingSpinner 
                                        v-if="savingData"
                                        borderWidth="2px" 
                                        borderTopColor="#00ce07" 
                                        borderBg="#f3f3f3" 
                                        size="15px"/>
                            </div>
                        </button>
                    </div>
                    <input type="hidden" name="course_id" :value="_course.id"/>
                </div>
                <div class="col-sm-12 mt-5">
                    <h3>Edit course hole data below:</h3>
                    <hr>
                </div>
                <!-- Hidden Fields For AutoComplete Components -->
                <input type="hidden" id="street_number" name="street_number" disabled="true"/>
                <input type="hidden" id="route" name="route" disabled="true"/>
                <input type="hidden" id="locality" name="locality" disabled="true"/>
                <input type="hidden" id="administrative_area_level_1" name="administrative_area_level_1" disabled="true"/>
                <input type="hidden" id="country" name="country" disabled="true"/>
                <input type="hidden" id="postal_code" name="postal_code" disabled="true"/>
                <input type="hidden" id="lat" name="course_lat" disabled="true"/>
                <input type="hidden" id="lng" name="course_lng" disabled="true"/>
            </div>
        </form>
    </div>
</template>

<script>
    import LoadingSpinner from '../LoadingSpinner.vue';
    export default {
        props: ['course'],
        data() {
            return {
                inputs: {
                    course_name: '',
                    course_address: '',
                    course_phone: ''
                },
                courseImage: false,
                saveActive: false,
                savingData: false
            }
        },
        components: {LoadingSpinner},
        computed: {
            _course: function() {
                return  this.course ? JSON.parse(this.course) : null;
            }
        },
        created() {
            this.inputs.course_name = this._course.course_name;
            this.inputs.course_address = this._course.course_address;
            this.inputs.course_phone = this._course.course_phone;
            // --------------------
            this.saveActive = false;
        },
        mounted() {
            initAddressesAutoComplete();
            if (this._course.featured_image) {
                this.courseImage = true;
                let courseImage = this.$refs.course_image;
                courseImage.src = `https://teetyme-app.s3.us-east-2.amazonaws.com/${this._course.featured_image}`;
            }
        },
        methods: {
            submit: function() {
                let form = document.getElementById('courseEditForm');
                let formData = new FormData(form);

                this.savingData = true;
                this.$validator.validateAll('course_edit_form')
                .then((course_edit_form_valid) => {
                    if (course_edit_form_valid) {
                        axios.post("/course/update", formData)
                            .then( res => {
                                
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
                this.$refs.course_image_input.click();
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
                    let courseImage = document.getElementById('course_image');
                    courseImage.src=`${e.target.result}`;
                    that.courseImage = true;
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
    #course-img-container {
        // width: 250px;
        // height: 250px;
        // margin: 0 auto;
        .course-placeholder {
            height: inherit;
            width: inherit;
            overflow: hidden;
            box-shadow: 0px 1px 8px 0px #999;
        }
    }
    #course_image_input {
        display: none;
    }
    #course_image {
        object-fit: cover;
        height: 250px;
        width: 100%;
    }
</style>