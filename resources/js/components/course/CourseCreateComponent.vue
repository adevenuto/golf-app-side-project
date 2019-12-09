<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-8 mx-auto border shadow-sm">
                <header class="text-center">
                    <h1>Create a new course</h1>
                </header>
                <p>This is were you can create a new course that can be played by you, and all the other TeeTyme members.</p>
            </div>
            <div class="col-sm-8 mx-auto mt-5">
                <div class="row">
                    <div class="col-6">
                        <div class="input-dynamic_text">
                            <label for="course_name" class="dynamic-label">
                                Name:
                                <span v-show="errors.has('course_name')" class="is-error"> (required)</span>
                            </label>
                            <input id="course_name" 
                                    :class="{ 'is-error': errors.has('course_name') }"
                                    name="course_name" 
                                    v-model="inputs.course_name" 
                                    v-validate="'required'"
                                    type="text">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-dynamic_text">
                            <label for="course_name" class="dynamic-label">
                                Address:
                                <span v-show="errors.has('course_address')" class="is-error"> (required)</span>
                            </label>
                            <input id="course_address" 
                                    :class="{ 'is-error': errors.has('course_address') }"
                                    name="course_address" 
                                    v-model="inputs.course_address" 
                                    v-validate="'required'"
                                    type="text">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                inputs: {
                    course_name: ''
                }
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>