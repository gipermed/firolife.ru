// noinspection JSUnresolvedFunction,JSUnresolvedVariable

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';

require('./bootstrap');

window.Vue = Vue;
window.VueEventBus = new Vue();

window.TEMPLATE_PATH = '/local/templates/main';
window.IMG_PATH = `${TEMPLATE_PATH}/assets/img`;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.createVueComponents = () => $('.js-vue-app').each((index, element) => {
    if (element.__vue__ === undefined) {
        new Vue({el: element});
    }
});

$(() => createVueComponents());

// const app = new window.Vue({el: '#app'});

