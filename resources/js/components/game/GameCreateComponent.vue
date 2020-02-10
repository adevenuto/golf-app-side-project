<template>
    <div class="container mx-auto">
        <div class="flex flex-col mx-auto    w-11/12 sm:w-8/12 lg:w-6/12 xl:w-5/12">
            <div class="flex h-70">
                <div class="mr-4 mt-2">
                    <img v-if="!selectedCourse" 
                            src="/images/step-one.svg" 
                            width="50px" 
                            height="50px" 
                            alt="step icon">
                    <img v-else 
                            src="/images/step-complete.svg" 
                            width="50px" 
                            height="50px" 
                            alt="step icon">
                </div>
                <div class="flex-1 relative">
                    <h3 class="font-bold text-xl">Start by selecting a course:</h3>
                    <div class="relative">
                        <input class="border border-gray-500 px-3 font-bold text-base w-full h-10 rounded   outline-none focus:outline-none focus:border-blue-800    pl-12 mt-2" 
                                placeholder="Search for a course..."
                                v-model="searchTerm"
                                @input="searchCourses"
                                type="text">
                        <img src="/images/magnifying-glass.svg" 
                                class="absolute w-6 h-6 top-0 mt-4 ml-2"
                                alt="magnification glass">
                    </div>
                    <div class="">
                        <div v-for="course in courses" 
                                :key="course.id" 
                                class="px-3 hover:bg-gray-200 border-b-2 border-gray-300 cursor-pointer"
                                @click="setCourse(course)">
                            {{course.course_name}}
                        </div>
                    </div>
                </div>
            </div>
            <div :class="[{'opacity-25': !selectedCourse},'flex h-70']">
                <div class="mr-4 mt-2">
                    <img v-if="!teebox" 
                            src="/images/step-two.svg" 
                            width="50px" 
                            height="50px" 
                            alt="step icon">
                    <img v-else 
                            src="/images/step-complete.svg" 
                            width="50px" 
                            height="50px" 
                            alt="step icon">
                </div>
                <div class="flex-1">
                    
                    <h3 class="font-bold text-xl">Select a teebox:</h3>
                    <div v-if="teeboxes.length" class="mt-2">
                        <button v-for="_teebox in teeboxes" 
                                :class="[{'bg-green-800 text-white': _teebox == teebox}, 'hover:bg-gray-100 border b-green-800 rounded py-1 px-3 mr-3 cursor-pointer capitalize']"  
                                :key="_teebox"
                                @click="setTeebox(_teebox)">
                                {{_teebox}}
                        </button>
                    </div>
                    
                </div>
            </div>
            <div :class="[{'opacity-25': !holegroup_holes.length},'flex']">
                <div class="mr-4 mt-2">
                    <img v-if="!holegroupsSelected.length" 
                            src="/images/step-three.svg" 
                            width="50px" 
                            height="50px" 
                            alt="step icon">
                    <img v-else 
                            src="/images/step-complete.svg" 
                            width="50px" 
                            height="50px" 
                            alt="step icon">
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-xl">Select holes to play:</h3>
                    <template v-if="holegroup_holes.length">
                        <div v-for="group in holegroup_holes" 
                            :class="[{'bg-green-800 text-white': group.selected}, 'flex flex-col mb-2 py-1 px-3 border rounded cursor-pointer capitalize']" 
                            :key="group.id"
                            @click="setHolegroups(group)">
                            
                            <span v-if="group.holegroup.group_name">
                                Name: 
                                <span class="">{{ group.holegroup.group_name }}</span>
                            </span>
                            <span>Holes: <span class="">{{ group.holes.length }}</span></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>


        <template v-if="gameReady">
            <div class="text-center mx-auto w-64">
                <button @click="startGame"
                        class="mt-24 w-64 mx-auto p-6 rounded font-bold text-3xl border-2 border-green-800 text-green-800 hover:bg-green-800 hover:text-white">
                    Go play Golf
                </button>
            </div>
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
