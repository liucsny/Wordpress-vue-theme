<template>
  <div id="my-app" class="yellow">
    <!-- Loader -->
    <audio :src="audio" id="audioPlayer" loop></audio>
    <transition name="loader-animation" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
      <div class="progress loader" v-if="showLoader">
        <div class="progress-bar" role="progressbar" :style="loaderStyle" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
    </transition>
    <router-view v-if="!showLoader"/>
    <div class="bg-video flex justify-center items-center" v-else>
      <div class="ttu f1">Loading...</div>
    </div>
    <div id="audio-control">
      <ion-icon id="audio-control-icon" :name="audioIcon" @click='toggleAudio'></ion-icon>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex'

export default {
  data() {
    return {
      showLoader: true,
      audioIcon: 'pause'
    }
  },
  computed: {
    ...mapGetters({
      isLoading: 'isLoading',
      loadingProgress: 'loadingProgress',
      audio: 'audio',
    }),
    loaderStyle() {
      return `width: ${this.loadingProgress}%;`
    },
  },
  watch: {
    // watch the value of isLoading and once it's false hide the loader
    isLoading(val) {
      if (val == false) {
        let self = this
        setTimeout(function(){
          self.showLoader = false
          // let audioPlayer = document.getElementById('audioPlayer');
          // audioPlayer.play();
        }, 1000)
      }
    },
    '$route'(from, to){
      // console.log(to)
    }
  },
  methods:{
    toggleAudio(){
      let audioPlayer = document.getElementById('audioPlayer');
      if(audioPlayer.paused){
        audioPlayer.play();
        this.audioIcon = 'pause'
      }else{
        audioPlayer.pause();
        this.audioIcon = 'play'
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

body{
  overflow: hidden;
}

.bg-img{
  @include bg-img;
}

.fade-enter-active {
  transition: opacity 1s cubic-bezier(1,0,.8,1);
}
.fade-enter {
  opacity: 0;
}

#audio-control{
  position: absolute;
  bottom: 1.2rem;
  right: 2rem;
  @extend .pointer;
  @extend .dim;
}
</style>
