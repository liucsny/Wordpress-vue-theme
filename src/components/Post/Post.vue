<template>
  <div class="">
    <video ref="player_bg" v-show="hasVideo" autoplay muted loop class="bg-video" :src="bgVideoURL"></video>
    <div class="bg-video bg-black-20"></div>
    <video ref="player_video" v-show="showPlayer" muted class="bg-video z-999" :src="videoURL"></video>
    <div v-if='!hasVideo && !showPlayer' :style="{ backgroundImage: 'url(' + bgImgURL + ')' }" class="bg-img"></div>
    <ion-icon v-if='showPlayer' class="player-close" :class="{'close-icon-show':showCloseIcon, 'close-icon-hide':!showCloseIcon}" @click='closeShowPlayer' name="close"></ion-icon>
    <div v-if="!showPlayer" class="relative page-container pb6">
      <div class="page-title">{{ post.title.rendered }}</div>
      <div v-html="post.content.rendered"></div>
      <div v-if=' videoURL !== "" ' @click="openShowPlayer" class="link-button ttu f3 pt4">Watch Video</div>
    </div>
    <Loader v-else />
  </div>
</template>

<script>
import Loader from '../partials/Loader.vue';
import { mapGetters } from 'vuex';

export default {
  components: {Loader},
  data() {
    return {
      // showCloseIcon: true,
      post: null,
      bgImgURL: null,
      hasVideo: false,
      bgVideoURL: null,
      showPlayer: false,
      videoURL: ''
    }
  },
  computed: {
  },

  beforeMount() {
    this.getPost();
    // this.getBgImgURL();
  },
  mounted(){
    // let self = this;
    // this.replayVideo();
    // document.addEventListener('mousemove',function showIcon(){
    //   self.showCloseIcon = true;
    // })

    // setTimeout(()=>{
    //   self.showCloseIcon = false;
    // }, 3000);
  },
  methods: {
    openShowPlayer(){
      this.showPlayer = true;
      let player_bg = this.$refs.player_bg;
      let player_video = this.$refs.player_video;
      // this.videoSrc = this.videoURL;
      // player.pause();
      // player.currentTime = '0';
      player_video.muted = false;
      player_video.controls = true;
      player_video.play();
    },
    closeShowPlayer(){
      this.showPlayer = false;

      let player_bg = this.$refs.player_bg;
      let player_video = this.$refs.player_video;

      player_video.pause();
      player_video.currentTime = '0';
      player_bg.muted = "muted";
    },
    replayVideo(){
      if(this.hasVideo){
        let player_bg = this.$refs.player_bg;
        // console.log(player)
        player_bg.muted = 'muted';
        player_bg.pause();
        setTimeout(()=>{
          player_bg.play();
          // console.log('postTime')
        },1000)
      }
    },
    getPost: function() {
      axios.get(window.SETTINGS.API_BASE_PATH + 'posts?slug=' + this.$route.params.postSlug)
      .then(response => {
        this.post = response.data[0];
        this.checkHasVideo();
        this.getvideoURL()
        this.getBgImgURL();
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
    getvideoURL(){
      if((!!this.post.metadata)&&(!!this.post.metadata.video)){
        // console.log(this.post.metadata)
        this.videoURL = this.post.metadata.video[0];
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
      this.videoURL=''
      this.getPost();
      this.replayVideo();
      // console.log(this.$route.params)
      // react to route changes...
    }
  }
}
</script>