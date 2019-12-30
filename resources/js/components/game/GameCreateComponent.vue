<template>
    <div class="container">
        <div class="row">

            <div id="searchContainer" class="col-sm-8 mx-auto">
                <h3 class="font-weight-bold">Start by selecting a course:</h3>
                <div id="search-input" class="input-text mb-0 mt-3">
                    <input id="course_name" 
                    placeholder="Search for a course..."
                    v-model="searchTerm"
                    @input="searchCourses"
                    type="text">
                    <img src="/images/magnifying-glass.svg" alt="magnification glass">
                </div>
                <div id="search-results">
                    <div v-for="course in courses" 
                            :key="course.id" 
                            class="result-row"
                            @click="setCourse(course.course_name, course.id)">
                        {{course.course_name}}
                    </div>
                </div>
            </div>

            <div class="col-sm-8 mx-auto">
                <h3 class="font-weight-bold">Next, select a teebox:</h3>
                <div v-if="teeboxes.length" class="select-teebox-prompt">
                    <span class="btn btn-sm btn-outline-secondary mr-2" v-for="teebox in teeboxes" :key="teebox">
                        {{teebox}}
                    </span>
                </div>
            </div>

            <!-- <div class="col-sm-12">
                <div id="gamecard" class="shadow-sm">
                    <div class="gamecard-header p-2">
                        <h3>{{selectedCourse.name}}</h3>
                    </div> 
                    <div class="gamecard-body p-2">
                        ...
                    </div>
                </div>
            </div> -->

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
                selectedCourse: {},
                teeboxes: []
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
                    
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    #searchContainer {
        min-height: 390px;
    }
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
    .result-row {
        padding: 5px 0;
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