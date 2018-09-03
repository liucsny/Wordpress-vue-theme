<template>
  <article class="bg-black">
    <div class="vh-100 bg-black dt w-100">
      <video ref="player" v-if="hasVideo" autoplay muted='true' loop class="bg-video" :src="bgVideoURL"></video>
      <div v-else-if='!showPlayer' :style="{ backgroundImage: 'url(' + bgImgURL + ')' }" class="bg-img"></div>
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
      post: null,
      bgImgURL: null,
      hasVideo: false,
      bgVideoURL: null,
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
      let player = this.$refs.player;
      player.pause();
      player.currentTime = '0'
      player.play();
      player.controls = true;
      player.muted = false;
    },
    closeShowPlayer(){
      this.showPlayer = false;
      let player = this.$refs.player;
      player.controls = false;
      player.muted = true;
    },
    replayVideo(){
      if(this.hasVideo){
        let player = this.$refs.player;
        // console.log(player)
        player.muted= true;
        player.pause();
        // player.play();
        setTimeout(()=>{
          player.play();
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

<style lang="scss">
</style>