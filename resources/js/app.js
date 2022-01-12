/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from 'vue'
require('./bootstrap');
import ReactionComponent from './components/ReactionComponent.vue';
import VueGoogleMaps from '@fawmi/vue-google-maps'
import MembersMapComponent from './components/MembersMapComponent.vue'

const app = createApp({});

app.component('reaction-component', ReactionComponent);
app.component('members-map', MembersMapComponent);
app.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyCOE-y6rIHLsG6ONcNib1pfv0eq3xTWRok',
    }
}).mount('#app');
