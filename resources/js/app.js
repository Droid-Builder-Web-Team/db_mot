/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from 'vue'
require('./bootstrap');
import ReactionComponent from './components/ReactionComponent.vue';
const app = createApp({});

app.component('reaction-component', ReactionComponent);
app.mount('#app');
