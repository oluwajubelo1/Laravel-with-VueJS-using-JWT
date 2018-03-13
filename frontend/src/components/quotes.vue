<template>
    <div>
        <button class="btn btn-primary" @click="onGetQuotes">Get Quotes</button>
        <hr>
            <app-quote v-for="quote in quotes"
                       :qt="quote"
                       @quoteDeleted="onQuoteDeleted($event)"></app-quote>
    </div>
</template>

<script>
    import quote from './quote.vue'
    import axios from 'axios'
    export default{
            data(){
              return{
                quotes:[]
              }
            },
        components:{
            appQuote:quote
        },
        methods:{
                onGetQuotes(){
                    axios.get('http://teen.md/api/quote').then((response)=>{
                       this.quotes=response.data.quotes;
                    }).catch((error)=>{
                        console.log(error);
                    })
                },
            onQuoteDeleted(id){
                const position=this.quotes.findIndex((element)=>{
                    return element.id=id;
                });
                this.quotes.splice(position,1);
            }
        }
    }
</script>