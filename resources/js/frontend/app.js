
import '../bootstrap';
import '../plugins';
import Vue from 'vue';
import Form from '../Form'
window.Form = Form

import BootstrapVue from "bootstrap-vue"

Vue.use(BootstrapVue)
window.Vue = Vue;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('choose-cards', require('./components/chooseCards.vue').default);
Vue.component('level-vue', require('./components/Level.vue').default);
Vue.component('quiz-body', require('./components/Quiz/Body.vue').default);
Vue.component('quiz-questions', require('./components/Quiz/Questions.vue').default);
Vue.component('awards', require('./components/Awards.vue').default);
Vue.component('awards-new', require('./components/AwardsNew.vue').default);
Vue.component('quiz-header', require('./components/Quiz/Header.vue').default);

Vue.prototype.$userId = document.querySelector("meta[name='user_id']").getAttribute('content');


const app = new Vue({
    el: '#app',
});