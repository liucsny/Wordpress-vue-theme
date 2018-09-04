<template>
  <div id="my-app" class="yellow">
    <!-- Loader -->
    <transition name="loader-animation" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
      <div class="progress loader" v-if="showLoader">
        <div class="progress-bar" role="progressbar" :style="loaderStyle" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
    </transition>
    <router-view/>
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
@import url("https://use.typekit.net/vol3eny.css");

*{
  font-family: adrianna-condensed, sans-serif !important;
  font-style: italic;
  font-weight: 800;
}

*::-webkit-scrollbar-track
{
	-webkit-box-shadow: none !important;
	background-color: transparent !important;
}
 *::-webkit-scrollbar
{
	width: 0 !important;
	background-color: transparent !important;
}
 *::-webkit-scrollbar-thumb
{
	-webkit-box-shadow: none !important;
	background-color: transparent !important;
}

html{
  @extend .bg-black;
}

.bg-img{
  @include bg-img;
}
</style>
