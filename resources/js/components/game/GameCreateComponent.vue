<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h4>Start by selecting a course:</h4>
                <div id="search-input" class="input-text mb-0">
                    <input id="course_name" 
                    placeholder="Search for a course..."
                    v-model="searchTerm"
                    @input="searchCourses"
                    type="text">
                    <img src="/images/magnifying-glass.svg" alt="magnification glass">
                </div>
                <div id="search-results">
                    <div v-for="course in courses" :key="course.id" class="result-row">
                        {{course.course_name}}
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
                noResults: false
            }
        },
        methods: {
            searchCourses: _.debounce(function() {
                axios.get(`/courses/search?term=${this.searchTerm}`)
                .then( payload => {
                    this.noResults = false;
                    this.courses = payload.data.courses;
                })
                .catch( err => {
                    this.noResults = true;
                    this.courses = [];
                });
            }, 200)
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
    .result-row {
        padding: 5px 0;
        border-bottom: 1px solid #e6e6e6;
        background: #f7f7f7;
        cursor: pointer;
        &:hover {
            background: #f3f3f3;
        }
    }
</style>