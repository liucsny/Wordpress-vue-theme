<template>
  <div class="">
    <video id="postPlayer" ref="player" v-if="hasVideo" muted autoplay loop class="bg-video" :src="bgVideoURL"></video>
    <div v-else :style="{ backgroundImage: 'url(' + bgImgURL + ')' }" class="bg-img"></div>
    <div class="block"></div>
    <div v-if="post" class="relative page-container pb6">
      <div class="page-title">{{ post.title.rendered }}</div>
      <div v-html="post.content.rendered"></div>
      <div v-if=' videoIframe !== "" ' @click="showPlayer=true" class="link-button ttu f3 pt4">Watch Video</div>
    </div>
    <Loader v-else />
    <transition name="fade">
      <app-player @closePlayer='showPlayer = false' v-if="showPlayer" :iframe='videoIframe'></app-player>
    </transition>
  </div>
</template>

<script>
import Loader from '../partials/Loader.vue';
import appPlayer from '../partials/Player.vue';
import { mapGetters } from 'vuex';

export default {
  components: {appPlayer, Loader},
  data() {
    return {
      post: null,
      bgImgURL: null,
      hasVideo: false,
      bgVideoURL: null,
      showPlayer: false,
      videoIframe: ''
    }
  },
  computed: {
  },

  beforeMount() {
    this.getPost();
    // this.getBgImgURL();
  },
  mounted(){
    this.replayVideo();
    this.mutePlayer();
  },
  methods: {
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
        // console.log(player)
        player.muted= true;
        player.pause();
        setTimeout(()=>{
          player.play();
          // console.log('postTime')
        },1000)
      }
    },
    getPost: function() {
      axios.get(window.SETTINGS.API_BASE_PATH + 'posts?slug=' + this.$route.params.postSlug)
      .then(response => {
        this.post = response.data[0];
        this.checkHasVideo();
        this.getVideoIframe()
        this.getBgImgURL();
        // console.log(!!response.data[0].metadata.audio)
        if(!!response.data[0].metadata.audio){
          let audioPlayer = document.getElementById('audioPlayer')
          // console.log(audioPlayer)
          audioPlayer.currentTime = 0;
          // audioPlayer.play();
          // 必须在等待150ms后play()，否则报错： The play() request was interrupted by a new load request
          setTimeout(function () {
            audioPlayer.play();
          }, 1000);
          this.setAudioURL(response.data[0].metadata.audio)
        }else{
          audioPlayer.pause();
          this.setAudioURL(null)
        }
      })
      .catch(e => {
        console.log(e);
      })
    },
    checkHasVideo(){
      // console.log(this.post)
      if((!!this.post.metadata)&&(!!this.post.metadata.featured_video)){
        this.hasVideo = true;
        this.bgVideoURL = this.post.metadata.featured_video[0];
      }else{
        this.hasVideo = false;
      }
    },
    getVideoIframe(){
      if((!!this.post.metadata)&&(!!this.post.metadata.video)){
        // console.log(this.post.metadata)
        this.videoIframe = this.post.metadata.video[0];
      }
    },
    getBgImgURL(){
      if(!this.hasVideo){
        let homeMediaId = this.post.featured_media;
        axios.get(window.SETTINGS.API_BASE_PATH + 'media/' + homeMediaId)
            .then(response => {
            // 这里调整图片filesize大小
            //   console.log(response.data.media_details.sizes.medium.source_url)
              this.bgImgURL = response.data.media_details.sizes.large.source_url;
              // console.log(this.hasVideo)
        })
      }
    },
  },
  watch: {
    '$route' (to, from) {
      this.getPost();
      this.replayVideo();
      this.videoIframe=''
      this.mutePlayer();
    },
    showPlayer(from,to){
      let audioPlayer = document.getElementById('audioPlayer');
      // console.log(to)
      if(!to){
        audioPlayer.pause();
      }else{
        audioPlayer.currentTime = 0;
        audioPlayer.play();
      }
    }
  }
}
</script>