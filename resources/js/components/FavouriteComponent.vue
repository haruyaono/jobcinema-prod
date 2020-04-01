<template>
    <div class="entrybtn-item"> 
           <button v-if="show" @click.prevent="unsave()" class="entry-btn favourite-btn" type="submit">お気に入りリストから削除</button>
           <button v-else @click.prevent="save()" class="entry-btn favourite-btn" type="submit">お気に入りリストに追加</button>
    </div>
</template>

<script>
    export default {
        props:['jobid', 'favourited'],

        data(){
            return {
                show: true
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
                axios.post('/save/' +this.jobid).then(response=>
                this.show=true).catch(error=>alert('お気に入りに追加できませんでした'))
        
            },
            unsave(){
                axios.post('/unsave/' +this.jobid).catch(error=>alert('お気に入りから削除できませんでした'))
            }
        }
    }
</script>
