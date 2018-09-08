<template>
  <article class="bg-black">
    <div class="vh-100 bg-black dt w-100">
      <video ref="player" v-if="hasVideo" autoplay muted='true' loop class="bg-video" :src="bgVideoURL"></video>
      <div v-else :style="{ backgroundImage: 'url(' + bgImgURL + ')' }" class="bg-img"></div>
      <div class="dtc tc v-mid home-img-container cover ph3 ph4-m ph5-l relative bg-black-40">
        <h1 class="f2 f-subheadline-l measure lh-title fw9">Drowning Pool Productions</h1>
        <div class="flex justify-center home-links">
          <div @click="onClickWatch" class="f6 fw6 ttu mr4 link-button">watch reel</div>
          <router-link to="info" tag='div' class="f6 fw6 ttu mr4 link-button">enter site</router-link>
        </div>
      </div>
    </div>
    <transition name="fade">
      <app-player @closePlayer='showPlayer = false' v-if="showPlayer" :iframe='videoIframe'></app-player>
    </transition>
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
      // newestPostURL: null,
      showPlayer: false,
      videoIframe: '',
    }
  },
  computed:{
    ...mapGetters({
      page: 'page',
      logo: 'logo',
      audioIsPlaying: 'audioIsPlaying'
      // allPagesLoaded: 'allPagesLoaded',
      // ecentPosts: 'recentPosts',
    }),
  },
  beforeMount(){
    this.getPost();
    this.checkHasVideo();
    this.getBgImgURL();
    // this.getNewestPost();
    this.getVideoIframe();
  },
  mounted(){
    this.replayVideo();
    this.setAudioURL();
    this.playAudio();
  },
  watch:{
  },
  methods:{
    onClickWatch(){
      this.showPlayer = true;
      document.getElementById('audioPlayer').pause();
    },
    setAudioURL(){
      this.$store.commit('setAudio',this.post.metadata.audio);
      // console.log('set')
    },
    playAudio(){
      let audioPlayer = document.getElementById('audioPlayer');
      console.log(this.audioIsPlaying)
      if(this.audioIsPlaying){
        audioPlayer.currentTime = 0;
        this.$store.commit('playTheAudio')
        // 必须在等待150ms后play()，否则报错： The play() request was interrupted by a new load request
        setTimeout(function () {
            audioPlayer.play();
        }, 1000);
      }
    },
    replayVideo(){
      if(this.hasVideo){
        let player = this.$refs.player;
        player.muted= true;
        player.pause();
        setTimeout(()=>{
          player.play();
        },1000)
      }
    },
    getNewestPost(){
      axios.get(window.SETTINGS.API_BASE_PATH + 'posts?per_page=1')
            .then(response=>{
              this.newestPostURL = response.data[0].id + '/' + response.data[0].slug
            })
            .catch(e => {
              console.log(e);
            })
    },
    checkHasVideo(){
      if((!!this.post.metadata)&&(!!this.post.metadata.featured_video)){
        this.hasVideo = true;
        this.bgVideoURL = this.post.metadata.featured_video[0];
      }else{
        this.hasVideo = false;
      }
    },
    getVideoIframe(){
      if((!!this.post.metadata)&&(!!this.post.metadata.video)){
        this.videoIframe = this.post.metadata.video[0];
      }
    },
    getPost(){
      this.post =  this.page('home');
    },
    getBgImgURL(){
      if(!this.hasVideo){
        let homeMediaId = this.post.featured_media;
        axios.get(window.SETTINGS.API_BASE_PATH + 'media/' + homeMediaId)
            .then(response => {
              // 这里调整图片filesize大小
              this.bgImgURL = response.data.media_details.sizes.large.source_url;
        })
      }
    },
  }
}
</script>

<style lang="scss">
// .home-links{
//   margin-top: -10vw;
// }

.home-img-container{
  // padding-top: 100vw;
}
.placeholder-div{
  width: 100px;
  height: 200px;
}
</style>