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
                        <div class="shadow-sm">
                            <div v-for="course in courses" 
                                    :key="course.id" 
                                    class="result-row"
                                    @click="setCourse(course)">
                                {{course.course_name}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div :class="[{'step-faded': !selectedCourse},'step-desc', 'col-sm-8', 'mx-auto']">
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
            <div :class="[{'step-faded': !teebox},'step-desc', 'col-sm-8', 'mx-auto']">
                <div class="d-flex align-items-center">
                    <div class="step-number align-self-start mr-3">
                        <img v-if="!holegroupsSelected.length" src="/images/step-three.svg" width="50px" height="50px" alt="step icon">
                        <img v-else src="/images/step-complete.svg" width="50px" height="50px" alt="step icon">
                    </div>
                    <div class="step-desc">
                        <h3 class="font-weight-bold">Select holes to play:</h3>
                        <div v-if="holegroup_holes.length">
                            <div v-for="group in holegroup_holes" 
                                :class="[{'activeHolegroup': group.selected}, 'card', 'holegroup-card', 'col-10', 'mb-2']" 
                                :key="group.id"
                                @click="setHolegroups(group)">
                                <!-- {{group}} -->
                                <span v-if="group.holegroup.group_name">
                                    Name: 
                                    <span class="text-secondary">{{ group.holegroup.group_name }}</span>
                                </span>
                                <span>Holes: <span class="text-secondary">{{ group.holes.length }}</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <template v-if="gameReady">
            <button @click="startGame">Start Game</button>
        </template>
        <template v-else>
            Game not ready
        </template>
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

                holegroup_holes: [],
                holegroupsSelected: []
            }
        },
        watch: {
            searchTerm: function(val) {
                if (!val) {
                    this.selectedCourse = null;
                    this.teebox = null;
                    this.teeboxes = [];
                    this.holegroup_holes = [];
                    this.holegroupsSelected = [];
                }
            }
        },
        computed: {
            gameReady: function() {
                return (this.selectedCourse && this.teebox && this.holegroupsSelected.length);
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
            setCourse: function(course) {
                this.selectedCourse = course;
                this.searchTerm = course.course_name;
                this.teeboxes = [];
                this.teebox = null;
                this.courses = [];
                this.holegroup_holes = [];
                this.holegroupsSelected = [];
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
                this.holegroup_holes = [];
                this.holegroupsSelected = [];
                this.getHolegroups();
            },
            getHolegroups: function() {
                let course_id = this.selectedCourse.id;
                let teebox = this.teebox;
                axios.get(`/course/${course_id}/holegroups/${teebox}`)
                .then( payload => {
                    let holegroup_holes_length = payload.data.holegroupWithHoles.length;
                    this.holegroup_holes = payload.data.holegroupWithHoles;
                    // If holegroup_holes_length == 1 automatically select it
                    if(holegroup_holes_length == 1) this.setHolegroups(payload.data.holegroupWithHoles[0]);
                })
                .catch( err => {
                    console.log(err);
                });
            },
            findSelectedHolegroup: function(group) {
                var result = false;
                this.holegroupsSelected.find((stored, index) => {
                    if ((stored) && (stored.holegroup.id == group.holegroup.id)) {
                        group['selected'] = false;
                        this.holegroupsSelected.splice(index, 1);
                        result = true;
                    } 
                })
                return result;
            },
            setHolegroups: function(group) {
                if (!this.findSelectedHolegroup(group)) {
                    if (this.holegroupsSelected.length == 2) return false;
                    group['selected'] = true;
                    this.holegroupsSelected.push(group);
                }
            },
            startGame: function() {
                let gameData = {
                    course: this.selectedCourse,
                    holeGroups: this.holegroupsSelected
                }
                axios.post('/game/store', gameData)
                .then( payload => {
                    let url = payload.data.url
                    window.location = url;
                })
                .catch( err => {
                    console.log(err);
                });
            }
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
        min-height: 160px;
        flex-grow: 1;
        width: 100%;
        &:last-child {
            height: 20px;
        }
        .card {
            background: transparent;
            &:hover {
                background: #fff;
            }
        }
    }
    .step-faded {
        opacity: .2;
        pointer-events: none;
    }
    .activeTeebox {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .step-desc .card.holegroup-card {
        cursor: pointer;
    }
    .step-desc .card.activeHolegroup {
        background-color: #f5f5f5;
        border-color: #499d47;
    }
    .result-row {
        padding: 3px 10px;
        border-bottom: 1px solid #e6e6e6;
        background: #f7f7f7;
        cursor: pointer;
        position: relative;
        z-index: 4500;
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