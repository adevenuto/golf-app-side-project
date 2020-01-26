<template>
    
    <transition name="fade">
        <a href="#" v-if="isFavorited" @click.prevent="unFavorite()">
            <img width="18" height="16" src="/images/heart_full.svg" alt="heart full">
        </a>
        <a href="#" v-else @click.prevent="favorite()">
            <img width="18" height="16" src="/images/heart_outline_transparent.svg" alt="heart full">
        </a>
    </transition>
    
</template>

<script>
    export default {
        props: ['course_id', 'favorited'],
        data: function() {
            return {
                isFavorited: '',
                courseId: this.course_id
            }
        },
        mounted() {
            this.isFavorited = this.isFavorite ? true : false;
        },
        computed: {
            isFavorite() {
                return this.favorited;
            },
        },
        methods: {
            favorite() {
                this.isFavorited = true
                axios.post('/course/favorite/'+this.courseId)
                    .then(response => this.isFavorited = true)
                    .catch(response => console.log(response.data));
            },
            unFavorite() {
                this.isFavorited = false
                axios.post('/course/unfavorite/'+this.courseId)
                    .then(response => this.isFavorited = false)
                    .catch(response => console.log(response.data));
            }
        }
    }
</script>