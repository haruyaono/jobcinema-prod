<template>
    <slick
    ref="slick"
    :options="slickOptions">
        <img v-if="env == 'local'" v-bind:src="jobjson.job_img">
        <img v-else v-bind:src="baseurl + jobjson.job_img">
        <img v-if="env == 'local'" v-bind:src="jobjson.job_img2">
        <img v-else v-bind:src="baseurl + jobjson.job_img2">
        <img v-if="env == 'local'" v-bind:src="jobjson.job_img3">
        <img v-else v-bind:src="baseurl + jobjson.job_img3">
    </slick>
</template>
 
<script>
Vue.config.devtools = true;
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
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 0,
                    cssEase: 'linear',
                    speed: 5000,
                    infinite: true,
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    responsive: [
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1,
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        },
                    ]
                },
                env: document.getElementById('env_input').value,
                baseurl: document.getElementById('s3_url_input').value,
               
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