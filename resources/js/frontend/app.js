
import '../bootstrap';
import '../plugins';
import Vue from 'vue';

import BootstrapVue from "bootstrap-vue"

Vue.use(BootstrapVue)
window.Vue = Vue;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('choose-cards', require('./components/chooseCards.vue').default);
Vue.component('level-vue', require('./components/Level.vue').default);
Vue.component('quiz-body', require('./components/Quiz/Body.vue').default);
Vue.component('quiz-questions', require('./components/Quiz/Questions.vue').default);
Vue.component('awards', require('./components/Awards.vue').default);



const app = new Vue({
    el: '#app',
});