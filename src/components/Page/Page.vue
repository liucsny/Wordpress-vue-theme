<template>
  <div class="">
    <video ref="player" v-if="hasVideo" autoplay loop class="bg-video" :src="bgVideoURL"></video>
    <div v-else :style="{ backgroundImage: 'url(' + bgImgURL + ')' }" class="bg-img"></div>
    <div class="block"></div>
    <div v-if="allPagesLoaded" class="relative page-container">
      <div class="page-title">{{ pageContent.title.rendered }}</div>
      <div v-html="pageContent.content.rendered"></div>
    </div>
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
      allPagesLoaded: 'allPagesLoaded',
      audioIsPlaying: 'audioIsPlaying',
    }),

    pageContent() {
      return this.page(this.$route.params.pageSlug)
    },
  },
  components: {
    Loader
  },
  data(){
    return {
      bgImgURL: null,
      hasVideo: false,
      bgVideoURL: null,
    }
  },
  beforeMount(){
    this.checkHasVideo();
    this.getBgURL();
    // console.log(this.hasVideo)
  },
  mounted(){
    this.replayVideo();
    this.mutePlayer();
    this.playAudio();
  },
  methods: {
    playAudio(){
      // console.log(this.pageContent.metadata.audio[0]);
      let self = this;
      let audioPlayer = document.getElementById('audioPlayer')
      if(!!self.pageContent.metadata.audio[0]){
        self.setAudioURL(self.pageContent.metadata.audio[0])
        if(self.audioIsPlaying){
          audioPlayer.currentTime = 0;
          setTimeout(function () {
            audioPlayer.play();
            self.$store.commit('playTheAudio')
          }, 1000);
        }
      }else{
        // 如果进入没有音乐的页面不停止上一个页面的音乐，就把下面三段代码注释掉
        self.setAudioURL(null)
        audioPlayer.pause();
        self.$store.commit('pauseTheAudio')
      }
    },
    setAudioURL(url){
      this.$store.commit('setAudio',url);
    },
    mutePlayer(){
      let self = this;
      let timer = setInterval(()=>{
        // console.log(self.$refs.player)
        if(!!self.$refs.player){
          self.$refs.player.muted = 'muted';
          clearInterval(timer);
        }
      },100)
    },
    replayVideo(){
      if(this.hasVideo){
        let player = this.$refs.player;
        // console.log('Info')
        player.pause();
        setTimeout(()=>{
          player.play();
          // console.log('postTime')
        },1000)
      }
    },
    checkHasVideo(){
      if((!!this.pageContent.metadata)&&(!!this.pageContent.metadata.featured_video)){
        this.hasVideo = true;
        this.bgVideoURL = this.pageContent.metadata.featured_video[0];
      }else{
        this.hasVideo = false;
      }
    },
    getBgURL(){
      if(!this.hasVideo){
        let mediaId = this.pageContent.featured_media;
        axios.get(window.SETTINGS.API_BASE_PATH + 'media/' + mediaId)
            .then(response => {
              // 这里调整图片filesize大小
              this.bgImgURL = response.data.media_details.sizes.large.source_url;
        })
      }
    }
  }
}
</script>