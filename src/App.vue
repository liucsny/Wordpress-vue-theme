<template>
  <div id="my-app" class="yellow">
    <!-- Loader -->
    <transition name="loader-animation" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
      <div class="progress loader" v-if="showLoader">
        <div class="progress-bar" role="progressbar" :style="loaderStyle" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
    </transition>

    <article>
      <header class="vh-100 bg-black dt w-100">
        <div class="dtc v-mid cover ph3 ph4-m ph5-l bg-img">
          <h1 class="f2 f-subheadline-l measure lh-title fw9">Drowning Pool Productions</h1>
          <div class="flex ">
            <div class="f6 fw6 ttu mr4 link-button">watch reel</div>
            <div class="f6 fw6 ttu mr4 link-button">enter site</div>
          </div>
        </div>
      </header>
    </article>
  </div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex'

export default {
  data() {
    return {
      showLoader: true
    }
  },
  computed: {
    ...mapGetters({
      isLoading: 'isLoading',
      loadingProgress: 'loadingProgress'
    }),

    loaderStyle() {
      return `width: ${this.loadingProgress}%;`
    }
  },

  watch: {
    // watch the value of isLoading and once it's false hide the loader
    isLoading(val) {
      if (val == false) {
        let self = this
        setTimeout(function(){
          self.showLoader = false
        }, 1000)
      }
    }
  }
}
</script>
<style lang="scss">
@import './styles/app.scss';

.bg-img{
  @include bg-img('https://drowningpool.tv/wp-content/uploads/2018/08/head2.jpg');
}
</style>
