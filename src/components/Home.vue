<template>
  <article class="bg-black">
    <div class="vh-100 bg-black dt w-100">
      <video ref="player" v-if="hasVideo" autoplay muted='true' loop class="bg-video" :src="bgVideoURL"></video>
      <div v-else :style="{ backgroundImage: 'url(' + bgImgURL + ')' }" class="bg-img"></div>
      <div class="dtc tc v-mid cover ph3 ph4-m ph5-l relative bg-black-40">
        <h1 class="f2 f-subheadline-l measure lh-title fw9">Drowning Pool Productions</h1>
        <div class="flex justify-center">
          <div @click="showPlayer = true" class="f6 fw6 ttu mr4 link-button">watch reel</div>
          <router-link :to="'site/' + newestPostURL" tag='div' class="f6 fw6 ttu mr4 link-button">enter site</router-link>
        </div>
      </div>
    </div>
    <transition name="fade">
      <app-player @closePlayer='showPlayer = false' v-if="showPlayer" :iframe='videoIframe'></app-player>
    </transition>
    <!-- <iframe width="720" height="405" scrolling="no"  style="border: none;"  allowfullscreen src="https://gaiamount.com/insert?mid=24753"></iframe> -->
    <!-- <iframe width="100%" height="800px" scrolling="no"  style="border: none;"  allowfullscreen src="https://gaiamount.com/insert?wid=37997"></iframe> -->
  </article>
</template>

<script>
import appPlayer from './partials/Player.vue';
import { mapGetters } from 'vuex';

export default {
  components: {appPlayer},
  data(){
    return {
      // audioURL:null,
      post: null,
      bgImgURL: null,
      hasVideo: false,
      bgVideoURL: null,
      newestPostURL: null,
      showPlayer: false,
      videoIframe: ''
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
    this.getVideoIframe();
  },
  mounted(){
    this.replayVideo();
    this.setAudioURL();
    this.playAudio();
    // let player = document.getElementById('player');
    // console.log(player)
    // console.log('mounted');
  },
  watch:{
    showPlayer(from,to){
      let audioPlayer = document.getElementById('audioPlayer');
      if(!to){
        audioPlayer.pause();
      }else{
        audioPlayer.currentTime = 0;
        audioPlayer.play();
      }
    }
  },
  methods:{
    setAudioURL(){
      this.$store.commit('setAudio',this.post.metadata.audio);
      // console.log('set')
    },
    playAudio(){
      let audioPlayer = document.getElementById('audioPlayer');
      audioPlayer.currentTime = 0;
      // let playPromise = audioPlayer.play();
      // console.log(playPromise)
      // playPromise.then(d=>{
      //   console.log(d)
      // })
      // 必须在等待150ms后play()，否则报错： The play() request was interrupted by a new load request
      setTimeout(function () {
          audioPlayer.play();
      }, 150);
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
    getVideoIframe(){
      if((!!this.post.metadata)&&(!!this.post.metadata.video)){
        // console.log(this.post.metadata)
        this.videoIframe = this.post.metadata.video[0];
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