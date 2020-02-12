<template>
    <div class="container mx-auto">
        <div class="mx-auto   w-11/12 md:w-10/12 lg:w-7/12">
        
            <form id="courseEditForm" @submit.prevent="submit">
                <div class="mt-8 mb-4 pb-1 border-b-2 border-gray-300">
                    <div class="text-2xl">Edit: <span class="text-gray-600">{{course_data.course_name}}</span></div>
                </div>
                <div class="flex flex-col sm:flex-row">
                    <div class="w-full flex justify-center items-center mb-4 min-h-64 overflow-hidden   sm:mb-0 sm:w-1/2">
                        <a href="#" @click="imageInputField">
                            <!-- <div class="course-placeholder flex justify-center items-center flex-col min-h-64 rounded"> -->
                                <img v-show="!courseImage" 
                                        src="/images/camera.svg" 
                                        width="75px" 
                                        height="75px" 
                                        alt="camera">
                                <img v-show="courseImage" 
                                        id="course_image" 
                                        ref="course_image"
                                        class="object-cover rounded h-64 w-full" 
                                        src="" 
                                        alt="course image">
                            <!-- </div> -->
                            <input type="file" 
                                    id="course_image_input" 
                                    name="course_image" 
                                    ref="course_image_input"
                                    class="hidden" 
                                    @change="validateImage" 
                                    @input="fieldChange">
                        </a>
                    </div>
                    <div class="w-full  bg-gray-100 shadow-md border rounded   sm:w-1/2 p-6 sm:ml-6">
                        <div class="flex flex-col py-2">
                            <label for="course_name" class="mb-1 sm:mb-0 text-gray-700 font-bold w-full">
                                Name:
                                <span v-show="errors.has('course_edit_form.course_name')" class="is-error"> (required)</span>
                            </label>
                            <input type="text"
                                    :class="{ 'is-error': errors.has('course_edit_form.course_name') }" 
                                    class="input-base"
                                    data-vv-scope="course_edit_form"
                                    v-validate="'required'"
                                    v-model="inputs.course_name"
                                    @input="fieldChange" 
                                    name="course_name">
                        </div>
                        <div class="flex flex-col py-2">
                            <label for="addressesAutoComplete" class="mb-1 sm:mb-0 text-gray-700 font-bold w-full">
                                Address:
                                <span v-show="errors.has('course_edit_form.course_address')" class="is-error"> (required)</span>
                            </label>
                            <input id="addressesAutoComplete"
                                    :class="{ 'is-error': errors.has('course_edit_form.course_address') }"
                                    class="input-base"
                                    data-vv-scope="course_edit_form"
                                    v-validate="'required'"
                                    name="course_address"  
                                    v-model="inputs.course_address"
                                    @input="fieldChange"
                                    placeholder="Start typing / select address from dropdown"
                                    type="text">
                        </div>
                        <div class="flex flex-col py-2">
                            <label for="course_phone" class="mb-1 sm:mb-0 text-gray-700 font-bold w-full">
                                Phone:
                                <span v-show="errors.has('course_edit_form.course_phone')" class="is-error"> (required)</span>
                            </label>
                            <input id="course_phone"
                                    :class="{ 'is-error': errors.has('course_edit_form.course_phone') }"
                                    class="input-base"
                                    data-vv-scope="course_edit_form"
                                    v-validate="'required'"
                                    name="course_phone"
                                    v-model="inputs.course_phone"
                                    @input="fieldChange"
                                    type="text">
                        </div>
                        
                        <button :class="[{'btn-disabled': !saveActive}, 'btn btn-blue mt-5']" :disabled="!saveActive">
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
                        
                        <input type="hidden" name="course_id" :value="course_data.id"/>
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
            <div class="flex justify-between items-center mt-8 mb-4 pb-1 border-b-2 border-gray-300">
                <div class="text-2xl">Manage: <span class="text-gray-600">Holegroups</span></div>
                <img src="/images/plus.svg" 
                        width="25px" 
                        height="25px"
                        class="hover:rotate-90 cursor-pointer modal-open" 
                        alt="Plus icon"
                        data-modal="true" 
                        data-target="#addHoleGroupModal">
            </div>
            <div class="flex flex-col sm:flex-row flex-wrap">
                <div class="w-full sm:w-1/2 lg:w-1/3 mb-5" v-for="holegroup in hole_groups" :key="holegroup.id">
                    <HolegroupCardComponent :holegroup="holegroup"/>
                </div>
            </div>
            <AddHoleGroupModal @holeGroupAdded="pushHoleGroup" :course_id="course_data.id"/>
        </div>
    </div>
</template>

<script>
    import LoadingSpinner from '../LoadingSpinner';
    import HolegroupCardComponent from './HolegroupCardComponent';
    import AddHoleGroupModal from './AddHoleGroupModal';
    export default {
        props: ['course', 'holegroups'],
        data() {
            return {
                inputs: {
                    course_name: '',
                    course_address: '',
                    course_phone: ''
                },
                courseImage: false,
                saveActive: false,
                savingData: false,

                hole_groups: this.holegroups ? JSON.parse(this.holegroups) : null,
                course_data: this.course ? JSON.parse(this.course) : null
            }
        },
        components: {LoadingSpinner, HolegroupCardComponent, AddHoleGroupModal},
        watch: {
            'inputs.course_phone': function(val) {
                let x = val.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                this.inputs.course_phone = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            }
        },
        created() {
            this.inputs.course_name = this.course_data.course_name;
            this.inputs.course_address = this.course_data.course_address;
            this.inputs.course_phone = this.course_data.course_phone;
            // --------------------
            this.saveActive = false;
        },
        mounted() {
            initAddressesAutoComplete();
            if (this.course_data.featured_image) {
                this.courseImage = true;
                let courseImage = this.$refs.course_image;
                courseImage.src = `https://teetyme-app.s3.us-east-2.amazonaws.com/${this.course_data.featured_image}`;
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
            },
            pushHoleGroup: function(holegroup) {
                this.hole_groups.push(holegroup);
            }
        }
    }
</script>
