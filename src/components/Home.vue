<template>
  <article class="bg-black">
    <div class="vh-100 bg-black dt w-100">
      <video ref="player_video" v-show="showPlayer" muted class="bg-video" :src="videoURL"></video>
      <video ref="player_bg" v-show="hasVideo && !showPlayer" muted autoplay loop class="bg-video" :src="bgVideoURL"></video>
      <div v-if='!hasVideo || !showPlayer' :style="{ backgroundImage: 'url(' + bgImgURL + ')' }" class="bg-img"></div>
      <ion-icon v-if='showPlayer' class="player-close" :class="{'close-icon-show':showCloseIcon, 'close-icon-hide':showCloseIcon}" @click='closeShowPlayer' name="close"></ion-icon>
      <div v-if='!showPlayer' class="dtc tc v-mid cover ph3 ph4-m ph5-l relative bg-black-40">
        <h1 class="f2 f-subheadline-l measure lh-title fw9">Drowning Pool Productions</h1>
        <div class="flex justify-center">
          <div @click="openShowPlayer" class="f6 fw6 ttu mr4 link-button">watch reel</div>
          <router-link :to="'site/' + newestPostURL" tag='div' class="f6 fw6 ttu mr4 link-button">enter site</router-link>
        </div>
      </div>
    </div>
  </article>
</template>

<script>
// import appPlayer from './partials/Player.vue';
import { mapGetters } from 'vuex';

export default {
  // components: {appPlayer},
  data(){
    return {
      showCloseIcon: true,
      post: null,
      bgImgURL: null,
      hasVideo: false,
      bgVideoURL: null,
      // videoSrc: null,
      newestPostURL: null,
      showPlayer: false,
      videoURL: ''
    }
  },
  computed:{
    ...mapGetters({
      page: 'page',
      // allPagesLoaded: 'allPagesLoaded',
      // ecentPosts: 'recentPosts',
    }),
  },
  beforeMount(){
    this.getPost();
    this.checkHasVideo();
    this.getBgImgURL();
    this.getNewestPost();
    this.getVideoURL();
  },
  mounted(){
    this.replayVideo();
    // let player = document.getElementById('player');
    // console.log(player)
    // console.log('mounted');
  },
  methods:{
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
        player_bg.muted= "muted";
        player_bg.pause();
        // player.play();
        setTimeout(()=>{
          player_bg.play();
          // console.log('time')
        },1000)
      }
    },
    getNewestPost(){
      axios.get(window.SETTINGS.API_BASE_PATH + 'posts?per_page=1')
            .then(response=>{
              // console.log(response.data[0])
              this.newestPostURL = response.data[0].id + '/' + response.data[0].slug
            })
            .catch(e => {
              console.log(e);
            })
    },
    checkHasVideo(){
      // let suffix = this.bgImgURL.substring(this.bgImgURL.indexOf(".")+1);
      // this.isImg = (suffix == 'png')||(suffix == 'jpg')||(suffix == 'jpeg')||(suffix == 'gif')||(suffix == 'bmp');
      if((!!this.post.metadata)&&(!!this.post.metadata.featured_video)){
        this.hasVideo = true;
        this.bgVideoURL = this.post.metadata.featured_video[0];
        // this.videoSrc = this.bgVideoURL;
      }else{
        this.hasVideo = false;
      }
    },
    getVideoURL(){
      if((!!this.post.metadata)&&(!!this.post.metadata.video)){
        // console.log(this.post.metadata)
        this.videoURL = this.post.metadata.video[0];
      }
    },
    getPost(){
      this.post =  this.page('home');
    },
    getBgImgURL(){

      // console.log(this.post.metadata.featured_video[0])


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
  }
}
</script>

<style lang="scss" scoped>
</style>