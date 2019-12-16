<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <div class="border shadow-sm p-3">
                    <header class="text-center">
                        <h1>Create a new course</h1>
                    </header>
                    <p>This is were you can create a new course that will be available to you, and all the other TeeTyme members.</p>
                </div>
            </div>
            <div class="col-sm-8 mx-auto mt-5">
                <form id="courseForm" class="p-3" enctype="multipart/form-data">
                    
                    <div v-show="stepNumber == 1" class="row">  
                        <div class="col-sm-12">
                            <div class="input-text">
                                <label for="course_name" class="dynamic-label">
                                    Name:
                                    <span v-show="errors.has('course_form_s1.course_name')" class="is-error"> (required)</span>
                                </label>
                                <input id="course_name" 
                                        :class="{ 'is-error': errors.has('course_form_s1.course_name') }"
                                        name="course_name" 
                                        v-model="inputs.course_name" 
                                        data-vv-scope="course_form_s1"
                                        v-validate="'required'"
                                        type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-text">
                                <label for="addressesAutoComplete" class="dynamic-label">
                                    Address:
                                    <span v-show="errors.has('course_form_s1.course_address')" class="is-error"> (required)</span>
                                </label>
                                <input id="addressesAutoComplete" 
                                        :class="{ 'is-error': errors.has('course_form_s1.course_address') }"
                                        name="course_address" 
                                        v-model="inputs.course_address"
                                        data-vv-scope="course_form_s1" 
                                        placeholder="Start typing / select address from dropdown"
                                        v-validate="'required'"
                                        type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-text">
                                <label for="course_phone" class="dynamic-label">
                                    Phone:
                                    <span v-show="errors.has('course_form_s1.course_phone')" class="is-error"> (required)</span>
                                </label>
                                <input id="course_phone" 
                                        :class="{ 'is-error': errors.has('course_form_s1.course_phone') }"
                                        name="course_phone" 
                                        v-model="inputs.course_phone"
                                        data-vv-scope="course_form_s1" 
                                        v-validate="'required|length:14'"
                                        type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-file m-0">
                                <label class="dynamic-label">Featured Image:</label>
                                <input id="courseImage" 
                                        type="file" 
                                        name="course_image">
                                <label class="input-file-btn btn btn-outline-black btn-sm mb-0" for="courseImage">Upload file</label>
                            </div>
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
                    <div v-show="stepNumber == 2" class="row">  
                        <div class="col-sm-6">
                            <div class="input-select">
                                <label class="dynamic-label">Number of holes:</label>
                                <select v-model="holeCount"                                    
                                        name="number_of_holes">
                                    <option :value="18">18</option>
                                    <option :value="9">9</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-select">
                                <label class="dynamic-label">Teebox:</label>
                                <div class="teebox-custom d-flex align-items-center">
                                    <div :class="[{
                                        'bg-blue': teebox == 'blue', 
                                        'bg-white': teebox == 'white', 
                                        'bg-red': teebox == 'red'},
                                        'select-dot']">
                                    </div>
                                    <select v-model="teebox" 
                                            name="teebox">
                                        <option value="blue">Blue</option>
                                        <option value="white">White</option>
                                        <option value="red">Red</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="input-text">
                                <label class="dynamic-label mr-3">Holes group Name:
                                    <a data-trigger="focus"
                                        v-tooltip:bottom="'Some courses have multiple 9 or 18-hole layouts. If this course has different (individually named) groups of holes, name this group accordingly. If not, leave this field blank.'"
                                        tabindex="0"
                                        data-toggle="popover"
                                        alt="info-box">
                                        <img src="/images/information-box.svg" 
                                        width="13px" 
                                        height="13px">
                                    </a>
                                </label>
                            <input v-model="inputs.hole_group_name" 
                                    name="group_name" 
                                    type="text">
                            </div>
                        </div>
                        
                        
                        <div v-for="index in holeCount" :key="index" class="col-3">
                            <div class="input-text mb-2">
                                <label for="course_phone" class="dynamic-label">
                                    Hole <span>#{{index}}</span>
                                </label>
                                <input type="text" 
                                        maxlength="3"
                                        v-validate="'required'"
                                        data-vv-scope="course_form_s2"
                                        :class="[{'is-error': errors.first('course_form_s2.'+holeName(index))},'num-only']"
                                        :name="holeName(index)"
                                        value="432"
                                        aria-describedby="hole-length">
                            </div>
                        </div>
                        
                    </div>
                    
                    
                    <div class="d-flex flex-row-reverse mt-5">
                        <template v-if="stepNumber == 1">
                            <button type="button" 
                                    class="btn btn-primary btn-lg" 
                                    @click.prevent="step_forward">
                                Add holes >>
                            </button>
                        </template>
                        <template v-if="stepNumber == 2">
                            <button type="button" class="btn btn-primary btn-lg" @click.prevent="submit">
                                <div class="d-flex align-items-center">
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
                        <button v-show="notStepOne" type="button" class="btn btn-outline-secondary btn-lg mr-2" @click="step_back">
                            Back 
                        </button>
                    </div>

                </form>
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
                    course_image: '',
                    number_of_holes: '',
                    hole_group_name: ''
                },
                stepNumber: 1,
                stepMax: 2,
                holeCount: 9,
                teebox: 'blue',
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
            }
        }
    }
</script>

<style lang="scss" scoped>
    #courseFormWrapper {
        height: 350px;
        .row {
            height: inherit;
        }
    }
    .input-file .input-file-btn {
        text-align: center;
        display: block;
        max-width: 33%;
    }
    .btn-outline-black {
        color: #173e5f;
        border-color: #080808;
        border-width: 2px;
        border-radius: 0;
        cursor: pointer;
        &:hover {
            color: #000;
        }
    }
    .teebox-custom {
        position: relative;
        width: 100%;
        select[name=teebox] {
            padding-left: 1.5rem;
        }
    }
    .select-dot {
        position: absolute;
        left: 4px;
        top: 4px;
        border: 1px solid #999;
        border-radius: 12px;
        width: 12px;
        height: 12px;
    }
    .dynamic-label span {
        font-size: 0.7rem;
        position: relative;
        top: -4px;
    }
    .bg-blue {
        background: #0c498e !important;
    }
    .bg-white {
        background: #fff !important;
    }
    .bg-red {
        background: #f00 !important;
    }
</style>