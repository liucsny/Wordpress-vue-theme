<template>
  <div class="">
    <video ref="player" v-if="hasVideo" autoplay loop class="bg-video">
      <source :src="bgVideoURL" type="video/mp4">
    </video>
    <div v-else :style="{ backgroundImage: 'url(' + bgImgURL + ')' }" class="bg-img"></div>
    <div v-if="post" class="relative page-container">
      <div class="page-title">{{ post.title.rendered }}</div>
      <div v-html="post.content.rendered"></div>
    </div>
    <Loader v-else />
  </div>
</template>

<script>
import Loader from '../partials/Loader.vue';
import { mapGetters } from 'vuex';

export default {
  data() {
    return {
      post: null,
      bgImgURL: null,
      hasVideo: false,
      bgVideoURL: null,
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
        this.getBgImgURL();
      })
      .catch(e => {
        console.log(e);
      })
    },
    checkHasVideo(){
      // let suffix = this.bgImgURL.substring(this.bgImgURL.indexOf(".")+1);
      // this.isImg = (suffix == 'png')||(suffix == 'jpg')||(suffix == 'jpeg')||(suffix == 'gif')||(suffix == 'bmp');
      // console.log(this.post)
      if((!!this.post.metadata)&&(!!this.post.metadata.featured_video)){
        this.hasVideo = true;
        this.bgVideoURL = this.post.metadata.featured_video[0];
      }else{
        this.hasVideo = false;
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
    }
  },

  components: {
    Loader
  },


  watch: {
    '$route' (to, from) {
      this.getPost();
      this.replayVideo();
      // console.log(this.$route.params)
      // react to route changes...
    }
  }
}
</script>