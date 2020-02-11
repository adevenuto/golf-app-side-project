<template>
<!--Modal-->
    <div id="addHoleGroupModal" class="modal opacity-0 overflow-auto py-5 pointer-events-none fixed top-0 bottom-0 left-0 right-0">
        <div class="modal-close fixed top-0 bottom-0 left-0 right-0 bg-gray-900 z-40 opacity-25"></div>
        <div class="modal-container relative bg-white w-11/12 sm:w-8/12 md:w-1/2 mx-auto rounded shadow-md z-50 overflow-y-auto">
            
            <div class="modal-content py-4 text-left px-6">
                <!-- Modal Header -->
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold">Create new holegroup</p>
                    <div class="cursor-pointer z-50 modal-close">
                        <svg class="fill-current text-black pointer-events-none" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>
                <!-- Modal Body -->
                <form id="addHoleGroupForm" @submit.prevent="submit">
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
                    <!-- Modal Footer -->
                    <div class="flex flex-row-reverse mt-5">
                        <button type="button" class="btn btn-blue" @click.prevent="submit">
                            <div class="flex items-center">
                                <span class="mr-2">Create holegroup</span> 
                                <LoadingSpinner 
                                        v-if="savingData"
                                        borderWidth="2px" 
                                        borderTopColor="#00ce07" 
                                        borderBg="#f3f3f3" 
                                        size="15px"/>
                            </div>
                        </button>
                    </div>
                    <input type="hidden" name="course_id" :value="course_id"/>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import LoadingSpinner from '../LoadingSpinner.vue';
    export default {
        props: ['course_id'],
        data() {
            return {
                inputs: {
                    teebox: '',
                    course_image: '',
                    number_of_holes: '',
                    hole_group_name: ''
                },
                holeCount: 9,
                savingData: false
            }
        },
        components: {LoadingSpinner},
        methods: {
            submit: function() {
                var form = document.getElementById('addHoleGroupForm');
                var formData = new FormData(form);

                this.$validator.validateAll('course_form_s2')
                .then((s2_valid) => {
                    if (s2_valid) {
                        this.savingData = true;
                        axios.post('/course/holegroup/create', formData)
                        .then( res => {
                            this.savingData = false;
                            this.$emit('holeGroupAdded', res.data.holegroup);
                            _toggleModal('addHoleGroupModal');
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
