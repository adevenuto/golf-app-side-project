<template>
    <div class="container">
        <div class="row">
            <div v-for="course in golfCourses" :key="course.id" class="col-sm-12 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm">
                    <img class="card-img-top" :src="`https://teetyme-app.s3.us-east-2.amazonaws.com/${course.featured_image}`" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{course.course_name}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['courses'],
        data() {
            return {

            }
        },
        computed: {
            golfCourses: function() {
                return  this.courses ? JSON.parse(this.courses) : null;
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>