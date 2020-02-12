<template>
    <div :id="modalId()" class="modal opacity-0 overflow-auto py-5 pointer-events-none fixed top-0 bottom-0 left-0 right-0">
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
                <form :id="formId()" @submit.prevent="submit">
                    
                    <div class="flex flex-col sm:flex-row my-2">
                        <div class="w-full mb-4 sm:mb-0 sm:w-1/2 sm:mr-2">
                            <label :for="groupNameId()" class="mb-1 inline-block text-gray-700 font-bold">
                                Hole group name:
                                <span v-show="errors.has('holegroup_edit_form.group_name')" class="is-error"> (required)</span>
                            </label>
                            <input :id="groupNameId()" 
                                    class="input-base"
                                    name="group_name" 
                                    v-model="inputs.hole_group_name" 
                                    data-vv-scope="holegroup_edit_form"
                                    v-validate="'required'"
                                    type="text">
                        </div>
                        <div class="w-full sm:w-1/2 sm:ml-2">
                            <label :for="teeBoxId()" class="mb-1 inline-block text-gray-700 font-bold">
                                Teebox:
                                <span v-show="errors.has('holegroup_edit_form.teebox')" class="is-error"> (required)</span>
                            </label>
                            <input :id="teeBoxId()" 
                                    :class="{ 'is-error': errors.has('holegroup_edit_form.teebox') }"
                                    class="input-base"
                                    name="teebox" 
                                    v-model="inputs.teebox" 
                                    data-vv-scope="holegroup_edit_form"
                                    v-validate="'required'"
                                    type="text">
                        </div>
                        <input type="hidden" :value="holegroup.id" name="holegroup_id">
                    </div>

                    <div class="flex flex-wrap my-6">
                        <div v-for="(hole, index) in holeGroupHoles" :key="index" class="w-1/3">
                            <div class="mb-6">
                                <label class="text-gray-700">
                                    Hole <span>#{{hole.hole_number}}</span>
                                </label>
                                <div id="hole-inputs" class="flex justify-between px-2">
                                    <input type="number" 
                                            maxlength="3"
                                            min="20"
                                            max="1200"
                                            v-validate="'required'"
                                            data-vv-scope="holegroup_edit_form"
                                            placeholder="length"
                                            :class="[{'is-error': errors.first('holegroup_edit_form.hole_length')},'w-8/12 border-b border-gray-200 pl-1 border-blue-800 mr-2']"
                                            name="hole_length[]"
                                            v-model="holeGroupHoles[index].hole_length"
                                            aria-describedby="hole-length">
                                    <input type="number" 
                                            maxlength="1"
                                            min="3"     
                                            max="7"
                                            v-validate="'required'"
                                            data-vv-scope="holegroup_edit_form"
                                            placeholder="par"
                                            :class="[{'is-error': errors.first('holegroup_edit_form.hole_par')},'w-4/12 border-b border-gray-200 pl-1 border-blue-800']"
                                            name="hole_par[]"
                                            v-model="holeGroupHoles[index].hole_par"
                                            aria-describedby="hole-par">
                                    <input type="hidden" :value="hole.id" name="hole_id[]">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex flex-row-reverse mt-5">
                        <button class="btn btn-blue">
                            <div class="flex items-center">
                                <span class="mr-2">Update holegroup</span> 
                                <LoadingSpinner 
                                        v-if="savingData"
                                        borderWidth="2px" 
                                        borderTopColor="#00ce07" 
                                        borderBg="#f3f3f3" 
                                        size="15px"/>
                            </div>
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
        props: ['holegroup'],
        data() {
            return {
                savingData: false,
                holeGroupHoles: [],
                inputs: {
                    teebox: this.holegroup.teebox,
                    hole_group_name: this.holegroup.group_name
                }
            }
        },
        components: {LoadingSpinner},
        created() {
            axios.get(`/course/holegroup/edit/${this.holegroup.id}`)
            .then( res => {
                this.holeGroupHoles = res.data.holeGroupHoles
            })
            .catch( err => {
                console.log(err);
            });
        },
        methods: {
            submit: function() {
                var form = document.getElementById(this.formId());
                var formData = new FormData(form);

                this.$validator.validateAll('holegroup_edit_form')
                .then((holegroup_edit_form_valid) => {
                    if (holegroup_edit_form_valid) {
                        this.savingData = true;
                        axios.post("/course/holegroup/update", formData)
                        .then( res => {
                            this.savingData = false;
                            let modal = this.modalId();
                            _toggleModal(modal);
                        })
                        .catch( err => {
                            this.savingData = false;
                        });
                    }
                });
            },
            modalId: function() {
                return 'editHoleGroupModal_'+this.holegroup.id;
            },
            formId: function() {
                return 'editHoleGroupForm_'+this.holegroup.id;
            },
            groupNameId: function() {
                return 'holeGroupName_'+this.holegroup.id;
            },
            teeBoxId: function() {
                return 'teebox_'+this.holegroup.id;
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