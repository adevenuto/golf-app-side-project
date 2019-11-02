require('./bootstrap');
require('./main');

import Vue from 'vue';
import Vuex from 'vuex';
import vuexStore from './vuexStore/store';

import NavigationComponent from './components/NavigationComponent';
import DashboardComponent from './components/DashboardComponent';

Vue.use(Vuex);

const store = new Vuex.Store(vuexStore);
const app = new Vue({
    el: '#app',
    store,
    components: { 
        NavigationComponent, 
        DashboardComponent 
    }
});

