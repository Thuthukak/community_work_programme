
import Vue from 'vue';
import Sidebar from './components/Sidebar.vue';
import Projects from './components/Projects.vue';

Vue.component('sidebar', Sidebar);
Vue.component('projects', Projects);

const app = new Vue({
    el: '#app',
});

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
