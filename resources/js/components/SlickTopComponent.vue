<template>
    <slick
    ref="slick"
    :options="slickOptions">
        <div v-for="adItem in adItems">
          <a :href="adItem.href">
            <img :src="adItem.src" :alt="adItem.alt">
          </a>
        </div>
    </slick>
</template>

<script>
    // vue-slickをインポート
    import Slick from 'vue-slick';
    export default {
        // コンポーネント使用の宣言
        name: 'v-slick-top',
        components: { Slick },
        props: {
          adItems: {
            type: Object
          }
        },
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