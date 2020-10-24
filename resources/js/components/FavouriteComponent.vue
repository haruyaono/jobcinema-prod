<template>
    <div class="entrybtn-item">
           <button v-if="show" @click.prevent="unsave()" class="entry-btn favourite-btn" type="submit" v-bind:disabled="isProcessing()">お気に入りリストから削除</button>
           <button v-else @click.prevent="save()" class="entry-btn favourite-btn" type="submit" v-bind:disabled="isProcessing()">お気に入りリストに追加</button>
    </div>
</template>

<script>
    import Processing from '../mixins/processing'
    export default {

        mixins: [Processing],
        props:['jobid', 'favourited'],

        data(){
            return {
                show: true,
                count: [
                    document.getElementById('saveCount-pc').innerHTML,
                    document.getElementById('saveCount-sp').innerHTML,
                    document.getElementById('hamburgerLogoutClipJobCount').innerHTML,
                ],
                countElm: [
                     document.getElementById('saveCount-pc'),
                    document.getElementById('saveCount-sp'),
                    document.getElementById('hamburgerLogoutClipJobCount'),
                ]
            }
        },
        mounted(){
            this.show = this.jobFavourited ? true:false;
        },

        computed:{
            jobFavourited(){
                return this.favourited
            }
        },
        methods:{
            save(){
                this.startProcessing();

                axios.post('/keeplist/save/' +this.jobid).then(response=>{
                    if(response.data.fav_save_status == 1) {
                        this.show=true;
                        for(let i in this.count) {
                            this.count[i] ++ ;
                        }
                        document.getElementById('saveCount-pc').innerHTML = this.count[0];
                        document.getElementById('saveCount-sp').innerHTML = this.count[1];
                        document.getElementById('hamburgerLogoutClipJobCount').innerHTML = this.count[2];
                        alert('お仕事情報を保存しました。');

                    } else {
                        console.log('アイテムがすでに存在');
                    }

                }).catch(error=>alert('お仕事情報の保存に失敗しました'))
                .finally(() => this.endProcessing())




            },
            unsave(){
                if(confirm('選択した求人情報を削除しますか？')) {
                    this.startProcessing();
                    axios.post('/keeplist/unsave/' +this.jobid).then(response=>{
                        if(response.data.fav_del_status == 1) {
                            this.show=false;
                            if(this.count[0] > 0 && this.count[1] > 0) {
                                for(let i in this.count) {
                                    this.count[i] -- ;
                                };
                                document.getElementById('saveCount-pc').innerHTML = this.count[0];
                                document.getElementById('saveCount-sp').innerHTML = this.count[1];
                                document.getElementById('hamburgerLogoutClipJobCount').innerHTML = this.count[1];
                            }
                            alert('削除しました。');
                        } else {
                            console.log('削除するアイテムなし');
                        }

                    }).catch(error=>alert('お仕事情報の削除に失敗しました'))
                    .finally(() => this.endProcessing())

                } else {
                    return
                }

            },

        }
    }
</script>
