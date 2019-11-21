require('./bootstrap');
require('./main');

import Vue from 'vue';

import NavigationComponent from './components/NavigationComponent';
import LandingComponent from './components/landing/LandingComponent';
import DashboardComponent from './components/dashboard/DashboardComponent';
import ProfileComponent from './components/profile/ProfileComponent';

const app = new Vue({
    el: '#app',
    components: { 
        NavigationComponent,
        LandingComponent, 
        DashboardComponent,
        ProfileComponent
    }
});

