<template>
    <slick
    ref="slick"
    :options="slickOptions"
    @afterChange="handleAfterChange"
    @beforeChange="handleBeforeChange"
    @swipe="handleSwipe">
       <video id="mvideo_1" class="slide-video slide-media" muted autoplay v-on:click="videoFnc" preload="metadata">
            <source v-if="env == 'local'" v-bind:src="jobjson.job_mov" type="video/mp4" />
            <source v-else v-bind:src="baseurl + jobjson.job_mov" type="video/mp4" />
        </video>
        <video id="mvideo_2" class="slide-video slide-media" muted v-on:click="videoFnc" preload="metadata">
            <source v-if="env == 'local'" v-bind:src="jobjson.job_mov2" type="video/mp4" />
            <source v-else v-bind:src="baseurl + jobjson.job_mov2" type="video/mp4" />
        </video>
        <video id="mvideo_3" class="slide-video slide-media" muted v-on:click="videoFnc" preload="metadata">
            <source v-if="env == 'local'" v-bind:src="jobjson.job_mov3" type="video/mp4" />
            <source v-else v-bind:src="baseurl + jobjson.job_mov3" type="video/mp4" />
        </video>
    </slick>
</template>
 
<script>
    // vue-slickをインポート
    import Slick from 'vue-slick';
    export default {
         // コンポーネント使用の宣言
        components: { Slick },
        // bladeから受け取るデータを指定
        props: {
            jobjson: {
                type: Object,
                required: true
            }
        },
    
        data() {
            return {
                // slickの設定
                slickOptions: {
                    speed:200,
                    arrows:false,
                    dots:true,
                    accessibility: true,
                    pauseOnFocus: true,
                    
                },
                env: document.getElementById('env_input').value,
                baseurl: document.getElementById('s3_url_input').value,
                is_playing: {
                    mvideo_1: true,
                    mvideo_2: false,
                    mvideo_3: false,
                },
            };
        },
        mounted() {
            const targetElement = this.$el;
        },
        methods: {
            reInit() {
                this.$nextTick(() => {
                    this.$refs.slick.reSlick();
                });
            },
            videoFnc: function(e) {
                
                    let currentVideo = e.currentTarget,
                        currentVideoId = currentVideo.getAttribute('id');

                    if (this.is_playing[currentVideoId] == false) { 
                        currentVideo.play();
                        this.is_playing[currentVideoId] = true;
                    } else {
                        currentVideo.pause();
                        this.is_playing[currentVideoId] = false;

                    }
            
            },
            handleAfterChange(event, slick, currentSlide) {

                var vIndex = currentSlide + 1;
                var video = document.getElementById("mvideo_" + vIndex);

                if(video) {
                    var playPromise = video.play();
                    this.is_playing['mvideo_' + vIndex] = true;

                    if (playPromise !== undefined) {
                        playPromise.then(_ => {
                        })
                        .catch(error => {
                            video.pause();
                            throw error;
                        });
                    } else {
                        console.log('playPromise undefined');
                    }
                    
                } else {
                    console.log('playPromise undefined or none video');
                }
                
            },

            handleBeforeChange(event, slick, currentSlide, nextSlide) {
                var vBeforeIndex = currentSlide + 1,
                    videoBefore = document.getElementById("mvideo_" + vBeforeIndex);
                
                var playPromise = videoBefore.pause();
                this.is_playing['mvideo_' + vBeforeIndex] = false;
            },
            handleSwipe(event, slick, direction) {

                let vIndex = slick.currentSlide + 1,
                    currentVideo = document.getElementById("mvideo_" + vIndex);

                if(direction == 'left') {
                    if(vIndex == 1) {
                        var beforeVideoIndex = 3;
                    } else {
                        var beforeVideoIndex = vIndex - 1;
                    }

                    var  beforeVideo = document.getElementById("mvideo_" + beforeVideoIndex);

                    beforeVideo.pause();
                    this.is_playing['mvideo_' + beforeVideoIndex] = false;

                } else {
                    if(vIndex == 3) {
                        var beforeVideoIndex = 1;
                    } else {
                        var beforeVideoIndex = vIndex + 1;
                       
                    }

                    var  beforeVideo = document.getElementById("mvideo_" + beforeVideoIndex);

                    beforeVideo.pause();

                    this.is_playing['mvideo_' + beforeVideoIndex] = false;

                }
            },
            
        },

    }
</script>