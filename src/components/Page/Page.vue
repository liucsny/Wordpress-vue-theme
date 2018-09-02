<template>
  <div class="bv-example-row pt-4">
    <template v-if="allPagesLoaded">
      <h1>{{ pageContent.title.rendered }}</h1>
      <div v-html="pageContent.content.rendered"></div>
      <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea id, provident nobis debitis culpa, doloribus ducimus quisquam repudiandae quia laborum veniam, aliquam expedita. Reprehenderit voluptatibus, corrupti possimus at sint nostrum.</div>
    </template>
    <Loader v-else />
  </div>
</template>

<script>
import Loader from '../partials/Loader.vue';
import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters({
      page: 'page',
      allPagesLoaded: 'allPagesLoaded'
    }),

    pageContent() {
      return this.page(this.$route.params.pageSlug)
    }
  },

  components: {
    Loader
  }
}
</script>