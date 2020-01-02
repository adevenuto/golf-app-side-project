<template>
    <div class="container">
        <div class="row">

            <div class="col-sm-8 mx-auto">
                <div class="d-flex align-items-center">
                    <div class="step-number align-self-start mr-3">
                        <img v-if="!selectedCourse" src="/images/step-one.svg" width="50px" height="50px" alt="step icon">
                        <img v-else src="/images/step-complete.svg" width="50px" height="50px" alt="step icon">
                    </div>
                    <div class="step-desc">
                        <h3 class="font-weight-bold">Start by selecting a course:</h3>
                        <div id="search-input" class="input-text mb-0">
                            <input id="course_name" 
                            placeholder="Search for a course..."
                            v-model="searchTerm"
                            @input="searchCourses"
                            type="text">
                            <img src="/images/magnifying-glass.svg" alt="magnification glass">
                        </div>
                        <div v-for="course in courses" 
                                :key="course.id" 
                                class="result-row"
                                @click="setCourse(course.course_name, course.id)">
                            {{course.course_name}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-8 mx-auto">
                <div class="d-flex align-items-center">
                    <div class="step-number align-self-start mr-3">
                        <img v-if="!teebox" src="/images/step-two.svg" width="50px" height="50px" alt="step icon">
                        <img v-else src="/images/step-complete.svg" width="50px" height="50px" alt="step icon">
                    </div>
                    <div class="step-desc">
                        <h3 class="font-weight-bold">Select a teebox:</h3>
                        <div v-if="teeboxes.length" class="select-teebox-prompt">
                            <span v-for="_teebox in teeboxes" 
                                    :class="[{'activeTeebox': _teebox == teebox},'btn', 'btn-sm','btn-outline-secondary', 'mr-2']"  
                                    :key="_teebox"
                                    @click="setTeebox(_teebox)">
                                    {{_teebox}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-8 mx-auto">
                <div class="d-flex align-items-center">
                    <div class="step-number align-self-start mr-3">
                        <img v-if="!holesSelected" src="/images/step-three.svg" width="50px" height="50px" alt="step icon">
                        <img v-else src="/images/step-complete.svg" width="50px" height="50px" alt="step icon">
                    </div>
                    <div class="step-desc">
                        <h3 class="font-weight-bold">Select holes to play:</h3>
                        <div v-if="holegroup_holes.length">
                            <!-- <div class="row"> -->
                                <div v-for="group in holegroup_holes" 
                                    class="card col-10 mb-2" 
                                    :key="group.id"
                                    @click="setHoles">
                                    <span v-if="group.holegroup.group_name">
                                        Name: 
                                        <span class="text-secondary">{{ group.holegroup.group_name }}</span>
                                    </span>
                                    <span>Holes: <span class="text-secondary">{{ group.holes.length }}</span></span>
                                </div>
                            <!-- </div> -->
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import _ from 'lodash';
    export default {
        data() {
            return {
                courses: [],
                searchTerm: '',
                selectedCourse: null,

                teeboxes: [],
                teebox: null,

                holesSelected: false,
                holegroup_holes: []
            }
        },
        watch: {
            searchTerm: function(val) {
                if (!val) {
                    this.selectedCourse = null;
                    this.teebox = null;
                    this.teeboxes = [];
                    this.holegroup_holes = [];
                }
            }
        },
        methods: {
            searchCourses: _.debounce(function() {
                axios.get(`/courses/search?term=${this.searchTerm}`)
                .then( payload => {
                    this.courses = payload.data.courses;
                })
                .catch( err => {
                    this.courses = [];
                });
            }, 200),
            setCourse: function(course_name, course_id) {
                let course = {
                    name: course_name,
                    id: course_id
                }
                this.selectedCourse = course;
                this.searchTerm = this.selectedCourse.name;
                this.teeboxes = [];
                this.teebox = null;
                this.courses = [];
                this.getTeeboxes(course.id);
            },
            getTeeboxes: function(course_id) {
                axios.get(`/course/teeboxes/${course_id}`)
                .then( payload => {
                    let teeboxes = payload.data.teeboxes;
                    this.teeboxes = [];
                    teeboxes.forEach(teebox => {
                        this.teeboxes.push(teebox);
                    })
                })
                .catch( err => {
                    console.log(err);
                });
            },
            setTeebox: function(teebox) {
                this.teebox = teebox;
                this.getHolegroups();
            },
            getHolegroups: function() {
                let course_id = this.selectedCourse.id;
                let teebox = this.teebox;
                axios.get(`/course/${course_id}/holegroups/${teebox}`)
                .then( payload => {
                    this.holegroup_holes = payload.data.holegroupWithHoles;
                })
                .catch( err => {
                    console.log(err);
                });
            },
            setHoles: function() {
                this.holesSelected = true;
            },
        }
    }
</script>

<style lang="scss" scoped>
    #search-input {
        position: relative;
        input {
            padding-left: 40px;
        }
        img {
            position: absolute;
            width: 22px;
            left: 0;
            top: 0;
        }
    }
    .step-desc {
        min-height: 320px;
        flex-grow: 1;
        width: 100%;
        .card:hover {
            background: #f5f5f5;
        }
    }
    .activeTeebox {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .result-row {
        padding: 3px 0;
        border-bottom: 1px solid #e6e6e6;
        background: #f7f7f7;
        cursor: pointer;
        &:hover {
            background: #f3f3f3;
        }
    }
    #gamecard {
        border: 1px solid #e6e6e6;
        min-height: 300px;
        .gamecard-header {
            font-weight: 600;
            background: #e9e2cb;
            min-height: 48px;
        }
    }
</style>