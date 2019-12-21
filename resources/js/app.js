require('./bootstrap');
require('./main');

import Vue from 'vue';
import VeeValidate from 'vee-validate';

import NavigationComponent from './components/NavigationComponent';
import LandingComponent from './components/landing/LandingComponent';
import DashboardComponent from './components/dashboard/DashboardComponent';
import ProfileComponent from './components/profile/ProfileComponent';
import CourseCreateComponent from './components/course/CourseCreateComponent';
import FavoriteComponent from './components/course/FavoriteComponent.vue';

Vue.use(VeeValidate);

Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
        title: binding.value,
        placement: binding.arg,
        trigger: 'focus'             
    })
})

const app = new Vue({
    el: '#app',
    components: { 
        NavigationComponent,
        LandingComponent, 
        DashboardComponent,
        ProfileComponent,
        CourseCreateComponent,
        FavoriteComponent
    }
});

