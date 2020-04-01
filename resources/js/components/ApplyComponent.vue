<template>
    <div class="entrybtn-item">
       <form @submit="formSubmit">
           
           <button v-if="show" class="entry-btn apply-btn" type="submit">応募する</button>
           <div v-else class="alert alert-success">
               応募が正常に完了しました！
           </div>
       </form>
    </div>
</template>

<script>
    export default {
        props:["jobid"],
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return {
                'show': true
            }
        },
        methods:{
            formSubmit(e){
                e.preventDefault();
                axios.post('/applications/' + this.jobid,{

                }).then((response)=>{
                    this.show=false
                });
            }
        }
    }
</script>
