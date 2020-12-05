require('./bootstrap');

window.Vue = require('vue');

// Register Views
Vue.component('shop-main-view', () => import('./vue/views/shop/Categories.vue'));

const appVue = new Vue({
  el: '#app'
})