<template>
  <div class="">
    <video ref="player" v-if="hasVideo" autoplay loop class="bg-video">
      <source :src="bgVideoURL" type="video/mp4">
    </video>
    <div v-else :style="{ backgroundImage: 'url(' + bgImgURL + ')' }" class="bg-img"></div>
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
      allPagesLoaded: 'allPagesLoaded'
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
  },
  methods: {
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
        // console.log(this.pageContent)
        // this.bgImgURL = 
        let mediaId = this.pageContent.featured_media;
        axios.get(window.SETTINGS.API_BASE_PATH + 'media/' + mediaId)
            .then(response => {
            // 这里调整图片filesize大小
            //   console.log(response.data.media_details.sizes.medium.source_url)
              this.bgImgURL = response.data.media_details.sizes.large.source_url;
              // console.log(this.hasVideo)
        })
      }
    }
  }
}
</script>