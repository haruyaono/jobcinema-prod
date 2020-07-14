<template>
    <slick
    ref="slick"
    :options="slickOptions">
        <a href="/beginners">
            <img src="/uploads/images/jobcinema_hedd_sam4_aのコピー.png" alt="JOBCiNEMAとは">
        </a>
        <a href="/lp" target="_blank">
            <img src="/uploads/images/jobcinema_hedd_sam5_aのコピー.png" alt="広告掲載企業募集について">
        </a>
        <a href="/published-contact">
            <img src="/uploads/images/jobcinema_hedd_sam6_aのコピー.png" alt="お祝い金申請について">
        </a>
    </slick>
</template>
 
<script>
    // vue-slickをインポート
    import Slick from 'vue-slick';
    export default {
        // コンポーネント使用の宣言
        name: 'v-slick-top',
        components: { Slick },
        data() {
            return {
                // slickの設定
                slickOptions: {
                    autoplay: true,
                    autoplaySpeed: 3000,
                    speed: 800,
                    dots: false,
                    prevArrow: '<button class="slide-arrow prev-arrow"></button>',
                    nextArrow: '<button class="slide-arrow next-arrow"></button>',
                    centerMode: true,
                    centerPadding: '20%',
                    dotsClass: 'slide-dots',
                    responsive: [
                        {
                            breakpoint: 992,
                            settings: {
                                centerPadding: '10%',
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                               centerPadding: '5%',
                            }
                        },
                    ]
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