require('./bootstrap');
require('./main');

import Vue from 'vue';
import VeeValidate from 'vee-validate';

import NavigationComponent from './components/NavigationComponent';
import LandingComponent from './components/landing/LandingComponent';
import DashboardComponent from './components/dashboard/DashboardComponent';
import ProfileComponent from './components/profile/ProfileComponent';
import CourseIndexComponent from './components/course/CourseIndexComponent';
import CourseCreateComponent from './components/course/CourseCreateComponent';

Vue.use(VeeValidate);
const app = new Vue({
    el: '#app',
    components: { 
        NavigationComponent,
        LandingComponent, 
        DashboardComponent,
        ProfileComponent,
        CourseIndexComponent,
        CourseCreateComponent
    }
});

