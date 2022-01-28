/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from 'vue'
require('./bootstrap');
import ReactionComponent from './components/ReactionComponent.vue';
import VueGoogleMaps from '@fawmi/vue-google-maps'
import MapComponent from './components/MapComponent.vue'

const app = createApp({});

app.component('reaction-component', ReactionComponent);
app.component('map-component', MapComponent);
app.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyCOE-y6rIHLsG6ONcNib1pfv0eq3xTWRok',
    }
}).mount('#app');

(function($) {

	"use strict";

	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	$('#sidebarCollapse').on('click', function () {
      $('#sidebar').toggleClass('active');
  });

})(jQuery);
