<template>
    <slick
    ref="slick"
    :options="slickOptions">
       <video class="slide-video slide-media" autoplay loop  muted preload="metadata" poster="/uploads/images/no-image.gif">
            <source v-bind:src="jobjson.job_mov" type="video/mp4" />
        </video>
        <video class="slide-video slide-media" autoplay loop  muted preload="metadata" poster="/uploads/images/no-image.gif">
            <source v-bind:src="jobjson.job_mov2" type="video/mp4" />
        </video>
        <video class="slide-video slide-media" autoplay loop  muted preload="metadata" poster="/uploads/images/no-image.gif">
            <source v-bind:src="jobjson.job_mov3" type="video/mp4" />
        </video>
    </slick>
</template>
 
<script>
    // vue-slickをインポート
    import Slick from 'vue-slick';
    export default {
        // bladeから受け取るデータを指定
        props: {
            jobjson: {
                type: Object,
                required: true
            }
        },
        // コンポーネント使用の宣言
        components: { Slick },
        data() {
            return {
                // slickの設定
                slickOptions: {
                    autoplay: true,
                    fade:true,
                    autoplaySpeed:6000,
                    speed:600,
                    arrows:false,
                    dots:true,
                    cssEase:"cubic-bezier(0.87, 0.03, 0.41, 0.9)",
                    accessibility	: true,
                    pauseOnFocus: true,
                    
                },
            };
        },
        methods: {
            next() {
                this.$refs.slick.next();
            },
            prev() {
                this.$refs.slick.prev();
            },
            reInit() {
                this.$nextTick(() => {
                    this.$refs.slick.reSlick();
                });
            },
        },
    }
</script>