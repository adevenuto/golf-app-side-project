require('./bootstrap');
require('./nav-dropdown.js');
require('./tw-modal.js');

import Vue from 'vue';
import VeeValidate from 'vee-validate';

import NavigationComponent from './components/NavigationComponent';
import LandingComponent from './components/landing/LandingComponent';
import DashboardComponent from './components/dashboard/DashboardComponent';
import ProfileComponent from './components/profile/ProfileComponent';
import CourseCreateComponent from './components/course/CourseCreateComponent';
import CourseEditComponent from './components/course/CourseEditComponent';
import FavoriteComponent from './components/course/FavoriteComponent';
import GameCreateComponent from './components/game/GameCreateComponent';
import GameShowComponent from './components/game/GameShowComponent';


Vue.use(VeeValidate);

const app = new Vue({
    el: '#app',
    components: { 
        NavigationComponent,
        LandingComponent, 
        DashboardComponent,
        ProfileComponent,
        CourseCreateComponent,
        CourseEditComponent,
        FavoriteComponent,
        GameCreateComponent,
        GameShowComponent
    }
});



