<template>
  <div id="shop-categories-view">
    <h1>Categorías</h1>
    <ul v-for="(category, key) in categories" :key="key">
      <li>
        <h3>{{ category.title }}</h3>
        <ul v-for="(type, tKey) in category.types" :key="tKey">
          <li>{{ type.title }}</li>
        </ul>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'shop-categories-view',
  created(){
    axios.get('http://alibuya.net/api/public/shop/category').then(_resp=>{
      this.categories = _resp.data.DATA;
    })
  },
  data(){
    return {
      categories: [],
    }
  },
}
</script>

<style>

</style>