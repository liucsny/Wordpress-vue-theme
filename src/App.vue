<template>
  <div id="my-app" class="page-wrapper">
    <!-- Loader -->
    <transition name="loader-animation" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
      <div class="progress loader" v-if="showLoader">
        <div class="progress-bar" role="progressbar" :style="loaderStyle" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
    </transition>

    <transition name="page-transition" mode="out-in" appear>
      <div class="page-content-wrapper">
        <router-view></router-view>
      </div>
    </transition>
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
</style>
