<template>
  <div class="player-container">
    <ion-icon class="player-close" @click='closePlayer' name="close"></ion-icon>
      <div class="player-inner-container" v-html="iframe"></div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  props:{
    iframe:{
      type: String,
      default: ''
    }
  },
  computed:{
    ...mapGetters({
      audioIsPlaying: 'audioIsPlaying'
    }),
  },
  methods:{
    closePlayer(){
      this.$emit('closePlayer')
      if(this.audioIsPlaying){
        document.getElementById('audioPlayer').play();
      }
    }
  }
}
</script>