<template>
    <div class="modal fade" id="addHoleGroupModal" tabindex="-1" role="dialog" aria-labelledby="addHoleGroupLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="addHoleGroupForm" @submit.prevent="submit">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addHoleGroupLabel">Create new holegroup</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
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
                                <div class="input-text">
                                    <label for="teebox" class="dynamic-label">
                                        Teebox:
                                        <span v-show="errors.has('course_form_s1.teebox')" class="is-error"> (required)</span>
                                    </label>
                                    <input id="teebox" 
                                            :class="{ 'is-error': errors.has('course_form_s2.teebox') }"
                                            name="teebox" 
                                            v-model="inputs.teebox" 
                                            data-vv-scope="course_form_s2"
                                            v-validate="'required'"
                                            type="text">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="input-text">
                                    <label class="dynamic-label mr-3">Holes group Name:
                                       
                                    </label>
                                <input v-model="inputs.hole_group_name" 
                                        name="group_name" 
                                        type="text">
                                </div>
                            </div>
                            
                            
                            <div v-for="index in holeCount" :key="index" class="col-4">
                                <div id="hole-inputs" class="input-number mb-3">
                                    <label for="course_phone" class="dynamic-label">
                                        Hole <span>#{{index}}</span>
                                    </label>
                                    <div class="d-flex justify-content-between">
                                        <input type="number" 
                                            maxlength="3"
                                            max="1200"
                                            v-validate="'required'"
                                            data-vv-scope="course_form_s2"
                                            placeholder="length"
                                            :class="[{'is-error': errors.first('course_form_s2.'+holeName(index))},'col-6']"
                                            :name="holeName(index)"
                                            value="444"
                                            aria-describedby="hole-length">
                                        <input type="number" 
                                            maxlength="1"
                                            max="7"
                                            v-validate="'required'"
                                            data-vv-scope="course_form_s2"
                                            placeholder="par"
                                            :class="[{'is-error': errors.first('course_form_s2.'+holePar(index))},'col-5']"
                                            :name="holePar(index)"
                                            value="4"
                                            aria-describedby="hole-length">
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">
                            <div class="d-flex align-items-center">
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
                </div>
            </form>
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
                            $('#addHoleGroupModal').modal('hide');
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
    .dynamic-label span {
        font-size: 0.7rem;
        position: relative;
        top: -4px;
    }
    #hole-inputs {
        input {
            padding: 0 5px 0 0;
            font-size: .9rem;
        }
        input::-webkit-input-placeholder {
            font-size: .5rem;
        }
        .dynamic-label span {
            color: #000;
            font-size: .9rem;
        }
    }
</style>