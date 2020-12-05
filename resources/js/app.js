require('./bootstrap');

window.Vue = require('vue');

// Register Views
import VueCategories from './vue/views/shop/Categories.vue';

const appVue = new Vue({
  el: '#app',
  components: {
    'shop-main-view': VueCategories
  }
})