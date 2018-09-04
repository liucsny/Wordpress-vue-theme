<template>
  <div class="menu-container">
    <ul v-for="(categories, key) in list" :key="key" class="menu-ul">
      <div class="menu-category-name" @click="changeOpenMenu(categories.name)">{{categories.name}}</div>
      <!-- <div :class="{'menu-open': categories.name == openMenu, 'menu-close': categories.name !== openMenu}"> -->
      <div :ref="categories.name+'_subMenu'" class="sub-menu">
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
  // data(){
  //   return {
  //     openMenu: null
  //   }
  // },
  methods: {
    changeOpenMenu(name){
      // this.openMenu = name;
      // let subMenu = this.$refs[name+'_subMenu']

      
      for (let key in this.$refs) {
        if(key == (name+'_subMenu')){
          this.$refs[key][0].style.maxHeight = this.$refs[key][0].scrollHeight + "px";
        }else{
          this.$refs[key][0].style.maxHeight = null;
        }
      }

      // console.log(subMenu)
      // console.log(this.list)
    }
  }
}
</script>

<style lang="scss" scoped>
.router-link-active{
  text-decoration: underline;
}


.sub-menu{
  overflow: hidden;
  // opacity: 0;
  max-height: 0;
  transition: max-height .4s ease-in-out;
  // transition: opacity 1s ease;
}

</style>

