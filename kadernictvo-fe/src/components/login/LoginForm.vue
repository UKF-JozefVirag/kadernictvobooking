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
            <v-row class="text-center" v-if="loading">
                <v-col align-self="center">
                    <img width="40" src="@/assets/images/loader.svg" alt="...">
                </v-col>
            </v-row>
            <v-row class="justify-center">
                <v-col cols="12">
                    <input type="text" class="form-control" placeholder="Email" v-model="formData.email">
                </v-col>
                <v-col cols="12">
                    <input type="password" class="form-control" placeholder="Password" v-model="formData.password">
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
                    <v-btn type="submit" :ripple="false" plain class="w-100 submit-button" form="loginform" @click="login">Sign in</v-btn>
                </v-col>
            </v-row>
<!--            <v-row class="text-center">-->
<!--                <v-col align-self="center">-->
<!--                    <a href="#" class="text-center text-decoration-underline forgot-pwd">Forgot password ?</a>-->
<!--                </v-col>-->
<!--            </v-row>-->
        </v-container>
    </v-form>
    <SnackComponent :color="color" :snack-open="snackOpen" :text="snackText"></SnackComponent>
</template>

<script>
import axios from 'axios';
import SnackComponent from "@/components/common/SnackComponent.vue";
import axiosInstance from '@/axios.js'

axios.defaults.withXSRFToken = true;

export default {
    name: "LoginForm",
    components: { SnackComponent },
    data() {
        return {
            formData: {
                email: '',
                password: '',
            },
            color: '',
            snackText: '',
            snackOpen: false,
            errors: {},
            loading: false
        };
    },
    methods: {
        async login() {
            this.snackOpen = false;
            this.loading = true;
            try {
                await axios.get("http://localhost:8000/sanctum/csrf-cookie");
                const response = await axiosInstance.post(
                    '/login',
                    this.formData,
                    {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }
                );
                this.snackOpen = true;
                this.color = "success";
                this.snackText = this.$t('login.success');
                const token = response.data.token;
                this.$cookies.set('token', encodeURIComponent(token), '1d');
                this.$router.push('/dashboard');
            } catch (e) {
                this.color = "danger";
                this.snackOpen = true;
                if (e.response && e.response.data && e.response.data.message) {
                    this.snackText = e.response.data.message;
                } else {
                    this.snackText = this.$t('login.error')
                }
            } finally {
                this.loading = false;
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
