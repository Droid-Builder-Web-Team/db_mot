/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from 'vue'
require('./bootstrap');
import ReactionComponent from './components/ReactionComponent.vue';
import VueGoogleMaps from 'vue-google-maps-community-fork';
import MapComponent from './components/MapComponent.vue';
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';

const app = createApp({});

app.component('reaction-component', ReactionComponent);
app.component('map-component', MapComponent);
app.component('EasyDataTable', Vue3EasyDataTable);
app.use(
    VueGoogleMaps, {
        load: {
            key: 'AIzaSyCOE-y6rIHLsG6ONcNib1pfv0eq3xTWRok',
        }
    }
).mount('#app');
