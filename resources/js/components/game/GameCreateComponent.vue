<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <ul>
                    <li v-for="course in _courses" 
                        :key="course.id"
                        @click="getHoleGroups(course.id)">
                        {{course.course_name}}
                    </li>
                </ul>
            </div>
            <div class="col-sm-6">
                <label class="mr-2" v-for="holeGroup in courseHoleGroups" 
                    :key="holeGroup.id">
                    <input type="radio" 
                            :value="holeGroup.teebox"                              
                            v-model="teeboxSelected"
                            @click="getHoles(holeGroup.id)"> 
                    {{ holeGroup.teebox }}
                </label>    
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3" v-for="hole in courseHoles" :key="hole.id">
                <span>{{ hole.hole_number }}</span>
                <span>{{ hole.hole_length }}</span>
            </div>    
        </div>
    </div>
</template>

<script>
    export default {
        props: ['courses'],
        data() {
            return {
                courseHoleGroups: [],
                courseHoles: [],
                teeboxSelected: null
            }
        },
        computed: {
            _courses: function() {
                return  this.courses ? JSON.parse(this.courses) : null;
            }
        },
        methods: {
            getHoleGroups(course_id) {
                this.clearSelections();
                axios.get(`/course/${course_id}/holegroups`)
                    .then(response => {
                        let holeGroups = response.data.holegroups;
                        this.courseHoleGroups = holeGroups;
                    })
                    .catch(response => console.log(response.data));
            },
            getHoles(holegroup_id) {
                axios.get(`/course/holegroup/${holegroup_id}`)
                    .then(response => {
                        let holes = response.data.holes;
                        this.courseHoles = holes;
                    })
                    .catch(response => console.log(response.data));
            },
            clearSelections: function() {
                this.teeboxSelected = null;
                this.courseHoles = [];
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>