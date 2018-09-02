<template>
  <div class="menu-container">
    <ul v-for="(categories, key) in list" :key="key" class="menu-ul">
      <div class="menu-category-name">{{categories.name}}</div>
      <router-link tag='li' class="link-button list f5 pl4 pv1" v-for="(post, key) in categories.content" :key="key" :to='"/site/" + post.id + "/" +post.slug'>{{post.title.rendered}}</router-link>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'menu',
  props:{
    list:{
      type: Array,
      default: ()=>[]
    }
  },
  // watch:{
  //   '$route' (to, from) {

  //   }
  // }
}
</script>
