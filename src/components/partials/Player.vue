<template>
  <div class="player-container">
    <!-- <div class="player-close" @click='closePlayer'>x</div> -->
    <ion-icon class="player-close" @click='closePlayer' name="close"></ion-icon>
    <div class="player-inner-container">
      <video :src="videoURL" controls></video>
    </div>
  </div>
</template>

<script>
export default {
  props:{
    videoURL:{
      type: String,
      default: ''
    }
  },
  methods:{
    closePlayer(){
      this.$emit( 'closePlayer' )
    }
  }
}
</script>
