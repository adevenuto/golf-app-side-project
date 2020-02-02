<template> 
    <div class="container mx-auto">
        <div class="flex justify-center items-center">
            <div class="w-11/12 sm:w-8/12 mx-3 sm:mx-0 shadow-lg rounded overflow-hidden max-w-xl">
                <div class="bg-gray-200 text-gray-700 p-4">
                    <div class="text-2xl font-bold">Create a course</div>
                    <div class="text-sm">This is were you can create a new course that will be available to you, and all the other TeeTyme members.</div>
                </div>    
                <div class="p-4">
                    <form id="courseForm" enctype="multipart/form-data">
                        <div v-show="stepNumber == 1">
                            <div class="flex flex-col">
                                <div class="my-2">
                                    <label for="course_name" class="mb-1 inline-block text-gray-700 font-bold">
                                        Course Name:
                                        <span v-show="errors.has('course_form_s1.course_name')" class="is-error"> (required)</span>
                                    </label>
                                    <input type="text" 
                                            id="course_name"
                                            class="border border-gray-500 px-3 font-bold text-base w-full h-10 rounded outline-none focus:outline-none focus:border-blue-800" 
                                            :class="{ 'is-error': errors.has('course_form_s1.course_name') }"
                                            name="course_name" 
                                            v-model="inputs.course_name" 
                                            data-vv-scope="course_form_s1"
                                            v-validate="'required'">
                                </div>
                                <div class="my-2">
                                    <label for="addressesAutoComplete" class="mb-1 inline-block text-gray-700 font-bold">
                                        Course Address:
                                        <span v-show="errors.has('course_form_s1.course_address')" class="is-error"> (required)</span>
                                    </label>
                                    <input type="text"
                                            id="addressesAutoComplete" 
                                            class="border border-gray-500 px-3 font-bold text-base w-full h-10 rounded outline-none focus:outline-none focus:border-blue-800" 
                                            :class="{ 'is-error': errors.has('course_form_s1.course_address') }"
                                            name="course_address" 
                                            v-model="inputs.course_address" 
                                            data-vv-scope="course_form_s1"
                                            v-validate="'required'">
                                </div>
                                <div class="my-2">
                                    <label for="course_phone" class="mb-1 inline-block text-gray-700 font-bold">
                                        Phone:
                                        <span v-show="errors.has('course_form_s1.course_phone')" class="is-error"> (required)</span>
                                    </label>
                                    <input id="course_phone" 
                                            :class="{ 'is-error': errors.has('course_form_s1.course_phone') }"
                                            class="border border-gray-500 px-3 font-bold text-base w-full h-10 rounded outline-none focus:outline-none focus:border-blue-800"
                                            name="course_phone" 
                                            v-model="inputs.course_phone"
                                            data-vv-scope="course_form_s1" 
                                            v-validate="'required|length:14'"
                                            type="text">
                                </div>
                                <div class="my-2">
                                    <label class="dynamic-label">Featured Image:</label>
                                    <input id="courseImage"
                                            class="hidden" 
                                            type="file" 
                                            name="course_image">
                                    <label for="courseImage" class="block border-dashed border-2 py-8 text-center">Select a course image</label>
                                </div>
                                <input type="hidden" id="street_number" name="street_number" disabled="true"/>
                                <input type="hidden" id="route" name="route" disabled="true"/>
                                <input type="hidden" id="locality" name="locality" disabled="true"/>
                                <input type="hidden" id="administrative_area_level_1" name="administrative_area_level_1" disabled="true"/>
                                <input type="hidden" id="country" name="country" disabled="true"/>
                                <input type="hidden" id="postal_code" name="postal_code" disabled="true"/>
                                <input type="hidden" id="lat" name="course_lat" disabled="true"/>
                                <input type="hidden" id="lng" name="course_lng" disabled="true"/>
                            </div>
                        </div>
                        <div v-show="stepNumber == 2">  
                            <div class="flex flex-col sm:flex-row my-2">
                                <div class="w-full mb-4 sm:mb-0 sm:w-1/2 sm:mr-2">
                                    <label for="holeCount" class="mb-1 inline-block text-gray-700 font-bold">Number of holes:</label>
                                    <select v-model="holeCount"
                                            class="border border-gray-500 px-3 font-bold text-base w-full h-10 rounded outline-none focus:outline-none focus:border-blue-800"
                                            id="holeCount"                                    
                                            name="number_of_holes">
                                        <option :value="18">18</option>
                                        <option :value="9">9</option>
                                    </select>
                                </div>
                                <div class="w-full sm:w-1/2 sm:ml-2">
                                    <label for="teebox" class="mb-1 inline-block text-gray-700 font-bold">
                                        Teebox:
                                        <span v-show="errors.has('course_form_s2.teebox')" class="is-error"> (required)</span>
                                    </label>
                                    <input id="teebox" 
                                            :class="{ 'is-error': errors.has('course_form_s2.teebox') }"
                                            class="border border-gray-500 px-3 font-bold text-base w-full h-10 rounded outline-none focus:outline-none focus:border-blue-800"
                                            name="teebox" 
                                            v-model="inputs.teebox" 
                                            data-vv-scope="course_form_s2"
                                            v-validate="'required'"
                                            type="text">
                                </div>
                            </div>
                            <div class="flex">
                                <div class="my-2 flex-1">
                                    <label for="holeGroupName" class="mb-1 inline-block text-gray-700 font-bold">
                                        Hole group name:
                                    </label>
                                    <input id="holeGroupName" 
                                            class="border border-gray-500 px-3 font-bold text-base w-full h-10 rounded outline-none focus:outline-none focus:border-blue-800"
                                            name="group_name" 
                                            v-model="inputs.hole_group_name" 
                                            data-vv-scope="course_form_s2"
                                            v-validate="'required'"
                                            type="text">
                                    </div>
                            </div>
                            <div class="flex flex-wrap my-6">
                                <div v-for="index in holeCount" :key="index" class="w-1/3">
                                    <div class="mb-6">
                                        <label class="text-gray-700">
                                            Hole <span>#{{index}}</span>
                                        </label>
                                        <div id="hole-inputs" class="flex justify-between px-2">
                                            <input type="number" 
                                                maxlength="3"
                                                min="20"
                                                max="1200"
                                                v-validate="'required'"
                                                data-vv-scope="course_form_s2"
                                                placeholder="length"
                                                :class="[{'is-error': errors.first('course_form_s2.'+holeName(index))},'w-8/12 border-b border-gray-200 pl-1 border-blue-800 mr-2']"
                                                :name="holeName(index)"
                                                value="421"
                                                aria-describedby="hole-length">
                                            <input type="number" 
                                                maxlength="1"
                                                min="3"
                                                max="7"
                                                v-validate="'required'"
                                                data-vv-scope="course_form_s2"
                                                placeholder="par"
                                                :class="[{'is-error': errors.first('course_form_s2.'+holePar(index))},'w-4/12 border-b border-gray-200 pl-1 border-blue-800']"
                                                :name="holePar(index)"
                                                value="4"
                                                aria-describedby="hole-length">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </form>
                    <div class="flex flex-row-reverse mt-8">
                        <template v-if="stepNumber == 1">
                            <button type="button" 
                                    class="bg-blue-700 text-white rounded py-2 px-4" 
                                    @click.prevent="step_forward">
                                Add holes >>
                            </button>
                        </template>
                        <template v-if="stepNumber == 2">
                            <button type="button" class="bg-blue-700 text-white rounded py-2 px-4" @click.prevent="submit">
                                <div class="flex items-center">
                                    <span class="mr-2">Create course</span> 
                                    <LoadingSpinner 
                                            v-if="savingData"
                                            borderWidth="2px" 
                                            borderTopColor="#00ce07" 
                                            borderBg="#f3f3f3" 
                                            size="15px"/>
                                </div>
                            </button>
                        </template>
                        <button v-show="notStepOne" type="button" class="bg-gray-700 text-white rounded py-2 px-4 mr-2" @click="step_back">
                            Back 
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LoadingSpinner from '../LoadingSpinner.vue';
    export default {
        props: ['user'],
        data() {
            return {
                inputs: {
                    course_name: '',
                    course_phone: '',
                    course_address: 'chicago',
                    teebox: '',
                    course_image: '',
                    number_of_holes: '',
                    hole_group_name: ''
                },
                stepNumber: 1,
                stepMax: 2,
                holeCount: 9,
                savingData: false
            }
        },
        components: {LoadingSpinner},       
        watch: {
            'inputs.course_phone': function(val) {
                let x = val.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                this.inputs.course_phone = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            }
        },
        mounted() {
            initAddressesAutoComplete();
        },
        computed: {
            notStepOne: function() {
                return this.stepNumber > 1;
            }
        },
        methods: {
            step_forward: function() {
                this.$validator.validateAll('course_form_s1')
                .then((s1_valid) => {
                    if (s1_valid && (this.stepNumber < this.stepMax)) {
                        this.stepNumber ++;
                    }
                });
            },
            step_back: function() {
                if (this.stepNumber > 1) this.stepNumber --;
            },
            submit: function() {
                var form = document.getElementById('courseForm');
                var formData = new FormData(form);

                this.$validator.validateAll('course_form_s2')
                .then((s2_valid) => {
                    if (s2_valid) {
                        this.savingData = true;
                        axios.post("/course/store", formData)
                        .then( res => {
                            this.savingData = false;
                            window.location = '/courses';
                        })
                        .catch( err => {
                            this.savingData = false;
                        });
                    }
                });
            },
            holeName(index) {
				return 'hole_'+index;
            },
            holePar(index) {
				return 'holepar_'+index;
            }
        }
    }
</script>

<style lang="scss" scoped>
    #hole-inputs {
        input::-webkit-input-placeholder {
            font-size: .5rem;
        } 
    }
</style>