<template>
    <div>
        <div class="login">
            <div class="alert alert-danger" role="alert" v-if="error">
                {{error}}
            </div>
            <form @submit.prevent="login">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                           placeholder="Enter email" v-model="email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.
                    </small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" v-model="password">
                </div>
                <button type="submit" class="btn btn-primary" :disabled="blockSubmit">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
    import {logIn} from "../Store/utils";

    export default {
        name: 'login',
        data() {
            return {
                error: false,
                blockSubmit: false,
                email: '',
                password: ''
            }
        },
        methods: {
            async login() {
                this.blockSubmit = true;
                await axios.get("/sanctum/csrf-cookie");
                await axios.post("/api/login", {
                    email: this.email,
                    password: this.password
                }).then((data) => {
                    logIn();
                    this.$store.dispatch("loadUser");
                    this.$router.push('/');
                }).catch(error => {
                    this.error = error.response.data.msg;
                    this.blockSubmit = false;
                });
            }
        }
    }
</script>