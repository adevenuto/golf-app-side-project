<template>
    <div class="modal fade" :id="modalId()" tabindex="-1" role="dialog" aria-labelledby="editHoleGroupLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form :id="formId()" @submit.prevent="submit">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editHoleGroupLabel">Edit holegroup</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-text">
                                    <label class="dynamic-label">
                                        Teebox:
                                        <span v-show="errors.has('course_form_s1.teebox')" class="is-error"> (required)</span>
                                    </label>
                                    <input :class="{ 'is-error': errors.has('holegroup_edit_form.teebox') }"
                                            name="teebox" 
                                            v-model="inputs.teebox" 
                                            data-vv-scope="holegroup_edit_form"
                                            v-validate="'required'"
                                            type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
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
                        
                            <input type="hidden" :value="holegroup.id" name="holegroup_id">
                        </div> 
                        <div class="row">
                            <div v-for="(hole, index) in holeGroupHoles" :key="index" class="col-4">
                                <div id="hole-inputs" class="input-number mb-3">
                                    <label for="course_phone" class="dynamic-label">
                                        Hole <span>#{{hole.hole_number}}</span>
                                    </label>

                                    <div class="d-flex justify-content-between">
                                        <input type="number" 
                                            maxlength="3"
                                            max="1200"
                                            v-validate="'required'"
                                            data-vv-scope="holegroup_edit_form"
                                            placeholder="length"
                                            :class="[{'is-error': errors.first('holegroup_edit_form.hole_length')},'col-6']"
                                            name="hole_length[]"
                                            v-model="holeGroupHoles[index].hole_length"
                                            aria-describedby="hole-length">
                                        <input type="number" 
                                            maxlength="1"
                                            max="7"
                                            v-validate="'required'"
                                            data-vv-scope="holegroup_edit_form"
                                            placeholder="par"
                                            :class="[{'is-error': errors.first('holegroup_edit_form.hole_par')},'col-5']"
                                            name="hole_par[]"
                                            v-model="holeGroupHoles[index].hole_par"
                                            aria-describedby="hole-par">
                                        <input type="hidden" :value="hole.id" name="hole_id[]">
                                    </div>
                                    
                                </div>
                            </div>
                        </div>           
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">
                            <div class="d-flex align-items-center">
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
                </div>
            </form>
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
                            let modal = '#'+this.modalId();
                            $(modal).modal('hide');
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