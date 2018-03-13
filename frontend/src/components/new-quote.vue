<template>
    <form class="form-group" @submit.prevent="onSubmitted">
        <label class="content">Content</label>
        <input type="text"
               id="content"
               class="form-control"
        v-model="quoteContent">
        <button class="btn btn-primary" type="submit">
            Submit
        </button>
    </form>
</template>

<script>
    import axios from 'axios';

    export default{
        data(){
            return{
                quoteContent:''
            }
        },
        methods:{
            onSubmitted(){
                const token=localStorage.getItem('token');
                axios.post('http://teen.md/api/quote?token='+token,
                    {content:this.quoteContent},{
                    headers:{
                        'X-Requested-With':'XMLHttpRequest'
                    }
                    }).then((response)=>{
                    console.log(response);
                }).catch((error)=>{
                    console.log(error);
                })
            }
        }
    }
</script>