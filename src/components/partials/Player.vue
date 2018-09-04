<template>
  <div class="player-container">
    <!-- <div class="player-close" @click='closePlayer'>x</div> -->
    <ion-icon class="player-close" @click='closePlayer' name="close"></ion-icon>
      <div class="player-inner-container" v-html="iframe"></div>
  </div>
</template>

<script>
export default {
  props:{
    iframe:{
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