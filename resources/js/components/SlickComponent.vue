<template>
    <slick
    ref="slick"
    :options="slickOptions">
        <img v-if="env == 'local'" v-bind:src="jobImageList.img1">
        <img v-else v-bind:src="baseurl + jobImageList.img1">
        <img v-if="env == 'local'" v-bind:src="jobImageList.img2">
        <img v-else v-bind:src="baseurl + jobImageList.img2">
        <img v-if="env == 'local'" v-bind:src="jobImageList.img3">
        <img v-else v-bind:src="baseurl + jobImageList.img3">
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
                    dots:true,
                    speed:200,
                    slidesToScroll: 1,
                    accessibility: true,
                    responsive: [
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
                jobImages: {
                    img1: this.jobjson.job_img,
                    img2: this.jobjson.job_img2,
                    img3: this.jobjson.job_img3
                } 
               
            };
        },
        computed: {
            jobImageList: function() {
                for (var key in this.jobImages) {
                    if(this.jobImages[key] == null) {
                        this.jobImages[key] = '/uploads/images/no-image.gif';
                    }
                }
                return this.jobImages;
            }
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