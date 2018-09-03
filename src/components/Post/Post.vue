<template>
  <div class="">
    <video ref="player" v-if="hasVideo" autoplay muted='true' loop class="bg-video" :src="bgVideoURL"></video>
    <div v-else :style="{ backgroundImage: 'url(' + bgImgURL + ')' }" class="bg-img"></div>
    <div v-if="post" class="relative page-container pb6">
      <div class="page-title">{{ post.title.rendered }}</div>
      <div v-html="post.content.rendered"></div>
      <div v-if=' videoIframe !== "" ' @click="showPlayer=true" class="link-button ttu f3 pt4">Watch Video</div>
    </div>
    <Loader v-else />
    <app-player @closePlayer='showPlayer = false' v-if="showPlayer" :iframe='videoIframe'></app-player>
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
  },
  methods: {
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
      // console.log(this.$route.params)
      // react to route changes...
    }
  }
}
</script>