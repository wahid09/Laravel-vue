require('./bootstrap');
import Vue from 'vue';


Vue.component('customer-component', require('./components/CustomerComponent.vue').default);


const app = new Vue({
    el: '#app'
});
