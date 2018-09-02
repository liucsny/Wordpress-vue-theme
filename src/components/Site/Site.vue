<template>
  <div class="bg-black full">
    <div class="menu-side-bar">
      <router-link tag='div' to='/' class="pointer pl3 pt4 f2">Drowning Pool</router-link>
      <side-menu :list='menuList'></side-menu>
    </div>
    <router-view/>
  </div>
</template>

<script>
import sideMenu from '../widgets/SideMenu';
import { mapGetters } from 'vuex';

export default {
  components:{sideMenu},
  data(){
    return {
      limit: 100,
    }
  },
  computed:{
    ...mapGetters({
      allCategories: 'allCategories',
      allCategoriesLoaded: 'allCategoriesLoaded',
      recentPosts: 'recentPosts',
    }),
    getAllCategories:{
      get(){
        // console.log(this.allCategories.map(d=>{
        //   console.log(d)
        //   return d.name;
        // }).filter(d => d!==('未分类'||'Uncategorized')))
        return this.allCategories.slice(0)
                    .filter(d => d.name!==('未分类'||'Uncategorized'))
                    .sort((a,b)=>a.id>b.id)
                    .map(d=>{
                      return {
                        name: d.name,
                        id: d.id,
                      }
                    })
      }
    },
    menuList(){
      let list = this.getAllCategories.slice(0)
      list.forEach(d => {
        d.content = this.recentPosts(this.limit).slice(0)
                        .filter(e=>e.categories[0]==d.id)
      });
      return list;
    }
  },
  mounted() {
    this.$store.dispatch('getPosts', { limit: this.limit })
  },
}
</script>

