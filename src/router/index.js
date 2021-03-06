import Vue from 'vue'
import Router from 'vue-router'

// Components
import Home from '../components/Home.vue'
import Post from '../components/Post/Post.vue'
import Page from '../components/Page/Page.vue'
import Site from '../components/Site/Site.vue'

Vue.use(Router)

const router = new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/site',
      name: 'Site',
      component: Site,
      children:[
        {
          // Assuming you're using the default permalink structure for posts
          path: ':id/:postSlug',
          name: 'Post',
          component: Post
        },
        {
          path: '/:pageSlug',
          name: 'Page',
          component: Page
        }
      ]
    },
    // {
    //   // Assuming you're using the default permalink structure for posts
    //   path: '/:year/:month/:day/:postSlug',
    //   name: 'Post',
    //   component: Post
    // },
  ],
  mode: 'history',
  base: '',

  // Prevents window from scrolling back to top
  // when navigating between components/views
  scrollBehavior (to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { x: 0, y: 0 }
    }
  }
})

export default router
