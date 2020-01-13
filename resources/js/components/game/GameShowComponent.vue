<template>
    <div class="container">
        <div class="row">
            <h1 class="col-sm-12">{{course_data.course_name}}</h1>
            
            <hr>
            <div class="col-sm-3" v-for="object in hole_groups" :key="object.holegroup.id">
                {{ object.holegroup.group_name}}
                <div v-for="hole in object.holes" :key="hole.id">
                    {{ hole.hole_number }}, {{ hole.hole_length }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['course', 'holegroups'],
        data() {
            return {
                hole_groups: this.holegroups ? JSON.parse(this.holegroups) : null,
                course_data: this.course ? JSON.parse(this.course) : null
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>