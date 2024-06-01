<template>
    <v-form ref="form" lazy-validation @submit.prevent="login" id="loginform">
        <v-container>
            <v-row class="justify-center">
                <v-col cols="12" class="text-center">
                    <v-img src="src/assets/images/logo-light.png" class="logo" width="100px"></v-img>
                </v-col>
            </v-row>
            <v-row class="justify-center">
                <v-col cols="12" class="text-center mb-3">
                    <h3 style="color: #d09c6e">Sign in</h3>
                </v-col>
            </v-row>
            <v-row class="justify-center">
                <v-col cols="12">
                    <input type="text" class="form-control" placeholder="Email" v-model="email">
                </v-col>
                <v-col cols="12">
                    <input type="password" class="form-control" placeholder="Password" v-model="password">
                </v-col>
            </v-row>
            <v-row class="text-left">
                <v-col cols="6">
                    <div class="form-check custom-checkbox">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label text-white" for="flexCheckDefault">Remember me</label>
                    </div>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-btn type="submit" :ripple="false" plain class="w-100 submit-button" form="loginform">Sign in</v-btn>
                </v-col>
            </v-row>
            <v-row class="text-center">
                <v-col align-self="center">
                    <a href="#" class="text-center text-decoration-underline forgot-pwd">Forgot password ?</a>
                </v-col>
            </v-row>
        </v-container>
    </v-form>
</template>

<script>
import axios from 'axios';

export default {
    name: "LoginForm",
    data() {
        return {
            email: '',
            password: ''
        };
    },
    methods: {
        async login() {
            try {
                await axios.get('http://localhost:8080/sanctum/csrf-cookie');
                await axios.post('http://localhost:8080/login', {
                    email: this.email,
                    password: this.password
                });
            } catch (error) {
                console.error('Login failed: ' + error)
            }
        }
    }
};
</script>

<style lang="scss" scoped>
input {
    background-color: white;
}

.logo {
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.custom-checkbox .form-check-input {
    background-color: white;
}

.custom-checkbox .form-check-input:checked {
    background-color: #d09c6e;
    border-color: #d09c6e;
}

.custom-checkbox .form-check-input:focus {
    box-shadow: none;
}

.forgot-pwd {
    transition: 0.3s ease-in-out;
    color: white;
    &:hover {
        color: #d09c6e;
    }
}

.submit-button {
    background-color: white;
    transition: 0.5s ease-in-out;
    color: black;
    &:hover {
        color: #d09c6e;
    }
}
</style>
