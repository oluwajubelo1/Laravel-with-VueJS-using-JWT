<template>
    <form>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text"
            id="username"
            class="form-control"
            v-model="username">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email"
            id="email"
            class="form-control"
            v-model="email">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password"
            id="password"
            class="form-control"
            v-model="password">
        </div>
        <button type="submit" class="btn btn-primary" @click.prevent="signUp">Sign Up</button>
    </form>
</template>

<script>
    import axios from 'axios';
    export default{
        data(){
            return{
                username:'',
                email:'',
                password
            }
        },
        methods:{
            signUp(){
                const url="http://teen.md/api/user";
                axios.post(url,{
                    name:this.username,
                    email:this.email,
                    password:this.password
                },{
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