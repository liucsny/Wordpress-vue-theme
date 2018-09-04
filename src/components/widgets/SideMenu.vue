<template>
  <div class="menu-container">
    <ul v-for="(categories, key) in list" :key="key" class="menu-ul">
      <div class="menu-category-name" @click="changeOpenMenu(categories.name)">{{categories.name}}</div>
      <div :class="{'menu-open': categories.name == openMenu, 'menu-close': categories.name !== openMenu}">
        <router-link tag='li' class="link-button list f5 pl4 pv1" v-for="(post, key) in categories.content" :key="key" :to='"/site/" + post.id + "/" +post.slug'>{{post.title.rendered}}</router-link>
      </div>
    </ul>
    <router-link tag='li' class="menu-category-name pl4" to='/info'>Info</router-link>
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
  data(){
    return {
      openMenu: null
    }
  },
  methods: {
    changeOpenMenu(name){
      this.openMenu = name;
      // console.log(this.list)
    }
  }
}
</script>

<style lang="scss" scoped>
.router-link-active{
  text-decoration: underline;
}


.menu-close{
  overflow: hidden;
  // opacity: 0;
  max-height: 0;
  transition: max-height 1s ease;
  // transition: opacity 1s ease;
}

.menu-open{
  max-height: 1000px;
  // opacity: 1;
  transition: max-height 1s ease;
  // transition: opacity 1s ease;
}
</style>

