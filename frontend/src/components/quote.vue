<template>
    <div class="panel panel-default">
        <div class="panel-body">
            {{qt.content}}
        </div>
        <div class="panel-footer">
            <div v-if="editing">
                <input type="text" v-model="editValue">
                <a  @click="onUpdate">Save</a>
                <a  @click="onCancel">Cancel</a>
            </div>
            <div v-if="!editing">
                <a  @click="onEdit">Edit</a>
                <a  @click="onDelete">Delete</a>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios'
    export default{
        props:['qt'],
        data(){
            return{
               editing:false,
                editValue:this.qt.content
            }
        },
        methods:{
            onEdit(){
                this.editing=true;
                this.editValue=this.qt.content;
            },
            onCancel(){
                this.editing=false;
            },
            onDelete(){
                const token=localStorage.getItem('token');
                this.$emit('quoteDeleted',this.qt.id);
                axios.delete('http://teen.md/quote/'+ this.qt.id+'?token='+token,{
                    headers:{
                        'X-Requested-With':'XMLHttpRequest'
                    }
                }).then((response)=>{
                    console.log(response);
                }).catch((error)=>{
                    console.log(error);
                })
            },
            onUpdate(){
                this.editing=false;
                this.qt.content=this.editValue;
                const token=localStorage.getItem('token');
                axios.put('http://teen.md/quote/'+this.qt.id+'?token='+token,{content:this.editValue},{
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

<style sccoped>
    a{
      cursor: pointer;
    }
</style>